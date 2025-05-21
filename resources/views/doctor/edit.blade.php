<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                Edit doctor Information
            </h2>

            <a href="{{ route('doctor.create') }}" style="color:blue">Create doctor</a>
        </div>
    </x-slot>
    <x-flash-message />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('admin.doctor.update', $doctor->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $doctor->user->name)" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Contact -->
                        <div>
                            <x-input-label for="contact" :value="__('Contact')" />
                            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact"
                                :value="old('contact', $doctor->contact)" required autofocus autocomplete="contact" />
                            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                        </div>


                        <!-- Bio -->
                        <div>
                            <x-input-label for="bio" :value="__('Bio')" />
                            <textarea id="bio" name="bio" class="block mt-1 w-full p-3" required autofocus autocomplete="bio">{{ old('bio', $doctor->bio) }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                        </div>

                        <!-- Department -->
                        <div class="mt-4">
                            <x-input-label for="department_id" :value="__('Department')" />
                            <select id="department_id" name="department_id" class="block mt-1 w-full">
                                <option value=""
                                    {{ old('department_id', $doctor->department_id) == '' ? 'selected' : '' }}>Select a
                                    Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>


                        <!-- Image -->
                        <div class="mt-4">
                            <x-input-label for="image" value="Profile Image" />
                            @if ($doctor->image)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads_doctor/' . $doctor->image) }}" alt="Profile Image"
                                        class="w-32 h-32 object-cover rounded">
                                </div>
                            @endif
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                Update Doctor
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
