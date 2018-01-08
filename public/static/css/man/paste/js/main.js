arr_wx = ['test1996'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];
$(document).ready(function(){
    location.hash="#main";
    $('.button').click(function(){
        $('.alert').show();
    });
    $('.close').click(function(){
        $('.alert').hide();
    });
});