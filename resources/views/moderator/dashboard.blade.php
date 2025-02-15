@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Moderator Dashboard</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-info text-white p-3">
                <h4>Total Tasks: {{ $totalTasks }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h4>Completed: {{ $completedTasks }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
                <h4>Pending: {{ $pendingTasks }}</h4>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Employee Task Overview</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Task</th>
                <th>Status</th>
                <th>Logged At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->created_at->format('Y-m-d H:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
