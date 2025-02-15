@extends(auth()->user()->role === 'admin' ? 'admin.layout' : 'layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold text-center mb-8">Manage Tasks</h2>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Task Form (25%) -->
        <div class="md:w-1/4 w-full bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-center mb-6">Create a New Task</h3>
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="text-lg font-medium">Task Title</label>
                    <input type="text" name="title" placeholder="Task Title" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="due_date" class="text-lg font-medium">Due Date</label>
                    <input type="date" name="due_date" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    Add Task
                </button>
            </form>
        </div>

        <!-- Task List (75%) -->
        <div class="md:w-3/4 w-full space-y-6">
            @if(auth()->user()->role === 'admin')
                <!-- Employee Dropdown -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <label for="employee" class="text-lg font-medium">Select Employee</label>
                    <select id="employee" name="employee" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="fetchTasks()">
                        <option value="" selected disabled>-- Choose an Employee --</option>
                        <!-- array employees and moderators and show them -->
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                        
                    </select>
                </div>
            @endif

            <!-- Task List -->
            <div id="taskList" class="space-y-4">
                @if(auth()->user()->role === 'employee')
                    @forelse($tasks as $task)
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h4 class="text-xl font-semibold">{{ $task->title }}</h4>
                            <p class="text-sm text-gray-600 mt-2">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-medium mr-2">Status:</span>
                                <span class="font-medium capitalize {{ $task->status == 'completed' ? 'text-green-500' : ($task->status == 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No tasks assigned to you.</p>
                    @endforelse
                @else
                    <p class="text-center text-gray-500">Select an employee to view tasks.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function fetchTasks() {
        let employeeId = document.getElementById('employee').value;
        if (!employeeId) return;

        fetch(`/tasks/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                let taskList = document.getElementById('taskList');
                taskList.innerHTML = ''; // Clear previous tasks

                if (data.tasks.length === 0) {
                    taskList.innerHTML = '<p class="text-center text-gray-500">No tasks found</p>';
                    return;
                }

                data.tasks.forEach(task => {
                    let taskCard = `
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h4 class="text-xl font-semibold">${task.title}</h4>
                            <p class="text-sm text-gray-600 mt-2">Due: ${task.due_date}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-medium mr-2">Status:</span>
                                <span class="font-medium capitalize ${task.status == 'completed' ? 'text-green-500' : (task.status == 'pending' ? 'text-yellow-500' : 'text-red-500')}">
                                    ${task.status.charAt(0).toUpperCase() + task.status.slice(1)}
                                </span>
                            </div>
                        </div>
                    `;
                    taskList.innerHTML += taskCard;
                });
            })
            .catch(error => console.error('Error fetching tasks:', error));
    }
</script>
@endsection
