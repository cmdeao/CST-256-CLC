<?php
namespace App\Services\Business;
use App\Services\Data\JobApplicationDAO;

class JobApplicationService
{
    public function createJobApplication($jobID, $userID)
    {
        $service = new JobApplicationDAO();
        return $service->createJobApplication($jobID, $userID);
    }
}

