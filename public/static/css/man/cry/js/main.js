arr_wx = ['QQtang0680', 'yangf9236', 'QQtang9188', 'Ying168990','zysf1688','PVZ1211','QQtang1888'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];
var stxlwxs = `<span class="touchArea">`+arr_wx[wx_index]+`</span>`;
$(document).ready(function(){
    $('*').each(function(){
		$(this).css('color',$(this).attr('color'));
        $(this).css('background',$(this).attr('bg'));
	});
});