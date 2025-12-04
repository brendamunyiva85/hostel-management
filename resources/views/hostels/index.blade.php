@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Hostels</h1>
            <a href="{{ route('hostels.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Add New Hostel
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($hostels as $hostel)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center text-white text-4xl font-bold">
                        {{ Str::limit($hostel->name, 1) }}
                    </div>

                    <div class="p-5">
                        <h3 class="text-xl font-semibold">{{ $hostel->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $hostel->location }}</p>

                        <div class="flex items-center mt-2">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-5 h-5 {{ $i<=$hostel->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.317 9.37c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                </svg>
                            @endfor
                        </div>

                        <p class="mt-2 font-bold text-lg text-green-600">
                            KSh {{ number_format($hostel->price_per_night) }} <span class="text-sm font-normal text-gray-500">/night</span>
                        </p>

                        <p class="text-xs text-gray-600">
                            {{ $hostel->room_type === 'dorm' ? 'Dorm' : 'Private' }} •
                            {{ $hostel->available_beds }}/{{ $hostel->total_beds }} beds free
                        </p>

                        @if($hostel->amenities)
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($hostel->amenities as $a)
                                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $a }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4 flex gap-3 text-sm">
                            <a href="{{ route('hostels.show', $hostel) }}" class="text-indigo-600 hover:underline">View</a>
                            <a href="{{ route('hostels.edit', $hostel) }}" class="text-green-600 hover:underline">Edit</a>
                            <form action="{{ route('hostels.destroy', $hostel) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Delete {{ addslashes($hostel->name) }}?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">No hostels yet.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $hostels->links() }}
        </div>
    </div>
</div>
@endsection