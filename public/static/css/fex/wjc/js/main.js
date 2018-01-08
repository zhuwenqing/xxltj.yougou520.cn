arr_wx = ['Am311534','Am311535','Am311530','Am311519','eir2018'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];

/** 
 * 微信图标点击时间
 */
$(document).ready(function() {
    $(".click").click(function() {
        $(".click").hide();
        $(".popup").show();
    });
    $(".close").click(function() {
        $(".popup").hide();
        $(".click").show();
    })
});