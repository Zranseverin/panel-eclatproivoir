<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroSlideApiController extends Controller
{
    /**
     * Display a listing of the hero slides.
     */
    public function index(): JsonResponse
    {
        $slides = HeroSlide::ordered()->get();
        
        return response()->json([
            'success' => true,
            'data' => $slides
        ], 200);
    }

    /**
     * Display active hero slides.
     */
    public function getActive(): JsonResponse
    {
        $slides = HeroSlide::active()->ordered()->get();
        
        // Convert background_image to full URL for each slide
        $slidesData = $slides->map(function ($slide) {
            $slideData = $slide->toArray();
            if (!empty($slide->background_image)) {
                $slideData['background_image'] = $this->getFullUrl($slide->background_image);
            }
            return $slideData;
        });
        
        return response()->json([
            'success' => true,
            'data' => $slidesData
        ], 200);
    }

    /**
     * Store a newly created hero slide in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagePath = null;
            if ($request->hasFile('background_image')) {
                $imagePath = '/storage/' . $request->file('background_image')->store('hero_slides', 'public');
            }

            $slide = HeroSlide::create([
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

            return response()->json([
                'success' => true,
                'message' => 'Hero slide created successfully',
                'data' => $slide
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating hero slide',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified hero slide.
     */
    public function show(int $id): JsonResponse
    {
        $slide = HeroSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $slideData = $slide->toArray();
        if (!empty($slide->background_image)) {
            $slideData['background_image'] = $this->getFullUrl($slide->background_image);
        }

        return response()->json([
            'success' => true,
            'data' => $slideData
        ], 200);
    }

    /**
     * Update the specified hero slide in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $slide = HeroSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [];

            // Handle image upload
            if ($request->hasFile('background_image')) {
                // Delete old image if it exists
                if ($slide->background_image) {
                    $path = parse_url($slide->background_image, PHP_URL_PATH);
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

            $slide->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Hero slide updated successfully',
                'data' => $slide->fresh()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating hero slide',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified hero slide from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $slide = HeroSlide::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        try {
            // Delete the image file if it exists
            if ($slide->background_image) {
                $path = parse_url($slide->background_image, PHP_URL_PATH);
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }
            
            $slide->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hero slide deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting hero slide',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get full URL for a given path using config('app.url')
     */
    private function getFullUrl(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        $path = ltrim($path, '/');
        return rtrim(config('app.url'), '/') . '/' . $path;
    }
}
