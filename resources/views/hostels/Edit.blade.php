@extends('layouts.app')

@section('title', 'Edit Hostel - ' . $hostel->name)

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

            <!-- Header -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Edit Hostel: {{ $hostel->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update hostel details below.
                </p>
            </div>

            <div class="p-6 md:p-8">

                <form method="POST" action="{{ route('hostels.update', $hostel) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Hostel Name -->
                    <div>
                        <x-input-label for="name" :value="__('Hostel Name')" />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="block mt-1 w-full"
                            :value="old('name', $hostel->name)"
                            required
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div>
                        <x-input-label for="location" :value="__('Location / Address')" />
                        <x-text-input
                            id="location"
                            name="location"
                            type="text"
                            class="block mt-1 w-full"
                            :value="old('location', $hostel->location)"
                            required
                        />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Contact Phone')" />
                        <x-text-input
                            id="phone"
                            name="phone"
                            type="tel"
                            class="block mt-1 w-full"
                            :value="old('phone', $hostel->phone)"
                            required
                        />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Star Rating -->
                    <div>
                        <x-input-label for="stars" :value="__('Star Rating')" />
                        <select name="stars" id="stars" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select Rating --</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('stars', $hostel->stars) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        <x-input-error :messages="$errors->get('stars')" class="mt-2" />
                    </div>

                    <!-- Price per Night -->
                    <div>
                        <x-input-label for="price_per_night" :value="__('Price per Night (KSh)')" />
                        <x-text-input
                            id="price_per_night"
                            name="price_per_night"
                            type="number"
                            step="0.01"
                            class="block mt-1 w-full"
                            :value="old('price_per_night', $hostel->price_per_night)"
                            required
                        />
                        <x-input-error :messages="$errors->get('price_per_night')" class="mt-2" />
                    </div>

                    <!-- Room Type Preference -->
                    <div>
                        <x-input-label for="room_type" :value="__('Primary Room Type')" />
                        <select name="room_type" id="room_type" required
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm">
                            <option value="dorm" {{ old('room_type', $hostel->room_type) === 'dorm' ? 'selected' : '' }}>Dormitory</option>
                            <option value="private" {{ old('room_type', $hostel->room_type) === 'private' ? 'selected' : '' }}>Private Room</option>
                        </select>
                        <x-input-error :messages="$errors->get('room_type')" class="mt-2" />
                    </div>

                    <!-- Amenities (Checkboxes) -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                        <x-input-label :value="__('Amenities')" class="mb-4 block text-lg font-medium" />
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                $availableAmenities = ['Wi-Fi', 'Parking', 'Pool', 'Gym', 'Restaurant', '24/7 Reception', 'Kitchen', 'Laundry', 'Security', 'Hot Shower'];
                                $selectedAmenities = old('amenities', $hostel->amenities ?? []);
                            @endphp

                            @foreach($availableAmenities as $amenity)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox"
                                           name="amenities[]"
                                           value="{{ $amenity }}"
                                           {{ in_array($amenity, $selectedAmenities) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $amenity }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('amenities')" class="mt-4" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description (Optional)')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $hostel->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('hostels.index') }}"
                           class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline text-sm">
                            ← Back to Hostels
                        </a>

                        <div class="flex space-x-3">
                            <x-danger-button
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $hostel->id }}').submit();">
                                Delete Hostel
                            </x-danger-button>

                            <x-primary-button type="submit">
                                Update Hostel
                            </x-primary-button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="delete-form-{{ $hostel->id }}"
                      action="{{ route('hostels.destroy', $hostel) }}"
                      method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection