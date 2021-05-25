<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Application controller handles the operation of creating a new job application.
 * Logging statements are built in to showcase entry and exit of class and method,
 * along with results of operations and various variables utilized in the method.
 */

namespace App\Http\Controllers;

use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    //Logger variable
    protected $logger;
    
    //Constructor method to initialize logger
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Index method, utilized solely for testing.
    function index()
    {
//         $service = new JobApplicationService();
//         $service->createJobApplication(1, 1);
    }
    
    //Job application method to store a job application from a specific user.
    function jobApplication(Request $request)
    {
        $this->logger->info("Entering ApplicationController::jobApplication()", null);
        $jobID = $request->input('jobID');
        //Creating service variables for functions() and JobApplicationService()
        $functions = new functions();
        $service = new JobApplicationService();
        $userID = $functions->getUserID();
        
        //Exception handling for operation.
        try 
        {
            //If-statement for creating a job application. Redirects to appropriate view
            //based on result of operation.
            if($service->createJobApplication($jobID, $userID))
            {
                $this->logger->info("Create job application values: ", array("JobID"=>$jobID,
                    "User ID"=>$userID));
                $this->logger->info("Exiting ApplicationController::jobApplication()", null);
                return view('home');
            }
            else
            {
                echo "Failed to create job application!<br>";
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ApplicationController::jobApplication() ", $e->getMessage());   
        }
    }
}
