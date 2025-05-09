<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function showApplicationForm(Job $job)
    {
        $alreadyApplied = Applicant::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->exists();
        return view('front.job-application', compact('job', 'alreadyApplied'));
    }

    public function apply(Request $request, Job $job)
    {
        $request->validate([
            'institute' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'cgpa' => 'required|string|max:10',
            'passing_year' => 'required|string|max:10',
            'experience' => 'required|string',
        ]);

        // Check if user has already applied
        $existingApplication = Applicant::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return response()->json([
                'status' => false,
                'errors' => ['general' => ['You have already applied for this job.']]
            ]);
        }

        // Create application
        $application = Applicant::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'institute' => $request->institute,
            'degree' => $request->degree,
            'cgpa' => $request->cgpa,
            'passing_year' => $request->passing_year,
            'experience' => $request->experience,
            'applied_date' => now()
        ]);

        if ($application) {
            session()->flash('success', 'Application submitted successfully!');
            return response()->json([
                'status' => true,
                'redirect' => route('account.jobsApplied'),
                'message' => 'Application submitted successfully!'
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => ['general' => ['Failed to submit application. Please try again.']]
        ]);
    }

    public function jobsApplied()
    {
        $applications = Applicant::with('job')
            ->where('user_id', Auth::id())
            ->orderByDesc('applied_date')
            ->paginate(10);
        return view('front.account.job.jobs-applied', compact('applications'));
    }
} 