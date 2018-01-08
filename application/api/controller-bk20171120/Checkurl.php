<?php

namespace app\api\controller;


use think\Controller;
use think\Db;

class Checkurl extends Controller
{
    function checkdomain($pjid){
        // $pro = Db::name('dmproject')->field('id')->where('project_id',$pjid)->find();
        // $first_domain = Db::name('pjdomain')->field('domain')->where('pid',$pjid)->where('type',1)->find();
        // $ckurl = $_SERVER['HTTP_REFERER'];//域名
        // if(strstr($ckurl,$first_domain['domain'])){
            //检测项目下所有域名
            $jump_domain = Db::name('pjdomain')->where('pid',$pjid)->where('type',2)->select();
            $key = '8752bc8ecc89b376364538361e84c96e';
            $count = count($jump_domain);
            foreach($jump_domain as $h){
                $http = urlencode($h['jump_url']);
                $url = "http://check.api-export.com/api/checkdomain?key=".$key."&url=".$http;
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_HEADER,0);
                $str = curl_exec($ch);
                curl_close($ch);
                $info = json_decode($str,true);
                if($info['status'] === 'ok'){
                    $arr = [
                        'domain'=>$h['domain'],
                        'jump_url'=>$h['jump_url'],
                        'postfix'=>$h['postfix'],
                        'type'=>$h['type']
                    ];
                    // dump(json_encode($arr));exit();
                    return json_encode($arr);
                }
            }
        // }else{
        //     $arr = [
        //         'error'=>'该域名没有权限',
        //     ];
        //     return json_encode($UriName);
        // }
        
    }
}