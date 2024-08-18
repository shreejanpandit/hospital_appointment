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

            {{-- @dd($appointments) --}}
            <!-- Appointments Section -->
            <div class="bg-gray-100 dark:bg-gray-800 ">
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

                                        <a href="{{ route('appointment.show', $appointment->id) }}"
                                            class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('appointment.cancle', $appointment->id) }}"
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
