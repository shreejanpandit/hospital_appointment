<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            doctor
        </h2>
    </x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Doctor Information
            </h2>
            <form action="{{ route('doctor.search') }}" method="GET" class="flex items-center space-x-4">
                @csrf
                <input id="search"
                    class="w-80 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    type="search" name="search" placeholder="Search Doctor" autocomplete="off" />
                <x-input-error :messages="$errors->get('search')" class="mt-2 text-red-600" />
            </form>
        </div>
    </x-slot>

    <x-flash-message />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Department
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Bio
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Image
                                </th>

                                {{-- <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Created At
                                </th> --}}

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $doctor->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $doctor->contact }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $doctor->department->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $doctor->bio }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <img src="{{ asset('uploads_doctor/' . ($doctor->image ?: 'default_image.png')) }}"
                                            alt="Profile Image" class="w-16 h-16 object-cover">
                                    </td>


                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $doctor->created_at }}
                                    </td> --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <!-- Edit Button -->
                                        <a href="{{ route('doctor.edit', $doctor->id) }}"
                                            class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                                            Edit
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.doctor.delete', $doctor->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirmCancel()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-block px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        function confirmCancel() {
            return confirm(
                "Are you sure you want to delete this patient? This action cannot be undone and will permanently remove the patient. Click 'Cancel' to go back or 'OK' to proceed."
            );
        }
    </script>
</x-app-layout>
