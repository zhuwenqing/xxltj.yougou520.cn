/*
* 如果是在iframe调用，并且当前的iframe和根窗口跨域，则直接把弹层插入到当前iframe中
*/
var WEUI = {
    _alert : function(obj, windows){
        if(windows.insert.$(".weui_dialog_alert").length >= 1){
            windows.insert.$(".weui_dialog_alert").remove();
        }
        $(windows.insert.document.body).append('<div class="weui_dialog_alert">\
                                    <div class="weui_dialog_alert">\
                                        <div class="weui_mask"></div>\
                                        <div class="weui_dialog">\
                                            <div class="weui_dialog_hd">\
                                            <strong class="weui_dialog_title">'+obj.title+'</strong>\
                                        </div>\
                                        <div class="weui_dialog_bd">'+obj.content+'</div>\
                                        <div class="weui_dialog_ft">\
                                            <a href="javascript:;" class="weui_btn_dialog primary">确定</a>\
                                        </div>\
                                    </div>\
                                </div>');
        windows.insert.$(".weui_dialog_alert").show();
        windows.insert.$(".weui_dialog_alert .weui_btn_dialog").unbind().click(function(){
            obj.onOk && obj.onOk(windows.root);
            windows.insert.$(".weui_dialog_alert").remove();
            if(typeof obj.url !='undefined'){
                windows.root.location.href = obj.url;
            }
        })
    },
    _alertDownload : function(obj, windows){
        if(windows.insert.$(".weui_dialog_alertDownload").length >= 1){
            windows.insert.$(".weui_dialog_alertDownload").remove();
        }
        $(windows.insert.document.body).append('<div class="weui_dialog_alertDownload">\
                                    <div class="weui_dialog_alertDownload">\
                                        <div class="weui_mask"></div>\
                                        <div class="weui_dialog">\
                                            <div class="weui_dialog_hd">\
                                            <strong class="weui_dialog_title">'+obj.title+'</strong>\
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>\
                                        </div>\
                                        <div class="weui_dialog_bd">'+obj.content+'</div>\
                                        <div class="weui_dialog_ft">\
                                            <a href="javascript:;" class="weui_btn_dialog primary">立即下载</a>\
                                        </div>\
                                    </div>\
                                </div>');
        windows.insert.$(".weui_dialog_alertDownload").show();
        windows.insert.$(".weui_dialog_alertDownload .weui_btn_dialog").unbind().click(function(){
            obj.onOk && obj.onOk(windows.root);
            windows.insert.$(".weui_dialog_alertDownload").remove();
            if(typeof obj.url !='undefined'){
                windows.root.location.href = obj.url;
            }
        })
        windows.insert.$(".weui_dialog_alertDownload .glyphicon-remove").unbind().click(function(){
            windows.insert.$(".weui_dialog_alertDownload").remove();
            if(typeof obj.url !='undefined'){
                windows.root.location.href = obj.url;
            }
        })
    },
    _confirm : function(obj, windows){
        if(windows.insert.$(".weui_dialog_confirm").length >= 1){
            windows.insert.$(".weui_dialog_confirm").remove();
        }
        $(windows.insert.document.body).append('<div class="weui_dialog_confirm">\
                                    <div class="weui_mask"></div>\
                                    <div class="weui_dialog">\
                                    <div class="weui_dialog_hd">\
                                    <strong class="weui_dialog_title">'+obj.title+'</strong>\
                                    </div>\
                                    <div class="weui_dialog_bd">'+obj.content+'</div>\
                                        <div class="weui_dialog_ft">\
                                            <a href="javascript:;" class="weui_btn_dialog default">取消</a>\
                                            <a href="javascript:;" class="weui_btn_dialog primary">确定</a>\
                                         </div>\
                                    </div>\
                                </div>');
        windows.insert.$(".weui_dialog_confirm").show();
        windows.insert.$(".weui_dialog_confirm .weui_btn_dialog").unbind().click(function(){
            if($(this).hasClass('primary')){
                //确定
                if(typeof obj.url !='undefined'){
                    windows.root.location.href = obj.url;
                }
                obj && obj.submitCallback && obj.submitCallback(windows.root);
            }
            windows.insert.$(".weui_dialog_confirm").remove();
        })
    },
    _toash : function(obj, windows){
        if($("#weui_toast").length >= 1){
            $("#weui_toast").remove();
        }
        $(windows.insert.document.body).append('<div id="weui_toast" style="display: none;">\
                                    <div class="weui_mask_transparent"></div>\
                                        <div class="weui_toast">\
                                        <i class="weui_icon_toast"></i>\
                                        <p class="weui_toast_content">'+obj.content+'</p>\
                                    </div>\
                                 </div>');
        windows.insert.$("#weui_toast").show();
        windows.insert.setTimeout(function () {
            windows.insert.$('#weui_toast').hide();
            obj.callback && obj.callback(windows.root);
        }, 1000);
    },

    _getWindows: function() {
        var css = $(document).find('link');
        var WEUICssPath = "http://static.zhan.qq.com/weui/weui.min.css";
        for (var i = 0; i < css.length; i++) {
            var path = $(css[i]).attr('href');
            if (path.indexOf('weui.min.css') > -1) {
                WEUICssPath = path;
                break;
            }
        }

        // 获取根窗口
        var insertWindow = window;
        var needCss = false;
        if (top !== window) {
            needCss = true;
        }

        try {
            if (window.top.location.host == window.location.host) { // 不跨域
                insertWindow = window.top;
        if (needCss) {
                    /** 检测根窗口是否需要css */
                    css = $(window.top.document).find('link');
                    for (i = 0; i < css.length; i++) {
                        var path = $(css[i]).attr('href');
                        if (path.indexOf('weui.min.css') > -1) {
                            needCss = false;
                            break;
        }
                    }

                    if (needCss) {
                        $(window.top.document.head).append('<link rel="stylesheet" href="' + WEUICssPath + '">');
                    }
                }
            }else{
                return {root: window, insert: window};
            }
        }catch(e){
            return {root: window, insert: window};
        }

        return {root: window.top, insert: insertWindow};
    },

    alert: function(data){
        this._alert(data, this._getWindows());
    },

    confirm: function(obj){
        this._confirm(obj, this._getWindows());
    },

    toash: function(obj){
        this._toash(obj, this._getWindows());
    },

    alertDownload : function(obj){
        this._alertDownload(obj, this._getWindows());
    }
};