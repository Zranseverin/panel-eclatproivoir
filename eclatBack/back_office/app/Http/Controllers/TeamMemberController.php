<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the team members.
     */
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('team_members.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        return view('team_members.create');
    }

    /**
     * Store a newly created team member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $teamMember = TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'bio' => $request->bio,
            'image_url' => $imageUrl,
            'twitter_url' => $request->twitter_url,
            'facebook_url' => $request->facebook_url,
            'linkedin_url' => $request->linkedin_url,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.team_members.index')
                         ->with('success', 'Membre de l\'équipe créé avec succès.');
    }

    /**
     * Display the specified team member.
     */
    public function show(TeamMember $teamMember)
    {
        return view('team_members.show', compact('teamMember'));
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(TeamMember $teamMember)
    {
        return view('team_members.edit', compact('teamMember'));
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($teamMember->image_url) {
                $oldImagePath = str_replace(asset(''), '', $teamMember->image_url);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }
            
            $imagePath = $request->file('image')->store('team_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $teamMember->update([
            'name' => $request->name,
            'role' => $request->role,
            'bio' => $request->bio,
            'image_url' => $imageUrl ?? $teamMember->image_url,
            'twitter_url' => $request->twitter_url,
            'facebook_url' => $request->facebook_url,
            'linkedin_url' => $request->linkedin_url,
            'is_active' => $request->is_active ?? $teamMember->is_active,
        ]);

        return redirect()->route('admin.team_members.index')
                         ->with('success', 'Membre de l\'équipe mis à jour avec succès.');
    }

    /**
     * Remove the specified team member from storage.
     */
    public function destroy(TeamMember $teamMember)
    {
        // Delete the image file if it exists
        if ($teamMember->image_url) {
            $imagePath = str_replace(asset(''), '', $teamMember->image_url);
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        }
        
        $teamMember->delete();

        return redirect()->route('admin.team_members.index')
                         ->with('success', 'Membre de l\'équipe supprimé avec succès.');
    }
}