<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/8/22
 * Time: 8:38
 */

namespace app\index\controller;

use app\common\controller\HomeBase;


class Nose extends HomeBase
{
    /*
     * 初始化参数
     * */
    public function _initial(){

    }

    /*
     * 【精华】我是如何很快祛除折磨了我10多年的老鼻炎（鼻友必看）！
     *  第一页  /index/Nose/old
     * */
    public function old(){
        return $this->fetch();
    }

    public function pages02(){
        return $this->fetch();
    }

    public function pages03(){
        return $this->fetch();
    }

    public function pages04(){
        return $this->fetch();
    }



    /*
     * 鼻.炎又犯了，怎么办？小偏方一招解决！！！
     *  /index/Nose/again
     * */
    public function again(){
        return $this->fetch();
    }

    /*
     *鼻炎5年多，鼻塞鼻痒流鼻涕
     * /index/Nose/fiveyear
     * */
    public function fiveyear(){
        return $this->fetch();
    }




}
