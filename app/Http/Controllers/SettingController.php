<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $interval = Setting::get('reporting_interval');
        return view('settings.index', compact('interval'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reporting_interval' => 'required|in:hourly,bi-hourly',
        ]);

        Setting::set('reporting_interval', $request->reporting_interval);

        return redirect()->route('settings.index')->with('success', 'Reporting interval updated.');
    }
}
