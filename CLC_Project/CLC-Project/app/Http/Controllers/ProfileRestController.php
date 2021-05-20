<?php

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

    public function show($id)
    {
        $service = new ProfileService();
        $profile = $service->getProfile($id);
        
        if($profile == false)
        {
            $dto = new DTO(-1, "No profile was found with id: " . $id, null);
        }
        else
        {
            $dto = new DTO(1, "Profile " . $id . " was found", $profile->jsonSerialize());
        }
        
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        echo $json;
    }
}
