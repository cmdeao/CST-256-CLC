<?php
namespace App\Services\Data;

class SkillsDAO
{
    public function getAllSkills($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT user_skills FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $skills = $row['user_skills'];
            return $skills;
        }
        
        return null;
    }
    
    public function updateSkills($skills, $userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT user_skills FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $sql = $database->prepare("UPDATE users_profiles SET user_skills=? WHERE
                user_id=?");
            $sql->bind_param("si", $skills, $userID);
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
        else
        {
            $sql = "INSERT INTO users_profiles(user_skills) VALUES ('$skills') WHERE
                user_id = '$userID'";
            if(mysqli_query($database, $sql))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        
//         $sql = "INSERT INTO users_profiles(user_skills) VALUES ('$skills')";
        
//         if(mysqli_query($database, $sql))
//         {
//             return true;
//         }
//         else
//         {
//             return false;
//         }
    }
}

