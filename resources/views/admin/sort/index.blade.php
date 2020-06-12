@include('admin.layout.head')

<body>
<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style"></div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加分类</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80">ID</th>
                        <th width="100">分类名称</th>
                        <th width="100">创建时间</th>
                        <th width="250">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sort as $sort)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$sort->id}}</td>
                        <td>{{$sort->name}}</td>
                        <td>{{$sort->created_at}}</td>
                        <td class="td-manage">
                            <a title="编辑" onclick="member_edit({{$sort->id}})" class="btn btn-xs btn-info">编辑</a>
                            <a title="删除" onclick="member_del(this,{{$sort->id}})" class="btn btn-xs btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--添加分类图层-->
<div class="add_menber" id="add_menber_style" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">名称：</label><span class="add_name"><input name="名称" id="name" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


<!--编辑分类图层-->
<div class="add_menber" id="member_edit" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">新名称：</label><span class="add_name"><input name="新名称" id="newname" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
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

    /*分类-添加*/
    $('#member_add').on('click', function(){
        layer.open({
            type: 1,
            title: '添加分类',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_menber_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                name = $("#name").val()
                if(name == ""){
                    layer.alert("名称不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }else{
                    $.ajax({
                        url: "/admin/sort/create",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name:name
                        },
                        success: function (data) {
                            if(data){
                                layer.alert('添加成功！',{
                                    title: '提示框',
                                    icon:1,
                                });
                                layer.close();
                                setTimeout(function(){
                                    window.location.href = "/admin/sort";
                                },700);
                            }
                        },
                        error:function (data) {
                            layer.alert('数据格式不规范或名称相同',{
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

    /*分类-编辑*/
    function member_edit(id){
        layer.open({
            type: 1,
            title: '分类编辑',
            maxmin: true,
            shadeClose:false, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#member_edit'),
            btn:['提交','取消'],
            yes:function(index,layero){
                newname = $("#newname").val()
                if(newname == ""){
                    layer.alert("名称不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/sort/update",
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
                                    window.location.href = "/admin/sort";
                                },700);
                            }
                        },
                        error:function (data) {
                            layer.alert('数据格式不规范或名称相同',{
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

    /*分类-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url:"/admin/sort/delete",
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