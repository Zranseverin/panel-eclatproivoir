<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavbarBrand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NavbarBrandApiController extends Controller
{
    /**
     * Display the active navbar brand configuration.
     */
    public function getActive(): JsonResponse
    {
        $brand = NavbarBrand::latestActive()->first();

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'No brand configuration found'
            ], 404);
        }

        // Convert logo_path to full URL
        $brandData = $brand->toArray();
        if (!empty($brand->logo_path) && !filter_var($brand->logo_path, FILTER_VALIDATE_URL)) {
            $brandData['logo_path'] = asset($brand->logo_path);
        }

        return response()->json([
            'success' => true,
            'data' => $brandData
        ], 200);
    }

    /**
     * Display a listing of the navbar brand configurations.
     */
    public function index(): JsonResponse
    {
        $brands = NavbarBrand::orderBy('created_at', 'desc')->get();
        
        // Convert logo_path to full URL for each brand
        $brandsData = $brands->map(function ($brand) {
            $brandData = $brand->toArray();
            if (!empty($brand->logo_path) && !filter_var($brand->logo_path, FILTER_VALIDATE_URL)) {
                $brandData['logo_path'] = asset($brand->logo_path);
            }
            return $brandData;
        });
        
        return response()->json([
            'success' => true,
            'data' => $brandsData
        ], 200);
    }

    /**
     * Store a newly created navbar brand configuration in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'logo_path' => 'nullable|string|max:500',
            'logo_alt' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'brand_url' => 'nullable|string|max:255',
            'logo_height' => 'nullable|integer|min:10|max:500',
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
            // Deactivate all existing brands if this one is active
            if ($request->is_active !== false) {
                NavbarBrand::where('is_active', true)->update(['is_active' => false]);
            }

            $brand = NavbarBrand::create([
                'logo_path' => $request->logo_path ?? 'img/logo.jpg',
                'logo_alt' => $request->logo_alt ?? 'eclat pro ivoir',
                'brand_name' => $request->brand_name ?? 'EPI - Eclat pro Ivoire',
                'brand_url' => $request->brand_url ?? 'index.php',
                'logo_height' => $request->logo_height ?? 100,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Navbar brand configuration created successfully',
                'data' => $brand
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
     * Display the specified navbar brand configuration.
     */
    public function show(int $id): JsonResponse
    {
        $brand = NavbarBrand::find($id);

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        // Convert logo_path to full URL
        $brandData = $brand->toArray();
        if (!empty($brand->logo_path) && !filter_var($brand->logo_path, FILTER_VALIDATE_URL)) {
            $brandData['logo_path'] = asset($brand->logo_path);
        }

        return response()->json([
            'success' => true,
            'data' => $brandData
        ], 200);
    }

    /**
     * Update the specified navbar brand configuration in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $brand = NavbarBrand::find($id);

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'logo_path' => 'nullable|string|max:500',
            'logo_alt' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'brand_url' => 'nullable|string|max:255',
            'logo_height' => 'nullable|integer|min:10|max:500',
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

            // Deactivate all other brands if this one is being set as active
            if ($request->has('is_active') && $request->is_active === true) {
                NavbarBrand::where('id', '!=', $id)->where('is_active', true)->update(['is_active' => false]);
            }

            // Update fields if provided
            $fields = ['logo_path', 'logo_alt', 'brand_name', 'brand_url', 'logo_height', 'is_active'];
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->$field;
                }
            }

            $brand->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Navbar brand configuration updated successfully',
                'data' => $brand->fresh()
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
     * Remove the specified navbar brand configuration from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $brand = NavbarBrand::find($id);

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        try {
            $brand->delete();

            return response()->json([
                'success' => true,
                'message' => 'Navbar brand configuration deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
