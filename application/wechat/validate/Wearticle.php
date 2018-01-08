<?php

namespace app\wechat\validate;

use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 14:51
 */
class Wearticle extends Validate
{
    protected $rule = [
        'content' => 'require'
    ];

    protected $message = [
        'content.require' => '内容不能为空'
    ];
}