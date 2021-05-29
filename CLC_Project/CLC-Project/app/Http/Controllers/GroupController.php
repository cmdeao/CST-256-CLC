<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Group controller handles requests related to group creation, deletion,
 * displaying a specific group, showing all groups, editing a group, and joining a group.
 * Logging statements are built in to showcase entry and exit of class and methods,
 * along with results of operations and various variables utilized in methods.
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\GroupService;
use App\Models\GroupModel;
use App\Services\Business\functions;
use App\Services\Utility\ILoggerService;

class GroupController extends Controller
{
    //Logger variable.
    protected $logger;
    
    //Constructor method to initialize logger
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    //Index method exists solely for testing purposes
    function index()
    {
//         $service = new GroupService();

//         $groups = $service->searchGroups("Test");
//         echo "Got groups!";
        
//         echo "ID: " . $groups[0][0] . "<br>";
//         echo "Group Name: " . $groups[0][1] . "<br>";
//         echo "Group Details: " . $groups[0][2] . "<br>";
//         echo "Group Admins: " . $groups[0][3] . "<br>";
//         echo "Group Members: " . $groups[0][4] . "<br>";
        
//         echo "ID: " . $groups[1][0] . "<br>";
//         echo "Group Name: " . $groups[1][1] . "<br>";
//         echo "Group Details: " . $groups[1][2] . "<br>";
//         echo "Group Admins: " . $groups[1][3] . "<br>";
//         echo "Group Members: " . $groups[1][4] . "<br>";       
    }
    
    //Create group method to allow the creation of a group within the application.
    function createGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::createGroup()", null);
        //Creating service variable for access to group service class.
        $service = new GroupService();
        
        $groupName = $request->input('groupName');
        $groupDetails = $request->input('groupDetails');
        
        //Creating group model for storage. 
        $newGroup = new GroupModel(null, $groupName, $groupDetails, null, null);
        
        //Exception handling for operation.
        try 
        {
            //If-statement for creating a group. Redirects to appropriate view
            //based on result of operation.
            if($service->createGroup($newGroup))
            {
                //echo "We've created a new group!<br>";
                $this->logger->info("Created new group: ", $groupName);
            }
            else
            {
                $this->logger->error("Failed to create new group!", null);
                $message = "Failed to create new group!";
                $error = ['error'=>$message];
                return view('error')->with($error);
                exit;
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::createGroup() ", $e->getMessage()); 
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }

        $this->logger->info("Exiting GroupController::createGroup()", null);
        return redirect()->action('GroupController@showGroups');
    }
    
    //Delete group method for admins to delete a specific group from the application.
    function deleteGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::deleteGroup()", null);
        //Creating service variable for access to group service class.
        $service = new GroupService();
        $groupID = $request->input('delete');
        
        //Exception handling for operation.
        try 
        {
            $this->logger->info("Deleted group ID: ", $groupID);
            $service->deleteGroup($groupID);
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::deleteGroup() ", $e->getMessage());   
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        $this->logger->info("Exiting GroupController::deleteGroup()", null);
        return redirect()->action('GroupController@showGroups');
    }
    
