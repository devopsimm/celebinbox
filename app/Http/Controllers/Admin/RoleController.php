<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    public GeneralService $gService;
    public string $viewFolder = 'role';
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
        if (!request()->user()->can('roles.view')){
            return abort('403');
        }
        $roles = Role::paginate();

        return view($this->viewFolder.'.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('roles.create')){
            return abort('403');
        }
        $role = new Role();
        return view($this->viewFolder.'.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('roles.create')){
            return abort('403');
        }
        request()->validate(Role::$rules);

        $role = Role::create($request->all());

        return redirect()->route($this->route.'.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('roles.view')){
            return abort('403');
        }
        $role = Role::find($id);

        return view($this->viewFolder.'.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('roles.edit')){
            return abort('403');
        }
        $role = Role::find($id);

        return view($this->viewFolder.'.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        if (!request()->user()->can('roles.edit')){
            return abort('403');
        }
        request()->validate(Role::$rules);

        $role->update($request->all());

        return redirect()->route($this->route.'.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('roles.delete')){
            return abort('403');
        }

        $role = Role::find($id)->delete();

        return redirect()->route($this->route.'.index')
            ->with('success', 'Role deleted successfully');
    }
}
