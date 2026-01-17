<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::query();

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
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        $rooms = $query->latest('created_at')->paginate(10)->withQueryString();
        return view('module.rooms.index', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Manager can only view rooms, not create
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to create rooms.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:rooms,name'],
            'is_active' => ['boolean']
        ]);

        $room = new Room();
        $room->name = $request->name;
        $room->slug = \Illuminate\Support\Str::slug($request->name);
        $room->is_active = $request->has('is_active');
        $room->created_by = Auth::id();
        $room->updated_by = Auth::id();
        $room->save();

        return redirect()->back()->with('success', 'Room ' . $room->name . ' created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        // Manager can only view rooms, not edit
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to edit rooms.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:rooms,name,' . $room->id],
            'is_active' => ['boolean']
        ]);

        $room->name = $request->name;
        $room->slug = \Illuminate\Support\Str::slug($request->name);
        $room->is_active = $request->has('is_active');
        $room->updated_by = Auth::id();
        $room->save();

        return redirect()->back()->with('success', 'Room ' . $room->name . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Manager can only view rooms, not delete
        if (Auth::user()->isManager()) {
            return redirect()->back()->with('error', 'You do not have permission to delete rooms.');
        }

        $name = $room->name;
        $room->delete();
        return redirect()->back()->with('success', 'Room ' . $name . ' deleted successfully.');
    }
}
