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
}

