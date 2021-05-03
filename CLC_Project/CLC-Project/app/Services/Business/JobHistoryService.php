<?php
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

