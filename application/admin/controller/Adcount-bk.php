<?php

namespace app\admin\controller;

use app\common\model\Adcount as AdcountModel;
use app\common\model\Adcategory as CategoryModel;
use app\common\controller\AdminBase;
use think\Db;

class Adcount extends AdminBase
{
    protected $adcount_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->adcount_model = new AdcountModel();
        $this->category_model = new CategoryModel();

        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
    }

    public function index($cid = 4,$page = 1){
        if($cid == 0){
            $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->join('think_adcategory','a.cid = think_adcategory.id')->order('a.sort DESC')->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        }else{
            $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->where('cid',$cid)->join('think_adcategory','a.cid = think_adcategory.id')->order('a.sort DESC')->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        }
        $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));//今天零点
        $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//今天23点59分59秒
        $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        $arr = [];
        foreach($url_list as $k=>$v){
            $map['count_url'] = ['eq',$v['count_url']];
            $totalIp = model('count_detail')->where($map)->count();
            $totalCopyIp = model('count_detail')->where($map)->where('is_copy',1)->count();
            $ipCount = model('count_detail')->where($map)->group('count_ip')->count();
            $ipCopyCount = model('count_detail')->where('is_copy',1)->where($map)->group('count_ip')->count();
            $url_list[$k]['count_ip_num'] = $ipCount;
            $url_list[$k]['count_copy_ip_num'] = $ipCopyCount;
            $url_list[$k]['count_visit'] = $totalIp;
            $url_list[$k]['count_copy_num'] = $totalCopyIp;
            $arr = [
                'count_visit'=>$totalIp,
                'count_copy_num'=>$totalCopyIp,
                'count_ip_num'=>$ipCount,
                'count_copy_ip_num'=>$ipCopyCount,
            ];
            // $this->adcount_model->where('count_url',$v['count_url'])->update($arr);
        }
        
        // dump($url_list);exit();
        $this->assign('url_list',$url_list);
        return $this->fetch('index',['cid'=>$cid]);
    }

    public function add(){
        return $this->fetch();
    }

    public function save(){
        $data = $this->request->post();
        $validate_result = $this->validate($data, 'Adcount');
        if($validate_result !== true){
            $this->error($validate_result);
        }else{
            $result = $this->adcount_model->allowField(true)->save($data);
            if ($result) {
                $this->success('保存成功');
            } else {
                $this->error('保存失败');
            }
        }
    }

    public function detail($count_url,$key_name = '',$keyword = '',$page = 1,$start_time = '',$end_time = '',$is_copy = '',$adcount_time=''){
        $search_list = [
            [
                'name'=>'IP',
                'value'=>'count_ip'
            ],
            [
                'name'=>'微信号',
                'value'=>'copu_wechat'
            ]
        ];
        $map = [];
        $count_url = urldecode($count_url);
        $map['count_url'] = ['eq',$count_url];
        if(!empty($is_copy)){
            $map['is_copy'] = ['eq',1];
        }
        if(!empty($start_time)){
            $startTotime  = strtotime($start_time);
            $endTotime = strtotime($end_time);
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }elseif($adcount_time == 'toDay' && $start_time == ''){//今天
            $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }elseif($adcount_time == 'beforeYesterDay' && $start_time == ''){//前天
            $startTotime=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d')-1,date('Y'))-1;
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }elseif($adcount_time == 'yesterDay' && $start_time == ''){//昨天
            $startTotime=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }else{//默认今天
            $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }

        if (!empty($keyword)) {
            $keyword = trim($keyword);
            $map[$key_name] = ['like', "%{$keyword}%"];
        }
        $count_detail_data = model('count_detail')->where($map)->select();
        // 'key_name='.$key_name.'&keyword='.$keyword."&start_time=".$start_time."&end_time=".$end_time."&is_copy=".$is_copy,
        $count_detail_list = model('count_detail')->where($map)->paginate(15, false, [
            'query'=>[
                'key_name'=>$key_name,
                'keyword'=>$keyword,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
                'is_copy'=>$is_copy,
                'adcount_time'=>$adcount_time,
            ],
            'page' => $page
            ]);
        if(empty($count_detail_list->items())){
            $this->error('没有查询到相关数据');
        }
        

        $copy_count = 0;
        $Ind_ip = [];
        $Ind_copy_ip = [];
        foreach($count_detail_data as $vc){
            if($vc['is_copy'] == 1){
                $copy_count++;
                if(array_key_exists($vc['count_ip'],$Ind_copy_ip)){
                    // dump('haha');exit();
                    $Ind_copy_ip[$vc['count_ip']]++;
                }else{
                    $c = 1;
                    $Ind_copy_ip[$vc['count_ip']] = $c;
                }
            }
            if(array_key_exists($vc['count_ip'],$Ind_ip)){
                // dump('haha');exit();
                $Ind_ip[$vc['count_ip']]++;
            }else{
                $m = 1;
                $Ind_ip[$vc['count_ip']] = $m;
            }
            
        }
        // dump($Ind_copy_ip);exit();
        // dump("总ip量:".count($count_detail_data)."      总复制ip量:".$copy_count."      独立访问ip量:".count($Ind_ip)."      独立访问ip量:".count($Ind_copy_ip));
        $this->assign('ip_count',count($count_detail_data));//总访问ip量
        $this->assign('copy_count',$copy_count);//总复制ip量
        $this->assign('Ind_ip_count',count($Ind_ip));//独立访问ip量
        $this->assign('Ind_copy_ip_count',count($Ind_copy_ip));//独立复制ip量
        $this->assign('count_detail_list',$count_detail_list);
        $this->assign('search_list',$search_list);
        return $this->fetch('detail',[
            'keyword' => $keyword,
            'key_name'=> $key_name,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'is_copy' => $is_copy,
            ]);
    }

    public function wechat_count($count_url,$key_name = '',$keyword = '',$page = 1,$start_time = '',$end_time = '',$is_copy = ''){


        $map = [
            'is_copy'=>1,
        ];
        $count_url = urldecode($count_url);



        if(!empty($start_time)){
            $startTotime  = strtotime($start_time);
            $endTotime = strtotime($end_time);
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }
        if (!empty($keyword)) {
            $keyword = trim($keyword);
            $map[$key_name] = ['like', "%{$keyword}%"];
        }
        $wechatName = model('count_detail')->field('count(*) as count,copu_wechat,id,count_url')->where('count_url',$count_url)->where($map)->group('copu_wechat')->select();
        // var_dump($wechatName);exit();
        if(empty($wechatName)){
            $this->error('没有查询到相关数据');
        }
        
        // dump($wechatName[0]['count_url']);exit();

        $this->assign('wechatName_count',$wechatName);
        return $this->fetch('wechat_count',[
            'keyword' => $keyword,
            'key_name'=> $key_name,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'is_copy' => $is_copy,
        ]);
    }

    function edit($id){
        $data = model('adcount')->where('id',$id)->find();
        $this->assign('urlInfo',$data);
        return $this->fetch();
    }

    function update($id){
        $data = $this->request->post();
        $result = $this->adcount_model->where('id',$id)->update($data);
        if ($result) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败');
        }
    }

    function delete(){
        // dump(urldecode($count_name));
        $del_data = $this->request->param();
        $count_name = $del_data['count_name'];
        $url_name = urldecode($count_name);
        $count_detail = Db::name('count_detail')->where('count_url',$url_name)->select();
        // dump($count_detail);exit();
        if(empty($count_detail)){
            $data_adcount = Db::name('adcount')->where('count_url',$url_name)->delete();
            if($data_adcount){
                $this->success('删除成功');
            }else{
                $this->error('保存失败');
            }
        }else{
            Db::transaction(function(){
                $del_data = $this->request->param();
                $count_name = $del_data['count_name'];
                $url_name = urldecode($count_name);
                $data = Db::name('adcount')->where('count_url',$url_name)->delete();
                $data_detail = Db::name('count_detail')->where('count_url',$url_name)->delete();
                if($data && $data_detail){
                    $this->success('删除成功');
                }else{
                    $this->error('保存失败');
                }
            });
        }
    }

    public function address_count($area = 'province',$keyword='',$start_time = '',$end_time = ''){
        $count_url = $this->request->param('count_url');

        $search_list = [
            [
                'name'=>'省份',
                'value'=>'province'
            ],
            [
                'name'=>'城市',
                'value'=>'city'
            ]
        ];
        if(!empty($start_time)){
            $startTotime  = strtotime($start_time);
            $endTotime = strtotime($end_time);
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }

        if(!empty($keyword)){
            $map[$area] = ['like',"%{$keyword}%"];
        }

        $map['count_url'] = ['eq',urldecode($count_url)];
        
        // $count_detail_data = model('count_detail')->where('count_url',urldecode($count_url))->select();
        $count_ip_arr = model('count_detail')
                        ->field($area.',group_concat(count_ip) as count_ip,count(*) as count')
                        ->where($map)
                        ->group($area)
                        ->select();
        $ip_arr = [];
        foreach($count_ip_arr as $k=>$v){
            $ip_arr = explode(',',$v['count_ip']);
            $ip_arr = array_flip($ip_arr);
            $ip_arr = array_flip($ip_arr);
            $count_ip_arr[$k]['ip_count'] = count($ip_arr);
            
        }
        
        $Ind_ip_arr = model('count_detail')
                    ->field($area.',group_concat(count_ip) as count_ip,count(*) as copy_count')
                    ->where($map)
                    ->where('is_copy',1)
                    ->group($area)
                    ->select();
        $copy_ip_arr = [];
        foreach($Ind_ip_arr as $k2=>$v2){
            $copy_ip_arr = explode(',',$v2['count_ip']);
            $copy_ip_arr = array_flip($copy_ip_arr);
            $copy_ip_arr = array_flip($copy_ip_arr);
            foreach($count_ip_arr as $k3=>$v3){
                if($v2[$area] === $v3[$area]){
                    $count_ip_arr[$k3]['copy_count'] =  $v2['copy_count'];
                    $count_ip_arr[$k3]['ind_count_ip'] =  count($copy_ip_arr);
                }
            }
        }

        // print_r($count_ip_arr);
        // exit();
        $this->assign('count_ip_arr',$count_ip_arr);
        $this->assign('count_url',$count_url);
        $this->assign('search_list',$search_list);
        return $this->fetch('address_count',[
            'area'=>$area,
            'keyword'=>$keyword,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);
    }
}