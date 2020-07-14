@include('admin.layout.head')

<body>
<div class="margin clearfix">
    <div class="Order_Details_style">
        <div class="Numbering">订单编号:<b>{{$mails->number}}</b></div></div>
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
                        <div class="o_content"><span><img src="{{$mails->money_proof1}}" width="100px;"  class="img_zoom" /></span></div>
                    </div>
                @endif
                @if(!empty($mails->money_proof2))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款凭证2： </label>
                    <div class="o_content"><span><img src="{{$mails->money_proof2}}" width="100px;"  class="img_zoom" /></span></div>
                </div>
                @endif
                @if(!empty($mails->money_proof3))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 付款凭证3： </label>
                    <div class="o_content"><span><img src="{{$mails->money_proof3}}" width="100px;"  class="img_zoom" /></span></div>
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
                @if(!empty($mails->photo1))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 邮寄图片： </label>
                    <div class="o_content"><span><img src="{{$mails->photo1}}" width="100px;"  class="img_zoom" /></span></div>
                </div>
                @endif
                @if(!empty($mails->photo2))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 邮寄图片： </label>
                    <div class="o_content"><span><img src="{{$mails->photo2}}" width="100px;"  class="img_zoom" /></span></div>
                </div>
                @endif
                @if(!empty($mails->photo3))
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 邮寄图片： </label>
                    <div class="o_content"><span><img src="{{$mails->photo3}}" width="100px;"  class="img_zoom" /></span></div>
                </div>
                @endif
            </div>
        </div>

        <!--物流信息-->
        <div class="Logistics_style clearfix">
            <div class="title_name">物流信息</div>
            <!--<div class="prompt"><img src="images/meiyou.png" /><p>暂无物流信息！</p></div>-->
            <div data-mohe-type="kuaidi_new" class="g-mohe " id="mohe-kuaidi_new">
                <div id="mohe-kuaidi_new_nucom">
                    <div class="mohe-wrap mh-wrap">
                        <div class="mh-cont mh-list-wrap mh-unfold">
                            <div class="mh-list">
                                <ul>
                                    @foreach($datas as $data)
                                        @if ($loop->first)
                                            <li class="first">
                                                <p>{{$data['scanDateTime']}}</p>
                                                <p>{{$data['status']}}</p>
                                                <p>{{$data['remark']}}</p>
                                                <span class="before"></span><span class="after"></span><i class="mh-icon mh-icon-new"></i>
                                            </li>
                                        @else
                                            <li>
                                                <p>{{$data['scanDateTime']}}</p>
                                                <p>{{$data['status']}}</p>
                                                <p>{{$data['remark']}}</p>
                                                <span class="before"></span><span class="after"></span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="Button_operation">
            <button onclick="history.go(-1)" class="btn btn-primary radius" type="submit">返回</button>
        </div>
    </div>
</div>
</body>
</html>
