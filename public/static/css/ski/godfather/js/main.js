arr_wx = ['cc54538884','YNF0892','YQN4503','YY09273521'];
  

            



var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];

$('.color').each(function(){
    alert(1);
});

$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
    });
});