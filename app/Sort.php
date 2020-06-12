<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    protected $table = "goods_sort";

    protected $guarded = [];

    //关联商品
    public function goods()
    {
        return $this->hasMany('App\Good','sort_id','id');
    }

}
