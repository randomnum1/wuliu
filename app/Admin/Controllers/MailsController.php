<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;
use \App\Mail;
use App\Events\PayExecuted;

class MailsController extends Controller
{

    //全部邮寄订单
    public function all(Request $request)
    {
        $where = array();
        $orderNumber = $request->get('ordernumber');
        if(!empty($orderNumber)) {
            $where[] = array('number','=',$orderNumber);
        }
        $state = $request->get('state');
        if(isset($state) && ($state != '全部')) {
            $where[] = array('state','=',$state);
        }
        $orderTime = $request->get('start');
        if(!empty($orderTime)) {
            $where[] = array('order_time','>=',$orderTime);
        }

        $mails = DB::table('mails')->select('id','number','a_country','b_country','money','state','order_time')->where($where)->orderBy('order_time','desc')->get();
        return view('admin.mails.all',compact('mails'));
    }


    //待核价订单
    public function check()
    {
        $mails = DB::table('mails')->select('id','number','a_country','b_country','money','state','order_time')->where('state','待核价')->orderBy('order_time','desc')->get();
        return view('admin.mails.check',compact('mails'));
    }


    //待付款订单
    public function pay()
    {
        $mails = DB::table('mails')->select('id','number','a_country','b_country','money','state','order_time')->where('state','待付款')->orderBy('order_time','desc')->get();
        return view('admin.mails.pay',compact('mails'));
    }


    //待确认订单
    public function confirm()
    {
        $mails = DB::table('mails')->select('id','number','a_country','b_country','money','state','order_time')->where('state','待确认')->orderBy('order_time','desc')->get();
        return view('admin.mails.confirm',compact('mails'));
    }


