 /**
  * 微信号添加
  */

 arr_wx = ['ct67686','cv1446','cv1447','cv1448','ev6869','QQJG0006','QQJG0008','QQJG0011','QQJG0018',
 'QQJG0024','QQJG0026','QQJG0029','QQJG0034','QQJG0036','QQJG0037','QQJG0039','QQJG0041'
 ]
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