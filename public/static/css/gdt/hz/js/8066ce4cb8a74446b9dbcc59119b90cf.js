(function(){window.Global||(Global={}),Global.API_HOST={Custom:"http://flzhan.cn",Manage:"http://gdt.zhan.qq.com",Admin:"http://gdtadmin.zhan.qq.com"}})();var BJ_REPORT=function(e){if(e.BJ_REPORT)return e.BJ_REPORT;var t=[],n={},r={id:0,uin:0,url:"",combo:1,ext:null,level:4,ignore:[],random:1,delay:1e3,submit:null,repeat:5},i=function(e,t){return Object.prototype.toString.call(e)==="[object "+(t||"Object")+"]"},s=function(e){var t=typeof e;return t==="object"&&!!e},o=function(e){return e===null?!0:i(e,"Number")?!1:!e},u=e.onerror;e.onerror=function(t,n,r,s,o){var a=t;o&&o.stack&&(a=f(o)),i(a,"Event")&&(a+=a.type?"--"+a.type+"--"+(a.target?a.target.tagName+"::"+a.target.src:""):""),g.push({msg:a,target:n,rowNum:r,colNum:s}),m(),u&&u.apply(e,arguments)};var a=function(e){try{if(e.stack){var t=e.stack.match("https?://[^\n]+");t=t?t[0]:"";var n=t.match(":(\\d+):(\\d+)");n||(n=[0,0,0]);var r=f(e);return{msg:r,rowNum:n[1],colNum:n[2],target:t.replace(n[0],"")}}return e.name&&e.message&&e.description?{msg:JSON.stringify(e)}:e}catch(i){return e}},f=function(e){var t=e.stack.replace(/\n/gi,"").split(/\bat\b/).slice(0,9).join("@").replace(/\?[^:]+/gi,""),n=e.toString();return t.indexOf(n)<0&&(t=n+"@"+t),t},l=function(e,t){var n=[],i=[],u=[];if(s(e)){e.level=e.level||r.level;for(var a in e){var f=e[a];if(!o(f)){if(s(f))try{f=JSON.stringify(f)}catch(l){f="[BJ_REPORT detect value stringify error] "+l.toString()}u.push(a+":"+f),n.push(a+"="+encodeURIComponent(f)),i.push(a+"["+t+"]="+encodeURIComponent(f))}}}return[i.join("&"),u.join(","),n.join("&")]},c=[],h=function(e){if(r.submit)r.submit(e);else{var t=new Image;c.push(t),t.src=e}},p=function(e){if(!s(e))return!0;var t=e.msg,i=n[t]=(parseInt(n[t],10)||0)+1;return i>r.repeat},d=[],v=0,m=function(e){if(!r.report)return;while(t.length){var n=!1,s=t.shift();if(p(s))continue;var o=l(s,d.length);if(i(r.ignore,"Array"))for(var u=0,a=r.ignore.length;u<a;u++){var f=r.ignore[u];if(i(f,"RegExp")&&f.test(o[1])||i(f,"Function")&&f(s,o[1])){n=!0;break}}n||(r.combo?d.push(o[0]):h(r.report+o[2]+"&_t="+ +(new Date)),r.onReport&&r.onReport(r.id,s))}var c=d.length;if(c){var m=function(){clearTimeout(v),h(r.report+d.join("&")+"&count="+d.length+"&_t="+ +(new Date)),v=0,d=[]};e?m():v||(v=setTimeout(m,r.delay))}},g=e.BJ_REPORT={push:function(e){if(Math.random()>=r.random)return g;var n=s(e)?a(e):{msg:e};return r.ext&&!n.ext&&(n.ext=r.ext),n.from||(n.from=encodeURIComponent(location.href)),t.push(n),m(),g},report:function(e){return e&&g.push(e),m(!0),g},info:function(e){return e?(s(e)?e.level=2:e={msg:e,level:2},g.push(e),g):g},debug:function(e){return e?(s(e)?e.level=1:e={msg:e,level:1},g.push(e),g):g},init:function(e){if(s(e))for(var n in e)r[n]=e[n];var i=parseInt(r.id,10);return i&&(/qq\.com$/gi.test(location.hostname)&&(r.url||(r.url="//badjs2.qq.com/badjs"),r.uin||(r.uin=parseInt((document.cookie.match(/\buin=\D+(\d+)/)||[])[1],10))),r.report=(r.url||"/badjs")+"?id="+i+"&uin="+r.uin+"&"),t.length&&m(),g},__onerror__:e.onerror};return typeof console!="undefined"&&console.error&&setTimeout(function(){var e=((location.hash||"").match(/([#&])BJ_ERROR=([^&$]+)/)||[])[2];e&&console.error("BJ_ERROR",decodeURIComponent(e).replace(/(:\d+:\d+)\s*/g,"$1\n"))},0),g}(window);typeof module!="undefined"&&(module.exports=BJ_REPORT);var BJ_REPORT=function(e){if(e.BJ_REPORT)return e.BJ_REPORT;var t=[],n={},r={id:0,uin:0,url:"",combo:1,ext:null,level:4,ignore:[],random:1,delay:1e3,submit:null,repeat:5},i=function(e,t){return Object.prototype.toString.call(e)==="[object "+(t||"Object")+"]"},s=function(e){var t=typeof e;return t==="object"&&!!e},o=function(e){return e===null?!0:i(e,"Number")?!1:!e},u=e.onerror;e.onerror=function(t,n,r,s,o){var a=t;o&&o.stack&&(a=f(o)),i(a,"Event")&&(a+=a.type?"--"+a.type+"--"+(a.target?a.target.tagName+"::"+a.target.src:""):""),g.push({msg:a,target:n,rowNum:r,colNum:s}),m(),u&&u.apply(e,arguments)};var a=function(e){try{if(e.stack){var t=e.stack.match("https?://[^\n]+");t=t?t[0]:"";var n=t.match(":(\\d+):(\\d+)");n||(n=[0,0,0]);var r=f(e);return{msg:r,rowNum:n[1],colNum:n[2],target:t.replace(n[0],"")}}return e.name&&e.message&&e.description?{msg:JSON.stringify(e)}:e}catch(i){return e}},f=function(e){var t=e.stack.replace(/\n/gi,"").split(/\bat\b/).slice(0,9).join("@").replace(/\?[^:]+/gi,""),n=e.toString();return t.indexOf(n)<0&&(t=n+"@"+t),t},l=function(e,t){var n=[],i=[],u=[];if(s(e)){e.level=e.level||r.level;for(var a in e){var f=e[a];if(!o(f)){if(s(f))try{f=JSON.stringify(f)}catch(l){f="[BJ_REPORT detect value stringify error] "+l.toString()}u.push(a+":"+f),n.push(a+"="+encodeURIComponent(f)),i.push(a+"["+t+"]="+encodeURIComponent(f))}}}return[i.join("&"),u.join(","),n.join("&")]},c=[],h=function(e){if(r.submit)r.submit(e);else{var t=new Image;c.push(t),t.src=e}},p=function(e){if(!s(e))return!0;var t=e.msg,i=n[t]=(parseInt(n[t],10)||0)+1;return i>r.repeat},d=[],v=0,m=function(e){if(!r.report)return;while(t.length){var n=!1,s=t.shift();if(p(s))continue;var o=l(s,d.length);if(i(r.ignore,"Array"))for(var u=0,a=r.ignore.length;u<a;u++){var f=r.ignore[u];if(i(f,"RegExp")&&f.test(o[1])||i(f,"Function")&&f(s,o[1])){n=!0;break}}n||(r.combo?d.push(o[0]):h(r.report+o[2]+"&_t="+ +(new Date)),r.onReport&&r.onReport(r.id,s))}var c=d.length;if(c){var m=function(){clearTimeout(v),h(r.report+d.join("&")+"&count="+d.length+"&_t="+ +(new Date)),v=0,d=[]};e?m():v||(v=setTimeout(m,r.delay))}},g=e.BJ_REPORT={push:function(e){if(Math.random()>=r.random)return g;var n=s(e)?a(e):{msg:e};return r.ext&&!n.ext&&(n.ext=r.ext),n.from||(n.from=encodeURIComponent(location.href)),t.push(n),m(),g},report:function(e){return e&&g.push(e),m(!0),g},info:function(e){return e?(s(e)?e.level=2:e={msg:e,level:2},g.push(e),g):g},debug:function(e){return e?(s(e)?e.level=1:e={msg:e,level:1},g.push(e),g):g},init:function(e){if(s(e))for(var n in e)r[n]=e[n];var i=parseInt(r.id,10);return i&&(/qq\.com$/gi.test(location.hostname)&&(r.url||(r.url="//badjs2.qq.com/badjs"),r.uin||(r.uin=parseInt((document.cookie.match(/\buin=\D+(\d+)/)||[])[1],10))),r.report=(r.url||"/badjs")+"?id="+i+"&uin="+r.uin+"&"),t.length&&m(),g},__onerror__:e.onerror};return typeof console!="undefined"&&console.error&&setTimeout(function(){var e=((location.hash||"").match(/([#&])BJ_ERROR=([^&$]+)/)||[])[2];e&&console.error("BJ_ERROR",decodeURIComponent(e).replace(/(:\d+:\d+)\s*/g,"$1\n"))},0),g}(window);typeof module!="undefined"&&(module.exports=BJ_REPORT),function(e){if(!e.BJ_REPORT){console.error("please load bg-report first");return}var t=function(t){e.BJ_REPORT.push(t)},n={};e.BJ_REPORT.tryJs=function(e){return e&&(t=e),n};var r=function(e,t){for(var n in t)e[n]=t[n]},i=function(e){return typeof e=="function"},s,o=function(n,r){return function(){try{return n.apply(this,r||arguments)}catch(i){t(i),i.stack&&console&&console.error&&console.error("[BJ-REPORT]",i.stack);if(!s){var o=e.onerror;e.onerror=function(){},s=setTimeout(function(){e.onerror=o,s=null},50)}throw i}}},u=function(e){return function(){var t,n=[];for(var r=0,s=arguments.length;r<s;r++)t=arguments[r],i(t)&&(t=o(t)),n.push(t);return e.apply(this,n)}},a=function(e){return function(t,n){if(typeof t=="string")try{t=new Function(t)}catch(r){throw r}var i=[].slice.call(arguments,2);return t=o(t,i.length&&i),e(t,n)}},f=function(e,t){return function(){var n,r,s=[];for(var u=0,a=arguments.length;u<a;u++)n=arguments[u],i(n)&&(r=o(n))&&(n.tryWrap=r)&&(n=r),s.push(n);return e.apply(t||this,s)}},l=function(e){var t,n;for(t in e)n=e[t],i(n)&&(e[t]=o(n));return e};n.spyJquery=function(){var t=e.$;if(!t||!t.event)return n;var r,s;t.zepto?(r=t.fn.on,s=t.fn.off,t.fn.on=f(r),t.fn.off=function(){var e,t=[];for(var n=0,r=arguments.length;n<r;n++)e=arguments[n],i(e)&&e.tryWrap&&(e=e.tryWrap),t.push(e);return s.apply(this,t)}):window.jQuery&&(r=t.event.add,s=t.event.remove,t.event.add=f(r),t.event.remove=function(){var e,t=[];for(var n=0,r=arguments.length;n<r;n++)e=arguments[n],i(e)&&e.tryWrap&&(e=e.tryWrap),t.push(e);return s.apply(this,t)});var o=t.ajax;return o&&(t.ajax=function(e,n){return n||(n=e,e=undefined),l(n),e?o.call(t,e,n):o.call(t,n)}),n},n.spyModules=function(){var t=e.require,s=e.define;return s&&s.amd&&t&&(e.require=u(t),r(e.require,t),e.define=u(s),r(e.define,s)),e.seajs&&s&&(e.define=function(){var e,t=[];for(var n=0,r=arguments.length;n<r;n++)e=arguments[n],i(e)&&(e=o(e),e.toString=function(e){return function(){return e.toString()}}(arguments[n])),t.push(e);return s.apply(this,t)},e.seajs.use=u(e.seajs.use),r(e.define,s)),n},n.spySystem=function(){return e.setTimeout=a(e.setTimeout),e.setInterval=a(e.setInterval),n},n.spyCustom=function(e){return i(e)?o(e):l(e)},n.spyAll=function(){return n.spyJquery().spyModules().spySystem(),n}}(window),BJ_REPORT.init({url:Global.API_HOST.Manage+"/report/jsreport",id:1,onReport:function(e,t){console.log("bad js report")}}),$(document).ajaxError(function(e,t,n,r){var i=[],s=function(e){var t,n=window.location.origin,r=window.location.pathname;return t=/^https?:\/\//.test(e)?e:/^\//.test(e)?n+e:n+r.replace(/(?:\/)\w*$/,"/"+e),t};i.push("status="+t.status),i.push("responseText="+encodeURIComponent(t.responseText)),i.push("ua="+encodeURIComponent(window.navigator.userAgent)),i.push("type="+n.type),i.push("param="+n.data==undefined?"":JSON.stringify(n.data)),i.push("errorType="+encodeURIComponent(t.statusText)),i.push("url="+encodeURIComponent(s(n.url)));var o=new Image;o.onload=o.onerror=function(){o=null},o.src=Global.API_HOST.Manage+"/report/ajaxError?"+i.join("&")});