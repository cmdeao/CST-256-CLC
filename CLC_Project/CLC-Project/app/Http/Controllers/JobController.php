<?php

namespace App\Http\Controllers;

use App\Services\Business\JobService;
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
}
