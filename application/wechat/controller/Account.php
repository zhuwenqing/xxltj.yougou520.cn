<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/5/31
 * Time: 10:23
 */

namespace app\wechat\controller;
use app\common\model\Account as AccountModel;
use app\common\controller\WebAdminBase;
use app\common\model\Accservice as AcceserviceModel;
use app\common\model\Channel as ChannelModel;
use think\session;
use think\Loader;
use think\View;
use think\Controller;

class Account extends WebAdminBase
{
    protected $account_model;
    protected $accservice_model;
    protected $channel_model;

    public function _initialize()
    {
        parent::_initialize();
        $this->channel_model = new ChannelModel();
        $this->account_model = new AccountModel();
        $this->accservice_model = new AcceserviceModel();
    }

    /*
     * 显示微信号列表
     * */

    public function index($page = 1){
        // 获取所有的微信号 按照 客服号-客户号的样式输出
        $map = [];
        $uid = session::get('user_id');
        if($uid > 0 ){
            $map['uid'] = ['eq',$uid];
        }

        // 1 获取 客服微信号
        $accservice_list = $this->accservice_model->where($map)->paginate(10, false, ['page' => $page]);
        // 2 根据获取到的客服微信号获取对应的客户微信号
//        var_dump($accservice_list);

//        $account_list = $this->account_model->field(true)->where($map)->paginate(10, false, ['page' => $page]);

//        dump($account_list);
        // 整理客服微信号 嵌入 客户微信号

        return $this->fetch('index', [
            'accservice_list' => $accservice_list,
//            'account_list' => $account_list
        ]);



    }


    public function add(){
        $data = $this->channel_model->field('id,name')->select();
        $this->assign('channel_list',$data);
        return $this->fetch('add');
    }


    /*
     * 添加客服微信号
     * */
    public function add_accservice(){
        $uid = session::get('user_id');
        if($this->request->isPost()){
            $data = $this->request->param();
            $data['uid'] = $uid;
            $result_validate = Loader::validate('Account');
            if(!$result_validate->check($data)){
                $this->error($result_validate->getError());
            }else{
                $result = $this->accservice_model->allowField(true)->save($data);
                if($result){
                    $this->success('添加成功','wechat/account/add');
                }else{
                    $this->error('添加失败','wechat/account/add');
                }
            }
        }
    }


    public function fadd(){
        $channel_list = $this->channel_model->field('id,name')->select();
        $data = $this->accservice_model->alias('a')->field('a.id,a.username,think_channel.name,a.wechat_name')
                    ->join('think_channel','a.b_type = think_channel.id')->select();
//        var_dump($data);
        $this->assign('channel_list',$channel_list);
        $this->assign('data',$data);
        return $this->fetch('fadd');
    }

    /*
     * 添加客户微信号
     * */
    public function add_account(){
        if($this->request->isPost()){
            $data = $this->request->param();
            $result_validate = Loader::validate('Faccount');
            if(!$result_validate->check($data)){
                $this->error($result_validate->getError());
            }else{
                $result = $this->account_model->save($data);
                if($result){
                    $this->success('添加成功','wechat/account/fadd');
                }else{
                    $this->error('添加失败','wechat/account/fadd');
                }
            }
        }
    }


    public function friend($page = 1){
        $data = $this->request->get();
        $map['fid'] = ['eq',$data['id']];
        $result = $this->account_model->alias('a')->field('a.*,c.name')->join('think_channel c','a.c_type = c.id')->where($map)->paginate(10, false, ['page' => $page]);
        return $result;
    }



}
