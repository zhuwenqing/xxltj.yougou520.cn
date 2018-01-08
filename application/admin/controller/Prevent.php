<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Products as ProductsModel;
use app\common\model\Category as CategoryModel;

class Prevent extends AdminBase
{
    protected $products_model;
    protected $category_model;

    protected function _initialize(){
        parent::_initialize();
        $this->products_model  = new ProductsModel();
        $this->category_model = new CategoryModel();
    }

    public function index(){
        return $this->fetch();
    }

    public function project($cid = 0, $keyword = '', $page = 1){
        $map   = [];
        $field = 'id,name,cid,publisher,status,publish_time,thumb,remark';

        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['name'] = ['like', "%{$keyword}%"];
        }else{
            $map['status'] = ['eq','1'];
        }

        $article_list  = $this->products_model->field($field)->where($map)->order(['publish_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', [
            'article_list' => $article_list,
            'category_list' => $category_list,
            'cid' => $cid, 'keyword' => $keyword
        ]);
        return $this->fetch();
    }


}