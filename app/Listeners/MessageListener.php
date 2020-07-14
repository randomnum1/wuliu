<?php

namespace App\Listeners;

use App\Events\MessageExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\WechatController;
use Illuminate\Support\Facades\DB;

class MessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 通过微信模板消息发送新订单提醒
     *
     * @param  MessageExecuted  $event
     * @return void
     */
    public function handle(MessageExecuted $event)
    {
        $order = $event->order;
        //订单类型
        $orderSort = substr($order->number,0,2);
        switch ($orderSort){
            case 'YJ': $orderSort = '邮寄'; break;
            case 'JC': $orderSort = '寄存'; break;
            case 'ZY': $orderSort = '转运'; break;
        }

        //通知取件员
        $manageOpenid = DB::table('admin_users')->select('openid')->get()->toArray();
        foreach ($manageOpenid as $manage) {
            $user_openid = $manage->openid;
            $template_id = "a3Chfg3G2VYYlxqR8TM9bMQbx5cACeyI4RHsMlsnGpk";
            $first = "您有新的订单";
            $keyword1 = $orderSort;
            $keyword2 = $order->date;
            $remark = "请尽快处理!";
            $url = "http://wl.miyacloud.cn/manage/login/auth2";

            $data = array(
                'touser' => $user_openid,
                'template_id'=> $template_id,
                'url'=> $url,
                'data'=> array(
                    'first' => array(
                        'value' => $first,
                        'color' => "#173177"
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => "#173177"
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => "#173177"
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => "#173177"
                    )
                )
            );
            $data = json_encode($data);
            
            $weChat = new WechatController();
            $res = $weChat->send_message($data);
        } 
    }

}
