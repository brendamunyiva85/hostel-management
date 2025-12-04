<x-guest-layout>
    <!-- Fullscreen Background -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative"
         style="background-image: url('{{ asset('images/hostel-bg.jpg') }}');">
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-md mx-4">
            <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">

                <!-- Header -->
                <div class="text-center py-10 px-6 bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
                    <h1 class="text-4xl font-bold tracking-tight">Nachu Hostel</h1>
                    <p class="mt-2 text-indigo-100 text-lg">Hostel Management System</p>
                </div>

                <div class="p-8">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <x-auth-validation-errors class="mb-6" :errors="$errors" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                            <x-text-input
                                id="email"
                                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="admin@nachu.com" />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password" />
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="flex items-center justify-between mb-8">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-500 underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <x-primary-button class="w-full justify-center py-3 text-lg font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>