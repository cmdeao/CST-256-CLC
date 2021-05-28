<?php
/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thispen
 * 5/30/2021
 * Registration Controller handles the retrieval of user submitted data,
 * creates a User object, and inserts the objects into the database. If
 * the query finds a used email or username an error message will be returned.
 * Logging statements are built in to showcase entry and exit of class and method.
 */
namespace App\Http\Controllers;

use App\User;
use DB;
use App\Services\Utility\ILoggerService;

use Illuminate\Http\Request;


class RegistrationController extends Controller
{
    //Logger variable.
    protected $logger;
    
    //Constructor method to initialize logger.
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //User registration method to register user to the application and store
    //within the database.
    function userRegistration(Request $request)
    {   
        $this->logger->info("Entering RegistrationController::userRegistration", null);
        
        //Creating new user.
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->age = $request->input('age');
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->role = 1;
        $user->banned = 0;
        $user->suspended = 0;
        
        //Querying database to find if any results exist for the submitted email.
        $retrievedUser = DB::table('users')->where('email', $user->email)->first();
        
        //Exiting if email exists within the database.
        if(!is_null($retrievedUser))
        {
            $message = "Cannot register an account with this username and email combination";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        //Exception handling for operation.
        try 
        {
            //Saving user information to the database.
            $user->save();
            $this->logger->info("Registered user.", null);
        }
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception RegistrationController::userRegistration ", $e->getMessage());  
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        $this->logger->info("Exiting RegistrationController::userRegistration", null);
        return view('login');
    }
}
