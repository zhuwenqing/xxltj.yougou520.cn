<?php
namespace app\api\controller;

use think\Controller;
use Aliyun\DySDKLite\Sms\SmsApi;

class Sms extends Controller
{
    public function sendmsg(){
        $Access_Key_ID = "LTAIKqa4XUOwajiT";
        $Access_Key_Secret = "7ycL9N1EJ5MdcF9FdT0jzepj5rgZ3d";
        $sms = new SmsApi($Access_Key_ID,$Access_Key_Secret); // 请参阅 https://ak-console.aliyun.com/ 获取AK信息
        $response = $sms->sendSms(
            "广州尚凝文化发展有限公司", // 短信签名
            "SMS_113445232", // 短信模板编号
            "15915928882", // 短信接收者
            Array (  // 短信模板中字段的值
                "str"=>"123",
            )
            // "123"   // 流水号,选填
        );
        echo "发送短信(sendSms)接口返回的结果:\n";
        print_r($response);
    } 
}
