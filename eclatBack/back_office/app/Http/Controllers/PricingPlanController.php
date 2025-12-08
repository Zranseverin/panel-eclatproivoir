<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    /**
     * Display a listing of the pricing plans.
     */
    public function index()
    {
        $pricingPlans = PricingPlan::all();
        return view('pricing_plans.index', compact('pricingPlans'));
    }

    /**
     * Show the form for creating a new pricing plan.
     */
    public function create()
    {
        return view('pricing_plans.create');
    }

    /**
     * Store a newly created pricing plan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'period' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'required|string',
            'cta_text' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pricing_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $pricingPlan = PricingPlan::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'currency' => $request->currency,
            'period' => $request->period,
            'image_url' => $imageUrl,
            'features' => $request->features,
            'cta_text' => $request->cta_text,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.pricing_plans.index')
                         ->with('success', 'Plan de tarification créé avec succès.');
    }

    /**
     * Display the specified pricing plan.
     */
    public function show(PricingPlan $pricingPlan)
    {
        return view('pricing_plans.show', compact('pricingPlan'));
    }

    /**
     * Show the form for editing the specified pricing plan.
     */
    public function edit(PricingPlan $pricingPlan)
    {
        return view('pricing_plans.edit', compact('pricingPlan'));
    }

    /**
     * Update the specified pricing plan in storage.
     */
    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'period' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'required|string',
            'cta_text' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = $request->image_url; // Default to existing URL if provided
        
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($pricingPlan->image_url) {
                $oldImagePath = str_replace(asset(''), '', $pricingPlan->image_url);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }
            
            $imagePath = $request->file('image')->store('pricing_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $pricingPlan->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'currency' => $request->currency,
            'period' => $request->period,
            'image_url' => $imageUrl ?? $pricingPlan->image_url,
            'features' => $request->features,
            'cta_text' => $request->cta_text,
            'is_active' => $request->is_active ?? $pricingPlan->is_active,
        ]);

        return redirect()->route('admin.pricing_plans.index')
                         ->with('success', 'Plan de tarification mis à jour avec succès.');
    }

    /**
     * Remove the specified pricing plan from storage.
     */
    public function destroy(PricingPlan $pricingPlan)
    {
        // Delete the image file if it exists
        if ($pricingPlan->image_url) {
            $imagePath = str_replace(asset(''), '', $pricingPlan->image_url);
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        }
        
        $pricingPlan->delete();

        return redirect()->route('admin.pricing_plans.index')
                         ->with('success', 'Plan de tarification supprimé avec succès.');
    }
}