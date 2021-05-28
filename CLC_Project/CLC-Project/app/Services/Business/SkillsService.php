<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Skills service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Services\Data\SkillsDAO;

class SkillsService
{
    public function getAllSkills($userID)
    {
        $service = new SkillsDAO();
        return $service->getAllSkills($userID);
    }
    
    public function udpateSkills($skills, $userID)
    {
        $service = new SkillsDAO();
        return $service->updateSkills($skills, $userID);
    }
}

