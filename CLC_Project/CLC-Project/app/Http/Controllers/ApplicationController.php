<?php

namespace App\Http\Controllers;

use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    function index()
    {
        $service = new JobApplicationService();
        $service->createJobApplication(1, 1);
    }
    
    function jobApplication(Request $request)
    {
        $jobID = $request->input('jobID');
        $functions = new functions();
        $service = new JobApplicationService();
        $userID = $functions->getUserID();
        
        if($service->createJobApplication($jobID, $userID))
        {
            return view('home');
        }
        else
        {
            echo "Failed to create job application!<br>";
        }
    }
}
