<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Date;

class SystemController extends Controller
{

    //日志列表
    public function log(Request $request)
    {
        //逻辑
        $where = array();
        $date = $request->get('date');
        if(!empty($date)) {
            $where[] = array('created_at','>=',$date);
        }
        $logs = DB::table('admin_logs')->where($where)->orderBy('created_at','desc')->get();

        //返回
        return view('admin.system.log',compact('logs'));
    }


    //日期列表
    public function date(Request $request)
    {
        //逻辑
        $where = array();       //查询条件
        $note = $request->get('note');
        if(($note != null) && ($note != "全部")) {
            $where[] = array('note',$note);
        }else{
            $date = $request->get('start');
            if(!empty($date)) {
                $where[] = array('date',$date);
            }
        }
        $dates = Date::where($where)->get();

        //返回
        return view('admin.system.index',compact('dates'));
    }


    //上班-休息
    public function state()
    {
        //验证
        $this->validate(request(),[
            'state' => 'required|in:0,1',
        ]);

        //逻辑
        $date = Date::find(request('id'));
        if(request('state') == 1) {
            $date->note = "上班";
        }else{
            $date->note = "休息";
        }
        $date->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //插入日期
    public function add()
    {
        for($i=0;$i<=3650;$i++){
            $date[$i]['date'] = date('Y-m-d',time() + $i*86400);
            $date[$i]['note'] = "上班";
        }
        DB::table('dates')->insert($date);
    }


    //仓库列表
    public function warehouse(Request $request)
    {
        //逻辑
        $where = array();
        $name = $request->get('name');
        if((!empty($name)) && ($name != '全部') ) {
            $where[] = array('name','=',$name);
        }
        $warehouse = DB::table('warehouse')->where($where)->get();
        //仓库分类
        $sorts = DB::table('warehouse')->select('name')->groupBy('name')->get();

        //返回
        return view('admin.system.warehouse',compact('warehouse','sorts'));
    }


    //添加仓库
    public function warehouse_add(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'name' => 'required|unique:warehouse|min:1|max:10',
        ]);

        //逻辑
        DB::table('warehouse')->insert([
            'name' => $request->get('name'),
        ]);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            200
        );
    }


    //添加库位
    public function location_add(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:10',
            'location' => 'required|min:1|max:10',
        ]);

        //逻辑
        $null = DB::table('warehouse')->where('name',$request->get('name'))->whereNull('location')->first();
        if($null){
            DB::table('warehouse')->where('id',$null->id)->update([
                'location' => $request->get('location'),
            ]);
        }else{
            DB::table('warehouse')->insert([
                'name' => $request->get('name'),
                'location' => $request->get('location'),
            ]);
        }

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            200
        );
    }


    //修改库位名称
    public function location_update(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'location' => 'required|min:1|max:10',
        ]);

        //逻辑
        DB::table('warehouse')->where('id',$request->get('id'))->update([
            'location' => $request->get('location'),
        ]);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            200
        );
    }


    //删除库位
    public function delete(Request $request)
    {
        //逻辑
        $id = $request->get('id');
        DB::table('warehouse')->where('id',$id)->delete();

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            200
        );
    }

}
