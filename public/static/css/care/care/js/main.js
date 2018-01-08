
//back1.js
//360、by4、by8、by10、by15、by19、smc、zc1(两个)、sougouyong

//"1","1","1","2","2","2","2","3","3","4","5"
 



var arrWx=["48477507","47181477","79376421"];
var indexWx=Math.floor(Math.random()*arrWx.length);  
$(".wechat_code").html(arrWx[indexWx]); 
$(".weixinid").html(arrWx[indexWx]);
var stxlwx = arrWx[indexWx];



