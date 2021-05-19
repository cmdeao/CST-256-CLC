<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\GroupService;
use App\Services\Business\JobService;
use App\Services\Utility\ILoggerService;


class SearchController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function searchMethod(Request $request)
    {
        $this->logger->info("Entering SearchController::searchMethod()", null);
        
        $searchTerm = $request->input('search');
        
        try 
        {
            if($request->submit == "jobs")
            {
                $service = new JobService();
                $postings = $service->searchJobs($searchTerm);
                $this->logger->info("Exiting SearchController::searchMethod() with jobs search: ", $searchTerm);
                return view('jobPostAdmin')->with(compact('postings'));
            }
            else if($request->submit == "groups")
            {
                $service = new GroupService();
                $groups = $service->searchGroups($searchTerm);
                $this->logger->info("Exiting SearchController::searchMethod() with groups search: ", $searchTerm);
                return view('affinityGroupList')->with(compact('groups'));
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception SearchController::searchMethod() ", $e->getMessage());
        }
    }
}
