<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('profils.index', compact('admin'));
    }

    /**
     * Display the profile edit form.
     */
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('profils.edit', compact('admin'));
    }

    /**
     * Update the admin profile.
     */
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($admin->id)
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nom_complet', 'numero', 'email']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('uploads/admins'), $photoName);
            $data['photo'] = 'uploads/admins/' . $photoName;
            
            // Delete old photo if exists
            if ($admin->photo && file_exists(public_path($admin->photo))) {
                unlink(public_path($admin->photo));
            }
        }

        $admin->update($data);

        return redirect()->route('admin.profile.edit')
                         ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('profils.password');
    }

    /**
     * Change the admin password.
     */
    public function changePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Update password
        $admin->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin.profile.password')
                         ->with('success', 'Mot de passe changé avec succès.');
    }
}