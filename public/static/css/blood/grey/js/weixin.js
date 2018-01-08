 /**
  * 刷新更换微信号
  */

 arr_wx = ['cow060911', 'qqtang766', 'qqtang036', 'qqtang021'];

 var wx_index = Math.floor((Math.random() * arr_wx.length));

 var stxlwx = arr_wx[wx_index];

 /** 
  * 图片延时加载
  */

 $(document).ready(function() {
     $("img.lazy").lazyload({

         effect: "fadeIn",

     });
 });