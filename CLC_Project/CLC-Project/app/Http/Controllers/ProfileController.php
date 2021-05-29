<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Profile controller handles reqeusts related to viewing a specific profile,
 * viewing a specific resume, and updating a specific profile.
 * Logging statements are built in to showcase entry and exit of class and methods,
 * along with results of operations and various variables utilized in methods.
 */

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
    //Logger variable.
    protected $logger;
    
    //Constructor method to initialize loggertion 
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Index method retrieves logged user's profile.
    function index() 
    {
        $this->logger->info("Entering ProfileController::index()", null);
        
        //Creating service variables.
        $functions = new functions();
        $service = new ProfileService();
        
        //Exception handling for operation.
        try 
        {
            //Retrieving the user's profile.
            $userID = $functions->getUserID();
            $profile = $service->getProfile($userID);
            $this->logger->info("Retrieved profile for user: ", $userID);
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::index() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        //If-statement in the event a user profile does not exits. If false, user is
        //redirected to a view to create their profile.
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
    
    //View resume method to view the resume of the user.
    function viewResume()
    {
        $this->logger->info("Entering ProfileController::viewResume()", null);
        
        //Creating service variables.
        $functions = new functions();
        $service = new ProfileService();
        $userID = $functions->getUserID();
        
        //Exception handling for operation.
        try 
        {
            //Retrieving the user's profile.
            $profile = $service->getProfile($userID);

            //Retrieving the user's education.
            $educationService = new EducationService();
            $education = $educationService->getEducation($userID);
            
            //Retrieving the user's job history.
            $jobService = new JobHistoryService();
            $jobHistory = $jobService->getAllJobHistory($userID);
            
            //Retrieviing the user's skills.
            $skillsService = new SkillsService();
            $skills = $skillsService->getAllSkills($userID);
            $this->logger->info("Retrieved resume for user: ", $userID);
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::viewResume() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        if(is_null($education) || count($jobHistory) == 0 || is_null($skills))
        {
            return view('resume');
        }
        
        //Creating an array of retrieved resume information for display.
        $userData['data'] = [$education->getSchool(), $education->getDegree(),
            $education->getStudy(), $education->getStartDate(), $education->getEndDate(),
            $jobHistory[0][1], $jobHistory[0][0], $jobHistory[0][2], $jobHistory[0][3],
            $jobHistory[0][5], $skills];
        
        $this->logger->info("Exiting ProfileController::viewResume()", null);
        
        return view ('viewResume', $userData);
    }
    
    //Update profile method for updating the user's profile.
    function updateProfile(Request $request)
    {
        $this->logger->info("Entering ProfileController::updateProfile()", null);
        
        //Creating service variables.
        $functions = new functions();
        $service = new ProfileService();

        //Creating new user profile model.
        $userProfile = new UserProfileModel($functions->getUserID(), $request->input('address'), $request->input('city'), $request->input('state'), 
            $request->input('country'), $request->input('profession'), $request->input('bio'), $request->input('skills'), $request->input('yearsExperience'),
        $request->input('jobExperience'), $request->input('relocation'), $request->input('education'));
        
        //Exception handling for operation.
        try 
        {
            //If-statement for retrieving user profile. If false, insert user profile.
            //If insert is false, display error.
            if(!$service->getProfile($functions->getUserID()))
            {
                if(!$service->insertProfile($userProfile))
                {
                    //echo "<br>ERROR!";
                    $this->logger->error("Error inserting profile. ", $functions->getUserID());
                    $message = "Error inserting profile!";
                    $error = ['error'=>$message];
                    return view('error')->with($error);
                }
            }
            
            //If-statement for update operation. Redirects to appropriate view
            //based on result of operation.
            if($service->updateProfile($userProfile))
            {
                $this->logger->info("Exiting ProfileController::updateProfile()", null);
                return redirect()->action('ProfileController@index');
            }
            else
            {
                $this->logger->error("Failed to updated profile. ", $functions->getUserID());
                $message = "Failed to update profile!";
                $error = ['error'=>$message];
                return view('error')->with($error);
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception ProfileController::updateProfile() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
    }
}
