<div x-data="{ open: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="open ? 'w-72' : 'w-20'" class="bg-gradient-to-b from-blue-700 to-blue-500 text-white h-full transition-all duration-300 flex flex-col shadow-lg relative">
        <!-- Sidebar Toggle Button -->
        <button @click="open = !open" class="p-4 focus:outline-none flex items-center justify-center">
            <i :class="open ? 'fas fa-chevron-left' : 'fas fa-bars'" class="text-xl"></i>
        </button>

<!-- User Info -->
<div class="p-4 text-center border-b border-blue-400" x-show="open">
    <div class="w-16 h-16 mx-auto rounded-full bg-gray-300 flex items-center justify-center">
        <i class="fas fa-user text-2xl text-blue-900"></i>
    </div>
    <a href="{{ route('profile.edit') }}" class="mt-2 font-semibold text-white hover:underline">
        {{ Auth::user()->name }}
    </a>
    <p class="text-sm text-blue-200">{{ ucfirst(Auth::user()->role) }}</p>
</div>


        <!-- Navigation Links -->
        <ul class="mt-6 flex-1 space-y-2">
    @if(Auth::user()->role === 'admin')
        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span x-show="open" class="ml-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('reports.weekly') }}" class="sidebar-link">
                <i class="fas fa-chart-line"></i>
                <span x-show="open" class="ml-3">Reports</span>
            </a>
        </li>
        <li>
            <a href="{{ route('settings.index') }}" class="sidebar-link">
                <i class="fas fa-cogs"></i>
                <span x-show="open" class="ml-3">Settings</span>
            </a>
        </li>
    @elseif(Auth::user()->role === 'moderator')
        <li>
            <a href="{{ route('moderator.dashboard') }}" class="sidebar-link">
                <i class="fas fa-user-cog"></i>
                <span x-show="open" class="ml-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('reports') }}" class="sidebar-link">
                <i class="fas fa-file-alt"></i>
                <span x-show="open" class="ml-3">Reports</span>
            </a>
        </li>
        <li>
            <a href="{{ route('tasks') }}" class="sidebar-link">
                <i class="fas fa-tasks"></i>
                <span x-show="open" class="ml-3">Manage Tasks</span>
            </a>
        </li>
    @elseif(Auth::user()->role === 'employee')
        <li>
            <a href="{{ route('employee.dashboard') }}" class="sidebar-link">
                <i class="fas fa-user"></i>
                <span x-show="open" class="ml-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.index') }}" class="sidebar-link">
                <i class="fas fa-tasks"></i>
                <span x-show="open" class="ml-3">My Tasks</span>
            </a>
        </li>
        <li>
            <a href="{{ route('reports.weekly') }}" class="sidebar-link">
                <i class="fas fa-file-alt"></i>
                <span x-show="open" class="ml-3">My Reports</span>
            </a>
        </li>
        <!-- create activities link -->
        <li>
            <a href="{{ route('activities.index') }}" class="sidebar-link">
                <i class="fas fa-chart-line"></i>
                <span x-show="open" class="ml-3">Activities</span>
            </a>
        </li>
    @endif
</ul>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        color: #ffffff;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .sidebar-link i {
        font-size: 18px;
    }

    /* Active link styles (optional, based on current route) */
    .sidebar-link.active {
        background-color: rgba(255, 255, 255, 0.3);
        font-weight: 600;
    }
</style>


        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-400">
            @csrf
            <button type="submit" class="sidebar-link bg-red-500 hover:bg-red-600">
                <i class="fas fa-sign-out-alt"></i>
                <span x-show="open">Log Out</span>
            </button>
        </form>
    </div>
</div>

<!-- Tailwind CSS classes for Sidebar links -->
<style>
    .sidebar-link {
        @apply flex items-center space-x-3 p-3 rounded-md transition hover:bg-blue-600;
    }
</style>
