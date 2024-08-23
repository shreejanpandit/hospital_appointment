<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login and Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f5f5f5;
        }

        .button {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="font-sans antialiased text-black dark:text-white flex items-center justify-center min-h-screen">
    <div class="relative w-full max-w-sm p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg text-center">
        <div class="flex justify-center mb-6">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </div>
        <div>
            <!-- Login Button -->
            <a href="{{ route('login') }}"
                class="button block mb-4 px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Log in
            </a>
            <!-- Register Button -->
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="button block px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Register
                </a>
            @endif
        </div>
    </div>
</body>

</html>
