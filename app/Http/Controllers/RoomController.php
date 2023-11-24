<?php

namespace App\Http\Controllers;

use App\Model\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('rooms.view');
    }

    public function json()
    {
        $rooms = Room::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'data' => $rooms
        ]);
    }

    public function create()
    {
        return view('rooms.form');
    }

    public function edit($id)
    {
        $room = Room::find($id);
        return view('rooms.form', [
            'data' => $room
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'major' => 'required|string|max:64',
        ]);

        Room::create(array_merge($request->all(), [
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name
        ]));

        return redirect()->route('room.index')->with('success', 'Room created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'major' => 'required|string|max:64',
        ]);

        $room = Room::find($id);
        $room->name = $request->name;
        $room->major = $request->major;
        $room->updated_by = auth()->user()->name;
        $room->save();

        return redirect()->route('room.index')->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        $room->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
