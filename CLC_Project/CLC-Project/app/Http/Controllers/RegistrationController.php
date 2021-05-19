<?php
/*
 * CLC-Project-256
 * Version 0.1
 * Cameron Deao, Zachary Gardner, Mercedes Thispen
 * 4/18/2021
 * Registration Controller handles the retrieval of user submitted data,
 * creates a User object, and inserts the objects into the database. If
 * the query finds a used email or username an error message will be returned.
 */
namespace App\Http\Controllers;

use App\User;
use DB;
use App\Services\Utility\ILoggerService;

use Illuminate\Http\Request;


class RegistrationController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    function userRegistration(Request $request)
    {   
        $this->logger->info("Entering RegistrationController::userRegistration", null);
        
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->age = $request->input('age');
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->role = 1;
        $user->banned = 0;
        $user->suspended = 0;
        
        $retrievedUser = DB::table('users')->where('email', $user->email)->first();
        
        if(!is_null($retrievedUser))
        {
            echo "Cannot register an account with this username and email combination";
            exit;
        }
        
        try 
        {
            $user->save();
            $this->logger->info("Registered user.", null);
        }
        catch (Exception $e) 
        {
            $this->logger->error("Exception RegistrationController::userRegistration ", $e->getMessage());  
        }
        
        $this->logger->info("Exiting RegistrationController::userRegistration", null);
        return view('login');
    }
}
