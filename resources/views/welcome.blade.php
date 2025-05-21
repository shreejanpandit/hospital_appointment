<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login and Register</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="bg-slate-200 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm p-6 pb-10 bg-white rounded-2xl ">
            <div class=" flex justify-center">
                <x-application-logo class="block" />
            </div>

            <a href="{{ route('login') }}"
                class="button block bg-blue-600 text-white rounded-lg mb-4 p-3 text-center hover:bg-blue-500">
                Log in
            </a>

            <a href="{{ route('register') }}"
                class="button block bg-green-600 text-white rounded-lg p-3 text-center hover:bg-green-500">
                Register
            </a>
        </div>

    </div>

</body>

</html>
