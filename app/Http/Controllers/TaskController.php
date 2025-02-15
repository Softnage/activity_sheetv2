<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\User;

class TaskController extends Controller
{
    
    // List tasks
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'admin') {
            $employees = User::where('role', 'employee')->get();
            $moderator = User::where('role', 'moderator')->get();
            return view('tasks.index', compact('employees', 'moderator'));
        } else {
            // Employees only see their tasks
            $tasks = Task::where('user_id', $user->id)->get();
            return view('tasks.index', compact('tasks'));
        }
    }

    public function fetchEmployeeTasks($employeeId)
{
    $tasks = Task::where('user_id', $employeeId)->get();

    return response()->json(['tasks' => $tasks]);
}


    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            // 'due_date' => $request->due_date,
            'status' => 'pending', // Default status
        ]);
        // Fetch the reporting interval from settings
$interval = Setting::get('reporting_interval');

// Define interval duration
$duration = ($interval == 'hourly') ? 1 : 2;
$nextAllowedTime = Carbon::now()->subHours($duration);

// Ensure employees log tasks within allowed time
$tasks = Task::where('created_at', '>=', $nextAllowedTime)->get();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        // Ensure only admins or task owners can update
        if (auth()->user()->role !== 'admin' && auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $request->validate([
            'status' => 'required|in:pending,completed,undone',
            
        ]);
    
        // Move undone tasks to the next day
        if ($request->status === 'undone') {
            $task->update([
                'status' => 'undone',
                'completed_at' => now(),
                'due_date' => now()->addDay()->format('Y-m-d'), // Move to the next day
            ]);
        } else {
            $task->update(['status' => $request->status]);
        }
    
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    
    public function weeklyReport()
{
    $startOfWeek = Carbon::now()->startOfWeek(); // Start of the week (Monday)
    $endOfWeek = Carbon::now()->endOfWeek(); // End of the week (Sunday)

    $tasks = Task::whereBetween('completed_at', [$startOfWeek, $endOfWeek])
        ->where('status', 'completed')
        ->orderBy('completed_at', 'asc')
        ->get();

    return view('reports.weekly', compact('tasks', 'startOfWeek', 'endOfWeek'));
}
    
    // Delete a task
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
