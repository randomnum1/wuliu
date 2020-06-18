@include('admin.layout.head')

<body>
<div class="clearfix" id="add_picture">

    <form action="/admin/goods/store" method="post" class="form form-horizontal" id="form-article-add">
        {{csrf_field()}}
        <div class="clearfix cl">
            <label class="form-label col-2"><span class="c-red">*</span>商品名称：</label>
            <div class="formControls col-10"><input type="text" class="input-text" value="" placeholder="" id="" name="name"></div>
        </div>

        <div class=" clearfix cl">
            <div class="Add_p_s">
                <label class="form-label col-2">价&nbsp;&nbsp;&nbsp;&nbsp;格：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="" placeholder="人民币1.11" id="" name="price"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2">单&nbsp;&nbsp;&nbsp;&nbsp;位：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="" placeholder="罐、个、件" id="" name="unit"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2">规&nbsp;&nbsp;&nbsp;&nbsp;格：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="" placeholder="" id="" name="size"></div>
            </div>
        </div>
        <div class=" clearfix cl">
            <div class="Add_p_s">
                <label class="form-label col-2">库&nbsp;&nbsp;&nbsp;&nbsp;存：</label>
                <div class="formControls col-2"><input type="text" class="input-text" value="" placeholder="" id="" name="number"></div>
            </div>
            <div class="Add_p_s">
                <label class="form-label col-2">商品类别：</label>
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
                <label class="form-label col-2">上&nbsp;下&nbsp;架：</label>
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
            <label class="form-label col-2"><span class="c-red">*</span>商品详情：</label>
            <div class="formControls col-10"><input type="text" class="input-text" value="" placeholder="详细介绍" id="" name="detail"></div>
        </div>


        <div class="clearfix cl">
            <label class="form-label col-2">图片上传：</label>
            <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">

            <div id="box">
                <div id="upload"></div>
            </div>
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
            <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;返回&nbsp;&nbsp;</button>
            </div>
        </div>

    </form>
</div>

</body>
</html>

<script type="text/javascript">

    $('#upload').diyUpload({

        url:'server/fileupload.php',

        success:function( data ) {
            console.info( data );
        },

        error:function( err ) {
            console.info( err );
        }

    });

</script>