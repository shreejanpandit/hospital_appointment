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
                    <div class="bg-orange-100 border-l-4 border-orange-500 p-4 mb-6 rounded-md">
                        <p class="text-orange-600 font-semibold">
                            *Important Note:
                        </p>
                        <p>
                            Appointment times are automatically assigned based on the selected date from the doctor's
                            schedule. You must come during the available time frame for that day. Services will be
                            provided on a first-come, first-served basis within the designated time slot.
                        </p>
                    </div>

                    <!-- Doctor's Weekly Schedule -->
                    <div class="bg-gray-100 p-4 rounded-md shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Dr. {{ $doctor_schedule->first()->doctor->user->name }}'s Weekly Schedule
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                                <div class="mb-2">
                                    <span class="font-medium capitalize">{{ $day }}:</span>
                                    @if (!empty($schedules[$day . '_start_time']))
                                        <span>
                                            <strong class="text-green-500">
                                                {{ \Carbon\Carbon::parse($schedules[$day . '_start_time'])->format('g:i A') }}</strong>
                                            -
                                            <strong class="text-red-500">
                                                {{ \Carbon\Carbon::parse($schedules[$day . '_end_time'])->format('g:i A') }}</strong>
                                        </span>
                                    @else
                                        <span class="text-gray-500">No available time</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Appointment Form -->
                    <form action="{{ route('appointment.store') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" id="doctor_id" name="doctor_id"
                            value="{{ $doctor_schedule->first()->doctor->id }}">

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
                                :value="old('date')" onchange="updateDay()" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Display Selected Day -->
                        <div class="mt-4">
                            <p id="selected-day" class="font-medium text-gray-900 dark:text-gray-100">
                                <!-- The selected day will be shown here -->
                            </p>
                        </div>

                        <!-- Time -->
                        <div class="mt-4">
                            <x-input-label for="time" :value="__('Time')" />
                            <x-text-input id="time" class="block mt-1 w-full" type="time" name="time"
                                :value="old('time')" readonly />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>

                        <!-- Book Appointment Button -->
                        <div class="flex items-center justify-end">
                            <button id="book-appointment-btn"
                                class="ms-4 mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Updating Day -->
    <script>
        // Pass PHP data to JavaScript
        const schedules = @json($schedules);

        function updateDay() {
            const dateInput = document.getElementById('date');
            const timeInput = document.getElementById('time');
            const selectedDate = new Date(dateInput.value);
            const daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

            const dayIndex = selectedDate.getDay();
            const dayName = daysOfWeek[dayIndex];

            const dayDisplay = document.getElementById('selected-day');
            dayDisplay.textContent = `Selected Day: ${dayName.charAt(0).toUpperCase() + dayName.slice(1)}`;

            // Get the start time for the selected day
            const startTime = schedules[`${dayName}_start_time`];
            timeInput.value = startTime ? startTime : '';
        }
    </script>
</x-app-layout>
