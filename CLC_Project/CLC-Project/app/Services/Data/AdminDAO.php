<?php
namespace App\Services\Data;
use App\Models\UserModel;

class AdminDAO
{
    public function getAllUsers()
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT id, name, email, age, username, role, banned, suspended FROM users";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $users = array();
        
        while($row = $result->fetch_assoc())
        {
            $users[$index] = array($row['id'], $row['name'], $row['email'], $row['age'],
                $row['username'], $row['role'], $row['banned'], $row['suspended']);
            ++$index;
        }
        
        $result->free();
        mysqli_close($database);
        
        return $users;
    }
    
    public function findByID($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM users WHERE id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 0)
        {
            $result->free();
            mysqli_close($database);
        }
        elseif(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $user = new UserModel($row['id'], $row['name'], $row['email'], $row['age'], $row['username']);
            $result->free();
            mysqli_close($database);
            return $user;
        }
        
        return null;
    }
    
    public function suspendUser($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users SET suspended=1 WHERE id=?");
        $sql->bind_param('i', $userID);
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
    
    public function unsuspendUser($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users SET suspended=0 WHERE id=?");
        $sql->bind_param('i', $userID);
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
    
    public function banUser($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users SET banned=1 WHERE id=?");
        $sql->bind_param('i', $userID);
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
    
    public function unbanUser($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users SET banned=0 WHERE id=?");
        $sql->bind_param('i', $userID);
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
    
    public function updateRole($role, $userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE users SET role=? WHERE id=?");
        $sql->bind_param('ii', $role, $userID);
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
    
    public function deleteUser($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $query = mysqli_query($database, "SELECT * FROM users_profiles WHERE user_id = '$userID'");
        
        if(mysqli_num_rows($query) > 0)
        {
            $sql = "DELETE FROM users_profiles WHERE user_id = '$userID'";
            if(!$database->query($sql))
            {
                return false;
            }
        }
        
        $sql = "DELETE FROM users WHERE id = '$userID'";
        
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

