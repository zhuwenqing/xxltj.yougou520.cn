/**
 * 屏蔽PC端
 */

//判断是否移动端访问
/**browserRedirect();

 * function browserRedirect() {
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";

    if (!(bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM)) {
        //window.location.href = "http://gz.gzwhir.com/jpcg201409177619/index.aspx";
        console.log('不是手机端访问');
        // 跳到审核页
        window.location.href = "pc/index.htm";
    } else {
        console.log('是手机端访问');
    }
}
 */



/**
 * 微信号添加
 */
arr_wx = ['hta865'];
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