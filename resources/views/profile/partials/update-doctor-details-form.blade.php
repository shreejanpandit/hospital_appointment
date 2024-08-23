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
        $doctor = $user->doctor;

        // Initialize default values if $doctor is null
        $contact = $doctor ? $doctor->contact : '';
        $bio = $doctor ? $doctor->bio : '';
        $departmentId = $doctor ? $doctor->department_id : '';
        $image = $doctor ? $doctor->image : '';

        // Determine if the doctor exists
        $hasDoctor = !is_null($doctor);

        // Retrieve all departments from the database
        $departments = App\Models\Department::all();
    @endphp

    <form method="post" action="{{ $hasDoctor ? route('doctor.update', $doctor->id) : route('doctor.store') }}"
        class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @if ($hasDoctor)
            @method('patch')
        @else
            @method('post')
        @endif

        <div>
            <x-input-label for="contact" :value="__('Contact Information')" />
            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact', $contact)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('Department')" />
            <select id="department" name="department_id" class="mt-1 block w-full px-3" required>
                <option value="" disabled>{{ __('Select Department') }}</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ old('department_id', $departmentId) == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full p-3" rows="4" required>{{ old('bio', $bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" />
            @if ($image)
                <img src="{{ asset('uploads_doctor/' . $image) }}" alt="Profile Image"
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
