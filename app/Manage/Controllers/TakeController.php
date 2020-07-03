<?php

namespace App\Manage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakeController extends Controller
{

    //未取件列表
    public function noTake()
    {
        //邮寄
        $mails = DB::table('mails')->select('number','a_province','a_city','a_area','a_detail','a_postcode','date')
            ->where('state','待取件')->get();
        //寄存

        $noTake = [];
        foreach ($mails as $k=>$v) {
            $temp['number'] = $v->number;
            $temp['address'] = $v->a_province.$v->a_city.$v->a_area.$v->a_detail;
            $temp['postcode'] = $v->a_postcode; $temp['time'] = $v->date;
            $temp['items'] = '';
            $items = DB::table('items')->select('sort','number')->where('mail_number',$temp['number'])->orderBy('number','asc')->get();
            foreach($items as $a=>$b){
                if($b->sort == '其他'){
                    $temp['items'] .= $b->number;
                }else{
                    $temp['items'] .= $b->sort.$b->number.',';
                }
            }
            array_push($noTake,$temp);
        }

        return response()->json(
            $data = $noTake,
            $status = 200
        );
    }


    /**
     * 已取件列表接口
     * 返回一周内的取件记录
     * */
    public function take()
    {
        //邮寄
        $start = date('Y-m-d H:i:s',time()-86400*7);
        $end = date('Y-m-d H:i:s',time());
        $mails = DB::table('mails')->select('number','a_province','a_city','a_area','a_detail','a_postcode','date')
            ->where([['state','!=','待取件'],['take_time','>=',$start],['take_time','<=',$end]])->get();
        //寄存

        $take = [];
        foreach ($mails as $k=>$v){
            $temp['number'] = $v->number;
            $temp['address'] = $v->a_province.$v->a_city.$v->a_area.$v->a_detail;
            $temp['postcode'] = $v->a_postcode;
            $temp['time'] = $v->date;
            $items = DB::table('items')->select('sort','number')->where('mail_number',$temp['number'])->orderBy('number','asc')->get();
            $temp['items'] = '';
            foreach($items as $a=>$b){
                if($b->sort == '其他'){
                    $temp['items'] .= $b->number;
                }else{
                    $temp['items'] .= $b->sort.$b->number.',';
                }
            }
            array_push($take,$temp);
        }

        //返回
        return response()->json(
            $data = $take,
            $status = 200
        );
    }


    /**
     * 代取件详情
     * params orderNUmber
     * */
    public function show(Request $request)
    {
        //编号
        $number = $request->get('number');

        //根据类型整理数据
        $orderSort = substr($number,0,2);
        switch ($orderSort){
            case 'YJ':
                $order = DB::table('mails')
                    ->select('id','number','a_country','a_en_name','a_cn_name','a_phone','a_email','a_province','a_city','a_area','a_detail','a_postcode','b_country','b_en_name','b_cn_name','b_phone','b_email','b_province','b_city','b_area','b_detail','b_postcode','type','date','packaging','tax','note')
                    ->where('number',$number)->first();
            break;
        }
        $order = json_decode(json_encode($order), true);
        $order['take_user'] = $request->session()->get('manage.real_name');

        //物品
        $items = DB::table('items')->select('sort','number')->where('mail_number',$number)->orderBy('number','asc')->get();
        $items = json_decode(json_encode($items), true);
        $order['itemsArr'] = $items;
        $order['items'] = '';
        foreach($items as $a=>$b){
            if($b['sort'] == '其他'){
                $order['items'] .= $b['number'];
            }else{
                $order['items'] .= $b['sort'].$b['number'].',';
            }
        }

        //日期
        $now = date('Y-m-d H:i:s',time());
        $order['dateArr'] = DB::table('dates')->select('date')->where([['note','上班'],['date','>',$now]])->take(6)->get();

        //返回
        return response()->json(
            $data = $order,
            $status = 200
        );
    }


    /**
     * 代取件信息修改
     * params
     * */
    public function update(Request $request)
    {
        $number = $request->get('number');                          //订单编号
        $orderSort = substr($number,0,2);                   //订单类型

        //验证
        $this->doValidate($request,$orderSort);

        //逻辑
        $take_user = $request->session()->get('manage.real_name');  //取件员
        $take_time = date('Y-m-d H:i:s',time());                 //取件时间
        $state = "待入库";

        //根据类型修改订单信息
        switch ($orderSort){
            case 'YJ':
                $params = array_merge(request(['a_en_name','a_cn_name','a_phone','a_email','a_province','a_city','a_area','a_detail','a_postcode','b_en_name','b_cn_name','b_phone','b_email','b_province','b_city','b_area','b_detail','b_postcode','type','date','packaging','tax','note']),compact('take_time','take_user','state'));
                DB::table('mails')->where('number',$number)->update($params);
            break;
        }

        //修改物品信息
        DB::table('items')->where('mail_number',$number)->delete();
        $items = request('itemsArr');
        foreach ($items as $k=>$v){
            $items[$k]['mail_number'] = $number; $items[$k]['created_at'] = $take_time; $items[$k]['updated_at'] = $take_time;
        }
        DB::table('items')->insert($items);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            $status = 200
        );
    }


    //验证取件数据
    public function doValidate($request,$orderSort)
    {
        if($orderSort == 'YJ'){
            $validatedData = $request->validate([
                'a_en_name' => 'required|min:1',
                'a_cn_name' => 'required|min:1',
                'a_phone' => 'required|min:1',
                'a_email' => 'required|min:1',
                'a_province' => 'required|min:1',
                'a_city' => 'present',
                'a_area' => 'present',
                'a_detail' => 'required|min:1',
                'a_postcode' => 'required|min:1',
                'b_en_name' => 'required|min:1',
                'b_cn_name' => 'required|min:1',
                'b_phone' => 'required|min:1',
                'b_email' => 'required|min:1',
                'b_province' => 'required|min:1',
                'b_city' => 'present',
                'b_area' => 'present',
                'b_detail' => 'required|min:1',
                'b_postcode' => 'required|min:1',
                'itemsArr' => 'required',
                'itemsArr.*.sort' => 'required|min:1',
                'itemsArr.*.number' => 'required|min:1',
                'type' => 'required|min:1',
                'date' => 'required|date',
                'packaging' => 'required|in:0,1',
                'tax' => 'required|in:0,1',
                'note' => 'present',
            ]);
        }
    }

}
