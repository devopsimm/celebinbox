<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    public GeneralService $gService;
    public UserService $service;
    public string $viewFolder = 'user';
    public static string $route = 'users';


    public function __construct()
    {
        $this->gService = new GeneralService();
        $this->service = new UserService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {

            if (!request()->user()->can('users.view')){
                return abort('403');
            }
            $users = $this->service->index();

            return view($this->viewFolder.'.index', compact('users'))
                ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
        }
        catch (\Exception $exception){
            return $this->gService->handleException($exception,'dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        if (!request()->user()->can('users.create')){
            return abort('403');
        }
        $data = $this->service->formData();
        return view($this->viewFolder.'.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!request()->user()->can('users.create')){
            return abort('403');
        }
        request()->validate(User::$rules);
        $create = $this->service->save($request);

        return redirect()->route('users.index')
            ->with('success', $create['msg']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        if (!request()->user()->can('users.view')){
            return abort('403');
        }
        $data = $this->service->formData($id);
        return view($this->viewFolder.'.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        if (!request()->user()->can('users.edit')){
            return abort('403');
        }
        $data = $this->service->formData($id);

        return view($this->viewFolder.'.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (!request()->user()->can('users.edit')){
            return abort('403');
        }
        $roles = User::$rules;
        unset($roles['email']);
        request()->validate($roles);
        $update = $this->service->save($request,$user);
        return redirect()->route('users.index')
            ->with('success', $update['msg']);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (!request()->user()->can('users.delete')){
            return abort('403');
        }
        $delete = $this->service->destroy($id);

        return redirect()->route('users.index')
            ->with('success', $delete['msg']);
    }

    public function myProfileUpdate(Request $request,User $user){
        $service = new UserService();
        $update = $service->save($request,$user);
        return redirect()->back()->with('success', $update['msg']);
    }
    public function myProfileUpdatePassword(Request $request,User $user){
        $roles = User::$rules;
        unset($roles['email']);
        unset($roles['name']);
        request()->validate($roles);

        $update = $this->service->save($request,$user);
        return redirect()->back()->with('success', $update['msg']);
    }

}
