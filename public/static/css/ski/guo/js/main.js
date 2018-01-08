arr_wx = ['gdq15815', 'xyq813999'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];
$(document).ready(function(){
	$('*').each(function(){
		$(this).css('color',$(this).attr('color'));
	});
});