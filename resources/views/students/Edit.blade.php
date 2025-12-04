@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Edit Student</h2>

            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
                                      :value="old('name', $student->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="reg_number" :value="__('Registration Number')" />
                        <x-text-input id="reg_number" name="reg_number" type="text" class="block mt-1 w-full"
                                      :value="old('reg_number', $student->reg_number)" required />
                        <x-input-error :messages="$errors->get('reg_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full"
                                      :value="old('email', $student->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" name="phone" type="text" class="block mt-1 w-full"
                                      :value="old('phone', $student->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="hostel_id" :value="__('Hostel')" />
                        <select name="hostel_id" id="hostel_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm">
                            <option value="">-- No Hostel --</option>
                            @foreach($hostels as $hostel)
                                <option value="{{ $hostel->id }}" {{ old('hostel_id', $student->hostel_id) == $hostel->id ? 'selected' : '' }}>
                                    {{ $hostel->name }} ({{ $hostel->location }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('hostel_id')" class="mt-2" />
                    </div>

                </div>

                <div class="flex justify-end mt-8 space-x-3">
                    <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                    <x-primary-button>{{ __('Update Student') }}</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection