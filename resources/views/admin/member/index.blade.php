@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">会员昵称</label><input type="text" class="text_add" id="nickname" /></li>
                    <li><label class="l_f">关注时间</label><input class="inline laydate-icon" id="start" style="margin-left:10px;"></li>
                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </ul>
            </div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                <a href="/admin/member/export" id="member_add" class="btn btn-warning">导出数据表格</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="50">ID</th>
                        <th width="100">昵称</th>
                        <th width="100">头像</th>
                        <th width="100">积分</th>
                        <th width="100">关注时间</th>
                        <th width="100">最后登陆时间</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user as $user)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->nickname}}</td>
                        <td><img src="{{$user->head}}" style="width: 60px;" /></td>
                        <td>{{$user->score}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->updated_at}}</td>
                        <td class="td-manage">
                            <a title="编辑积分" onclick="member_edit({{$user->id}})" class="btn btn-xs btn-danger">编辑积分</a>
                            <a title="收货地址" href="/admin/member/address?id={{$user->id}}" class="btn btn-xs btn-info">收货地址</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--编辑用户积分图层-->
<div class="add_menber" id="member_edit" style="display:none">
    <ul class=" page-content">
        <li><label class="label_name">新积分：</label><span class="add_name"><input name="积分" placeholder="整数数字" id="score" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>
</div>


</body>
</html>

<script>
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "bStateSave": false,    //状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,1,2,3,4,5,6,7]}    // 制定列不参与排序
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

    /*用户-查找*/
    $(".btn_search").click(function () {
        var nickname = $("#nickname").val();
        var date = $("#start").val();
        window.location.href = "/admin/member?nickname="+nickname+"&date="+date;
    });


    /*用户-编辑-积分*/
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
                score = $("#score").val()
                if(score == ""){
                    layer.alert("积分不能为空！\r\n",{
                        title: '提示框',
                        icon:0,
                    });
                    return false;
                }
                else{
                    $.ajax({
                        url: "/admin/member/update",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id:id,
                            score:score
                        },
                        success: function (data) {
                            if(data){
                                layer.alert('修改成功！',{
                                    title: '提示框',
                                    icon:1,
                                });
                                layer.close();
                                setTimeout(function(){
                                    window.location.href = "/admin/member";
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


    laydate({
        elem: '#start',
        event: 'focus'
    });

</script>