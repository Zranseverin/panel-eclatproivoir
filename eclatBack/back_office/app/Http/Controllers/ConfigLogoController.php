<?php

namespace App\Http\Controllers;

use App\Models\ConfigLogo;
use Illuminate\Http\Request;

class ConfigLogoController extends Controller
{
    /**
     * Display a listing of the logos.
     */
    public function index()
    {
        $logos = ConfigLogo::all();
        return view('logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new logo.
     */
    public function create()
    {
        return view('logos.create');
    }

    /**
     * Store a newly created logo in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('logo_image')) {
            $imagePath = $request->file('logo_image')->store('logos', 'public');
            // Store relative path for API compatibility
            $logoPath = '/storage/' . $imagePath;
        }

        $logo = ConfigLogo::create([
            'logo_path' => $logoPath ?? '',
            'alt_text' => $request->alt_text ?? 'Logo',
            'site_title' => $request->site_title ?? 'EPI - Eclat pro Ivoire',
        ]);

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo created successfully.');
    }

    /**
     * Display the specified logo.
     */
    public function show(ConfigLogo $logo)
    {
        return view('logos.show', compact('logo'));
    }

    /**
     * Show the form for editing the specified logo.
     */
    public function edit(ConfigLogo $logo)
    {
        return view('logos.edit', compact('logo'));
    }

    /**
     * Update the specified logo in storage.
     */
    public function update(Request $request, ConfigLogo $logo)
    {
        $request->validate([
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('logo_image')) {
            // Delete old image if it exists
            if ($logo->logo_path && file_exists(public_path($logo->logo_path))) {
                unlink(public_path($logo->logo_path));
            }
            
            $imagePath = $request->file('logo_image')->store('logos', 'public');
            // Store relative path for API compatibility
            $logoPath = '/storage/' . $imagePath;
            
            $logo->update([
                'logo_path' => $logoPath,
                'alt_text' => $request->alt_text ?? $logo->alt_text,
                'site_title' => $request->site_title ?? $logo->site_title,
            ]);
        } else {
            // Update only alt text and site title if no new image is uploaded
            $logo->update([
                'alt_text' => $request->alt_text ?? $logo->alt_text,
                'site_title' => $request->site_title ?? $logo->site_title,
            ]);
        }

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo updated successfully.');
    }

    /**
     * Remove the specified logo from storage.
     */
    public function destroy(ConfigLogo $logo)
    {
        // Delete the image file if it exists
        if ($logo->logo_path) {
            if (file_exists(public_path($logo->logo_path))) {
                unlink(public_path($logo->logo_path));
            }
        }
        
        $logo->delete();

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo deleted successfully.');
    }
}