<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\functions;
use App\Services\Business\EducationService;
use App\Models\EducationModel;

use App\Services\Business\JobHistoryService;
use App\Models\JobHistory;

use App\Services\Business\SkillsService;


class ResumeController extends Controller
{
    function index()
    {
        
    }
    
    function updateSkills(Request $request) 
    {
        $function = new functions();
        $userID = $function->getUserID();
        $skills = $request->input('skill1');
        $skills = $skills . $request->input('skill2');
        $skills = $skills . $request->input('skill3');
        $skills = $skills . $request->input('skill4');
        $skills = $skills . $request->input('skill5');
        $skills = $skills . $request->input('skill6');
        
        $service = new SkillsService();
        if($service->udpateSkills($skills, $userID))
        {
            return redirect()->action('ProfileController@viewResume');
        }
        else
        {
            echo "Failed to update skills!";
        }
    }
    
    function updateEducation(Request $request)
    {        
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
        
        if(is_null($userEducation))
        {
            if($service->createEducation($updatedEducation))
            {
                echo "Created a new education entry!<br>";
            }
            else
            {
                echo "Failed to create a new education entry!<br>";
            }
        }
        else
        {
            if($service->updateEducation($updatedEducation))
            {
                echo "We've updated the education entry!<br>";
            }
            else
            {
                echo "We failed to update the education entry!<br>";
            }
        }        
        
        return redirect()->action('ProfileController@viewResume');
    }
    
    function updateWorkHistory(Request $request)
    {   
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
        
        if(count($jobHistory) == 0)
        {
            if($service->createJobHistory($updatedJobHistory))
            {
                return redirect()->action('ProfileController@viewResume');
            }
            else
            {
                echo "We failed to create a new job history entry!<br>";
            }
        }
        else
        {
            if($service->updateJobHistory($updatedJobHistory, $userID))
            {
                return redirect()->action('ProfileController@viewResume');
            }
            else
            {
                echo "We feild to update job history!";
            }
        }
    }
}
