<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Navbar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NavbarApiController extends Controller
{
    /**
     * Display a listing of the navbar items.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $navbars = Navbar::with('children')->ordered()->get();
        
        return response()->json([
            'success' => true,
            'data' => $navbars
        ], 200);
    }

    /**
     * Display active navbar items with dropdown structure.
     * 
     * @return JsonResponse
     */
    public function getActive(): JsonResponse
    {
        // Get top-level active items
        $topLevel = Navbar::active()
            ->topLevel()
            ->ordered()
            ->with(['children' => function($query) {
                $query->active()->ordered();
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $topLevel
        ], 200);
    }

    /**
     * Store a newly created navbar item in storage.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:navbars,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $navbar = Navbar::create([
                'title' => $request->title,
                'url' => $request->url,
                'route_name' => $request->route_name,
                'order' => $request->order ?? 0,
                'is_active' => $request->is_active ?? true,
                'parent_id' => $request->parent_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Navbar item created successfully',
                'data' => $navbar->load('parent', 'children')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating navbar item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified navbar item.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $navbar = Navbar::with('parent', 'children')->find($id);

        if (!$navbar) {
            return response()->json([
                'success' => false,
                'message' => 'Navbar item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $navbar
        ], 200);
    }

    /**
     * Update the specified navbar item in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $navbar = Navbar::find($id);

        if (!$navbar) {
            return response()->json([
                'success' => false,
                'message' => 'Navbar item not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:100',
            'url' => 'sometimes|required|string|max:255',
            'route_name' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:navbars,id',
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

            // Update fields if provided
            $fields = ['title', 'url', 'route_name', 'order', 'is_active', 'parent_id'];
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->$field;
                }
            }

            $navbar->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Navbar item updated successfully',
                'data' => $navbar->fresh()->load('parent', 'children')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating navbar item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified navbar item from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $navbar = Navbar::find($id);

        if (!$navbar) {
            return response()->json([
                'success' => false,
                'message' => 'Navbar item not found'
            ], 404);
        }

        try {
            $navbar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Navbar item deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting navbar item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
