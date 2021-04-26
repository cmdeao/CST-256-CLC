<?php
namespace App\Services\Business;
use App\Models\UserModel;

class functions
{
    public function saveUserID($userID)
    {
        if(!isset($_SESSION))
        {
            session_start();    
        }
        
        $_SESSION["USER_ID"] = $userID;
    }
    
    public function getUserID()
    {
        if(!isset($_SESSION))
        {
            session_start();    
        }
        
        return $_SESSION["USER_ID"];
    }
    
    public function logUser($obj)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        
        $object = new UserModel($obj->getUserID(), $obj->getName(), $obj->getEmail(), $obj->getAge(), $obj->getUsername()
            , $obj->getRole());
        $_SESSION["USER"] = serialize($object);
        
    }
    
    public function getUser()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }

        $object = unserialize($_SESSION["USER"]);
        return $object;
    }
    
    public function saveUserRole($role)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        
        $_SESSION["ROLE"] = $role;
    }
    
    public function getUserRole()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        
        return $_SESSION["ROLE"];
    }
}

