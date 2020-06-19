<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/back/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/back/css/style.css" rel="stylesheet" />
    <link href="/back/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/back/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/back/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/back/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/back/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/back/assets/js/jquery.min.js"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='/back/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/back/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/back/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/back/js/jquery-1.9.1.min.js"></script>
    <script src="/back/assets/js/bootstrap.min.js"></script>
    <script src="/back/assets/js/typeahead-bs2.min.js"></script>
    <!-- page specific plugin scripts -->
    <script src="/back/assets/js/jquery.dataTables.min.js"></script>
    <script src="/back/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/back/js/H-ui.js"></script>
    <script type="text/javascript" src="/back/js/H-ui.admin.js"></script>
    <script src="/back/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/back/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/back/js/dragDivResize.js" type="text/javascript"></script>

    <!--图片预览-->
    <link rel="stylesheet" href="/back/css/mediazoom.css"/>
    <script src="/back/js/mediazoom.js"></script>

    <title></title>
</head>