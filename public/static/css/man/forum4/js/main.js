/**
 * 微信号添加
 */
arr_wx = ['Am311534', 'Am311535', 'Am311530', 'Am311519', 'eir2018'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];




/**
 * 点击弹窗事件
 */
$(document).ready(function() {
    $(".wxbtn").click(function() {
        $(".click").hide();
        $(".popup").show();
    });
    $(".close").click(function() {
        $(".popup").hide();
        $(".wxbtn").show();
    })
});


/** 
 * 图片延时加载
 */
$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
    });
});