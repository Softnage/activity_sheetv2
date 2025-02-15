@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Employee Dashboard</h2>

    <!-- Task Completion Progress -->
    @php
        $totalTasks = count($tasks);
        $completedTasks = collect($tasks)->where('status', 'completed')->count();
        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
    @endphp
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-2">Task Completion Progress</h3>
        <div class="relative pt-1">
            <div class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-gray-200">
                <div style="width: {{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
            </div>
            <p class="text-sm text-gray-600">{{ $completedTasks }} out of {{ $totalTasks }} tasks completed</p>
        </div>
    </div>

    <!-- Task List -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach($tasks as $task)
                <li class="bg-white p-5 rounded-lg shadow-md flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">{{ $task->title }}</h4>
                        <p class="text-sm text-gray-600">Status: 
                            <span class="font-medium capitalize {{ $task->status == 'completed' ? 'text-green-500' : ($task->status == 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                                {{ $task->status }}
                            </span>
                        </p>
                    </div>

                    <div class="flex gap-2 mt-4 md:mt-0">
                        @if($task->status == 'pending')
                            <form action="{{ route('tasks.index', $task->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                    Mark as Completed
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
