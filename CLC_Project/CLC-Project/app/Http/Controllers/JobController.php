<?php

namespace App\Http\Controllers;

use App\Services\Business\JobService;
use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobController extends Controller
{
    function index()
    {
        echo "Inside JobController Index<br>";
        
        $job = new JobPosting(null, date("Y/m/d H:i:s"), "Programmer", "Microsoft", "Office Skills", "You do work");
        
        echo "ID: " . $job->getJobID() . "<br>";
        echo "Post Date: " . $job->getJobPostDate() . "<br>";
        echo "Post Title: " . $job->getPostTitle() . "<br>";
        echo "Company: " . $job->getCompany() . "<br>";
        echo "Skills: " . $job->getSkills() . "<br>";
        echo "Job Details: " . $job->getJobDetails() . "<br>";
        
        $service = new JobService();
        //$service->deleteJobPosting(2);
        //$service->createJobPosting($job);
        $job = $service->findByID(4);
        
        echo "Found Job - ";
        echo "Job Title: " . $job->getPostTitle() . "<br>";
//         $jobs = array();
//         $jobs = $service->getAllJobs();
        
//         echo "Total Jobs in Table: " . count($jobs) . "<br>";
        
//         for($i = 0; $i < count($jobs); $i++)
//         {
//             echo "Post Title: " . $jobs[$i][2] . "<br>";
//         }
    }
    
    function viewPost(Request $request)
    {
        $ID = $request->input('editpost');
        return view('editPost')->with('ID', $ID);
    }
    
    function updatePost(Request $request)
    {
        $service = new JobService();
        
        $jobID = $request->input('jobID');
        $postDate = $request->input('postdate');
        $postTitle = $request->input('title');
        $company = $request->input('company');
        $skills = $request->input('prefskills');
        $details = $request->input('jobdetails');
        
        $updatedJob = new JobPosting($jobID, $postDate, $postTitle, $company, $skills, $details);
        
        if($service->editPosting($updatedJob))
        {
            echo "We've updated the job!";
        }
        else
        {
            echo "We failed to update the job!";
        }
        
        return redirect()->action('AdminController@viewJobs');
    }
    
    function deletePost(Request $request)
    {
        $service = new JobService();
        $postID = $request->input('delete');
        if($service->deleteJobPosting($postID))
        {
            return redirect()->action('AdminController@viewJobs');
        }
    }
    
    function createPost(Request $request)
    {
        $postDate = $request->input('postdate');
        $postTitle = $request->input('jobtitle');
        $company = $request->input('company');
        $skills = $request->input('prefskills');
        $details = $request->input('jobdetails');
        
        $newJob = new JobPosting(null, $postDate, $postTitle, $company,
            $skills, $details);
        
        $service = new JobService();
        if($service->createJobPosting($newJob))
        {
            return redirect()->action('AdminController@viewJobs');
        }
        else
        {
            echo "Failed to create new job!";
        }
    }
    
    function viewJobPosting(Request $request)
    {
        $jobID = $request->input('displayJob');
        $service = new JobService();
        $jobAppService = new JobApplicationService();
        
        $foundJob = $service->findByID($jobID);
        $postDate = $foundJob->getJobPostDate();
        $postTitle = $foundJob->getPostTitle();
        $company = $foundJob->getCompany();
        $skills = $foundJob->getSkills();
        $jobDetails = $foundJob->getJobDetails();
        
        $functions = new functions();
        $userID = $functions->getUserID();
        $applicationStatus = $jobAppService->checkApplication($jobID, $userID);
        
        return view('showJob', array("postDate"=>$postDate, "postTitle"=>$postTitle,
            "company"=>$company, "skills"=>$skills, "jobDetails"=>$jobDetails,
            "jobID"=>$jobID, "applicationStatus"=>$applicationStatus
        ));
    }
}
