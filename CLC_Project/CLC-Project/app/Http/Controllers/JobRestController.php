<?php

namespace App\Http\Controllers;

use App\Services\Business\JobService;
use App\Models\DTO;
use Illuminate\Http\Request;

class JobRestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = new JobService();
        $jobs = $service->getAllJobs();
        
        if(count($jobs) == 0)
        {
            $dto = new DTO(-1, "No jobs found.", null);
        }
        else
        {
            $dto = new DTO(1, "We found " . count($jobs) . " jobs.", $jobs);
        }
        
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function show($id)
    {
        $service = new JobService();
        $job = $service->findByID($id);
        
        if($job == NULL)
        {
            $dto = new DTO(-1, "No job was found with ID: " . $id, null);
        }
        else
        {
            $dto = new DTO(1, "Found job " . $id, $job->jsonSerialize());
        }
        
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        echo $json;
    }
}
