<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //return "Form data will be here";
        $testingUser = $req->input('username');
        $testingPassword = $req->input('userpassword');
        echo "Username: " . $testingUser . "<br>";
        echo "Password: " . $testingPassword . "<br>";
        //return $req->input();
    }
}
