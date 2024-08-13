<x-guest-layout>

    <div>
        Name : {{ Auth::user()->name }} <br>
        Email: {{ Auth::user()->email }} <br>
        Role: {{ Auth::user()->role }} <br>
    </div>
    <form method="POST" action="{{ route('patient.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" value="Gender" />
            <input id="male" class=" " type="radio" name="gender" value="male" checked="true" /> Male
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
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">


            <x-primary-button class="ms-4">
                Add Patient
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
