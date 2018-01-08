<?php

namespace app\admin\validate;

use think\Validate;

class Wechatnumedit extends Validate
{
    protected $rule = [
        'wechat_name'  => 'require',
        'set_copy' => 'require',
        'email' => 'require',
    ];

    protected $message = [
        'wechat_name.require'  => '请输入微信号(至少一个) 多个微信号每行一个(Enter键换行)',
        'set_copy.require' => '请输入复制次数',
        'email.require' => '请输入邮箱',
    ];
}