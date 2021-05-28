<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job Rest Controller handles retrieval and display of all job postings and
 * specific job postings in JSON format with REST.
 */

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
    //Index method to display all job postings in JSON format.
    public function index()
    {
        //Creating service variable to access job service class.
        $service = new JobService();
        //Retrieving all jobs.
        $jobs = $service->getAllJobs();
        
        //Checking if jobs array is empty.
        if(count($jobs) == 0)
        {
            //Creating new DTO to display no jobs.
            $dto = new DTO(-1, "No jobs found.", null);
        }
        else
        {
            //Creating new DTO to display found jobs.
            $dto = new DTO(1, "We found " . count($jobs) . " jobs.", $jobs);
        }
        
        //Encoding DTO into JSON for display.
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        //Displaying JSON data.
        echo $json;
    }

    //Show method to display specific job posting in JSON format.
    public function show($id)
    {
        //Creating service variable to access job service class.
        $service = new JobService();
        //Retrieving specific job postings.
        $job = $service->findByID($id);
        
        //Checking if object is null.
        if($job == NULL)
        {
            //Creating new DTO to display no found job.
            $dto = new DTO(-1, "No job was found with ID: " . $id, null);
        }
        else
        {
            //Creating new DTO to display found job.
            $dto = new DTO(1, "Found job " . $id, $job->jsonSerialize());
        }
        
        //Encoding DTO into JSON for display.
        $json = json_encode($dto, JSON_PRETTY_PRINT);
        
        //Displaying JSON data.
        echo $json;
    }
}
