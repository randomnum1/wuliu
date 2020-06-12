<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $guarded = []; // 不可以注入的字段

    protected $rememberTokenName = "";
}
