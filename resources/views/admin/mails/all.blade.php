@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">订单编号</label><input type="text" class="text_add" id="ordernumber" /></li>
                    <li><label class="l_f">商品状态</label>
                        <select id="state" style="width:150px; margin-left: 10px;">
                            <option selected="selected" value="全部">全部</option>
                            <option value="待取件">待取件</option>
                            <option value="待入库">待入库</option>
                            <option value="待核价">待核价</option>
                            <option value="待付款">待付款</option>
                            <option value="待确认">待确认</option>
                            <option value="待出库">待出库</option>
                            <option value="待发出">待发出</option>
                            <option value="已邮寄">已邮寄</option>
                        </select>
                    </li>
                    <li><label class="l_f">下单时间</label><input class="inline laydate-icon" id="start" style="margin-left:10px;"></li>
                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </ul>
            </div>
            <!---->
            <div class="border clearfix">
                <span class="l_f">
                <a href="/admin/mails/export" class="btn btn-warning">导出数据表格</a>
                </span>
            </div>
            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="25">ID</th>
                        <th width="50">订单编号</th>
                        <th width="50">发出地</th>
                        <th width="50">目的地</th>
                        <th width="50">费用</th>
                        <th width="50">状态</th>
                        <th width="50">下单时间</th>
                        <th width="100">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mails as $mails)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$mails->id}}</td>
                        <td>{{$mails->number}}</td>
                        <td>{{$mails->a_country}}</td>
                        <td>{{$mails->b_country}}</td>
                        <td>{{$mails->money}}</td>
                        <td style="color: red; font-weight: 600">{{$mails->state}}</td>
                        <td>{{$mails->order_time}}</td>
                        <td class="td-manage">
                            @if($mails->state == '待核价')
                                <a title="详情" href="/admin/mails/{{$mails->id}}/check_show" class="btn btn-xs btn-info">订单详情</a>
                            @elseif($mails->state == '待确认')
                                <a title="详情" href="/admin/mails/{{$mails->id}}/confirm_show" class="btn btn-xs btn-info">订单详情</a>
                            @else
                                <a title="详情" href="/admin/mails/{{$mails->id}}/show" class="btn btn-xs btn-info">订单详情</a>
                            @endif
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
                {"orderable":false,"aTargets":[0,1,2,3,4,5,6,7,8]}    // 制定列不参与排序
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


    /*订单-查找*/
    $(".btn_search").click(function () {
        var ordernumber = $("#ordernumber").val();
        var state = $("#state").val();
        var start = $("#start").val();
        window.location.href = "/admin/mails/all?ordernumber="+ordernumber+"&state="+state+"&start="+start;
    });

    laydate({
        elem: '#start',
        event: 'focus'
    });

</script>