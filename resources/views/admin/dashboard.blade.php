@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>

    <!-- Stats Cards (Clickable) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('tasks.index') }}" class="bg-sky-400 text-white p-5 rounded-lg shadow-md transition transform hover:scale-105 hover:bg-sky-500">
            <h4 class="text-lg font-semibold">Total Tasks</h4>
            <p class="text-2xl">{{ $totalTasks }}</p>
        </a>
        <a href="{{ route('tasks.index') }}" class="bg-gray-800 text-white p-5 rounded-lg shadow-md transition transform hover:scale-105 hover:bg-gray-900">
            <h4 class="text-lg font-semibold mb-2">Task Progress</h4>
            <div class="w-full bg-gray-300 rounded-full h-4">
                <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($totalTasks > 0) ? ($completedTasks / $totalTasks) * 100 : 0 }}%;"></div>
            </div>
            <div class="mt-2 text-sm">
                <span class="text-green-400">{{ $completedTasks }} Completed</span> /
                <span class="text-yellow-400">{{ $pendingTasks }} Pending</span>
            </div>
        </a>
    </div>

    <!-- Metrics Section -->
    <h3 class="text-xl font-semibold mt-6">Performance Metrics</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4">
        <div class="bg-purple-500 text-white p-5 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold">Task Completion Rate</h4>
            <p class="text-2xl">{{ $taskCompletionRate }}%</p>
        </div>
        <div class="bg-orange-500 text-white p-5 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold">Avg Task Duration</h4>
            <p class="text-2xl">{{ $avgTaskDuration }} mins</p>
        </div>
        <div class="bg-teal-500 text-white p-5 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold">Active Employees</h4>
            <p class="text-2xl">{{ $activeEmployees }}</p>
        </div>
        <div class="bg-red-500 text-white p-5 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold">Productivity Score</h4>
            <p class="text-2xl">{{ $productivityScore }}</p>
        </div>
    </div>


</div>
@endsection
