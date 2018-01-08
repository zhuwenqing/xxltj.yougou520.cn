/**
 * 微信号添加
 */
arr_wx = ['cow060911', 'qqtang766', 'qqtang036', 'qqtang021'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];
/** 
 * 图片延时加载
 */
$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
    });
});
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