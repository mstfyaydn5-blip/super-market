<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">

    <div class="p-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p class="mt-2">أهلاً {{ auth()->user()->name }}</p>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="px-4 py-2 bg-red-500 text-white rounded">
                Logout
            </button>
        </form>
    </div>

</body>
</html>
