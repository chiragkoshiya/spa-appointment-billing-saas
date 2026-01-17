<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by discount type
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $offers = $query->latest('created_at')->paginate(10)->withQueryString();
        return view('module.offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        Offer::create($data);

        return redirect()->back()->with('success', 'Offer ' . $data['name'] . ' created successfully.');
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        $offer->update($data);

        return redirect()->back()->with('success', 'Offer ' . $offer->name . ' updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $name = $offer->name;
        $offer->delete();
        return redirect()->back()->with('success', 'Offer ' . $name . ' deleted successfully.');
    }
}
