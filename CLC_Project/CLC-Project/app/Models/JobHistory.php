<?php
namespace App\Models;

class JobHistory
{
    private $id;
    private $title;
    private $company;
    private $startDate;
    private $endDate;
    private $location;
    private $description;
    private $userID;
    
    public function __construct($id, $title, $company, $startDate, $endDate, 
        $location, $description, $userID)
    {
        $this->id = $id;
        $this->title = $title;
        $this->company = $company;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->location = $location;
        $this->description = $description;
        $this->userID = $userID;
    }
        
    public function getID()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getCompany()
    {
        return $this->company;
    }
    
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    public function getLocation()
    {
        return $this->location;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getUserID()
    {
        return $this->userID;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function setCompany($company)
    {
        $this->company = $company;
    }
    
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
    
    public function setLocation($location)
    {
        $this->location = $location;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
}

