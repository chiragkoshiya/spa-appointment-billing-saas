<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource with advanced filters
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'staff', 'room', 'service', 'services.service', 'invoice', 'offer']);

        // Advanced Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        if ($request->filled('filter')) {
            if ($request->filter == 'today') {
                $query->whereDate('appointment_date', today());
            } elseif ($request->filter == 'week') {
                $query->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $query->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year);
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'appointment_date');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['appointment_date', 'created_at', 'amount', 'status'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest('appointment_date');
        }

        $appointments = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'today' => Appointment::whereDate('appointment_date', today())->count(),
            'week' => Appointment::whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month' => Appointment::whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)->count(),
            'total' => Appointment::count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'pending' => Appointment::where('status', 'created')->count(),
            'today_revenue' => Appointment::whereDate('appointment_date', today())
                ->where('status', 'completed')->sum('amount'),
            'month_revenue' => Appointment::whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)
                ->where('status', 'completed')->sum('amount'),
            // Room Statistics
            'total_rooms' => Room::count(),
            'active_rooms' => Room::where('is_active', true)->count(),
            'inactive_rooms' => Room::where('is_active', false)->count(),
        ];

        $customers = Customer::with('wallet')->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $offers = Offer::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('name')->get();

        return view('module.appointments.index', compact('appointments', 'stats', 'customers', 'services', 'rooms', 'staff', 'offers'));
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required_if:customer_id,|string|max:255',
            'customer_email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'room_id' => 'required|exists:rooms,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'duration' => 'nullable|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid',
            'is_member' => 'nullable|boolean',
            'offer_id' => 'nullable|exists:offers,id',
            'sleep' => 'nullable|string|max:255',
        ]);

        // Check for conflicts
        $conflicts = $this->checkConflicts($request->staff_id, $request->room_id, $request->appointment_date, $request->start_time, $request->end_time);

        if (!empty($conflicts)) {
            return redirect()->back()->withErrors(['conflict' => 'Conflict detected: ' . implode(', ', $conflicts)])->withInput();
        }

        DB::beginTransaction();
        try {
            $customerId = $request->customer_id;

            // Auto-create customer if not selected
            if (!$customerId) {
                $customer = Customer::where('email', $request->customer_email)
                    ->orWhere('phone', $request->phone)
                    ->first();

                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->phone,
                        'customer_type' => $request->is_member ? 'member' : 'normal',
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);

                    // Create wallet for member customers
                    if ($customer->customer_type == 'member' && !$customer->wallet) {
                        \App\Models\MemberWallet::create([
                            'customer_id' => $customer->id,
                            'balance' => 0,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
                $customerId = $customer->id;
            }

            // Get service price
            $service = Service::findOrFail($request->service_id);
            $amount = $request->amount ?? $service->price;

            // Create appointment
            $appointment = Appointment::create([
                'customer_id' => $customerId,
                'phone' => $request->phone,
                'service_id' => $request->service_id,
                'staff_id' => $request->staff_id,
                'room_id' => $request->room_id,
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration' => $request->duration ?? $service->duration_minutes,
                'is_member' => $request->is_member ?? false,
                'payment_method' => $request->payment_method,
                'amount' => $amount,
                'offer_id' => $request->offer_id,
                'payment_status' => $request->payment_status,
                'sleep' => $request->sleep,
                'status' => 'created',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Create appointment service record
            AppointmentService::create([
                'appointment_id' => $appointment->id,
                'service_id' => $request->service_id,
                'price' => $amount,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Appointment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating appointment: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Check if invoice exists
        if ($appointment->invoice) {
            return redirect()->back()->with('error', 'Cannot edit appointment after invoice is generated.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'room_id' => 'required|exists:rooms,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'duration' => 'nullable|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid',
            'is_member' => 'nullable|boolean',
            'offer_id' => 'nullable|exists:offers,id',
            'sleep' => 'nullable|string|max:255',
        ]);

        // Check for conflicts (excluding current appointment)
        $conflicts = $this->checkConflicts(
            $request->staff_id,
            $request->room_id,
            $request->appointment_date,
            $request->start_time,
            $request->end_time,
            $appointment->id
        );

        if (!empty($conflicts)) {
            return redirect()->back()->withErrors(['conflict' => 'Conflict detected: ' . implode(', ', $conflicts)])->withInput();
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['updated_by'] = Auth::id();

            // Don't allow status change via update (use separate method)
            unset($data['status']);

            $appointment->update($data);

            // Update appointment service if service changed
            if ($appointment->service_id != $request->service_id) {
                $appointment->services()->delete();
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $request->service_id,
                    'price' => $request->amount,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Appointment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating appointment: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:created,completed',
        ]);

        if ($appointment->status === 'completed' && $request->status === 'created') {
            return redirect()->back()->with('error', 'Cannot revert completed appointment to created status.');
        }

        $appointment->update([
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        $message = $request->status === 'completed'
            ? 'Appointment marked as completed. Invoice generated automatically.'
            : 'Appointment status updated.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Appointment $appointment)
    {
        try {
            if ($appointment->invoice) {
                return redirect()->back()->with('error', 'Cannot delete appointment with existing invoice. Please delete invoice first.');
            }

            $id = $appointment->id;
            $appointment->delete();
            return redirect()->back()->with('success', 'Appointment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting appointment: ' . $e->getMessage());
        }
    }

    /**
     * Check for staff and room availability conflicts
     */
    private function checkConflicts($staffId, $roomId, $date, $startTime, $endTime, $excludeAppointmentId = null)
    {
        $conflicts = [];

        // Check staff availability
        $staffConflict = Appointment::where('staff_id', $staffId)
            ->where('appointment_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->where('status', '!=', 'cancelled');

        if ($excludeAppointmentId) {
            $staffConflict->where('id', '!=', $excludeAppointmentId);
        }

        if ($staffConflict->exists()) {
            $staff = Staff::find($staffId);
            $conflicts[] = "Staff '{$staff->name}' is already booked at this time";
        }

        // Check room availability
        $roomConflict = Appointment::where('room_id', $roomId)
            ->where('appointment_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->where('status', '!=', 'cancelled');

        if ($excludeAppointmentId) {
            $roomConflict->where('id', '!=', $excludeAppointmentId);
        }

        if ($roomConflict->exists()) {
            $room = Room::find($roomId);
            $conflicts[] = "Room '{$room->name}' is already booked at this time";
        }

        return $conflicts;
    }

    /**
     * Get availability for staff/room on a specific date and time
     */
    public function getAvailability(Request $request)
    {
        try {
            $date = $request->get('date');
            $startTime = $request->get('start_time');
            $endTime = $request->get('end_time');
            $staffId = $request->get('staff_id');
            $roomId = $request->get('room_id');
            $excludeAppointmentId = $request->get('exclude_appointment_id');

            $bookedSlots = [];
            $availableRooms = [];
            $unavailableRooms = [];

            // Get all active rooms
            $allRooms = Room::where('is_active', true)->get();

            // Check room availability if date and time are provided
            if ($date && $startTime && $endTime) {
                foreach ($allRooms as $room) {
                    $isAvailable = !Appointment::where('room_id', $room->id)
                        ->where('appointment_date', $date)
                        ->where(function ($query) use ($startTime, $endTime) {
                            // Check if new appointment overlaps with existing appointments
                            $query->where(function ($q) use ($startTime, $endTime) {
                                // New start time is between existing appointment
                                $q->where('start_time', '<=', $startTime)
                                    ->where('end_time', '>', $startTime);
                            })->orWhere(function ($q) use ($startTime, $endTime) {
                                // New end time is between existing appointment
                                $q->where('start_time', '<', $endTime)
                                    ->where('end_time', '>=', $endTime);
                            })->orWhere(function ($q) use ($startTime, $endTime) {
                                // New appointment completely contains existing appointment
                                $q->where('start_time', '>=', $startTime)
                                    ->where('end_time', '<=', $endTime);
                            })->orWhere(function ($q) use ($startTime, $endTime) {
                                // Existing appointment completely contains new appointment
                                $q->where('start_time', '<=', $startTime)
                                    ->where('end_time', '>=', $endTime);
                            });
                        })
                        ->where('status', '!=', 'cancelled')
                        ->when($excludeAppointmentId, function ($q) use ($excludeAppointmentId) {
                            $q->where('id', '!=', $excludeAppointmentId);
                        })
                        ->exists();

                    if ($isAvailable) {
                        $availableRooms[] = [
                            'id' => $room->id,
                            'name' => $room->name,
                        ];
                    } else {
                        // Get conflicting appointment details
                        $conflict = Appointment::where('room_id', $room->id)
                            ->where('appointment_date', $date)
                            ->where(function ($query) use ($startTime, $endTime) {
                                // Check if new appointment overlaps with existing appointments
                                $query->where(function ($q) use ($startTime, $endTime) {
                                    $q->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>', $startTime);
                                })->orWhere(function ($q) use ($startTime, $endTime) {
                                    $q->where('start_time', '<', $endTime)
                                        ->where('end_time', '>=', $endTime);
                                })->orWhere(function ($q) use ($startTime, $endTime) {
                                    $q->where('start_time', '>=', $startTime)
                                        ->where('end_time', '<=', $endTime);
                                })->orWhere(function ($q) use ($startTime, $endTime) {
                                    $q->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>=', $endTime);
                                });
                            })
                            ->where('status', '!=', 'cancelled')
                            ->when($excludeAppointmentId, function ($q) use ($excludeAppointmentId) {
                                $q->where('id', '!=', $excludeAppointmentId);
                            })
                            ->first();

                        $unavailableRooms[] = [
                            'id' => $room->id,
                            'name' => $room->name,
                            'conflict_time' => $conflict ? ($conflict->start_time . ' - ' . $conflict->end_time) : null,
                        ];
                    }
                }
            }

            // Staff bookings
            if ($staffId && $date) {
                $staffBookings = Appointment::where('staff_id', $staffId)
                    ->where('appointment_date', $date)
                    ->where('status', '!=', 'cancelled')
                    ->when($excludeAppointmentId, function ($q) use ($excludeAppointmentId) {
                        $q->where('id', '!=', $excludeAppointmentId);
                    })
                    ->get(['start_time', 'end_time']);

                foreach ($staffBookings as $booking) {
                    $bookedSlots[] = [
                        'type' => 'staff',
                        'start' => $booking->start_time,
                        'end' => $booking->end_time,
                    ];
                }
            }

            // Room bookings
            if ($roomId && $date) {
                $roomBookings = Appointment::where('room_id', $roomId)
                    ->where('appointment_date', $date)
                    ->where('status', '!=', 'cancelled')
                    ->when($excludeAppointmentId, function ($q) use ($excludeAppointmentId) {
                        $q->where('id', '!=', $excludeAppointmentId);
                    })
                    ->get(['start_time', 'end_time']);

                foreach ($roomBookings as $booking) {
                    $bookedSlots[] = [
                        'type' => 'room',
                        'start' => $booking->start_time,
                        'end' => $booking->end_time,
                    ];
                }
            }

            return response()->json([
                'booked_slots' => $bookedSlots,
                'available_rooms' => $availableRooms,
                'unavailable_rooms' => $unavailableRooms,
                'total_rooms' => $allRooms->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Availability check error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'error' => 'Error checking availability',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while checking availability',
                'booked_slots' => [],
                'available_rooms' => [],
                'unavailable_rooms' => [],
                'total_rooms' => 0,
            ], 500);
        }
    }
}
