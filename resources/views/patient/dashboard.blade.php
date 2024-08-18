<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Patient Dashboard') }}
            </h2>
            <!-- Aligning the content to the right -->
            <div class="ml-auto flex items-center space-x-4">
                <a href="{{ route('appointment.create') }}" class="text-blue-500 hover:underline">
                    Add Appointment
                </a>

                <!-- Notification Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="50">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>Notification</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Notifications Section -->

                            @if ($notifications->isNotEmpty())
                                <div
                                    class="bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 rounded-md p-4 max-h-80 overflow-y-auto w-80">
                                    <div class="font-semibold">Appointment Rescheduled</div>
                                    <hr>

                                    <ul class="mt-2">
                                        @foreach ($notifications->take(3) as $notification)
                                            <li class="mb-2">
                                                <p>
                                                    Your appointment with Dr.
                                                    {{ $notification->data['doctor_name'] ?? 'Unknown Doctor' }}
                                                    has been rescheduled to
                                                    {{ $notification->data['appointment_date'] ?? 'Unknown Date' }}
                                                    at {{ $notification->data['appointment_time'] ?? 'Unknown Time' }}.
                                                </p>
                                                <small
                                                    class="text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
                                                <hr>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="p-4 text-gray-500 dark:text-gray-400">No new notifications.</p>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>

            </div>
        </div>
    </x-slot>


    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Profile Section -->
            <h1 class="text-xl font-bold mb-4">Hello, {{ Auth::user()->name }}. Your upcoming appointments:</h1>

            <!-- Appointments Section -->
            <div class="bg-gray-100 dark:bg-gray-800">
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
                                class="px-4 py-4 bg-white dark:bg-gray-800 border border-transparent dark:border-transparent hover:border-cyan-500 dark:hover:border-cyan-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                            Dr. {{ $appointment->doctor->user->name }}
                                        </p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                            Description: {{ $appointment->description }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $date->format('F j, Y') }} at {{ $time->format('g:i A') }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('appointment.show', $appointment->id) }}"
                                            class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                                            Details
                                        </a>
                                        <a href="{{ route('appointment.edit', $appointment->id) }}"
                                            class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('appointment.cancel', $appointment->id) }}"
                                            method="POST" onsubmit="return confirmCancel()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-block px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmCancel() {
            return confirm(
                "Are you sure you want to cancel this appointment? This action cannot be undone and will permanently remove the appointment. Click 'Cancel' to go back or 'OK' to proceed."
            );
        }
    </script>
</x-app-layout>
