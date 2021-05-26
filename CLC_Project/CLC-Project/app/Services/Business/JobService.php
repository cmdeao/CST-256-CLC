<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

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

