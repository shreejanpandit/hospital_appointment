<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Doctor Details') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, including contact, department, bio, and profile picture.") }}
        </p>
    </header>

    @php
        $user = Auth::user();
        // Assuming departments is a collection of department objects
        $departments = App\Models\Department::all(); // Retrieve all departments from the database
    @endphp

    <form method="post" action="{{ route('doctor.update', $user->doctor->id) }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="contact" :value="__('Contact Information')" />
            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact', $user->doctor->contact)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('Department')" />
            <select id="department" name="department" class="mt-1 block w-full px-3" required>
                <option value="" disabled>{{ __('Select Department') }}</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ old('department', $user->doctor->department_id) == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full p-3" rows="4" required>{{ old('bio', $user->doctor->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" />
            @if ($user->doctor->image)
                <img src="{{ asset('uploads_doctor/' . $user->doctor->image) }}" alt="Profile Image"
                    class="mt-2 w-24 h-24 object-cover" />
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'doctor-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
