<?php

namespace App\Http\Controllers;

use App\Helpers\EmailHelper;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the job applications.
     */
    public function index(Request $request)
    {
        $query = JobApplication::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom_complet', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('poste', 'LIKE', "%{$search}%")
                  ->orWhere('telephone', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Get counts for each status
        $pendingCount = JobApplication::where('status', 'pending')->count();
        $acceptedCount = JobApplication::where('status', 'accepted')->count();
        $rejectedCount = JobApplication::where('status', 'rejected')->count();
        $reviewedCount = JobApplication::where('status', 'reviewed')->count();

        // Order by submission date descending
        $applications = $query->orderBy('submitted_at', 'desc')->get();

        return view('job_applications.index', compact('applications', 'pendingCount', 'acceptedCount', 'rejectedCount', 'reviewedCount'));
    }

    /**
     * Show the form for creating a new job application.
     */
    public function create()
    {
        return view('job_applications.create');
    }

    /**
     * Store a newly created job application in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'civilite' => 'required|string|max:20',
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'adresse' => 'required|string',
            'poste' => 'required|string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'nullable|in:pending,reviewed,accepted,rejected',
        ]);

        // Handle file uploads
        $data = $request->except(['cv', 'lettre_motivation']);
        
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $data['cv_path'] = $cvPath;
        }
        
        if ($request->hasFile('lettre_motivation')) {
            $letterPath = $request->file('lettre_motivation')->store('lettres_motivation', 'public');
            $data['lettre_motivation_path'] = $letterPath;
        }

        $application = JobApplication::create($data);

        return redirect()->route('admin.job-applications.index')
                         ->with('success', 'Candidature créée avec succès.');
    }

    /**
     * Display the specified job application.
     */
    public function show(JobApplication $jobApplication)
    {
        return view('job_applications.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified job application.
     */
    public function edit(JobApplication $jobApplication)
    {
        return view('job_applications.edit', compact('jobApplication'));
    }

    /**
     * Update the specified job application in storage.
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'civilite' => 'required|string|max:20',
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'adresse' => 'required|string',
            'poste' => 'required|string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'nullable|in:pending,reviewed,accepted,rejected',
        ]);

        // Handle file uploads
        $data = $request->except(['cv', 'lettre_motivation']);
        
        if ($request->hasFile('cv')) {
            // Delete old file if exists
            if ($jobApplication->cv_path && Storage::disk('public')->exists($jobApplication->cv_path)) {
                Storage::disk('public')->delete($jobApplication->cv_path);
            }
            
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $data['cv_path'] = $cvPath;
        }
        
        if ($request->hasFile('lettre_motivation')) {
            // Delete old file if exists
            if ($jobApplication->lettre_motivation_path && Storage::disk('public')->exists($jobApplication->lettre_motivation_path)) {
                Storage::disk('public')->delete($jobApplication->lettre_motivation_path);
            }
            
            $letterPath = $request->file('lettre_motivation')->store('lettres_motivation', 'public');
            $data['lettre_motivation_path'] = $letterPath;
        }

        $jobApplication->update($data);

        return redirect()->route('admin.job-applications.index')
                         ->with('success', 'Candidature mise à jour avec succès.');
    }

    /**
     * Remove the specified job application from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        // Delete associated files if they exist
        if ($jobApplication->cv_path && Storage::disk('public')->exists($jobApplication->cv_path)) {
            Storage::disk('public')->delete($jobApplication->cv_path);
        }
        
        if ($jobApplication->lettre_motivation_path && Storage::disk('public')->exists($jobApplication->lettre_motivation_path)) {
            Storage::disk('public')->delete($jobApplication->lettre_motivation_path);
        }

        $jobApplication->delete();

        return redirect()->route('admin.job-applications.index')
                         ->with('success', 'Candidature supprimée avec succès.');
    }

    /**
     * Update the status of the specified job application.
     */
    public function updateStatus(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'reject_reason' => 'nullable|string|required_if:status,rejected',
            'interview_date' => 'nullable|date|required_if:status,accepted',
            'accept_message' => 'nullable|string',
            'reject_message' => 'nullable|string',
        ]);

        $jobApplication->update(['status' => $request->input('status')]);

        // Send email notification based on status
        if ($request->input('status') == 'accepted') {
            // Send acceptance email with interview date
            $this->sendAcceptanceEmail($jobApplication, $request->input('interview_date'), $request->input('accept_message'));
        } elseif ($request->input('status') == 'rejected') {
            // Send rejection email with reason
            $this->sendRejectionEmail($jobApplication, $request->input('reject_reason'), $request->input('reject_message'));
        }

        return redirect()->route('admin.job-applications.show', $jobApplication)
                         ->with('success', 'Statut de la candidature mis à jour avec succès.');
    }
    
    /**
     * Send acceptance email to the applicant.
     */
    private function sendAcceptanceEmail(JobApplication $jobApplication, $interviewDate, $customMessage)
    {
        $result = EmailHelper::sendAcceptanceEmail(
            $jobApplication->email,
            $jobApplication->nom_complet,
            $interviewDate,
            $customMessage
        );
        
        if ($result) {
            Log::info("Acceptance email sent successfully to: " . $jobApplication->email);
        } else {
            Log::error("Failed to send acceptance email to: " . $jobApplication->email);
        }
    }
    
    /**
     * Send rejection email to the applicant.
     */
    private function sendRejectionEmail(JobApplication $jobApplication, $rejectReason, $customMessage)
    {
        $result = EmailHelper::sendRejectionEmail(
            $jobApplication->email,
            $jobApplication->nom_complet,
            $rejectReason,
            $customMessage
        );
        
        if ($result) {
            Log::info("Rejection email sent successfully to: " . $jobApplication->email);
        } else {
            Log::error("Failed to send rejection email to: " . $jobApplication->email);
        }
    }
    
    /**
     * Download the CV file.
     */
    public function downloadCv(JobApplication $jobApplication)
    {
        if (!$jobApplication->cv_path) {
            return redirect()->back()->with('error', 'Fichier CV non trouvé.');
        }
        
        $cvFullPath = storage_path('app/public/' . $jobApplication->cv_path);
        if (!file_exists($cvFullPath)) {
            return redirect()->back()->with('error', 'Fichier CV introuvable sur le disque.');
        }
        
        return response()->download($cvFullPath);
    }
    
    /**
     * Download the cover letter file.
     */
    public function downloadLettreMotivation(JobApplication $jobApplication)
    {
        if (!$jobApplication->lettre_motivation_path) {
            return redirect()->back()->with('error', 'Fichier lettre de motivation non trouvé.');
        }
        
        $letterFullPath = storage_path('app/public/' . $jobApplication->lettre_motivation_path);
        if (!file_exists($letterFullPath)) {
            return redirect()->back()->with('error', 'Fichier lettre de motivation introuvable sur le disque.');
        }
        
        return response()->download($letterFullPath);
    }
}