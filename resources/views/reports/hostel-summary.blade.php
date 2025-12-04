<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hostel Summary Report</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between mb-6">
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Back to Dashboard</a>
                    </div>
                    <a href="{{ route('reports.hostel-summary.pdf') }}"
                       class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Export PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hostel</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Rooms</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Beds</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Occupied</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Occupancy %</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($hostels as $hostel)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $hostel->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $hostel->type == 'boys' ? 'bg-blue-100 text-blue-800' : 
                                           ($hostel->type == 'girls' ? 'bg-pink-100 text-pink-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($hostel->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $hostel->total_rooms }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $hostel->total_beds }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-red-600">{{ $hostel->occupied_beds }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-green-600">{{ $hostel->available_beds }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $percent = $hostel->total_beds > 0 ? round(($hostel->occupied_beds / $hostel->total_beds) * 100, 1) : 0;
                                    @endphp
                                    <span class="font-medium {{ $percent >= 80 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $percent }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>