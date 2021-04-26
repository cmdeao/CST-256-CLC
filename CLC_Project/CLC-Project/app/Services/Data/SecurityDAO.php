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
}

