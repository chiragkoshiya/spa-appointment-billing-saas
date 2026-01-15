<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MemberWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('type')) {
            $query->where('customer_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->latest()->paginate(10);

        return view('module.customers.index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|max:255',
            'customer_type' => 'required|in:normal,member',
            'wallet_balance' => 'nullable|numeric|min:0',
        ]);

        if ($request->customer_type == 'normal') {
            return redirect()->back()->with('error', 'Normal customers can only be created via the Appointment module.');
        }

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $customer = Customer::create($data);

        if ($customer->customer_type == 'member') {
            MemberWallet::create([
                'customer_id' => $customer->id,
                'balance' => $request->wallet_balance ?? 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Customer "' . $customer->name . '" created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'email' => 'nullable|email|max:255',
            'customer_type' => 'required|in:normal,member',
            'wallet_balance' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();

        $customer->update($data);

        // If changed to member and wallet doesn't exist
        if ($customer->customer_type == 'member' && !$customer->wallet) {
            MemberWallet::create([
                'customer_id' => $customer->id,
                'balance' => $request->wallet_balance ?? 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Customer "' . $customer->name . '" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();
        return redirect()->back()->with('success', 'Customer "' . $name . '" deleted successfully.');
    }
}
