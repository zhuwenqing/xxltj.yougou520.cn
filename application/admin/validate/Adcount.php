<?php
namespace app\admin\validate;

use think\Validate;

class Adcount extends Validate
{
    protected $rule = [
        'count_url'         => 'require|unique:adcount',
    ];

    protected $message = [
        'count_url.require'         => '请输入域名',
        'count_url.unique'          => '域名已存在',
    ];
}