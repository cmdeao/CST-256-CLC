<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Education service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Models\EducationModel;
use App\Services\Data\EducationDAO;

class EducationService
{
    public function getEducation($userID)
    {
        $service = new EducationDAO();
        return $service->getEducation($userID);
    }
    
    public function createEducation(EducationModel $education)
    {
        $service = new EducationDAO();
        return $service->createEducation($education);
    }
    
    public function updateEducation(EducationModel $education)
    {
        $service = new EducationDAO();
        return $service->updateEducation($education);
    }
}

