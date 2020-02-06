<?php

namespace ViralsInfyom\ViralsPermission\Controllers\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use ViralsInfyom\ViralsPermission\Controllers\Controller;
use ViralsInfyom\ViralsPermission\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $method = $request->get('method') ?? '';
        // Start displaying items from this number;
        $offSet = ($page * 10) - 10; // Start displaying items from this number
        $permissionData = $this->permissionService->getRoutePermissions($request->get('method'));
        $itemsForCurrentPage = array_slice($permissionData, $offSet, 10, true);
        $permissions = new LengthAwarePaginator($itemsForCurrentPage, count($permissionData), 10, $page, ['path' => route('admin.permission.index')]);
        return view('virals-permission::admin.permissions.index', compact('permissions', 'method'));
    }

    public function validate_index()
    {
        if(Auth::user()->email != 'admin@viralsoft.vn') {
            abort('403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = $this->permissionService->findByUriAndMethod($request->input('method'), $request->input('uri'));
        if ($permission) {
            $permission->update(['name' => $request->name]);
        } else {
            $permission = $this->permissionService->create($request->except('_token'));
        }
        return response()->json($permission->toArray());
    }

    public function validate_store()
    {
        if(Auth::user()->email != 'admin@viralsoft.vn') {
            abort('403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->permissionService->delete($id);
    }

    public function validate_destroy()
    {
        if(Auth::user()->email != 'admin@viralsoft.vn') {
            abort('403');
        }
    }
}
