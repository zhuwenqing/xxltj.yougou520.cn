<?php

namespace app\admin\validate;

use think\Validate;

class Changewx extends Validate
{
    protected $rule = [
        // 'change_url' => 'require|unique:change_wechat',
        // 'change_name'  => 'require|unique:change_wechat',
        'change_url' => 'require',
        'change_name'  => 'require',
    ];

    protected $message = [
        'change_url.require' => '请输入域名',
        // 'change_url.unique' => '域名已存在',
        'change_name.require'  => '请输入微信号(至少一个) 多个微信号每行一个(Enter键换行)',
        // 'change_name.unique' => "这个微信号已存在",
    ];
}