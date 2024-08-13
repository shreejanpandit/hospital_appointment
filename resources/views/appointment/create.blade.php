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

                    <form method="POST" action="{{ route('appointment.store') }}">
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
                                <option value="" {{ old('department_id') }}>Select a Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>

                        <!-- Doctor -->
                        <div class="mt-4">
                            <x-input-label for="doctor_id" :value="__('Doctor')" />
                            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full">
                                <option value="">Select a Doctor</option>
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>



                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                                :value="old('description')" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                :value="old('date')" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Time -->
                        <div class="mt-4">
                            <x-input-label for="time" :value="__('Time')" />
                            <x-text-input id="time" class="block mt-1 w-full" type="time" name="time"
                                :value="old('time')" />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                Schedule Appointment
                            </x-primary-button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const departmentSelect = document.getElementById('department_id');
                            const doctorSelect = document.getElementById('doctor_id');

                            // Modify the structure to include doctor user names
                            const doctors = @json(
                                $departments->mapWithKeys(function ($department) {
                                    return [$department->id => $department->doctors->pluck('user.name', 'id')];
                                }));

                            departmentSelect.addEventListener('change', function() {
                                const departmentId = departmentSelect.value;
                                const doctorsOptions = doctors[departmentId] || {};

                                doctorSelect.innerHTML = '<option value="">Select a Doctor</option>';

                                Object.keys(doctorsOptions).forEach(function(doctorId) {
                                    const option = document.createElement('option');
                                    option.value = doctorId;
                                    option.textContent = doctorsOptions[doctorId];
                                    doctorSelect.appendChild(option);
                                });
                            });
                        });
                    </script>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
