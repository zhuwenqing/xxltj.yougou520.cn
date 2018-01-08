<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Changewx as ChangewxModel;
use app\common\model\ChangeWechat as ChangeWechatModel;
use app\common\model\Adcategory as CategoryModel;
use think\Db;

class Changewx extends AdminBase
{

    protected $changewx_model;
    protected $changewechat_model;
    protected $category_model;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->changewx_model = new ChangewxModel();
        $this->category_model = new CategoryModel();
        $this->changewechat_model = new ChangeWechatModel();

        $category_level_list = $this->category_model->getLevelList();
        $auth_user = model('admin_user')->where('status',1)->select();
        $this->assign('auth_user',$auth_user);
        $this->assign('category_level_list', $category_level_list);
    }


    public function index($cid = 0,$page = 1,$keyword = ''){
        $admin_id = session('admin_id');
        $group_access = model('auth_group_access')->where('uid',$admin_id)->find();
        $map = [];
        if($group_access['group_id'] !== 1){
            $map['uid']=['eq',$admin_id];
        }

        if(!empty($keyword)){
            $map['change_url|remark|code']=['like','%'.$keyword.'%'];
            $cid = 0;
        }
        
        if($cid == 0){
            $url_list = $this->changewx_model->change_wehcat_list($page,$map);
            // dump($url_list[2]);exit();
        }else{
            // $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->where('cid',$cid)->where($map)->join('think_adcategory','a.cid = think_adcategory.id')->order('a.sort DESC')->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        }
        $this->assign('url_list',$url_list);
        return $this->fetch('index',['cid'=>$cid,'keyword'=>$keyword]);
    }


    public function add($id = ''){
        if($id != ''){
            $cgurl = Db::name('adcount')->where('id',$id)->find();
            $this->assign('change_url',$cgurl['count_url']);
        }else{
            $this->assign('change_url','');
        }
        $water_imgs = Db::name('water_img')->where('status',1)->select();
        $this->assign('water_imgs',$water_imgs);
        return $this->fetch();
    }

    //保存微信号名单
    public function save(){
        // $image_qrcode = \think\Image::open('static/images/poster/qrcode.png');
        // $image_qrcode->thumb(480, 480,6)->save('static/images/poster/thumb.png');
        // $image = \think\Image::open('static/images/poster/2.jpg');
        // $image->water('static/images/poster/thumb.png',['272','977'])->save('static/images/poster/water_image.png'); 
        // dump($image);exit();
        $data = $this->request->post();
        if($data){
            if($data['wid'] == 2){
                // if(count(explode("\n",trim($data['change_name']))) !== count($data['qrcode_path'])){
                //     $this->error('微信号和二维码数量不对应');
                // }
                $data['change_name'] = serialize(explode("\n",trim($data['change_name'])));
                $data['qrcode_path'] = serialize($data['qrcode_path']);
                $data['create_time'] = date('Y-m-d H:i:s');
            }elseif($data['wid'] == 1){
                $data['change_name'] = serialize(explode("\n",trim($data['change_name'])));
                $data['create_time'] = date('Y-m-d H:i:s');
            }
            // dump($data);exit();
            $code = md5(base64_encode($data['change_url'].$data['create_time']));
            $data['code'] = $code;
            // dump($data);exit();
            $validate_result = $this->validate($data,'Changewx');            
            if($validate_result !== true){
                $this->error($validate_result);
            }else{
                // $result = Db::name('change_wechat')->insert($data);
                $result = $this->changewechat_model->allowField(true)->insertGetId($data);
                // dump($result);
                if($result){
                    $optye = '保存微信号名单- '.$data['remark'];
                    add_logs($optye,1);
                    $this->success('添加成功',url('admin/changewx/detail',array('id'=>$result)));
                }else{
                    $this->success('添加失败');
                }
            }
        }
    }

    public function edit($id){
        $result = $this->changewx_model->change_wechat_find_one($id);
        // $result['change_name'] = implode("\r\n",unserialize($result['change_name'])); 
        // dump($result);exit();
        $water_imgs = Db::name('water_img')->where('status',1)->select();
        $this->assign('water_imgs',$water_imgs);
        $this->assign('urlInfo',$result);
        return $this->fetch();
    }

    //更新微信号名单
    public function update($id){
        if($this->request->isPost()){
            $data            = $this->request->param();
            if($data['wid'] == 2){
                $data['change_name'] = serialize(explode("\n",trim($data['change_name'])));
                $data['qrcode_path'] = serialize($data['qrcode_path']);
                $data['create_time'] = date('Y-m-d H:i:s');
            }elseif($data['wid'] == 1){
                $data['change_name'] = serialize(explode("\n",trim($data['change_name'])));
                $data['create_time'] = date('Y-m-d H:i:s');
            }
            $validate_result = $this->validate($data,'Changewx');
            if($validate_result !== true){
                $this->error($validate_result);
            }else{
                $result = Db::name('change_wechat')->where('id',$id)->update($data);
                if($result){
                    $optye = '更新微信号名单- '.$data['remark'];
                    add_logs($optye,2);
                    $this->success('修改成功','admin/changewx/index');
                }else{
                    $this->success('修改失败');
                }
            }
            
        }
    }

    //删除微信号名单
    public function delete($id){
        $result = Db::name('change_wechat')->where('id',$id)->update(['status'=>0]);
        
        if($result){
            $data = Db::name('change_wechat')->where('id',$id)->find();
            $optye = '删除微信号名单- '.$data['remark'];
            add_logs($optye,3);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //查看代码
    public function detail($id){
        $data = Db::name('change_wechat')->field('code')->where('id',$id)->find();
        $this->assign('code',$data['code']);
        return $this->fetch();
    }
}