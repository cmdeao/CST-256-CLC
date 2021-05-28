<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Group DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\GroupModel;

class GroupDAO
{
    //Search groups returns all groups based on the passed search term.
    public function searchGroups($term)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM groups WHERE group_name LIKE " . "'%" . $term . "%'";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $groups = array();
        
        //Iterating through results and adding groups into the array.
        while($row = $result->fetch_assoc())
        {
            $groups[$index] = array($row['group_id'], $row['group_name'],
                $row['group_details'], $row['group_admins_id'], $row['group_member_id']);
            ++$index;
        }
        
        //Returning the array.
        return $groups;
    }
    
    //Get group returns a specific group based on the passed ID.
    public function getGroup($groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        //Checking number of returned rows.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            //Creating new Group Model object with retrieved data.
            $groupModel = new GroupModel($row['group_id'], $row['group_name'], $row['group_details'],
                $row['group_admins_id'], $row['group_member_id']);
            
            //Returning object
            return $groupModel;
        }
        else
        {
            return false;
        }
    }
    
    //Get all groups returns all the groups within the database.
    public function getAllGroups()
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM groups";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $groups = array();
        
        //Iterating through results and adding users into the array.
        while($row = $result->fetch_assoc())   
        {
            //Adding group information into the array.
            $groups[$index] = array($row['group_id'], $row['group_name'],
                $row['group_details'], $row['group_admins_id'], $row['group_member_id']);
            ++$index;
        }
        
        //Freeing result set and closing connection.
        $result->free();
        mysqli_close($database);
        
        //Returning array.
        return $groups;
    }
    
    //Create group creates a new group entry within the database.
    public function createGroup(GroupModel $group)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values of passed Group Model object.
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $groupAdmins = $group->getGroupAdmins();
        $groupMembers = $group->getGroupMembers();
        
        //Creating SQL query and establishing result set.
        $retrievalSQL = "SELECT group_name FROM groups WHERE group_name = '$groupName'";
        $retrievalResult = mysqli_query($database, $retrievalSQL);
        
        //Checking if the group already exists within the database.
        if(mysqli_num_rows($retrievalResult) == 1)
        {
            echo "A group already has this name!<br>";
            return false;
        }
        
        //Creating SQL query to create new group.
        $sql = "INSERT INTO groups (group_name, group_details, group_admins_id, group_member_id)
            VALUES ('$groupName', '$groupDetails', '$groupAdmins', '$groupMembers')";
        
        //Executing query and returning result of operation.
        if(mysqli_query($database, $sql))
        {
            echo "Created a new group!<br>";
            return true;
        }
        else
        {
            echo "Failed to create a new group!<br>";
            return false;
        }
    }
    
    //Edit group updates a stored group within the database.
    public function editGroup(GroupModel $group)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Preparing SQL statement.
        $sql = $database->prepare("UPDATE groups SET group_name=?, group_details=?,
            group_admins_id=?, group_member_id=? WHERE group_id=?");
        
        //Retrieving values from passed Group Model object.
        $groupID = $group->getID();
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $groupAdmins = $group->getGroupAdmins();
        $groupMembers = $group->getGroupMembers();
        
        //Binding parameters.
        $sql->bind_param('ssssi', $groupName, $groupDetails, $groupAdmins,
                $groupMembers, $groupID);
        //Executing statement.
        $sql->execute();
        
        //Returning true if operation was successful, else returning false.
        if($sql)
        {
            echo "We've updated group: " . $groupID . "<br>";
            return true;
        }
        else
        {
            echo "We've failed to update group: " . $groupID . "<br>";
            return false;
        }
    }
    
    //Delete group removes group information from the database based on the passed ID.
    public function deleteGroup($groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating query to delete group.
        $sql = "DELETE FROM groups WHERE group_id = '$groupID'";
        
        //Executing query. Returning true if successful, else returning false.
        if($database->query($sql))
        {
            echo "We've deleted group: " . $groupID . "<br>";
            return true;
        }
        else
        {
            echo "We've failed to delete group: " . $groupID . "<br>";
            return false;
        }
    }
    
    //Add user adds a specific user to a specific group.
    public function addUser($userID, $groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT group_member_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
    
        //Checking if group exists within the database.
        if(mysqli_num_rows($result) == 1)
        {
            //Retrieving all group members of the group.
            $row = $result->fetch_assoc();
            $str = $row['group_member_id'];
          
            //Checking if retrieved user string is not empty.
            if($str != "")
            {
                //Formatting the string to only have numeric values.
                $newSTR = str_replace(',', '', $str);
                //Storing numeric values within temp array.
                $array = str_split($newSTR);
                
                //Iterating through temp array.
                for($i = 0; $i < count($array); $i++)
                {
                    //Checking if temp array has passed user ID.
                    if($array[$i] == $userID)
                    {
                        //Returing false if user ID is found in temp array.
                        return false;
                    }
                }
                
                //Adding new user ID to string of users.
                $str = $str . "," . $userID;
            }
            else
            {
                $str = $userID;
            }
            
            //Preparing SQL statement.
            $sql = $database->prepare("UPDATE groups SET group_member_id=? WHERE group_id='$groupID'");
            //Binding parameter.
            $sql->bind_param('s', $str);
            //Executing statement.
            $sql->execute();
            
            //Returning true if operation was successful, else returning false.
            if($sql)
            {
                echo "We've updated the values!<br>";
                return true;
            }
            else
            {
                echo "We've failed to update the values!<br>";
                return false;
            }
        }
        //Returing false if group is not found.
        else
        {
            return false;
        }
    }
    
    //Remove user will remove a user from a specific group.
    public function removeUser($userID, $groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT group_member_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        //Checking if group exists within the database.
        if(mysqli_num_rows($result) == 1)
        {
            //Fetching results.
            $row = $result->fetch_assoc();
            //Retrieving all users within the group.
            $str = $row['group_member_id'];
            
            //Formatting the string to only have numeric values.
            $newSTR = str_replace(',','', $str);
            //Storing numeric values within temp array.
            $array = str_split($newSTR);
            
            //Checking if user is in array.
            if(!in_array($userID, $array))
            {
                echo "You are not in the array!<br>";
                return false;
            }
            
            //Finding which index value the current user is at within the array.
            $indexValue;
            for($i = 0; $i < count($array); $i++)
            {
                if($array[$i] == $userID)
                {
                    $indexValue = $i;
                }
            }
            
            //Removing the user value from the temp array at the correct index.
            unset($array[$indexValue]);
            //Creating final temp array with removed value.
            $newArr = array_values($array);
            
            //Creating final string for column within the database.
            $finalSTR = implode(",", $newArr);
            
            //Preparing SQL statement.
            $sql = $database->prepare("UPDATE groups SET group_member_id=? WHERE group_id='$groupID'");
            //Binding parameter.
            $sql->bind_param('s', $finalSTR);
            //Executing statement.
            $sql->execute();
            
            //Returing true if operation was successful, else returning false.
            if($sql)
            {
                return true;
            }
            else
            {
                return false;
            }
            
        }
        else
        {
            return false;
        }
    }
    
    //Admin remove user allows an admin to remove a user from the group.
    public function adminRemoveUser($username, $groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT id FROM users WHERE name = '$username'";
        $result = mysqli_query($database, $sql);
        $userID;
        
        //Retrieving the user ID based on the result of query.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $userID = $row['id'];
        }
        
        //Passing user ID and group ID into the remove user method and returning result.
        if($this->removeUser($userID, $groupID))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //Add admin adds an admin to the list of admins within a group.
    public function addAdmin($adminID, $groupID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT group_admins_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        //Checking if group exists within the database.
        if(mysqli_num_rows($result) == 1)
        {
            //Retrieving all admins from the group.
            $row = $result->fetch_assoc();
            $str = $row['group_admins_id'];
            
            //Formatting the string to only have numeric values.
            $newSTR = str_replace(',' , '', $str);
            //Storing numeric values within temp array.
            $array = str_split($newSTR);
            
            //Iterating through temp aray.
            for($i = 0; $i < count($array); $i++)
            {
                //Checking if temp array has passed admin ID.
                if($array[$i] == $adminID)
                {
                    return false;
                }
            }
            
            //Adding new admin ID to string of admins.
            $str = $str . "," . $adminID;
            
            //Preparing SQL statement.
            $sql = $database->prepare("UPDATE groups SET group_admins_id=? WHERE group_id='$groupID'");
            //Binding parameter.
            $sql->bind_param('s', $str);
            //Executing statement.
            $sql->execute();
            
            //Returing true if operation was successful, else returning false. 
            if($sql)
            {
                echo "We've updated the values!<br>";
                return true;
            }
            else
            {
                echo "We've failed to update the values!<br>";
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    //Get group members returns the name of a specific group member
    public function getGroupMembers($memberID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT name FROM users WHERE id = '$memberID'";
        $result = mysqli_query($database, $sql);
        
        //Checking retrieved results.
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            
            //Returing name.
            return $name;
        }
        else
        {
            //Returing null.
            return null;
        }
    }
}

