<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Writer as WriterModel;
use app\common\model\WriterCategory as WrCateModel;
/*
 * 文案管理系统
 * */
class Writer extends AdminBase{

    protected $writer_model;
    protected $wri_cate_model;

    /*
     * 初始化数据库的调用
     * */
    public function _initialize(){
        parent::_initialize();
        $this->writer_model = new WriterModel();
        $this->wri_cate_model = new WrCateModel();
        $category_list = $this->wri_cate_model->order(['sort' => 'ASC', 'id' => 'ASC'])->select();
		$category_level_list = array2level($category_list);
		$this->assign('category_level_list', $category_level_list);
    }

    /*
     * 显示文案列表
     * 筛选分类   关键词
     * */
    public function index($keyword = '', $page = 1){

        $map   = [];

        if (!empty($keyword)) {
            $map['think_writer.name'] = ['like', "%{$keyword}%"];
        }
     //    $writer_list = $this->writer_model->alias('w')->field('w.*,think_writer_category.name as cname')->join('think_writer_category','think_writer.pid = think_writer_category.id')->order(['think_writer.sort' => 'ASC', 'think_writer.id' => 'DESC'])->select();
    //     ->paginate(15, false, ['page' => $page]);
        $writer_list = $this->writer_model->alias('w')->field('w.*,think_writer_category.name as cname')->join('think_writer_category','think_writer.pid = think_writer_category.id')->where($map)->order(['think_writer.sort' => 'ASC', 'think_writer.id' => 'DESC']) ->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', [
            'writer_list' => $writer_list ,
            'keyword' => $keyword
        ]);
    }
    
    /*
     * 添加文案
     * */
     public function add($pid = ''){
		
		return $this->fetch('add', ['pid' => $pid]);
		
    }
    
    /**
     * 保存导航
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Nav');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->writer_model->save($data)) {
                    $this->success('保存成功','Writer/index');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑导航
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $nav = $this->writer_model->find($id);

        return $this->fetch('edit', ['nav' => $nav]);
    }

    /**
     * 更新导航
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Nav');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->writer_model->save($data, $id) !== false) {
                    $this->success('更新成功','Writer/index');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }
    
}
