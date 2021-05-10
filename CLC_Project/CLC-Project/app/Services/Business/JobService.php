<?php
namespace App\Services\Business;
use App\Models\JobPosting;
use App\Services\Data\JobDAO;

class JobService
{
    public function searchJobs($term)
    {
        $service = new JobDAO();
        return $service->searchJobs($term);
    }
    
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
    
    public function editPosting(JobPosting $jobPosting)
    {
        $service = new JobDAO();
        return $service->editPosting($jobPosting);
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

