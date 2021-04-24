<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\ProfileService;
use App\Models\UserProfileModel;
use App\Services\Business\functions;

class ProfileController extends Controller
{
    function index() 
    {
        
        $service = new ProfileService();
        $profile = $service->getProfile(1);
        
        echo "Profession: " . $profile->getProfession() . "<br>";
        
        $userData['data'] = [$profile->getUserID(), $profile->getAddress(), $profile->getCity(), $profile->getState(),
            $profile->getCountry(), $profile->getProfession(), $profile->getBio(), $profile->getSkills(), 
            $profile->getYearsExperience(), $profile->getJobExperience(), $profile->getRelocation(), $profile->getEducation()
        ];
        
        return view('profileOutputTest', $userData);
    }
    
    function updateProfile(Request $request)
    {
        $functions = new functions();
        $service = new ProfileService();
        
//         $userProfile = new UserProfileModel(9, $request->input('address'), $request->input('city'), $request->input('state'),
//             $request->input('country'), $request->input('profession'), $request->input('bio'), $request->input('skills'), $request->input('yearsExperience'),
//             $request->input('jobExperience'), $request->input('relocation'), $request->input('education'));

//         $userProfile = new UserProfileModel(8, '123 Drive', 'Testing', 'New York', 'United States', 'Manager', 'I manage people!', 'Microsoft Word', 15,
//         'Worked here:', 1, 'School:');
        
        $userProfile = new UserProfileModel(10, $request->input('address'), $request->input('city'), $request->input('state'), 
            $request->input('country'), $request->input('profession'), $request->input('bio'), $request->input('skills'), $request->input('yearsExperience'),
        $request->input('jobExperience'), $request->input('relocation'), $request->input('education'));
        
        if(!$service->getProfile(10))
        {
            echo "<br>We didn't find your profile!";
            if($service->insertProfile($userProfile))
            {
                echo "<br>We've created a profile!";
            }
            else
            {
                echo "<br>ERROR!";
            }
            exit;
        }
        
        if($service->updateProfile($userProfile))
        {
            echo "<br>We've updated the information!";
        }
        else
        {
            echo "<br>We failed to update information!";
        }
    }
}
