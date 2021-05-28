<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job controller handles requests related to viewing a specific job posting,
 * updating a job posting, deleting a job posting, and creating a job posting.
 * Logging statements are built in to showcase entry and exit of class and methods,
 * along with results of operations and various variables utilized in methods.
 */

namespace App\Http\Controllers;

use App\Services\Business\JobService;
use App\Services\Business\JobApplicationService;
use App\Services\Business\functions;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Services\Utility\ILoggerService;

class JobController extends Controller
{
    //Logger variable
    protected $logger;
    
    //Constructor method to initialize logger.
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Index method exists solely for testing purposes.
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
    
    //View post method to showcase a specific job posting.
    function viewPost(Request $request)
    {
        $ID = $request->input('editpost');
        $this->logger->info("Entering JobController::viewPost() ", $ID);
        return view('editPost')->with('ID', $ID);
    }
    
    //Update post method for admins to update a specific job posting.
    function updatePost(Request $request)
    {
        //Creating service variable to access job service class.
        $service = new JobService();
       
        //Retrieving all form fields and storing within variables.
        $jobID = $request->input('jobID');
        $postDate = $request->input('postdate');
        $postTitle = $request->input('title');
        $company = $request->input('company');
        $skills = $request->input('prefskills');
        $details = $request->input('jobdetails');
        
        $this->logger->info("Entering JobController::updatePost() ", $jobID);
        
        //Creating updating job posting model.
        $updatedJob = new JobPosting($jobID, $postDate, $postTitle, $company, $skills, $details);
        
        //Exception handling for operation.
        try 
        {
            //If-statement for editing a job posting.
            if($service->editPosting($updatedJob))
            {
                $this->logger->info("Updated job posting: ", $jobID);
            }
            else
            {
                $this->logger->error("Error occurred JobController::updatePost() ", $jobID);
                $message = "Error occurred!";
                $error = ['error'=>$message];
                return view('error')->with($error);
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::updatePost() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        $this->logger->info("Exiting JobController::updatePost() ", null);
        return redirect()->action('AdminController@viewJobs');
    }
    
    //Deletion method for delelting a specific job posting.
    function deletePost(Request $request)
    {
        $this->logger->info("Entering JobController::deletePost() ", null);
        
        //Creating service variable to access job service class.
        $service = new JobService();
        $postID = $request->input('delete');
        
        //Exception handling for operation.
        try 
        {
            if($service->deleteJobPosting($postID))
            {
                $this->logger->info("Deleted job posting: ", $postID);
                $this->logger->info("Exiting JobController::deletePost() ", null);
                return redirect()->action('AdminController@viewJobs');
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::deletePost() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
    }
    
    //Create posting method for creating a new job posting.
    function createPost(Request $request)
    {
        $this->logger->info("Entering JobController::createPost() ", null);
        
        //Retrieving all form fields and storing within variables.
        $postDate = $request->input('postdate');
        $postTitle = $request->input('jobtitle');
        $company = $request->input('company');
        $skills = $request->input('prefskills');
        $details = $request->input('jobdetails');
        
        //Creating new job posting model with passed data.
        $newJob = new JobPosting(null, $postDate, $postTitle, $company,
            $skills, $details);
        
        //Creating service variable to access job service class.
        $service = new JobService();
        
        //Exception handling for operation.
        try 
        {
            //If-statement for creating job posting. Redirects to appropriate view
            //based on result of operation.
            if($service->createJobPosting($newJob))
            {
                $this->logger->info("Created new job posting.", null);
                $this->logger->info("Exiting JobController::createPost(). ", null);
                return redirect()->action('AdminController@viewJobs');
            }
            else
            {
                $this->logger->error("Error occurred creating new job posting.", null);
                $message = "Failed to create new job!";
                $error = ['error'=>$message];
                return view('error')->with($error);
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception JobController::createPost() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
    }
    
    //View job posting method for viewing a specific job posting.
    function viewJobPosting(Request $request)
    {
        $this->logger->info("Entering JobController::viewJobPosting() ", null);
        $jobID = $request->input('displayJob');
        
        //Creating service variables.
        $service = new JobService();
        $jobAppService = new JobApplicationService();
        
        //Retrieving information from service and returned object.
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
