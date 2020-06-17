@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">时间</label><input class="inline laydate-icon" id="start" style="margin-left:10px;"></li>
                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </ul>
            </div>
            <!---->

            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="50">ID</th>
                        <th width="50">用户</th>
                        <th width="100">操作</th>
                        <th width="50">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$log->id}}</td>
                        <td>{{$log->user}}</td>
                        <td>{{$log->note}}</td>
                        <td>{{$log->created_at}}</td>
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

    /*日志-查找*/
    $(".btn_search").click(function () {
        var date = $("#start").val();
        window.location.href = "/admin/system/log?date="+date;
    });


    laydate({
        elem: '#start',
        event: 'focus'
    });

</script>