<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        // Get all employee tasks
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->get();

        // Generate task metrics
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();

        // Weekly task statistics
        $weeklyTasks = Task::whereBetween('created_at', [
            Carbon::now()->startOfWeek(), 
            Carbon::now()->endOfWeek()
        ])->get();

        return view('moderator.dashboard', compact('tasks', 'totalTasks', 'completedTasks', 'pendingTasks', 'weeklyTasks'));
    }
}

