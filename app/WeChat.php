<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class WeChat extends Authenticatable
{
    protected $table = "users";

    protected $guarded = []; // 不可以注入的字段

    protected $rememberTokenName = "";

}

