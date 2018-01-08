 /**
  * 微信号添加
  */
 arr_wx = ['bte566', 'bte536', 'tab327','tte564',' mee755'];
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