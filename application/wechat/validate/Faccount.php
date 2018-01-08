<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 10:50
 */

namespace app\wechat\validate;

use think\Validate;

class Faccount extends Validate
{
    protected $rule = [
        'fid' => 'require',
        'wechat_name' => 'require|unique:account|regex:^[a-zA-Z]{1}[\w-]{5,19}$',
        'username' => 'require',
        'mobile' => ['regex' => '/^13[0-9]{1}\d{8}$|15[012356789]{1}\d{8}$|18[2789]{1}\d{8}$|147\d{8}$/'],
        'c_type' => 'require',
        'email' => 'email',
    ];

    protected $message = [
        'fid.require' => '请选择客服微信号',
        'wechat_name.require' => '微信号必须填写',
        'wechat_name.unique' => '微信号已存在',
        'wechat_name.regex' => '请输入正确的微信号',
        'username.require' => '微信名必须填写',
        'mobile.regex' => '请输入正确的手机号码',
        'c_type.require' => '请选择客户类型',
        'email.email' => '请输入有效的邮箱地址',
    ];
}