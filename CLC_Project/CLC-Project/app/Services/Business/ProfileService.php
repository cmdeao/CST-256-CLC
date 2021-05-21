<?php
namespace App\Services\Business;
use App\Services\Data\ProfileDAO;
use App\Models\UserProfileModel;

class ProfileService
{
    public function getProfile($userID)
    {
        $service = new ProfileDAO();
        return $service->findProfile($userID);
    }
    
    public function findResume($userID)
    {
        $service = new ProfileDAO();
        return $service->findResume($userID);
    }
    
    public function insertProfile(UserProfileModel $profile)
    {
        $service = new ProfileDAO();
        return $service->createProfile($profile);
    }
    
    public function updateProfile(UserProfileModel $profile)
    {
        $service = new ProfileDAO();
        return $service->updateProfile($profile);
    }
}

