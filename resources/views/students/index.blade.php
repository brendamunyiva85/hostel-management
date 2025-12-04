<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between mb-6">
            <h1 class="text-3xl font-bold">Students</h1>
            <a href="{{ route('students.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
                Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reg No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hostel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->reg_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->hostel)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        {{ $student->hostel->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Not Assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:underline">View</a>
                                <a href="{{ route('students.edit', $student) }}" class="text-green-600 hover:underline ml-3">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-3"
                                            onclick="return confirm('Delete {{ $student->name }}?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-8 text-gray-500">No students yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $students->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>