<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Pjdomain extends Model
{
    public function findPjname($id){
        $result = Db::name('dmproject')->where('id',$id)->find();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    public function saveDomain($data){
        $result = Db::name('pjdomain')->insert($data);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}