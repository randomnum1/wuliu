<?php

namespace App\Http\Controllers;

use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Mail;
use \App\Items;

class TestController extends Controller
{

    public function index()
    {
        return view('test.index');
    }


    public function number()
    {
        $time = date('Y-m-d',time());
        $oldNumber = DB::table('mails')->where('order_time','>',$time)->orderBy('id','desc')->value('number');

        if($oldNumber) {
            $count = substr($oldNumber,-3);
            $count++;
        }else{
            $count = 1;
        }

        $newNumber = 'YJ-'.date('ymd',time()).str_pad($count,3,"0",STR_PAD_LEFT );
        return $newNumber;
    }


    public function test(Request $request)
    {
        //打印sql
//        DB::connection()->enableQueryLog();
//        dd(DB::getQueryLog());

        //验证
        $validated = $request->validate([
            'a_id' => 'required|numeric',
            'b_id' => 'required|numeric',
            'type' => 'required|max:255',
            'date' => 'required|max:255',
            'packaging' => 'required|in:0,1',
            'tax' => 'required|in:0,1',
            'note' => 'nullable|max:255',
        ]);

        //逻辑
        $number = $this->number();      //订单编号

        //数据处理
        $aAddress = DB::table('addresses')->select('country as a_country','en_name as a_en_name','cn_name as a_cn_name','phone as a_phone','email as a_email','province as a_province','city as a_city','area as a_area','detail as a_detail','postcode as a_postcode')->where('id',$request->input('a_id'))->first();
        $bAddress = DB::table('addresses')->select('country as b_country','en_name as b_en_name','cn_name as b_cn_name','phone as b_phone','email as b_email','province as b_province','city as b_city','area as b_area','detail as b_detail','postcode as b_postcode')->where('id',$request->input('b_id'))->first();
        $aAddress = json_decode(json_encode($aAddress), true);      //邮寄人地址
        $bAddress = json_decode(json_encode($bAddress), true);      //收件人地址

        $user_id = $request->session()->get('user.id');
        $order_time = date('Y-m-d H:i:s',time());
        $state = "待取件";
        $params = array_merge($aAddress,$bAddress,request(['date','type','packaging','tax','note']),compact('number','user_id','order_time','state'));
        Mail::create($params);

        //写入邮寄物品
        $itemsArr = $request->input('items');
        foreach ($itemsArr as $k => $v){
            $items[$k]['mail_number'] = $number;
            $items[$k]['sort'] = $v['sort'];
            $items[$k]['number'] = $v['number'];
            $items[$k]['money'] = '';
            $items[$k]['created_at'] = date('Y-m-d H:i:s',time());
            $items[$k]['updated_at'] = date('Y-m-d H:i:s',time());
        }
        DB::table('items')->insert($items);

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );
    }

}
