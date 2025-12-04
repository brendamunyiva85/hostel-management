<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room: ') . $room->room_no }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Hostel</p>
                            <p class="mt-1 text-lg font-semibold">{{ $room->hostel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Capacity</p>
                            <p class="mt-1 text-lg font-semibold">{{ $room->capacity }} beds</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Available</p>
                            <p class="mt-1 text-lg font-semibold">{{ $room->available_beds }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $room->status == 'available' ? 'bg-green-100 text-green-800' :
                                       ($room->status == 'full' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Beds in {{ $room->room_no }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($room->beds as $bed)
                                <div class="border rounded-lg p-3 text-center 
                                    {{ $bed->is_occupied ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }}">
                                    <p class="font-medium text-lg">{{ $bed->bed_no }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $bed->is_occupied ? ($bed->student?->name ?? 'Occupied') : 'Available' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('rooms.edit', $room) }}" 
                           class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('rooms.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>