<?php

namespace app\admin\validate;

use think\Validate;


class Weditor extends Validate
{
	protected $rule = [
	    'pid' => 'require'
    ];

	protected $message = [
	    'pid.require'=> '请选择分类'
    ];
}