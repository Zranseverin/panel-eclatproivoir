<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigLogo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ConfigLogoApiController extends Controller
{
    /**
     * Display a listing of the site configurations.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $configs = ConfigLogo::all();
        
        return response()->json([
            'success' => true,
            'data' => $configs
        ], 200);
    }

    /**
     * Store a newly created configuration in storage.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'logo_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file upload
            $logoPath = null;
            if ($request->hasFile('logo_image')) {
                $imagePath = $request->file('logo_image')->store('logos', 'public');
                $logoPath = asset('storage/' . $imagePath);
            }

            $config = ConfigLogo::create([
                'logo_path' => $logoPath ?? '',
                'alt_text' => $request->alt_text ?? 'Logo',
                'site_title' => $request->site_title ?? 'EPI - Eclat pro Ivoire',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Site configuration created successfully',
                'data' => $config
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified configuration.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $config = ConfigLogo::find($id);

        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $config
        ], 200);
    }

    /**
     * Update the specified configuration in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $config = ConfigLogo::find($id);

        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
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

            // Handle file upload
            if ($request->hasFile('logo_image')) {
                // Delete old image if it exists
                if ($config->logo_path) {
                    $path = parse_url($config->logo_path, PHP_URL_PATH);
                    if ($path && file_exists(public_path($path))) {
                        unlink(public_path($path));
                    }
                }
                
                $imagePath = $request->file('logo_image')->store('logos', 'public');
                $updateData['logo_path'] = asset('storage/' . $imagePath);
            }

            // Update other fields
            if ($request->has('alt_text')) {
                $updateData['alt_text'] = $request->alt_text;
            }
            
            if ($request->has('site_title')) {
                $updateData['site_title'] = $request->site_title;
            }

            $config->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Site configuration updated successfully',
                'data' => $config->fresh()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified configuration from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $config = ConfigLogo::find($id);

        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        try {
            // Delete the image file if it exists
            if ($config->logo_path) {
                $path = parse_url($config->logo_path, PHP_URL_PATH);
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
            }
            
            $config->delete();

            return response()->json([
                'success' => true,
                'message' => 'Site configuration deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the active/primary site configuration (most recent).
     * 
     * @return JsonResponse
     */
    public function getActive(): JsonResponse
    {
        $config = ConfigLogo::latest()->first();

        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'No configuration found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $config
        ], 200);
    }
}
