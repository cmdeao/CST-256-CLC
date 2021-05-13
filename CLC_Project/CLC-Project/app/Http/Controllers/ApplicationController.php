<?php

namespace App\Http\Controllers;

use App\Services\Business\JobApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    function index()
    {
        $service = new JobApplicationService();
        $service->createJobApplication(1, 1);
    }
}
