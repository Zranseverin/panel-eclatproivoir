<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeaderContact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class HeaderContactApiController extends Controller
{
    /**
     * Display the active header contact configuration.
     * 
     * @return JsonResponse
     */
    public function getActive(): JsonResponse
    {
        $contact = HeaderContact::where('is_active', true)->latest()->first();

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'No contact configuration found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $contact
        ], 200);
    }

    /**
     * Display a listing of the header contact configurations.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contacts = HeaderContact::all();
        
        return response()->json([
            'success' => true,
            'data' => $contacts
        ], 200);
    }

    /**
     * Store a newly created header contact configuration in storage.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
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
            // Deactivate all existing contacts if this one is active
            if ($request->is_active !== false) {
                HeaderContact::where('is_active', true)->update(['is_active' => false]);
            }

            $contact = HeaderContact::create([
                'phone' => $request->phone ?? '+012 345 6789',
                'email' => $request->email ?? 'info@example.com',
                'address' => $request->address ?? '123 Street, New York, USA',
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'linkedin' => $request->linkedin,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Header contact configuration created successfully',
                'data' => $contact
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
     * Display the specified header contact configuration.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $contact = HeaderContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $contact
        ], 200);
    }

    /**
     * Update the specified header contact configuration in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $contact = HeaderContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
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

            // Deactivate all other contacts if this one is being set as active
            if ($request->has('is_active') && $request->is_active === true) {
                HeaderContact::where('id', '!=', $id)->where('is_active', true)->update(['is_active' => false]);
            }

            // Update fields if provided
            $fields = ['phone', 'email', 'address', 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'is_active'];
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->$field;
                }
            }

            $contact->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Header contact configuration updated successfully',
                'data' => $contact->fresh()
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
     * Remove the specified header contact configuration from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $contact = HeaderContact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        try {
            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Header contact configuration deleted successfully'
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
