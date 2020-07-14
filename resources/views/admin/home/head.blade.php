<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>物流管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/back/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/back/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/back/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="/back/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/back/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/back/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/back/css/style.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/back/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/back/assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/back/assets/js/html5shiv.js"></script>
    <script src="/back/assets/js/respond.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script src="/back/js/jquery-1.9.1.min.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script type="text/javascript">window.jQuery || document.write("<script src='/back/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");</script>
    <![endif]-->
    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/back/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
    </script>
    <script src="/back/assets/js/bootstrap.min.js"></script>
    <script src="/back/assets/js/typeahead-bs2.min.js"></script>
    <!--[if lte IE 8]>
    <script src="/back/assets/js/excanvas.min.js"></script>
    <![endif]-->
    <script src="/back/assets/js/ace-elements.min.js"></script>
    <script src="/back/assets/js/ace.min.js"></script>
    <script src="/back/assets/layer/layer.js" type="text/javascript"></script>
    <script src="/back/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/back/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            var cid = $('#nav_list> li>.submenu');
            cid.each(function(i){
                $(this).attr('id',"Sort_link_"+i);

            })
        });

        jQuery(document).ready(function(){
            $.each($(".submenu"),function(){
                var $aobjs=$(this).children("li");
                var rowCount=$aobjs.size();
                var divHeigth=$(this).height();
                $aobjs.height(divHeigth/rowCount);
            });
            //初始化宽度、高度

            $("#main-container").height($(window).height()-76);
            $("#iframe").height($(window).height()-140);

            $(".sidebar").height($(window).height()-99);
            var thisHeight = $("#nav_list").height($(window).outerHeight()-173);
            $(".submenu").height();
            $("#nav_list").children(".submenu").css("height",thisHeight);

            //当文档窗口发生改变时 触发
            $(window).resize(function(){
                $("#main-container").height($(window).height()-76);
                $("#iframe").height($(window).height()-140);
                $(".sidebar").height($(window).height()-99);

                var thisHeight = $("#nav_list").height($(window).outerHeight()-173);
                $(".submenu").height();
                $("#nav_list").children(".submenu").css("height",thisHeight);
            });
            $(document).on('click','.iframeurl',function(){
                var cid = $(this).attr("name");
                var cname = $(this).attr("title");
                $("#iframe").attr("src",cid).ready();
                $("#Bcrumbs").attr("href",cid).ready();
                $(".Current_page a").attr('href',cid).ready();
                $(".Current_page").attr('name',cid);
                $(".Current_page").html(cname).css({"color":"#333333","cursor":"default"}).ready();
                $("#parentIframe").html('<span class="parentIframe iframeurl"> </span>').css("display","none").ready();
                $("#parentIfour").html(''). css("display","none").ready();
            });
        });

        /******/
        $(document).on('click','.link_cz > li',function(){
            $('.link_cz > li').removeClass('active');
            $(this).addClass('active');
        });

        /******时间设置********/
        $( document).ready(function(){
            function currentTime(){
                var d=new Date(),str='';
                str+=d.getFullYear()+'年';
                str+=d.getMonth() + 1+'月';
                str+=d.getDate()+'日';
                str+=d.getHours()+'时';
                str+=d.getMinutes()+'分';
                str+= d.getSeconds()+'秒';
                return str;
            }
            setInterval(function(){$('#time').html(currentTime)},1000);
        });

    </script>
</head>

<body>

<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    <div class="navbar-container" id="navbar-container">

        <div class="navbar-header pull-left">
            <a href="/back/index" class="navbar-brand">
                <small>
                    <img src="/back/images/logo1.png" width="470px">
                </small>
            </a>
        </div>
        <div class="navbar-header operating pull-left"></div>

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span  class="time"><em id="time"></em></span><span class="user-info"><small>欢迎光临,</small>{{\Auth::guard("admin")->user()->name}}</span>
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li><a href="/admin/logout" id="Exit_system"><i class="icon-off"></i>退出</a></li>
                    </ul>
                </li>

<!--                 <li class="purple">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-bell-alt"></i><span class="badge badge-important">8</span></a>
                    <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                        <li class="dropdown-header"><i class="icon-warning-sign"></i>8条通知</li>
                        <li>
                            <a href="#">
                                <div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comments-alt"></i>
												最新消息
											</span>
                                    <span class="pull-right badge badge-info">+12</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="btn btn-xs btn-primary icon-user"></i>
                                切换为编辑登录..
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>
												新订单
											</span>
                                    <span class="pull-right badge badge-success">+8</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info icon-twitter"></i>
												用户消息
											</span>
                                    <span class="pull-right badge badge-info">+11</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                查看所有通知
                                <i class="icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->

            </ul>
        </div>
    </div>
</div>
