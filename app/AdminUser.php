<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $guarded = []; // 不可以注入的字段

    protected $rememberTokenName = "";

    //关联用户的权限
    public function permissions()
    {
        return $this->belongsToMany('App\AdminPermission','admin_user_permissions','user_id','permission_id');
    }

    //用户是否有权限
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }


}

