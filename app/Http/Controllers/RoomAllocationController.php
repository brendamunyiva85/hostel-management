<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class RoomAllocationController extends Controller
{
    /**
     * Show form to allocate a student to a bed
     */
    public function create()
    {
        $students = Student::whereDoesntHave('bed')
                        ->orderBy('name')
                        ->get();

        $availableBeds = Bed::where('is_occupied', false)
                            ->with('room.hostel')
                            ->get();

        return view('allocations.create', compact('students', 'availableBeds'));
    }

    /**
     * Store allocation (assign student to bed)
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'bed_id'     => 'required|exists:beds,id',
        ]);

        $bed = Bed::findOrFail($request->bed_id);

        // Prevent double allocation
        if ($bed->is_occupied) {
            return back()->with('error', 'This bed is already taken.');
        }

        $student = Student::findOrFail($request->student_id);

        // Prevent student having multiple beds
        if ($student->bed()->exists()) {
            return back()->with('error', 'This student already has a bed.');
        }

        // Assign bed
        $bed->update([
            'is_occupied' => true,
            'student_id'  => $student->id,
        ]);

        // Update room's available beds
        $room = $bed->room;
        $room->decrement('available_beds');

        // Update room status
        if ($room->available_beds == 0) {
            $room->update(['status' => 'full']);
        }

        return redirect()
            ->route('allocations.create')
            ->with('success', "{$student->name} has been allocated to Bed {$bed->bed_no} in Room {$room->room_no}.");
    }

    /**
     * Free a bed (unassign student)
     */
    public function destroy(Bed $bed)
    {
        if (!$bed->is_occupied) {
            return back()->with('error', 'This bed is already free.');
        }

        $studentName = $bed->student?->name ?? 'Unknown';

        $room = $bed->room;

        // Free the bed
        $bed->update([
            'is_occupied' => false,
            'student_id'  => null,
        ]);

        // Update room
        $room->increment('available_beds');
        $room->update(['status' => 'available']);

        return redirect()
            ->route('allocations.create')
            ->with('success', "Bed {$bed->bed_no} in Room {$room->room_no} is now free. {$studentName} has been removed.");
    }

    /**
     * Show all allocations (optional dashboard)
     */
    public function index()
    {
        $allocations = Bed::where('is_occupied', true)
                          ->with('student', 'room.hostel')
                          ->paginate(15);

        return view('allocations.index', compact('allocations'));
    }
}