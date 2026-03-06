<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    /**
     * Display a listing of the hero slides.
     */
    public function index()
    {
        $slides = HeroSlide::ordered()->get();
        return view('hero_slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new hero slide.
     */
    public function create()
    {
        return view('hero_slides.create');
    }

    /**
     * Store a newly created hero slide in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|string|max:255',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('background_image')) {
            $imagePath = '/storage/' . $request->file('background_image')->store('hero_slides', 'public');
        }

        HeroSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'background_image' => $imagePath,
            'button1_text' => $request->button1_text,
            'button1_url' => $request->button1_url,
            'button2_text' => $request->button2_text,
            'button2_url' => $request->button2_url,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.hero-slides.index')
                         ->with('success', 'Hero slide created successfully.');
    }

    /**
     * Display the specified hero slide.
     */
    public function show(HeroSlide $heroSlide)
    {
        return view('hero_slides.show', compact('heroSlide'));
    }

    /**
     * Show the form for editing the specified hero slide.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('hero_slides.edit', compact('heroSlide'));
    }

    /**
     * Update the specified hero slide in storage.
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|string|max:255',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $updateData = [];

        // Handle image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if it exists
            if ($heroSlide->background_image) {
                $path = parse_url($heroSlide->background_image, PHP_URL_PATH);
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }
            
            $updateData['background_image'] = '/storage/' . $request->file('background_image')->store('hero_slides', 'public');
        }

        // Update other fields
        $fields = ['title', 'subtitle', 'description', 'button1_text', 'button1_url', 
                  'button2_text', 'button2_url', 'is_active', 'order'];
        
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $request->$field;
            }
        }

        $heroSlide->update($updateData);

        return redirect()->route('admin.hero-slides.index')
                         ->with('success', 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified hero slide from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        // Delete the image file if it exists
        if ($heroSlide->background_image) {
            $path = parse_url($heroSlide->background_image, PHP_URL_PATH);
            if ($path && file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }
        
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
                         ->with('success', 'Hero slide deleted successfully.');
    }
}
