<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class China extends Model
{
    protected $table = "china";

    protected $guarded = []; // 不可以注入的字段
}
