<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:100',
            'client_position' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'testimonial_text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_image_url' => 'nullable|url|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->client_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonial_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $testimonial = Testimonial::create([
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'company' => $request->company,
            'testimonial_text' => $request->testimonial_text,
            'client_image_url' => $imageUrl,
            'rating' => $request->rating ?? 5,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Témoignage créé avec succès.');
    }

    /**
     * Display the specified testimonial.
     */
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|string|max:100',
            'client_position' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'testimonial_text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_image_url' => 'nullable|url|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->client_image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($testimonial->client_image_url) {
                $oldImagePath = str_replace(asset(''), '', $testimonial->client_image_url);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }
            
            $imagePath = $request->file('image')->store('testimonial_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $testimonial->update([
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'company' => $request->company,
            'testimonial_text' => $request->testimonial_text,
            'client_image_url' => $imageUrl ?? $testimonial->client_image_url,
            'rating' => $request->rating ?? $testimonial->rating,
            'is_active' => $request->is_active ?? $testimonial->is_active,
        ]);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Témoignage mis à jour avec succès.');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete the image file if it exists
        if ($testimonial->client_image_url) {
            $imagePath = str_replace(asset(''), '', $testimonial->client_image_url);
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        }
        
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Témoignage supprimé avec succès.');
    }
}