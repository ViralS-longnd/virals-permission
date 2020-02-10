<?php


namespace ViralsInfyom\ViralsPermission\Services;

use ViralsInfyom\ViralsPermission\Models\ViralsUser;

class UserService
{
    protected $user;

    public function __construct(ViralsUser $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->with('permissions', 'roles')->get();
    }

    public function paginate()
    {
        return $this->user->with('permissions', 'roles')->paginate(10);
    }

    public function create($data)
    {
        $users = $this->user->create($data);
        if (array_key_exists('permissions', $data)) {
            $users->permissions()->attach($data['permissions']);
        }
        $users->roles()->attach($data['roles']);
        return $users;
    }

    public function find($id)
    {
        return $this->user->with('permissions', 'roles')->findOrFail($id);
    }

    public function update($data)
    {
        $users = $this->user->with('permissions', 'roles')->find($data['id']);
        $users->update(['name' => $data['name']]);
        $users->permissions()->detach();
        if (array_key_exists('permissions', $data)) {
            $users->permissions()->attach($data['permissions']);
        }
        $users->roles()->detach();
        $users->roles()->attach($data['roles']);
        return $users;
    }

    public function destroy($id)
    {
        $roles = $this->user->with('permissions')->find($id);
        $roles->permissions()->detach();
        $roles->delete();
    }
}