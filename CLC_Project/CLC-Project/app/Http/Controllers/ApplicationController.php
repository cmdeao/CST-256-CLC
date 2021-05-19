<?php

namespace App\Http\Controllers;

use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function index()
    {
        $service = new JobApplicationService();
        $service->createJobApplication(1, 1);
    }
    
    function jobApplication(Request $request)
    {
        $this->logger->info("Entering ApplicationController::jobApplication()", null);
        $jobID = $request->input('jobID');
        $functions = new functions();
        $service = new JobApplicationService();
        $userID = $functions->getUserID();
        
        try 
        {
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
        catch (Exception $e) 
        {
            $this->logger->error("Exception ApplicationController::jobApplication() ", $e->getMessage());   
        }
    }
}
