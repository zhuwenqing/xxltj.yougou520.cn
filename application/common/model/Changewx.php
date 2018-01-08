<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Changewx extends Model
{
    public function change_wehcat_list($page, $where = []){
        // $result = Db::name('change_wechat')->where('status',1)->order('sort desc')->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        $result = Db::name('change_wechat')->where($where)->where('status',1)->order('sort desc')->paginate(30,false,['page'=>$page]);
        // $result['change_name'] = implode(',',unserialize($result['change_name']));
        return $result;
    }

    public function change_wechat_find_one($id){
        $result = Db::name('change_wechat')->where('id',$id)->find();
        $result['change_name'] = implode("\n",unserialize($result['change_name']));
        if($result['wid'] == 2){
            $result['qrcode_path'] = unserialize($result['qrcode_path']);
        }
        return $result;
    }
}