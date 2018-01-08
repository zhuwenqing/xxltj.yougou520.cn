$(document).ready(function () {
	$('.r_body .more').click(function (event) {
		$(this).toggleClass('active');
		$('.result .r_body .detail[data-id="' + $(this).attr('data-id') + '"]').slideToggle();
		//		alert($(this).attr('data-id'));
		event.stopPropagation();
	});
	$(".search").on('keypress', function (e) { //搜索事件
		var keycode = e.keyCode;
		var searchName = $(this).val();
		if (keycode == '13') {
			e.preventDefault();
			alert($(this).val());
		}
	});
	$('.class_index').click(function(){
		$('.select_class').click()
	});
});
