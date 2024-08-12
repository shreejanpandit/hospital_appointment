<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}</h1>
                    <!-- Add patient-specific dashboard content here -->
                    <p>Your profile image: <img src="{{ asset('uploads_doctor/' . Auth::user()->doctor->image) }}"
                            alt="Profile Image" width="150"></p>
                    {{-- <p>Your age: {{ Auth::user()->patient->age }}</p> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
