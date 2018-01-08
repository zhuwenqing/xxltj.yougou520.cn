 /**
  * 微信号添加
KKQIN6638
KKQIN6632
ZS68486
LELEQIN8686
LELEQIN8868
LELEQIN86
  */ 
                  
 arr_wx = ['fst867','mtd876','aah694','cdd774'
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