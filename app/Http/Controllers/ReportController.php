<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use App\Models\InventoryItem;
use App\Models\MemberWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Display reports dashboard with filters
     */
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'revenue');
        $period = $request->get('period', 'this_month');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Get date range based on period
        $dateRange = $this->getDateRange($period, $dateFrom, $dateTo);
        
        $data = [];
        $summary = [];

        switch ($reportType) {
            case 'revenue':
                $data = $this->getRevenueReport($dateRange);
                $summary = $this->getRevenueSummary($dateRange);
                break;
            case 'appointments':
                $data = $this->getAppointmentsReport($dateRange, $request);
                $summary = $this->getAppointmentsSummary($dateRange);
                break;
            case 'customers':
                $data = $this->getCustomersReport($dateRange, $request);
                $summary = $this->getCustomersSummary($dateRange);
                break;
            case 'services':
                $data = $this->getServicesReport($dateRange);
                $summary = $this->getServicesSummary($dateRange);
                break;
            case 'staff':
                $data = $this->getStaffReport($dateRange);
                $summary = $this->getStaffSummary($dateRange);
                break;
            case 'inventory':
                $data = $this->getInventoryReport();
                $summary = $this->getInventorySummary();
                break;
            default:
                $data = $this->getRevenueReport($dateRange);
                $summary = $this->getRevenueSummary($dateRange);
        }

        return view('module.reports.index', compact('data', 'summary', 'reportType', 'period', 'dateFrom', 'dateTo'));
    }

    /**
     * Download report
     */
    public function download(Request $request)
    {
        $reportType = $request->get('report_type', 'revenue');
        $period = $request->get('period', 'this_month');
        $format = $request->get('format', 'pdf');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $dateRange = $this->getDateRange($period, $dateFrom, $dateTo);
        
        $data = [];
        $summary = [];

        switch ($reportType) {
            case 'revenue':
                $data = $this->getRevenueReport($dateRange);
                $summary = $this->getRevenueSummary($dateRange);
                break;
            case 'appointments':
                $data = $this->getAppointmentsReport($dateRange, $request);
                $summary = $this->getAppointmentsSummary($dateRange);
                break;
            case 'customers':
                $data = $this->getCustomersReport($dateRange, $request);
                $summary = $this->getCustomersSummary($dateRange);
                break;
            case 'services':
                $data = $this->getServicesReport($dateRange);
                $summary = $this->getServicesSummary($dateRange);
                break;
            case 'staff':
                $data = $this->getStaffReport($dateRange);
                $summary = $this->getStaffSummary($dateRange);
                break;
            case 'inventory':
                $data = $this->getInventoryReport();
                $summary = $this->getInventorySummary();
                break;
        }

        $fileName = $this->generateFileName($reportType, $period, $format);

        if ($format === 'csv' || $format === 'excel') {
            return $this->downloadCsv($data, $summary, $reportType, $fileName);
        } else {
            return view('module.reports.pdf', compact('data', 'summary', 'reportType', 'period', 'dateRange'));
        }
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period, $dateFrom = null, $dateTo = null)
    {
        if ($period === 'custom' && $dateFrom && $dateTo) {
            return [
                'from' => $dateFrom,
                'to' => $dateTo,
                'label' => date('d M, Y', strtotime($dateFrom)) . ' - ' . date('d M, Y', strtotime($dateTo))
            ];
        }

        $now = now();
        
        switch ($period) {
            case 'today':
                return [
                    'from' => $now->format('Y-m-d'),
                    'to' => $now->format('Y-m-d'),
                    'label' => 'Today'
                ];
            case 'yesterday':
                $yesterday = $now->copy()->subDay();
                return [
                    'from' => $yesterday->format('Y-m-d'),
                    'to' => $yesterday->format('Y-m-d'),
                    'label' => 'Yesterday'
                ];
            case 'this_week':
                $startOfWeek = $now->copy()->startOfWeek();
                $endOfWeek = $now->copy()->endOfWeek();
                return [
                    'from' => $startOfWeek->format('Y-m-d'),
                    'to' => $endOfWeek->format('Y-m-d'),
                    'label' => 'This Week'
                ];
            case 'last_week':
                $lastWeek = $now->copy()->subWeek();
                return [
                    'from' => $lastWeek->startOfWeek()->format('Y-m-d'),
                    'to' => $lastWeek->endOfWeek()->format('Y-m-d'),
                    'label' => 'Last Week'
                ];
            case 'this_month':
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();
                return [
                    'from' => $startOfMonth->format('Y-m-d'),
                    'to' => $endOfMonth->format('Y-m-d'),
                    'label' => 'This Month (' . $now->format('M Y') . ')'
                ];
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return [
                    'from' => $lastMonth->startOfMonth()->format('Y-m-d'),
                    'to' => $lastMonth->endOfMonth()->format('Y-m-d'),
                    'label' => 'Last Month (' . $lastMonth->format('M Y') . ')'
                ];
            case 'this_year':
                $startOfYear = $now->copy()->startOfYear();
                $endOfYear = $now->copy()->endOfYear();
                return [
                    'from' => $startOfYear->format('Y-m-d'),
                    'to' => $endOfYear->format('Y-m-d'),
                    'label' => 'This Year (' . $now->year . ')'
                ];
            case 'last_year':
                $lastYear = $now->copy()->subYear();
                return [
                    'from' => $lastYear->startOfYear()->format('Y-m-d'),
                    'to' => $lastYear->endOfYear()->format('Y-m-d'),
                    'label' => 'Last Year (' . $lastYear->year . ')'
                ];
            default:
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();
                return [
                    'from' => $startOfMonth->format('Y-m-d'),
                    'to' => $endOfMonth->format('Y-m-d'),
                    'label' => 'This Month'
                ];
        }
    }

    /**
     * Revenue Report
     */
    private function getRevenueReport($dateRange)
    {
        $invoices = Invoice::whereBetween(DB::raw('DATE(created_at)'), [$dateRange['from'], $dateRange['to']])
            ->with(['customer', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Daily revenue breakdown
        $dailyRevenue = Invoice::whereBetween(DB::raw('DATE(created_at)'), [$dateRange['from'], $dateRange['to']])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('SUM(wallet_deduction) as wallet'),
                DB::raw('SUM(payable_amount) as payable'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return [
            'invoices' => $invoices,
            'daily' => $dailyRevenue
        ];
    }

    private function getRevenueSummary($dateRange)
    {
        $invoices = Invoice::whereBetween(DB::raw('DATE(created_at)'), [$dateRange['from'], $dateRange['to']]);
        
        return [
            'total_invoices' => $invoices->count(),
            'total_revenue' => $invoices->sum('total_amount'),
            'wallet_deduction' => $invoices->sum('wallet_deduction'),
            'total_paid' => $invoices->where('payable_amount', '<=', 0)->sum('total_amount'),
            'pending_amount' => $invoices->sum('payable_amount'),
            'cash_payments' => $invoices->where('payment_mode', 'cash')->sum('total_amount'),
            'online_payments' => $invoices->where('payment_mode', 'online')->sum('total_amount'),
        ];
    }

    /**
     * Appointments Report
     */
    private function getAppointmentsReport($dateRange, $request)
    {
        $query = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']])
            ->with(['customer', 'staff', 'room', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        return [
            'appointments' => $query->orderBy('appointment_date', 'desc')->get(),
            'by_status' => Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']])
                ->select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')
                ->get(),
            'by_staff' => Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']])
                ->join('staff', 'appointments.staff_id', '=', 'staff.id')
                ->select('staff.name', DB::raw('COUNT(*) as count'))
                ->groupBy('staff.name')
                ->get(),
        ];
    }

    private function getAppointmentsSummary($dateRange)
    {
        $appointments = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']]);
        
        return [
            'total' => $appointments->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'created' => $appointments->where('status', 'created')->count(),
            'total_revenue' => $appointments->sum('amount'),
            'avg_amount' => $appointments->avg('amount'),
        ];
    }

    /**
     * Customers Report
     */
    private function getCustomersReport($dateRange, $request)
    {
        $query = Customer::with('wallet')
            ->whereBetween('created_at', [$dateRange['from'], $dateRange['to']]);

        if ($request->filled('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }

        $customers = $query->get();

        // Customer activity
        $customerActivity = Customer::whereBetween('created_at', [$dateRange['from'], $dateRange['to']])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN customer_type = "member" THEN 1 ELSE 0 END) as members')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return [
            'customers' => $customers,
            'activity' => $customerActivity
        ];
    }

    private function getCustomersSummary($dateRange)
    {
        $customers = Customer::whereBetween('created_at', [$dateRange['from'], $dateRange['to']]);
        
        return [
            'total' => $customers->count(),
            'normal' => $customers->where('customer_type', 'normal')->count(),
            'members' => $customers->where('customer_type', 'member')->count(),
            'total_wallet_balance' => MemberWallet::whereHas('customer', function($q) use ($dateRange) {
                $q->whereBetween('created_at', [$dateRange['from'], $dateRange['to']]);
            })->sum('balance'),
        ];
    }

    /**
     * Services Report
     */
    private function getServicesReport($dateRange)
    {
        $services = Service::withCount(['appointments' => function($q) use ($dateRange) {
            $q->whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']]);
        }])->get();

        // Service usage
        $serviceUsage = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']])
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->select(
                'services.name',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(appointments.amount) as revenue')
            )
            ->groupBy('services.name')
            ->orderBy('count', 'desc')
            ->get();

        return [
            'services' => $services,
            'usage' => $serviceUsage
        ];
    }

    private function getServicesSummary($dateRange)
    {
        $appointments = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']]);
        
        return [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'services_used' => $appointments->distinct('service_id')->count('service_id'),
            'total_bookings' => $appointments->count(),
        ];
    }

    /**
     * Staff Report
     */
    private function getStaffReport($dateRange)
    {
        $staff = Staff::withCount(['appointments' => function($q) use ($dateRange) {
            $q->whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']]);
        }])->get();

        // Staff performance
        $staffPerformance = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']])
            ->join('staff', 'appointments.staff_id', '=', 'staff.id')
            ->select(
                'staff.name',
                DB::raw('COUNT(*) as appointments'),
                DB::raw('SUM(appointments.amount) as revenue')
            )
            ->groupBy('staff.name')
            ->orderBy('appointments', 'desc')
            ->get();

        return [
            'staff' => $staff,
            'performance' => $staffPerformance
        ];
    }

    private function getStaffSummary($dateRange)
    {
        $appointments = Appointment::whereBetween('appointment_date', [$dateRange['from'], $dateRange['to']]);
        
        return [
            'total_staff' => Staff::count(),
            'active_staff' => Staff::where('is_active', true)->count(),
            'staff_working' => $appointments->distinct('staff_id')->count('staff_id'),
            'total_appointments' => $appointments->count(),
        ];
    }

    /**
     * Inventory Report
     */
    private function getInventoryReport()
    {
        return [
            'items' => InventoryItem::with('movements')->get(),
            'low_stock' => InventoryItem::where('quantity', '<', 10)->get(),
            'out_of_stock' => InventoryItem::where('quantity', '<=', 0)->get(),
        ];
    }

    private function getInventorySummary()
    {
        return [
            'total_items' => InventoryItem::count(),
            'in_stock' => InventoryItem::where('quantity', '>', 0)->count(),
            'low_stock' => InventoryItem::where('quantity', '>', 0)->where('quantity', '<', 10)->count(),
            'out_of_stock' => InventoryItem::where('quantity', '<=', 0)->count(),
            'total_value' => InventoryItem::sum(DB::raw('quantity * amount')),
        ];
    }

    /**
     * Download CSV
     */
    private function downloadCsv($data, $summary, $reportType, $fileName)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data, $summary, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Write summary
            fputcsv($file, ['Report Summary']);
            foreach ($summary as $key => $value) {
                fputcsv($file, [ucwords(str_replace('_', ' ', $key)), is_numeric($value) ? number_format($value, 2) : $value]);
            }
            fputcsv($file, []); // Empty row

            // Write data based on report type
            switch ($reportType) {
                case 'revenue':
                    fputcsv($file, ['Invoice #', 'Customer', 'Date', 'Total Amount', 'Wallet Deduction', 'Payable', 'Payment Mode']);
                    foreach ($data['invoices'] as $invoice) {
                        fputcsv($file, [
                            $invoice->invoice_number,
                            $invoice->customer->name,
                            $invoice->created_at->format('Y-m-d'),
                            $invoice->total_amount,
                            $invoice->wallet_deduction,
                            $invoice->payable_amount,
                            $invoice->payment_mode
                        ]);
                    }
                    break;
                case 'appointments':
                    fputcsv($file, ['Date', 'Customer', 'Service', 'Staff', 'Amount', 'Status']);
                    foreach ($data['appointments'] as $appointment) {
                        fputcsv($file, [
                            $appointment->appointment_date,
                            $appointment->customer->name ?? 'N/A',
                            $appointment->service->name ?? 'N/A',
                            $appointment->staff->name ?? 'N/A',
                            $appointment->amount,
                            $appointment->status
                        ]);
                    }
                    break;
                // Add more cases as needed
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Generate file name
     */
    private function generateFileName($reportType, $period, $format)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return "{$reportType}_report_{$period}_{$timestamp}.{$format}";
    }
}