    //Display group method to view a specific group stored within the application.
    function displayGroup(Request $request)
    {
        $this->logger->info("Entering GroupController::displayGroup()", null);
        //Creation of variables and service variables.
        $inGroup = false;
        $id = $request->input('displayGroup');
        $service = new GroupService();
        $functions = new functions();
        $userID = $functions->getUserID();
        
        //Retrieving specific group from the service class.
        $group = $service->getGroup($id);
        
        //Creating variables for group information.
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $users = $group->getGroupMembers();
        
        //Formatting string of users stored within the group.
        $userids = str_replace(',' , '', $users);
        $userarray = str_split($userids);
        
        //For-loop to check if a specifc user is within the group.
        for($i = 0; $i < count($userarray); $i++)
        {
            if($userarray[$i] == $userID)
            {
                $inGroup = true;
            }
        }
        
        //Declaring an array.
        $usernames = array();
        
        //Adding usernames to the array for display.
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
    
    //Show groups method for displaying all groups stored within the application.
    function showGroups()
    {
        $this->logger->info("Entering GroupController::showGroups()", null);
        //Creating service variable to access group service class.
        $service = new GroupService();
        //Array of all retrieved groups from the database.
        $groups = $service->getAllGroups();
        $this->logger->info("Exiting GroupController::showGroups()", $groups);
        //Returning the appropriate view and passing the array.
        return view('affinityGroupList')->with(compact('groups'));
    }
    
    //Join group method for users to join a specific group.
    function joinGroup(Request $request)
    {   
        //Creating service variable to access group service class.
        $service = new GroupService();
        $functions = new functions();
        $userID = $functions->getUserID();
        
        //If-elseif statements to see which button was pressed by the user.
        //Service operations are performed for joining or leaving the group,
        //based on which button was pressed.
        if(!is_null($request->input('join')))
        {
            $groupID = $request->input('join');
            $service->addUser($userID, $groupID);
        }
        elseif(!is_null($request->input('leave')))
        {
            $groupID = $request->input('leave');
            $service->removeUser($userID, $groupID);
        }
        
        return redirect()->action('GroupController@showGroups');
    }
    
    //Edit group method for admins to edit a specific group within the application.
    function editGroup(Request $request)
    {   
        $this->logger->info("Entering GroupController::editGroup()", null);
        //Creating service variable to access group service class.
        $service = new GroupService();
        $ID = $request->input('editGroup');
        
        //Retrieving specific group and all users associated with the group.
        $group = $service->getGroup($ID);
        $users = $group->getGroupMembers();
        
        //Formatting the string of all users within the group.
        $userids = str_replace(',' , '', $users);
        $userarray = str_split($userids);
        
        //Creating an array for usernames.
        $usernames = array();
        
        //Retrieving usernames and adding them into the array.
        for($i = 0; $i < count($userarray); $i++)
        {
            array_push($usernames, $service->getGroupMembers($userarray[$i]));
        }
        
        $groupMembers['groupMembers'] = $usernames;
        $this->logger->info("Exiting GroupController::editGroup() ", $ID);
        
        //Returning the appropriate view and passing appropriate variables.
        return view('editGroup', array("ID"=>$ID), $groupMembers);
    }
    
    //Method to confirm edit of group by an admin.
    function confirmEdit(Request $request)
    {
        $this->logger->info("Entering GroupController::confirmEdit()", null);
        //Creating service variable to access group service class
        $service = new GroupService();
        
        //Creating variables of information passed by the admin
        $groupID = $request->input('groupID');
        $groupName = $request->input('groupName');
        $groupDetails = $request->input('groupDetails');
        
        //Retrieving old group information.
        $oldGroup = $service->getGroup($groupID);
        
        //Creating new group model.
        $newGroup = new GroupModel($groupID, $groupName, $groupDetails,
            $oldGroup->getGroupAdmins(), $oldGroup->getGroupMembers());
        
        //Exception handling for operation.
        try 
        {
            //If-statement for editing a group. Redirects to appropriate view
            //based on result of operation.
            if($service->editGroup($newGroup))
            {
                $this->logger->info("Edited group: ", $groupID);
                return redirect()->action('GroupController@showGroups');
            }
            else
            {
                $this->logger->error("Error editing group: ", $groupID);
                $message = "Error editing group!";
                $error = ['error'=>$message];
                return view('error')->with($error);
                //return redirect()->action('GroupController@showGroups');
            }
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::confirmEdit() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
    }
    
    //Remove user method for admins to remove a specific user from a specific group.
    function removeUser(Request $request)
    {
        $this->logger->info("Entering GroupController::confirmEdit()", null);
        $groupID = $request->input('groupID');
        //Creating service variable to access group service class.
        $service = new GroupService();
        
        //Exception handling for operation.
        try 
        {
            $service->adminRemoveUser($request->input('user'), $request->input('groupID'));
            $this->logger->info("Removed user: ", $request->input('user'));
        } 
        //Logging a potential exception that could occur.
        catch (Exception $e) 
        {
            $this->logger->error("Exception GroupController::removeUser() ", $e->getMessage());
            $message = "An exception occurred!";
            $error = ['error'=>$message];
            return view('error')->with($error);
        }
        
        $this->logger->info("Exiting GroupController::removeUser()", null);
        return redirect()->action('GroupController@showGroups');
    }
}
