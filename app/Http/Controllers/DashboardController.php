<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\MemberWallet;
use App\Models\Invoice;
use App\Models\InventoryItem;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');
        $weekStart = $now->copy()->startOfWeek()->format('Y-m-d');
        $weekEnd = $now->copy()->endOfWeek()->format('Y-m-d');
        $monthStart = $now->copy()->startOfMonth()->format('Y-m-d');
        $monthEnd = $now->copy()->endOfMonth()->format('Y-m-d');

        // Optimized query for today's appointments with relationships
        $todayAppointments = Appointment::with(['customer', 'staff', 'room', 'service'])
            ->whereDate('appointment_date', $today)
            ->where('status', '!=', 'cancelled')
            ->orderBy('start_time')
            ->get();

        // Get all active rooms
        $rooms = Room::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($room) use ($todayAppointments, $currentTime, $today) {
                // Find current/upcoming appointments for this room
                $roomAppointments = $todayAppointments->filter(function ($apt) use ($room) {
                    return $apt->room_id == $room->id;
                });

                // Check if room is currently booked
                $currentlyBooked = $roomAppointments->filter(function ($apt) use ($currentTime, $today) {
                    return $apt->appointment_date == $today &&
                        $apt->start_time <= $currentTime &&
                        $apt->end_time >= $currentTime;
                })->first();

                // Get next appointment
                $nextAppointment = $roomAppointments->filter(function ($apt) use ($currentTime, $today) {
                    return $apt->appointment_date == $today && $apt->start_time > $currentTime;
                })->first();

                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'is_booked' => $currentlyBooked ? true : false,
                    'current_appointment' => $currentlyBooked ? [
                        'id' => $currentlyBooked->id,
                        'customer' => $currentlyBooked->customer->name ?? 'N/A',
                        'service' => $currentlyBooked->service->name ?? 'N/A',
                        'start_time' => $currentlyBooked->start_time,
                        'end_time' => $currentlyBooked->end_time,
                        'staff' => $currentlyBooked->staff->name ?? 'N/A',
                    ] : null,
                    'next_appointment' => $nextAppointment ? [
                        'id' => $nextAppointment->id,
                        'customer' => $nextAppointment->customer->name ?? 'N/A',
                        'service' => $nextAppointment->service->name ?? 'N/A',
                        'start_time' => $nextAppointment->start_time,
                        'end_time' => $nextAppointment->end_time,
                        'staff' => $nextAppointment->staff->name ?? 'N/A',
                    ] : null,
                    'total_bookings_today' => $roomAppointments->count(),
                ];
            });

        // Get all active staff
        $staff = Staff::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($staffMember) use ($todayAppointments, $currentTime, $today) {
                // Find current/upcoming appointments for this staff
                $staffAppointments = $todayAppointments->filter(function ($apt) use ($staffMember) {
                    return $apt->staff_id == $staffMember->id;
                });

                // Check if staff is currently busy
                $currentlyBusy = $staffAppointments->filter(function ($apt) use ($currentTime, $today) {
                    return $apt->appointment_date == $today &&
                        $apt->start_time <= $currentTime &&
                        $apt->end_time >= $currentTime;
                })->first();

                // Get next appointment
                $nextAppointment = $staffAppointments->filter(function ($apt) use ($currentTime, $today) {
                    return $apt->appointment_date == $today && $apt->start_time > $currentTime;
                })->first();

                return [
                    'id' => $staffMember->id,
                    'name' => $staffMember->name,
                    'is_busy' => $currentlyBusy ? true : false,
                    'current_appointment' => $currentlyBusy ? [
                        'id' => $currentlyBusy->id,
                        'customer' => $currentlyBusy->customer->name ?? 'N/A',
                        'service' => $currentlyBusy->service->name ?? 'N/A',
                        'start_time' => $currentlyBusy->start_time,
                        'end_time' => $currentlyBusy->end_time,
                        'room' => $currentlyBusy->room->name ?? 'N/A',
                        'duration' => $currentlyBusy->duration ?? 'N/A',
                    ] : null,
                    'next_appointment' => $nextAppointment ? [
                        'id' => $nextAppointment->id,
                        'customer' => $nextAppointment->customer->name ?? 'N/A',
                        'service' => $nextAppointment->service->name ?? 'N/A',
                        'start_time' => $nextAppointment->start_time,
                        'end_time' => $nextAppointment->end_time,
                        'room' => $nextAppointment->room->name ?? 'N/A',
                    ] : null,
                    'total_appointments_today' => $staffAppointments->count(),
                ];
            });

        // Comprehensive Statistics
        $stats = [
            // Appointments
            'today_appointments' => Appointment::whereDate('appointment_date', $today)
                ->where('status', '!=', 'cancelled')->count(),
            'week_appointments' => Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])
                ->where('status', '!=', 'cancelled')->count(),
            'month_appointments' => Appointment::whereBetween('appointment_date', [$monthStart, $monthEnd])
                ->where('status', '!=', 'cancelled')->count(),

            // Customers
            'total_member_customers' => Customer::where('customer_type', 'member')->count(),
            'total_wallet_balance' => MemberWallet::sum('balance'),

            // Invoices
            'total_invoices' => Invoice::count(),
            'total_paid_amount' => Invoice::where('payable_amount', '<=', 0)->sum('total_amount'),
            'total_unpaid_amount' => Invoice::where('payable_amount', '>', 0)->sum('payable_amount'),

            // Inventory
            'total_inventory_count' => InventoryItem::count(),

            // Offers
            'total_active_offers' => Offer::where('is_active', true)->count(),

            // Rooms & Staff
            'total_rooms' => Room::where('is_active', true)->count(),
            'booked_rooms' => $rooms->where('is_booked', true)->count(),
            'available_rooms' => $rooms->where('is_booked', false)->count(),
            'total_staff' => Staff::where('is_active', true)->count(),
            'busy_staff' => $staff->where('is_busy', true)->count(),
            'available_staff' => $staff->where('is_busy', false)->count(),
        ];

        // Chart data for appointments (last 7 days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i)->format('Y-m-d');
            $chartData['dates'][] = $now->copy()->subDays($i)->format('d M');
            $chartData['appointments'][] = Appointment::whereDate('appointment_date', $date)
                ->where('status', '!=', 'cancelled')->count();
            $chartData['revenue'][] = Appointment::whereDate('appointment_date', $date)
                ->where('status', 'completed')
                ->where('payment_status', 'paid')
                ->sum('amount');
        }

        return view('module.dashboard.dashboard', compact('rooms', 'staff', 'stats', 'today', 'chartData'));
    }
}

