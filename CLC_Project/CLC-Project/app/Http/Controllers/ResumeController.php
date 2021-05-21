<?php

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
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function index()
    {
        
    }
    
    function updateSkills(Request $request) 
    {
        $this->logger->info("Entering ResumeController::updateSkills()", null);
        
        $function = new functions();
        $userID = $function->getUserID();
        $skills = $request->input('skill1');
        $skills = $skills . $request->input('skill2');
        $skills = $skills . $request->input('skill3');
        $skills = $skills . $request->input('skill4');
        $skills = $skills . $request->input('skill5');
        $skills = $skills . $request->input('skill6');
        
        $service = new SkillsService();
        
        try 
        {
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
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::udpateSkilss() ", $e->getMessage());
        }
    }
    
    function updateEducation(Request $request)
    {        
        $this->logger->info("Entering ResumeController::updateEducation()", null);
        $service = new EducationService();
        $function = new functions();
        $userID = $function->getUserID();
        
        $school = $request->input('school');
        $degree = $request->input('degree');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $study = $request->input('study');
        
        $updatedEducation = new EducationModel(null, $school, $degree, 
            $study, $startDate, $endDate, 3.0, "Description...", $userID);
        
        $userEducation = $service->getEducation($userID);
        
        try 
        {
            if(is_null($userEducation))
            {
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
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::updateEducation() ", $e->getMessage());
        }
                
        $this->logger->info("Exiting ResumeController::updateEducation()", null);
        return redirect()->action('ProfileController@viewResume');
    }
    
    function updateWorkHistory(Request $request)
    {   
        $this->logger->info("Entering ResumeController::updateWorkHistory()", null);
        
        $function = new functions();
        $userID = $function->getUserID();
        
        $title = $request->input('jobtitle');
        $company = $request->input('company');
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $description = $request->input('description');
        
        $service = new JobHistoryService();
        
        $updatedJobHistory = new JobHistory(null, $title, $company, $startDate,
            $endDate, "Somewhere", $description, $userID);
        
        $jobHistory = $service->getAllJobHistory($userID);
        
        try 
        {
            if(count($jobHistory) == 0)
            {
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
        catch (Exception $e) 
        {
            $this->logger->error("Exception ResumeController::updateWorkHistory() ", $e->getMessage());
        }
    }
}
