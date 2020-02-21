<?php


namespace ViralsInfyom\ViralsPermission\Services;

use ViralsInfyom\ViralsPermission\Models\Permission;
use Illuminate\Support\Facades\Route;

class PermissionService
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->all();
    }

    public function getRoutePermissions($method)
    {
        $routeGroups = Route::getRoutes()->getRoutesByMethod();
        $routeData = [];
        if (in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            $routeData[$method] = $routeGroups[$method];
        } else {
            $routeData = $routeGroups;
        }
        $permissionDatabases = $this->all();
        $permissions = [];
        $permissionsId = [];
        foreach ($routeData as $key => $routes) {
            if ($key != 'HEAD' && $key != 'OPTIONS') {
                foreach ($routes as $uri => $route) {
                    $permission['method'] = $key;
                    $permission['uri'] = $route->uri;
                    $checkPermission = $permissionDatabases->where('method', $key)->where('uri', $route->uri)->first();
                    if ($checkPermission) {
                        $permission['name'] = $checkPermission->name;
                        $permission['id'] = $checkPermission->id;
                        $permissionsId[] = $checkPermission->id;
                    } else {
                        $permission['id'] = '';
                        $permission['name'] = '';
                    }
                    $permission['status'] = true;
                    $permissions[] = $permission;
                }
            }
        }
        $deleteRouteQuery = $this->permission->whereNotIn('id', $permissionsId);
        if (in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            $deleteRouteQuery->where('method', $method);
        }
        $deleteRoute = $deleteRouteQuery->get();
        foreach ($deleteRoute as $route) {
            $permission['method'] = $route->method;
            $permission['uri'] = $route->uri;
            $permission['name'] = $route->name;
            $permission['id'] = $route->id;
            $permission['status'] = false;
            $permissions[] = $permission;
        }
        return $permissions;
    }

    public function create($data)
    {
        return $this->permission->create($data);
    }

    public function findByUriAndMethod($method, $uri)
    {
        return $this->permission->where('method', $method)->where('uri', $uri)->first();
    }


    public function delete($id)
    {
        $permission = $this->permission->find($id);
        $permission->delete();
    }
}