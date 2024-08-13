<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Doctor Dashboard') }}
            </h2>

        </div>
    </x-slot>

    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Doctor Information -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">Welcome, <b>Dr. {{ $doctor->user->name }}</b></h1>
                    </div>

                    <!-- Appointments Sections -->
                    <div class="space-y-8">

                        <!-- Today's Appointments -->
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Today's Appointments:</h2>
                            @if (empty($todayAppointments))
                                <p class="text-gray-500">You have no appointments for today.</p>
                            @else
                                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($todayAppointments as $appointment)
                                        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg overflow-hidden">
                                            <div class="p-4">Patient:
                                                <span class="text-xl font-semibold mb-2">
                                                    {{ $appointment->patient->user->name }}
                                                </span>
                                                <p class="text-gray-600 dark:text-gray-400">Date:
                                                    {{ $appointment->date->format('Y-m-d') }}</p>
                                                <p class="text-gray-600 dark:text-gray-400">Time:
                                                    {{ $appointment->time }}</p>
                                                <p class="text-gray-800 dark:text-gray-300 mt-2">
                                                    {{ $appointment->details }}</p>
                                            </div>
                                            {{-- <div class="bg-gray-100 dark:bg-gray-800 px-4 py-2 text-right">
                                                <a href="{{ route('appointment.show', $appointment->id) }}" class="text-blue-500 hover:underline">View Details</a>
                                            </div> --}}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Upcoming Appointments -->
                        <div class="mt-4">
                            <h2 class="text-2xl font-semibold mb-4">Upcoming Appointments:</h2>
                            @if (empty($upcomingAppointments))
                                <p class="text-gray-500">No upcoming appointments.</p>
                            @else
                                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($upcomingAppointments as $appointment)
                                        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg overflow-hidden">
                                            <div class="p-4">
                                                Patient:
                                                <span class="text-xl font-semibold mb-2">
                                                    {{ $appointment->patient->user->name }}
                                                </span>
                                                <p class="text-gray-600 dark:text-gray-400">Date:
                                                    {{ $appointment->date->format('Y-m-d') }}</p>
                                                <p class="text-gray-600 dark:text-gray-400">Time:
                                                    {{ $appointment->time }}</p>
                                                <p class="text-gray-800 dark:text-gray-300 mt-2">
                                                    {{ $appointment->details }}</p>
                                            </div>
                                            {{-- <div class="bg-gray-100 dark:bg-gray-800 px-4 py-2 text-right">
                                                <a href="{{ route('appointment.show', $appointment->id) }}" class="text-blue-500 hover:underline">View Details</a>
                                            </div> --}}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Previous Appointments -->
                        <div class="mt-4">
                            <h2 class="text-2xl font-semibold mb-4">Previous Appointments:</h2>
                            @if (empty($previousAppointments))
                                <p class="text-gray-500">No previous appointments.</p>
                            @else
                                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($previousAppointments as $appointment)
                                        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg overflow-hidden">
                                            <div class="p-4">
                                                Patient:
                                                <span class="text-xl font-semibold mb-2">
                                                    {{ $appointment->patient->user->name }}
                                                </span>
                                                <p class="text-gray-600 dark:text-gray-400">Date:
                                                    {{ $appointment->date->format('Y-m-d') }}</p>
                                                <p class="text-gray-600 dark:text-gray-400">Time:
                                                    {{ $appointment->time }}</p>
                                                <p class="text-gray-800 dark:text-gray-300 mt-2">
                                                    {{ $appointment->details }}</p>
                                            </div>
                                            {{-- <div class="bg-gray-100 dark:bg-gray-800 px-4 py-2 text-right">
                                                <a href="{{ route('appointment.show', $appointment->id) }}" class="text-blue-500 hover:underline">View Details</a>
                                            </div> --}}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
