@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li><label class="l_f">日期</label><input class="inline laydate-icon" id="start" style="margin-left:10px;"></li>
                    <li><label class="l_f">状态</label>
                        <select name="" style="width:150px; margin-left: 10px;" id="note">
                            <option value="全部" selected="selected">全部</option>
                            <option value="上班">上班</option>
                            <option value="休息">休息</option>
                        </select>
                    </li>
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
                        <th width="50">日期</th>
                        <th width="50">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dates as $date)
                    <tr>
                        <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td>{{$date->id}}</td>
                        <td>{{$date->date}}</td>
                        <td>
                            @if($date->note == "上班")
                                <a title="休息" id="0" onclick="member_edit(this,{{$date->id}})" class="btn btn-xs btn-danger">休息</a>
                            @else
                                <a title="上班" id="1" onclick="member_edit(this,{{$date->id}})" class="btn btn-xs btn-success">上班</a>
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


    /*日期-查找*/
    $(".btn_search").click(function () {
        var start = $("#start").val();
        var note = $("#note option:selected").val();
        window.location.href = "/admin/system/date?start="+start+"&note="+note;
    });


    /*上下班*/
    function member_edit(obj,id){
        if(obj.id == 0){
            confirm = "确认要休息吗？";
        }else{
            confirm = "确认要上班吗？";
        }
        layer.confirm(confirm,function(index){
            $.ajax({
                url:"/admin/system/date/state",
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
                        $(obj)[0].innerText = '上班';
                        $(obj)[0].id = 1;
                        layer.msg("已休息！",{icon:1,time:1000});
                    }else{
                        $(obj)[0].className = "btn btn-xs btn-danger";
                        $(obj)[0].innerText = '休息';
                        $(obj)[0].id = 0;
                        layer.msg("已上班！",{icon:1,time:1000});
                    }
                }
            });
        });
    }

    laydate({
        elem: '#start',
        event: 'focus'
    });


</script>