<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job Application service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Services\Data\JobApplicationDAO;

class JobApplicationService
{
    public function createJobApplication($jobID, $userID)
    {
        $service = new JobApplicationDAO();
        return $service->createJobApplication($jobID, $userID);
    }
    
    public function checkApplication($jobID, $userID)
    {
        $service = new JobApplicationDAO();
        return $service->checkApplication($jobID, $userID);
    }
}

