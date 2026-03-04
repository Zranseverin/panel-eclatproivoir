<?php

namespace App\Http\Controllers;

use App\Models\HeaderContact;
use Illuminate\Http\Request;

class HeaderContactController extends Controller
{
    /**
     * Display a listing of the header contacts.
     */
    public function index()
    {
        $contacts = HeaderContact::all();
        return view('header_contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new header contact.
     */
    public function create()
    {
        return view('header_contacts.create');
    }

    /**
     * Store a newly created header contact in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'facebook' => 'nullable|url|max:500',
            'twitter' => 'nullable|url|max:500',
            'linkedin' => 'nullable|url|max:500',
            'instagram' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        // Deactivate all existing contacts if this one is active
        if ($request->is_active) {
            HeaderContact::where('is_active', true)->update(['is_active' => false]);
        }

        $contact = HeaderContact::create([
            'phone' => $request->phone ?? null,
            'email' => $request->email ?? null,
            'address' => $request->address ?? null,
            'facebook' => $request->facebook ?? null,
            'twitter' => $request->twitter ?? null,
            'linkedin' => $request->linkedin ?? null,
            'instagram' => $request->instagram ?? null,
            'youtube' => $request->youtube ?? null,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.header-contacts.index')
                         ->with('success', 'Header contact configuration created successfully.');
    }

    /**
     * Display the specified header contact.
     */
    public function show(HeaderContact $headerContact)
    {
        return view('header_contacts.show', compact('headerContact'));
    }

    /**
     * Show the form for editing the specified header contact.
     */
    public function edit(HeaderContact $headerContact)
    {
        return view('header_contacts.edit', compact('headerContact'));
    }

    /**
     * Update the specified header contact in storage.
     */
    public function update(Request $request, HeaderContact $headerContact)
    {
        $request->validate([
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'facebook' => 'nullable|url|max:500',
            'twitter' => 'nullable|url|max:500',
            'linkedin' => 'nullable|url|max:500',
            'instagram' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        // If this contact is being set to active, deactivate all others
        if ($request->is_active && !$headerContact->is_active) {
            HeaderContact::where('id', '!=', $headerContact->id)->where('is_active', true)->update(['is_active' => false]);
        }

        // If this contact is being set to inactive and it's the only active one, prevent it
        if (!$request->is_active && $headerContact->is_active) {
            $activeCount = HeaderContact::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return redirect()->back()
                    ->withErrors(['is_active' => 'At least one active contact configuration is required.'])
                    ->withInput();
            }
        }

        $headerContact->update([
            'phone' => $request->phone ?? $headerContact->phone,
            'email' => $request->email ?? $headerContact->email,
            'address' => $request->address ?? $headerContact->address,
            'facebook' => $request->facebook ?? $headerContact->facebook,
            'twitter' => $request->twitter ?? $headerContact->twitter,
            'linkedin' => $request->linkedin ?? $headerContact->linkedin,
            'instagram' => $request->instagram ?? $headerContact->instagram,
            'youtube' => $request->youtube ?? $headerContact->youtube,
            'is_active' => $request->is_active ?? $headerContact->is_active,
        ]);

        return redirect()->route('admin.header-contacts.index')
                         ->with('success', 'Header contact configuration updated successfully.');
    }

    /**
     * Remove the specified header contact from storage.
     */
    public function destroy(HeaderContact $headerContact)
    {
        // Prevent deletion if it's the only active contact
        if ($headerContact->is_active) {
            $activeCount = HeaderContact::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return redirect()->back()
                    ->withErrors(['delete' => 'Cannot delete the only active contact configuration. Please activate another one first.']);
            }
        }

        $headerContact->delete();

        return redirect()->route('admin.header-contacts.index')
                         ->with('success', 'Header contact configuration deleted successfully.');
    }
}
