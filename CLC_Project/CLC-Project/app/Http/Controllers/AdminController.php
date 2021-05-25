<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Admin controller handles administration requests related to user suspension,
 * banning users, deleting users, and viewing all jobs stored within the database.
 * Logging statements are built in to showcase entry and exit of class and methods,
 * along with results of operations and various variables utilized in methods.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\AdminService;
use App\Services\Business\JobService;
use App\Services\Utility\ILoggerService;

class AdminController extends Controller
{
    //Logger variable
    protected $logger;
    
    //Constructor method to initialize logger.
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Index method to showcase all users within the application.
    function index()   
    {
        $this->logger->info("Entering AdminController::index()", null);
        
        //Creating service variable to access service class.
        $service = new AdminService();
        //Storing all users within an array.
        $users = $service->getAllUsers();
        
        //Returning the appropriate view and passing the user array.
        return view('adminPage')->with(compact('users'));
    }   
    
    //Suspension method for admins to suspend a specific user from the application.
    function suspendUser(Request $request)
    {
        //Creating service variable to access service class.
        $service = new AdminService();
        $userID = $request->input('suspend');
        $this->logger->info("Entering AdminController::suspendUser() with value: ", $userID);
        
        //Exception handling for operation.
        try
        {
            //If-statement for suspending user. Redirects to appropriate view
            //based on result of operation.
            if($service->suspendUser($userID))
            {
                $this->logger->info("Exiting AdminController::suspendUser()", null);
                return redirect()->action('AdminController@index');
            }
            else
            {
                $this->logger->error("Error occurred AdminController::suspendUser() with value: ", $userID);
                echo "Failed to suspend User ID: '$userID'";
            }
        }
        //Logging a potential exception that could occur.
        catch(exception $e)
        {
            $this->logger->error("Exception AdminController::suspendUser() ", $e->getMessage());   
        }
    }
    
    //Banning method for admins to ban a specific user from the application.
    function banUser(Request $request)
    {
        //Creating service variable to access service class.
        $service = new AdminService();
        $userID = $request->input('ban');
        $this->logger->info("Entering AdminController::banUser() with value: ", $userID);
        
        //Exception handling for operation.
        try
        {
            //If-statement for banning user. Redirects to appropriate view
            //based on result of operation.
            if($service->banUser($userID))
            {
                $this->logger->info("Exiting AdminController::suspendUser()", null);
                return redirect()->action('AdminController@index');
            }
            else
            {
                $this->logger->error("Error occurred AdminController::banUser() with value: ", $userID);
                echo "Failed to ban User ID: '$userID'";
            }
        }
        //Logging a potential exception that could occur.
        catch(exception $e)
        {
            $this->logger->error("Exception AdminController::banUser() ", $e->getMessage());   
        }    
    }
    //Delete method for admins to delete a specific user from the application.
    function deleteUser(Request $request)
    {
        //Creating service variable to access service class.
        $service = new AdminService();
        $userID = $request->input('delete');
        $this->logger->info("Entering AdminController::deleteUser()", null);
        
        //Exception handling for operation.
        try 
        {
            if($service->deleteUser($userID))
            {
                $this->logger->info("Exiting AdminController::deleteUser()", null);
                return redirect()->action('AdminController@index');
            }
            else
            {
                $this->logger->error("Error occurred AdminController::deleteUser() with value: ", $userID);
                echo "Failed to delete User ID: '$userID'";
            }    
        }
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception AdminController::deleteUser() ", $e->getMessage());   
        }
    }
    
    //View jobs method to retrieve and display all job postings from the database.
    function viewJobs()
    {
        //Creating service variable to access service class.
        $service = new JobService();
        //Storing all job postings within an array.
        $postings = $service->getAllJobs();
        $this->logger->info("Entering AdminController::viewJobs()", null);
        //Returning appropriate view and passing job postings array.
        return view('jobPostAdmin')->with(compact('postings'));
    }
}
