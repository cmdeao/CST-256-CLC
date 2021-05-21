<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\GroupService;
use App\Models\GroupModel;
use App\Services\Business\functions;
use App\Services\Utility\ILoggerService;

class GroupController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
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

//             if($service->addUser(6, 1))
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

//             $service->addAdmin(6,1);

            $groups = $service->searchGroups("Test");
            echo "Got groups!";
            
            echo "ID: " . $groups[0][0] . "<br>";
            echo "Group Name: " . $groups[0][1] . "<br>";
            echo "Group Details: " . $groups[0][2] . "<br>";
            echo "Group Admins: " . $groups[0][3] . "<br>";
            echo "Group Members: " . $groups[0][4] . "<br>";
            
            echo "ID: " . $groups[1][0] . "<br>";
            echo "Group Name: " . $groups[1][1] . "<br>";
            echo "Group Details: " . $groups[1][2] . "<br>";
            echo "Group Admins: " . $groups[1][3] . "<br>";
            echo "Group Members: " . $groups[1][4] . "<br>";
            //TESTING
//             for($i = 0; $i < count($groups); $i++) 
//             {
//                 echo $groups[0][$i] . "<br>";
//             }
            
    }
    
    function createGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::createGroup()", null);
        $service = new GroupService();
        
        $groupName = $request->input('groupName');
        $groupDetails = $request->input('groupDetails');
        
        $newGroup = new GroupModel(null, $groupName, $groupDetails, null, null);
        
        try 
        {
            if($service->createGroup($newGroup))
            {
                //echo "We've created a new group!<br>";
                $this->logger->info("Created new group: ", $groupName);
            }
            else
            {
                $this->logger->error("Failed to create new group!", null);
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::createGroup() ", $e->getMessage());   
        }

        $this->logger->info("Exiting GroupController::createGroup()", null);
        return redirect()->action('GroupController@showGroups');
    }
    
    function deleteGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::deleteGroup()", null);
        $service = new GroupService();
        $groupID = $request->input('delete');
        
        try 
        {
            $this->logger->info("Deleted group ID: ", $groupID);
            $service->deleteGroup($groupID);
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::deleteGroup() ", $e->getMessage());   
        }
        
        $this->logger->info("Exiting GroupController::deleteGroup()", null);
        return redirect()->action('GroupController@showGroups');
    }
    
    function displayGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::displayGroup()", null);
        $inGroup = false;
        $id = $request->input('displayGroup');
        $service = new GroupService();
        $functions = new functions();
        $userID = $functions->getUserID();
        
        $group = $service->getGroup($id);
        
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $users = $group->getGroupMembers();
        
        $userids = str_replace(',' , '', $users);
        $userarray = str_split($userids);
        
        for($i = 0; $i < count($userarray); $i++)
        {
            if($userarray[$i] == $userID)
            {
                $inGroup = true;
            }
        }
        
        $usernames = array();
        
        for($i = 0; $i < count($userarray); $i++)
        {
            array_push($usernames, $service->getGroupMembers($userarray[$i]));
        }
        
        
        
        $groupMembers['groupMembers'] = $usernames;
        
        $groupid = $id;
        $this->logger->info("Exiting GroupController::displayGroup() ", $groupid);
        return view('showGroup', array("groupName"=>$groupName, "groupDetails"=>$groupDetails,
            "groupid"=>$groupid, "inGroup"=>$inGroup), $groupMembers);        
        
    }
    
    function showGroups()
    {
        $this->logger->info("Entering GroupController::showGroups()", null);
        $service = new GroupService();
        $groups = $service->getAllGroups();
        $this->logger->info("Exiting GroupController::showGroups()", $groups);
        return view('affinityGroupList')->with(compact('groups'));
    }
    
    function joinGroup(Request $request)
    {   
        $service = new GroupService();
        $functions = new functions();
        $userID = $functions->getUserID();
        
        if(!is_null($request->input('join')))
        {
            echo "You are joining the group!";
            $groupID = $request->input('join');
            $service->addUser($userID, $groupID);
        }
        elseif(!is_null($request->input('leave')))
        {
            echo "You are leaving the group!";
            $groupID = $request->input('leave');
            $service->removeUser($userID, $groupID);
        }
        
        return redirect()->action('GroupController@showGroups');
    }
    
    function editGroup(Request $request)
    {   
        $this->logger->info("Entering GroupController::editGroup()", null);
        $service = new GroupService();
        $ID = $request->input('editGroup');
        
        $group = $service->getGroup($ID);
        $users = $group->getGroupMembers();
        
        $userids = str_replace(',' , '', $users);
        $userarray = str_split($userids);
        
        $usernames = array();
        
        for($i = 0; $i < count($userarray); $i++)
        {
            array_push($usernames, $service->getGroupMembers($userarray[$i]));
        }
        
        $groupMembers['groupMembers'] = $usernames;
        $this->logger->info("Exiting GroupController::editGroup() ", $ID);
        return view('editGroup', array("ID"=>$ID), $groupMembers);
    }
    
    function confirmEdit(Request $request)
    {
        $this->logger->info("Entering GroupController::confirmEdit()", null);
        $service = new GroupService();
        
        $groupID = $request->input('groupID');
        $groupName = $request->input('groupName');
        $groupDetails = $request->input('groupDetails');
        
        $oldGroup = $service->getGroup($groupID);
        
        $newGroup = new GroupModel($groupID, $groupName, $groupDetails,
            $oldGroup->getGroupAdmins(), $oldGroup->getGroupMembers());
        
        try 
        {
            if($service->editGroup($newGroup))
            {
                $this->logger->info("Edited group: ", $groupID);
                return redirect()->action('GroupController@showGroups');
            }
            else
            {
                $this->logger->error("Error editing group: ", $groupID);
                return redirect()->action('GroupController@showGroups');
            }
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::confirmEdit() ", $e->getMessage());   
        }
    }
    
    function removeUser(Request $request)
    {
        $this->logger->info("Entering GroupController::confirmEdit()", null);
        $groupID = $request->input('groupID');
        $service = new GroupService();
        
        try 
        {
            $service->adminRemoveUser($request->input('user'), $request->input('groupID'));
            $this->logger->info("Removed user: ", $request->input('user'));
        } 
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::removeUser() ", $e->getMessage());   
        }
        
        $this->logger->info("Exiting GroupController::removeUser()", null);
        return redirect()->action('GroupController@showGroups');
    }
}
