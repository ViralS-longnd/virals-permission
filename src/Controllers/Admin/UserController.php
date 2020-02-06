<?php

namespace ViralsInfyom\ViralsPermission\Controllers\Admin;

use ViralsInfyom\ViralsPermission\Controllers\Controller;
use ViralsInfyom\ViralsPermission\Requests\CreateUserRequest;
use ViralsInfyom\ViralsPermission\Requests\EditUserRequest;
use ViralsInfyom\ViralsPermission\Services\PermissionService;
use ViralsInfyom\ViralsPermission\Services\RoleService;
use Illuminate\Http\Request;
use ViralsInfyom\ViralsPermission\Services\UserService;

class UserController extends Controller
{
    /**
     * @var PermissionService
     * @var RoleService
     */
    protected $permissionService;
    protected $roleService;
    protected $userService;

    public function __construct(RoleService $roleService, PermissionService $permissionService, UserService $userService)
    {
        parent::__construct();
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->all();
        return view('virals-permission::admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionService->all();
        $roles = $this->roleService->all();
        return view('virals-permission::admin.users.create', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        $this->userService->create($request->except(['_token', 'password_confirmation']));
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = $this->permissionService->all();
        $roles = $this->roleService->all();
        $user = $this->userService->find($id);
        $permissionUser = $this->roleService->findRoles($user->roles->pluck('id')->toArray());
        $collection = collect($permissionUser);

        $collapseUser = array_unique($collection->collapse()->toArray());
        return view('virals-permission::admin.users.edit', compact('permissions', 'roles', 'user', 'collapseUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $this->userService->update($request->all());
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPermission(Request $request)
    {
        $collapsed = [];
        if($request->has('roles')) {
            $permissions = $this->roleService->findRoles($request->roles);
            $collection = collect($permissions);

            $collapsed = $collection->collapse()->toArray();
        }
        return response()->json(array_unique($collapsed));
    }
}
