<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function updateCompanyInfo(Request $request)
    {
        $employer = Employer::where('user_id', Auth::id())->first();

        if (!$employer) {
            $employer = new Employer();
            $employer->user_id = Auth::id();
        }

        $employer->company_name = $request->company_name;
        $employer->company_location = $request->company_location;
        $employer->company_website = $request->company_website;
        $employer->save();

        return response()->json([
            'status' => true,
            'message' => 'Company information updated successfully'
        ]);
    }
} 