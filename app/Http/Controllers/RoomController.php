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
    public function index()
    {
        $rooms = Room::latest('created_at')->paginate(10);
        return view('module.rooms.index', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $name = $room->name;
        $room->delete();
        return redirect()->back()->with('success', 'Room ' . $name . ' deleted successfully.');
    }
}
