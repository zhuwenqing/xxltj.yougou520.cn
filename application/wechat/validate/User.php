<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 15:55
 */

namespace app\wechat\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'nickname' => 'max:24|unique:user',
        'nickname' => ['regex'=>'/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
        'mobile' => 'unique:user',
        'mobile' => ['regex' => '/^13[0-9]{1}\d{8}$|15[012356789]{1}\d{8}$|18[2789]{1}\d{8}$|147\d{8}$/'],
        'email' => 'unique:user|email',
        'qq' => 'unique:user|number|length:5,12',
        'wechat' => 'unique:user|regex:^[a-zA-Z]{1}[\w-]{5,19}$',
        'birthday' => ['regex'=>'/^[1-2]{1}[0-9]{3}-(0?[1-9]|1[0-2])-(0?[1-9]|1[0-9]|2[0-9]|3[0-1])$/'],
    ];

    protected $message = [
        'nickname.max' => '昵称不能超过24个字符',
        'nickname.unique' => '昵称已存在',
        'nickname.regex' => '昵称只支持中文、数字、字母、下划线',
        'mobile.unique' => '手机号码已存在',
        'mobile.regex' => '请输入正确的手机号码',
        'email.unique' => '邮箱已存在',
        'email.email' => '请输入正确的邮箱',
        'qq.unique' => 'qq已存在',
        'qq.number' => '请输入正确qq号码',
        'qq.length' => '请输入正确qq号码',
        'wechat.unique' => '微信号已存在',
        'wechat.regex' => '请输入正确的微信号',
        'birthday' => '出生日期格式不正确'

    ];
}