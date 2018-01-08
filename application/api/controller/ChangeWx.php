<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
use app\common\model\ChangeWechat as ChangeWechatModel;

class ChangeWx extends Controller
{
    protected $changewechat_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->changewechat_model = new ChangeWechatModel();
    }

    public function GetOnlyWx(){
        $str = $_SERVER['HTTP_REFERER'];//域名
        $param = '/(http[s|]:\/\/[\s\S]+?)\//';
        preg_match($param,$str,$matches);
        $UriName = $matches[1];
        // $UriName = 'https://owzh.fangwanlian.cn';
        $fruit = Db::name('change_wechat')->where('change_url',$UriName)->find();
        if($fruit['wid'] == 1){
            $wname = unserialize($fruit['change_name']);
            $wqrcode = 'https://'.$_SERVER['SERVER_NAME'].$fruit['qrcode_path'];
            $json_wname = json(['arr_wx'=>$wname,'qrcode'=>$wqrcode]);
        }elseif($fruit['wid'] == 2){
            $wname = unserialize($fruit['change_name']);
            $wqrcode = unserialize($fruit['qrcode_path']);
            if(count($wname) == count($wqrcode)){
                $count = count($wname);
                $rand = rand(0,$count-1);
                $w_name = [$wname[$rand]];
                $w_qrcode = 'https://'.$_SERVER['SERVER_NAME'].$wqrcode[$rand];
                $json_wname = json(['arr_wx'=>$w_name,'qrcode'=>$w_qrcode]);
            }else{
                $json_wname = json(['msg'=>'错误','status'=>'2']);
            }
        }



        
        // dump($only_wname);exit();
        return $json_wname;
    }

    public function get_wechat_num_qrcode(){
        // if($this->request->isPost()){
            $data = $this->request->post();
            $code = $data['code'];
            if(!$code){
                return false;
            }else{
                $fruit = $this->changewechat_model->where('code',$code)->find();
                if($fruit['wid'] == 1){
                    $wname = unserialize($fruit['change_name']);
                    $wqrcode = 'https://'.$_SERVER['SERVER_NAME'].$fruit['qrcode_path'];
                    $json_wname = json(['arr_wx'=>$wname,'qrcode'=>$wqrcode]);
                }elseif($fruit['wid'] == 2){
                    $wname = unserialize($fruit['change_name']);
                    $wqrcode = unserialize($fruit['qrcode_path']);
                    // if(count($wname) == count($wqrcode)){
                        $count = count($wname);
                        $rand = rand(0,$count-1);
                        $w_name = [trim($wname[$rand])];
                        foreach($wqrcode as $qrcode){
                            if(strpos($qrcode,trim($w_name[0]))){
                                $w_qrcode = 'https://'.$_SERVER['SERVER_NAME'].$qrcode;
                            }
                        }

                        $json_wname = json(['arr_wx'=>$w_name,'qrcode'=>$w_qrcode]);
                    // }else{
                        // $json_wname = json(['msg'=>'错误','status'=>'2']);
                    // }
                }
                return $json_wname;
            }
        // }
    }

    public function get_wechat_num_qrcode2(){
        // if($this->request->isPost()){
            $data = $this->request->param();
            $code = $data['code'];
            if(!$code){
                return false;
            }else{
                $fruit = $this->changewechat_model->where('code',$code)->find();
                if($fruit['wid'] == 1){
                    $wname = unserialize($fruit['change_name']);
                    $wqrcode = 'https://'.$_SERVER['SERVER_NAME'].$fruit['qrcode_path'];
                    $wname = json_encode($wname);
                    $js_qrcode = $fruit['qrcode_path'] == '' ? '' : '$(document).ready(function(){$(".weixinpic").attr("src","'.$wqrcode.'");})';
                    $js = "arr_wx = {$wname};var wx_index = Math.floor((Math.random() * arr_wx.length));var stxlwx = arr_wx[wx_index];".$js_qrcode;
                    return $js;
                    // $json_wname = json(['arr_wx'=>$wname,'qrcode'=>$wqrcode]);
                }elseif($fruit['wid'] == 2){
                    $wname = unserialize($fruit['change_name']);
                    $wqrcode = unserialize($fruit['qrcode_path']);
                    // if(count($wname) == count($wqrcode)){
                        $count = count($wname);
                        $rand = rand(0,$count-1);
                        $w_name = [trim($wname[$rand])];
                        foreach($wqrcode as $qrcode){
                            if(strpos($qrcode,trim($w_name[0]))){
                                $w_qrcode = 'https://'.$_SERVER['SERVER_NAME'].$qrcode;
                            }
                        }
                        $w_name = json_encode($w_name);
                        $js_qrcode = '$(document).ready(function(){$(".weixinpic").attr("src","'.$w_qrcode.'");});';
                        $js = "arr_wx = {$w_name};var wx_index = Math.floor((Math.random() * arr_wx.length));var stxlwx = arr_wx[wx_index];{$js_qrcode}";
                        return $js;
                        // $json_wname = json(['arr_wx'=>$w_name,'qrcode'=>$w_qrcode]);
                    // }else{
                        // $json_wname = json(['msg'=>'错误','status'=>'2']);
                    // }
                }
                // dump(json_encode($wname));exit();
                
                // return $json_wname;
            }
        // }
    }
}