<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Task;

class ActivityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'admin' || $user->role === 'moderator') {
            // Admin & Moderator: See all activity logs
            $activities = Activity::with('user', 'task')->latest()->get();
        } else {
            // Employee: See only their own activity logs
            $activities = Activity::with('task')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }
    
        return view('activities.index', compact('activities'));
    }
    

    public function create()
    {
        $tasks = auth()->user()->tasks()->where('status', 'pending')->get();
        return view('activities.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:completed,undone',
        ]);
    
        // Get the selected task
        $task = Task::findOrFail($request->task_id);
    
        // If status is "completed", save to activities table
        if ($request->status === 'completed') {
            Activity::create([
                'user_id' => auth()->id(),
                'task_id' => $request->task_id,
                'description' => $request->description,
                'status' => $request->status,
                'logged_at' => now(),
            ]);
    
            // Mark task as completed
            $task->status = 'completed';
        } else {
            // If status is "undone", keep the task status as undone
            $task->status = 'undone';
        }
    
        $task->save();
    
        return redirect()->route('activities.index')->with('success', 'Activity logged successfully.');
    }
    
    
}

