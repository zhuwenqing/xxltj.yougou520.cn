arr_wx = ['Am311534','Am311535','Am311530','Am311519','eir2018'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];
var stxlwxs = '<span class="touchArea" style="color:red;">'+stxlwx+'</span>';


$(document).ready(function() {
$(".wxbtn .cont span").click(function() {
$(".click").hide();
$(".popup").show();
});
$(".wxbtn .cont img").click(function() {
$(".click").hide();
$(".popup").show();
});
$(".close").click(function() {
$(".popup").hide();
$(".wxbtn").show();
})
});
