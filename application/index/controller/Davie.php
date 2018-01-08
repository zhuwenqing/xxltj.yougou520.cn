<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/4/6
 * Time: 18:25
 */
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\View;
class Davie extends HomeBase
{
    public function index(){

    }

    // 添加数据解析
    public function add(){
        return view('add');
    }

    // 接收输入的数据
    public function save(){
        if ($this->request->isPost())
        {
            dump($this->request->param());
            //
            $content_arr = $this->request->param();
            $content = $content_arr['content'];
            // 解析数据转化为json格式



//            dump($this->request);


        }
    }

}