<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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


    //邮寄订单查询
    public function search(Request $request)
    {
        $user_id = $request->session()->get('user.id');
        $mails = DB::table('mails')->where('user_id',$user_id)->orderBy('order_time','desc')->get();
        $mails = json_decode(json_encode($mails), true);
        foreach ($mails as $k=>$v) {
            $datas[$k]['number'] = $v['number'];
            $datas[$k]['state'] = $v['state'];
            $datas[$k]['a_country'] = $v['a_country'];
            $datas[$k]['b_country'] = $v['b_country'];
            $datas[$k]['a_name'] = $v['a_cn_name'];
            $datas[$k]['b_name'] = $v['b_cn_name'];

            $items = DB::table('items')->select('sort','number')->where('mail_number',$v['number'])->orderBy('number','asc')->get();
            $items = json_decode(json_encode($items), true);
            $datas[$k]['items'] = '';
            foreach($items as $a=>$b){
                if($b['sort'] == '其他'){
                    $datas[$k]['items'] .= $b['number'];
                }else{
                    $datas[$k]['items'] .= $b['sort'].$b['number'].',';
                }
            }
        }

        //返回
        return response()->json(
            $data = $datas,
            $state = 200
        );
    }


    //邮寄详情接口
    public function show(Request $request)
    {
        $number = $request->get('number');
        $mails = DB::table('mails')->where('number',$number)->first();
        $data['number'] = $mails->number;
        $data['a_country'] = $mails->a_country;
        $data['b_country'] = $mails->b_country;
        if(!empty($mails->money_proof1)){
            $proof = [0=>getenv('HOST').$mails->money_proof1];
        }
        if(!empty($mails->money_proof2)){
            $proof = [0=>getenv('HOST').$mails->money_proof1,1=>getenv('HOST').$mails->money_proof2];
        }
        if(!empty($mails->money_proof3)){
            $proof = [0=>getenv('HOST').$mails->money_proof1,1=>getenv('HOST').$mails->money_proof2,2=>getenv('HOST').$mails->money_proof3];
        }
        if(!empty($mails->photo1)){
            $photo = [0=>getenv('HOST').$mails->photo1];
        }
        if(!empty($mails->photo2)){
            $photo = [0=>getenv('HOST').$mails->photo1,1=>getenv('HOST').$mails->photo2];
        }
        if(!empty($mails->photo3)){
            $photo = [0=>getenv('HOST').$mails->photo1,1=>getenv('HOST').$mails->photo2,3=>getenv('HOST').$mails->photo3];
        }
        
        switch ($mails->state){
            case '待取件' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'等待取件员取件'];
            break;
            case '待入库' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>'','status'=>'待入库','remark'=>'等待物品入库'];
            break;
            case '待核价' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>'','status'=>'待核价','remark'=>'等待仓库核算价格'];
            break;
            case '待付款' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data['list'][4] = ['scanDateTime'=>'','status'=>'代付款','remark'=>'等待用户付款'];
            break;
            case '待确认' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data['list'][4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data['list'][5] = ['scanDateTime'=>'','status'=>'待确认','remark'=>'等待仓库确认付款'];
                $data['detail']['proof'] = $proof;
                break;
            case '待出库' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data['list'][4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data['list'][5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data['list'][6] = ['scanDateTime'=>'','status'=>'待出库','remark'=>'等待仓库出库'];
                $data['detail']['proof'] = $proof;
                break;
            case '待发出' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data['list'][4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data['list'][5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data['list'][6] = ['scanDateTime'=>$mails->out_time,'status'=>'已出库','remark'=>'仓库已出库'];
                $data['list'][7] = ['scanDateTime'=>'','status'=>'待邮寄','remark'=>'等待邮寄'];
                $data['detail']['proof'] = $proof;
                break;
            case '已邮寄' :
                $data['list'][0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'已下单'];
                $data['list'][1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data['list'][2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data['list'][3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data['list'][4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data['list'][5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data['list'][6] = ['scanDateTime'=>$mails->out_time,'status'=>'已出库','remark'=>'仓库已出库'];
                $data['list'][7] = ['scanDateTime'=>$mails->send_time,'status'=>'已邮寄','remark'=>'已邮寄,点击连接查快递','click'=>true];
                $data['detail']['proof'] = $proof;
                $data['detail']['issue'] = $photo;
                break;
        }

        //地址
        $data['detail']['address'] = [
            0 => [
                'cn_name' => $mails->a_cn_name, 'phone' => $mails->a_phone,
                'address' => $mails->a_province.$mails->a_city.$mails->a_area.$mails->a_detail,
                'email' => $mails->a_email, 'postcode' => $mails->b_postcode,
            ],
            1 => [
                'cn_name' => $mails->b_cn_name, 'phone' => $mails->b_phone,
                'address' => $mails->b_province.$mails->b_city.$mails->b_area.$mails->b_detail,
                'email' => $mails->b_email, 'postcode' => $mails->b_postcode,
            ],
        ];
        //物品
        $items = DB::table('items')->select('sort','number','weight','money')->where('mail_number',$number)->orderBy('number','asc')->get();
        $items = json_decode(json_encode($items), true);
        $data['detail']['items'] = $items;
        $data['detail']['total_money'] = $mails->money;
        $data['detail']['type'] = '邮寄订单';
        //付款状态
        $data['pay'] = $mails->state == "待付款" ? true : false;
        //修改付款凭证
        $data['pay_update'] = $mails->state == "待确认" ? true : false;

        //返回
        return response()->json(
            $data,
            200
        );
    }


    //付款
    public function pay(Request $request)
    {
        $number = $request->get('number');

        //验证
        $validatedData = $request->validate([
            'number' => 'required|min:1',
            'picture' => 'required|min:1|max:3'
        ]);
        $state = DB::table('mails')->select('state')->where('number',$number)->first();
        if($state->state != '待付款'){
            return response()->json(
                $data = ['message'=>'error!'],422
            );
        }

        //逻辑
        $imageArr = $request->get('picture');
        for($i = 0; $i < count($imageArr); $i++){
            $base64String = explode(',',$imageArr[$i])[1];
            $imagePath = '/mails/'.str_random(10).'.png';
            Storage::disk('public')->put($imagePath, base64_decode($base64String));
            $key = 'money_proof'.($i + 1);
            $params[$key] = '/storage'.$imagePath;
        }
        $params['state'] = '待确认';
        DB::table('mails')->where('number',$number)->update($params);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],200
        );
    }


    //修改付款情况
    public function pay_update(Request $request)
    {
        $number = $request->get('number');

        //验证
        $validatedData = $request->validate([
            'number' => 'required|min:1',
            'picture' => 'required|min:1|max:3'
        ]);
        $state = DB::table('mails')->select('state')->where('number',$number)->first();
        if($state->state != '待确认'){
            return response()->json(
                $data = ['message'=>'error!'],422
            );
        }

        //逻辑
        DB::table('mails')->where('number',$number)->update(['money_proof1'=>'','money_proof2'=>'','money_proof3'=>'']);
        $imageArr = $request->get('picture');
        for($i = 0; $i < count($imageArr); $i++){
            $base64String = explode(',',$imageArr[$i])[1];
            $imagePath = '/mails/'.str_random(10).'.png';
            Storage::disk('public')->put($imagePath, base64_decode($base64String));
            $key = 'money_proof'.($i + 1);
            $params[$key] = '/storage'.$imagePath;
        }
        DB::table('mails')->where('number',$number)->update($params);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],200
        );
    }
}
