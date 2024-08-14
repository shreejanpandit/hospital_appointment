<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Set Your Weekly Schedule
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('doctor.schedule.update') }}">
                        @csrf
                        <div class="space-y-4">
                            @foreach ($weekDays as $day)
                                <div>
                                    <x-input-label :value="__($day)" />
                                    <div class="flex space-x-4">
                                        <x-text-input id="{{ $day }}_start_time"
                                            name="{{ $day }}_start_time" type="time" :value="old($day . '_start_time', $schedule[$day . '_start_time'] ?? '')" />
                                        <x-text-input id="{{ $day }}_end_time"
                                            name="{{ $day }}_end_time" type="time" :value="old($day . '_end_time', $schedule[$day . '_end_time'] ?? '')" />
                                    </div>
                                    <x-input-error :messages="$errors->get($day . '_start_time')" class="mt-2" />
                                    <x-input-error :messages="$errors->get($day . '_end_time')" class="mt-2" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                Save Schedule
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
