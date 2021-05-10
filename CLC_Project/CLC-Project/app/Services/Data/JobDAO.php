<?php
namespace App\Services\Data;
use App\Models\JobPosting;

class JobDAO
{
    public function searchJobs($term)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM job_postings WHERE post_title LIKE " . "'%" . $term . "%'";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $jobs = array();
        
        while($row = $result->fetch_assoc())
        {
            $jobs[$index] = array($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            ++$index;
        }
        
        return $jobs;
    }
    
    public function getAllJobs()   
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM job_postings";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $jobs = array();
        
        while($row = $result->fetch_assoc())
        {
            $jobs[$index] = array($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            ++$index;
        }
        
        $result->free();
        mysqli_close($database);
        
        return $jobs;
    }
    
    public function findByID($jobID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM job_postings WHERE post_id = '$jobID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 0)
        {
            $result->free();
            mysqli_close($database);
        }
        elseif(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $jobPosting = new JobPosting($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            
            $result->free();
            mysqli_close($database);
            
            return $jobPosting;
        }
        
        return null;
    }
    
    public function createJobPosting(JobPosting $jobPosting)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $jobID = $jobPosting->getJobID();
        $postDate = $jobPosting->getJobPostDate();
        $postTitle = $jobPosting->getPostTitle();
        $company = $jobPosting->getCompany();
        $skills = $jobPosting->getSkills();
        $jobDetails = $jobPosting->getJobDetails();
        
        $sql = "INSERT INTO job_postings(post_date, post_title, company, preferred_skills,
            job_details) VALUES ('$postDate', '$postTitle', '$company', '$skills', '$jobDetails')";
        
        if(mysqli_query($database, $sql))
        {
            echo "Created: " . $jobPosting->getPostTitle() . "<br>";
            return true;
        }
        else
        {
            echo "Failed to create: " . $jobPosting->getPostTitle() . "<br>";
            return false;
        }
    }
    
    public function deleteJobPosting($jobID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "DELETE FROM job_postings WHERE post_id = '$jobID'";
        
        if($database->query($sql))
        {
            echo "Deleted Job Posting: '$jobID'";
            return true;
        }
        else
        {
            echo "Failed to delete Job Posting: '$jobID'";
            return false;
        }
    }
    
    public function editPosting(JobPosting $jobPosting)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE job_postings SET post_date=?, post_title=?, company=?, preferred_skills=?, 
            job_details=? WHERE post_id=?");
        
        $jobID = $jobPosting->getJobID();
        $postDate = $jobPosting->getJobPostDate();
        $postTitle = $jobPosting->getPostTitle();
        $company = $jobPosting->getCompany();
        $skills = $jobPosting->getSkills();
        $details = $jobPosting->getJobDetails();
        
        $sql->bind_param("sssssi", $postDate, $postTitle, $company, $skills, $details, $jobID);
        $sql->execute();
        
        if($sql)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

