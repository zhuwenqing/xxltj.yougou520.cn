<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/28
 * Time: 16:05
 */

namespace app\common\controller;

use org\Auth;
use think\Loader;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;

class WebAdminBase extends Controller{


    protected  function _initialize(){
        parent::_initialize();

        $this->checkAuth();

    }

    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth()
    {

        if (!Session::has('user_id')) {
            $this->redirect('wechat/login/index');
        }

    }




}