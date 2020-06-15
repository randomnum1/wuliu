$(document).ready(function(){

	var videosrc = "";
	
	
	$(".video_zoom").hover(function(){
		videosrc=$(this).attr('href');
		$(this).attr({"href":"javascript:void(0)"});
	},
	function(){
		$(this).attr({"href":""+videosrc+""});
	});

	$(".video_zoom,.img_zoom").click(function(){
		//适配屏幕高度	
		
		
		var hei = $(window).height()*0.85 +"px";
		var wid = $(window).width()*0.85 +"px";
		var imgsrc = $(this).attr("src");
		
		if($(this).attr("class") == "video_zoom"){
			var htmlcontent = "<div class='image_wrap_fixed'><div class='image_mask'></div><span class='image_wrap_content_scroll'><video src='" + videosrc + "'class='video_wrap' controls='controls' type='video/mp4' style='max-width:" + wid +";max-height:" + hei +";'></video></span></div>"
		}
		else{
			var imgarr = [];
			$(".img_zoom").each(function(index, element) {
			var src=$(element).attr("src");
			imgarr.push(src);
			});
			var htmlcontent = "<div class='image_wrap_fixed'><div class='image_mask'></div><div class='leftbt'><</div><div class='rightbt'>></div><span class='image_wrap_content_scroll'><img src='" + imgsrc + "'class='image_zoom' style='max-width:" + wid +";max-height:" + hei +";'></span></div>"
		}
		
		$("body").append(htmlcontent);
		
		
		
		$(".image_mask,.image_wrap_content_scroll").click(function(){
			$(".image_wrap_fixed").hide();
			$(".image_wrap_fixed").remove();
		})
		
		$(".leftbt").click(function(){
			var imgindexsrc = $(".image_zoom").attr("src");
			var imgindex = $.inArray(imgindexsrc,imgarr);
			var leftimg = imgindex-1;
			if(leftimg >=0){
				$(".image_zoom").attr("src",imgarr[leftimg]);
			}
		})
		$(".rightbt").click(function(){
			var imgindexsrc = $(".image_zoom").attr("src");
			var imgindex = $.inArray(imgindexsrc,imgarr);
			var leftimg = imgindex+1;
			if(leftimg < imgarr.length){
				$(".image_zoom").attr("src",imgarr[leftimg]);
			}
		})
	})

})
