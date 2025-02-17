@extends(auth()->user()->role === 'admin' ? 'admin.layout' : 'layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-blue-600 text-white text-center py-3">
                    <h5 class="mb-0 font-semibold">Log Activity</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf
                        
                        <!-- Task Selection -->
                        <div class="mb-4">
                            <label for="task_id" class="form-label font-medium text-sm text-gray-700">Select Task</label>
                            <select name="task_id" id="task_id" class="form-select p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 w-full" required>
                                <option value="" disabled selected>-- Choose a Task --</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Activity Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label font-medium text-sm text-gray-700">Activity Description</label>
                            <textarea name="description" id="description" class="form-control p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 w-full" rows="4" placeholder="Enter activity details..." required></textarea>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="mb-4">
                            <label for="status" class="form-label font-medium text-sm text-gray-700">Status</label>
                            <select name="status" id="status" class="form-select p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 w-full" required>
                                <option value="completed">Completed</option>
                                <option value="undone">Undone</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full py-3 text-lg rounded-md shadow-md transition duration-200 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Log Activity
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
