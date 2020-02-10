<?php

namespace ViralsInfyom\ViralsPermission\Controllers\Admin;

use ViralsInfyom\ViralsPermission\Controllers\Controller;
use ViralsInfyom\ViralsPermission\Requests\CreateRolesRequest;
use ViralsInfyom\ViralsPermission\Requests\UpdateRolesRequest;
use ViralsInfyom\ViralsPermission\Services\PermissionService;
use ViralsInfyom\ViralsPermission\Services\RoleService;

class RoleController extends Controller
{
    /**
     * @var PermissionService
     * @var RoleService
     */
    protected $permissionService;
    protected $roleService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        parent::__construct();
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleService->paginate();
        return view('virals-permission::admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionService->all();
        return view('virals-permission::admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolesRequest $request)
    {
        $this->roleService->create($request->all());
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->roleService->find($id);
        return response()->json($role->permissions->pluck('id')->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleService->find($id);
        $permissions = $this->permissionService->all();
        return view('virals-permission::admin.roles.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        $this->roleService->update($request->all());
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->roleService->destroy($id);
        return redirect()->route('admin.roles.index');
    }
}
