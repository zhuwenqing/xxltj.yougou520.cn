/**
 * 微信号更换
 */
arr_wx = ['chh9636', 'xa3731', 'sin054'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];

$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
    });
});