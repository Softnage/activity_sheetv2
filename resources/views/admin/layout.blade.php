<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
</style>
<body class="bg-white flex">
    <div x-data="{ open: true }" class="flex h-screen w-full">
        <!-- Sidebar -->
        <div :class="open ? 'w-64' : 'w-16'" class="bg-gray-900 text-white h-full transition-all duration-300 flex flex-col">
            <!-- Sidebar Toggle Button -->
            <button @click="open = !open" class="p-4 focus:outline-none hover:bg-gray-700 flex items-center">
                <i :class="open ? 'fas fa-arrow-left' : 'fas fa-bars'"></i>
            </button>

            <!-- Navigation Links -->
            <nav class="mt-4 flex-1">
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 transition">
                            <i class="fas fa-home"></i>
                            <span :class="open ? 'ml-3 block' : 'hidden'" class="transition-all">Dashboard</span>
                        </a>
                    </li>
                    <li>
    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 transition">
        <i class="fas fa-users mr-2"></i>
        <span x-show="open">Users</span>
    </a>
</li>

                    <li>
                        <a href="{{ route('tasks.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 transition">
                            <i class="fas fa-tasks"></i>
                            <span :class="open ? 'ml-3 block' : 'hidden'" class="transition-all">Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 transition">
                            <i class="fas fa-cog"></i>
                            <span :class="open ? 'ml-3 block' : 'hidden'" class="transition-all">Settings</span>
                        </a>
                    </li>
                    <!-- activities link -->
                    <li>
                        <a href="{{ route('activities.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 transition">
                            <i class="fas fa-chart-line"></i>
                            <span :class="open ? 'ml-3 block' : 'hidden'" class="transition-all">Activities</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="mb-4">
                @csrf
                <button type="submit" class="flex items-center w-full bg-red-500 hover:bg-red-600 px-4 py-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span :class="open ? 'ml-3 block' : 'hidden'" class="transition-all">Logout</span>
                </button>
            </form>
        </div>

        <!-- Main Content (Expands when sidebar is closed) -->
        <div :class="open ? 'w-[calc(100%-16rem)]' : 'w-[calc(100%-4rem)]'" class="transition-all duration-300 p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
