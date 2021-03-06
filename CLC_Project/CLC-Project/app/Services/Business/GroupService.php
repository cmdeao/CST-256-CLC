<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Group service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Services\Data\GroupDAO;
use App\Models\GroupModel;

class GroupService
{
    public function searchGroups($term)
    {
        $service = new GroupDAO();
        return $service->searchGroups($term);
    }
    
    public function getGroup($groupID)
    {
        $service = new GroupDAO();
        return $service->getGroup($groupID);
    }
    
    public function getAllGroups()
    {
        $service = new GroupDAO();
        return $service->getAllGroups();
    }
    
    public function createGroup(GroupModel $group)
    {
        $service = new GroupDAO();
        return $service->createGroup($group);
    }
    
    public function editGroup(GroupModel $group)
    {
        $service = new GroupDAO();
        return $service->editGroup($group);
    }
    
    public function deleteGroup($groupID)
    {
        $service = new GroupDAO();
        return $service->deleteGroup($groupID);
    }
    
    public function addUser($userID, $groupID)
    {
        $service = new GroupDAO();
        return $service->addUser($userID, $groupID);
    }
    
    public function removeUser($userID, $groupID)
    {
        $service = new GroupDAO();
        return $service->removeUser($userID, $groupID);
    }
    
    public function adminRemoveUser($username, $groupID)
    {
        $service = new GroupDAO();
        return $service->adminRemoveUser($username, $groupID);
    }
    
    public function addAdmin($adminID, $groupID)
    {
        $service = new GroupDAO();
        return $service->addAdmin($adminID, $groupID);
    }
    
    public function getGroupMembers($memberID)
    {
        $service = new GroupDAO();
        return $service->getGroupMembers($memberID);
    }
}

