<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Profile DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\UserProfileModel;

class ProfileDAO
{
    //Find profile returns the profile associated with a user ID.
    public function findProfile($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Retrieving values if a row is found.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            //Storing values in a new User Profile Model object.
            $userProfile = new UserProfileModel($row['user_id'], $row['user_address'], $row['user_city'], $row['user_state'],
                $row['user_country'], $row['user_profession'], $row['user_bio'], $row['user_skills'], $row['user_years_experience'],
                $row['user_job_experience'], $row['user_relocation'], $row['user_education']);
            
            //Returing the object.
            return $userProfile;
        }
        else
        {
            return false;
        }
    }
    
//     //Find resume returns a resume of a specific user based on the user ID.
//     public function findResume($userID)
//     {
//         //Establishing connection to the database.
//         $link = new Database();
//         $database = $link->getConnection();
        
//         //Creating SQL query. JOIN statements are used to incorporate multiple
//         //tables into a single query and result.
//         $sql = "SELECT education.school,
//         education.degree,
//         education.field_of_study,
//         education.start_date,
//         education.end_date,
//         job_history.job_title,
//         job_history.company_name,
//         job_history.start_date,
//         job_history.end_date,
//         job_history.job_location,
//         job_history.job_description,
//         users_profiles.user_skills
//         FROM education
//         LEFT JOIN users_profiles ON users_profiles.user_id = 1
//         LEFT JOIN job_history ON job_history.id = 1
//         WHERE education.user_id = 1";
        
//         $result = mysqli_query($database, $sql);
        
//         if(mysqli_num_rows($result) == 1)
//         {
//             $row = $result->fetch_assoc();
//         }
        
//     }
    
    //Create profile will insert a new profile into the database.    
    public function createProfile(UserProfileModel $profile)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values from passed User Profile Model.
        $userID = $profile->getUserID();
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
        
        //Creating SQL insert statement.
        $sql = "INSERT INTO users_profiles(user_id, user_address, user_city, user_state, user_country, user_profession, user_bio, user_skills, user_years_experience,
             user_job_experience, user_relocation, user_education) VALUES ($userID, '$address', '$city', '$state', '$country', '$profession', '$bio', 
                '$skills', $yearsExperience,'$jobExperience', '$relocation', '$education')";
        
        //Executing query. Returning true if operation was successful, else returning false.
        if(mysqli_query($database, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //Update profile will update the profile table for a specifc user.
    public function updateProfile(UserProfileModel $profile)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Prepare SQL statement.
        $sql = $database->prepare("UPDATE users_profiles SET user_address=?, user_city=?, user_state=?, user_country=?, user_profession=?,
            user_bio=?, user_skills=?, user_years_experience=?, user_job_experience=?, user_relocation=?, user_education=? WHERE user_id=?");
        
        //Retrieving values from passed User Profile Model.
        $userID = $profile->getUserID();
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
        
        //Binding paramaters.
        $sql->bind_param("sssssssisisi", $address, $city, $state, $country, $profession, $bio, $skills, $yearsExperience, 
                $jobExperience, $relocation, $education, $userID);
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

