<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\AdminService;
use App\Services\Business\JobService;

class AdminController extends Controller
{
    function index()   
    {
        $service = new AdminService();
        $users = $service->getAllUsers();
        
        return view('adminPage')->with(compact('users'));
    }   
    
    function suspendUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('suspend');
        
        if($service->suspendUser($userID))
        {   
            return redirect()->action('AdminController@index');
        }
        else
        {
            echo "Failed to suspend User ID: '$userID'";
        }
    }
    
    function banUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('ban');
        
        if($service->banUser($userID))
        {
            return redirect()->action('AdminController@index'); 
        }
        else
        {
            echo "Failed to ban User ID: '$userID'";
        }
    }
    
    function deleteUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('delete');
        
        if($service->deleteUser($userID))
        {
            return redirect()->action('AdminController@index');
        }
        else
        {
            echo "Failed to delete User ID: '$userID'";
        }
    }
    
    function viewJobs()
    {
        $service = new JobService();
        $postings = $service->getAllJobs();
        return view('jobPostAdmin')->with(compact('postings'));
    }
}
