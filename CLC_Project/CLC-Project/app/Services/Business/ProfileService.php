<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Profile service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

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

