<?php
namespace App\Models;

class JobPosting
{
    private $jobID;
    private $postDate;
    private $postTitle;
    private $company;
    private $skills;
    private $jobDetails;
    
    public function __construct($jobID, $postDate, $postTitle, $company, $skills, $jobDetails)
    {
        $this->jobID = $jobID;
        $this->postDate = $postDate;
        $this->postTitle = $postTitle;
        $this->company = $company;
        $this->skills = $skills;
        $this->jobDetails = $jobDetails;
    }
    
    public function getJobID()
    {
        return $this->jobID;
    }
    
    public function getJobPostDate()
    {
        return $this->postDate;
    }
    
    public function getPostTitle()
    {
        return $this->postTitle;
    }
    
    public function getCompany()
    {
        return $this->company;
    }
    
    public function getSkills()
    {
        return $this->skills;
    }
    
    public function getJobDetails()
    {
        return $this->jobDetails;
    }
    
    public function setJobID($jobID)
    {
        $this->jobID = $jobID;
    }
    
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    }
    
    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;
    }
    
    public function setCompany($company)
    {
        $this->company = $company;
    }
    
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }
    
    public function setJobDetails($jobDetails)
    {
        $this->jobDetails = $jobDetails;
    }
}

