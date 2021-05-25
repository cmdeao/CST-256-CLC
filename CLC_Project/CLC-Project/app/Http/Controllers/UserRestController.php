<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * User Rest Controller handles retrieval and display of all users and
 * specific users in JSON format with REST.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DTO;
use App\Services\Business\SecurityService;

class UserRestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Index method to display all users in JSON format.
    public function index()
    {
        //Creating service variable to access security service class.
        $service = new SecurityService();
        //Retrieving all users.
        $users = $service->getAllUsers();
        
        //Check if users array is empty.
        if(count($users) == 0)
        {
            //Creating new DTO to display no found users.
            $dto = new DTO(-1, "No users were found", $users);
        }
        else
        {
            //Creating new DTO to display found users.
            $dto = new DTO(1, "Found Users", $users);
        }
        
        //Encoding DTO into JSON for display.
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        //Displaying JSON data.
        echo $json;
    }

    //Show method to display specific user information in JSON format.
    public function show($id)
    {
        //Creating service variable to access security service class.
        $service = new SecurityService();
        //Retrieving specific user.
        $user = $service->getUser($id);
        
        //Checking if object is null.
        if($user == NULL)
        {
            //Creating new DTO to display no found user.
            $dto = new DTO(-1, "No user found with that ID", null);
        }
        else
        {
            //Creating new DTO to display found user.
            $dto = new DTO(1, "User found", $user->jsonSerialize());
        }
        
        //Encoding DTO into JSON for display.
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        //Displaying JSON data.
        echo $json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
