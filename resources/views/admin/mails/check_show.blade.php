@include('admin.layout.head')
<style>
    table {
        width: 100%;
        position: relative;
        float: left;
        border: 1px solid #ccc;
        border-collapse: collapse;
    }

    table tr {
        width: 100%;
        height: 40px;
        line-height: 40px;
        text-align: center;
        position: relative;
        float: left;
    }

    table tr td,
    table tr th {
        width: 25%;
        position: relative;
        float: left;
        padding: 0;
        margin: 0;
        border-right: 1px solid #ccc;
        box-sizing: border-box;
        border-top: 1px solid #ccc;
        text-align: center;
        height: 100%;
    }

    #info {
        width: 100%;
        height: auto;
        position: relative;
        float: left;
        margin-bottom: 60px;
    }

    #info input {
        width: 90%;
        height: 100%;
        border: 0;
    }

    #info input:focus {
        outline: none;
    }

    #info input::-webkit-outer-spin-button,
    #info input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    #info input[type="number"] {
        -moz-appearance: textfield;
    }

    .button {
        width: 200px;
        height: 60px;
        position: absolute;
        right: 10px;
        bottom: 0px;
    }

    .button button {
        width: 80px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        border: none;
        float: right;
        color: #fff;
        position: relative;
        margin: 10px 0;
        border-radius: 5px;
    }

    .button button:first-child {
        background-color: #D15B47;
    }

    .button button:last-child {
        background-color: #FFB752;
    }
    /* .button button:focus {
        background-color: #09d;
        outline: none;
        border: none;
    } */

    .button button:last-child {
        margin-right: 10px;
    }

    .boxSwitch {
        display: none;
    }

    .active {
        display: block;
    }

    .title {
        background: -moz-linear-gradient(top, #fff 0%, #EDEDED 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #EDEDED));
        background: -webkit-linear-gradient(top, #fff 0%, #EDEDED 100%);
        background: -o-linear-gradient(top, #fff 0%, #EDEDED 100%);
        background: -ms-linear-gradient(top, #fff 0%, #EDEDED 100%);
        background: linear-gradient(to bottom, #fff 0%, #EDEDED 100%);
    }
</style>
<body>
<div class="margin clearfix">
    <div class="Order_Details_style">
        <div class="Numbering">订单编号:<b>{{$mails->number}}</b></div></div>
    <input type="hidden" id="number" value="{{$mails->number}}">
    <div class="detailed_style">

        <!--寄件人信息-->
        <div class="Receiver_style">
            <div class="title_name">寄件人信息</div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人姓名： </label>
                    <div class="o_content">{{$mails->a_en_name}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人姓名： </label>
                    <div class="o_content">{{$mails->a_cn_name}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人电话： </label>
                    <div class="o_content">{{$mails->a_phone}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人邮箱： </label>
                    <div class="o_content">{{$mails->a_email}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人邮编： </label>
                    <div class="o_content">{{$mails->a_postcode}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 寄件人地址： </label>
                    <div class="o_content">{{$mails->a_province}}{{$mails->a_city}}{{$mails->a_area}}{{$mails->a_detail}}</div>
                </div>
            </div>
        </div>

        <!--收件人信息-->
        <div class="Receiver_style">
            <div class="title_name">收件人信息</div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人姓名： </label>
                    <div class="o_content">{{$mails->b_en_name}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人姓名： </label>
                    <div class="o_content">{{$mails->b_cn_name}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人电话： </label>
                    <div class="o_content">{{$mails->b_phone}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人邮箱： </label>
                    <div class="o_content">{{$mails->b_email}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人邮编： </label>
                    <div class="o_content">{{$mails->b_postcode}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人地址： </label>
                    <div class="o_content">{{$mails->b_province}}{{$mails->b_city}}{{$mails->b_area}}{{$mails->b_detail}}</div>
                </div>
            </div>
        </div>

        <!--物品信息-->
        <div class="product_style">
            <div class="title_name">物品信息</div>
            <div class="Info_style clearfix">
                @foreach($items as $item)
                <div class="product_info clearfix" style="width: 300px;">
                    <span>
                        <b>类型：{{$item->sort}}</b>
                        <p>数量：{{$item->number}}</p>
                        <p>重量：{{$item->weight}}</p>
                        <p>费用：<b class="price">{{$item->money}}</b></p>
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!--仓库信息-->
        <div class="Receiver_style">
            <div class="title_name">仓库信息</div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 物品状态： </label>
                    <div class="o_content">
                        <span style="color: red;font-weight: 900">
                            @switch($mails->state)
                            @case('待取件') 未入库 @break
                            @case('待入库') 未入库 @break
                            @case('待核价') 已入库 @break
                            @case('待付款') 已入库 @break
                            @case('待确认') 已入库 @break
                            @case('待出库') 已入库 @break
                            @case('待发出') 已出库 @break
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 仓库： </label>
                    <div class="o_content">{{$mails->name}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 库位号： </label>
                    <div class="o_content">{{$mails->location}}</div>
                </div>
            </div>
        </div>

        <!--总价-->
        <div class="Receiver_style">
            <div class="title_name">支付信息</div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 支付状态： </label>
                    <div class="o_content">
                        <span style="color: red;font-weight: 900">
                            @switch($mails->state)
                            @case('待取件')  @break
                            @case('待入库')  @break
                            @case('待核价') 待核价 @break
                            @case('待付款') 待付款 @break
                            @case('待确认') 待确认 @break
                            @case('待出库') 已付款 @break
                            @case('待发出') 已付款 @break
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款类型： </label>
                    <div class="o_content">{{$mails->money_sort}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 总价： </label>
                    <div class="o_content"><span style="color: red;font-weight: 900">{{$mails->money}}</span></div>
                </div>
                @if(!empty($mails->money_proof1))
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 付款凭证1： </label>
                        <div class="o_content"><span><img src="{{$mails->money_proof1}}" width="100px;" /></span></div>
                    </div>
                @endif
                @if(!empty($mails->money_proof2))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款凭证2： </label>
                    <div class="o_content"><span><img src="{{$mails->money_proof2}}" width="100px;" /></span></div>
                </div>
                @endif
                @if(!empty($mails->money_proof3))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款凭证3： </label>
                    <div class="o_content"><span><img src="{{$mails->money_proof3}}" width="100px;" /></span></div>
                </div>
                @endif
            </div>
        </div>


        <!--其他信息-->
        <div class="Receiver_style">
            <div class="title_name">其他信息</div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 取件方式： </label>
                    <div class="o_content">{{$mails->type}}</div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 预取日期： </label>
                    <div class="o_content"><span>{{$mails->date}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 是否包装： </label>
                    <div class="o_content"><span>
                            @if($mails->packaging == 1)
                                是
                                @else
                                否
                            @endif
                        </span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 是否包税： </label>
                    <div class="o_content"><span>
                            @if($mails->tax == 1)
                                是
                            @else
                                否
                            @endif
                        </span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 用户备注： </label>
                    <div class="o_content"><span>{{$mails->note}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 下单日期： </label>
                    <div class="o_content"><span>{{$mails->order_time}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 取件日期： </label>
                    <div class="o_content"><span>{{$mails->take_time}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款日期： </label>
                    <div class="o_content"><span>{{$mails->pay_time}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 确认日期： </label>
                    <div class="o_content"><span>{{$mails->confirm_time}}</span></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 订单状态： </label>
                    <div class="o_content"><span style="color: red;font-weight: 900">{{$mails->state}}</span></div>
                </div>
            </div>
        </div>

        <div class="Button_operation">
            <button id="open" class="btn btn-danger radius">去核价</button>
            <button onclick="history.go(-1)" class="btn btn-primary radius" type="submit">返回</button>
        </div>
    </div>
</div>

<!-- 模态框 -->
<div class="boxSwitch" style="width: 100%;height: 100%;position: fixed;top:0;left: 0;background-color: rgba(0,0,0,.3);float: left;">
    <!-- 内部模态框 -->
    <div style="width: 50%;height: auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);background-color: #fff;border-radius:5px; ;">
        <!-- 标题title -->
        <div class="title" style="width: 100%;height: 40px;line-height: 40px;padding: 0 20px;box-sizing: border-box;color: #333;font-size: 14px;border-radius: 5px 5px 0 0;position: relative;">重量价格核算</div>
        <div style="position: relative;width: 95%;height: auto;margin-top: 10px;transform: translateX(-50%);left: 50%;box-sizing: border-box;">
            <div id="info">

            </div>

        </div>
        <div class="button">
            <button id="confirm">确定</button>
            <button id="cancle">取消</button>
        </div>
    </div>
</div>

</body>
<script>
    json = [];

    function getData() {
        $('#info').empty();
        for (var i = 0; i < json.length; i++) {}
        var str = "";
        str += "<table>";
        for (var i = 0; i < json.length; i++) { //该数组为嵌套数组[[xx],[xx],[xx]]形式
            if (i === 0) { //取第一个数组为表头
                str += "<tr>";
                for (key in json[i]) {
                    str += " <th>" + json[i][key] + "</th>";
                }
                str += "</tr>";
            } else {
                str += "<tr>"; //循环取数组的值生成html代码
                for (key in json[i]) {
                    if (key == 'weight') {
                        str += "<td>" + "<input type='text' name='" + json[i]['id'] + "'alt='" + key + "' >" + "</td>";
                    } else if (key == 'money') {
                        if (json[i]['id'] == json[json.length - 1].id) {
                            str += "<td style='width:75%;float:left;height:100%;'>" + "<input style='width:25%;float:right;box-sizing:border-box;text-align:right;padding-right:5px' type='number' name='" + json[i]['id'] + "'alt='" + key + "' class='sumnum'>" + "</td>";
                            continue;
                        } else {
                            str += "<td>" + "<input type='number' name='" + json[i]['id'] + "'alt='" + key + "'class='num' >" + "</td>";
                        }
                    } else if (key == 'id') {
                        continue;
                    } else {
                        str += "<td>" + json[i][key] + "</td>";
                    }
                }
                str += "</tr>";
            }
        }
        str += "</table>";
        document.getElementById('info').innerHTML = str;

        // 取消按钮
        $("#cancle").click(function() {
            $(".boxSwitch").removeClass('active')
        });

        // 确定按钮
        $("#confirm").click(function() {
            var inputs = document.querySelectorAll("#info input");
            var arr = json.slice(1)
            arr.forEach(function(el){
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].name == el.id) {
                        for (key in el) {
                            if (key == 'weight' || key == 'money') {
                                if (key == $(inputs[i])['0'].alt) {
                                    el[key] = inputs[i].value;
                                }
                            }
                        }
                    }
                }
            });
            console.log(arr);
            var num = [];
            var sum = [];
            num = arr.slice(0, arr.length - 1);
            sum = arr.slice(arr.length - 1);
            num = JSON.stringify(num);
            sum = JSON.stringify(sum);
            $(".boxSwitch").removeClass('active');
            $.ajax({
                url: "/admin/mails/check_update",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    number:$('#number').val(),
                    num:num,
                    sum:sum
                },
                success: function (data) {
                    layer.alert('提交成功！',{
                        title: '提示框',
                        icon:1,
                    });
                    layer.close();
                    setTimeout(function(){
                        window.location.href = "/admin/mails/check";
                    },700);
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
        });

        //计算
        $('.num').on("change", function() {
            var val = parseFloat($(this).val());
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toFixed(2));
//            var nums = $("input[alt = 'money']");
//            var newNums = 0;
//            for (var i = 0; i < nums.length; i++) {
//                if (nums[i].name != 'sum') {
//                    newNums += Number(nums[i].value)
//                }
//            }
//            $('.sumnum')[0].value = newNums.toFixed(2);
        });

        $('.sumnum').change(function() {
            var val = parseFloat($(this).val());
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toFixed(2));
        });
    }


    // 开启按钮
    $("#open").click(function() {
        $(".boxSwitch").addClass('active');
        $.ajax({
            url: "/admin/mails/get_items",
            type: "post",
            async:false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                number:$('#number').val()
            },
            success: function (data) {
                json = data;
                getData();
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
    });


</script>
</html>