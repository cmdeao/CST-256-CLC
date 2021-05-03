<?php
namespace App\Services\Business;
use App\Models\EducationModel;
use App\Services\Data\EducationDAO;

class EducationService
{
    public function getEducation($userID)
    {
        $service = new EducationDAO();
        return $service->getEducation($userID);
    }
    
    public function createEducation(EducationModel $education)
    {
        $service = new EducationDAO();
        return $service->createEducation($education);
    }
    
    public function updateEducation(EducationModel $education)
    {
        $service = new EducationDAO();
        return $service->updateEducation($education);
    }
}

