<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;


use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(){
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1)->orderBy('created_at', 'DESC')->paginate(9);
        // Pass data to the view
        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
        ]);
    }

    public function detail($id){
        $job = Job::with(['jobType', 'category', 'user'])->findOrFail($id);
        return view('front.job-detail', [
            'job' => $job
        ]);
    }

    public function search(Request $request)
    {
        $query = Job::where('status', 1);
        $role = $request->input('role', 'aspirant'); // Default to aspirant if not specified

        // Filter based on role
        if ($role === 'employer') {
            // For employers, show jobs they've posted
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        } else {
            // For aspirants, show all active jobs
            $query->where('status', 1);
        }

        // Search by job title (case-insensitive)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->search) . '%']);
            });
        }

        // Search by location (case-insensitive)
        if ($request->filled('location')) {
            $query->where(function($q) use ($request) {
                $q->whereRaw('LOWER(location) LIKE ?', ['%' . strtolower($request->location) . '%']);
            });
        }

        // Search by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $jobs = $query->orderBy('created_at', 'DESC')->paginate(9);
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('front.jobs', [
            'jobs' => $jobs,
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'selectedRole' => $role,
        ]);
    }
}
