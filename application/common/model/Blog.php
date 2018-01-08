<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 9:32
 */

namespace app\common\model;

use think\Session;
use think\Model;
use think\Db;

class Blog extends Model{
    private $_blog_model;

    public function _initialize(){
        $this->_blog_model = Db::name('document');
    }

    /*
     * 展示首页列表数据 id cid title introduction reading  thumb publish_time
     * */
    public function showHomeList(){
        //   return Db::name('article')->select('title');
        return Db::query('SELECT id,title,create_time,thumb FROM think_document ');
    }

    /*
    * 获取详情数据 根据id指定返回 对应的所有数据
    * @author xiongan  @date 2017 02 26
    * */
    public function showOneBlog($id){
//        return Db::query('SELECT id,title,introduction,publish_time FROM think_article ');
        return Db::name('document')->where(['id'=>$id])->select();
    }

    /*
     * show blog list
     * @author xiongan  @date 2017 02 26
     * */
    public function showAll($cid = 0, $keyword = '', $page = 1){
        $map = [];
        $field = 'id,title,cid,create_time,wechatname';

        if($cid>0){
//            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }
        if(!empty($keyword)){
            $map['title'] = ['like',"%{$keyword}%"];
        }
      $blog_list        =  Db::name('document')->field($field)->where($map)->order(['create_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
      $category_list    =   Db::name('category')->column('name','id');

        return array(
            'article_list' => $blog_list,
            'category_list' => $category_list,
            'cid' => $cid, 'keyword' => $keyword
        );

    }

    public function showUser($cid = 0, $keyword = '', $page = 1){
        $map = ["id_name" => $_SESSION["think"]["admin_name"]];
        $field = 'id,title,cid,create_time,wechatname';

        if($cid>0){
//            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }
        if(!empty($keyword)){
            $map['title'] = ['like',"%{$keyword}%"];
        }
        $blog_list        =  Db::name('document')->field($field)->where($map)->order(['create_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list    =   Db::name('category')->column('name','id');

        return array(
            'article_list' => $blog_list,
            'category_list' => $category_list,
            'cid' => $cid, 'keyword' => $keyword
        );

    }

    /*
     * new data for blog
     * */
    public function kk(){

    }





}
