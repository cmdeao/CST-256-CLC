<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Admin DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\UserModel;

class AdminDAO
{
    //Get all users method returns all users stored within the database.
    public function getAllUsers()
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT id, name, email, age, username, role, banned, suspended FROM users";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $users = array();
        
        //Iterating through results and adding users into the array.
        while($row = $result->fetch_assoc())
        {
            $users[$index] = array($row['id'], $row['name'], $row['email'], $row['age'],
                $row['username'], $row['role'], $row['banned'], $row['suspended']);
            ++$index;
        }
        
        //Freeing result set and closing connection.
        $result->free();
        mysqli_close($database);
        
        //Returning array.
        return $users;
    }
    
    //Find by ID returns a user based on the pased user ID.
    public function findByID($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM users WHERE id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Check if returned rows is 0.
        if(mysqli_num_rows($result) == 0)
        {
            //Freeing result set and closing connection.
            $result->free();
            mysqli_close($database);
        }
        elseif(mysqli_num_rows($result) == 1)
        {
            //Fetching results.
            $row = $result->fetch_assoc();
            //Creating new User Model with retrieved data.
            $user = new UserModel($row['id'], $row['name'], $row['email'], $row['age'], $row['username']);
            //Freeing result set and closing conneciton.
            $result->free();
            mysqli_close($database);
            //Returning User Model object.
            return $user;
        }
        
        //Returning null if no results are found.
        return null;
    }
    
    //Suspend user updates the suspended column based on the passed user ID.
    public function suspendUser($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing an SQL query.
        $sql = $database->prepare("UPDATE users SET suspended=1 WHERE id=?");
        //Binding the paramater to the query.
        $sql->bind_param('i', $userID);
        //Executing query.
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
    
    //Unsuspend user will unsuspend a user from the database based on the passed user ID.
    public function unsuspendUser($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing SQL query.
        $sql = $database->prepare("UPDATE users SET suspended=0 WHERE id=?");
        //Binding the parameter.
        $sql->bind_param('i', $userID);
        //Executing the query.
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
    
    //Ban user will update the banned column within the database based on the passed user ID.
    public function banUser($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing SQL query.
        $sql = $database->prepare("UPDATE users SET banned=1 WHERE id=?");
        //Binding the parameter.
        $sql->bind_param('i', $userID);
        //Executing the query.
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
    
    //Unban user will update the banned column within the database based on the passed user ID.
    public function unbanUser($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing SQL statement.
        $sql = $database->prepare("UPDATE users SET banned=0 WHERE id=?");
        //Binding the parameter.
        $sql->bind_param('i', $userID);
        //Executing the query.
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
    
    //Update role will update the role column based on the passed user ID 
    //and passed role number.
    public function updateRole($role, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing SQL statement.
        $sql = $database->prepare("UPDATE users SET role=? WHERE id=?");
        //Binding parameters.
        $sql->bind_param('ii', $role, $userID);
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
    
    //Delete user will delete users information from the database based on the passed user ID.
    public function deleteUser($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating query to retrieve user profile.
        $query = mysqli_query($database, "SELECT * FROM users_profiles WHERE user_id = '$userID'");
        
        //Checking number of returned rows for user profile.
        if(mysqli_num_rows($query) > 0)
        {
            //Creating query to delete user profile from the database.
            $sql = "DELETE FROM users_profiles WHERE user_id = '$userID'";
            //Returning false if the query failed.
            if(!$database->query($sql))
            {
                return false;
            }
        }
        
        //Creating query to delete user from the users table.
        $sql = "DELETE FROM users WHERE id = '$userID'";
        
        //Returning true if operation was successful, else returning false.
        if($database->query($sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

