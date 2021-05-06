<?php
namespace App\Services\Business;
use App\Services\Data\GroupDAO;
use App\Models\GroupModel;

class GroupService
{
    public function getGroup($groupID)
    {
        $service = new GroupDAO();
        return $service->getGroup($groupID);
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
    
    public function addAdmin($adminID, $groupID)
    {
        $service = new GroupDAO();
        return $service->addAdmin($adminID, $groupID);
    }
}

