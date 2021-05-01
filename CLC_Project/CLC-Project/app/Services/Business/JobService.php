<?php
namespace App\Services\Business;
use App\Models\JobPosting;
use App\Services\Data\JobDAO;

class JobService
{
    public function getAllJobs()
    {
        $service = new JobDAO();
        return $service->getAllJobs();
    }
    
    public function findByID($jobID)
    {
        $service = new JobDAO();
        return $service->findByID($jobID);
    }
    
    public function createJobPosting(JobPosting $jobPosting)
    {
        $service = new JobDAO();
        return $service->createJobPosting($jobPosting);
    }
    
    public function deleteJobPosting($jobID)
    {
        $service = new JobDAO();
        return $service->deleteJobPosting($jobID);
    }
}

