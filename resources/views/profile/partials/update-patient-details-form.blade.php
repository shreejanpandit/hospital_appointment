<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Patient Details') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, including date of birth, gender, and profile picture.") }}
        </p>
    </header>

    @php
        $user = Auth::user();
        $patient = $user->patient;

        // Initialize default values if $patient is null
        $dob = $patient ? $patient->dob : '';
        $gender = $patient ? $patient->gender : '';
        $image = $patient ? $patient->image : '';

        // Format $dob if it's a DateTime object

$dobFormatted = $dob instanceof \DateTime ? $dob->format('Y-m-d') : $dob;

        // Determine if the patient exists
        $hasPatient = !is_null($patient);
    @endphp

    <form method="post" action="{{ $hasPatient ? route('patient.update', $patient->id) : route('patient.store') }}"
        class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @if ($hasPatient)
            @method('patch')
        @else
            @method('post')
        @endif


        <div>
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $dobFormatted)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="mt-1 block w-full" required>
                <option value="" disabled>{{ __('Select Gender') }}</option>
                <option value="male" {{ old('gender', $gender) === 'male' ? 'selected' : '' }}>
                    {{ __('Male') }}</option>
                <option value="female" {{ old('gender', $gender) === 'female' ? 'selected' : '' }}>
                    {{ __('Female') }}</option>
                <option value="other" {{ old('gender', $gender) === 'other' ? 'selected' : '' }}>
                    {{ __('Other') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" />
            @if ($image)
                <img src="{{ asset('uploads_patient/' . $image) }}" alt="Profile Image"
                    class="mt-2 w-24 h-24 object-cover" />
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'patient-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
