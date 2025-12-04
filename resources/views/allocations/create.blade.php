<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allocate Room / Bed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6">
                        <a href="{{ route('allocations.index') }}" class="text-indigo-600 hover:underline">
                            ← View All Allocations
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('allocations.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Select Student</label>
                            <select name="student_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Choose a student...</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Select Available Bed</label>
                            <select name="bed_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Choose a bed...</option>
                                @foreach($availableBeds as $bed)
                                    @if($bed->room && $bed->room->hostel)
                                        <option value="{{ $bed->id }}">
                                            {{ $bed->room->hostel->name }} → Room {{ $bed->room->room_no }} → Bed {{ $bed->bed_no }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                Allocate Bed
                            </button>
                        </div>
                    </form>

                    <h3 class="text-lg font-semibold mb-4">Available Beds</h3>
                    @if($availableBeds->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($availableBeds as $bed)
                                @if($bed->room && $bed->room->hostel)
                                    <div class="border rounded-lg p-4 bg-green-50">
                                        <p class="font-medium">Bed {{ $bed->bed_no }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $bed->room->hostel->name }} → Room {{ $bed->room->room_no }}
                                        </p>
                                        <p class="text-xs text-green-700 mt-1">Available</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No available beds.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>