<?php

namespace ViralsInfyom\ViralsPermission\Http\Middleware;

use ViralsInfyom\ViralsPermission\Services\PermissionService;
use ViralsInfyom\ViralsPermission\Services\RoleService;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissionMiddleware
{
    protected $permissionService;
    protected $roleService;

    public function __construct(PermissionService $permissionService, RoleService $roleService)
    {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->path();
        $method = $request->getMethod();
        $permission = $this->permissionService->findByUriAndMethod($method, $uri);
        if (!$permission) {
            return $next($request);
        }
        if ($permission) {
            $permissionUser = $this->roleService->findRoles(Auth::user()->roles->pluck('id')->toArray());
            $collection = collect($permissionUser);

            $collapseUser = array_unique($collection->collapse()->toArray());

            $permissionExtra = Auth::user()->permissions->pluck('id')->toArray();
            $totalPermissionUser = array_unique(array_merge($collapseUser, $permissionExtra));
            if (in_array($permission->id, $totalPermissionUser)) {
                return $next($request);
            } else {
                return abort('404');
            }
        }
    }
}
