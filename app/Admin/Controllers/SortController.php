<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use \App\Sort;

class SortController extends Controller
{

    //分类列表
    public function index()
    {
        //逻辑
        $sort = Sort::get();

        //返回
        return view('admin.sort.index',compact('sort'));
    }


    //新增分类
    public function create()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|unique:goods_sort,name|max:255',
        ]);

        //逻辑
        Sort::create(['name'=>request('name')]);

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //修改分类
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


    //删除分类
    public function delete()
    {
        Sort::destroy(request('id'));

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }

}