    //订单详情
    public function show(Mail $mails)
    {
        //物品清单
        $items = DB::table('items')->where('mail_number',$mails->number)->get();

        //流程
        switch ($mails->state){
            case '待取件' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'等待取件员取件'];
                break;
            case '待入库' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>'','status'=>'待入库','remark'=>'等待物品入库'];
                break;
            case '待核价' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>'','status'=>'待核价','remark'=>'等待仓库核算价格'];
                break;
            case '待付款' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data[4] = ['scanDateTime'=>'','status'=>'代付款','remark'=>'等待用户付款'];
                break;
            case '待确认' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data[4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data[5] = ['scanDateTime'=>'','status'=>'待确认','remark'=>'等待仓库确认付款'];
                break;
            case '待出库' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data[4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data[5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data[6] = ['scanDateTime'=>'','status'=>'待出库','remark'=>'等待仓库出库'];
                break;
            case '待发出' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data[4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data[5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data[6] = ['scanDateTime'=>$mails->out_time,'status'=>'已出库','remark'=>'仓库已出库'];
                $data[7] = ['scanDateTime'=>'','status'=>'待邮寄','remark'=>'等待邮寄'];
                break;
            case '已邮寄' :
                $data[0] = ['scanDateTime'=>$mails->order_time,'status'=>'已下单','remark'=>'用户已下单'];
                $data[1] = ['scanDateTime'=>$mails->take_time,'status'=>'已取件','remark'=>'取件员已取件'];
                $data[2] = ['scanDateTime'=>$mails->into_time,'status'=>'已入库','remark'=>'物品已入库'];
                $data[3] = ['scanDateTime'=>$mails->check_time,'status'=>'已核价','remark'=>'仓库已核算价格'];
                $data[4] = ['scanDateTime'=>$mails->pay_time,'status'=>'已付款','remark'=>'用户已付款'];
                $data[5] = ['scanDateTime'=>$mails->confirm_time,'status'=>'已确认','remark'=>'仓库已确认付款'];
                $data[6] = ['scanDateTime'=>$mails->out_time,'status'=>'已出库','remark'=>'仓库已出库'];
                $data[7] = ['scanDateTime'=>$mails->send_time,'status'=>'已邮寄','remark'=>'已邮寄'];
                break;
        }
        $datas = array_reverse($data);

        return view('admin.mails.show',compact('mails','items','datas'));
    }


    //核价详情
    public function check_show(Mail $mails)
    {
        //物品清单
        $items = DB::table('items')->where('mail_number',$mails->number)->get();

        return view('admin.mails.check_show',compact('mails','items'));
    }


    //核价逻辑
    public function check_update(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'number' => 'required|min:1'
        ]);
        $state = DB::table('mails')->select('state')->where('number',$request->get('number'))->first();
        if($state->state != '待核价'){
            return response()->json(
                $data = ['message'=>'error!'],422
            );
        }

        //逻辑
        $money = 0;
        $items = json_decode($request->get('num'),true);
        foreach ($items as $k=>$v) {
            $money += $v['money'];
            DB::table('items')->where('id',$v['id'])->update(['weight'=>$v['weight'],'money'=>$v['money']]);
        }

        $number = $request->get('number');
        $check_time = date('Y-m-d H:i:s',time());
        $state = '待付款';
        $params = compact('check_time','state','money');
        DB::table('mails')->where('number',$number)->update($params);

        //发送消息
        event(new PayExecuted($number));

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],200
        );
    }
    
    
    //获取物品
    public function get_items(Request $request)
    {
        $number = $request->get('number');
        $items = DB::table('items')->select('id','sort','number','weight','money')->where('mail_number',$number)->get();
        $items = json_decode(json_encode($items), true);
        $data = [];
        $data[0] = [
            'sort' => '物品','number' => '数量','weight' => '重量','money' => '金额',
        ];
        $i = 1;
        foreach($items as $k => $v){
            $data[$i] = [
                'sort' => $v['sort'],'number' => $v['number'],'weight' => $v['weight'],'money' => $v['money'],'id' => $v['id'],
            ];
            $i++;
        }
        $data[$i] = [
            'sort' => '总计','money' => '','id'=>$i
        ];
        return response()->json(
            $data,
            200
        );
    }


    //确认详情
    public function confirm_show(Mail $mails)
    {
        //物品清单
        $items = DB::table('items')->where('mail_number',$mails->number)->get();

        return view('admin.mails.confirm_show',compact('mails','items'));
    }


    //确认逻辑
    public function confirm_update(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'number' => 'required|min:1',
            'sort' => 'required|min:1'
        ]);
        $state = DB::table('mails')->select('state')->where('number',$request->get('number'))->first();
        if($state->state != '待确认'){
            return response()->json(
                $data = ['message'=>'error!'],422
            );
        }
        //逻辑
        $number = $request->get('number');
        $money_sort = $request->get('sort');
        $confirm_time = date('Y-m-d H:i:s',time());
        $state = '待出库';
        $params = compact('money_sort','confirm_time','state');
        DB::table('mails')->where('number',$number)->update($params);

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],200
        );
    }


    //订单导出
    public function export()
    {
        ini_set('memory_limit','500M');
        set_time_limit(0);

        //数据
        $mails = Mail::select('number','a_country','a_en_name','a_cn_name','a_phone','a_email','a_province','a_city','a_area','a_detail','a_postcode','b_country','b_en_name','b_cn_name','b_phone','b_email','b_province','b_city','b_area','b_detail','b_postcode','type','date','packaging','tax','note','money','state')
            ->orderBy('order_time','desc')->get()->toArray();

        $cellData = [
            [
                '编号','邮寄人国家','邮寄人中文名','邮寄人英文名','邮寄人电话','邮寄人邮箱','邮寄人省份','邮寄人城市','邮寄人区域','邮寄人详细地址','邮寄人邮编',
                '收件人国家','收件人中文名','收件人英文名','收件人电话','收件人邮箱','收件人省份','收件人城市','收件人区域','收件人详细地址','收件人邮编',
                '取件方式','取件日期','是否包装','是否包税','用户备注','订单金额','订单状态'
            ],
        ];
        $cellData = array_merge($cellData,$mails);

        //导出逻辑
        Excel::create('邮寄订单表',function($excel) use ($cellData){
            $excel->sheet('mails', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

}
