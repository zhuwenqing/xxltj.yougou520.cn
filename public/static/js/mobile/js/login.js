$(document).ready(function () {
	$('#logining').on('keypress', function (e) { //搜索事件
		var keycode = e.keyCode;
		var searchName = $(this).val();
		if (keycode == '13') {
			e.preventDefault();
			$('#logining').click();
		}
	});
	$('#logining').click(function () {
		var x = $('#login').serializeArray(),m = [], idata;
		$.each(x, function (i, field) {
			m.push('"' + field.name + '":"' + field.value + '"');
		});
		idata =eval('('+'{' +  m.join(',') + '}'+')');  
		$.post($(this).attr('url'),idata,function(res){
			$('body .hint').html(res.msg);
			$('body .hint').fadeIn();
			setTimeout(function(){
				$('body .hint').html(0);
				$('body .hint').fadeOut();
			},2000);
			// alert(res.msg);
			if(res.code == 1){
				setTimeout(function(){
					window.location.href='/admin/changewx/index.html';
				},1000);
			}
		});
	});
});
