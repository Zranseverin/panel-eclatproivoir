<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobPostings = JobPosting::orderBy('created_at', 'desc')->paginate(10);
        return view('job_postings.index', compact('jobPostings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_postings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'profile_requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        JobPosting::create($request->all());

        return redirect()->route('admin.job-postings.index')
                         ->with('success', 'Offre d\'emploi créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPosting $jobPosting)
    {
        return view('job_postings.show', compact('jobPosting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $jobPosting)
    {
        return view('job_postings.edit', compact('jobPosting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $jobPosting)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'profile_requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $jobPosting->update($request->all());

        return redirect()->route('admin.job-postings.index')
                         ->with('success', 'Offre d\'emploi mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();

        return redirect()->route('admin.job-postings.index')
                         ->with('success', 'Offre d\'emploi supprimée avec succès.');
    }
}