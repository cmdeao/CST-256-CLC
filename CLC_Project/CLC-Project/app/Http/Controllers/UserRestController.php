<?php

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
    public function index()
    {
        $service = new SecurityService();
        $users = $service->getAllUsers();
        
        if(count($users) == 0)
        {
            $dto = new DTO(-1, "No users were found", $users);
        }
        else
        {
            $dto = new DTO(1, "Found Users", $users);
        }
        
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        echo $json;
    }

    public function show($id)
    {
        $service = new SecurityService();
        $user = $service->getUser($id);
        
        if($user == NULL)
        {
            $dto = new DTO(-1, "No user found with that ID", null);
        }
        else
        {
            $dto = new DTO(1, "User found", $user->jsonSerialize());
        }
        
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        echo $json;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
