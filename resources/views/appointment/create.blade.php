<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Schedule New Appointment
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                        $dep_id = 0;
                    @endphp
                    <form method="post" action="{{ route('appointment.doctor.find') }}">
                        @csrf

                        <!-- Patient -->
                        <div>
                            <x-input-label for="patient_id" :value="__('Patient')" />
                            <select id="patient_id" name="patient_id" class="block mt-1 w-full">
                                @if ($patient)
                                    <option value="{{ $patient->id }}" selected>
                                        {{ $patient->user->name }}
                                    </option>
                                @else
                                    <option value="" selected disabled>{{ __('Select a patient') }}</option>
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                        </div>

                        <!-- Department -->
                        <div class="mt-4">
                            <x-input-label for="department_id" :value="__('Department')" />
                            <select id="department_id" name="department_id" class="block mt-1 w-full">
                                <option value="" {{ old('department_id') ? '' : 'selected' }}>Select a Department
                                </option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                Find Doctor
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
