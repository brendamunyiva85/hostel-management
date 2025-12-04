<?php

namespace Database\Seeders;

use App\Models\Hostel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hostels = Hostel::all();

        foreach ($hostels as $hostel) {
            Room::factory()->count(10)->create([
                'hostel_id' => $hostel->id,
            ]);
        }
    }
}