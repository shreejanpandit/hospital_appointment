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
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="scheduleApp()">

                    <!-- Form -->
                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf

                        <!-- Select Doctor -->
                        <div class="mb-8">
                            <div class="mt-4">
                                <x-input-label for="doctor_id" :value="__('Doctor')" />
                                <select id="doctor_id" name="doctor_id" class="block mt-1 w-full"
                                    x-model="selectedDoctor" @change="fetchSchedules">
                                    <option value="" {{ old('doctor_id') === '' ? 'selected' : '' }}>Select a
                                        doctor</option>
                                    @foreach ($department_doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Schedule Display -->
                        <div>
                            <h3>Schedules:</h3>
                            <ul id="schedule-list">
                                <template x-if="schedules.length > 0">
                                    <template x-for="(scheduleGroup, day) in schedules" :key="day">
                                        <div>
                                            <h4 x-text="day"></h4>
                                            <ul>
                                                <template x-for="schedule in scheduleGroup" :key="schedule.id">
                                                    <li>
                                                        <strong>Time:</strong>
                                                        <span x-text="schedule.start_time"></span> -
                                                        <span x-text="schedule.end_time"></span><br>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="schedules.length === 0">
                                    <li>No schedules available</li>
                                </template>
                            </ul>
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

                        <!-- Book Appointment Button -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="ms-4 mt-4">
                                Book Appointment
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function scheduleApp() {
            return {
                selectedDoctor: '',
                schedules: [],

                fetchSchedules() {
                    if (this.selectedDoctor) {
                        fetch(`/schedules/${this.selectedDoctor}`)
                            .then(response => response.json())
                            .then(data => {
                                this.schedules = Object.entries(data).map(([day, schedules]) => ({
                                    day,
                                    schedules
                                }));
                            })
                            .catch(error => {
                                console.error('Error fetching schedules:', error);
                                this.schedules = [];
                            });
                    } else {
                        this.schedules = [];
                    }
                }
            };
        }
    </script>
</x-app-layout>
