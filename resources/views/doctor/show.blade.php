<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Select doctor of your choice in the list available below
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Doctor Cards -->
                    <form action="{{ route('doctor.schedule.find') }}" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient_id }}">
                        <input type="hidden" name="department_id" value="{{ $department_id }}">
                        <input type="hidden" id="selected_doctor_id" name="doctor_id" value="">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($department_doctors as $doctor)
                                <div id="doctor_card_{{ $doctor->id }}"
                                    class="doctor-card bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 shadow-md cursor-pointer flex items-start gap-4"
                                    data-doctor-id="{{ $doctor->id }}">

                                    <!-- Image Section -->
                                    <img src="{{ $doctor->image ? asset('uploads_doctor/' . $doctor->image) : asset('uploads_doctor/default_image.png') }}"
                                        alt="Profile Image" class="w-24 h-24 object-cover rounded-full">

                                    <!-- Text Content Section -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold mb-1">Dr. {{ $doctor->user->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            {{ $doctor->department->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $doctor->contact }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $doctor->bio }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Book Appointment Button -->
                        <div class="flex items-center justify-end">
                            <button id="book-appointment-btn"
                                class="ms-4 mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                disabled>
                                Check Schedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .selected-card {
            border-color: blue !important;
            border-width: 3px !important;
        }
    </style>

    <script>
        document.querySelectorAll('.doctor-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.doctor-card').forEach(c => c.classList.remove('selected-card'));

                // Add selected class to the clicked card
                this.classList.add('selected-card');
                // Enable the button if a card is selected
                document.getElementById('book-appointment-btn').disabled = false;
                // Set the hidden input field with the selected doctor's ID
                document.getElementById('selected_doctor_id').value = this.getAttribute('data-doctor-id');
            });
        });
    </script>
</x-app-layout>
