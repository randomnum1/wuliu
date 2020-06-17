<?php

namespace App\Listeners;

use App\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class QueryListener
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
     * 记录一些简单的请求日志
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        $request = $event->request;
        //要记录的log
        $array = ["admin/index"=>"登陆系统","admin/user/create"=>"新增管理员",
            "admin/user/delete"=>"删除管理员","admin/user/update"=>"更新管理员账户","admin/user/setting"=>"重置管理员密码",
            "admin/user/auth"=>"更改管理员权限",
        ];

        $path = $request->path();

        if(isset($array[$path])) {
            switch($path){
                case "admin/user/create": $array[$path]="新增管理员".$request->input('name'); break;
                case "admin/user/delete": $array[$path]="删除管理员".$request->input('id'); break;
                case "admin/user/update": $array[$path]="更新管理员".$request->input('id')."账户为".$request->input('name'); break;
                case "admin/user/setting": $array[$path]="重置管理员".$request->input('id')."密码"; break;
                case "admin/user/auth": $array[$path]="更改管理员".$request->input('id')."权限"; break;
            }

            $user = \Auth::guard("admin")->user()->name;
            $note = $array[$path];
            $time = date('Y-m-d H:i:s',time());
            DB::table('admin_logs')->insert(
                ['user'=>$user,'path'=>$path,'note'=>$note,'created_at'=>$time]
            );
        }

    }
}
