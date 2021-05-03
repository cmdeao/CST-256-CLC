<?php
namespace App\Models;

class EducationModel
{
    private $id;
    private $school;
    private $degree;
    private $study;
    private $startDate;
    private $endDate;
    private $grade;
    private $description;
    private $userID;
    
    public function __construct($id, $school, $degree, $study, $startDate, $endDate,
            $grade, $description, $userID)
    {
        $this->id = $id;
        $this->school = $school;
        $this->degree = $degree;
        $this->study = $study;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->grade = $grade;
        $this->description = $description;
        $this->userID = $userID;
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getSchool()
    {
        return $this->school;
    }
    
    public function getDegree()
    {
        return $this->degree;
    }
    
    public function getStudy()
    {
        return $this->study;
    }
    
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    public function getGrade()
    {
        return $this->grade;
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
    
    public function setSchool($school)
    {
        $this->school = $school;
    }
    
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }
    
    public function setStudy($study)
    {
        $this->study = $study;
    }
    
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
    
    public function setGrade($grade)
    {
        $this->grade = $grade;
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

