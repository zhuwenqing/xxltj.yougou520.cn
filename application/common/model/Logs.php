<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Logs extends Model
{
    public function showAll($page,$type,$keyword,$start_time,$end_time){
        $map = [];
        if($type != ''){
            $map['type'] = ['eq',$type];
        }
        if($keyword != ''){
            $map['detail'] = ['like',"%".$keyword."%"];
        }
        if($start_time != '' && $end_time != ''){
            $map['time'] = ['between',[$start_time,$end_time]];
        }
        $data = Db::name('logs')->where($map)->paginate(15,false,['page'=>$page,'query'=>['type'=>$type,'keyword'=>$keyword,'start_time'=>$start_time,'end_time'=>$end_time]]);
        return $data;
    }
}