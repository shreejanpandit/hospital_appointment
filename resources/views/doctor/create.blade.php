<x-guest-layout>

    <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Contact -->
        <div class="mt-4">
            <x-input-label for="contact" value="Contact" />
            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" required
                autocomplete="new-contact" />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department_id" :value="__('Department')" />
            <select id="department_id" name="department_id" class="block mt-1 w-full" required>
                <option value="">Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>

        <!-- Bio -->
        <div class="mt-4">
            <x-input-label for="bio" value="Bio" />
            <x-text-input id="bio" class="block mt-1 w-full" type="text" name="bio" required
                autocomplete="new-bio" />
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <!-- Image -->
        <div class="mt-4">
            <x-input-label for="image" value="Profile Image" />
            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
            <!--    <x-input-error :messages="$errors->get('contact')" class="mt-2" /> -->
        </div>

        <div class="flex items-center justify-end mt-4">


            <x-primary-button class="ms-4">
                Add Doctor
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
