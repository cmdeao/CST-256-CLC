<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\EducationService;
use App\Models\EducationModel;

class EducationController extends Controller
{
    function index()
    {
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
    }
}
