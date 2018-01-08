<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Advdata extends Model
{
    protected $insert = ['create_time'];

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return time();
    }
}