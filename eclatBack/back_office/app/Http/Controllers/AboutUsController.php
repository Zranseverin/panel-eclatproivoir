<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the about us content.
     */
    public function index()
    {
        $aboutUsItems = AboutUs::all();
        return view('about_us.index', compact('aboutUsItems'));
    }

    /**
     * Show the form for creating a new about us content.
     */
    public function create()
    {
        return view('about_us.create');
    }

    /**
     * Store a newly created about us content in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature1_icon' => 'nullable|string|max:100',
            'feature1_title' => 'nullable|string|max:255',
            'feature2_icon' => 'nullable|string|max:100',
            'feature2_title' => 'nullable|string|max:255',
            'feature3_icon' => 'nullable|string|max:100',
            'feature3_title' => 'nullable|string|max:255',
            'feature4_icon' => 'nullable|string|max:100',
            'feature4_title' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = '/storage/' . $request->file('image_path')->store('about_us', 'public');
        }

        AboutUs::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image_path' => $imagePath,
            'feature1_icon' => $request->feature1_icon,
            'feature1_title' => $request->feature1_title,
            'feature2_icon' => $request->feature2_icon,
            'feature2_title' => $request->feature2_title,
            'feature3_icon' => $request->feature3_icon,
            'feature3_title' => $request->feature3_title,
            'feature4_icon' => $request->feature4_icon,
            'feature4_title' => $request->feature4_title,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.about-us.index')
                         ->with('success', 'About us content created successfully.');
    }

    /**
     * Display the specified about us content.
     */
    public function show(AboutUs $aboutUs)
    {
        return view('about_us.show', compact('aboutUs'));
    }

    /**
     * Show the form for editing the specified about us content.
     */
    public function edit(AboutUs $aboutUs)
    {
        return view('about_us.edit', compact('aboutUs'));
    }

    /**
     * Update the specified about us content in storage.
     */
    public function update(Request $request, AboutUs $aboutUs)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature1_icon' => 'nullable|string|max:100',
            'feature1_title' => 'nullable|string|max:255',
            'feature2_icon' => 'nullable|string|max:100',
            'feature2_title' => 'nullable|string|max:255',
            'feature3_icon' => 'nullable|string|max:100',
            'feature3_title' => 'nullable|string|max:255',
            'feature4_icon' => 'nullable|string|max:100',
            'feature4_title' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [];

        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($aboutUs->image_path) {
                $path = parse_url($aboutUs->image_path, PHP_URL_PATH);
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }
            
            $updateData['image_path'] = '/storage/' . $request->file('image_path')->store('about_us', 'public');
        }

        // Update other fields
        $fields = ['title', 'subtitle', 'description', 'feature1_icon', 'feature1_title',
                  'feature2_icon', 'feature2_title', 'feature3_icon', 'feature3_title',
                  'feature4_icon', 'feature4_title', 'is_active'];
        
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $request->$field;
            }
        }

        $aboutUs->update($updateData);

        return redirect()->route('admin.about-us.index')
                         ->with('success', 'About us content updated successfully.');
    }

    /**
     * Remove the specified about us content from storage.
     */
    public function destroy(AboutUs $aboutUs)
    {
        // Delete the image file if it exists
        if ($aboutUs->image_path) {
            $path = parse_url($aboutUs->image_path, PHP_URL_PATH);
            if ($path && file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }
        
        $aboutUs->delete();

        return redirect()->route('admin.about-us.index')
                         ->with('success', 'About us content deleted successfully.');
    }
}
