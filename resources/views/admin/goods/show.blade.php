@include('admin.layout.head')

<body>
<div class="clearfix" id="add_picture">

    <form action="/admin/goods/store" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
        {{csrf_field()}}
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
                        <select class="select" name="sort_id">
                            @foreach($sorts as $sort)
                            <option value="{{$sort->id}}">{{$sort->name}}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2"><span style="color: red">*</span>上&nbsp;下&nbsp;架：</label>
                <div class="formControls col-2">
                    <span class="select-box">
                        <select class="select" name="state">
                            <option value="1">上架</option>
                            <option value="0">下架</option>
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
            <ul style="color: red; line-height: 35px; width: 500px; font-size: 14px; margin: 20px;">
                @foreach ($errors->all() as $error)
                    <li>*{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <div class="clearfix cl">
            <div class="Button_operation">
            <button  class="btn btn-primary radius" type="submit"><i class="icon-save "></i>提交</button>
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
</script>