<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use \App\China;
use Illuminate\Support\Facades\DB;

class ChinaController extends Controller
{

    //省市区写入数据库
    public function index()
    {
        $json = file_get_contents('china.json');
        $res = json_decode($json,true);
        dd($res);

        $i=0;
        foreach($res as $k=>$v)
        {
            //$v => 省
            foreach($v['cityList'] as $v1)
            {
                //$v1 => 市
                //dd($v1);
                $p_id = DB::table('china')->where([
                    ['code','=',$v1['code']],
                    ['level','=',2]
                ])->value('id');    //市id

                foreach ($v1['areaList'] as $v2)
                {
                    //$v2 => 区
                    $area[$i]['p_id'] = $p_id;
                    $area[$i]['code'] = $v2['code'];
                    $area[$i]['name'] = $v2['name'];
                    $area[$i]['level'] = 3;
                    $area[$i]['created_at'] = date('Y-m-d H:i:s',time());
                    $area[$i]['updated_at'] = date('Y-m-d H:i:s',time());

                    $i++;
                }
            }
        }

//        dd($area);
//        DB::table('china')->insert($area);
    }


}
