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
