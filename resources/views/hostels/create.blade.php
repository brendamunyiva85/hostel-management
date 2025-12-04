<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Hostel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('hostels.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hostel Name</label>
                                <input type="text" name="name" required value="{{ old('name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hostel Type</label>
                                <select name="type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="boys" {{ old('type')=='boys' ? 'selected' : '' }}>Boys</option>
                                    <option value="girls" {{ old('type')=='girls' ? 'selected' : '' }}>Girls</option>
                                    <option value="mixed" {{ old('type')=='mixed' ? 'selected' : '' }}>Mixed</option>
                                </select>
                                @error('type') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Floors</label>
                                <input type="number" name="floors" min="1" value="{{ old('floors', 1) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('floors') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Warden</label>
                                <select name="warden_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Warden</option>
                                    @foreach($wardens as $warden)
                                        <option value="{{ $warden->id }}" {{ old('warden_id') == $warden->id ? 'selected' : '' }}>
                                            {{ $warden->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warden_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" value="{{ old('location') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('location') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rooms (count)</label>
                                <input type="number" name="rooms_count" min="0" value="{{ old('rooms_count', 0) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('rooms_count') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price per Night (KSh)</label>
                                <input type="number" name="price_per_night" min="0" step="0.01" value="{{ old('price_per_night') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('price_per_night') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Beds</label>
                                <input type="number" name="total_beds" min="0" value="{{ old('total_beds', 0) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('total_beds') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address') }}</textarea>
                                @error('address') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('hostels.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Create Hostel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
