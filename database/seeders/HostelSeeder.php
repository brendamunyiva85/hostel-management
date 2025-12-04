<?php

namespace Database\Seeders;

use App\Models\Hostel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hostels')->delete();

        $hostels = [
            [
                'name' => 'Serene Heights Hostel',
                'type' => 'girls',
                'floors' => 4,
                'address' => '123 University Road',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pioneer Boys Hostel',
                'type' => 'boys',
                'floors' => 5,
                'address' => '456 College Avenue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Unity Mixed Hostel',
                'type' => 'mixed',
                'floors' => 3,
                'address' => '789 Innovation Drive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Hostel::insert($hostels);
    }
}
