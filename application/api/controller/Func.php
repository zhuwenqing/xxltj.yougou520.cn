<?php
namespace app\api\Controller;

use think\Controller;
use think\Db;
// use app\home\logic\UsersLogic;

class Func extends Controller
{
    public function _initialize(){
        parent::_initialize();
    }

    /**
    *获取用户openid
    */
    public function get_openid(){
        $data = $this->request->post();
        $wechatMsg = Db::name('plugin')->field('config_value')->where('code','weixinsmall')->find();
        $wechatMsg = unserialize($wechatMsg['config_value']);
        $code = $data['code'];
        $appid = $wechatMsg['appid'];
        $appsecret = trim($wechatMsg['appsecret']);
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($ch);
        curl_close($ch);
        // var_dump($output);exit();
        $result_arr = json_decode($output,true);
        return json($result_arr);
    }

    public function mp_login(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $openid = $data['openid'];
            $user = $this->get_user_info($openid);
            if(!$user){
                //账户不存在 注册一个
                $map['openid'] = $openid;
                $map['oauth'] = $data['oauth'];
                $map['avatarUrl'] = $data['avatarUrl'];
                $map['city'] = $data['city'];
                $map['province'] = $data['province'];
                $map['country'] = $data['country'];
                $map['gender'] = $data['gender'];
                $map['language'] = $data['language'];
                $map['nickName'] = $data['nickName'];
                $map['reg_time'] = date('Y-m-d H:i:s');
                $row_id = Db::name('weusers')->insertGetId($map);
                $user = Db::name('weusers')->where("user_id", $row_id)->find();
            }else{
                Db::name('weusers')->where("user_id", $user['user_id'])->update(array('last_login'=>date('Y-m-d H:i:s')));
            }
            return json(array('status'=>1,'msg'=>'登陆成功','result'=>$user));
        }else{
            return json(['err_msg'=>'错误']);
        }
    }

    /**
    *储存用户信息
    */
    // public function change_user(){
    //     $mini = $this->request->post();
    //     $openid = $mini['openid'];
    //     $info = M('users')->where('openid',$openid)->find();
    //     if(!$info){
    //         $logic = new UsersLogic();
    //         $data = $logic->thirdLogin($mini);
    //         return json($data);
    //     }else{
    //         return json(array('status'=>1,'msg'=>'登陆成功','result'=>$info));
    //     }

    // }


    public function get_user_info($openid = ''){
        $map = [];
        if(!empty($openid)){
            $map['openid'] = ['eq',$openid];
        }
        $user = Db::name('weusers')->where($map)->find();
        return json($user);
    }

    public function save_user_info(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $user_id = $data['user_id'];
            $validate_result = $this->validate($data,'Func');
            if($validate_result !== true){
                return json(['msg'=>$validate_result]);
            }
            $result = Db::name('weusers')->where('user_id',$user_id)->update($data);
            if($result){
                return json(['status'=>'200','msg'=>'保存成功']);
            }else{
                return json(['status'=>'400','msg'=>'保存失败']);
            }
            // return json($data);
        }else{
            return json(['msg'=>'错误']);
        }
    }
}