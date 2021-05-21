<?php
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

