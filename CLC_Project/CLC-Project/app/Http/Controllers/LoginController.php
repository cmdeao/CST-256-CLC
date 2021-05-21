<?php
/*
 * CLC-Project-256
 * Version 0.2
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 4/22/2021
 * Login controller handles the retrieval of user submitted data,
 * queries the 'users' table within the database to check if the username
 * exists, and will return messages if the username and password combination fail.
 */
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SecurityModel;
use App\Services\Business\SecurityService;
use App\Services\Business\functions;

use App\Services\Utility\MyLogger;
use App\Services\Utility\ILoggerService;

class LoginController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function findUser(Request $request)
    {
        $logger1 = new MyLogger();
        
        $logger1->info("Entering LoginController::findUser()", array("username"=>$request->input('username'), "password"=>'****'));
        $this->logger->info("Entering LoginController::findUser()", array("username"=>$request->input('username'), "password"=>'****'));
        
        $userCreds = new SecurityModel($request->input('username'), $request->input('password'));
        $service = new SecurityService();
        $loginResult = $service->login($userCreds);
        
        try
        {
            if(!$loginResult)
            {
                echo "<br>Failed to login to application";
                $logger1->info("Failed login at LoginController::findUser() Paramaters: ", array("username"=>$request->input('username'), "password"=>$request->input('password')));
                $this->logger->info("Failed login at LoginController::findUser() Paramaters: ", array("username"=>$request->input('username'), "password"=>$request->input('password')));
                
            }
            else
            {
                $functions = new functions();
                $functions->saveUserID($loginResult->getUserID());
                $functions->logUser($loginResult);
                $functions->saveUserRole($loginResult);
                
                session(['USER_ID' => $loginResult->getUserID()]);
                session(['user' => $loginResult->getUsername()]);
                session(['role' => $loginResult->getRole()]);
                session(['loggedUser' => 1]);
                
                $logger1->info("Exit LoginController::findUser() with login passing.", null);
                $this->logger->info("Exit LoginController::findUser() with login passing.", null);
                
                return view('home');
            }
        }
        catch(exception $e)
        {
            $logger1->error("Exception LoginController::findUser() ", $e->getMessage());
            $this->logger->error("Exception LoginController::findUser() ", $e->getMessage());   
        }
    }
}
