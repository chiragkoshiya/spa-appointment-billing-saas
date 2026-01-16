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
    public function index()
    {
        $staff = Staff::latest('created_at')->paginate(10);
        return view('module.staff.index', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $name = $staff->name;
        $staff->delete();
        return redirect()->back()->with('success', 'Staff member ' . $name . ' deleted successfully.');
    }

    /**
     * Store staff documents.
     */
    public function storeDocument(Request $request, Staff $staff)
    {
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
}
