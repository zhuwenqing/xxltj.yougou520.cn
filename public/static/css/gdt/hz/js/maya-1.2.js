
(function(global){var env={};var nav=window.navigator;var intime=+(new Date);var cReport=true;var min10=1000*60*10;var errList={};window.jsreport=window.maya=(function(){var config={bid:102};var report=function(msg,url,line,level,type){if(!cReport)return false;var bid=report.bid||config.bid;level=Number(level)||4;if(!env.info){env.info={};env.info.userAgent=nav.userAgent;env.info.platform=nav.platform;env.info.appCodeName=nav.appCodeName;env.info.appName=nav.appName;env.info.appVersion=nav.appVersion;}
var info=env.info;var _info=info&&['|_|browser:[','agent:'+info.userAgent,',plat:'+info.platform,',appcode:'+info.appCodeName,',appname:'+info.appName,',appversion:'+info.appVersion
+']','|_|'+'st:'+((+new Date())-intime)].join('')||'';var surl=location.href;setTimeout(function(){if((typeof msg=='object')&&msg.toString){var msg_str=msg.toString();if(msg_str.indexOf('[object event]')>-1){msg=objectSerialize(msg);}}
var dataStr='common/js-report.php?type='+
type+'&level='+level+'&bid='+bid+'&surl='+encodeURIComponent(surl)+'&msg='+encodeURIComponent(msg)+'|_|'+
line;if(inErrList(dataStr)){return}
var img=new Image();var domainRoute=location.protocol+'//iyouxi.vip.qq.com/';img.src=domainRoute+dataStr+_info+'|_|'+url+'&r='+Math.random();setToErrList(dataStr)},report.buffTime*1000);}
function setToErrList(msg){var errKey=Math.floor(Date.now()/min10)*min10+'';errList[errKey]?errList[errKey].push(msg):(errList[errKey]=[msg]);}
function inErrList(errMsg){var errKey=Math.floor(Date.now()/min10)*min10+'';if(errList[errKey]&&errList[errKey].indexOf(errMsg)>-1){return true;}
return false;}
function objectSerialize(obj){var str=[],i=0,x;if(obj.toString){str.push(obj.toString());}
for(x in obj){if(i++>30)break;try{if(typeof obj[x]=='object'){str.push(x+'='+obj[x].toString().replace(/[\n\s\r]/g,''));}else{str.push(x+'='+obj[x]);}}catch(e){str.push(x+'=read-err#'+e.message);}}
return str.join('&');}
report.init=function(bid,rate,bufferTime){if(typeof(bid)=='undefined'){throw"maya缺少bid";return;}
report.rate=rate||100;report.buffTime=bufferTime||3;report.bid=bid;if(Math.random()>report.rate/100){return cReport=false;}
this.report('v',location.href,0,1,1);}
report.report=function(msg,url,line,level,type){if(arguments.length==2){report(msg,location.href,0,4,url);}else{report(msg,url||location.href,line||0,level||4,type||2);}};var arr=[];var errorHandler=function(){var stack='';if(arguments.length==1&&typeof arguments[0]=='object'){var ext='';if(arguments[0].target){ext=arguments[0].target.src;}
report.apply(global,['oneargs#'+ext+'#'+objectSerialize(arguments[0]),'',0,null,-1]);}else{if(arguments[4]&&typeof arguments[4]=='object'){stack=(arguments[4].stack||'').replace(/\n/g,'');}
arr.splice.apply(arguments,[3,0,null,-1]);arguments[0]+='#stack:'+stack;report.apply(global,arguments);}};global.onerror=errorHandler;var _extend=function(target,source){for(var key in source){target[key]=source[key];}};var _isFunction=function(fn){return typeof fn==="function";};var timeoutkey;var wrapFn=function(fn,args){return function(){try{return fn.apply(this,args||arguments);}catch(error){if(!error.reported){error.reported=true;errorHandler(error.message,'',0,0,error)
if(!timeoutkey){global.onerror=function(){};timeoutkey=setTimeout(function(){global.onerror=errorHandler;timeoutkey=null;},500);}}
throw error;}};};var makeObjTry=function(obj){var key,value;for(key in obj){value=obj[key];if(_isFunction(value))obj[key]=wrapFn(value);}
return obj;};var wrapArgs=function(fn){return function(){var arg,args=[];for(var i=0,l=arguments.length;i<l;i++){arg=arguments[i];_isFunction(arg)&&(arg=wrapFn(arg));args.push(arg);}
return fn.apply(this,args);};};var makeArgsTry=function(fn,self){return function(){var arg,tmp,args=[];for(var i=0,l=arguments.length;i<l;i++){arg=arguments[i];_isFunction(arg)&&(tmp=wrapFn(arg))&&(arg.tryWrap=tmp)&&(arg=tmp);args.push(arg);}
return fn.apply(self||this,args);};};var spyTimeout=function(fn){return function(cb,timeout){if(typeof cb==="string"){try{cb=new Function(cb);}catch(err){throw err;}}
var args=[].slice.call(arguments,2);var wrapfn=wrapFn(cb,args.length&&args);return fn(wrapfn,timeout||0);}}
var spyStatus={system:false,jquery:false,modules:false,vue:false,zero:false}
report.spyJquery=function(){var _$=global.$;if(spyStatus.jQuery){return report;}
if(!_$||!_$.event){return report;}
var _add,_remove;if(_$.zepto){_add=_$.fn.on,_remove=_$.fn.off;_$.fn.on=makeArgsTry(_add);_$.fn.off=function(){var arg,args=[];for(var i=0,l=arguments.length;i<l;i++){arg=arguments[i];_isFunction(arg)&&arg.tryWrap&&(arg=arg.tryWrap);args.push(arg);}
return _remove.apply(this,args);};}else if(window.jQuery){_add=_$.event.add,_remove=_$.event.remove;_$.event.add=makeArgsTry(_add);_$.event.remove=function(){var arg,args=[];for(var i=0,l=arguments.length;i<l;i++){arg=arguments[i];_isFunction(arg)&&arg.tryWrap&&(arg=arg.tryWrap);args.push(arg);}
return _remove.apply(this,args);};}
var _ajax=_$.ajax;if(_ajax){_$.ajax=function(url,setting){if(!setting){setting=url;url=undefined;}
makeObjTry(setting);if(url)return _ajax.call(_$,url,setting);return _ajax.call(_$,setting);};}
spyStatus.jQuery=true;return report;};report.spyModules=function(){var _require=global.require,_define=global.define;if(spyStatus.modules){return report;}
if(_define&&_define.amd&&_require){global.require=wrapArgs(_require);_extend(global.require,_require);global.define=wrapArgs(_define);_extend(global.define,_define);spyStatus.modules=true;}
if(global.seajs&&_define){global.define=function(){var arg,args=[];for(var i=0,l=arguments.length;i<l;i++){arg=arguments[i];if(_isFunction(arg)){arg=wrapFn(arg);arg.toString=(function(orgArg){return function(){return orgArg.toString();};}(arguments[i]));}
args.push(arg);}
return _define.apply(this,args);};global.seajs.use=wrapArgs(global.seajs.use);_extend(global.define,_define);spyStatus.modules=true;}
return report;};report.spySystem=function(){if(spyStatus.system){return report;}
spyStatus.system=true;global.setTimeout=spyTimeout(global.setTimeout);global.setInterval=spyTimeout(global.setInterval);return report;};report.spyCustom=function(obj){if(_isFunction(obj)){return wrapFn(obj);}else{return makeObjTry(obj);}};var vueTips=false;report.spyVue=function(vue){var Vue=global.Vue||vue;if(spyStatus.vue){return report;}
if(!Vue){!vueTips&&console.warn('maya: 没有找到名为Vue的全局变量，请手动调用 maya.spyVue(Vue)')
vueTips=true;return}
if(+Vue.version.split('.')[0]<2){!vueTips&&console.warn('maya: 暂只支持 Vue 2.0.0 及以上版本')
vueTips=true;return}
Vue.mixin({beforeCreate:function(){var option=this.$options,tryList=['watch','computed','methods','beforeCreate','created','beforeMount','mounted','beforeUpdate','updated','beforeDestroy','destroyed','activated','deactivated'],length=tryList.length;for(var i=0;i<length;i++){option[tryList[i]]&&makeObjTry(option[tryList[i]]);}}})
spyStatus.vue=true;return report;};report.spyZero=function(){if(!window.qv||!window.qv.zero||!window.qv.zero.Page||!window.qv.zero.Http){return}
if(spyStatus.zero){return report;}
var page=qv.zero.Page,http=qv.zero.Http;qv.zero.Page=function(option){makeObjTry(option);return new page(option);}
http.send&&(http.send=wrapArgs(http.send));http.SSOSend&&(http.SSOSend=wrapArgs(http.SSOSend));http.loadScript&&(http.loadScript=wrapArgs(http.loadScript));spyStatus.zero=true;return report;};return report;})();}(window));(function(){var spy=_getUrlParam('monitor_try'),rpt_bid=window.pluginData&&window.pluginData.bid,rate=window.pluginData&&window.pluginData.rate;function _getUrlParam(key,url){var regStr="[?&]"+key+"=([^&#]*)[&#]?",reg=new RegExp(url?"(?:(?:\/maya[-\\.\\d]*\\.js)|(?:qianbao.qq.com\/plugin)).*"+regStr:regStr,"i"),ret=reg.exec(url||location.search);return ret?ret[1]:"";}
function _spy(){spy=+spy;if(!spy){return}
(spy&1)===1&&maya.spySystem();(spy&2)===2&&maya.spyJquery();(spy&4)===4&&maya.spyModules();(spy&8)===8&&maya.spyVue();(spy&16)===16&&maya.spyZero();}
function _initReport(){var scriptNodes=document.getElementsByTagName('script'),url;for(var i=0,len=scriptNodes.length;i<len;i++){url=scriptNodes[i].src;_getUrlParam('rpt_bid',url)&&(rpt_bid=_getUrlParam('rpt_bid',url));_getUrlParam('rate',url)&&(rate=_getUrlParam('rate',url));_getUrlParam('monitor_try',url)&&(spy=_getUrlParam('monitor_try',url));}
rpt_bid&&(maya.init(rpt_bid,rate),_spy())}
window.addEventListener&&document.body.addEventListener('load',_spy,true);_initReport()})();