arr_wx = ['mz6234','mz8595'
]
    
var wx_index = Math.floor((Math.random() * arr_wx.length));
var stxlwx = arr_wx[wx_index];

$(function() {
    $("img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 1000
    });
});