<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Good;
use App\Sort;


class GoodsController extends Controller
{

    //商城首页
    public function index()
    {
        //逻辑
        $data['sort'] = Sort::select('id','name')->get()->toArray();
        foreach ($data['sort'] as $k=>$v) {
            $data['sort'][$k]['goods'] = Good::select('id','name','price','unit','picture')->where('sort_id',$v['id'])->get()->toArray();
        }

        //返回
        return response()->json(
            $data,
            200
        );
    }


    //商城详情页
    public function show(Request $request)
    {


    }


    //购物车接口
    public function car(Request $request)
    {


    }


    //订单提交接口


}
