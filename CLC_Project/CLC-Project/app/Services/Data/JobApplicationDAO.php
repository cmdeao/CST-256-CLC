<?php
namespace App\Services\Data;
use App\Models\UserProfileModel;

class JobApplicationDAO
{
    public function createJobApplication($jobID, $userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        $username = null;
        
        if($this->checkApplication($jobID, $userID))
        {
            echo "You already submit an application!";
            return false;
        }
        
        $sql = "SELECT * FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
         
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $profile = new UserProfileModel($row['user_id'], $row['user_address'], $row['user_city'], $row['user_state'],
                $row['user_country'], $row['user_profession'], $row['user_bio'], $row['user_skills'], $row['user_years_experience'],
                $row['user_job_experience'], $row['user_relocation'], $row['user_education']);
        }
        
        $sql = "SELECT name FROM users WHERE id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $username = $row['name'];
        }
        
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
        
        $sql = "INSERT INTO job_application (user_id, job_post_id, applicant_name,
            user_address, user_city, user_state, user_country, user_profession, user_skills,
            user_years_experience, user_job_experience, user_relocation, user_education) VALUES 
            ('$userID', '$jobID','$username', '$address', '$city', '$state', '$country', '$profession',
                '$skills', '$yearsExperience', '$jobExperience','$relocation','$education')";

        if(mysqli_query($database, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function checkApplication($jobID, $userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM job_application WHERE job_post_id = '$jobID' AND user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
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

