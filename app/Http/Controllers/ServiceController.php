<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Duration range filter
        if ($request->filled('duration_min')) {
            $query->where('duration_minutes', '>=', $request->duration_min);
        }

        if ($request->filled('duration_max')) {
            $query->where('duration_minutes', '<=', $request->duration_max);
        }

        $services = $query->latest('created_at')->paginate(10)->withQueryString();
        return view('module.services.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active') ? true : false;

        Service::create($data);

        return redirect()->back()->with('success', 'Service ' . $data['name'] . ' created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active') ? true : false;

        $service->update($data);

        return redirect()->back()->with('success', 'Service ' . $service->name . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            // Check if service is being used in appointments
            if ($service->appointments()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete service. It is being used in appointments.');
            }

            $name = $service->name;
            $service->delete();
            return redirect()->back()->with('success', 'Service ' . $name . ' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting service: ' . $e->getMessage());
        }
    }
}
