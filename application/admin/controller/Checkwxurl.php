<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;

class Checkwxurl extends AdminBase
{
    protected $key = '8752bc8ecc89b376364538361e84c96e';

    public function index(){
        return $this->fetch();
    }

    public function check($domain){
        $domain_arr = explode("\n",$domain);
        $res = [];
        foreach($domain_arr as $h){    
            $http = urlencode($h);
            $url = "http://check.api-export.com/api/checkdomain?key=".$this->key."&url=".$http;
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_HEADER,0);
            $str = curl_exec($ch);
            curl_close($ch);
            $info = json_decode($str,true);
            $info['url'] = $h;

            //接口是否可用
            if($info['status'] != 'ok'){
                echo '<script>alert("接口已过期")</script>';
                return false;
            }
            $res[] = $info;
            sleep(2);
        }
        return json($res);
    }
}