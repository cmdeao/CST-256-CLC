<?php
/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Security service class will pass operations into the appropriate
 * Data Access Object (DAO) along with parameters and return the
 * appropriate data or results of operation within the DAO.
 */

namespace App\Services\Business;

use App\Models\SecurityModel;
use App\Services\Data\SecurityDAO;

class SecurityService
{
    public function login(SecurityModel $user)
    {
        $service = new SecurityDAO();
        return $service->findUser($user);
    }
    
    public function getAllUsers()
    {
        $service = new SecurityDAO();
        return $service->getAllUsers();
    }
    
    public function getUser($id)
    {
        $service = new SecurityDAO();
        return $service->findByUserID($id);
    }
}

