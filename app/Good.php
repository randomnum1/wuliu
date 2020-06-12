<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $guarded = [];

    //关联商品类型
    public function sort()
    {
        return $this->belongsTo('App\sort','sort_id','id');
    }
}
