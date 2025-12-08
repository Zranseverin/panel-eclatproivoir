<?php

namespace App\Http\Controllers;

use App\Models\HeroContent;
use Illuminate\Http\Request;

class HeroContentController extends Controller
{
    /**
     * Display a listing of the hero contents.
     */
    public function index()
    {
        $heroContents = HeroContent::all();
        return view('hero_contents.index', compact('heroContents'));
    }

    /**
     * Show the form for creating a new hero content.
     */
    public function create()
    {
        return view('hero_contents.create');
    }

    /**
     * Store a newly created hero content in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'primary_button_text' => 'nullable|string|max:50',
            'primary_button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle background image upload
        $backgroundImageUrl = $request->background_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('background_image')) {
            $imagePath = $request->file('background_image')->store('hero_backgrounds', 'public');
            $backgroundImageUrl = asset('storage/' . $imagePath);
        }

        $heroContent = HeroContent::create([
            'headline' => $request->headline,
            'subheading' => $request->subheading,
            'primary_button_text' => $request->primary_button_text,
            'primary_button_link' => $request->primary_button_link,
            'secondary_button_text' => $request->secondary_button_text,
            'secondary_button_link' => $request->secondary_button_link,
            'background_image_url' => $backgroundImageUrl,
            'background_color' => $request->background_color ?? '#009900',
            'text_color' => $request->text_color ?? '#ffffff',
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.hero_contents.index')
                         ->with('success', 'Hero content created successfully.');
    }

    /**
     * Display the specified hero content.
     */
    public function show(HeroContent $heroContent)
    {
        return view('hero_contents.show', compact('heroContent'));
    }

    /**
     * Show the form for editing the specified hero content.
     */
    public function edit(HeroContent $heroContent)
    {
        return view('hero_contents.edit', compact('heroContent'));
    }

    /**
     * Update the specified hero content in storage.
     */
    public function update(Request $request, HeroContent $heroContent)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'primary_button_text' => 'nullable|string|max:50',
            'primary_button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle background image upload
        $backgroundImageUrl = $request->background_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('background_image')) {
            // Delete old image if it exists
            if ($heroContent->background_image_url) {
                $oldImagePath = str_replace(asset(''), '', $heroContent->background_image_url);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }
            
            $imagePath = $request->file('background_image')->store('hero_backgrounds', 'public');
            $backgroundImageUrl = asset('storage/' . $imagePath);
        }

        $heroContent->update([
            'headline' => $request->headline,
            'subheading' => $request->subheading,
            'primary_button_text' => $request->primary_button_text,
            'primary_button_link' => $request->primary_button_link,
            'secondary_button_text' => $request->secondary_button_text,
            'secondary_button_link' => $request->secondary_button_link,
            'background_image_url' => $backgroundImageUrl ?? $heroContent->background_image_url,
            'background_color' => $request->background_color ?? $heroContent->background_color,
            'text_color' => $request->text_color ?? $heroContent->text_color,
            'is_active' => $request->is_active ?? $heroContent->is_active,
        ]);

        return redirect()->route('admin.hero_contents.index')
                         ->with('success', 'Hero content updated successfully.');
    }

    /**
     * Remove the specified hero content from storage.
     */
    public function destroy(HeroContent $heroContent)
    {
        // Delete the background image file if it exists
        if ($heroContent->background_image_url) {
            $imagePath = str_replace(asset(''), '', $heroContent->background_image_url);
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        }
        
        $heroContent->delete();

        return redirect()->route('admin.hero_contents.index')
                         ->with('success', 'Hero content deleted successfully.');
    }
}