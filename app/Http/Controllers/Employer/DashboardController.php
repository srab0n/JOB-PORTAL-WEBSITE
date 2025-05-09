<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Employer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        $jobs = Job::where('user_id', $user->id)->latest()->paginate(10);
        
        // Get notifications for the employer
        $notifications = Notification::where('user_id', $user->id)
            ->with(['job', 'applicant.user'])
            ->latest()
            ->take(5)
            ->get();
            
        // Count unread notifications
        $unreadNotifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        return view('employer.dashboard', compact('employer', 'jobs', 'notifications', 'unreadNotifications'));
    }

    public function createJob()
    {
        return view('employer.jobs.create');
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'salary' => 'nullable|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'keywords' => 'nullable|string',
            'experience' => 'required|string',
            'company_name' => 'required|string',
            'company_location' => 'nullable|string',
            'company_website' => 'nullable|url',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 1;
        $validated['isFeatured'] = 0;

        Job::create($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job posted successfully!');
    }

    public function editJob(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->to(url('/account/my-jobs/edit/' . $job->id));
    }

    public function updateJob(Request $request, Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'salary' => 'nullable|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'keywords' => 'nullable|string',
            'experience' => 'required|string',
            'company_name' => 'required|string',
            'company_location' => 'nullable|string',
            'company_website' => 'nullable|url',
        ]);

        $job->update($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job updated successfully!');
    }

    public function deleteJob(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('employer.dashboard')->with('success', 'Job deleted successfully!');
    }

    public function viewApplicants(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $applicants = $job->applicants()->with('user')->paginate(10);

        return view('employer.jobs.applicants', compact('job', 'applicants'));
    }

    public function markNotificationAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }
} 