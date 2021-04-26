<?php
namespace App\Models;

class UserModel
{
    private $userID;
    private $name;
    private $email;
    private $age;
    private $username;
    private $role;
    
    public function __construct($userID, $name, $email, $age, $username, $role)
    {
        $this->userID = $userID;
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        $this->username = $username;
        $this->role = $role;
    }
    
    public function getUserID()
    {
        return $this->userID;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getAge()
    {
        return $this->age;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function setAge($age)
    {
        $this->age = $age;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function setRole($role)
    {
        $this->role = $role;
    }
}

