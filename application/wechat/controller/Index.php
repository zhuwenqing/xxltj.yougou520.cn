<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/5/10
 * Time: 19:42
 */

namespace app\wechat\controller;

use app\common\controller\HomeBase;
use app\common\model\Wearticle as WearticleModel;
use think\View;
use think\Controller;

class Index extends HomeBase
{
    protected $wearticle_model;

    public function _initialize(){
        $this->wearticle_model = new WearticleModel();
    }

    /*
     * 微信编辑器首页
     * */
    public function index(){
        $welist = $this->wearticle_model->showHomeList();
//        dump($welist);
        $this->assign('welist',$welist);
        $this->assign('wechat_info',array(
            'id'         =>      1 ,
            'title'         =>      '文案列表',
        ));
        return view('index');
    }


    public function indexapi(){
        return json($this->wearticle_model->showHomeList());
    }
    
    /*
     * 文案详情
     * */
    public function detail($id=0){
        if(!empty($id)){
            // 显示文案页面
            $wedetail = $this->wearticle_model->showOneArticle($id);

            $this->assign('wedetail',$wedetail);
            return view('detail');
        }else{
            $this->error('文案不存在','Wechat/index');
        }
    }





}