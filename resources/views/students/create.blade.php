@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-6">Add New Student</h2>

            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Registration Number -->
                <div class="mb-4">
                    <x-input-label for="reg_number" :value="__('Reg Number')" />
                    <x-text-input id="reg_number" class="block mt-1 w-full" type="text" name="reg_number" :value="old('reg_number')" required />
                    <x-input-error :messages="$errors->get('reg_number')" class="mt-2" />
                </div>

                <!-- Hostel Assignment -->
                <div class="mb-4">
                    <x-input-label for="hostel_id" :value="__('Assign to Hostel (Optional)')" />
                    <select name="hostel_id" id="hostel_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">-- No Hostel --</option>
                        @foreach($hostels as $hostel)
                            <option value="{{ $hostel->id }}" {{ old('hostel_id') == $hostel->id ? 'selected' : '' }}>
                                {{ $hostel->name }} ({{ $hostel->location }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('hostel_id')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="flex justify-end mt-6">
                    <x-primary-button>{{ __('Add Student') }}</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection