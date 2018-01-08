<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/9
 * Time: 10:59
 */

namespace app\index\controller;
use think\Controller;
use think\Session;


class Admin extends Controller
{
    protected  function _initialize(){
        parent::_initialize();
        if(!Session::has('admin_id')){
            $this->redirect('web/login/index');
        }else{
            $this->redirect('web/admin/index');
        }

    }
}