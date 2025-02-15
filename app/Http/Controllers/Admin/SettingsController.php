<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Settings::first();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'site_name' => 'required|string|max:255',
      
            'color_scheme' => 'nullable|string|max:50',
        ]);

        // Get or create the settings record
        $settings = Settings::firstOrNew();

        // Update site name and color scheme
        $settings->site_name = $request->site_name;
        $settings->color_scheme = $request->color_scheme;

    

        // Save the settings
        $settings->save();

        // Redirect back with success message
        return redirect()->route('home')->with('success', 'Settings updated successfully!');
    }
}