<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource with advanced filters
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'appointment', 'items', 'creator']);

        // Advanced Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('amount_min')) {
            $query->where('total_amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('total_amount', '<=', $request->amount_max);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('payment_status')) {
            switch ($request->payment_status) {
                case 'paid':
                    $query->where('payable_amount', '<=', 0);
                    break;
                case 'partial':
                    $query->where('payable_amount', '>', 0)
                          ->where('wallet_deduction', '>', 0);
                    break;
                case 'unpaid':
                    $query->where('payable_amount', '>', 0)
                          ->where('wallet_deduction', '=', 0);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'total_amount', 'payable_amount', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $invoices = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total_invoices' => Invoice::count(),
            'total_revenue' => Invoice::sum('total_amount'),
            'total_paid' => Invoice::where('payable_amount', '<=', 0)->sum('total_amount'),
            'total_pending' => Invoice::where('payable_amount', '>', 0)->sum('payable_amount'),
            'today_invoices' => Invoice::whereDate('created_at', today())->count(),
            'today_revenue' => Invoice::whereDate('created_at', today())->sum('total_amount'),
            'month_invoices' => Invoice::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)->count(),
            'month_revenue' => Invoice::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)->sum('total_amount'),
        ];

        return view('module.invoices.index', compact('invoices', 'stats'));
    }

    /**
     * Display the specified resource
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'appointment', 'items', 'creator', 'appointment.staff', 'appointment.room']);
        return view('module.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(Invoice $invoice)
    {
        // Manager can only view/download/share invoices, not edit
        if (Auth::user()->isManager()) {
            return redirect()->route('invoices.index')->with('error', 'You do not have permission to edit invoices.');
        }

        $invoice->load(['customer', 'appointment', 'items']);
        return view('module.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Manager can only view/download/share invoices, not update
        if (Auth::user()->isManager()) {
            return redirect()->route('invoices.index')->with('error', 'You do not have permission to update invoices.');
        }

        $request->validate([
            'payment_mode' => 'required|in:cash,online',
            'payable_amount' => 'required|numeric|min:0',
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = Auth::id();

            $invoice->update($data);

            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Invoice $invoice)
    {
        // Manager can only view/download/share invoices, not delete
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to delete invoices.');
        }

        try {
            $invoice->delete();
            return redirect()->back()->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    /**
     * Download invoice as PDF
     */
    public function download(Invoice $invoice)
    {
        $invoice->load(['customer', 'appointment', 'items', 'appointment.staff', 'appointment.room']);
        
        // For now, return view - can be converted to PDF using dompdf or similar
        return view('module.invoices.pdf', compact('invoice'));
    }

    /**
     * Share invoice - generate shareable link
     */
    public function share(Invoice $invoice)
    {
        // Generate a shareable token (you can implement token-based sharing)
        $shareUrl = route('invoices.share.view', ['invoice' => $invoice->id, 'token' => md5($invoice->id . $invoice->created_at)]);
        
        return response()->json([
            'success' => true,
            'share_url' => $shareUrl,
            'message' => 'Shareable link generated successfully'
        ]);
    }

    /**
     * Public view of invoice (for sharing)
     */
    public function shareView(Request $request, Invoice $invoice)
    {
        // Verify token (simple implementation)
        $token = $request->get('token');
        $expectedToken = md5($invoice->id . $invoice->created_at);
        
        if ($token !== $expectedToken) {
            abort(403, 'Invalid share link');
        }

        $invoice->load(['customer', 'appointment', 'items', 'appointment.staff', 'appointment.room']);
        return view('module.invoices.share', compact('invoice'));
    }
}
