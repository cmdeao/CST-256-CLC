<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\EducationService;
use App\Models\EducationModel;

class EducationController extends Controller
{
    function index()
    {
        echo "Inside EducationController Index<br>";
        $service = new EducationService();
        
        $updatedEducation = new EducationModel(null, "ASDF", "Film", "CST",
            date("Y/m/d H:i:s"), date("Y/m/d H:i:s"), 3.0, "You write movies", 2);
        
        if($service->updateEducation($updatedEducation))
        {
            echo "Updated education for " . $updatedEducation->getUserID() . "<br>";
        }
        else
        {
            echo "Failed to update for " . $updatedEducation->getUserID() . "<br>";
        }
        
//         $foundEducation = $service->getEducation(2);
//         echo "ID: " . $foundEducation->getID() . "<br>";
//         echo "School: " . $foundEducation->getSchool() . "<br>";
//         echo "Degree: " . $foundEducation->getDegree() . "<br>";
//         echo "Study: " . $foundEducation->getStudy() . "<br>";
//         echo "Start Date: " . $foundEducation->getStartDate() . "<br>";
//         echo "End Date: " . $foundEducation->getEndDate() . "<br>";
//         echo "Grade: " . $foundEducation->getGrade() . "<br>";
//         echo "Description: " . $foundEducation->getDescription() . "<br>";
//         echo "User ID: " . $foundEducation->getUserID() . "<br>";
        
        
//         $education = new EducationModel(null, "Grand Canyon", "Programming", "CS",
//             date("Y/m/d H:i:s"), date("Y/m/d H:i:s"), 4.0, "You do stuff", 1);
        
//         echo "ID: " . $education->getID() . "<br>";
//         echo "School: " . $education->getSchool() . "<br>";
//         echo "Degree: " . $education->getDegree() . "<br>";
//         echo "Study: " . $education->getStudy() . "<br>";
//         echo "Start Date: " . $education->getStartDate() . "<br>";
//         echo "End Date: " . $education->getEndDate() . "<br>";
//         echo "Grade: " . $education->getGrade() . "<br>";
//         echo "Description: " . $education->getDescription() . "<br>";
//         echo "User ID: " . $education->getUserID() . "<br>";
        
//         if($service->createEducation($education))
//         {
//             echo "Created a new education entry!<br>";
//         }
//         else
//         {
//             echo "Failed to create a new education entry!<br";
//         }
    }
}
