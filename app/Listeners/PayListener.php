<?php

namespace App\Listeners;

use App\Events\PayExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\WechatController;
use Illuminate\Support\Facades\DB;

class PayListener
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
     * 通过微信模板消息发送付款消息提醒
     *
     * @return void
     */
    public function handle(PayExecuted $event)
    {
        $orderNumber = $event->number;
        //通知用户付款
        $order = DB::table('mails')->where('number',$orderNumber)->first();
        $openid = DB::table('users')->select('openid')->where('id',$order->user_id)->first();

        $user_openid = $openid->openid;
        $template_id = "O_LYaNFjUDzoREgADWSq5Nh0ye80MXU5ga3AfYAVe9Q";
        $first = "您的订单已确认价格，请您付款";
        $keyword1 = $order->number;
        $keyword2 = $order->money;
        $remark = "点击付款";
        $url = "http://wl.miyacloud.cn/auth2";

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
