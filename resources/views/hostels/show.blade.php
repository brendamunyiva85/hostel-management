@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold">{{ $hostel->name }}</h1>
                    <p class="text-gray-600">{{ $hostel->location }}</p>
                </div>
                <a href="{{ route('hostels.index') }}" class="text-indigo-600 hover:underline">← Back</a>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <div class="bg-gradient-to-br from-teal-500 to-cyan-600 h-64 rounded-lg flex items-center justify-center text-white text-6xl font-bold">
                        {{ Str::limit($hostel->name, 1) }}
                    </div>
                </div>

                <div>
                    <div class="space-y-3">
                        <p><strong>Price:</strong> <span class="text-2xl font-bold text-green-600">KSh {{ number_format($hostel->price_per_night) }}</span> / night</p>
                        <p><strong>Room Type:</strong> {{ ucfirst($hostel->room_type) }}</p>
                        <p><strong>Beds:</strong> {{ $hostel->available_beds }} free out of {{ $hostel->total_beds }}</p>
                        <p><strong>Phone:</strong> {{ $hostel->phone }}</p>

                        <div class="flex items-center">
                            <strong class="mr-2">Rating:</strong>
                            @for($i=1;$i<=5;$i++)
                                <svg class="w-6 h-6 {{ $i<=$hostel->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.317 9.37c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                </svg>
                            @endfor
                        </div>

                        @if($hostel->amenities)
                            <div>
                                <strong>Amenities:</strong>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach($hostel->amenities as $a)
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-sm">{{ $a }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($hostel->description)
                            <div class="mt-4">
                                <strong>Description:</strong>
                                <p class="mt-1 text-gray-700">{{ $hostel->description }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('hostels.edit', $hostel) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Edit</a>
                        <form action="{{ route('hostels.destroy', $hostel) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                                    onclick="return confirm('Delete {{ addslashes($hostel->name) }}?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection