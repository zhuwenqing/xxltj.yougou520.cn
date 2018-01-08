<?php
namespace app\common\model;

use think\Model;
use think\Db;
class User extends Model
{
    protected $insert = ['create_time'];

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return date('Y-m-d H:i:s');
    }
    /**
     * 验证账号密码
     * @$data array
     */
    function checkUser($data){
        $username = $data['username'];
        $password = md5('bxt'.$data['password']);
        $map['username'] = ['eq',$username];
        $map['password'] = ['eq',$password];
        $result = Db::name('user')->field('id,username,status')->where($map)->find();
        return $result;
    }

    /**
     * 查看用户中心个人信息
     * @$map array
     */
    function findUser($map){
        //$map['id'] = ['eq',$user_id];
        $result = Db::name('user')->where($map)->find();
        return $result;
    }
}