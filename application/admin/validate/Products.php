<?php
namespace app\admin\validate;

use think\Validate;

class Products extends Validate
{
    protected $rule = [
        'cid'   => 'require',
        'name' => 'require|unique:products',
        'sort'  => 'require|number'
    ];

    protected $message = [
        'cid.require'   => '请选择所属栏目',
        'name.unique'   => '产品名称已存在',
        'name.require'  => '请输入标题',
        'sort.require'  => '请输入排序',
        'sort.number'   => '排序只能填写数字'
    ];
}