<?php
namespace app\admin\controller;

use app\common\controller\HomeBase;
use app\common\model\Weditor as WeditorModel;
use app\common\model\Wecategory as WecategoryModel;
use app\common\model\Wearticle as WearticleModel;
use think\View;
use think\Db;
use app\common\controller\AdminBase;

/**
 * 栏目管理
 * Class Category
 * @package app\admin\controller
 */
class Warticlelist extends AdminBase
{

    protected $weditor_model;
    protected $wecategory_model;
    protected $wearticle_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->weditor_model = new WeditorModel();
        $this->wecategory_model = new WecategoryModel();
        $this->wearticle_model = new WearticleModel();
    }

    /**
     * 微文管理
     * @return mixed
     */
    public function index($keyword = '')
    {
        $welist = $this->wearticle_model->showHomeList();
        // dump($welist);
        $this->assign('welist',$welist);
        $this->assign('wechat_info',array(
            'id'         =>      1 ,
            'title'         =>      '文案列表',
        ));
        return $this->fetch();
    }

    /**
     * 添加微文
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '')
    {
        $art_category = Db::name('artcategory')->where('status',1)->order('id asc')->select();
        $this->assign('artcategory',$art_category);
        return $this->fetch();
    }

    /**
     * 保存微文
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            if(empty($data['content'])){
                $this->error('内容不能为空');
            }else{
                $result = $this->wearticle_model->allowField(true)->save($data);
                if($result){
                    $optye = '保存微文';
                    add_logs($optye,1);
                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑微文
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $wearticle = $this->wearticle_model->where('id',$id)->find();
        $art_category = Db::name('artcategory')->where('status',1)->order('id asc')->select();
        $this->assign('artcategory',$art_category);
        $this->assign('wearticle',$wearticle);
        return $this->fetch();
    }

    /**
     * 更新微文
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            if(empty($data['content'])){
                $this->error('内容不能为空');
            }else{
                $result = $this->wearticle_model->allowField(true)->save($data,$id);
                if($result){
                    $optye = '更新微文';
                    add_logs($optye,2);
                    $this->success('更新成功');
                }else{
                    $this->error('更新失败');
                }
            }
            // $validate_result = $this->validate($data, 'Weditor');
            // if ($validate_result !== true) {
            //     $this->error($validate_result);
            // } else {
            //         if ($this->weditor_model->allowField(true)->save($data, $id) !== false) {
            //             $this->success('更新成功');
            //         } else {
            //             $this->error('更新失败');
            //         }
            // }
        }
    }

    /**
     * 删除微文
     */
    public function delete($id){
        $data = $this->wearticle_model->where('id',$id)->delete();
        if($data){
            $optye = '删除微文';
            add_logs($optye,3);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }

}