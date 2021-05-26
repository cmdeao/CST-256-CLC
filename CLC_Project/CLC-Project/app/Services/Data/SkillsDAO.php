<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Skills DAO performs operations for retrieving and updating skills.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;

class SkillsDAO
{
    //Get all skills returns the skills of a specific user.
    public function getAllSkills($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT user_skills FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Checking if number of returned rows is 1.
        if(mysqli_num_rows($result) == 1)
        {
            //Retrieving skills.
            $row = $result->fetch_assoc();
            $skills = $row['user_skills'];
            //Returning skills.
            return $skills;
        }
        
        //Returning null if nothing is found.
        return null;
    }
    
    //Update skills will update the skills of a specific user.
    public function updateSkills($skills, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT user_skills FROM users_profiles WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Checking if number of returned rows is 1.
        if(mysqli_num_rows($result) == 1)
        {
            //Preparing SQL statement.
            $sql = $database->prepare("UPDATE users_profiles SET user_skills=? WHERE
                user_id=?");
            //Binding parameters.
            $sql->bind_param("si", $skills, $userID);
            //Executing statement/
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
        else
        {
            //Creating SQL insert statement if no skills exist for a specific user.
            $sql = "INSERT INTO users_profiles(user_skills) VALUES ('$skills') WHERE
                user_id = '$userID'";
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
    }
}

