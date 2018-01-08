<?php

namespace app\index\controller;

use app\common\controller\HomeBase;

class Care extends HomeBase{
    

    /*
    
    */
    public function index(){
        return $this->fetch();
    }

    /*
    /index/Care/care
    我的男人是这样从5分钟到50分钟的
    */
     public function care()
    {
        return $this->fetch();

    }


    /*
    震惊！原来脱肛的治疗方法竟这么简单！ ！

    */
    public function amaze()
    {
        return $this->fetch();
    }

}
