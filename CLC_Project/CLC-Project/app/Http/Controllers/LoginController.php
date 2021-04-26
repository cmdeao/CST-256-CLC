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

class LoginController extends Controller
{
    function findUser(Request $request)
    {
        $userCreds = new SecurityModel($request->input('username'), $request->input('password'));
        $service = new SecurityService();
        $loginResult = $service->login($userCreds);
        
        if(!$loginResult)
        {
            echo "<br>Failed to login to application";
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
            
            return view('home');
        }
    }
}
