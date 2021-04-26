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

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    function userRegistration(Request $request)
    {   
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
        
        $user->save();
        return view('home');
    }
}
