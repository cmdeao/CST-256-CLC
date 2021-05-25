<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Profile Rest Controller handles retrieval and display of a specific
 * user's profile and displays it in JSON format.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DTO;
use App\Services\Business\ProfileService;

class ProfileRestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "No data can be returned through this search";
    }

    //Show method to display specificc user profile in JSON format.
    public function show($id)
    {
        //Creating service variable to access profile service class.
        $service = new ProfileService();
        //Retrieving specific user profile.
        $profile = $service->getProfile($id);
        
        //If operation is false.
        if($profile == false)
        {
            //Creating new DTO to display no profile found.
            $dto = new DTO(-1, "No profile was found with id: " . $id, null);
        }
        else
        {
            //Creating new DTO to display found profile.
            $dto = new DTO(1, "Profile " . $id . " was found", $profile->jsonSerialize());
        }
        
        //Encoding DTO into JSON for display.
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        //Displaying JSON data.
        echo $json;
    }
}
