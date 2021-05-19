<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\ProfileService;
use App\Models\UserProfileModel;
use App\Services\Business\functions;

use App\Services\Business\EducationService;
use App\Services\Business\JobHistoryService;
use App\Services\Business\SkillsService;
use App\Services\Utility\ILoggerService;

class ProfileController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function index() 
    {
        $this->logger->info("Entering ProfileController::index()", null);
        
        $functions = new functions();
        $service = new ProfileService();
        
        try 
        {
            $userID = $functions->getUserID();
            $profile = $service->getProfile($userID);
            $this->logger->info("Retrieved profile for user: ", $userID);
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::index() ", $e->getMessage());
        }
        
        if(!$profile)
        {
            $this->logger->info("Exiting ProfileController::index() entering testProfileTable", null);
            return view('testProfileTable'); 
        }
        else
        {
            $userData['data'] = [$profile->getUserID(), $profile->getAddress(), $profile->getCity(), $profile->getState(),
                $profile->getCountry(), $profile->getProfession(), $profile->getBio(), $profile->getSkills(), 
                $profile->getYearsExperience(), $profile->getJobExperience(), $profile->getRelocation(), $profile->getEducation()
            ];
            $this->logger->info("Exiting ProfileController::index()", null);
            return view ('profile', $userData);
        }
    }
    
    function viewResume()
    {
        $this->logger->info("Entering ProfileController::viewResume()", null);
        
        $functions = new functions();
        $service = new ProfileService();
        $userID = $functions->getUserID();
        
        try 
        {
            $profile = $service->getProfile($userID);
            
            $educationService = new EducationService();
            $education = $educationService->getEducation($userID);
            
            $jobService = new JobHistoryService();
            $jobHistory = $jobService->getAllJobHistory($userID);
            
            $skillsService = new SkillsService();
            $skills = $skillsService->getAllSkills($userID);
            $this->logger->info("Retrieved resume for user: ", $userID);
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::viewResume() ", $e->getMessage());
        }
        
        
        $userData['data'] = [$education->getSchool(), $education->getDegree(),
            $education->getStudy(), $education->getStartDate(), $education->getEndDate(),
            $jobHistory[0][1], $jobHistory[0][0], $jobHistory[0][2], $jobHistory[0][3],
            $jobHistory[0][5], $skills];
        
        $this->logger->info("Exiting ProfileController::viewResume()", null);
        
        return view ('viewResume', $userData);
    }
    
    function updateProfile(Request $request)
    {
        $this->logger->info("Entering ProfileController::updateProfile()", null);
        $functions = new functions();
        $service = new ProfileService();

        $userProfile = new UserProfileModel($functions->getUserID(), $request->input('address'), $request->input('city'), $request->input('state'), 
            $request->input('country'), $request->input('profession'), $request->input('bio'), $request->input('skills'), $request->input('yearsExperience'),
        $request->input('jobExperience'), $request->input('relocation'), $request->input('education'));
        
        try 
        {
            if(!$service->getProfile($functions->getUserID()))
            {
                if(!$service->insertProfile($userProfile))
                {
                    //echo "<br>ERROR!";
                    $this->logger->error("Error inserting profile. ", $functions->getUserID());
                }
            }
            
            if($service->updateProfile($userProfile))
            {
                $this->logger->info("Exiting ProfileController::updateProfile()", null);
                return redirect()->action('ProfileController@index');
            }
            else
            {
                $this->logger->error("Failed to updated profile. ", $functions->getUserID());
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::updateProfile() ", $e->getMessage());
        }
    }
}
