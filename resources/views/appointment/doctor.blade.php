<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                Doctor's Appointment
            </h2>
            @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('appointment.create') }}" style="color:blue"> Add Appointment</a>
                <a href="{{ route('appointment.create') }}" style="color:blue"> View patients Appointment</a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900 dark:text-gray-100 bg-gradient-to-r from-sky-500 to-indigo-500">
                    @foreach ($doctors_appointment as $appointment)
                        <div class="bg-gray-100 p-4 mb-4 rounded-lg shadow-md ">
                            <div class="flex items-center justify-between mb-4 ">
                                <h2 class="text-lg font-semibold">Appointment #{{ $loop->iteration }}</h2>
                                @if ($appointment->status === 'active')
                                    <span
                                        class="px-3 py-1 text-sm text-green-500 bg-green-100 rounded-full">{{ $appointment->status }}</span>
                                @elseif ($appointment->status === 'pending')
                                    <span
                                        class=" px-3 py-1 text-sm text-blue-500 bg-blue-100 rounded-full">{{ $appointment->status }}</span>
                                @else
                                    <span
                                        class=" px-3 py-1 text-sm text-red-500 bg-red-100 rounded-full">{{ $appointment->status }}</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="font-medium">Doctor:</h3>
                                    <p class="text-gray-700">{{ $appointment->doctor->name }}</p>
                                </div>
                                <div>
                                    <h3 class="font-medium">Patient:</h3>
                                    <p class="text-gray-700">{{ $appointment->patient->name }}</p>
                                </div>
                                <div>
                                    <h3 class="font-medium">Scheduled Date:</h3>
                                    <p class="text-gray-700">
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <h3 class="font-medium">Scheduled Time:</h3>
                                    <p class="text-gray-700">
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-medium">Description:</h3>
                                <p class="text-gray-700">{{ $appointment->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
