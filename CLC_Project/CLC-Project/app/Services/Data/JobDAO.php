<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\JobPosting;

class JobDAO
{
    //Search jobs returns all job postings based on the passed search term.
    public function searchJobs($term)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing resulet set. UNION DISTINCT is utilized to ensure
        //both queries are performed, but no duplicates are returned.
        $sql = "SELECT * FROM job_postings WHERE post_title LIKE " . "'%" . $term . "%'
                UNION DISTINCT 
                SELECT * FROM job_postings WHERE job_details LIKE " . "'%" . $term . "%'";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $jobs = array();
        
        //Iterating through results and adding job postings into array.
        while($row = $result->fetch_assoc())
        {
            $jobs[$index] = array($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            ++$index;
        }
        
        //Returning array.
        return $jobs;
    }
    
    //Get all jobs returns all job postings within the database.
    public function getAllJobs()   
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM job_postings";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $jobs = array();
        
        //Iterating through results and adding job postings into array.
        while($row = $result->fetch_assoc())
        {
            $jobs[$index] = array($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            ++$index;
        }
        
        //Freeing result set and closing connection.
        $result->free();
        mysqli_close($database);
        
        //Returning array.
        return $jobs;
    }
    
    //Find by ID returns the job posting based on the passed job ID.
    public function findByID($jobID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
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
            //Creating new Job Posting Model and returning the object.
            $jobPosting = new JobPosting($row['post_id'], $row['post_date'], $row['post_title'],
                $row['company'], $row['preferred_skills'], $row['job_details']);
            
            $result->free();
            mysqli_close($database);
            
            return $jobPosting;
        }
        
        //Returning null if no job posting is found.
        return null;
    }
    
    //Create job posting creates a new job within the database.
    public function createJobPosting(JobPosting $jobPosting)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values from passed model.
        $jobID = $jobPosting->getJobID();
        $postDate = $jobPosting->getJobPostDate();
        $postTitle = $jobPosting->getPostTitle();
        $company = $jobPosting->getCompany();
        $skills = $jobPosting->getSkills();
        $jobDetails = $jobPosting->getJobDetails();
        
        //Creating SQL query.
        $sql = "INSERT INTO job_postings(post_date, post_title, company, preferred_skills,
            job_details) VALUES ('$postDate', '$postTitle', '$company', '$skills', '$jobDetails')";
        
        //Executing query. Returning true if successful, else returning false.
        if(mysqli_query($database, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //Delete job posting will delete a specific job posting based on the passed ID.
    public function deleteJobPosting($jobID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query.
        $sql = "DELETE FROM job_postings WHERE post_id = '$jobID'";

        //Executing query. Returning true if successful, else returning false.
        if($database->query($sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //Edit posting will update a specific job posting within the database.
    public function editPosting(JobPosting $jobPosting)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing an SQL statement.
        $sql = $database->prepare("UPDATE job_postings SET post_date=?, post_title=?, company=?, preferred_skills=?, 
            job_details=? WHERE post_id=?");
        
        //Retrieving values from passed model.
        $jobID = $jobPosting->getJobID();
        $postDate = $jobPosting->getJobPostDate();
        $postTitle = $jobPosting->getPostTitle();
        $company = $jobPosting->getCompany();
        $skills = $jobPosting->getSkills();
        $details = $jobPosting->getJobDetails();
        
        //Binding paramaters.
        $sql->bind_param("sssssi", $postDate, $postTitle, $company, $skills, $details, $jobID);
        //Executing statement.
        $sql->execute();
        
        //Returning true if operation was successful, else returning false.
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

