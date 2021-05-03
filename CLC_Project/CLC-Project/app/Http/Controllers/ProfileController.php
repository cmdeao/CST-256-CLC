<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\ProfileService;
use App\Models\UserProfileModel;
use App\Services\Business\functions;

use App\Services\Business\EducationService;
use App\Services\Business\JobHistoryService;
use App\Services\Business\SkillsService;

class ProfileController extends Controller
{
    function index() 
    {
        $functions = new functions();
        $service = new ProfileService();
        $userID = $functions->getUserID();
        $profile = $service->getProfile($userID);
        
        if(!$profile)
        {
            return view('testProfileTable'); 
        }
        else
        {
            $userData['data'] = [$profile->getUserID(), $profile->getAddress(), $profile->getCity(), $profile->getState(),
                $profile->getCountry(), $profile->getProfession(), $profile->getBio(), $profile->getSkills(), 
                $profile->getYearsExperience(), $profile->getJobExperience(), $profile->getRelocation(), $profile->getEducation()
            ];
            
            return view ('profile', $userData);
        }
    }
    
    function viewResume()
    {
        $functions = new functions();
        $service = new ProfileService();
        $userID = $functions->getUserID();
        //$resume = $service->findResume($userID);
        
        $profile = $service->getProfile($userID);
        
        $educationService = new EducationService();
        $education = $educationService->getEducation($userID);
        
        $jobService = new JobHistoryService();
        $jobHistory = $jobService->getAllJobHistory($userID);
        
        $skillsService = new SkillsService();
        $skills = $skillsService->getAllSkills($userID);
        
        $userData['data'] = [$education->getSchool(), $education->getDegree(),
            $education->getStudy(), $education->getStartDate(), $education->getEndDate(),
            $jobHistory[0][1], $jobHistory[0][0], $jobHistory[0][2], $jobHistory[0][3],
            $jobHistory[0][5], $skills];
        
        return view ('viewResume', $userData);
        
        //echo count($education);
//         for($i = 0; $i < count($education); $i++)
//         {
//             echo $education[$i];
//         }
        //$userData['data'] = [$education[]]
        
//         if(count($jobHistory) == 0)
//         {
//             echo "NO JOB HISTORY";
//         }
//         else
//         {
//             echo "FOUND STUFF";
//         }



//         if(!$profile)
//         {
//             return view('testProfileTable');
//         }
//         else
//         {
//             $userData['data'] = [$profile->getUserID(), $profile->getAddress(), $profile->getCity(), $profile->getState(),
//                 $profile->getCountry(), $profile->getProfession(), $profile->getBio(), $profile->getSkills(),
//                 $profile->getYearsExperience(), $profile->getJobExperience(), $profile->getRelocation(), $profile->getEducation()
//             ];
            
//             return view ('viewResume', $userData);
//         }
    }
    
    function updateProfile(Request $request)
    {
        $functions = new functions();
        $service = new ProfileService();

        
        $userProfile = new UserProfileModel($functions->getUserID(), $request->input('address'), $request->input('city'), $request->input('state'), 
            $request->input('country'), $request->input('profession'), $request->input('bio'), $request->input('skills'), $request->input('yearsExperience'),
        $request->input('jobExperience'), $request->input('relocation'), $request->input('education'));
        
        if(!$service->getProfile($functions->getUserID()))
        {
            if(!$service->insertProfile($userProfile))
            {
                echo "<br>ERROR!";
            }
            
        }
        
        if($service->updateProfile($userProfile))
        {
            return redirect()->action('ProfileController@index');
        }
        else
        {
            echo "<br>We failed to update information!";
        }
    }
}
