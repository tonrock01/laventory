<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index(array $data)
    {
        return Role::get()->select('id', 'name');
    }

    public function assignRole(array $data, User $user)
    {
        return $user->assignRole($data['role_name']) ? true : false;
    }
}
