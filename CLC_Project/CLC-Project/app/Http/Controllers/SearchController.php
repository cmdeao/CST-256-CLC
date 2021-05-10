<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\GroupService;
use App\Services\Business\JobService;

class SearchController extends Controller
{
    function searchMethod(Request $request)
    {
        $searchTerm = $request->input('search');
        if($request->submit == "jobs")
        {
            //TESTING
            $service = new JobService();
            $postings = $service->searchJobs($searchTerm);
            return view('jobPostAdmin')->with(compact('postings'));
        }
        else if($request->submit == "groups")
        {
            $service = new GroupService();
            $groups = $service->searchGroups($searchTerm);
            return view('affinityGroupList')->with(compact('groups'));
        }
    }
}
