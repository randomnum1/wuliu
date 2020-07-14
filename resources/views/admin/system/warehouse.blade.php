@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">仓库</label>
                        <select name="" id="name" style="width:150px; margin-left: 10px;">
                            <option>全部</option>
                            @foreach($sorts as $sort)
                                <option>{{$sort->name}}</option>
                            @endforeach
                        </select>
                    </li>
                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </ul>
            </div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                    <a href="javascript:ovid()" id="member_add" class="btn btn-info"><i class="icon-plus"></i>添加仓库</a>
                </span>
                <span class="l_f">
                    <a href="javascript:ovid()" id="member_add1" class="btn btn-warning"><i class="icon-plus"></i>添加库位</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="50">仓库</th>
                        <th width="50">库位</th>
                        <th width="100">物品单号</th>
                        <th width="50">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($warehouse as $warehouse)
                    <tr>
                        <td>{{$warehouse->name}}</td>
                        <td>{{$warehouse->location}}</td>
                        <td>{{$warehouse->state}}</td>
                        <td>
                            <a title="编辑" onclick="member_edit({{$warehouse->id}})" class="btn btn-xs btn-info">编辑</a>
                            <a title="删除" onclick="member_del(this,{{$warehouse->id}})" class="btn btn-xs btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--添加仓库图层-->
<div class="add_menber" id="add_menber_style" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">仓库名：</label><span class="add_name"><input name="仓库" id="warehouse_name" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


<!--添加库位图层-->
<div class="add_menber" id="add_member" style="display:none">
    <ul class=" page-content">
        <li>
            <label class="label_name">仓库名：</label>
            <span class="select-box">
				<select class="select" name="admin-role" id="xsnjx">
					@foreach($sorts as $sort)
                        <option>{{$sort->name}}</option>
                    @endforeach
				</select>
            </span>
            <div class="prompt r_f"></div>
        </li>
        <li>
            <label class="label_name">库位名：</label>
            <span class="add_name">
                <input name="库位" id="warehouse_location" type="text"  class="text_add"/>
            </span>
            <div class="prompt r_f"></div>
        </li>
    </ul>
</div>


<!--库位编辑图层-->
<div class="add_menber" id="member_edit" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">新库位名：</label><span class="add_name"><input name="库位" id="newlocation" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


</body>
</html>

<script>

    /*仓库-查找*/
    $(".btn_search").click(function () {
        var name = $("#name").val();
        window.location.href = "/admin/system/warehouse?name="+name;
    });

    /*仓库-添加*/
    $('#member_add').on('click', function(){
        layer.open({
            type: 1,
            title: '添加仓库',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_menber_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                name = $("#warehouse_name").val();
                if(name == ""){
                    layer.alert("不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/system/warehouse/warehouse_add",
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
                                    window.location.href = "/admin/system/warehouse";
                                },700);
                            }
                        },
                        error:function (data) {
                            layer.alert('数据格式不规范或仓库名称相同',{
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

    /*库位-添加*/
    $('#member_add1').on('click', function(){
        layer.open({
            type: 1,
            title: '添加库位',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_member'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var name = $("#xsnjx").val();
                var location = $("#warehouse_location").val();
                if((name == "")||(location == "")){
                    layer.alert("不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/system/warehouse/location_add",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name:name,
                            location:location
                        },
                        success: function (data) {
                            if(data){
                                layer.alert('添加成功！',{
                                    title: '提示框',
                                    icon:1,
                                });
                                layer.close();
                                setTimeout(function(){
                                    window.location.href = "/admin/system/warehouse";
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
    });

    /*库位-编辑*/
    function member_edit(id){
        layer.open({
            type: 1,
            title: '库位编辑',
            maxmin: true,
            shadeClose:false, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#member_edit'),
            btn:['提交','取消'],
            yes:function(index,layero){
                newlocation = $("#newlocation").val();
                if(newlocation == ""){
                    layer.alert("不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/system/warehouse/location_update",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id:id,
                            location:newlocation,
                        },
                        success: function (data) {
                            if(data){
                                layer.alert('修改成功！',{
                                    title: '提示框',
                                    icon:1,
                                });
                                layer.close();
                                setTimeout(function(){
                                    window.location.href = "/admin/system/warehouse";
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

    /*仓库-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url:"/admin/system/warehouse/delete",
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