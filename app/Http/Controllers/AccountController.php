<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;

class AccountController extends Controller
{
    // Show registration form
    public function registration()
    {
        return view('front.account.registration');
    }

    // Handle registration submission
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success', 'You have registered successfully.');

        return response()->json([
            'status' => true,
            'message' => 'You have registered successfully.'
        ]);
    }

    // Show login form
    public function login()
    {
        return view('front.account.login');
    }

    // Handle login authentication
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Redirect based on user type
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('account.profile');
            }
        }

        return redirect()->route('account.login')->with('error', 'Either Email/Password is incorrect');
    }

    // Show user profile
    public function profile()
    {
        $user = Auth::user();
        return view('front.account.profile', compact('user'));
    }

    // Handle profile update
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->designation = $request->designation;
        $user->save();

        // Flash success message
        session()->flash('success', 'Profile updated successfully.');

        // Determine the redirect route based on user type
        $redirectRoute = $user->user_type === 'admin' ? route('admin.dashboard') : route('account.profile');

        return response()->json([
            'status' => true,
            'redirect' => $redirectRoute, // Return the redirect route
            'errors' => []
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5|confirmed', // Ensure new_password matches new_password_confirmation
            'new_password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => ['old_password' => ['The old password does not match our records.']]
            ]);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Flash success message
        session()->flash('success', 'Password updated successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function createJob()
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'asc')->where('status', 1)->get();

        return view('front.account.job.create', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function saveJob(Request $request)
    {
        // Define validation rules
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required|exists:categories,id', // Ensure category exists in the database
            'jobType' => 'required|exists:job_types,id',   // Ensure job type exists in the database
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rules);

        // If validation passes
        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id; // Assuming the user is logged in
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();
 
            // Flash success message
            session()->flash('success', 'Job added successfully!');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            // If validation fails, return errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function myJobs()
    {
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->paginate(10);

        return view('front.account.job.my-jobs', [
            'jobs' => $jobs
        ]);
    }

    public function editJob($id)
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'asc')->where('status', 1)->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        if ($job === null) {
            abort(404);
        }

        return view('front.account.job.edit', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job' => $job
        ]);
    }

    public function updateJob(Request $request, $id)
    {
        // Define validation rules
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required|integer|exists:categories,id', // Validate category is an integer and exists in the categories table
            'jobType' => 'required|integer|exists:job_types,id',   // Validate job type is an integer and exists in the job_types table
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rules);

        // If validation passes
        if ($validator->passes()) {
            $job = Job::find($id);

            // Check if the job exists
            if (!$job) {
                return response()->json([
                    'status' => false,
                    'errors' => ['job' => ['Job not found!']]
                ]);
            }

            // Update the job
            $job->title = $request->title;
            $job->category_id = $request->category; // Assign the category_id
            $job->job_type_id = $request->jobType; // Assign the job_type_id
            $job->user_id = Auth::user()->id; // Assuming the user is logged in
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            // Save the job to the database
            $job->save();

            // Flash success message
            session()->flash('success', 'Job Updated Successfully!');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            // If validation fails, return errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function deleteJob(Request $request)
    {
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();
    
        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found!'
            ]);
        }
        
        $job->delete();  // Delete the job
    
        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully!'  // Add the message here
        ]);
    }
}    