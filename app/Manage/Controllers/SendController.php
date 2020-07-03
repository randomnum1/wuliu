<?php

namespace App\Manage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SendController extends Controller
{

    //待发出列表
    public function noSend()
    {
        //邮寄
        $mails = DB::table('mails')->select('number','a_province','a_city','a_area','a_detail','a_postcode','date')
            ->where('state','待发出')->get();
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
     * 已发出列表接口
     * 返回一周内的取件记录
     * */
    public function send()
    {
        //邮寄
        $start = date('Y-m-d H:i:s',time()-86400*7);
        $end = date('Y-m-d H:i:s',time());
        $mails = DB::table('mails')->select('number','a_province','a_city','a_area','a_detail','a_postcode','date')
            ->where([['state','=','已邮寄'],['into_time','>=',$start],['into_time','<=',$end]])->get();
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
     * 待发出详情
     * params orderNUmber
     * */
    public function show(Request $request)
    {
        //编号
        $number = $request->get('number');
        $orderSort = substr($number,0,2);

        //根据类型整理数据
        switch ($orderSort){
            case 'YJ':
                $temp = DB::table('mails')
                    ->select('id','number','a_en_name','a_cn_name','a_phone','a_email','a_province','a_city','a_area','a_detail','a_postcode','b_en_name','b_cn_name','b_phone','b_email','b_province','b_city','b_area','b_detail','b_postcode','type','date','packaging','tax','note','take_user','name','location')
                    ->where('number',$number)->get();
                $temp = json_decode(json_encode($temp), true);
                foreach($temp as $k=>$v){
                    $order['address'] = [
                        0 => [
                            'cn_name' => $v['a_cn_name'], 'phone' => $v['a_phone'],
                            'address' => $v['a_province'].$v['a_city'].$v['a_area'].$v['a_detail'],
                            'email' => $v['a_email'], 'postcode' => $v['a_postcode'],
                        ],
                        1 => [
                            'cn_name' => $v['b_cn_name'], 'phone' => $v['b_phone'],
                            'address' => $v['b_province'].$v['b_city'].$v['b_area'].$v['b_detail'],
                            'email' => $v['b_email'], 'postcode' => $v['b_postcode'],
                        ]
                    ];
                    $order['number'] = $v['number']; $order['type'] = $v['type'];  $order['date'] = $v['date'];  $order['packaging'] = $v['packaging'];  $order['tax'] = $v['tax'];  $order['note'] = $v['note'];  $order['take_user'] = $v['take_user']; $order['name'] = $v['name'];  $order['location'] = $v['location'];
                }
            break;
        }

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

        //返回
        return response()->json(
            $data = $order,
            $status = 200
        );
    }


    /**
     * 待发出信息修改
     * params 订单编号，订单发出凭证
     * */
    public function update(Request $request)
    {
        $number = $request->get('number');                          //订单编号
        $orderSort = substr($number,0,2);                   //订单类型

        //验证
        $this->doValidate($request,$orderSort);

        //逻辑
        $send_user = $request->session()->get('manage.real_name');
        $send_time = date('Y-m-d H:i:s',time());
        $state = "已邮寄";
        $params = compact('send_time','send_user','state');

        //存储base64的图片
        $imageArr = $request->get('picture');
        for($i = 0; $i < count($imageArr); $i++){
            $base64String = explode(',',$imageArr[$i])[1];
            $imagePath = '/mails/'.str_random(10).'.png';
            Storage::disk('public')->put($imagePath, base64_decode($base64String));
            $key = 'photo'.($i + 1);
            $params[$key] = '/storage'.$imagePath;
        }

        //根据类型修改订单信息
        switch ($orderSort){
            case 'YJ':
                DB::table('mails')->where('number',$number)->update($params);
            break;
        }

        //返回
        return response()->json(
            $data = ['message'=>'ok!'],
            $status = 200
        );
    }


    //验证数据
    public function doValidate($request,$orderSort)
    {
        $validatedData = $request->validate([
            'number' => 'required|min:1',
            'picture' => 'required|max:3'
        ]);
    }

}
