<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\AdminService;

class AdminController extends Controller
{
    function index()   
    {
//         echo "<br>Inside AdminController";
        $service = new AdminService();
        $users = $service->getAllUsers();
        
//         echo "<br>Count of users: " . count($users);
//         echo "<br>";
//         for($i = 0; $i < count($users); $i++)
//         {
//             echo $users[$i][0] . " " . $users[$i][1] . " " . $users[$i][2] . " " . 
//                 $users[$i][3] . " " . $users[$i][4] . " " . $users[$i][5] .
//                 " " . $users[$i][6] . " " . $users[$i][7] ."<br>";
//         }
        
//         if($service->suspendUser(10))
//         {
//             echo "<br>We suspended the user!";
//         }
//         else
//         {
//             echo"<br>Failed to suspend the user!";
//         }

//         if($service->unsuspendUser(10))
//         {
//             echo "<br>We unspended the user!";
//         }
//         else
//         {
//             echo "<br>We failed to unsuspend the user!";   
//         }

//         if($service->banUser(10))
//         {
//             echo "<br>We banned the user!";
//         }
//         else
//         {
//             echo "<br>We failed to ban the user!";
//         }

//         if($service->unbanUser(10))
//         {
//             echo "<br>We unbanned the user!";
//         }
//         else
//         {
//             echo "<br>We failed to unban the user!";
//         }

//         if($service->updateRole(2, 10))
//         {
//             echo "<br>We've updated the role of a user!";
//         }
//         else
//         {
//             echo "<br>We've failed to update the role of a user!";
//         }

//         if($service->deleteUser(13))
//         {
//             echo "<br>We've deleted the user from the application database!";
//         }
//         else
//         {
//             echo "<br>We failed to delete the user from the application database!";
//         }

//         $user = $service->findByID(10);
        
//         echo "<br>ID: " . $user->getUserID() . " Name: " . $user->getName() . " Email: " . $user->getEmail()
//             . " Age: " . $user->getAge() . " Username: " . $user->getUsername();

        return view('adminPage')->with(compact('users'));
    }   
    
    function suspendUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('suspend');
        
        if($service->suspendUser($userID))
        {   
            return redirect()->action('AdminController@index');
        }
        else
        {
            echo "Failed to suspend User ID: '$userID'";
        }
    }
    
    function banUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('ban');
        
        if($service->banUser($userID))
        {
            return redirect()->action('AdminController@index'); 
        }
        else
        {
            echo "Failed to ban User ID: '$userID'";
        }
    }
    
    function deleteUser(Request $request)
    {
        $service = new AdminService();
        $userID = $request->input('delete');
        
        if($service->deleteUser($userID))
        {
            return redirect()->action('AdminController@index');
        }
        else
        {
            echo "Failed to delete User ID: '$userID'";
        }
    }
}
