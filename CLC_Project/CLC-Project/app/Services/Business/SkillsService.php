<?php
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

