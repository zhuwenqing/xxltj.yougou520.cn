<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/8/29
 * Time: 17:34
 */

namespace app\index\controller;

use app\common\controller\HomeBase;

/*
 * 皮肤文案
 * */
class Ski  extends  HomeBase{

    /*-------------------------------------------------------- 吉米文案 -----------------------------------------------------
     * 吉米老文案 带二维码
     * /index/Ski/jimicode
     * */
    public function jimicode(){
        return $this->fetch();
    }

    /*
     * 吉米文案按钮版 带二维码
     * /index/Ski/jimibutton
     * */
    public function jimibutton(){
        return $this->fetch();
    }

    /*
     * 时尚嫩模曝惊天美白祛斑术，美容教父吉米独创，明星都在用！
     * /index/Ski/fasion
     * */
    public function fasion(){
        return $this->fetch();
    }

    /*
     * 【焦点】美容教父吉米重出江湖，为千万女性祛斑成功，又一次火了！
     * /index/Ski/godfather
     * */
    public function godfather(){
        return $this->fetch();
    }

    /*
     * 【大妈变校花】说说我的成功祛斑历程
     * /index/Ski/successful
     * */
    public function successful(){
        return $this->fetch();
    }

    /*-------------------------------------------------------- 国启东 -----------------------------------------------------
     * 国启东祛斑文案
     *  /index/Ski/guo
     * */
    public function guo(){
        return $this->fetch();
    }



    /*
     *
     * */
    public function tt1(){
        return $this->fetch();
    }
}