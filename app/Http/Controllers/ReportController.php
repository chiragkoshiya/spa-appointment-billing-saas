<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $todayRevenue = Appointment::whereDate('appointment_date', today())->sum('amount');
        $thisMonthRevenue = Appointment::whereMonth('appointment_date', now()->month)
                                     ->whereYear('appointment_date', now()->year)
                                     ->sum('amount');
                                     
        $recentAppointments = Appointment::with(['customer', 'service'])->latest()->take(5)->get();

        return view('module.reports.index', compact('todayRevenue', 'thisMonthRevenue', 'recentAppointments'));
    }
}
