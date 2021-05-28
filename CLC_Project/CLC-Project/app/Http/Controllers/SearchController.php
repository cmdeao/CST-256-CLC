<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Search controller handles operations for searching for job postings and groups.
 * Logging statements are built in to showcase entry and exit of class and method,
 * along with results of operations and various variables utilized in the method.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\GroupService;
use App\Services\Business\JobService;
use App\Services\Utility\ILoggerService;


class SearchController extends Controller
{
    //Logger variable.
    protected $logger;
    
    //Constructor method to initialize logger
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Search method for retrieving and displaying job postings or groups.
    function searchMethod(Request $request)
    {
        $this->logger->info("Entering SearchController::searchMethod()", null);
        
        //Store submitted search term.
        $searchTerm = $request->input('search');
        
        //Exception handling for operation.
        try 
        {
            //Checking which button was pressed by the user.
            if($request->submit == "jobs")
            {
                //Creating service variable.
                $service = new JobService();
                //Store found job postings based on search term.
                $postings = $service->searchJobs($searchTerm);
                $this->logger->info("Exiting SearchController::searchMethod() with jobs search: ", $searchTerm);
                return view('jobPostAdmin')->with(compact('postings'));
            }
            else if($request->submit == "groups")
            {
                //Creating service variable.
                $service = new GroupService();
                //Store found groups based on search term.
                $groups = $service->searchGroups($searchTerm);
                $this->logger->info("Exiting SearchController::searchMethod() with groups search: ", $searchTerm);
                return view('affinityGroupList')->with(compact('groups'));
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception SearchController::searchMethod() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
    }
}
