<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job History service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Models\JobHistory;
use App\Services\Data\JobHistoryDAO;

class JobHistoryService
{
    public function getAllJobHistory($userID)
    {
        $service = new JobHistoryDAO();
        return $service->getAllJobHistory($userID);
    }
    
    public function createJobHistory(JobHistory $history)
    {
        $service = new JobHistoryDAO();
        return $service->createJobHistory($history);
    }
    
    public function updateJobHistory(JobHistory $history, $userID)
    {
        $service = new JobHistoryDAO();
        return $service->updateJobHistory($history, $userID);
    }
    
    public function deleteJobHistory($historyID, $userID)
    {
        $service = new JobHistoryDAO();
        return $service->deleteJobHistory($historyID, $userID);
    }
}

