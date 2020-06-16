@include('admin.layout.head')

<body>
<div class="Competence_add_style clearfix">

    <div class="left_Competence_add">
        <div class="title_name">添加权限</div>
        <div class="Competence_add">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">操作用户</label>
                <div class="col-sm-9"><input type="text" id="form-field-1" placeholder="" value="{{$user->name}}" name="操作用户" class="col-xs-10 col-sm-5" disabled="disabled"></div>
            </div>
            <!--按钮操作-->
            <div class="Button_operation">
                <button onclick="save_submit();" class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i> 保存并提交</button>
                <button onclick="history.go(-1)" class="btn btn-secondary  btn-warning" type="button"><i class="fa fa-reply"></i> 返回上一页</button>
            </div>
        </div>
    </div>

    <!--权限分配-->
    <div class="Assign_style">
        <div class="title_name">权限分配</div>
        <div class="Select_Competence">
            @foreach($permissions as $permission)
            <dl class="permission-list" >
                <dt style="background-color: orange;"><label class="middle"><input name="user-Character-0" class="ace" type="checkbox" id="{{$permission->id}}"><span class="lbl">{{$permission->description}}</span></label></dt>
            </dl>
            @endforeach
        </div>
    </div>

</div>
</body>
</html>

<script type="text/javascript">
    //初始化宽度、高度
    $(".left_Competence_add,.Competence_add_style").height($(window).height()).val();;
    $(".Assign_style").width($(window).width()-500).height($(window).height()).val();
    $(".Select_Competence").width($(window).width()-500).height($(window).height()-40).val();

    @foreach($user_permissions as $permission)
        $('#{{$permission->id}}').prop("checked",true);
    @endforeach

    /*权限提交*/
    function save_submit() {
        var array = [];
        $('input[type="checkbox"]:checked').each(function() {
            array.push($(this)[0].id);
        });
        console.log(array);
        $.ajax({
            url: "/admin/user/auth",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id:id,
                password:newpassword
            },
            success: function (data) {
                if(data){
                    layer.alert('修改成功！',{
                        title: '提示框',
                        icon:1,
                    });
                    layer.close();
                    setTimeout(function(){
                        window.location.href = "/admin/user";
                    },700);
                }
            },
            error:function (data) {
                layer.alert('数据格式不规范',{
                    title: '提示框',
                    icon:1,
                },function () {
                    window.location.reload(true);
                });
            }
        });
    }


</script>
