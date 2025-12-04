<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Student;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Total counts
        $totalHostels   = Hostel::count();
        $totalRooms     = Room::count();
        $totalBeds      = Bed::count();
        $totalStudents  = Student::count();

        // Occupied beds (adjust this logic based on your Bed model)
        $occupiedBeds = Bed::where('is_occupied', true)->count();

        // Calculate occupancy rate
        $occupancyRate = $totalBeds > 0 
            ? round(($occupiedBeds / $totalBeds) * 100, 1) 
            : 0;

        // Recent hostels (for table or list)
        $recentHostels = Hostel::withCount('rooms')->latest()->take(10)->get();

        return view('dashboard', compact(
            'totalHostels',
            'totalRooms',
            'totalBeds',
            'totalStudents',
            'occupiedBeds',
            'occupancyRate',
            'recentHostels'
        ));
    }
}