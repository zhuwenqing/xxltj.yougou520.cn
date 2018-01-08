<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use app\common\model\Dmproject as DmprojectModel;
use app\common\model\Products as ProductsModel;
use app\common\model\Category as CategoryModel;

class Dmproject extends AdminBase
{
    protected $dmproject_model;
    protected $products_model;
    protected $category_model;

    protected function _initialize(){
        parent::_initialize();
        $this->dmproject_model = new DmprojectModel();
        $this->products_model  = new ProductsModel();
        $this->category_model = new CategoryModel();
    }

    public function index($keyword = '', $page = 1){
        $map   = [];
        $field = 'id,project_id,name,create_time,remark,email,sort';

        if (!empty($keyword)) {
            $map['name'] = ['like', "%{$keyword}%"];
        }

        $article_list  = $this->dmproject_model->field($field)->where($map)->order(['id' => 'DESC'])->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', [
            'article_list' => $article_list,
            'keyword' => $keyword
        ]);
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }


    /**
     * 保存域名池项目
     */
    public function save(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $data['email'] = str_replace("\r\n",',',$data['email']);
            $data['photo'] = str_replace("\r\n",',',$data['photo']);
            $data['project_id'] = md5(time());
            $result = $this->dmproject_model->insertProject($data);
            if($result){
                $optye = '保存域名池项目';
                add_logs($optye,1);
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
         }

    }

    public function edit($id){
        $info = $this->dmproject_model->where('id',$id)->find();
        $info['email'] = str_replace(',',"\r\n",$info['email']);
        $info['photo'] = str_replace(',',"\r\n",$info['photo']);
        // dump($info['email']);exit();
        $this->assign('project',$info);
        return $this->fetch();
    }

    /**
     * 修改域名池项目
     */
    public function update($id){
        if($this->request->isPost()){
            $data = $this->request->post();
            $data['email'] = str_replace("\r\n",',',$data['email']);
            $data['photo'] = str_replace("\r\n",',',$data['photo']);
            $result = $this->dmproject_model->where('id',$id)->update($data);
            if($result){
                $optye = '修改域名池项目';
                add_logs($optye,2);
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
    }

    /**
     * 删除域名池项目
     */
    public function delete($id){
        $domain = Db::name('pjdomain')->where('pid',$id)->find();
        if($domain){
            $this->error('项目下还有域名，请删除');
        }else{
            $res = $this->dmproject_model->where('id',$id)->delete();
            if($res){
                $optye = '删除域名池项目';
                add_logs($optye,3);
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }


}