<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/9/28
 * Time: 9:17
 */

namespace app\admin\controller;
use app\common\controller\AdminBase;
use app\common\model\Order as OrderModel;

class Order extends AdminBase{

    private  $_Order_model;

    protected function _initialize(){
        parent::_initialize();
        $this->_Order_model = new OrderModel();
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


}