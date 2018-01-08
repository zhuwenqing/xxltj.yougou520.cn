<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 18:58
 */

namespace app\wechat\controller;

use app\common\model\User as UserModel;
use app\common\controller\HomeBase;
use think\Loader;

class Regist extends HomeBase
{
    protected $user_model;

    protected function _initialize(){
        parent::_initialize();
        $this->user_model = new UserModel();
    }

    function index(){
        return view('index');
    }

    function regist(){
        if($this->request->isPost()){
            $data = $this->request->param();
//            var_dump($data);exit();
            $validate_result = Loader::validate('Regist');
//            var_dump($validate_result);exit();
            if(!$validate_result->check($data)){
//                $this->error($validate_result);
//                dump($validate_result->getError());exit();
                $this->error($validate_result->getError());
            }else{
                $data['password'] = md5('bxt'.$data['password']);
                if($this->user_model->allowField(true)->save($data)){
                    $this->success('注册成功','wechat/login/index');
                }else{
                    $this->error('注册失败');
                }
            }

        }
    }
}