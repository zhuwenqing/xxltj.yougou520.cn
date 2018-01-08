<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 18:58
 */

namespace app\wechat\controller;

use think\Session;
use think\Db;
use app\common\model\User as UserModel;
use app\common\controller\HomeBase;

class Login extends HomeBase
{
    protected $user_model;

    protected function _initialize(){
        parent::_initialize();
        $this->user_model = new UserModel();
    }

    function index(){
        return view('index');
    }



    function check(){
        if($this->request->isPost()){
            $data = $this->request->param();
            $result = $this->user_model->checkUser($data);
            if($result['status'] == 1){
                session::set('user_id',$result['id']);
                session::set('user_name',$result['username']);
                Db::name('user')->update(
                    [
                        'last_login_time' => date('Y-m-d H:i:s', time()),
                        'last_login_ip'   => $this->request->ip(),
                        'id'              => $result['id']
                    ]
                );
                $this->success('登录成功','wechat/index/index');
            }else{
                $this->error('用户名或密码错误','wechat/login/index');
            }
        }else{
            $this->error('用户名或密码错误','wechat/login/index');
        }
    }



    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        $this->redirect('wechat/index/index');
//        $this->success('退出成功', 'index/index/index');
    }
}