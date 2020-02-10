<?php


namespace ViralsInfyom\ViralsPermission\Services;

use ViralsInfyom\ViralsPermission\Models\Role;

class RoleService
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->with('permissions')->get();
    }

    public function paginate()
    {
        return $this->role->with('permissions')->paginate(10);
    }

    public function create($data)
    {
       $roles = $this->role->create(['name' => $data['name']]);
        $roles->permissions()->attach($data['permissions']);
        return $roles;
    }

    public function find($id)
    {
        return $this->role->with('permissions')->findOrFail($id);
    }

    public function findRoles($roles)
    {
        $roles = $this->role->with('permissions')->whereIn('id', $roles)->get();
        $permissions = [];
        foreach ($roles as $role)
        {
            $permissionRole = $role->permissions->pluck('id')->toArray();
            $permissions[] = $permissionRole;
        }
        return $permissions;
    }

    public function update($data)
    {
        $roles = $this->role->with('permissions')->find($data['id']);
        $roles->update(['name' => $data['name']]);
        $roles->permissions()->detach();
        $roles->permissions()->attach($data['permissions']);
        return $roles;
    }

    public function destroy($id)
    {
        $roles = $this->role->with('permissions')->find($id);
        $roles->permissions()->detach();
        $roles->delete();
    }
}