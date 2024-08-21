<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                Admin
            </h2>
            {{-- <a href="{{ route('appointment.create') }}" style="color:blue"> Add Appointment</a>
            <a href="{{ route('admin.dashboard') }}" style="color:blue"> View doctors Appointment</a>
            <a href="{{ route('appointment.create') }}" style="color:blue"> View patients Appointment</a> --}}

        </div>
    </x-slot>
    <x-flash-message />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <x-dashboard-card title="Total Patients" content="{{ $total_patient }}"
                    route="{{ route('patient.index') }}" />
                <!-- Card 2 -->

                <x-dashboard-card title="Total Doctors" content="{{ $total_doctor }}"
                    route="{{ route('doctor.index') }}" />

                <!-- Card 3 -->
                <x-dashboard-card title="Total Appointments" content="{{ $total_appointment }}"
                    route="{{ route('appointment.index') }}" />

            </div>
            {{-- @dd(Auth::user()->role) --}}
        </div>
    </div>
</x-app-layout>
