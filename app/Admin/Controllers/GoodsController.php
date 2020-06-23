<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Sort;
use \App\Good;
use Illuminate\Support\Facades\Storage;
use Excel;

class GoodsController extends Controller
{

    //商品列表
    public function index()
    {
        //逻辑
        $goods = DB::table('goods')->select('goods.*','goods_sort.name as sortname')
            ->leftJoin('goods_sort','goods.sort_id','=','goods_sort.id')
            ->orderBy('goods.id','desc')
            ->get();

        $sorts = Sort::get();

        //返回
        return view('admin.goods.index',compact('goods','sorts'));
    }


    //商品详情
    public function show(Good $goods)
    {
        //返回
        $sorts = Sort::get();

        return view('admin.goods.show',compact('goods','sorts'));
    }


    //商品新增
    public function create()
    {
        $sorts = Sort::all();
        return view('admin.goods.create',compact('sorts'));
    }


    //商品新增行为
    public function store(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:10',
            'price' => 'required|price|min:1|max:10',
            'unit' => 'required|min:1|max:10',
            'size' => 'required|min:1|max:10',
            'number' => 'required|numeric|min:0|max:100000',
            'sort_id' => 'required|numeric',
            'state' => 'required|in:0,1',
            'detail' => 'required|min:1|max:20',
            'picture' => 'required|image',
        ]);


        //逻辑
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('goods');
            $picture = "/storage/" . $path;
        }else{
            $request->flash();
            return back()->withErrors('请上传商品图片');
        }

        $params = array_merge(request(['name', 'price','unit','size','number','sort_id','state','detail']),compact('picture'));
        Good::create($params);

        //返回
        return redirect("/admin/goods");
    }


    //商品编辑行为
    public function update(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:10',
            'price' => 'required|price|min:1|max:10',
            'unit' => 'required|min:1|max:10',
            'size' => 'required|min:1|max:10',
            'number' => 'required|numeric|min:0|max:100000',
            'sort_id' => 'required|numeric',
            'state' => 'required|in:0,1',
            'detail' => 'required|min:1|max:20',
            'picture' => 'nullable|image'
        ]);

        //逻辑
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('goods');
            $picture = "/storage/" . $path;
            //删除旧图片
            $oldPicture = DB::table('goods')->where('id',$request['id'])->value('picture');
            Storage::delete(str_replace("/storage/goods", 'goods', $oldPicture));
        }

        $id = $request['id'];
        $updated_at = date('Y-m-d H:i:s',time());
        $params = array_merge(request(['name', 'price','unit','size','number','sort_id','state','detail']),compact('updated_at'));
        if(isset($picture)){
            $params = array_merge(request(['name', 'price','unit','size','number','sort_id','state','detail']),compact('updated_at','picture'));
        }

        DB::table('goods')->where('id',$id)->update($params);

        //返回
        return redirect("/admin/goods/$id/show");
    }


    //商品上下架
    public function state()
    {
        //验证
        $this->validate(request(),[
            'state' => 'required|in:0,1',
        ]);

        //逻辑
        $goods = Good::find(request('id'));
        $goods->state = request('state');
        $goods->save();

        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //商品删除
    public function delete()
    {
        $oldPicture = DB::table('goods')->where('id',request('id'))->value('picture');
        Storage::delete(str_replace("/storage/goods", 'goods', $oldPicture));

        Good::destroy(request('id'));
        //返回
        return response()->json(
            $data = ['message' => 'ok'],
            $status = 200
        );
    }


    //商品导出
    public function export()
    {
        ini_set('memory_limit','500M');
        set_time_limit(0);

        //数据
        $goods = Good::select('name','price','unit','size','detail','number','sort_id','state')->orderBy('updated_at','desc')->get()->toArray();

        $cellData = [
            ['名称','价格','单位','规格','描述','库存','分类','上下架'],
        ];
        $cellData = array_merge($cellData,$goods);

        //导出逻辑
        Excel::create('商品表',function($excel) use ($cellData){
            $excel->sheet('goods', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

}
