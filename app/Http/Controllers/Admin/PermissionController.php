<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Spatie\Permission\Models\Permission as SpatiePermission;
/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends Controller
{
    public $gService;
    public string $viewFolder = 'permission';
    public string $route = 'roles';

    public function __construct()
    {
        $this->gService = new GeneralService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }

        $permissions = SpatiePermission::paginate();
        $roles = Role::all();
        return view($this->viewFolder.'.index', compact('permissions','roles'))
            ->with('i', (request()->input('page', 1) - 1) * $permissions->perPage());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }

        $permission = new SpatiePermission();
        return view($this->viewFolder.'.create', compact('permission'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }
        SpatiePermission::create(['name'=>$request->name]);

        return redirect()->route($this->route.'.index')
            ->with('success', 'Permission created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }

        $permission = SpatiePermission::find($id);

        return view($this->viewFolder.'.show', compact('permission'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }

        $permission = SpatiePermission::find($id);

        return view($this->viewFolder.'.edit', compact('permission'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SpatiePermission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SpatiePermission $permission)
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }
        $permission->update($request->all());
        return redirect()->route($this->route.'.index')
            ->with('success', 'Permission updated successfully');
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }
        SpatiePermission::find($id)->delete();
        return redirect()->route($this->route.'.index')
            ->with('success', 'Permission deleted successfully');
    }

    public function assignRolePermission(Request $request){

        if (!request()->user()->can('permissions.manage')){
            return abort('403');
        }

        $permissionId = $request->permissionId;
        $roleId = $request->roleId;
        $role = Role::find($roleId);
        if ($request->createNew == 'true'){
            $role->givePermissionTo($permissionId);
        }else{
            $role->revokePermissionTo($permissionId);
        }
        return true;
    }
}
