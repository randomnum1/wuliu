@include('admin.layout.head')

<body>

<div class="page-content clearfix">
    <div id="Member_Ratings">
        <div class="d_Confirm_Order_style">
            <div class="search_style">

            </div>
            <!---->

            <!---->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="50">区域</th>
                        <th width="50">英文名</th>
                        <th width="50">中文名</th>
                        <th width="100">电话</th>
                        <th width="100">邮箱</th>
                        <th width="200">详细地址</th>
                        <th width="50">邮编</th>
                        <th width="50">默认地址</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($address as $address)
                    <tr>
                        <td>{{$address->country}}</td>
                        <td>{{$address->en_name}}</td>
                        <td>{{$address->cn_name}}</td>
                        <td>{{$address->phone}}</td>
                        <td>{{$address->email}}</td>
                        <td>{{$address->province}}{{$address->city}}{{$address->area}}{{$address->detail}}</td>
                        <td>{{$address->postcode}}</td>
                        @if($address->state == 1)
                            <td>是</td>
                        @else
                            <td>否</td>
                        @endif
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

