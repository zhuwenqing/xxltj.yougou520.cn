<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/12/4
 * Time: 17:51
 */

namespace app\admin\controller;

use app\common\model\Logs as LogsModel;
use app\common\controller\AdminBase;

class Logs extends AdminBase
{

    protected  $logs_model ;
    protected function _initialize()
    {
        parent::_initialize();
        $this->logs_model = new LogsModel();
    }
    // 显示所有的日志
    public function index($page = 1,$keyword = '',$type = '',$start_time = '',$end_time = ''){
        $data = $this->logs_model->showAll($page,$type,$keyword,$start_time,$end_time);
        return $this->fetch(
            'index',[
                'logs_data' => $data,
                'keyword'=>$keyword,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
            ]
        );
    }

    public function add(){
        $admin_user = 'hello';
        $logs_data = array(
            'ip' => '1.1.1.1',
            'type' => 1,
            'detail' => '登录者:'.$admin_user .'操作-登录',
            'time' => date("Y-m-d H:i:s")
        );
        $data = $this->logs_model->insert($logs_data);
        var_dump($data);
    }




}