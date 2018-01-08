<?php

namespace app\api\controller;

use think\Controller;
use email\Smtp;

class Countref extends Controller
{

    public function index(){
            $str = $_SERVER['HTTP_REFERER'];//域名
            $param = '/(http[s|]:\/\/[\s\S]+?)\//';
            preg_match($param,$str,$matches);
            $UriName = $matches[1];
            $reIP=$_SERVER["REMOTE_ADDR"];//ip
            $url = IP_URL.$reIP;
            $data = http_url($url);
            $arr = explode('=',$data); 
            $abc = substr(trim($arr[1]),0,-1);
            $address = json_decode($abc,true);

            // var_dump(json_decode($abc,true));exit();
            // $data['data']['count_url'] = $UriName;
            // $data['data']['count_ip'] = $reIP;
            // $data['data']['visit_time'] = time();
            // unset($data['data']['ip']);

            $data = [
                'country'=>$address['country'],
                'province'=>$address['province'],
                'city'=>$address['city'],
                'count_url'=>$UriName,
                'count_ip'=>$reIP,
                'visit_time'=>time()
            ];
            // var_dump($data);exit();
            $result = model('count_detail')->allowField(true)->insertGetId($data);
            if(!$result){
                echo $result->getLastSql();
            }else{
                return json(['lase_Id'=>$result]);
            }
    }

    public function copyAction(){
        if($this->request->post()){
            $data = $this->request->post();
            $id = $data['id'];//当前访问过的id
            $wechat_name = $data['WeName'];
            $arr = [
                'is_copy'=>1,
                'copu_wechat'=>$wechat_name,
                'copy_time'=>time(),
            ];
            $keyword = isset($data['keyword']) ? urldecode($data['keyword']) : '';
            if(!empty($keyword)){
                $arr['origin_keyword'] = $keyword;
            }

            // $ref = $_SERVER['HTTP_REFERER'];
            // $header = getallheaders();
            // dump($header);

            // $data['origin_keyword'] = $ref;
            // $url_dec = urldecode($ref);
            // $pattern = "/&wd=([\s\S]+?)&/";
            // if(preg_match_all($pattern,$url_dec,$matches)){
                // $arr['origin_keyword'] = $matches[1];
            // }

            $result = model('count_detail')->where('id',$id)->update($arr);
            if($result){
                $this->copyWechatNumber($wechat_name);
            }
            return json([$result]);
        }
    }

    public function copyWechatNumber($wechat=''){
        //查询wechatnum表数据
        // $wechat = 'dss346';
        $find_wechat = model('wechatnum')->where('wechat_name',$wechat)->find();
            if($find_wechat && $find_wechat['is_expire'] !== 0){
                if($find_wechat['warn_num'] < 10){
                    $map['copu_wechat'] = ['eq',$wechat];
                    $map['visit_time'] = ['between',[$find_wechat['start_time'],$find_wechat['end_time']]];
                    $copy_wechat = model('count_detail')->where($map)->count();
                    // dump($testInfo['copy_num'].'sss'.$copy_wechat);exit();
                    if($find_wechat['set_copy'] < $copy_wechat){
                        $this->sendmail($wechat,$find_wechat);
                    }
                }elseif(time() > $find_wechat['end_time']){
                    model('wechatnum')->where('id',$find_wechat['id'])->update(['is_expire'=>0]);
                }
            }
    }
    
    
    public function sendmail($wechat,$find_wechat){
        $emails = explode(',',$find_wechat['email']);
        $smtpserver = "smtp.163.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "qq2161811@163.com";//SMTP服务器的用户邮箱
        foreach($emails as $ve){
            $smtpemailto = $ve;//发送给谁
            $smtpuser = "qq2161811";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
            $smtppass = "1234qwer";//SMTP服务器的用户密码
            $mailtitle = '微信号复制数超出通知';//邮件主题
            $mailcontent = "<h1>您户是 <span style='color:red;background-color:yellow;'>".$find_wechat['remark']."</span> 的微信号为 <span style='color:red;background-color:yellow;'>".$find_wechat['wechat_name']."</span> 已超过复制次数啦，赶快换掉吧</h1>";//邮件内容
            $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
            //************************ 配置信息 ****************************
            $smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp->debug = false;//是否显示发送的调试信息
            $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
            // dump($state);
        }
        
        $this->updateWechatNum($find_wechat);
    }

    //修改警告数据
    public function updateWechatNum($find_wechat){
        // dump($find_wechat);exit();
        $data = [];
        if($find_wechat['is_warn'] == 1){
            $data['is_warn'] = 0;
            $data['warn_num'] = 1;
        }else{
            $data['warn_num'] = $find_wechat['warn_num']+1;
        }

        if(time() > $find_wechat['end_time']){
            $data['is_expire'] = 0;
        }

        model('wechatnum')->where('id',$find_wechat['id'])->update($data);
    }


    public function testcopyAction(){
        if($this->request->post()){
            $data = $this->request->post();
            $id = $data['id'];//当前访问过的id
            $wechat_name = $data['WeName'];
            $arr = [
                'is_copy'=>1,
                'copu_wechat'=>$wechat_name,
                'copy_time'=>time(),
            ];
            $keyword = isset($data['keyword']) ? urldecode($data['keyword']) : '';
            if(!empty($keyword)){
                $arr['origin_keyword'] = $keyword;
            }


            $ref = isset($data['ref']) ? urldecode($data['ref']) : '';
            if(!empty($ref)){
                $arr['referer'] = $ref;
            }
            
            // $ref = $_SERVER['HTTP_REFERER'];
            // $header = getallheaders();
            // dump($header);

            // $data['origin_keyword'] = $ref;
            // $url_dec = urldecode($ref);
            // $pattern = "/&wo?r?d=([\s\S]+?)&/";
            // if(preg_match_all($pattern,$url_dec,$matches)){
                // $arr['origin_keyword'] = $matches[1];
            // }

            $result = model('count_detail')->where('id',$id)->update($arr);
            if($result){
                $this->copyWechatNumber($wechat_name);
            }
            return json([$result]);
        }
    }

    /*
    根据素材id的页面的点击获取对应的来源url
    */
    public function getRefer()
    {
        # code...
        if($this->request->post()){
            $data = $this->request->post();
            //  存储url到数据  fromurl
            $referurl = $data;
            //  写入数据  ref:http://review.e.qq.com/toutiao/jump/
            $ref = isset($data['ref']) ? urldecode($data['ref']) : '';
            if(!empty($ref)){
                $arr['referer'] = $ref;
            }
            $result = model('count_detail')->allowField(true)->where('id',$data['id'])->update($arr);
            return json([$result]);
        }
    }


}