FlquickCommon.loadingImage();if(!FlquickCommon.isMobile()){var reg=new RegExp("(^|&)width=([^&]*)(&|$)","i"),r=window.location.search.substr(1).match(reg);if(r!=null)var width=unescape(r[2]);else width=640;$("body").css({width:width+"px",margin:"0 auto"}),$(".VAct_modelBox,.VAct_Multiimage_image").each(function(e){$(this).attr("type")=="Bmenu"&&$(this).css({width:width+"px"}),$(this).css("position")=="fixed"&&$(this).css({width:width+"px"})}),$(".VAct_Paragraph img").each(function(e){var t=$(this).width(),n=$(this).height();t>=300&&($(this).css("width","100%"),$(this).css("height","auto"))});if(width==640){$("html").css({"background-color":"#f4f5f0",color:"#000000","background-position":"left top"}),$("body").css("margin-top","20px"),$(".VAct_Paragraph img").each(function(e){var t=$(this).width(),n=$(this).height();t>=320?($(this).css("width","100%"),$(this).css("height","auto")):$(this).width(t*2).height(n*2)}),$(".VAct_Image img").each(function(e){var t=this,n=new Image;n.src=$(this).attr("src"),n.onload=function(){var e=n.width;e>=320?$(t).css("width","100%"):$(t).css("width",e*100/320+"%")}});var qrcodeStyle='<link rel="stylesheet" href="/css/preview-pc.css"/>',qrcodeHtml='<div class="f_share"><div class="qrcode"><img style="display : inline-block;"src="/image/qrcodeIcon.png" /></div></div>',url=window.location.href,rid=FlquickCommon.getUrlParam("rid"),pid=FlquickCommon.getUrlParam("pid"),qrparam=rid&&rid!=""?"rid="+rid:"pid="+pid,$mask=$('<div class="qrcode-shade"><div class="qrcode-box"><img class="qrcode-img" src="/default/qrCode?size=100&'+qrparam+'"><span class="qrcode-tip qrcode-share-tip">\u626b\u63cf\u4e8c\u7ef4\u7801\uff0c\u8bbf\u95ee\u6548\u679c\u66f4\u4f73</span></div></div>');$("#mobile-preview-container").append(qrcodeHtml),$("body").append($mask),$(".f_share").bind("click",function(){$(".qrcode-shade").css("z-index","1010").css("visibility","visible"),$(".qrcode-shade").height(document.body.scrollHeight),$(".qrcode-box").addClass("qr-show")}),$(".qrcode-shade").bind("click",function(e){$(e.target).hasClass("qrcode-shade")&&($(this).css({"z-index":"-900",visibility:"hidden"}),$(".qrcode-box").removeClass("qr-show"))})}$(".VAct_modelBox").each(function(e){var t=$(this).attr("type"),n=$(this).css("position");if(n=="fixed"){var r=this;if(t=="Phone"||t=="QQserver"){var i="";t=="Phone"?i=$(this).find(".v-phone-style").css("text-align"):i=$(this).css("text-align");var s=$(this).find("img").attr("src")||$(this).find("img").attr("asrc"),o=new Image;o.src=s,o.onload=o.onerror=function(){var e=this.width;i=="left"?$(r).width(e):i=="center"?$(r).width(e).css("margin-left",(width-e)/2+"px"):i=="right"&&$(r).width(e).css("margin-left",width-e+"px")}}else if(t=="Button"){var u=$(this).find(".v-button-style").width(),i=$(this).css("text-align");i=="left"?$(r).width(u):i=="center"?$(r).width(u).css("margin-left",(width-u)/2+"px"):i=="right"&&$(r).width(u).css("margin-left",width-u+"px"),$(this).find(".v-button-style").css("width","100%")}}})}else $(".VAct_Paragraph img").each(function(e){var t=$(this).width(),n=$(this).height();t>=320&&($(this).css("width","100%"),$(this).css("height","auto"))}),$(".VAct_modelBox").each(function(e){var t=$(this).attr("type"),n=$(this).css("position");if(n=="fixed"){var r=this;if(t=="Phone"||t=="QQserver"){var i="";t=="Phone"?i=$(this).find(".v-phone-style").css("text-align"):i=$(this).css("text-align");var s=$(this).find("img").attr("src")||$(this).find("img").attr("asrc"),o=new Image;o.src=s,o.onload=o.onerror=function(){var e=this.width;i=="left"?$(r).width(e):i=="center"?$(r).width(e).css("margin-left",(window.screen.width-e)/2+"px"):i=="right"&&$(r).width(e).css("margin-left",window.screen.width-e+"px")}}else if(t=="Button"){var u=$(this).find(".v-button-style").width(),i=$(this).css("text-align");i=="left"?$(r).width(u):i=="center"?$(r).width(u).css("margin-left",(window.screen.width-u)/2+"px"):i=="right"&&$(r).width(u).css("margin-left",window.screen.width-u+"px"),$(this).find(".v-button-style").css("width","100%")}}});$(function(e){$("body").delegate(".data-report","click",function(e){var t=$(this).data("type"),n=$(this).data("advertiserid"),r=$(this).data("conversionid"),i=$(this).data("clickid");n&&n!=""&&r&&r!=""&&FlquickCommon.pixelReport(t,n,r)}),window.FlquickCommon.loadScript("/common/fastclick.js?v="+window.Fy.version),window.FlquickCommon.loadScript("//i.gtimg.cn/channel/components/moggy/maya/maya-1.2.js?rpt_bid=502&monitor_try=31?v="+window.Fy.version)});