<?php

namespace App\Http\Controllers;

use App\Services\Business\JobService;
use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Services\Utility\ILoggerService;

class JobController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
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
        $this->logger->info("Entering JobController::viewPost() ", $ID);
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
        
        $this->logger->info("Entering JobController::updatePost() ", $jobID);
        
        $updatedJob = new JobPosting($jobID, $postDate, $postTitle, $company, $skills, $details);
        
        try 
        {
            if($service->editPosting($updatedJob))
            {
                $this->logger->info("Updated job posting: ", $jobID);
            }
            else
            {
                $this->logger->error("Error occurred JobController::updatePost() ", $jobID);
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::updatePost() ", $e->getMessage());   
        }
        
        $this->logger->info("Exiting JobController::updatePost() ", null);
        return redirect()->action('AdminController@viewJobs');
    }
    
    function deletePost(Request $request)
    {
        $this->logger->info("Entering JobController::deletePost() ", null);
        $service = new JobService();
        $postID = $request->input('delete');
        
        try 
        {
            if($service->deleteJobPosting($postID))
            {
                $this->logger->info("Deleted job posting: ", $postID);
                $this->logger->info("Exiting JobController::deletePost() ", null);
                return redirect()->action('AdminController@viewJobs');
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::deletePost() ", $e->getMessage());   
        }
    }
    
    function createPost(Request $request)
    {
        $this->logger->info("Entering JobController::createPost() ", null);
        $postDate = $request->input('postdate');
        $postTitle = $request->input('jobtitle');
        $company = $request->input('company');
        $skills = $request->input('prefskills');
        $details = $request->input('jobdetails');
        
        $newJob = new JobPosting(null, $postDate, $postTitle, $company,
            $skills, $details);
        
        $service = new JobService();
        
        try 
        {
            if($service->createJobPosting($newJob))
            {
                $this->logger->info("Created new job posting.", null);
                $this->logger->info("Exiting JobController::createPost(). ", null);
                return redirect()->action('AdminController@viewJobs');
            }
            else
            {
                $this->logger->error("Error occurred creating new job posting.", null);
                echo "Failed to create new job!";
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::createPost() ", $e->getMessage());   
        }
    }
    
    function viewJobPosting(Request $request)
    {
        $this->logger->info("Entering JobController::viewJobPosting() ", null);
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
        
        $this->logger->info("Exiting JobController::createPost() ", null);
        return view('showJob', array("postDate"=>$postDate, "postTitle"=>$postTitle,
            "company"=>$company, "skills"=>$skills, "jobDetails"=>$jobDetails,
            "jobID"=>$jobID, "applicationStatus"=>$applicationStatus
        ));
    }
}
