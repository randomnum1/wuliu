<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Mail;
use App\Events\MessageExecuted;

class MailsController extends Controller
{

    //首页接口
    public function index(Request $request)
    {
        //默认地址
        $user_id = $request->session()->get('user.id');
        $address = DB::table('addresses')->where([['user_id',$user_id],['state',1]])
            ->select('id','country','en_name','cn_name','phone','email','province','city','area','detail','postcode')
            ->get();

        //可预约日期
        $now = date('Y-m-d H:i:s',time());
        $date = DB::table('dates')->select('date')->where([
            ['note','上班'],
            ['date','>',$now]
        ])->take(6)->get();

        //返回
        return response()->json(
            $data = [
                'address' => $address,
                'date' => $date
            ],
            $status = 200
        );
    }


    //邮寄编号生成
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


    //邮寄物品写入
    public function items($number,$itemsArr)
    {
        foreach ($itemsArr as $k => $v){
            $items[$k]['mail_number'] = $number;
            $items[$k]['sort'] = $v['sort'];
            $items[$k]['number'] = $v['number'];
            $items[$k]['money'] = '';
            $items[$k]['created_at'] = date('Y-m-d H:i:s',time());
            $items[$k]['updated_at'] = date('Y-m-d H:i:s',time());
        }

        DB::table('items')->insert($items);
    }


    //邮寄订单新增接口
    public function create(Request $request)
    {
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

        $this->items($number,$request->input('items'));     //写入邮寄物品

        $aAddress = DB::table('addresses')->select('country as a_country','en_name as a_en_name','cn_name as a_cn_name','phone as a_phone','email as a_email','province as a_province','city as a_city','area as a_area','detail as a_detail','postcode as a_postcode')->where('id',$request->input('a_id'))->first();
        $bAddress = DB::table('addresses')->select('country as b_country','en_name as b_en_name','cn_name as b_cn_name','phone as b_phone','email as b_email','province as b_province','city as b_city','area as b_area','detail as b_detail','postcode as b_postcode')->where('id',$request->input('b_id'))->first();
        $aAddress = json_decode(json_encode($aAddress), true);      //邮寄人地址
        $bAddress = json_decode(json_encode($bAddress), true);      //收件人地址

        $user_id = $request->session()->get('user.id');
        $order_time = date('Y-m-d H:i:s',time());
        $state = "待取件";
        $params = array_merge($aAddress,$bAddress,request(['date','type','packaging','tax','note']),compact('number','user_id','order_time','state'));
        $mail = Mail::create($params);

        event(new MessageExecuted($mail));      //发送相关消息

        //返回
        return response()->json(
            $data = ['message'=>'ok'],
            $status = 200
        );
    }


    //邮寄详情接口
    public function show(Request $request)
    {


    }

}
