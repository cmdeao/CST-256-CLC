<?php
namespace App\Services\Data;
use App\Models\UserProfileModel;

class ProfileDAO
{
    public function findProfile($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $userProfile = new UserProfileModel($row['user_id'], $row['user_address'], $row['user_city'], $row['user_state'],
                $row['user_country'], $row['user_profession'], $row['user_bio'], $row['user_skills'], $row['user_years_experience'],
                $row['user_job_experience'], $row['user_relocation'], $row['user_education']);
            
            return $userProfile;
        }
        else
        {
            return false;
        }
    }
    
    public function createProfile(UserProfileModel $profile)
    {
        echo "<br>CREATING PROFILE!";
        $link = new Database();
        $database = $link->getConnection();
        
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
        
        $sql = "INSERT INTO users_profiles(user_id, user_address, user_city, user_state, user_country, user_profession, user_bio, user_skills, user_years_experience,
             user_job_experience, user_relocation, user_education) VALUES ($userID, '$address', '$city', '$state', '$country', '$profession', '$bio', 
                '$skills', $yearsExperience,'$jobExperience', '$relocation', '$education')";
        
        if(mysqli_query($database, $sql))
        {
            echo "<br>RETURNING TRUE";
            return true;
        }
        else
        {
            echo "<br>RETURNING FALSE";
            return false;
        }
    }
    
    public function updateProfile(UserProfileModel $profile)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users_profiles SET user_address=?, user_city=?, user_state=?, user_country=?, user_profession=?,
            user_bio=?, user_skills=?, user_years_experience=?, user_job_experience=?, user_relocation=?, user_education=? WHERE user_id=?");
        
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
        
        $sql->bind_param("sssssssisisi", $address, $city, $state, $country, $profession, $bio, $skills, $yearsExperience, 
                $jobExperience, $relocation, $education, $userID);
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

