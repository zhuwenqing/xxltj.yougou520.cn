<?php
namespace app\admin\controller;

use app\common\model\Article as ArticleModel;
use app\common\model\Wecategory as CategoryModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 栏目管理
 * Class Category
 * @package app\admin\controller
 */
class Wecategory extends AdminBase
{

    protected $category_model;
    protected $article_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new CategoryModel();
        $this->article_model  = new ArticleModel();
        $category_level_list  = $this->category_model->getLevelList();

        $this->assign('category_level_list', $category_level_list);
    }

    /**
     * 微信样式分类管理
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加微信样式分类
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '')
    {
        return $this->fetch('add', ['pid' => $pid]);
    }

    /**
     * 保存微信样式分类
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Category');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->category_model->allowField(true)->save($data)) {
                    $optye = '保存微信样式分类';
                    add_logs($optye,1);
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑微信样式分类
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $category = $this->category_model->find($id);

        return $this->fetch('edit', ['category' => $category]);
    }

    /**
     * 更新微信样式分类
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Category');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $children = $this->category_model->where(['path' => ['like', "%,{$id},%"]])->column('id');
                if (in_array($data['pid'], $children)) {
                    $this->error('不能移动到自己的子分类');
                } else {
                    if ($this->category_model->allowField(true)->save($data, $id) !== false) {
                        $optye = '更新微信样式分类';
                        add_logs($optye,2);
                        $this->success('更新成功');
                    } else {
                        $this->error('更新失败');
                    }
                }
            }
        }
    }

    /**
     * 删除微信样式分类
     * @param $id
     */
    public function delete($id)
    {
        $category = $this->category_model->where(['pid' => $id])->find();
        $article  = $this->article_model->where(['cid' => $id])->find();

        if (!empty($category)) {
            $this->error('此分类下存在子分类，不可删除');
        }
        if (!empty($article)) {
            $this->error('此分类下存在文章，不可删除');
        }
        if ($this->category_model->destroy($id)) {
            $optye = '删除微信样式分类';
            add_logs($optye,3);
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}