<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Resume controller handles requests related to updating skills, education,
 * and work history for a users resume.
 * Logging statements are built in to showcase entry and exit of class and methods,
 * along with results of operations and various variables utilized in methods.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\functions;
use App\Services\Business\EducationService;
use App\Models\EducationModel;

use App\Services\Business\JobHistoryService;
use App\Models\JobHistory;
use App\Services\Business\SkillsService;
use App\Services\Utility\ILoggerService;


class ResumeController extends Controller
{
    //Logger variable.
    protected $logger;
    
    //Constructor method to initialize logger.
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function index()
    {
        
    }
    
    //Update skills method to update the skills portion of users resume.
    function updateSkills(Request $request) 
    {
        $this->logger->info("Entering ResumeController::updateSkills()", null);
        
        $function = new functions();
        
        //Retrieving user ID and input skills.
        $userID = $function->getUserID();
        $skills = $request->input('skill1');
        $skills = $skills . $request->input('skill2');
        $skills = $skills . $request->input('skill3');
        $skills = $skills . $request->input('skill4');
        $skills = $skills . $request->input('skill5');
        $skills = $skills . $request->input('skill6');
        
        //Creating service variable for access to skills service class.
        $service = new SkillsService();
        
        //Exception handling for operation.
        try 
        {
            //If-statement for updating skills. Redirects to appropriate view
            //based on result of operation.
            if($service->udpateSkills($skills, $userID))
            {
                $this->logger->info("Updated skills for user: ", $userID);
                $this->logger->info("Exiting ResumeController::updateSkills()", null);
                return redirect()->action('ProfileController@viewResume');
            }
            else
            {
                $this->logger->error("Failed to update skills for user: ", $userID);  
                echo "Failed to update skills!";
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::udpateSkilss() ", $e->getMessage());
        }
    }
    
    //Update education method to update the education portion of users resume.
    function updateEducation(Request $request)
    {        
        $this->logger->info("Entering ResumeController::updateEducation()", null);
        //Creating service variables.
        $service = new EducationService();
        $function = new functions();
        $userID = $function->getUserID();
        
        //Retrieving input form information.
        $school = $request->input('school');
        $degree = $request->input('degree');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $study = $request->input('study');
    
        //Creating new education model object.
        $updatedEducation = new EducationModel(null, $school, $degree, 
            $study, $startDate, $endDate, 3.0, "Description...", $userID);
        
        //Retrieving current stored education for user.
        $userEducation = $service->getEducation($userID);
        
        //Exception handling for operation.
        try 
        {
            //Checking if retrieved user education is null.
            if(is_null($userEducation))
            {
                //If user education is null, perform create education operation.
                if($service->createEducation($updatedEducation))
                {
                    //echo "Created a new education entry!<br>";
                    $this->logger->info("Created new education entry for user: ", $userID);
                }
                else
                {
                    //echo "Failed to create a new education entry!<br>";
                    $this->logger->error("Failed to create new education entry for user: ", $userID);
                }
            }
            else
            {
                //If user education is not null, perform update education operation.
                if($service->updateEducation($updatedEducation))
                {
                    //echo "We've updated the education entry!<br>";
                    $this->logger->info("Updated education entry for user: ", $userID);
                }
                else
                {
                    //echo "We failed to update the education entry!<br>";
                    $this->logger->error("Failed to update education entry for user: ", $userID);
                }
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::updateEducation() ", $e->getMessage());
        }
                
        $this->logger->info("Exiting ResumeController::updateEducation()", null);
        return redirect()->action('ProfileController@viewResume');
    }
    
    //Update work history method to update the work history portion of users resume.
    function updateWorkHistory(Request $request)
    {   
        $this->logger->info("Entering ResumeController::updateWorkHistory()", null);
        
        $function = new functions();
        $userID = $function->getUserID();
        
        //Retrieving input form information.
        $title = $request->input('jobtitle');
        $company = $request->input('company');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $description = $request->input('description');
        
        //Creating service variable for access to job history service class.
        $service = new JobHistoryService();
        
        //Creating new job history model object.
        $updatedJobHistory = new JobHistory(null, $title, $company, $startDate,
            $endDate, "Somewhere", $description, $userID);
        
        //Retrieving job history for specific user.
        $jobHistory = $service->getAllJobHistory($userID);
        
        //Exception handling for operation.
        try 
        {
            //Checking the size of the array.
            if(count($jobHistory) == 0)
            {
                //If array count is 0, perform create job history operation.
                if($service->createJobHistory($updatedJobHistory))
                {
                    $this->logger->info("Created job history for user: ", $userID);
                    return redirect()->action('ProfileController@viewResume');
                }
                else
                {
                    echo "We failed to create a new job history entry!<br>";
                    $this->logger->error("Failed to create job history for user: ", $userID);
                }
            }
            else
            {
                //If array count is greater than 0, perform update job history operation.
                if($service->updateJobHistory($updatedJobHistory, $userID))
                {
                    $this->logger->info("Updated job history for user: ", $userID);
                    $this->logger->info("Exiting ResumeController::updateWorkHistory()", null);
                    return redirect()->action('ProfileController@viewResume');
                }
                else
                {
                    echo "We feild to update job history!";
                    $this->logger->error("Failed to update job history for user: ", $userID);
                }
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::updateWorkHistory() ", $e->getMessage());
        }
    }
}
