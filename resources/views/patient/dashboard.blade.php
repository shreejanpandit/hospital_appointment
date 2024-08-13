<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Patient Dashboard') }}
            </h2>
            <a href="{{ route('appointment.create') }}" class="text-blue-500 hover:underline">
                Add Appointment
            </a>
        </div>
    </x-slot>

    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Section -->
            <h1 class="text-xl font-bold mb-4">Hello , {{ Auth::user()->name }} your upcoming appointments</h1>


            <!-- Appointments Section -->
            <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                @if ($appointments->isEmpty())
                    <p class="text-center text-gray-500 py-4">No upcoming schedule</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($appointments as $appointment)
                            @php
                                $date = \Carbon\Carbon::parse($appointment->date);
                                $time = \Carbon\Carbon::parse($appointment->time);
                            @endphp
                            <li
                                class="px-4 py-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300 ">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                            {{ $appointment->description }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $date->format('F j, Y') }} at {{ $time->format('g:i A') }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('appointment.show', $appointment->id) }}"
                                            class="text-blue-500 hover:underline">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
