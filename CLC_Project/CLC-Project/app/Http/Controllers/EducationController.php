<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Controller exists solely for testing purposes of updating a specific user's 
 * education information within the database of the application.
 */


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
