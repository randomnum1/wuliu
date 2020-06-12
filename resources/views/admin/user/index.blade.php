@include('admin.layout.head')

<body>
<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style"></div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加用户</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80">ID</th>
                        <th width="100">账户</th>
                        <th width="100">创建时间</th>
                        <th width="250">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user as $user)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->created_at}}</td>
                        <td class="td-manage">
                            <a title="编辑" onclick="member_edit({{$user->id}})" class="btn btn-xs btn-info">编辑</a>
                            <a title="重置密码" onclick="setting({{$user->id}})" class="btn btn-xs btn-danger">重置密码</a>
                            <a title="权限" href="/admin/user/auth" class="btn btn-xs btn-info">权限</a>
                            <a title="删除" onclick="member_del(this,{{$user->id}})" class="btn btn-xs btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--添加用户图层-->
<div class="add_menber" id="add_menber_style" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">账&nbsp;&nbsp;户 &nbsp;名：</label><span class="add_name"><input name="账户" id="name" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
        <li><label class="label_name">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label><span class="add_name"><input name="密码" id="password" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


<!--编辑用户图层-->
<div class="add_menber" id="member_edit" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">账&nbsp;&nbsp;户 &nbsp;名：</label><span class="add_name"><input name="账户" id="newname" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>

<!--重置密码图层-->
<div class="add_menber" id="setting_password" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">新&nbsp;&nbsp;密&nbsp;&nbsp;码：</label><span class="add_name"><input name="新密码" id="newpassword" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


</body>
</html>

<script>
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "bStateSave": false,    //状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,1,2,3,4]}    // 制定列不参与排序
            ]});

        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });
    });

    /*用户-添加*/
    $('#member_add').on('click', function(){
        layer.open({
            type: 1,
            title: '添加用户',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_menber_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".add_menber input[type$='text']").each(function(n){
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
                    $.ajax({
                        url: "/admin/user/create",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name:$("#name").val(),
                            password:$("#password").val()
                        },
                        success: function (data) {
                            if(data){
                                layer.alert('添加成功！',{
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
                            layer.alert('数据格式不规范或账户名称相同',{
                                title: '提示框',
                                icon:1,
                            },function () {
                                window.location.reload(true);
                            });
                        }
                    });
                }
            }
        });
    });

    /*用户-编辑*/
    function member_edit(id){
        layer.open({
            type: 1,
            title: '用户编辑',
            maxmin: true,
            shadeClose:false, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#member_edit'),
            btn:['提交','取消'],
            yes:function(index,layero){
                newname = $("#newname").val()
                if(newname == ""){
                    layer.alert("账户不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/user/update",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id:id,
                            name:newname
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
            }
        });
    }

    /*重置密码*/
    function setting(id){
        layer.open({
            type: 1,
            title: '重置密码',
            maxmin: true,
            shadeClose:false, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#setting_password'),
            btn:['提交','取消'],
            yes:function(index,layero){
                newpassword = $("#newpassword").val()
                if(newpassword == ""){
                    layer.alert("密码不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/user/setting",
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
            }
        });
    }

    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url:"/admin/user/delete",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id:id
                },
                success: function (data) {
                }
            });
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }

</script>