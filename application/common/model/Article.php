<?php
namespace app\common\model;

use think\Model;
use think\Session;
use think\Db;

class Article extends Model
{
    protected $insert = ['create_time'];

    /**
     * 文章作者
     * @param $value
     * @return mixed
     */
    protected function setAuthorAttr($value)
    {
        return $value ? $value : Session::get('admin_name');
    }

    /**
     * 反转义HTML实体标签
     * @param $value
     * @return string
     */
    protected function setContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * 序列化photo图集
     * @param $value
     * @return string
     */
    protected function setPhotoAttr($value)
    {
        return serialize($value);
    }

    /**
     * 反序列化photo图集
     * @param $value
     * @return mixed
     */
    protected function getPhotoAttr($value)
    {
        return unserialize($value);
    }

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * show all articles  not category
     * @author rose @date 2017 02 25
     * @return bool|string
     */
    public function showAllArticles(){
        return Db::name('article')->select();
    }

    /*
     * 展示首页列表数据 id cid title introduction reading  thumb publish_time
     * */
    public function showHomeList(){
     //   return Db::name('article')->select('title');
        return Db::query('SELECT id,title,introduction,publish_time,thumb FROM think_article ');
    }

    /*
     * 获取详情数据 根据id指定返回 对应的所有数据
     * @author xiongan  @date 2017 02 26
     * */
    public function showOneArticle($id){
//        return Db::query('SELECT id,title,introduction,publish_time FROM think_article ');
        return Db::name('article')->where(['id'=>$id])->select();
    }

    /*
     * 根据id返回数据
     * @author xiongan  @date 2017 03 03
     * */
    public function showInfoById($id){

    }

    /*
     * 更新sort的值,根据id
     * */
    public function updataSort($id,$sort){
        //  UPDATE think_article SET sort = 1 WHERE id = 9
        return Db::query('UPDATE think_article SET sort =  '.$sort.'  WHERE id = 9');
    }










}