<?php
namespace app\admin\controller;

use app\common\model\Products as ProductsModel;
use app\common\model\Category as CategoryModel;
use app\common\model\WarehouseRule as WarehouseRuleModel;
use app\common\model\Generalwarehouse as WarehouseModel;
use app\common\controller\AdminBase;

/**
 * 仓储系统 仓储列表 index  / 添加存货 add / 内仓发货 inside  / 外仓发货 external
 * Class Generalwarehouse
 * @package app\admin\controller
 */
class Generalwarehouse extends AdminBase
{
    protected $products_model;
    protected $category_model;
    protected $warehouserule_model;
    protected $warehouse_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->warehouserule_model = new WarehouseRuleModel();
        $this->products_model  = new ProductsModel();
        $this->category_model = new CategoryModel();
        $this->warehouse_model = new WarehouseModel();

        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
        $products_level_list = $this->products_model->getLevelList();
        $this->assign('products_level_list',$products_level_list);
    }

    /**
     * 仓储列表
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index($cid = 0, $keyword = '', $page = 1)
    {
        $map   = [];
        $field = 'id,cid,pid,buy,status,inside_id,external_id,publish_time,thumb,remark';

        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }else{
            $map['status'] = ['eq','1'];
        }

        $article_list  = $this->warehouse_model->field($field)->where($map)->order(['publish_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $product_list = $this->products_model->column('name','id');
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', [
            'product_list' => $product_list,
            'article_list' => $article_list,
            'category_list' => $category_list,
            'cid' => $cid, 'keyword' => $keyword
        ]);
    }

    /**
     * 添加仓储
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存仓储
     */
    public function save()
    {

        if ($this->request->isPost()) {
            $data            = $this->request->param();
            var_dump($data);exit();
            // validate 验证数据
            $validate_result = $this->validate($data, 'Warehouse');

            if ($validate_result !== true) {
                $this->error($validate_result);
                echo '保存失败';
            } else {
                if ($this->warehouse_model->allowField(true)->save($data)) {
                    //   $this->success('保存成功');
                    //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
                    $this->success('新增成功', 'Generalwarehouse/index');
                } else {
                    $this->error('新增失败');
                }
            }
        }
    }

    /**
     *   子产品分类
     */
    public function son($pid){
        $son_list = $this->products_model->field('id,name')->where("cid",$pid)->select();
        return $son_list;
    }

    /**
     * 编辑仓储
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $article = $this->products_model->find($id);

        return $this->fetch('edit', ['article' => $article]);
    }

    /**
     * 更新仓储
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Article');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                // 保存数据到数据库

                if ($this->products_model->allowField(true)->save($data, $id) !== false) {
//                    $this->success('更新成功');
                    $this->success('修改成功', 'Products/index');
                } else {
                    $this->error('修改失败');
                }



            }
        }
    }

    /**
     * 删除仓储
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->products_model->where("id = {$id}")->setField("status",0)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的文章');
        }
    }

    /**
     * 文章审核状态切换
     * @param array  $ids
     * @param string $type 操作类型
     */
    public function toggle($ids = [], $type = '')
    {
        $data   = [];
        $status = $type == 'audit' ? 1 : 0;

        if (!empty($ids)) {
            foreach ($ids as $value) {
                $data[] = ['id' => $value, 'status' => $status];
            }
            if ($this->products_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的文章');
        }
    }

    /*
     *  发货管理
     *
     * */
    public function send(){
        return $this->fetch();
    }

    /*
     * 内仓发货
     * 调用内仓仓库列表
     * */
    public function inside($id = 6){
        $warehouserule_level_list = $this->warehouserule_model->getLevelList($id);
        // var_dump($warehouserule_level_list);exit();
        $this->assign('warehouserule_level_list', $warehouserule_level_list);
        return $this->fetch();
    }

    /*
     * 外仓发货
     * 调用外仓仓库列表
     * */
    public function external($id = 7){
        $warehouserule_level_list = $this->warehouserule_model->getLevelList($id);
        // var_dump($warehouserule_level_list);exit();
        $this->assign('warehouserule_level_list', $warehouserule_level_list);
        return $this->fetch();
    }

}