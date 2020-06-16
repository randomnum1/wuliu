<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $guarded = []; // 不可以注入的字段

    protected $table = "admin_permissions";

}

