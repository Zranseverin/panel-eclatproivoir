<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    /**
     * Display a listing of the navbar items.
     */
    public function index()
    {
        $navbars = Navbar::with(['parent', 'children'])->orderBy('order')->get();
        return view('navbars.index', compact('navbars'));
    }

    /**
     * Show the form for creating a new navbar item.
     */
    public function create()
    {
        $parents = Navbar::whereNull('parent_id')->orderBy('order')->get();
        return view('navbars.create', compact('parents'));
    }

    /**
     * Store a newly created navbar item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:navbars,id',
        ]);

        try {
            Navbar::create([
                'title' => $request->title,
                'url' => $request->url,
                'route_name' => $request->route_name,
                'order' => $request->order ?? 0,
                'is_active' => $request->is_active ?? true,
                'parent_id' => $request->parent_id,
            ]);

            return redirect()->route('admin.navbars.index')
                             ->with('success', 'Navbar item created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to create navbar item: ' . $e->getMessage()])
                             ->withInput();
        }
    }

    /**
     * Display the specified navbar item.
     */
    public function show(Navbar $navbar)
    {
        $navbar->load(['parent', 'children']);
        return view('navbars.show', compact('navbar'));
    }

    /**
     * Show the form for editing the specified navbar item.
     */
    public function edit(Navbar $navbar)
    {
        $parents = Navbar::whereNull('parent_id')
                        ->where('id', '!=', $navbar->id)
                        ->orderBy('order')
                        ->get();
        return view('navbars.edit', compact('navbar', 'parents'));
    }

    /**
     * Update the specified navbar item in storage.
     */
    public function update(Request $request, Navbar $navbar)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:navbars,id',
        ]);

        try {
            $navbar->update([
                'title' => $request->title,
                'url' => $request->url,
                'route_name' => $request->route_name,
                'order' => $request->order ?? 0,
                'is_active' => $request->is_active ?? true,
                'parent_id' => $request->parent_id,
            ]);

            return redirect()->route('admin.navbars.index')
                             ->with('success', 'Navbar item updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to update navbar item: ' . $e->getMessage()])
                             ->withInput();
        }
    }

    /**
     * Remove the specified navbar item from storage.
     */
    public function destroy(Navbar $navbar)
    {
        try {
            // Check if this item has children
            if ($navbar->children()->count() > 0) {
                return redirect()->back()
                    ->withErrors(['delete' => 'Cannot delete this item because it has submenu items. Please delete or move the submenu items first.']);
            }

            $navbar->delete();

            return redirect()->route('admin.navbars.index')
                             ->with('success', 'Navbar item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withErrors(['error' => 'Failed to delete navbar item: ' . $e->getMessage()]);
        }
    }
}
