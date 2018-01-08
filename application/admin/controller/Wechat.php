<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/4/17
 * Time: 11:31
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;


class Wechat extends  AdminBase
{
    /*
     * 集成微信编辑器
     * */
    public function index(){
        return $this->fetch();
    }
}