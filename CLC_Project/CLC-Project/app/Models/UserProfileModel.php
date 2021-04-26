<?php
namespace App\Models;

class UserProfileModel
{
    private $userID;
    private $address;
    private $city;
    private $state;
    private $country;
    private $profession;
    private $bio;
    private $skills;
    private $yearsExperience;
    private $jobExperience;
    private $relocation;
    private $education;
    
    public function __construct($userID, $address, $city, $state, $country, $profession,
        $bio, $skills, $yearsExperience, $jobExperience, $relocation, $education)
    {
        $this->userID = $userID;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->profession = $profession;
        $this->bio = $bio;
        $this->skills = $skills;
        $this->yearsExperience = $yearsExperience;
        $this->jobExperience = $jobExperience;
        $this->relocation = $relocation;
        $this->education = $education;
    }
    
    public function getUserID()
    {
        return $this->userID;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function getProfession()
    {
        return $this->profession;
    }
    
    public function getBio()
    {
        return $this->bio;
    }
    
    public function getSkills()
    {
        return $this->skills;
    }
    
    public function getYearsExperience()
    {
        return $this->yearsExperience;
    }
    
    public function getJobExperience()
    {
        return $this->jobExperience;
    }
    
    public function getRelocation()
    {
        return $this->relocation;
    }
    
    public function getEducation()
    {
        return $this->education;
    }
    
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }
    
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    public function setState($state)
    {
        $this->state = $state;
    }
    
    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    public function setProfession($profession)
    {
        $this->profession = $profession;
    }
    
    public function setBio($bio)
    {
        $this->bio = $bio;
    }
    
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }
    
    public function setYearsExperience($yearsExperience)
    {
        $this->yearsExperience = $yearsExperience;
    }
    
    public function setJobExperience($jobExperience)
    {
        $this->jobExperience = $jobExperience;
    }
    
    public function setRelocation($relocation)
    {
        $this->relocation = $relocation;
    }
    
    public function setEducation($education)
    {
        $this->education = $education;
    }
}

