var FlquickCommon={isMobile:function(){var e="pc",t=navigator.userAgent.toLowerCase();return t.indexOf("mobile")>-1?e="mobile":t.indexOf("iphone")>-1?e="mobile":t.indexOf("ipad")>-1?e="mobile":t.indexOf("phone")>-1?e="mobile":t.indexOf("blackberry")>-1?e="mobile":t.indexOf("meego")>-1?e="mobile":t.indexOf("rim")>-1?e="mobile":t.indexOf("android")>-1&&(e="mobile"),e=="mobile"},isAndroid:function(){var e=navigator.userAgent.toLowerCase();return e.indexOf("android")>-1?!0:!1},isIOS:function(){var e=navigator.userAgent.toLowerCase();return e.indexOf("phone")>-1||e.indexOf("iphone")>-1||e.indexOf("ipad")>-1?!0:!1},isWXBrowser:function(){return navigator.userAgent.toLowerCase().match(/MicroMessenger/i)=="micromessenger"?!0:!1},isUrl:function(e){return/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(e)},loadScript:function(e,t){var n=document.createElement("script");n.type="text/javascript",n.readyState?n.onreadystatechange=function(){if(n.readyState=="loaded"||n.readyState=="complete")n.onreadystatechange=null,t&&t()}:n.onload=function(){t&&t()},n.src=e,document.body.appendChild(n)},addImageEventTime:function(e){if(typeof e=="undefined"||e=="")return!1;var t=new Image;t.onload=t.oncomplete=t.onerror=function(){window.loadEndImageTime=Date.now()},t.src=e},loadFirstImage:function(e){var t=$($("img")[0]).attr("asrc");if(typeof t!="undefined"&&t!=""){var n=new Image;n.onload=n.oncomplete=n.onerror=function(){typeof window.loadFirstImageTime=="undefined"&&(window.loadFirstImageTime=Date.now()),e&&e(),$("img").each(function(){$(this).attr("src",$(this).attr("asrc")),FlquickCommon.addImageEventTime($(this).attr("asrc"))})},n.src=t}else e&&e(),$("img").each(function(){$(this).attr("src",$(this).attr("asrc")),FlquickCommon.addImageEventTime($(this).attr("asrc"))})},loadingGalleryImage:function(){$(".gallery-c-list-item").each(function(){var e=$(this).attr("bImage");typeof e!="undefined"&&e!=""&&(FlquickCommon.addImageEventTime(e),$(this).css("background-image","url("+e+")").show())}),typeof initGalleryStart!="undefined"&&initGalleryStart()},loadingGalleryFirstImage:function(e){var t=$(".gallery-c-list-item-first").attr("bImage");if(typeof t!="undefined"&&t!=""){var n=new Image;n.onload=n.oncomplete=n.onerror=function(){typeof window.loadFirstImageTime=="undefined"&&(window.loadFirstImageTime=Date.now()),e&&e()},n.src=t}else e&&e()},loadingImage:function(){window.loadImageStart=Date.now(),window.isHasGallery?FlquickCommon.loadingGalleryFirstImage(function(){FlquickCommon.loadFirstImage(function(){FlquickCommon.loadingGalleryImage()})}):FlquickCommon.loadFirstImage(function(){FlquickCommon.loadingGalleryImage()})},windowopen:function(e,t){var n=document.createElement("a");n.setAttribute("href",e),t==null&&(t=""),n.setAttribute("target",t),document.body.appendChild(n);if(n.click)n.click();else try{var r=document.createEvent("Event");n.initEvent("click",!0,!0),n.dispatchEvent(r)}catch(i){window.open(e)}document.body.removeChild(n)},pixelReport:function(e,t,n,r){if(window.FlquickCommon.getUrlParam("nreport"))return!1;var i=window.gdt_tracker||[];i.push(["set_account_id",t]);if(e=="tel")i.push(["add_action","TRACK_CONVERSION",n]);else if(e=="location")i.push(["add_action","TRACK_CONVERSION",n,{action_track_attribute:"30101"}]);else if(e=="form"){var s={};for(var o=0;o<r.serializeArray().length;o++){var u=r.serializeArray()[o],a=$("[name="+u.name+"]").parents(".weui-cell").find(".weui-label").html().replace('<label class="red">*</label>',"");a&&a!=""&&(s[a]=u.value)}i.push(["add_action","TRACK_CONVERSION",n,{form_info:JSON.stringify(s)}])}i.push(["send"])},reportError:function(e){var t="http://gdt.zhan.qq.com/report/jsreport?id=1&uin=0&msg[0]="+e+window.location.href+"------"+document.cookie+"&level[0]=4&count=1&_t=1490261884955",n=new Image;n.onload=n.onerror=function(){n=null},n.src=t},getUrlParam:function(e,t){var n=t||location.href,r=n.indexOf("?"),i,s,o={};r!=-1?(n=n.substring(r+1),s=n.split("#")[0].split("&")):s=[];for(i=0;i<s.length;++i)s[i]=s[i].split("="),o[s[i][0]]=o[s[i][0].toLowerCase()]=s[i][1];return e?o[e]:o},changeUrlArg:function(url,arg,arg_val){var pattern=arg+"=([^&]*)",replaceText=arg+"="+arg_val;if(url.match(pattern)){var tmp="/("+arg+"=)([^&]*)/gi";return tmp=url.replace(eval(tmp),replaceText),tmp}return url.match("[?]")?url+"&"+replaceText:url+"?"+replaceText},gdtReport:{send:function(e,t){var n=new Image;n.onload=n.onerror=function(){n=null};var r=this,i="",s=$.extend({},r.baseParam,t);s.random=parseInt(Math.random()*1e6);for(var o in s)s.hasOwnProperty(o)&&(i=i+o+"="+(s[o]||"")+"&");n.src=e+"?"+i},init:function(e,t){var n=this,r=FlquickCommon.getUrlParam("pv")=="no"||FlquickCommon.getUrlParam("qz_gdt")=="__tracestring__";if(r)return;var i=FlquickCommon.getUrlParam("rid"),s=FlquickCommon.getUrlParam("qz_gdt");n.baseParam={rId:i,qz_gdt:s||"",token:e,timestamp:t};var o={rId:i,qz_gdt:s||""};n.pv(),$(document).ready(function(){$("body").delegate(".data-report","click",function(e){var t=$(this).data("type");if(t=="button"){var r=$(this).data("btnlink");if(/^\#/.test(r))return}n.event(t)})});var u=function(e){var t=window.onload;typeof window.onload!="function"?window.onload=e:window.onload=function(){t(),e()}};u(function(){__timePoints.loadEnd=+(new Date),n.loadtime()}),$(document).touchwipe({wipeDown:function(){n.event("slide")},once:!0}),n.accessInfo()},event:function(e){if(window.FlquickCommon.getUrlParam("nreport")||window.FlquickCommon.getUrlParam("pv")=="no"||FlquickCommon.getUrlParam("qz_gdt")=="__tracestring__")return!1;var t=this,n={button:4,tel:1,location:5,sms:2,other:0,slide:6,qqserver:7,form:3,wxcard:8}[e||"other"];t.send("/stat/clickStream",{clickId:n})},accessInfo:function(){var e=10,t,n=this,r=window.setInterval(function(){e--,t=(+(new Date)-window.__timePoints.start)/1e3,n.send("/stat/pageStay",{viewTime:t}),e<=0&&(clearInterval(r),r=window.setInterval(function(){t=(+(new Date)-window.__timePoints.start)/1e3,n.send("/stat/pageStay",{viewTime:t}),t>=120&&clearInterval(r)},5e3))},1e3)},pv:function(){this.send("/stat/pv",{})},loadtime:function(){var e=window.performance.timing,t=((e.domContentLoadedEventEnd>0?e.domContentLoadedEventEnd:__timePoints.loadEnd)-e.fetchStart)/1e3;this.send("/stat/loadTime",{loadTime:t})},baseParam:{}}};