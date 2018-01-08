<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Pjdomain as PjdomainModel;
use app\common\model\Dmproject as DmprojectModel;
use app\common\model\Products as ProductsModel;
use app\common\model\Category as CategoryModel;

class Pjdomain extends AdminBase
{
    protected $pjdomain_model;
    protected $dmproject_model;
    protected $products_model;
    protected $category_model;

    protected function _initialize(){
        parent::_initialize();
        $this->pjdomain_model = new PjdomainModel();
        $this->dmproject_model = new DmprojectModel();
        $this->products_model  = new ProductsModel();
        $this->category_model = new CategoryModel();
    }

    public function index($id , $keyword = '' , $status = '' , $page = 1){
        $map   = [];
        $map['pid'] = ['eq',$id];
        if (!empty($keyword)) {
            $map['domain'] = ['like', "%{$keyword}%"];
        }

        if($status == 'on'){
            $map['status'] = ['eq',1];
        }

        $article_list  = $this->pjdomain_model->where($map)->order(['id' => 'DESC'])->paginate(15, false, [            
            'query'=>[
                'status'=>$status,
                'keyword'=>$keyword,
        ],'page' => $page]); 
        
        // dump($article_list);exit();
        if(empty($article_list->items())){
            $this->error('无可用域名');
        }
        // dump($article_list);exit();

        return $this->fetch('index', [
            'article_list' => $article_list,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function add($id){
        // dump($id);
        $pjname = $this->pjdomain_model->findPjname($id);
        $this->assign('pjname',$pjname);
        return $this->fetch();
    }

/**
 * 保存项目域名
 */
    public function save(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $domain = explode("\r\n",trim($data['domain']));
            if($data['type'] == 2){
                foreach($domain as $v){
                    //如果有前缀
                    if(strstr($v,'http://',true) != '' || strstr($v,'https://',true) != ''){
                        $this->error('请输入正确的域名');
                    }else if(strstr($v,'http://')){
                        $data['domain'] = substr($v,7);
                    }else if(strstr($v,'https://')){
                        $data['domain'] = substr($v,8);
                    }else{
                        $data['domain'] = $v;
                    }

                    //如果有后缀
                    if(strstr($data['domain'],'?',true)){
                        $data['domain'] = strstr($data['domain'],'?',true);
                    }else if(strstr($data['domain'],'/',true)){
                        $data['domain'] = strstr($data['domain'],'/',true);
                    }
                    $data['jump_url'] = 'http://'.$data['domain'];
                    $result = $this->pjdomain_model->saveDomain($data);
                    if(!$result){
                        $this->error('发生错误');
                    }
                }
                $optye = '保存项目域名';
                add_logs($optye,1);
                $this->success('添加成功');
            }else{
                $this->error('域名作用请选择:跳转域名');
            }
            
            // $result = $this->pjdomain_model->saveDomain($data);
            // if($result){
            //     $this->success('添加成功');
            // }else{
            //     $this->error('添加失败');
            // }
         }

    }

    /**
     * 删除项目域名
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0, $ids = []){
        // $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->pjdomain_model->where('id',$id)->delete()) {
                $optye = '删除项目域名';
                add_logs($optye,2);
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } elseif($ids) {
            $ids = implode(',',$ids);
            if($this->pjdomain_model->where('id','in',$ids)->delete()){
                $optye = '删除项目域名';
                add_logs($optye,2);
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('请选择需要删除的文章');
        }
    }


}