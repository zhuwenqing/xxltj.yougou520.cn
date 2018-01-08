/**
 * 更换微信号
 */
arr_wx = ['Am311534', 'Am311535', 'Am311530', 'Am311519', 'eir2018'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];




var index;
$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
        $('.foot').css("bottom", "50px");

    } else if ($(window).scrollTop() + $(window).height() < $(document).height()) {
        $('.foot').css("bottom", "0px");
    }
});