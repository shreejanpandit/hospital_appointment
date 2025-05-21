<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                Edit Patient Information
            </h2>

            <a href="{{ route('patient.create') }}" style="color:blue">Create Patient</a>
        </div>
    </x-slot>
    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('admin.patient.update', $patient->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $patient->user->name)" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div class="mt-4">
                            <x-input-label for="gender" value="Gender" />
                            <div class="flex items-center">
                                <input id="male" class="mr-2" type="radio" name="gender" value="male"
                                    {{ old('gender', $patient->gender) === 'male' ? 'checked' : '' }} /> Male
                                <input id="female" class="ml-4 mr-2" type="radio" name="gender" value="female"
                                    {{ old('gender', $patient->gender) === 'female' ? 'checked' : '' }} /> Female
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="mt-4">
                            <x-input-label for="dob" value="Date Of Birth" />
                            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob"
                                :value="old('dob', $patient->dob)" />
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <x-input-label for="image" value="Profile Image" />
                            @if ($patient->image)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads_patient/' . $patient->image) }}" alt="Profile Image"
                                        class="w-32 h-32 object-cover rounded">
                                </div>
                            @endif
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                Update Patient
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
