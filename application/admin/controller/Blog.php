<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 15:22
 */
namespace app\admin\controller;

use app\common\model\Blog as BlogModel;
use app\common\model\Category as CategoryModel;
use app\common\controller\AdminBase;
use app\common\model\Order as OrderModel;

/**
 * 博客管理
 * Class Blog
 * @package app\admin\controller
 */

class Blog  extends AdminBase{
    protected  $_blog_model;
    protected $category_model;
    private  $_Order_model;

    protected function _initialize(){
        parent::_initialize();
        $this->_blog_model = new BlogModel();

        $this->category_model = new CategoryModel();
        $this->_Order_model = new OrderModel();
        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
    }

    /*
     * 展示在线订单
     * */
    public function order($keyword = '', $page = 1, $show=0){
        // 查看所有订单
//        $show = 1;
        $orders =  $this->_Order_model->showAll($keyword,$page,$show);
//        var_dump($orders);
        return $this->fetch('order',
            [
                'order_list' => $orders['order_list'],
                'keyword' => $orders['keyword'],
            ]);
    }

    /*
     * 查看和修改
     * */
    public function oredit(){
        $data = request()->param();
        if($this->request->isPost()){
//            var_dump($data);
//            var_dump($data['id']);
//            exit();
            /* 提交修改数据
             * */
            $order = $this->_Order_model->where('id',$data['id'])->update($data);
            if($order){
                $this->success('修改成功','Blog/order');
            }else{
                $this->error('修改失败');
            }
        }else{
//            var_dump($data);
//            var_dump($data['id']);
//            exit();
            $id = $data['id'];
            if(empty($id)){
                $this->error('订单不存在','Blog/order');
            }else{
                $order =  $this->_Order_model->showOne($id);
//            var_dump($order);exit();
                return $this->fetch('oredit',
                    [
                        'Order' => $order[0]
                    ]);
            }
        }
    }

    /*
     * 删除订单
     * */
    public function ordelete($id){
        if(empty($id)){
            $this->error('订单不存在','Blog/order');
        }else{
            $data['statue'] = 99;
            $order =  $this->_Order_model->where('id',$id)->update($data);
           // var_dump($order);exit();
            if($order){
                $this->success('修改成功','Blog/order');
            }else{
                $this->error('修改失败');
            }
        }
    }

    /*
     * 保存修改的数据
     * */
    public function orsave($data){

    }


    /*
     * show all blogs
     * */
    public function index($cid = 0, $keyword = '', $page = 1){
     //   $blog_list = new BlogModel();
       $blog_result = $this->_blog_model->showAll($cid,$keyword,$page);
        return $this->fetch('index', [
            'article_list' => $blog_result['article_list'],
            'category_list' => $blog_result['category_list'],
            'cid' => $blog_result['cid'],
            'keyword' => $blog_result['keyword'],
        ]);
    }

    /**
     * Blog添加文章
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $data['wechatname'] = json_encode(explode('|',$data['wechatname']));
            // 验证数据  上传图片返回服务器的地址
            $this->_blog_model->name('document');
            // 选取data数据上传到数据库
            $data['create_time'] = time();
            $re = $this->_blog_model->save($data);
            if($re){
                $optye = 'Blog添加文章';
                add_logs($optye,1);
                $this->success('添加成功','Blog/index');
            }else{
                $this->error('添加失败','Blog/add');
            }
//            $res = $blog_model->allowField(true)->
        }else{
            return $this->fetch('add');
        }
    }

    public function update(){
        $data = request()->param('id');
        //读取表数据
        $Bloglist = $this->_blog_model->showOneBlog($data);
        if(json_decode($Bloglist[0]['wechatname'])){
            $Bloglist[0]['wechatname'] = implode('|',json_decode($Bloglist[0]['wechatname']));
        }
        if(!$Bloglist){
            $this->error('信息不存在或已被删除','Blog/index');
        }else {
            $this->assign('Bloglist', $Bloglist[0]);
        }
        return $this->fetch('update');
    }

    /**
     * Blog修改文章
     * @return mixed
     */
    public function save(){
        $data = request()->param();
        $data['wechatname'] = json_encode(explode('|',$data['wechatname']));
        $data['modification_time'] = time();
        $re = $this->_blog_model->name('document')->where('id',$data['id'])->update($data);
        if($re){
            $optye = 'Blog修改文章';
            add_logs($optye,2);
            $this->success('修改成功','Blog/index');
        }else{
            $this->error('修改失败','Blog/update');
        }
    }

    /**
     * Blog删除文章
     * @return mixed
     */
    public function delete(){
        $data = request()->param('id');
        $this->_blog_model->name('document');
        $delete = $this->_blog_model->where('id',$data)->delete();
        if($delete){
            $optye = 'Blog删除文章';
            add_logs($optye,3);
            $this->success('删除成功','Blog/index');
        }else{
            $this->error('删除失败','Blog/index');
        }
    }














}
