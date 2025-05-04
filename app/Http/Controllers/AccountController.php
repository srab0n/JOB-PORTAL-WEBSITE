<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
                'errors' => $validator->errors()
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
}