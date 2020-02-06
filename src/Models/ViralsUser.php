<?php


namespace ViralsInfyom\ViralsPermission\Models;

use App\User;
use ViralsInfyom\ViralsPermission\Models\Traits\InheritsRelationsFromParentModel;

class ViralsUser extends User
{
    use InheritsRelationsFromParentModel;

    protected $table = 'users';
    public function roles()
    {
        return $this->belongsToMany('ViralsInfyom\ViralsPermission\Models\Role', 'user_role', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('ViralsInfyom\ViralsPermission\Models\Permission', 'user_permission', 'user_id', 'permission_id');
    }
}