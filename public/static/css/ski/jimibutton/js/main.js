arr_wx = ['JMCC166','acb7895','amb9785','ANN7479','cash64','gome98','JMLS7925','wx435711'];
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];

$(document).ready(function(){
    $('.click_to').click(function(){
        $('.alert').show();
    });
    $('.close').click(function(){
        $('.alert').hide();
    });
});
