<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Business\GroupService;

use App\Models\GroupModel;

class GroupController extends Controller
{
    function index()
    {
        $service = new GroupService();
        
        //echo "Inside GroupController!";   
//         $newGroup = new GroupModel(null, "Testing", "Details go here", "1,2", "1,2");
//         if($service->createGroup($newGroup))
//         {
//             echo "Created group from controller!<br>";
//         }
//         else
//         {
//             echo "Failed to create group from controller!<br>";
//         }


//         $retrievedGroup = $service->getGroup(1);
//         if(!$retrievedGroup)
//         {
//             echo "Failed to retrieve the group!<br>";
//         }
//         else
//         {
//             echo "ID: " . $retrievedGroup->getID() . "<br>";
//             echo "Group Name: " . $retrievedGroup->getGroupName() . "<br>";
//             echo "Group Details: " . $retrievedGroup->getGroupDetails() . "<br>";
//             echo "Group Admins: " . $retrievedGroup->getGroupAdmins() . "<br>";
//             echo "Group Members: " . $retrievedGroup->getGroupMembers() . "<br>";
//         }


//         $updatedGroup = new GroupModel(1, "Update Test", "New Details", "1,2,3", "1,2,4");
//         if($service->editGroup($updatedGroup))
//         {
//             echo "Updated group from controller<br>";
//         }
//         else
//         {
//             echo "Failed to update group from controller<br>";
//         }

//            if($service->deleteGroup(2))
//            {
//                echo "Deleted group from controller!<br>";
//            }
//            else
//            {
//                echo "Failed to delete group from controller!<br>";
//            }

//             if($service->addUser(5, 1))
//             {
//                 echo "Added user to the group!<br>";
//             }
//             else
//             {
//                 echo "Failed to add user to the group!<br>";
//             }

//             if($service->removeUser(2, 1))
//             {
//                 echo "Removed user from the group!<br>";
//             }
//             else
//             {
//                 echo "Failed to remove user from the group!<br>";
//             }

            $service->addAdmin(6,1);
            
    }
}
