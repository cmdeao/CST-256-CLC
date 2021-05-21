<?php
namespace App\Services\Data;

use App\Models\SecurityModel;
use App\Models\UserModel;
use App\Services\Data\Database;

class SecurityDAO
{
    public function findUser(SecurityModel $user)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $username = $user->getUsername();
        $password = $user->getPassword();
        
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            
            if($row['banned'] == 1)
            {
                echo "You are banned from the application!";
                return false;
            }
            
            if($row['suspended'] == 1)
            {
                echo "You are currently suspended from the application!";
                return false;
            }
            
            $foundUser = new UserModel($row['id'], $row['name'], $row['email'], $row['age'], $row['username'], $row['role']);
            return $foundUser;
        }
        else
        {
            return false;
        }
    }
    
    public function getAllUsers()
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM users";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $users = array();
        
        while($row = $result->fetch_assoc())
        {
            $users[$index] = array($row['id'], $row['name'], $row['email'], $row['age'],
                $row['username'], $row['created_at'], $row['updated_at'], $row['role'],
                $row['banned'], $row['suspended']);
            ++$index;
        }
        
        $result->free();
        mysqli_close($database);
        
        return $users;
    }
    
    public function findByUserID($id)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $user = new UserModel($row['id'], $row['name'], $row['email'],
                $row['age'], $row['username'], $row['role']);
            
            $result->free();
            mysqli_close($database);
            
            return $user;
        }
        else
        {
            return null;
        }
    }
}

