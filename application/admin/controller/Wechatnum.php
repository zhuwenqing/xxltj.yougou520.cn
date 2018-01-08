<?php
namespace app\admin\controller;

use think\Db;
use app\common\model\Article as ArticleModel;
use app\common\model\Category as CategoryModel;
use app\common\model\Wechatnum as WechatnumModel;
use app\common\controller\AdminBase;

class Wechatnum extends AdminBase
{
    protected $article_model;
    protected $category_model;
    protected $wechatnum_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->article_model  = new ArticleModel();
        $this->category_model = new CategoryModel();
        $this->wechatnum_model = new WechatnumModel();

        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
    }

    public function index($cid = 0, $keyword = '', $page = 1){
        $wechat_list = $this->wechatnum_model->paginate(4, false, ['page' => $page]);
        foreach($wechat_list as $v){
            $map['visit_time'] = ['between',[$v['start_time'],$v['end_time']]];
            $map['copu_wechat'] = ['eq',$v['wechat_name']];
            $wechat_count = model('count_detail')->where($map)->count();
            $v['wechat_count'] = $wechat_count;
        }
        $this->assign('wechat_list',$wechat_list);



















        $map   = [];
        $field = 'id,title,cid,author,reading,status,publish_time,sort';

        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $article_list  = $this->article_model->field($field)->where($map)->order(['publish_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', [
            'article_list' => $article_list,
            'category_list' => $category_list,
            'cid' => $cid, 'keyword' => $keyword
        ]);
    }

    public function add(){
        return $this->fetch();
    }

    public function save(){
        $data = $this->request->post();
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $wechat_arr = explode("\r\n",trim($data['wechat_name']));
        unset($data['wechat_name']);
        foreach($wechat_arr as $v){
            $data['wechat_name'] = $v;
            $validate_result = $this->validate($data,'Wechatnum');
            if($validate_result !== true){
                $this->error($data['wechat_name'].' '.$validate_result);
                return false;
            }else{
                $result = $this->wechatnum_model->allowField(true)->insert($data);
                if(!$result){
                    $this->success('添加失败');
                    return false;
                }
            }
        }
        $this->success('添加成功',url('admin/wechatnum/index'));
        // dump($data);
    }

    public function edit($id){
        $result = $this->wechatnum_model->where('id',$id)->find();
        $result['email'] = str_replace(",","\r\n",$result['email']); 
        $this->assign('wechatMsg',$result);
        return $this->fetch();
    }

    public function update($id){
        $data = $this->request->post();
        $data['email'] = str_replace("\r\n",",",$data['email']);
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $validate_result = $this->validate($data,'Wechatnumedit');
        // dump($data);exit();
        if($validate_result !== true){
            $this->error($data['wechat_name'].' '.$validate_result);
        }else{
            $result = $this->wechatnum_model->allowField(true)->where('id',$id)->update($data);
            if(!$result){
                $this->success('修改失败');
            }else{
                $this->success('修改成功',url('admin/wechatnum/index'));
            }
        }
    }

    public function delete($id){
        $result = db('wechatnum')->delete($id);
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


}