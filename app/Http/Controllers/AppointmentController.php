<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Room;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'staff', 'room', 'service']);

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

        $appointments = $query->latest()->paginate(10);

        $todayCount = Appointment::whereDate('appointment_date', today())->count();
        $weekCount = Appointment::whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthCount = Appointment::whereMonth('appointment_date', now()->month)
                  ->whereYear('appointment_date', now()->year)->count();

        $customers = Customer::all();
        $services = Service::all();
        $rooms = Room::all();
        $staff = Staff::all();

        return view('module.appointments.index', compact('appointments', 'todayCount', 'weekCount', 'monthCount', 'customers', 'services', 'rooms', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'phone' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'room_id' => 'required|exists:rooms,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'nullable|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|string',
            'is_member' => 'boolean',
            'sleep' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['status'] = 'created';

        Appointment::create($data);

        return redirect()->back()->with('success', 'Appointment created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'phone' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'room_id' => 'required|exists:rooms,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'nullable|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|string',
            'is_member' => 'boolean',
            'sleep' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();

        $appointment->update($data);

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully.');
    }
}
