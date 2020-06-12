<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>测试接口</title>
</head>
<body>
<div id="test">

</div>
</body>
</html>

<script type="text/javascript" src="/js/jquery.min.js"></script>

<script>

    var json = {'id':'11','country':'中国','en_name':'glx','cn_name':'高凌霄','phone':'13462612658','email':'13462612@163.com','province':'上海市','city':'上海市','area':'浦东新区','detail':'北艾路','postcode':'210000','state':'1'};
    json = JSON.stringify(json);
    var url = "http://www.wuliu.cn/test";

    $.ajax({
        url: url,
        type: "post",
        contentType: "application/json; charset=utf-8",
        data: json,
        xhrFields: {
            withCredentials: true
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(msg){
            var str= JSON.stringify(msg);
            $("#test").text(str);
        },
        error: function (msg) {
            var str= JSON.stringify(msg);
            $("#test").text(str);
        }
    });

</script>
