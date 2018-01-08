<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/4/17
 * Time: 20:53
 */

namespace app\wechat\controller;

use app\common\controller\HomeBase;
use app\common\model\Weditor as WeditorModel;
use app\common\model\Wecategory as WecategoryModel;
use app\common\model\Wearticle as WearticleModel;
use think\View;
use think\Db;
use think\Controller;

class Wechat extends HomeBase
{
    protected $weditor_model;
    protected $wecategory_model;
    protected $wearticle_model;

    public function _initialize(){
        $this->weditor_model = new WeditorModel();
        $this->wecategory_model = new WecategoryModel();
        $this->wearticle_model = new WearticleModel();
    }

    /*
     * 微信编辑器
     * */
    public function index(){
        $result = $this->weditor_model->select();
        $wecategory = $this->wecategory_model->getLevelList();
        $art_category = Db::name('artcategory')->where('status',1)->order('id asc')->select();
    //    var_dump($art_category); exit();
        $this->assign('artcategory',$art_category);
        $this->assign('wecategory',$wecategory);
        $this->assign('results',$result);
        return view('index');
    }

    /*
     * 添加数据到数据库
     * */
    public function add(){
        if($this->request->isPost()){
            $data = $this->request->param();
//            var_dump($data);exit();
            if(empty($data['content'])){
                $this->error('内容不能为空');
            }else{
                $result = $this->wearticle_model->allowField(true)->save($data);
                if($result){
                    $this->success('保存成功','Index/index');
                }else{
                    $this->error('保存失败');
                }
                // if($this->request->file('thumb')){
                    // 获取提交的图片进行上传
                    // $image = $this->request->file('thumb');
//                    var_dump($image);exit();
                //     $info = $image->move(ROOT_PATH.'public/uploads/image');
                //     $data['thumb'] = '/uploads/image/'.$info->getSaveName();
                //     if($info){
                //         $result = $this->wearticle_model->allowField(true)->save($data);
                //         if($result){
                //             $this->success('保存成功','Index/index');
                //         }else{
                //             $this->error('保存失败');
                //         }
                //     }else{
                //         $this->error('保存失败');
                //     }
                // }else{
                //     $result = $this->wearticle_model->save($data);
                //     if($result){
                //         $this->success('保存成功','Index/index');
                //     }else{
                //         $this->error('保存失败');
                //     }
                // }
            }
        }
    }





}
