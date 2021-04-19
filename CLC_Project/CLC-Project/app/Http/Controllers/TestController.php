<?php
/*
 * TESTING CONTROLLER! THIS CONTROLLER SIMPLY EXISTS FOR TESTING
 * DATA RETRIEVAL FROM FORMS, INSERTING DATA INTO THE DATABASE,
 * AND RETRIEVING DATA FROM THE DATABASE.
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class TestController extends Controller
{
    function test()
    {
        return "Hello World from Test Controller";
    }
    
    function test2()
    {
        return view('helloworld');
    }
    
    function getData(Request $req)
    {
        
        $user = new User;
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->age = $req->input('age');
        $user->username = $req->input('username');
        $user->password = $req->input('password');
        
        echo "Name: " . $user->name . "<br>";
        echo "Email: " . $user->email . "<br>";
        echo "Age: " . $user->age . "<br>";
        echo "Username: " . $user->username . "<br>";
        echo "Password: " . $user->password . "<br>";
        
        //LINE OF CODE TO SAVE USER TO THE DATABASE
        //$user->save();
        
        //LINE OF CODE TO RETRIEVE USER FROM THE DATABASE
        $users = DB::select('SELECT * FROM users WHERE name = ' . "'cmd'");
        
        //LINE OF CODE TO RETRIEVE DATA BASED ON ID
        //return User::find(2);
        
        //ITERATE THROUGH ARRAY OF DATA
        foreach($users as $users)
        {
            echo "ID: " . $users->id;
            echo "Name: " . $users->name;
        }
    }
    
    function loguser(Request $req)
    {
        $username = $req->input('username');
        $password = $req->input('password');
    }
}
