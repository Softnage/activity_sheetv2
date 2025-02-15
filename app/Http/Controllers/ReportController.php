<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;    


class ReportController extends Controller
{
    public function dailyReport()
    {
        $today = Carbon::now()->toDateString();
        
        // Fetch completed tasks for today
        $tasks = Task::whereDate('completed_at', $today)
                     ->where('status', 'completed')
                     ->with('user')
                     ->get();

        return view('reports.daily', compact('tasks'));
    }
    public function weekly()
    {
        $user = auth()->user();
        $isAdminOrModerator = in_array($user->role, ['admin', 'moderator']);
    
        // Get current week start (Monday) and end (Sunday)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        // Get reporting interval from settings
        $interval = Setting::where('key', 'reporting_interval')->value('value') ?? 'hourly';
        $timeSlots = $this->generateTimeSlots($interval);
    
        // Get the week days
        $daysOfWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $daysOfWeek[] = $startOfWeek->copy()->addDays($i)->toDateString();
        }
    
        // Fetch activities based on logged_at
        $query = Activity::whereBetween('logged_at', [$startOfWeek, $endOfWeek]);
    
        // Employees see only their tasks; Admins/Moderators see all
        if (!$isAdminOrModerator) {
            $query->where('user_id', $user->id);
        }
    
        $activities = $query->get();
    
        // Structure activities by day and time slot
        $structuredActivities = [];
        foreach ($activities as $activity) {
            $day = Carbon::parse($activity->logged_at)->toDateString();
            $timeSlot = $this->getTimeSlot(Carbon::parse($activity->logged_at), $timeSlots);
            
            if ($timeSlot) {
                $structuredActivities[$day][$timeSlot] = $activity;
            }
        }
    
        return view('reports.weekly', compact('daysOfWeek', 'timeSlots', 'structuredActivities'));
    }

    private function generateTimeSlots($interval)
    {
        $slots = [];
        $start = Carbon::parse('08:00'); // Start time (8 AM)
        $end = Carbon::parse('18:00'); // End time (6 PM)
    
        while ($start->lessThan($end)) {
            $next = $start->copy()->addMinutes($interval === 'bi-hourly' ? 120 : 60);
            $slots[$start->format('H:i') . ' - ' . $next->format('H:i')] = [$start, $next];
            $start = $next;
        }
    
        return $slots;
    }
    
private function getTimeSlot(Carbon $loggedAt)
{
    // Get reporting interval from settings
    $interval = Setting::where('key', 'reporting_interval')->value('value') ?? 'hourly';

    // Generate time slots dynamically
    $timeSlots = $this->generateTimeSlots($interval);

    // Match the logged time to a slot
    foreach ($timeSlots as $slot => $range) {
        if ($loggedAt->between($range[0], $range[1])) {
            return $slot;
        }
    }

    return null;
}

    
    
}
