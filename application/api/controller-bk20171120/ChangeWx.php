<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class ChangeWx extends Controller
{
    public function GetOnlyWx(){
        $str = $_SERVER['HTTP_REFERER'];//域名
        $param = '/(http[s|]:\/\/[\s\S]+?)\//';
        preg_match($param,$str,$matches);
        $UriName = $matches[1];
        // $UriName = 'https://owzh.fangwanlian.cn';
        $fruit = Db::name('change_wechat')->where('change_url',$UriName)->find();
        $wname = unserialize($fruit['change_name']);
        // $wcount = count($wname);
        // $rand = rand(0,$wcount-1);

        // $only_wname = $wname[$rand];

        $json_wname = json(['arr_wx'=>$wname]);


        
        // dump($only_wname);exit();
        return $json_wname;
    }
}