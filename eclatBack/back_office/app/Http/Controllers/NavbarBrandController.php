<?php

namespace App\Http\Controllers;

use App\Models\NavbarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NavbarBrandController extends Controller
{
    /**
     * Display a listing of the navbar brand configurations.
     */
    public function index()
    {
        $brands = NavbarBrand::orderBy('created_at', 'desc')->get();
        return view('navbar_brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new navbar brand configuration.
     */
    public function create()
    {
        return view('navbar_brands.create');
    }

    /**
     * Store a newly created navbar brand configuration in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_path' => 'nullable|string|max:500',
            'logo_alt' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'brand_url' => 'nullable|string|max:255',
            'logo_height' => 'nullable|integer|min:10|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            // Handle logo upload
            $logoPath = $request->logo_path;
            
            if ($request->hasFile('logo_upload')) {
                $image = $request->file('logo_upload');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('navbar_brands', $imageName, 'public');
                $logoPath = asset('storage/' . $imagePath); // Store full URL
            }

            // Deactivate all existing brands if this one is active
            if ($request->is_active) {
                NavbarBrand::where('is_active', true)->update(['is_active' => false]);
            }

            NavbarBrand::create([
                'logo_path' => $logoPath ?? 'img/logo.jpg',
                'logo_alt' => $request->logo_alt ?? 'eclat pro ivoir',
                'brand_name' => $request->brand_name ?? 'EPI - Eclat pro Ivoire',
                'brand_url' => $request->brand_url ?? 'index.php',
                'logo_height' => $request->logo_height ?? 100,
                'is_active' => $request->is_active ?? true,
            ]);

            return redirect()->route('admin.navbar-brands.index')
                             ->with('success', 'Navbar brand configuration created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to create navbar brand: ' . $e->getMessage()])
                             ->withInput();
        }
    }

    /**
     * Display the specified navbar brand configuration.
     */
    public function show(NavbarBrand $navbarBrand)
    {
        return view('navbar_brands.show', compact('navbarBrand'));
    }

    /**
     * Show the form for editing the specified navbar brand configuration.
     */
    public function edit(NavbarBrand $navbarBrand)
    {
        return view('navbar_brands.edit', compact('navbarBrand'));
    }

    /**
     * Update the specified navbar brand configuration in storage.
     */
    public function update(Request $request, NavbarBrand $navbarBrand)
    {
        $request->validate([
            'logo_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_path' => 'nullable|string|max:500',
            'logo_alt' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'brand_url' => 'nullable|string|max:255',
            'logo_height' => 'nullable|integer|min:10|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $updateData = [];

            // Handle logo upload
            if ($request->hasFile('logo_upload')) {
                // Delete old logo if it exists and is in storage folder
                if ($navbarBrand->logo_path && strpos($navbarBrand->logo_path, '/storage/') !== false) {
                    $oldPath = parse_url($navbarBrand->logo_path, PHP_URL_PATH);
                    if ($oldPath && file_exists(public_path($oldPath))) {
                        unlink(public_path($oldPath));
                    }
                }
                
                $image = $request->file('logo_upload');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('navbar_brands', $imageName, 'public');
                $updateData['logo_path'] = asset('storage/' . $imagePath); // Store full URL
            } elseif ($request->has('logo_path')) {
                $updateData['logo_path'] = $request->logo_path;
            }

            // If this brand is being set to active, deactivate all others
            if ($request->is_active && !$navbarBrand->is_active) {
                NavbarBrand::where('id', '!=', $navbarBrand->id)->where('is_active', true)->update(['is_active' => false]);
            }

            // Update fields if provided
            $fields = ['logo_alt', 'brand_name', 'brand_url', 'logo_height', 'is_active'];
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->$field;
                }
            }

            $navbarBrand->update($updateData);

            return redirect()->route('admin.navbar-brands.index')
                             ->with('success', 'Navbar brand configuration updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to update navbar brand: ' . $e->getMessage()])
                             ->withInput();
        }
    }

    /**
     * Remove the specified navbar brand configuration from storage.
     */
    public function destroy(NavbarBrand $navbarBrand)
    {
        try {
            // Prevent deletion if it's the only active brand
            if ($navbarBrand->is_active) {
                $activeCount = NavbarBrand::where('is_active', true)->count();
                if ($activeCount <= 1) {
                    return redirect()->back()
                        ->withErrors(['delete' => 'Cannot delete the only active brand configuration. Please activate another one first.']);
                }
            }

            $navbarBrand->delete();

            return redirect()->route('admin.navbar-brands.index')
                             ->with('success', 'Navbar brand configuration deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to delete navbar brand: ' . $e->getMessage()]);
        }
    }
}
