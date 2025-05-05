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
        $jobs=Job::where('status',1)->orderBy('created_at', 'DESC')->paginate(9);
        // Pass data to the view
        return view('front.jobs', [
            'categories' => $categories,  // Corrected this line
            'jobTypes' => $jobTypes,
            'jobs'=>$jobs,
         
        ]);
    }

}
