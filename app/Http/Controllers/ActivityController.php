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
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'task_id' => $request->task_id,
            'description' => $request->description,
            'logged_at' => now(),
        ]);

        return redirect()->route('activities.index')->with('success', 'Activity logged successfully.');
    }
}

