<x-guest-layout>
    <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data"
        class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 border border-gray-200">
        @csrf

        <div class="mb-6 mt-3 p-4 border-2 border-teal-300 rounded-lg bg-white shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">User Information</h2>
            <div class="mb-2">
                <span class="font-medium text-gray-700">Name:</span>
                <span class="text-gray-900 ml-2">{{ Auth::user()->name }}</span>
            </div>
            <div class="mb-2">
                <span class="font-medium text-gray-700">Email:</span>
                <span class="text-gray-900 ml-2">{{ Auth::user()->email }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700">Role:</span>
                <span class="text-gray-900 ml-2">{{ Auth::user()->role }}</span>
            </div>
        </div>

        <!-- Contact -->
        <div class="mb-6 mt-2">
            <x-input-label for="contact" value="Contact" />
            <x-text-input id="contact"
                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                type="text" name="contact" required autocomplete="new-contact" />
            <x-input-error :messages="$errors->get('contact')" class="mt-2 text-red-600" />
        </div>

        <!-- Department -->
        <div class="mb-6">
            <x-input-label for="department_id" :value="__('Department')" />
            <select id="department_id" name="department_id"
                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required>
                <option value="">Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2 text-red-600" />
        </div>

        <!-- Bio -->
        <div class="mb-6">
            <x-input-label for="bio" value="Bio" />
            <x-text-input id="bio"
                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                type="text" name="bio" required autocomplete="new-bio" />
            <x-input-error :messages="$errors->get('bio')" class="mt-2 text-red-600" />
        </div>

        <!-- Image -->
        <div class="mb-6">
            <x-input-label for="image" value="Profile Image" />
            <x-text-input id="image"
                class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                type="file" name="image" />
            <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm">
                Add Doctor
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
