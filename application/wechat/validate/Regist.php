<?php

namespace app\wechat\validate;

use think\Validate;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 20:45
 */
class Regist extends Validate
{
    protected $rule = [
        'username' => 'require|unique:user|length:6,14',
        'password' => 'require|length:6,14|confirm:repassword',
        'repassword' => 'require|confirm:password',
        'email' => 'email|unique:user',
        'qq' => 'number|min:5',

    ];

    protected $message = [
        'username.require' => '用户名必须填写',
        'username.unique'  => '用户名已被注册',
        'username.length'     => '长度为6-14个字符',
        'password.require' => '密码必须填写',
        'password.length'     => '长度为6-14个字符',
        'password.confirm' => '两次密码必须一致',
        'repassword.require' => '确认密码必须填写',
        'repassword.confirm' => '两次密码必须一致',
        'email.unique' => '邮箱已被使用',
        'email.email' => '请输入有效的邮箱地址',
        'qq.number' => 'qq号码只允许为数字',
        'qq.min' => 'qq号码至少5位'


    ];
}