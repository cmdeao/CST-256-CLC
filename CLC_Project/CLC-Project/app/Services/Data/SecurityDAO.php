<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Sercurity DAO performs operations for retrieving users from the persistent database.
 */

namespace App\Services\Data;

use App\Models\SecurityModel;
use App\Models\UserModel;
use App\Services\Data\Database;

class SecurityDAO
{
    //Find user searches the database for specific user credentials.
    public function findUser(SecurityModel $user)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values from passed model.
        $username = $user->getUsername();
        $password = $user->getPassword();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($database, $sql);
        
        //Checking if number of rows returned is 1.
        if(mysqli_num_rows($result) == 1)
        {
            //Fetching association.
            $row = $result->fetch_assoc();
            
            //Checking if the user is banned.
            if($row['banned'] == 1)
            {
                echo "You are banned from the application!";
                return false;
            }
            
            //Checking if the user is suspended.
            if($row['suspended'] == 1)
            {
                echo "You are currently suspended from the application!";
                return false;
            }
            
            //Creating new User Model object.
            $foundUser = new UserModel($row['id'], $row['name'], $row['email'], $row['age'], $row['username'], $row['role']);
            //Returing new User Model object.
            return $foundUser;
        }
        else
        {
            return false;
        }
    }
    
    //Get all users returns all users within the database.
    public function getAllUsers()
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $users = array();
        
        //Iterating through results and adding users into the array.
        while($row = $result->fetch_assoc())
        {
            $users[$index] = array($row['id'], $row['name'], $row['email'], $row['age'],
                $row['username'], $row['created_at'], $row['updated_at'], $row['role'],
                $row['banned'], $row['suspended']);
            ++$index;
        }
        
        //Freeing results and closing connection.
        $result->free();
        mysqli_close($database);
        
        //Returning array.
        return $users;
    }
    
    //Find by user ID returns a user based on the passed ID.
    public function findByUserID($id)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($database, $sql);
        
        //Checking if number of rows returned is 1.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            //Creating new User Model object.
            $user = new UserModel($row['id'], $row['name'], $row['email'],
                $row['age'], $row['username'], $row['role']);
            
            //Freeing results and closing connection.
            $result->free();
            mysqli_close($database);
            
            //Returning new User Model object.
            return $user;
        }
        else
        {
            return null;
        }
    }
}

