<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 14:47
 */

namespace app\api\controller;

use app\common\controller\HomeBase;
use app\common\model\Blog as BlogModel;
use think\Controller;
use think\View;
use think\Request;
use app\common\model\Order as OrderModel;

class Blog extends HomeBase{

    private  $_Blog_model;
    private  $_Order_model;
    public function _initialize(){
        $this->_Blog_model = new BlogModel();
        $this->_Order_model = new OrderModel();
    }

    /*
     * 接收json数据
  * array(3) { ["name"]=> string(6) "张三" ["phone"]=> string(11) "15622722016" ["addr"]=> string(6) "北京" }
     * */
    public function add_order(){
        if($this->request->isPost()){
            $data      = $this->request->param();
            $data['create_time']  = intval(time());
            $data['keyword'] = $data['name'] . $data['phone'] ;   // express
//            var_dump($data);
            // 接收处理数据, 把数据写入数据库
            if ($this->_Order_model->allowField(true)->save($data)) {
                $data_array = array(
                    'error'     => 0,
                    'msg'       => 'successful',
                    'data'      => '写入成功'
                );
                return json_encode($data_array,JSON_UNESCAPED_UNICODE);
            } else {
                $data_array = array(
                    'error'     => 333,
                    'msg'       => 'fail',
                    'data'      => '写入失败'
                );
                return json_encode($data_array,JSON_UNESCAPED_UNICODE);
            }
            // 读取写入数据库
        }else{

            $data_array = array(
                'error'     => 110,
                'msg'       => 'fail',
                'data'      => '请求错误'
            );
            return json_encode($data_array,JSON_UNESCAPED_UNICODE);
//            return $this->thinkJson(0);
        }
    }

    /*
     * get blog home list
     * */
    public function index(){
        return $this->thinkJson($this->_Blog_model->showHomeList());
    }

    /*
     *
     * */
    public function detail($id=0){
        if(!empty($id)){
            // 根据id查询数据
            $re =  $this->_Blog_model->showOneBlog($id);
            return $this->thinkJson($re);
        }else{
            return $this->thinkJson($id);
        }
    }








}