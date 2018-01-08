<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 9:56
 */

namespace app\wechat\validate;

use think\Validate;


class Account extends Validate
{
    protected $rule = [
        'wechat_name' => 'require|unique:account|regex:^[a-zA-Z]{1}[\w-]{5,19}$',
        'username' => 'require',
//        'mobile' => 'require',
        'mobile' => ['require','regex' => '/^13[0-9]{1}\d{8}$|15[012356789]{1}\d{8}$|18[2789]{1}\d{8}$|147\d{8}$/'],
        'b_type' => 'require',
        'email' => 'email',
    ];

    protected $message = [
        'wechat_name.require' => '微信号必须填写',
        'wechat_name.unique' => '微信号已存在',
        'wechat_name.regex' => '请输入正确的微信号',
        'username.require' => '微信名必须填写',
        'mobile.require' => '手机号必须填写',
        'mobile.regex' => '请输入正确的手机号码',
        'b_type.require' => '请选择类型',
        'email.email' => '请输入有效的邮箱地址',
    ];
}