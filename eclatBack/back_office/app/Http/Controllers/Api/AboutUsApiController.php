<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsApiController extends Controller
{
    /**
     * Display a listing of the about us content.
     */
    public function index(): JsonResponse
    {
        $aboutUs = AboutUs::all();
        
        // Convert image_path to full URL for each item
        $aboutUsData = $aboutUs->map(function ($about) {
            $aboutData = $about->toArray();
            if (!empty($about->image_path)) {
                $aboutData['image_path'] = $this->getFullUrl($about->image_path);
            }
            return $aboutData;
        });
        
        return response()->json([
            'success' => true,
            'data' => $aboutUsData
        ], 200);
    }

    /**
     * Display active about us content.
     */
    public function getActive(): JsonResponse
    {
        $aboutUs = AboutUs::active()->first();
        
        if (!$aboutUs) {
            return response()->json([
                'success' => false,
                'message' => 'No active about us content found'
            ], 404);
        }
        
        $aboutUsData = $aboutUs->toArray();
        if (!empty($aboutUs->image_path)) {
            $aboutUsData['image_path'] = $this->getFullUrl($aboutUs->image_path);
        }
        
        return response()->json([
            'success' => true,
            'data' => $aboutUsData
        ], 200);
    }

    /**
     * Store a newly created about us content in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image_path')) {
                $imagePath = '/storage/' . $request->file('image_path')->store('about_us', 'public');
            }

            $aboutUs = AboutUs::create([
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

            return response()->json([
                'success' => true,
                'message' => 'About us content created successfully',
                'data' => $aboutUs
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating about us content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified about us content.
     */
    public function show(int $id): JsonResponse
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json([
                'success' => false,
                'message' => 'About us content not found'
            ], 404);
        }

        $aboutUsData = $aboutUs->toArray();
        if (!empty($aboutUs->image_path)) {
            $aboutUsData['image_path'] = $this->getFullUrl($aboutUs->image_path);
        }

        return response()->json([
            'success' => true,
            'data' => $aboutUsData
        ], 200);
    }

    /**
     * Update the specified about us content in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json([
                'success' => false,
                'message' => 'About us content not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
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

            return response()->json([
                'success' => true,
                'message' => 'About us content updated successfully',
                'data' => $aboutUs->fresh()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating about us content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified about us content from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json([
                'success' => false,
                'message' => 'About us content not found'
            ], 404);
        }

        try {
            // Delete the image file if it exists
            if ($aboutUs->image_path) {
                $path = parse_url($aboutUs->image_path, PHP_URL_PATH);
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }
            
            $aboutUs->delete();

            return response()->json([
                'success' => true,
                'message' => 'About us content deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting about us content',
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
