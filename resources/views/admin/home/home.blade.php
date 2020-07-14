<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/back/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/back/css/style.css"/>
    <link rel="stylesheet" href="/back/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/back/assets/css/font-awesome.min.css" />
    <link href="/back/assets/css/codemirror.css" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/back/assets/css/font-awesome-ie7.min.css"/>
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/back/assets/css/ace-ie.min.css"/>
    <![endif]-->
    <script src="/back/assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/back/assets/js/html5shiv.js"></script>
    <script src="/back/assets/js/respond.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script src="/back/assets/js/jquery.min.js"></script>
    <!-- <![endif]-->
    <script src="/back/assets/dist/echarts.js"></script>
    <script src="/back/assets/js/bootstrap.min.js"></script>
<title></title>
</head>
<body>
<div class="page-content clearfix">
    <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <i class="icon-ok green"></i>欢迎使用物流管理系统</strong>
    </div>
 <div class="state-overview clearfix">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                      <a href="#" title="商城会员">
                          <div class="symbol terques">
                             <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1>{{$userNumber}}</h1>
                              <p>系统用户</p>
                          </div>
                          </a>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="icon-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1>{{$orderNumber}}</h1>
                              <p>系统订单</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="icon-bar-chart"></i>
                          </div>
                          <div class="value">
                              <h1>¥{{$orderMoney}}</h1>
                              <p>交易记录</p>
                          </div>
                      </section>
                  </div>
              </div>
             <!--实时交易记录-->
        <div class="clearfix">
             <div class="Order_Statistics ">
                 <div class="title_name">订单统计信息</div>
                 <table class="table table-bordered">
                 <tbody>
                 <tr><td class="name">未处理订单：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                 <tr><td class="name">待核算订单：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                 <tr><td class="name">待发货订单：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                 </tbody>
                 </table>
             </div>
             <div class="Order_Statistics">
                <div class="title_name">商品统计信息</div>
                <table class="table table-bordered">
                <tbody>
                <tr><td class="name">商品总数：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                <tr><td class="name">上架商品：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                <tr><td class="name">下架商品：</td><td class="munber"><a href="#">0</a>&nbsp;个</td></tr>
                </tbody>
                </table>
             </div>

             <div class="Order_Statistics">
                 <div class="title_name">会员活跃信息</div>
                 <table class="table table-bordered">
                 <tbody>
                    <tr><td class="name">一周内登陆：</td><td class="munber"><a href="#">0</a>&nbsp;次</td></tr>
                    <tr><td class="name">一月内登陆：</td><td class="munber"><a href="#">0</a>&nbsp;次</td></tr>
                    <tr><td class="name">一年内登陆：</td><td class="munber"><a href="#">0</a>&nbsp;次</td></tr>
                 </tbody>
                 </table>
             </div>
        </div>

    </div>
</body>
</html>
