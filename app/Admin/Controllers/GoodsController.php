<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Sort;
use \App\Good;

class GoodsController extends Controller
{

    //商品列表
    public function index()
    {
        //逻辑
        $goods = DB::table('goods')->select('goods.*','goods_sort.name as sortname')
            ->leftJoin('goods_sort','goods.sort_id','=','goods_sort.id')
            ->get();
        $sorts = Sort::get();

        //返回
        return view('admin.goods.index',compact('goods','sorts'));
    }


    //商品详情页面
    public function show(Good $goods)
    {
        $goods = DB::table('goods')->select('goods.*','goods_sort.name as sortname')
            ->leftJoin('goods_sort','goods.sort_id','=','goods_sort.id')
            ->get();
        return view('admin.goods.show',compact('goods'));
    }


    //商品新增
    public function create()
    {
        return view('admin.goods.create');
    }


    //商品新增行为
    public function store()
    {

    }


    //商品编辑
    public function edit(Good $goods)
    {
        return view('admin.goods.edit');
    }


    //商品编辑行为
    public function update()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|unique:goods_sort,name|max:255',
        ]);

        //逻辑
        $sort = Sort::find(request('id'));
        $sort->name = request('name');
        $sort->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //商品上下架
    public function state()
    {
        //验证
        $this->validate(request(),[
            'state' => 'required|in:0,1',
        ]);

        //逻辑
        $goods = Good::find(request('id'));
        $goods->state = request('state');
        $goods->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //商品删除
    public function delete()
    {
        Good::destroy(request('id'));

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //商品导出
    public function export()
    {
        return 'success';
    }

}
