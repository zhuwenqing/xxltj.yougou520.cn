<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/15
 * Time: 16:23
 */

namespace app\wechat\controller;


use app\common\controller\WebAdminBase;
use think\Db;
use think\Session;
use think\Loader;
use app\common\model\User as UserModel;


class User extends WebAdminBase
{

    protected $user_model;
    protected $user_id;

    protected function _initialize(){
        parent::_initialize();
        if(is_mobile()){
//            $this->success('手机访问','Index/index');
            $this->redirect('Phone/index/index');
        }
        $this->user_id = Session::get('user_id');
        $this->user_model = new UserModel();
    }

    function index(){
        $user_id = $this->user_id;
//        dump($user_id);exit();
        $map['id'] = ['eq',$user_id];
        $UserMessage = $this->user_model->findUser($map);
//        dump($UserMessage);
        if($UserMessage['sex'] == 1){
            $UserMessage['sex'] = '保密';
        }elseif($UserMessage['sex'] == 2){
            $UserMessage['sex'] = '男';
        }elseif($UserMessage['sex'] == 3){
            $UserMessage['sex'] = '女';
        }else{
            $UserMessage['sex'] = '保密';
        }
        $this->assign('um',$UserMessage);
        return $this->fetch();
    }

    function update(){
//        获取Session的用户id值
        $user_id = $this->user_id;
        $map['id'] = ['eq',$user_id];
//        初始化用户个人资料
        $befort = ['nickname'=> "" , 'mobile' => "" , 'email' => "" , 'sex' => "" , 'qq' => "" , 'wechat' => "" , 'birthday' => "" , 'header_path' => ""];
        $this->user_model->allowField(true)->save($befort,$map);
        //        判断是否post是否有值
        if($this->request->isPost()){
            $data = $this->request->param();
            $validate_result = Loader::validate('User');
            if(!$validate_result->check($data)){
                $this->error($validate_result->getError());
            }else{
                if(array_key_exists('birthday',$data)){
                    $data['birthday'] = strtotime($data['birthday']);
                    if($data['birthday'] > time() || $data['birthday'] == ""){
                        $this->error('你穿越了吗？');
                    }
                }
                $userInfo = $this->user_model->allowField(true)->save($data,$map);
                if(!$userInfo){
                    $this->error('修改失败','wechat/user/index');
                }else{
                    $this->success('修改成功','wechat/user/index');
                }
            }
        }
    }
}