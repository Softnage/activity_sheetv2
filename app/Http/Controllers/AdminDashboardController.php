<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\Activity;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Total Tasks
        $totalTasks = Task::count();

        // Completed & Pending Tasks
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'undone')->count();

        // Task Completion Rate (Avoid division by zero)
        $taskCompletionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        // Average Task Duration (completed tasks only)
        $avgTaskDuration = Activity::whereNotNull('completed_at')
            ->whereNotNull('created_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, completed_at)) as avg_duration')
            ->value('avg_duration') ?? 0;

        // Active Employees (Users who have logged tasks today)
        $activeEmployees = User::whereHas('tasks', function ($query) {
            $query->whereDate('created_at', Carbon::today());
        })->count();

        // Productivity Score (Example Formula: Completion Rate * Active Users)
        $productivityScore = round($taskCompletionRate * ($activeEmployees / max($totalUsers, 1)), 2);

        // Get the reporting interval setting (Assume stored in config or DB)
        $reportingInterval = config('settings.reporting_interval', 'hourly');

        return view('admin.dashboard', compact(
            'totalUsers', 'totalTasks', 'completedTasks', 'pendingTasks',
            'taskCompletionRate', 'avgTaskDuration', 'activeEmployees',
            'productivityScore', 'reportingInterval'
        ));
    }

    public function updateSettings(Request $request)
    {
        // Validate the request
        $request->validate([
            'reporting_interval' => 'required|in:hourly,bi-hourly',
        ]);

        // Update the setting (assuming it's stored in a settings table)
        config(['settings.reporting_interval' => $request->reporting_interval]);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
