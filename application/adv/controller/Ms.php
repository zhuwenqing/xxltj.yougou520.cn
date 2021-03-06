<?php

namespace app\adv\controller;

use app\common\controller\HomeBase;  // model
use think\Db;                       // db

class Ms extends HomeBase
{
    protected $wedata;
    protected  function _initialize(){

        $this->wedata = [   'thy88816,tab386,hbm256',
                            'hdq66250,xxk3570,sxn767,sxn854,szn697,hxy854',
                            'chh9636,zyq274,cmy395,wed743,wed936'
    ];
    
    }

    // ----------------------------------   前 三个  ---------------------------------------//  

     /*
    强肾疚---------文案04
 /adv/Ms/amaze
    */
    public function amaze($id=0){
        // 默认显示第一组微信号
        $wxdata = $this->wedata[$id];
        // var_dump($wxdata);
        $this->assign('wedata', $wxdata);
        return $this->fetch();
    }

     /*  /index/Man/paste
    强肾灸--------------就这么一贴一灸02
    */
    public function paste($id=0){
        // 默认显示第一组微信号
      $wxdata = $this->wedata[$id];
       //   var_dump($wxdata);
         $this->assign('wedata', $wxdata);
         return $this->fetch();
   }

   /*  /index/Man/lady
   强肾疚---------------文案 少妇口述03
   */
   public function lady($id=0){
       // 默认显示第一组微信号
       $wxdata = $this->wedata[$id];
       //    var_dump($wxdata);
          $this->assign('wedata', $wxdata);
          return $this->fetch();
   }

   // ----------------------------------------   

    
    /*
    强肾灸-------------01  /index/Man/strong  今赛咨询
    神了，20分钟，穴位疗法让我对“大”老公爱不释手
    */
    public function strong($id=0){
       // 默认显示第一组微信号
       $wxdata = $this->wedata[$id];
    //    var_dump($wxdata);
       $this->assign('wedata', $wxdata);
       return $this->fetch();
    }


    /*  /index/Man/strongl
    强肾疚---------------牛牛-----------强肾疚文案01
    */
    public function strongl($id=0){
       // 默认显示第一组微信号
       $wxdata = $this->wedata[$id];
    //    var_dump($wxdata);
       $this->assign('wedata', $wxdata);
       return $this->fetch();
    }

   

    /*
     强肾疚---------------03
     /index/Man/explosive
    那晚老公终于爆发了，让我潮吹不停......
    */
    public function explosive($id=0){
       // 默认显示第一组微信号
       $wxdata = $this->wedata[$id];
        //   var_dump($wxdata);
          $this->assign('wedata', $wxdata);
          return $this->fetch();
    }
    
   
    /*
     * 补肾问答文案   /index/Man/answer
     *  底部悬浮
     * */
    public function answer($id=0){
       // 默认显示第一组微信号
       $wxdata = $this->wedata[$id];
       //    var_dump($wxdata);
        $this->assign('wedata', $wxdata);
        return $this->fetch();
    }
// ----------------------------------------------- 以上安排接入退弹页面测试 ----------------------------/
    /*
     * 补肾问答文案二  /index/Man/answer2
     * 右侧悬浮图标
     * */
    public function answer2(){
        return $this->fetch();
    }

    /*
     * 藏传密宗男科文案 /index/Man/zang
     * */
    public function zang(){
        return $this->fetch();
    }

    /*
     * 地宫探秘男科文案  /index/Man/undergroud
     * */
    public function undergroud(){
        return $this->fetch();
    }

    /*
     * 独家公布房事一次50分钟的秘密
     * /index/Man/only50
     * */
    public function only50(){
        return $this->fetch();
    }

    /*
     * 独家公布房事一次50分钟的秘密修改版
     * /index/Man/only50c
     * */
    public function only50c(){
        return $this->fetch();
    }

    /*
     * 健康养生贴吧文案
     * /index/Man/healthy
     * */
    public function healthy(){
        return $this->fetch();
    }

    /*
     * 老公肾虚 我让他这样恢复
     * 【360安全认证网站】受不了！美艳少妇被彻底征服的秘密……
     * /index/Man/kidney
     * */
    public function kidney(){
        return $this->fetch();
    }

    /*
     *苗疆房中术男科
      /index/Man/miao
     * */
    public function miao(){
        return $this->fetch();
    }

    /*
     *苗疆房中术男科第二版
     /index/Man/miao2
     * */
    public function miao2(){
        return $this->fetch();
    }

    /*
     * 男科（阅读超100万解决早泄阳痿短小案例）
     * /index/Man/read
     * /static/css/man/read/show.png
     * */
    public function read(){
        return $this->fetch();
    }

    /*
     * 男科多页面论坛文案 page 5
     * /index/Man/forum
     * /static/css/man/forum/show.png
     * */
    public function forum(){
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

    public function pages05(){
        return $this->fetch();
    }

    /*
     * 男性健康4页论坛文案 page four
     * * /index/Man/forum4
     * /static/css/man/forum4/show.png
     * */
    public function  forum4(){
        return $this->fetch();
    }
    public function page2(){
        return $this->fetch();
    }
    public function page3(){
        return $this->fetch();
    }
    public function page4(){
        return $this->fetch();
    }

    /*
     * 少妇哭述：老公不行
     *  * /index/Man/cry
     * /static/css/man/cry/show.png
     * */
    public function cry(){
        return $this->fetch();
    }

    /*
     * 思邈堂中医论坛
     *  /index/Man/medicine
     * /static/css/man/medicine/show.png
     * */
    public function medicine(){
        return $this->fetch();
    }

    /*
     * 阳痿早泄怎么办权威解答
     * /index/Man/early
     * */
    public function early(){
        return $this->fetch();
    }

    /*
     *印度男人器大活好的秘密  /index/Man/india
     * */
    public function india(){
        return $this->fetch();
    }

    /*
    色情圣好文案

    */
    public function ss()
    {
        return $this->fetch();
    }

}