<?php
namespace app\common\model;


use think\Model;
use think\Db;


class Dmproject extends Model
{
    protected $insert = ['create_time'];

    /**
     * 自动生成时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return date('Y-m-d H:i:s');
    }

    public function insertProject($data){
        $result = Db::name('dmproject')->insert($data);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}