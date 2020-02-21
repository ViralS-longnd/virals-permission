<?php
namespace ViralsInfyom\ViralsPermission\Models\Traits;

use Illuminate\Support\Facades\Auth;
use ViralsInfyom\ViralsPermission\Services\PermissionService;
use ViralsInfyom\ViralsPermission\Services\RoleService;

trait CheckPermissionTrait
{
    public function checkRoute($route)
    {
        $routeAction = \Route::getRoutes()->getByName($route);
        if (!$routeAction) {
            return false;
        }
        $uri = $routeAction->uri;
        $methods = $routeAction->methods();
        foreach ($methods as $method)
        {
            if ($method != 'HEAD' && $method != 'OPTIONS') {
                return $this->checkPermission($method, $uri);
            }
        }
    }

    private function checkPermission($method, $uri)
    {
        $permissionService = app()->make(PermissionService::class);
        $roleService = app()->make(RoleService::class);
        $permission = $permissionService->findByUriAndMethod($method, $uri);
        if (!$permission) {
            return true;
        }
        if ($permission) {
            $permissionUser = $roleService->findRoles(Auth::user()->roles->pluck('id')->toArray());
            $collection = collect($permissionUser);

            $collapseUser = array_unique($collection->collapse()->toArray());
            $permissionExtra = Auth::user()->permissions->pluck('id')->toArray();
            $totalPermissionUser = array_unique(array_merge($collapseUser, $permissionExtra));
            if (in_array($permission->id, $totalPermissionUser)) {
                return true;
            } else {
                return false;
            }
        }
    }
}