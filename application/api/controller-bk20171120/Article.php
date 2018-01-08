<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/26
 * Time: 11:52
 */

namespace app\api\controller;
use app\common\controller\HomeBase;
use think\View;
use think\Request;
use app\common\model\Article as ArticleModel;
use think\Controller;

class Article extends HomeBase{
    private $_article_model ;

    public function _initialize()
    {
        $this->_article_model  = new ArticleModel();
    }

    /*
     *  小程序json处理
     * */
    public function json_data($id){
        // 获取数据库的数据
        $re =  $this->_article_model->showOneArticle($id);
       // dump($re['0']);
       /// dump($re['0']['content']);
        $re_string = $re['0']['content'];
        // 正则匹配<P> 作为文本   <img>作为图片路径
        $p_array = explode('<p>',$re_string);
        $img_array = explode('<img',$re_string);
        dump($img_array);
        dump($p_array);


    }

    /*
     * 去掉html的空格
     * */
    public function replaceBlack($str){
        $dest = '';
        if($str != null){
            $p = $str.compile('\\s*|\t|\r|\n');

        }
    }

    /*
    * 微信二维码测试加粉数量
    * */
    public function wechat($id=0){
        // 1 这里直接执行获取当前id的数据
        $re =  $this->_article_model->showOneArticle($id);
        // 2 取得数据库里面的数据 sort
//        dump($re[0]);
        $sort = $re['0']['sort'];
//        dump($sort);
        // 3 把sort加1
        $sort += 1;
        //  4 把数据更新回数据库
        $readd =  $this->_article_model->updataSort($id,$sort);
//        dump($readd);

    }


    /*
     * html2json 导出 传入的文本格式json数据
     *
     * */
    public function detail($id=0){
        if(!empty($id)){
            // 根据id查询数据
            $re =  $this->_article_model->showOneArticle($id);
//            $re['0']['content'];
            // 取出里面的 content 解析为json数据
//            dump($re);
            $this->assign('result',$re['0']['content']);
            return view('detail');
//            return view('hello');
        }else{
            return $this->thinkJson($id);
        }
    }

    /*
     * 获取推荐数据 不包含内容
     *
     * */
    public function index(){
        return $this->thinkJson($this->_article_model->showHomeList());
    }

    /*
     * 获取推荐数据 指定返回 id,title,introduction,publish_time
     *@author xiongan  @date 2017 02 26
     * */
    public function homeList(){
        $result = $this->_article_model->showHomeList();
        return $this->thinkJson($result);
    }

    /*
     * 获取详情数据 根据id指定返回 对应的所有数据
     * @author xiongan  @date 2017 02 26
     * */
    public function detail_normal($id=0){
        if(!empty($id)){
            // 根据id查询数据
            $re =  $this->_article_model->showOneArticle($id);
            return $this->thinkJson($re);
        }else{
            return $this->thinkJson($id);
        }
    }








    /*
    * 处理返回json数据
    *
    * */
    protected function returnJson($array){
        $article =\app\common\model\Article::get(1);
//        $article = ArticleModel::all();
        var_dump($article);
        echo '<br/>';
//        $article->showAllArticles();

        return  $article->toJson();

    }







}