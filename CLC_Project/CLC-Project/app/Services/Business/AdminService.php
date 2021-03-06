<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Admin service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;
use App\Services\Data\AdminDAO;

class AdminService
{
    public function getAllUsers()
    {
        $service = new AdminDAO();
        return $service->getAllUsers();
    }
    
    public function findByID($userID)
    {
        $service = new AdminDAO();
        return $service->findByID($userID);
    }
    
    public function suspendUser($userID)
    {
        $service = new AdminDAO();
        return $service->suspendUser($userID);
    }
    
    public function unsuspendUser($userID)
    {
        $service = new AdminDAO();
        return $service->unsuspendUser($userID);
    }
    
    public function banUser($userID)
    {
        $service = new AdminDAO();
        return $service->banUser($userID);
    }
    
    public function unbanUser($userID)
    {
        $service = new AdminDAO();
        return $service->unbanUser($userID);
    }
    
    public function updateRole($role, $userID)
    {
        $service = new AdminDAO();
        return $service->updateRole($role, $userID);
    }
    
    public function deleteUser($userID)
    {
        $service = new AdminDAO();
        return $service->deleteUser($userID);
    }
}

