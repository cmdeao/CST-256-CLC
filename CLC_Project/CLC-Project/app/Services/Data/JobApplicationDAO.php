<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job Application DAO performs operations for inserting a new job application,
 * and checking the status of a job application.
 */

namespace App\Services\Data;
use App\Models\UserProfileModel;

class JobApplicationDAO
{
    //Create job application inserts a new job application into the database.
    public function createJobApplication($jobID, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        $username = null;
        
        //Checking if an application for the user ID already exists.
        if($this->checkApplication($jobID, $userID))
        {
            echo "You already submit an application!";
            return false;
        }
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
         
        //Retrieving user profile information and storing within new
        //User Profile Model.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $profile = new UserProfileModel($row['user_id'], $row['user_address'], $row['user_city'], $row['user_state'],
                $row['user_country'], $row['user_profession'], $row['user_bio'], $row['user_skills'], $row['user_years_experience'],
                $row['user_job_experience'], $row['user_relocation'], $row['user_education']);
        }
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT name FROM users WHERE id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Retrieving username from the users table based on passed user ID.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $username = $row['name'];
        }
        
        //Storing values in variables.
        $address = $profile->getAddress();
        $city = $profile->getCity();
        $state = $profile->getState();
        $country = $profile->getCountry();
        $profession = $profile->getProfession();
        $bio = $profile->getBio();
        $skills = $profile->getSkills();
        $yearsExperience = $profile->getYearsExperience();
        $jobExperience = $profile->getJobExperience();
        $relocation = $profile->getRelocation();
        $education = $profile->getEducation();
        
        //SQL query to insert data into the table.
        $sql = "INSERT INTO job_application (user_id, job_post_id, applicant_name,
            user_address, user_city, user_state, user_country, user_profession, user_skills,
            user_years_experience, user_job_experience, user_relocation, user_education) VALUES 
            ('$userID', '$jobID','$username', '$address', '$city', '$state', '$country', '$profession',
                '$skills', '$yearsExperience', '$jobExperience','$relocation','$education')";

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
    
    //Check application checks if a user has submitted an application for a job.
    public function checkApplication($jobID, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM job_application WHERE job_post_id = '$jobID' AND user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Returing true if row is found, else returning false.
        if(mysqli_num_rows($result) == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

