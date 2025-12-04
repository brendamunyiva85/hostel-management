<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Bed;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hostel')->withCount('beds')->paginate(12);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hostels = Hostel::all();
        return view('rooms.create', compact('hostels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'room_no'   => 'required|string|max:20|unique:rooms,room_no,NULL,id,hostel_id,' . $request->hostel_id,
            'capacity'  => 'required|integer|min:1|max:20',
        ]);

        $room = Room::create([
            'hostel_id'      => $request->hostel_id,
            'room_no'        => $request->room_no,
            'capacity'       => $request->capacity,
            'available_beds' => $request->capacity,
            'status'         => 'available',
        ]);

        // Auto-create beds: A, B, C, ...
        $letters = range('A', chr(64 + $room->capacity));
        foreach ($letters as $letter) {
            Bed::create([
                'room_id' => $room->id,
                'bed_no'  => $letter,
            ]);
        }

        return redirect()->route('rooms.index')
            ->with('success', "Room {$room->room_no} created with {$room->capacity} beds.");
    }

    public function show(Room $room)
    {
        $room->load('hostel', 'beds.student');
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $hostels = Hostel::all();
        return view('rooms.edit', compact('room', 'hostels'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'room_no'   => 'required|string|max:20|unique:rooms,room_no,' . $room->id . ',id,hostel_id,' . $request->hostel_id,
            'capacity'  => 'required|integer|min:1|max:20',
        ]);

        $oldCapacity = $room->capacity;
        $newCapacity = $request->capacity;

        $room->update([
            'hostel_id'      => $request->hostel_id,
            'room_no'        => $request->room_no,
            'capacity'       => $newCapacity,
            'available_beds' => $room->available_beds + ($newCapacity - $oldCapacity),
        ]);

        // Add extra beds if capacity increased
        if ($newCapacity > $oldCapacity) {
            $start = $oldCapacity + 1;
            for ($i = $start; $i <= $newCapacity; $i++) {
                $letter = chr(64 + $i);
                Bed::create([
                    'room_id' => $room->id,
                    'bed_no'  => $letter,
                ]);
            }
        }

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete(); // beds deleted via cascade
        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted.');
    }
}