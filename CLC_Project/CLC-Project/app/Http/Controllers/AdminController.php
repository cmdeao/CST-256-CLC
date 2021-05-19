<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\AdminService;
use App\Services\Business\JobService;
use App\Services\Utility\ILoggerService;

class AdminController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function index()   
    {
        $this->logger->info("Entering AdminController::index()", null);
        $service = new AdminService();
        $users = $service->getAllUsers();
        
        return view('adminPage')->with(compact('users'));
    }   
    
    function suspendUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('suspend');
        $this->logger->info("Entering AdminController::suspendUser() with value: ", $userID);
        
        try
        {
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
        catch(exception $e)
        {
            $this->logger->error("Exception AdminController::suspendUser() ", $e->getMessage());   
        }
    }
    
    function banUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('ban');
        $this->logger->info("Entering AdminController::banUser() with value: ", $userID);
        
        try
        {
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
        catch(exception $e)
        {
            $this->logger->error("Exception AdminController::banUser() ", $e->getMessage());   
        }    
    }
    
    function deleteUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('delete');
        $this->logger->info("Entering AdminController::deleteUser()", null);
        
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
        catch (Exception $e) 
        {
            $this->logger->error("Exception AdminController::deleteUser() ", $e->getMessage());   
        }
    }
    
    function viewJobs()
    {
        $service = new JobService();
        $postings = $service->getAllJobs();
        $this->logger->info("Entering AdminController::viewJobs()", null);
        return view('jobPostAdmin')->with(compact('postings'));
    }
}
