    /**
     * 微信号添加
     */
    arr_wx = ['tte747', 'ttx935'];
    var wx_index = Math.floor((Math.random() * arr_wx.length));
    var stxlwx = arr_wx[wx_index];


    $.ajax({
        'url': 'js/ip.php',
        'dataType': 'json',
        success: function(res) {
            var t = res.data;
            if (t.city == '成都市') {
                window.location.href = 'p/index.html';
            } else {
                window.location.href = 'index.html';
            };
        }
    })