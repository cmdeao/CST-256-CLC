<?php
namespace App\Models;

class GroupModel
{
    private $id;
    private $groupName;
    private $groupDetails;
    private $groupAdmins;
    private $groupMembers;
    
    public function __construct($id, $groupName, $groupDetails, $groupAdmins, $groupMembers)
    {
        $this->id = $id;
        $this->groupName = $groupName;
        $this->groupDetails = $groupDetails;
        $this->groupAdmins = $groupAdmins;
        $this->groupMembers = $groupMembers;
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getGroupName()
    {
        return $this->groupName;
    }
    
    public function getGroupDetails()
    {
        return $this->groupDetails;
    }
    
    public function getGroupAdmins()
    {
        return $this->groupAdmins;
    }
    
    public function getGroupMembers()
    {
        return $this->groupMembers;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }
    
    public function setGroupDetails($groupDetails)
    {
        $this->groupDetails = $groupDetails;
    }
    
    public function setGroupAdmins($groupAdmins)
    {
        $this->groupAdmins = $groupAdmins;
    }
    
    public function setGroupMembers($groupMembers)
    {
        $this->groupMembers = $groupMembers;
    }
}

