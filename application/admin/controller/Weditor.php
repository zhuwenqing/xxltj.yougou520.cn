<?php
namespace app\admin\controller;

use app\common\model\Article as ArticleModel;
use app\common\model\Weditor as WeditorModel;
use app\common\model\Wecategory as CategoryModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 栏目管理
 * Class Category
 * @package app\admin\controller
 */
class Weditor extends AdminBase
{

    protected $article_model;
    protected $weditor_model;
    protected $category_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new CategoryModel();
        $this->weditor_model = new WeditorModel();
        $this->article_model  = new ArticleModel();
        $category_level_list  = $this->category_model->getLevelList();

        $this->assign('category_level_list', $category_level_list);
    }

    /**
     * 微信样式管理
     * @return mixed
     */
    public function index()
    {
        $result = $this->weditor_model->paginate(15,false);
        $pages = $result->render();
//        var_dump($result);
//        $this->assign('pages',$pages);
        $this->assign('results',$result);
        return $this->fetch();
    }

    /**
     * 添加微信样式
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '')
    {
        return $this->fetch('add', ['pid' => $pid]);
    }

    /**
     * 保存微信样式
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Weditor');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->weditor_model->allowField(true)->save($data)) {
                    $optye = '保存微信样式';
                    add_logs($optye,1);
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑微信样式
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $result = $this->weditor_model->find($id);

        return $this->fetch('edit', ['result' => $result]);
    }

    /**
     * 更新微信样式
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Weditor');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                    if ($this->weditor_model->allowField(true)->save($data, $id) !== false) {
                        $optye = '更新微信样式';
                        add_logs($optye,2);
                        $this->success('更新成功');
                    } else {
                        $this->error('更新失败');
                    }
            }
        }
    }

}