<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src="/back/js/jquery-1.9.1.min.js"></script>
    <script src="/back/assets/layer/layer.js" type="text/javascript"></script>
    <title>登陆</title>
</head>

<body class="login-layout Reg_log_style">
<div class="logintop">
    <span>欢迎使用物流管理平台</span>
</div>
<div class="loginbody">
    <div class="login-container">
        <div class="center">
            <img src="/back/images/logo1.png" />
        </div>

        <div class="space-6"></div>

        <div class="position-relative">
            <div id="login-box" class="login-box widget-box no-border visible">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header blue lighter bigger">
                            <i class="icon-coffee green"></i>
                            管理员登陆
                        </h4>

                        <div class="login_icon"><img src="/back/images/login.png" /></div>

                        <form class="">
                            <fieldset>
                                <ul>
                                    <li class="frame_style form_error"><label class="user_icon"></label><input name="用户名" type="text"  id="username"/><i>用户名</i></li>
                                    <li class="frame_style form_error"><label class="password_icon"></label><input name="密码" type="password"   id="userpwd"/><i>密码</i></li>
                                </ul>
                                <div class="space"></div>
                                <div class="clearfix">
                                    <button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="login_btn">
                                        登陆
                                    </button>
                                </div>
                                <div class="space-4"></div>
                            </fieldset>
                        </form>

                        <div class="social-or-login center">
                            <span class="bigger-110">通知</span>
                        </div>

                        <div class="social-login center">
                            推荐使用google浏览器，不对IE8以下浏览器支持，请见谅。
                        </div>
                    </div><!-- /widget-main -->

                    <div class="toolbar clearfix">

                    </div>
                </div><!-- /widget-body -->
            </div><!-- /login-box -->
        </div><!-- /position-relative -->
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $("input[type='text'],input[type='password']").blur(function(){
            var $el = $(this);
            var $parent = $el.parent();
            $parent.attr('class','frame_style').removeClass(' form_error');
            if($el.val()==''){
                $parent.attr('class','frame_style').addClass(' form_error');
            }
        });
        $("input[type='text'],input[type='password']").focus(function(){
            var $el = $(this);
            var $parent = $el.parent();
            $parent.attr('class','frame_style').removeClass(' form_errors');
            if($el.val()==''){
                $parent.attr('class','frame_style').addClass(' form_errors');
            } else{
                $parent.attr('class','frame_style').removeClass(' form_errors');
            }
        });
    });

    $('#login_btn').on('click', function(){
        var num=0;
        var str="";
        $("input[type$='text'],input[type$='password']").each(function(n){
            if($(this).val()=="")
            {
                layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                    title: '提示框',
                    icon:0,
                });
                num++;
                return false;
            }
        });
        if(num>0){return false;}
        else{
            var name = $("#username").val();
            var password = $("#userpwd").val();
            $.ajax({
                url: "/admin/login",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name:name,
                    password:password
                },
                success: function (data) {
                    if(data){
                        layer.alert('登录成功！',{
                            title: '提示框',
                            icon:1,
                        });
                        layer.close();
                        setTimeout(function(){
                            window.location.href = "/admin/index";
                        },700);
                    }
                },
                error:function (data) {
                    layer.alert('用户名或密码错误！',{
                        title: '提示框',
                        icon:1,
                    },function () {
                        window.location.reload(true);
                    });
                }
            });
        }
    });

</script>