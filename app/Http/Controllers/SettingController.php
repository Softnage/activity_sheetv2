<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $interval = Setting::get('reporting_interval');
        $setting = Setting::first();
        return view('settings.index', compact('setting','interval'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reporting_interval' => 'required|in:hourly,bi-hourly',
            'timezone' => 'required|timezone',
        ]);

        $setting = Setting::first();
        $setting->update([
            'timezone' => $request->timezone,
        ]);
        Setting::set('reporting_interval', $request->reporting_interval);


        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
