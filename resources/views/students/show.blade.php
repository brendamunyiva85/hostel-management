@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $student->name }}</h1>
                        <p class="text-lg text-gray-600">{{ $student->reg_number }}</p>
                    </div>
                    <a href="{{ route('students.index') }}" class="text-indigo-600 hover:underline">← Back to List</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

                    <div class="space-y-4">
                        <div>
                            <span class="font-medium text-gray-500">Email:</span>
                            <p class="mt-1 text-lg">{{ $student->email }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Phone:</span>
                            <p class="mt-1 text-lg">{{ $student->phone }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="font-medium text-gray-500">Hostel:</span>
                            <p class="mt-1 text-lg">
                                @if($student->hostel)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        {{ $student->hostel->name }}
                                    </span>
                                    <br><small class="text-gray-600">{{ $student->hostel->location }}</small>
                                @else
                                    <span class="text-gray-400 italic">Not assigned</span>
                                @endif
                            </p>
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex space-x-3">
                    <a href="{{ route('students.edit', $student) }}"
                       class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Edit Student</a>

                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700"
                                onclick="return confirm('Delete {{ addslashes($student->name) }} permanently?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection