@extends(auth()->user()->role === 'admin' ? 'admin.layout' : 'layouts.app')

@section('content')
<div class="container">
    <h2>Daily Task Summary - {{ now()->format('F j, Y') }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Task</th>
                <th>Completed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->completed_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
