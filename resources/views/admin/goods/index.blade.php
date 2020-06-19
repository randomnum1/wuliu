@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">商品名称</label><input type="text" class="text_add" id="nickname" /></li>
                    <li><label class="l_f">商品类别</label>
                        <select name="" style="width:150px; margin-left: 10px;">
                            <option>全部</option>
                        @foreach($sorts as $sort)
                            <option>{{$sort->name}}</option>
                        @endforeach
                        </select>
                    </li>
                    <li><label class="l_f">商品状态</label>
                        <select name="" style="width:150px; margin-left: 10px;">
                            <option>全部</option>
                            <option>上架</option>
                            <option>下架</option>
                        </select>
                    </li>
                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </ul>
            </div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                <a href="/admin/goods/create" class="btn btn-primary"><i class="icon-plus"></i>新增商品</a>
                </span>
                <span class="l_f">
                <a href="/admin/goods/export" class="btn btn-warning">导出数据表格</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="50">ID</th>
                        <th width="50">分类</th>
                        <th width="50">名称</th>
                        <th width="50">照片</th>
                        <th width="50">价格</th>
                        <th width="50">单位</th>
                        <th width="50">库存</th>
                        <th width="50">上下架</th>
                        <th width="100">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($goods as $goods)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$goods->id}}</td>
                        <td>{{$goods->sortname}}</td>
                        <td>{{$goods->name}}</td>
                        <td><img src="{{$goods->picture}}" style="height: 80px;" class="img_zoom" /></td>
                        <td>{{$goods->price}}</td>
                        <td>{{$goods->unit}}</td>
                        <td>{{$goods->number}}</td>
                        <td>
                            @if($goods->state == 1)
                                <a title="下架" id="0" onclick="member_edit(this,{{$goods->id}})" class="btn btn-xs btn-danger">下架</a>
                            @else
                                <a title="上架" id="1" onclick="member_edit(this,{{$goods->id}})" class="btn btn-xs btn-success">上架</a>
                            @endif
                        </td>
                        <td class="td-manage">
                            <a title="详情" href="/admin/goods/{{$goods->id}}/show" class="btn btn-xs btn-info">详情</a>
                            <a title="删除" onclick="member_del(this,{{$goods->id}})" class="btn btn-xs btn-danger">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<script>
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "bStateSave": false,    //状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,1,2,3,4,5,6,7,8,9]}    // 制定列不参与排序
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


    /*商品-查找*/
    $(".btn_search").click(function () {
        var goodsname = $("#goodsname").val();
        var sort = $("#sort").val();
        var state = $("#state").val();
        window.location.href = "/admin/goods?goodsname="+goodsname+"&sort="+sort+"&state="+state;
    });


    /*商品上下架*/
    function member_edit(obj,id){
        if(obj.id == 0){
            confirm = "确认要下架吗？";
        }else{
            confirm = "确认要上架吗？";
        }
        layer.confirm(confirm,function(index){
            $.ajax({
                url:"/admin/goods/state",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id:id,
                    state:obj.id
                },
                success: function (data) {
                    if(obj.id == 0){
                        $(obj)[0].className = "btn btn-xs btn-success";
                        $(obj)[0].innerText = '上架';
                        $(obj)[0].id = 1;
                        layer.msg("已下架！",{icon:1,time:1000});
                    }else{
                        $(obj)[0].className = "btn btn-xs btn-danger";
                        $(obj)[0].innerText = '下架';
                        $(obj)[0].id = 0;
                        layer.msg("已上架！",{icon:1,time:1000});
                    }
                }
            });
        });
    }


    /*商品删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url:"/admin/goods/delete",
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