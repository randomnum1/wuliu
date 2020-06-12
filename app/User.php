<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $guarded = []; // 不可以注入的字段

    //关联地址
    public function addresses()
    {
        return $this->hasMany('App\Address')->orderBy('state', 'desc');
    }


}
