<?php
namespace app\admin\validate;

use think\Validate;

class WarehouseRule extends Validate
{
    protected $rule = [
        'pid'  => 'require',
        'name' => 'require',
    ];

    protected $message = [
        'pid.require'  => '请选择上级栏目',
        'name.require' => '请输入栏目名称',
    ];
}