<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\User;
use Excel;

class MemberController extends Controller
{

    //会员列表
    public function index(Request $request)
    {
        //逻辑
        $where = array();       //查询条件
        $nickname = $request->get('nickname');
        if(!empty($nickname)) {
            $where[] = array('nickname','like','%'.$nickname.'%');
        }
        $date = $request->get('date');
        if(!empty($date)) {
            $where[] = array('created_at','>',$date);
        }
        $user = User::where($where)->orderBy('updated_at','desc')->get();

        //返回
        return view('admin.member.index',compact('user'));
    }


    //修改会员积分
    public function update()
    {
        //验证
        $this->validate(request(),[
            'score' => 'required|integer|min:0',
        ]);

        //逻辑
        $user = User::find(request('id'));
        $user->score = request('score');
        $user->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //关联会员收货地址
    public function address(Request $request)
    {
        //逻辑
        $id = $request->get('id');
        $address = User::where('id',$id)->first()->addresses;

        //渲染
        return view('admin.member.address',compact('address'));
    }


    //导出会员数据
    public function export1()
    {
        ini_set('memory_limit','500M');
        set_time_limit(0);

        //数据
        $user = User::select('nickname','score','created_at','updated_at')->orderBy('updated_at','desc')->get()->toArray();

        $cellData = [
            ['微信昵称','积分','关注时间','最后登录时间'],
        ];
        $cellData = array_merge($cellData,$user);

        //导出逻辑
        Excel::create('会员表',function($excel) use ($cellData){
            $excel->sheet('user', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    //导出会员数据
    public function export()
    {
        ini_set('memory_limit','500M');
        set_time_limit(0);

        //数据
        $user = User::select('nickname','score','created_at','updated_at')->orderBy('updated_at','desc')->get()->toArray();

        $cellData = [
            ['微信昵称','积分','关注时间','最后登录时间'],
        ];
        $cellData = array_merge($cellData,$user);

        //导出逻辑
        Excel::create('会员表',function($excel) use ($cellData){
            $excel->sheet('user', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }



}
