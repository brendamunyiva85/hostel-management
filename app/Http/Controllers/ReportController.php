<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;
use PDF; // Optional: if using barryvdh/laravel-dompdf

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,warden'); // Optional: restrict
    }

    // ===================================================================
    // 1. Hostel Summary Report
    // ===================================================================
    public function hostelSummary()
    {
        $hostels = Hostel::withCount(['rooms as total_rooms'])
                         ->withCount(['rooms as occupied_rooms' => function ($q) {
                             $q->where('status', 'full');
                         }])
                         ->withCount(['rooms as available_rooms' => function ($q) {
                             $q->where('status', 'available');
                         }])
                         ->with(['rooms.beds' => function ($q) {
                             $q->where('is_occupied', true);
                         }])
                         ->get();

        $hostels->each(function ($hostel) {
            $hostel->total_beds = $hostel->rooms->sum('capacity');
            $hostel->occupied_beds = $hostel->rooms->sum(function ($room) {
                return $room->beds->where('is_occupied', true)->count();
            });
            $hostel->available_beds = $hostel->total_beds - $hostel->occupied_beds;
        });

        return view('reports.hostel-summary', compact('hostels'));
    }

    // ===================================================================
    // 2. Room Occupancy Report
    // ===================================================================
    public function roomOccupancy(Request $request)
    {
        $hostelId = $request->get('hostel_id');

        $query = Room::with(['hostel', 'beds.student'])
                     ->withCount(['beds as total_beds'])
                     ->withCount(['beds as occupied_beds' => function ($q) {
                         $q->where('is_occupied', true);
                     }]);

        if ($hostelId) {
            $query->where('hostel_id', $hostelId);
        }

        $rooms = $query->get();

        $hostels = Hostel::orderBy('name')->get();

        return view('reports.room-occupancy', compact('rooms', 'hostels', 'hostelId'));
    }

    // ===================================================================
    // 3. Student Allocation Report
    // ===================================================================
    public function studentAllocation()
    {
        $students = User::where('role', 'student')
                        ->with(['bed.room.hostel'])
                        ->orderBy('name')
                        ->get();

        return view('reports.student-allocation', compact('students'));
    }

    // ===================================================================
    // 4. Export PDF (Optional – requires barryvdh/laravel-dompdf)
    // ===================================================================
    public function exportHostelSummaryPdf()
    {
        // Reuse logic from hostelSummary()
        $hostels = Hostel::with(['rooms.beds'])->get();
        $hostels->each(function ($hostel) {
            $hostel->total_beds = $hostel->rooms->sum('capacity');
            $hostel->occupied_beds = $hostel->rooms->sum(fn($r) => $r->beds->where('1', 1)->count());
            $hostel->available_beds = $hostel->total_beds - $hostel->occupied_beds;
        });

        $pdf = PDF::loadView('reports.pdf.hostel-summary', compact('hostels'));
        return $pdf->download('hostel-summary-report.pdf');
    }
}