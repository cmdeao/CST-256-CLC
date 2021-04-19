<?php
/*
 * CLC-Project-256
 * Version 0.1
 * Cameron Deao, Zachary Gardner, Mercedes Thispen
 * 4/18/2021
 * Login controller handles the retrieval of user submitted data,
 * queries the 'users' table within the database to check if the username
 * exists, and will return messages if the username and password combination fail.
 */
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    function findUser(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        
        $security = DB::table('users')->where('username', $username)->first();
        
        if(is_null($security))
        {
            echo "Please register an account before attempting to login to the application.";
            exit;
        }
        
        if($security->password != $password)
        {
            echo "Failed to login to application!";
            exit;
        }

        return view('home'); 
    }
}
