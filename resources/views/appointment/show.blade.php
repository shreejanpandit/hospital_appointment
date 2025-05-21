<!-- resources/views/appointments/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <a href="{{ route('patient.dashboard') }}" class="text-blue-500 hover:underline">
                Back to Appointments
            </a>
        </div>
    </x-slot>

    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Appointment Details</h1>

                    <div class="mb-4">
                        <p class="text-lg font-semibold">Doctor Name:</p>
                        <p class="text-gray-700 dark:text-gray-400">Dr.{{ $appointment->doctor->user->name }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-semibold">Description:</p>
                        <p class="text-gray-700 dark:text-gray-400">{{ $appointment->description }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold">Date:</p>
                        <p class="text-gray-700 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-lg font-semibold">Time:</p>
                        <p class="text-gray-700 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</p>
                    </div>


                    <div class="mb-4">
                        <p class="text-lg font-semibold">Notes:</p>
                        <p class="text-gray-700 dark:text-gray-400">{{ $appointment->notes ?? 'No additional notes' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
