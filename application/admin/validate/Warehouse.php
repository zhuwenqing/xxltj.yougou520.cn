<?php
namespace app\admin\validate;

use think\Validate;

class Warehouse extends Validate
{
    protected $rule = [
        'pid'   => 'require',
        'buy'  => 'require|number',
    ];

    protected $message = [
        'pid.require'   => '请选择所属栏目',
        'buy.require'  => '请输入进货量',
        'buy.number'   => '进货量只能填写数字',
        'send.number'   => '发货量只能填写数字'
    ];
}