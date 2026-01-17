<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Staff::query();

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
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $staff = $query->latest('created_at')->paginate(10)->withQueryString();

        $managers = collect();
        if (Auth::user()->isAdmin()) {
            // Fetch users with 'manager' role
            $managers = \App\Models\User::whereHas('role', function ($q) {
                $q->where('name', 'manager');
            })->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($subQ) use ($search) {
                     $subQ->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            })->get();
        }

        return view('module.staff.index', compact('staff', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Manager can only view staff, not create
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to create staff members.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['required', 'email', 'max:255', 'unique:staff,email'],
            'address' => ['required', 'string', 'max:500'],
            'is_active' => ['boolean']
        ], [
            'name.regex' => 'Name must contain only alphabets and spaces.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $data = $request->except('documents');
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        $staff = Staff::create($data);

        return redirect()->back()->with('success', 'Staff member ' . $staff->name . ' created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $staff->load('documents');
        return view('module.staff.show', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        // Manager can only view staff, not edit
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to edit staff members.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['required', 'email', 'max:255', 'unique:staff,email,' . $staff->id],
            'address' => ['required', 'string', 'max:500'],
            'is_active' => ['boolean']
        ], [
            'name.regex' => 'Name must contain only alphabets and spaces.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        $staff->update($data);

        return redirect()->back()->with('success', 'Staff member ' . $staff->name . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Manager can only view staff, not delete
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to delete staff members.');
        }

        $name = $staff->name;
        $staff->delete();
        return redirect()->back()->with('success', 'Staff member ' . $name . ' deleted successfully.');
    }

    /**
     * Store staff documents.
     */
    public function storeDocument(Request $request, Staff $staff)
    {
        // Manager cannot access staff documents
        if (Auth::user()->isManager()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to manage staff documents.',
                ], 403);
            }
            return redirect()->back()->with('error', 'You do not have permission to manage staff documents.');
        }

        $request->validate([
            'document_type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('staff_documents', 'public');

            $staff->documents()->create([
                'document_type' => $request->document_type,
                'file_path' => $path,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Document uploaded successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload document.');
    }

    /**
     * Update the specified manager (User) resource.
     */
    public function updateManager(Request $request, \App\Models\User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'is_active' => ['boolean']
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->has('is_active');
        $user->save();

        return redirect()->back()->with('success', 'Manager ' . $user->name . ' updated successfully.');
    }

    /**
     * Remove the specified manager (User) from storage.
     */
    public function destroyManager(\App\Models\User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($user->id === Auth::id()) {
             return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->back()->with('success', 'Manager ' . $name . ' deleted successfully.');
    }
}
