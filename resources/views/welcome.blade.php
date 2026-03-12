<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center">

        <!-- Logo / Title -->
        <h1 class="text-5xl font-bold text-gray-800 mb-4">Job Board</h1>
        <p class="text-gray-500 text-lg mb-10">EXW DOULEIESSSS</p>

        <!-- Buttons -->
        <div class="flex justify-center gap-6">
            <a href="{{ route('login') }}"
               class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-blue-700 transition">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="bg-white text-blue-600 border-2 border-blue-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-blue-50 transition">
                Register
            </a>
        </div>

    </div>
</body>
</html>