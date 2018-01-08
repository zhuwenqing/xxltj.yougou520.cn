<?php


/*
 * 视频model
 * */

namespace app\common\model;

use think\Model;
use think\Db;

class Video extends Model
{
    protected $insert = ['create_time'];


    public function showAllVideo(){
        return Db::name('video')->select();
    }
}
