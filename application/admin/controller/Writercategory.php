<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/8/31
 * Time: 9:30
 */


namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use app\common\model\WriterCategory as WrCateModel;
use think\View; 

/**
 * 轮播图分类
 * Class WriterCategory
 * @package app\admin\controller
 */
class Writercategory extends AdminBase
{
	protected $wr_ca_model;
	
	public function _initialize(){
		parent::_initialize();
		$this->wr_ca_model = new WrCateModel();
		$category_list = $this->wr_ca_model->order(['sort' => 'ASC', 'id' => 'ASC'])->select();
		$category_level_list = array2level($category_list);
		$this->assign('category_level_list', $category_level_list);
	}
	
	
	/*
	 * 显示所有的分类信息
	 * */
	public function index(){
		 $category_list = $this->wr_ca_model->order(['sort' => 'ASC', 'id' => 'ASC'])->select();
		 $this->assign('category_list', $category_list);
		return $this->fetch();
	}
	
	
	/*
	 * 添加文案分类
	 * */
	public function add($pid = ''){
		
		return $this->fetch('add', ['pid' => $pid]);
		
	}

	/*
	保存分类
	*/
	public function save(){
		if($this->request->isPost()){
			$data            = $this->request->param();
			$validate_result = $this->validate($data, 'Category');
			

			if($validate_result !== true){
				$this->error($validate_result);
			}else{
				if($this->wr_ca_model->save($data)){
					$this->success('保存成功','Writercategory/index');
                } else {
                    $this->error('保存失败');
                }
			}

		}
	}

	/*
	编辑
	*/
	public function edit($id)
	{
		$type = $this->wr_ca_model->find($id);
		return $this->fetch('edit',['type'=>$type]);
	}

    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Category');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->wr_ca_model->save($data, $id) !== false) {
                    $this->success('保存成功','Writercategory/index');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

	/*
	删除
	*/
	public function delete($id)
	{
		if($this->wr_ca_model->destroy($id)){
			$this->success('保存成功','Writercategory/index');
		} else {
			$this->error('保存失败');
		}
	}












	
}