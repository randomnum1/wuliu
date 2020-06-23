@include('admin.layout.head')

<body>
<div class="clearfix" id="add_picture">

    <form action="/admin/goods/update" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
        {{csrf_field()}}

        <input type="hidden" value="{{$goods->id}}" name="id" />

        <div class="clearfix cl">
            <label class="form-label col-2"><span style="color: red">*</span>商品名称：</label>
            <div class="formControls col-10"><input type="text" class="input-text" value="{{$goods->name}}" placeholder="" id="" name="name"></div>
        </div>

        <div class=" clearfix cl">
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>价&nbsp;&nbsp;&nbsp;&nbsp;格：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="{{$goods->price}}" placeholder="人民币1.11" id="" name="price"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>单&nbsp;&nbsp;&nbsp;&nbsp;位：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="{{$goods->unit}}" placeholder="罐、个、件" id="" name="unit"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>规&nbsp;&nbsp;&nbsp;&nbsp;格：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="{{$goods->size}}" placeholder="" id="" name="size"></div>
            </div>
        </div>
        <div class=" clearfix cl">
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>库&nbsp;&nbsp;&nbsp;&nbsp;存：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="{{$goods->number}}" placeholder="" id="" name="number"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>商品类别：</label>
                <div class="formControls col-2">
                    <span class="select-box">
                        <select class="select" name="sort_id" id="sort_id">
                            @foreach($sorts as $sort)
                                @if($goods->sort_id == $sort->id)
                                    <option value="{{$sort->id}}" selected="selected">{{$sort->name}}</option>
                                @else
                                    <option value="{{$sort->id}}">{{$sort->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>上&nbsp;下&nbsp;架：</label>
                <div class="formControls col-2">
                    <span class="select-box">
                        <select class="select" name="state" id="state">
                            @if($goods->state == 1)
                                <option value="1" selected="selected">上架</option>
                                <option value="0">下架</option>
                            @else
                                <option value="1">上架</option>
                                <option value="0" selected="selected">下架</option>
                            @endif
                        </select>
                    </span>
                </div>
            </div>
        </div>

        <div class="clearfix cl">
            <label class="form-label col-2"><span style="color: red">*</span>商品详情：</label>
            <div class="formControls col-10"><input type="text" class="input-text" value="{{$goods->detail}}" placeholder="商品详细介绍" id="" name="detail"></div>
        </div>


        <div class="clearfix cl">
            <label class="form-label col-2"><span style="color: red">*</span>照片：</label>
            <img src="{{$goods->picture}}" style="width: 200px;">
        </div>

        <div class="clearfix cl">
            <label class="form-label col-2"><span style="color: red"></span>修改照片：</label>
            <input type="file" name="picture" id="picture" multiple="multiple" accept="image/*" onchange="showImg(this)">
            <img src="" alt="" id="img" style="width: 200px;">
        </div>

        <div class="clearfix cl">
            <div class="Button_operation">
            <button onClick="edit();" class="btn btn-primary radius" type="button"><i class="icon-save "></i>编辑</button>
            <button onClick="history.go(-1)" class="btn btn-default radius" type="button">&nbsp;&nbsp;返回&nbsp;&nbsp;</button>
            </div>
        </div>

    </form>

</div>

</body>
</html>

<script>
    function showImg(obj) {
        var file = $(obj)[0].files[0];    //获取文件信息
        var imgdata = '';
        if(file){
            var reader=new FileReader();    //调用FileReader
            reader.readAsDataURL(file);     //将文件读取为 DataURL(base64)
            reader.onload=function(evt){    //读取操作完成时触发。
                $("#img").attr('src',evt.target.result)  //将img标签的src绑定为DataURL
            };
        }
        else{
            alert("上传失败");
        }
    }

    /*--商品-编辑--*/
    function edit(){
        var formData = new FormData();

        if($("#picture").val() == null || $("#picture").val() == ""){

        }else{
            formData.append('picture', $("#picture")[0].files[0]);
        }
        formData.append('state', $('#state option:selected').val());
        formData.append('sort_id', $('#state option:selected').val());
        formData.append('number', $("input[ name='number']").val());
        formData.append('detail', $("input[ name='detail']").val());
        formData.append('size', $("input[ name='size']").val());
        formData.append('unit', $("input[ name='unit']").val());
        formData.append('price',$("input[ name='price']").val() );
        formData.append('name',$("input[ name='name']").val() );
        formData.append('id', $("input[ name='id']").val());
        $.ajax({
            url: "/admin/goods/update",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            cache: false,
            processData : false,
            contentType : false,
            beforeSend: function(){
                uploading = true;
            },
            success: function (data) {
                if(data){
                    layer.alert('修改成功！',{
                        title: '提示框',
                        icon:1,
                    });
                    layer.close();
                    setTimeout(function(){
                        window.location.href = "/admin/goods";
                    },700);
                }
            },
            error:function (data) {
                layer.alert('数据格式不规范',{
                    title: '提示框',
                    icon:1,
                });
                layer.close();
            }
        });
    }

</script>