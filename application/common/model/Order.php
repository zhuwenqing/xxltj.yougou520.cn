<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/9/26
 * Time: 17:42
 */

namespace app\common\model;

use think\Session;
use think\Model;
use think\Db;

class Order extends Model{
    public function index(){

    }

    public function show(){
        return Db::name('order')->select();
    }

    /*
     * 查看所有订单
     * */
    public function showAll( $keyword = '', $page = 1 , $show = 0){
        $map = [];
        $field = 'id,name,pro,phone,statue,express,addr,create_time';

        //  SELECT * FROM think_order WHERE statue != 99

        if(!empty($keyword)){
            $map['keyword'] = ['like',"%{$keyword}%"];
        }
        if(empty($show)){
            // 筛选显示状态是99的订单
//            $map['statue'] =' statue != 99 ';
            $map['statue'] = ['neq','99'];
        }
        $order_list   =  Db::name('order')->field($field)->where($map)->order(['create_time' => 'DESC'])->paginate(10, false, ['page' => $page]);

        return array(
            'order_list' => $order_list,
           'keyword' => $keyword
        );
    }

    /*
     * 查看单个订单详情
     * */
    public function showOne($id){
        return Db::name('order')->where(['id'=>$id])->select();
    }

    /*
     * 删除一条订单, 实际是修改订单的状态
     * */
    public function deleteOne($id){

    }


}