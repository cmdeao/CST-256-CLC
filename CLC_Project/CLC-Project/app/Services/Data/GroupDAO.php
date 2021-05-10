<?php
namespace App\Services\Data;
use App\Models\GroupModel;

class GroupDAO
{
    public function searchGroups($term)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM groups WHERE group_name LIKE " . "'%" . $term . "%'";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $groups = array();
        
        while($row = $result->fetch_assoc())
        {
            $groups[$index] = array($row['group_id'], $row['group_name'],
                $row['group_details'], $row['group_admins_id'], $row['group_member_id']);
            ++$index;
        }
        
        return $groups;
    }
    
    public function getGroup($groupID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $groupModel = new GroupModel($row['group_id'], $row['group_name'], $row['group_details'],
                $row['group_admins_id'], $row['group_member_id']);
            
            return $groupModel;
        }
        else
        {
            return false;
        }
    }
    
    public function getAllGroups()
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM groups";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $groups = array();
        
        while($row = $result->fetch_assoc())   
        {
            $groups[$index] = array($row['group_id'], $row['group_name'],
                $row['group_details'], $row['group_admins_id'], $row['group_member_id']);
            ++$index;
        }
        
        $result->free();
        mysqli_close($database);
        
        return $groups;
    }
    
    public function createGroup(GroupModel $group)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $groupAdmins = $group->getGroupAdmins();
        $groupMembers = $group->getGroupMembers();
        
        $retrievalSQL = "SELECT group_name FROM groups WHERE group_name = '$groupName'";
        $retrievalResult = mysqli_query($database, $retrievalSQL);
        
        if(mysqli_num_rows($retrievalResult) == 1)
        {
            echo "A group already has this name!<br>";
            return false;
        }
        
        $sql = "INSERT INTO groups (group_name, group_details, group_admins_id, group_member_id)
            VALUES ('$groupName', '$groupDetails', '$groupAdmins', '$groupMembers')";
        
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
    
    public function editGroup(GroupModel $group)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = $database->prepare("UPDATE groups SET group_name=?, group_details=?,
            group_admins_id=?, group_member_id=? WHERE group_id=?");
        
        $groupID = $group->getID();
        $groupName = $group->getGroupName();
        $groupDetails = $group->getGroupDetails();
        $groupAdmins = $group->getGroupAdmins();
        $groupMembers = $group->getGroupMembers();
        
        $sql->bind_param('ssssi', $groupName, $groupDetails, $groupAdmins,
                $groupMembers, $groupID);
        $sql->execute();
        
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
    
    public function deleteGroup($groupID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "DELETE FROM groups WHERE group_id = '$groupID'";
        
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
    
    public function addUser($userID, $groupID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT group_member_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
    
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $str = $row['group_member_id'];
          
            if($str != "")
            {
                $newSTR = str_replace(',', '', $str);
                $array = str_split($newSTR);
                
                for($i = 0; $i < count($array); $i++)
                {
                    if($array[$i] == $userID)
                    {
                        return false;
                    }
                }
                
                $str = $str . "," . $userID;
            }
            else
            {
                $str = $userID;
            }
            
            $sql = $database->prepare("UPDATE groups SET group_member_id=? WHERE group_id='$groupID'");
            $sql->bind_param('s', $str);
            $sql->execute();
            
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
    
    public function removeUser($userID, $groupID)
    {
        echo "Inside remove user!";
        echo "<br>GROUP ID: " . $groupID . "<br>";
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT group_member_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        echo "<br>Ran first query!<br>";
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $str = $row['group_member_id'];
            
            $newSTR = str_replace(',','', $str);
            $array = str_split($newSTR);
            
            if(!in_array($userID, $array))
            {
                echo "You are not in the array!<br>";
                return false;
            }
            
            $indexValue;
            for($i = 0; $i < count($array); $i++)
            {
                if($array[$i] == $userID)
                {
                    $indexValue = $i;
                }
            }
            
            unset($array[$indexValue]);
            $newArr = array_values($array);
            
            $finalSTR = implode(",", $newArr);
            
            $sql = $database->prepare("UPDATE groups SET group_member_id=? WHERE group_id='$groupID'");
            $sql->bind_param('s', $finalSTR);
            $sql->execute();
            echo "<br>Executed statement!<br>";
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
            echo "<br>We found nothing!<br>";
            return false;
        }
    }
    
    public function adminRemoveUser($username, $groupID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT id FROM users WHERE name = '$username'";
        $result = mysqli_query($database, $sql);
        $userID;
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $userID = $row['id'];
        }
        
        if($this->removeUser($userID, $groupID))
        {
            return true;
        }
        else
        {
            return false;
        }
        //echo "User ID: " . $userID;
    }
    
    public function addAdmin($adminID, $groupID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT group_admins_id FROM groups WHERE group_id = '$groupID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $str = $row['group_admins_id'];
            
            $newSTR = str_replace(',' , '', $str);
            $array = str_split($newSTR);
            
            for($i = 0; $i < count($array); $i++)
            {
                if($array[$i] == $adminID)
                {
                    return false;
                }
            }
            
            $str = $str . "," . $adminID;
            
            $sql = $database->prepare("UPDATE groups SET group_admins_id=? WHERE group_id='$groupID'");
            $sql->bind_param('s', $str);
            $sql->execute();
            
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
    
    public function getGroupMembers($memberID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT name FROM users WHERE id = '$memberID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            
            return $name;
        }
        else
        {
            return null;
        }
    }
}

