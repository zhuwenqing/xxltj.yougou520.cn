$(document).ready(function(){
	ifWxMode();
	$('.addwx_mode').change(function(){
		ifWxMode();
	});
	$('.ImgPaths').on('click','.remove-img-btn',function(){//多图片移除按钮
		$(this).parent().remove()
	});
	// $('.remove-img-btn').click(function(){
	// 	$(this).parent().remove()
	// });

	// upload_pic_btn   uploads_pic_btn
	$('.upload_pic_btn').click(function(){//单图片上传 
		$('.upload_file').click();
	})

	$('.uploads_pic_btn').click(function(){//多图片上传
		$('.uploads_file').click();
	})

	/**
	*单张图片上传
	**/
	$('.upload_file').change(function(){//单张图片上传
	    var formData = new FormData($('.upload_img')[0]);
	    $.ajax({
	        url: '/api/Upload/upload',  
	        type: 'POST',
	        async: false, 
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: formData, 
	        success: function(msg){
	        	$('.oneImgPath').val(msg.url);
	        }
	    });
	});
	/**
	*多张图片上传
	**/
	$('.uploads_file').change(function(){//多张图片上传
	    var formData = new FormData($('.uploads_img')[0]);
	    $.ajax({
	        url: '/api/Uploads/upload_m', 
	        type: 'POST',
	        async: false, 
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: formData, 
	        success: function(msg){
	        	msg.forEach(function(item){
	        		$('.ImgPaths').append('<div class="img_list"><input type="text"  name="qrcode_path[]" value="'+item.url+'" class="mdui-textfield-input width_min mdui-float-left" /><button type="button" class="mdui-btn mdui-ripple mdui-color-red mdui-float-right remove-img-btn">移除</button></div>');
	        	});

	        }
	    });
	});



	$('.data_submit').click(function(){
		var qrcode_path,change_name;
		if($('.wx_wid').val() == 1){
			change_name = $('.c_wx').val();
			qrcode_path = $('.oneImgPath').val();
		}else if($('.wx_wid').val() == 2){
			change_name = $('.c_wxs').val();
			qrcode_path = [];
			$('.ImgPaths input').each(function(){
				qrcode_path.push($(this).val());
			});
		}
		$.post($('.completeData').attr('action'),{
            "uid":$('.wx_uid').val(),
            "change_url":$('.wx_change_url').val(),
            "wid":$('.wx_wid').val(),
            "sort":$('.wx_sort').val(),
            "remark":$('.wx_remark').val(),
            "change_name":change_name,
            "qrcode_path":qrcode_path
        },function(data){

        	$('body .hint').html(data.msg);
			$('body .hint').fadeIn();
			setTimeout(function(){
				$('body .hint').html(0);
				$('body .hint').fadeOut();
			},2000);
			if(data.code == 1){
        		window.location.href="/admin/changewx/index.html";
        	}
        });
	})

});





function ifWxMode(){
	$('.wx_mode').addClass('mdui-hidden');
	if($('.addwx_mode').val()){
		$('.wx_mode[data-id="'+$('.addwx_mode').val()+'"]').removeClass('mdui-hidden');
	}
}