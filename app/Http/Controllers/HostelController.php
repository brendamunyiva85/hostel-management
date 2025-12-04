<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::with('warden')->withCount('rooms')->paginate(10);
        return view('hostels.index', compact('hostels'));
    }

    public function create()
    {
        $wardens = User::where('role', 'warden')->get();
        return view('hostels.create', compact('wardens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:boys,girls,mixed',
            'floors' => 'required|integer|min:1',
            'address' => 'nullable|string',
            'warden_id' => 'nullable|exists:users,id',
            'location' => 'required|string|max:255',
            'rooms_count' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'total_beds' => 'required|integer|min:1',
        ]);

        Hostel::create($request->all());

        return redirect()->route('hostels.index')
            ->with('success', 'Hostel created successfully.');
    }

    public function show(Hostel $hostel)
    {
        $hostel->load('rooms.beds');
        return view('hostels.show', compact('hostel'));
    }

    public function edit(Hostel $hostel)
    {
        $wardens = User::where('role', 'warden')->get();
        return view('hostels.edit', compact('hostel', 'wardens'));
    }

    public function update(Request $request, Hostel $hostel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:boys,girls,mixed',
            'floors' => 'required|integer|min:1',
            'address' => 'nullable|string',
            'warden_id' => 'nullable|exists:users,id',
            'location' => 'required|string|max:255',
            'rooms_count' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'total_beds' => 'required|integer|min:1',
        ]);

        $hostel->update($request->all());

        return redirect()->route('hostels.index')
            ->with('success', 'Hostel updated successfully.');
    }

    public function destroy(Hostel $hostel)
    {
        $hostel->delete();
        return redirect()->route('hostels.index')
            ->with('success', 'Hostel deleted.');
    }
}