<?php

namespace App\Admin\Controllers;

use App\AdminPermission;
use Illuminate\Http\Request;
use \App\AdminUser;


class UserController extends Controller
{

    //管理员列表
    public function index()
    {
//        $user = AdminUser::find(1)->permissions;
//        $permission = \App\AdminPermission::find(1);
//        $user->hasPermission($permission);

//        $permission = \App\AdminPermission::find(1);
//        $res = AdminUser::find(1)->permissions->contains($permission);
//        dd($res);

        $user = AdminUser::get();
        return view('admin.user.index',compact('user'));
    }


    //新增管理员
    public function create()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|unique:admin_users,name|min:1',
            'password' => 'required|min:1'
        ]);

        //逻辑
        $name = request('name');
        $password = bcrypt(request('password'));
        $parameter = compact('name','password');
        AdminUser::create($parameter);

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //修改管理员
    public function update()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|unique:admin_users,name|min:1',
        ]);

        //逻辑
        $user = AdminUser::find(request('id'));
        $user->name = request('name');
        $user->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //删除管理员
    public function delete()
    {
        AdminUser::destroy(request('id'));

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //重置密码
    public function setting()
    {
        //验证
        $this->validate(request(),[
            'password' => 'required|min:1'
        ]);

        //逻辑
        $user = AdminUser::find(request('id'));
        $user->password = bcrypt(request('password'));
        $user->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //管理员权限
    public function auth(AdminUser $user)
    {
        //所有权限
        $permissions = \App\AdminPermission::all();
        //用户的权限
        $user_permissions = $user->permissions;

        return view('admin.user.auth',compact('user','permissions','user_permissions'));
    }


    //权限修改
    public function doauth()
    {
        //验证


        //逻辑


        //返回


    }


}
