<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    //首页左侧
    //在左侧通过iframe调用右侧页面
    public function index()
    {
        return view('admin.home.left');
    }

    //首页右侧
    public function home()
    {
        return view('admin.home.home');
    }

}
