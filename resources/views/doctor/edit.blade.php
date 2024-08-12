{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Patient
        </h2>
    </x-slot>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                Edit Patient Information
            </h2>

            {{-- <a href="{{ route('patient.create') }}" style="color:blue"> Create Patient</a> --}}
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <form method="POST" action="{{ route('patient.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>



                    <!-- Contact -->
                    <div class="mt-4">
                        <x-input-label for="contact" value="Contact" />
                        <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" required
                            autocomplete="new-contact" />
                        <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                    </div>

                    <!-- Gender -->
                    <div class="mt-4">
                        <x-input-label for="gender" value="Gender" />
                        <input id="male" class=" " type="radio" name="gender" value="male"
                            checked="true" /> Male
                        <input id="female" class=" " type="radio" name="gender" value="female" />Female
                    </div>


                    <!-- DOB -->
                    <div class="mt-4">
                        <x-input-label for="dob" value="Date Of Birth" />
                        <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" />
                        <!--   <x-input-error :messages="$errors->get('contact')" class="mt-2" /> -->

                    </div>

                    <!-- Image -->
                    <div class="mt-4">
                        <x-input-label for="image" value="Profile Image" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                        <!--    <x-input-error :messages="$errors->get('contact')" class="mt-2" /> -->
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
</x-app-layout> --}}
