<?php

namespace App\Services;

use App\Http\Helpers\General\Helper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public array $specificationExcept = ['_token','_method', ];

    public array $return =  ['type'=>'success','msg' => 'User saved successfully'];

    public function __construct()
    {
        $this->gService = new GeneralService();
    }

    public function index(){
        return User::paginate();
    }

    public function formData($id=false){
        $user = new User();
        $roles = Role::all();
        if ($id){
            $user = $user::find($id);
        }
        return [
            'user'=>$user,
            'roles' =>$roles
        ];

    }
    public function destroy($id){
        User::find($id)->delete();
        $this->return['msg'] = 'User Successfully Removed';
        return $this->return;
    }



    public function save($request,$user=false){

        $data = $request->all();
        if ($user == false){

            $dbData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ];
            $user = User::create($dbData);
            $user->assignRole($data['role']);

            $this->return['msg'] = 'User Successfully created';
        }else{

            $dbData = [];
            if ($request->name){
                $dbData['name'] = $data['name'];
            }
            if ($request->password){
                $dbData['password'] = Hash::make($data['password']);
            }
            User::where('id',$user->id)->update($dbData);
            if ($request->role){
                $user->roles()->detach();
                $user->assignRole($data['role']);
            }
            $this->return['msg'] = 'User updated successfully';
        }

        return $this->return;
    }





}
