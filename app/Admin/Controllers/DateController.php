<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Date;


class DateController extends Controller
{

    //日期列表
    public function index(Request $request)
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
        return view('admin.date.index',compact('dates'));
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
}
