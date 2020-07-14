@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <!---->
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
                        <td>{{$mails->state}}</td>
                        <td>{{$mails->order_time}}</td>
                        <td class="td-manage">
                            <a title="详情" href="/admin/mails/{{$mails->id}}/check_show" class="btn btn-xs btn-info">订单详情</a>
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

</script>