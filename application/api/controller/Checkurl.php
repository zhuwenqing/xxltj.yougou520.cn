<?php

namespace app\api\controller;


use think\Controller;
use think\Db;
use Aliyun\DySDKLite\Sms\SmsApi;
use email\Smtp;

class Checkurl extends Controller
{
    protected $key = '8752bc8ecc89b376364538361e84c96e';
    function checkdomain($pjid){
            //检测项目下所有域名
            $jump_domain = Db::name('pjdomain')->where('pid',$pjid)->where('type',2)->where('status',1)->select();
            $count = count($jump_domain);
            foreach($jump_domain as $h){
                $http = urlencode($h['jump_url']);
                $url = "http://check.api-export.com/api/checkdomain?key=".$this->key."&url=".$http;
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_HEADER,0);
                $str = curl_exec($ch);
                curl_close($ch);
                $info = json_decode($str,true);

                //接口是否可用
                if($info['status'] != 'ok'){
                    return false;
                }

                if($info['code'] === 0){
                    $arr = [
                        'domain'=>$h['domain'],
                        'jump_url'=>$h['jump_url'],
                        'postfix'=>$h['postfix'],
                        'type'=>$h['type']
                    ];
                    // dump(json_encode($arr));exit();
                    return json_encode($arr);
                }else if($info['code'] === 2){
                    model('pjdomain')->where('id',$h['id'])->update(['status'=>0]);
                }
            }
        // }else{
        //     $arr = [
        //         'error'=>'该域名没有权限',
        //     ];
        //     return json_encode($UriName);
        // }
        
    }



    function autoCheckUrl(){
        $project = Db::name('dmproject')->field('id,email,name,photo')->select();
        foreach($project as $p){
            $domain = Db::name('pjdomain')->where('status',1)->where('pid',$p['id'])->select();
            // return $domain;
            $end_url = [];
            // dump($domain);exit();
            foreach($domain as $h){

                $http = urlencode($h['jump_url']);
                $url = "http://check.api-export.com/api/checkdomain?key=".$this->key."&url=".$http;
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_HEADER,0);
                $str = curl_exec($ch);
                curl_close($ch);
                $info = json_decode($str,true);

                //接口是否可用
                if($info['status'] != 'ok'){
                    echo '<script>alert("接口已过期")</script>';
                    return false;
                }

                if($info['code'] === 2){
                    Db::name('pjdomain')->where('id',$h['id'])->update(['status'=>0]);
                    $end_url[] = $h['jump_url'];
                }

                sleep(2);
            }
        
            if($end_url !== []){
                $this->sendmail($end_url,$p);
                $this->sendmsg($p['name'],$p);

            }
        }
        echo "<script>alert('域名已检测完成,被封域名会以邮箱方式通知您!请注意查收')</script>";
        
    }

    public function sendmail($domain,$find_email){
        $emails = explode(',',$find_email['email']);
        $url_str = implode("<br />",$domain);
        $smtpserver = "smtp.163.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "qq2161811@163.com";//SMTP服务器的用户邮箱


        // $smtpemailto = $email;
        $smtpuser = "qq2161811";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "1234qwer";//SMTP服务器的用户密码
        $mailtitle = '微信域名被封通知';//邮件主题
        $mailcontent = "<h1>警告：<br /><span style='color:red;background-color:yellow;'>".$url_str."</span><br />的域名已被微信封掉</h1>";//邮件内容
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        $smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        foreach($emails as $email){
            $smtpemailto = $email;
            $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
        }
    }

    public function sendmsg($domain,$send_photo){
        $photos = explode(',',$send_photo['photo']);
        // $url_str = implode(",",$domain);
        // $Pattern = "/(http|https):\/\/([\s\S]+?)(.com.cn|.cn|.com|.org|.ltd)/";
        // preg_match_all($Pattern,$url_str,$Matches);
        // $str = implode(',',$Matches[2]);
        $Access_Key_ID = "LTAIKqa4XUOwajiT";
        $Access_Key_Secret = "7ycL9N1EJ5MdcF9FdT0jzepj5rgZ3d";
        $sms = new SmsApi($Access_Key_ID,$Access_Key_Secret); // 请参阅 https://ak-console.aliyun.com/ 获取AK信息
        foreach($photos as $photo){
            $response = $sms->sendSms(
                "广州尚凝文化发展有限公司", // 短信签名
                "SMS_113445232", // 短信模板编号
                $photo, // 短信接收者
                Array (  // 短信模板中字段的值
                    "str"=>$domain,
                )
                // "123"   // 流水号,选填
            );
        }

        // echo "发送短信(sendSms)接口返回的结果:\n";
        // print_r($response);
    } 
}