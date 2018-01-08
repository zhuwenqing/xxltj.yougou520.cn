<?php
namespace app\adv\controller;

use app\common\controller\HomeBase;  // model
use think\Db;                       // db
use app\common\model\Article as ArticleModel;

class Index extends HomeBase
{
    
    protected $current_url;
    protected  function _initialize(){

       // $this->current_url = $_SERVER['SERVER_NAME'];
        $this->assign('current_url',$_SERVER['SERVER_NAME']);
    }

    /*
    *
    * */
    public function index()
    {
        return $this->fetch('mbaidu');
    }

    /*
    虚拟的搜索搜索页面  --百度 男科退弹
    */
    public function show()
    {
        // $urlarray = [
        //     '/index/Man/amaze',
        //     '/index/Man/strong',
        //     '/index/Man/strongl',
        //     '/index/Man/paste'
        // ];

        // $this->assign('showurl',$urlarray[1]);

        return $this->fetch('show');
    }

    /*
    虚拟的搜索搜索页面  --搜狗男科退弹
    */
    public function soso($id=0)
    {
        $data_arr = [
            [
                "title" =>  " 【<em style='color:red'>神奇！</em>】就这么一贴一灸！ 30分钟让老婆欲仙欲死……. "  ,
                "desc"  =>  "就这么一贴啊还真的就有反应了，身上热热的，下面胀胀的，欲望很强烈，我都四十多了，竟然晨勃又恢复了！真的挺神奇的！",
                "href"  =>  "https://www.sogou.com/"     ,
                "num"   =>  "998",
                "url"   =>  "{:url('adv/Ms/amaze')}"
            ],
            [
                "title"=>"【<em style='color:red'>神奇！</em>】就这么一贴一灸！30分钟让老婆欲仙欲死？……."       ,
                "desc"=>"或许你也曾被一个问题困扰多年，却又羞于启齿！或许你一直很苦恼也没自信，感觉对不起自己的老婆！不用怕，看小男人如何从一蹶不振，到再次超长待！",
                "href"=>"https://www.sogou.com/",
                "num"=>"998",
                "url"=>"{:url('adv/Ms/paste')}"
            ],
            [
                "title"=>"【<em style='color:red'>少妇口述</em>】我的男人是这样从5分钟到50分钟的…….",
                "desc"=>"当你欲火难耐、无处释放的时候！",
                "href"=>"https://www.sogou.com/",
                "num"=>"998",
                "url"=>"{:url('adv/Ms/lady')}"
            ]
        ];
        $data_json = json_encode($data_arr);
        // var_dump($data_json);
        $this->assign('sosojson',$data_json);
        return $this->fetch('soso');
    }


    public function beautiful($id=0)
    {
        # code...
    }








}
