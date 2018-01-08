<?php

namespace app\admin\controller;

use app\common\model\Adcount as AdcountModel;
use app\common\model\Adcategory as CategoryModel;
use app\common\model\Advdata as AdvdataModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Cache\driver\Redis;

class OldAdcount extends AdminBase
{
    protected $adcount_model;
    protected $advdata_model;


    protected function _initialize()
    {
        parent::_initialize();
        $this->adcount_model = new AdcountModel();
        $this->category_model = new CategoryModel();
        $this->advdata_model = new AdvdataModel();

        $category_level_list = $this->category_model->getLevelList();
        $auth_user = model('admin_user')->where('status',1)->select();
        $this->assign('auth_user',$auth_user);
        $this->assign('category_level_list', $category_level_list);
    }


    public function insertIndexSql(){
        // $redis = new Redis();
        // $is_clear = $redis->clear();
        // if($is_clear){
            $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->join('think_adcategory','a.cid = think_adcategory.id')->order('a.sort DESC')->select();
            $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));//今天零点
            $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//今天23点59分59秒
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
            $arr = [];
            foreach($url_list as $k=>$v){
                $map['count_url'] = ['eq',$v['count_url']];
                $totalIp = Db::name('count_detail_'.TIME_PREFIX)->where($map)->count();
                $totalCopyIp = Db::name('count_detail_'.TIME_PREFIX)->where($map)->where('is_copy',1)->count();
                $ipCount = Db::name('count_detail_'.TIME_PREFIX)->where($map)->group('count_ip')->count();
                $ipCopyCount = Db::name('count_detail_'.TIME_PREFIX)->where('is_copy',1)->where($map)->group('count_ip')->count();
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
                $this->adcount_model->where('count_url',$v['count_url'])->update($arr);
            }
            // $redis->set('url_list',$url_list);
            // dump($url_list);
        //     return "成功";
        // }else{
        //     return "失败";
        // }
        
    }



    public function index($cid = 4,$page = 1,$keyword = '',$ad_order = 'sort'){

        // dump(session('admin_id'));exit();
        $admin_id = session('admin_id');
        $group_access = model('auth_group_access')->where('uid',$admin_id)->find();
        $map = [];
        if($group_access['group_id'] !== 1){
            $map['uid']=['eq',$admin_id];
        }

        if(!empty($keyword)){
            $map['count_url']=['like','%'.$keyword.'%'];
            $cid = 0;
        } 
        if($cid == 0){
            $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->where($map)->join('think_adcategory','a.cid = think_adcategory.id')->order("a.".$ad_order." DESC")->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        }else{
            $url_list = $this->adcount_model->alias('a')->field('a.*,think_adcategory.name')->where('cid',$cid)->where($map)->join('think_adcategory','a.cid = think_adcategory.id')->order("a.".$ad_order." DESC")->paginate(13,false,['page'=>$page,'query'=>['cid'=>$cid]]);
        }
        $this->assign('url_list',$url_list);
        return $this->fetch('index',['cid'=>$cid,'keyword'=>$keyword]);
    }

    public function add(){
        
        return $this->fetch();
    }

    //保存统计域名
    public function save(){
        $data = $this->request->post();
        $validate_result = $this->validate($data, 'Adcount');
        if($validate_result !== true){
            $this->error($validate_result);
        }else{
            $result = $this->adcount_model->allowField(true)->save($data);
            if ($result) {
                $optye = '保存统计域名- '.$data['count_url'];
                add_logs($optye,1);
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

        $count_url = base64_decode($count_url);
        
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
        $count_detail_data = Db::name('count_detail_'.TIME_PREFIX)->where($map)->select();
        // 'key_name='.$key_name.'&keyword='.$keyword."&start_time=".$start_time."&end_time=".$end_time."&is_copy=".$is_copy,
        $count_detail_list = Db::name('count_detail_'.TIME_PREFIX)->where($map)->order('visit_time desc')->paginate(15, false, [
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
        $this->assign('excel_data',base64_encode(serialize($map)));
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
        $count_url = base64_decode($count_url);



        if(!empty($start_time)){
            $startTotime  = strtotime($start_time);
            $endTotime = strtotime($end_time);
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
        $wechatName = Db::name('count_detail_'.TIME_PREFIX)->field('count(*) as count,copu_wechat,id,count_url')->where('count_url',$count_url)->where($map)->group('copu_wechat')->select();
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

    //更新统计域名
    function update($id){
        $data = $this->request->post();
        $result = $this->adcount_model->where('id',$id)->update($data);
        if ($result) {
            $count_url_log = $this->adcount_model->where('id',$id)->find();
            $optye = '更新统计域名- '.$count_url_log['count_url'];
            add_logs($optye,2);
            $this->success('保存成功');
        } else {
            $this->error('保存失败');
        }
    }

    //删除统计域名
    function delete(){
        // dump(urldecode($count_name));
        $del_data = $this->request->param();
        $count_name = $del_data['count_name'];
        $url_name = base64_decode($count_name);
        $count_detail = Db::name('count_detail_'.TIME_PREFIX)->where('count_url',$url_name)->select();
        if(empty($count_detail)){
            $data_adcount = Db::name('adcount')->where('count_url',$url_name)->delete();     
            if($data_adcount){
                $optye = '删除统计域名- '.$url_name;
                add_logs($optye,3);
                $this->success('删除成功');
            }else{
                $this->error('保存失败');
            }
        }else{
            Db::transaction(function(){
                $del_data = $this->request->param();
                $count_name = $del_data['count_name'];
                $url_name = base64_decode($count_name);
                $data = Db::name('adcount')->where('count_url',$url_name)->delete();
                $data_detail = Db::name('count_detail_'.TIME_PREFIX)->where('count_url',$url_name)->delete();
                if($data && $data_detail){
                    $optye = '删除统计域名- '.$url_name;
                    add_logs($optye,3);
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
        }else{//默认今天
            $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $map['visit_time'] = ['between',[$startTotime,$endTotime]];
        }

        if(!empty($keyword)){
            $map[$area] = ['like',"%{$keyword}%"];
        }

        $map['count_url'] = ['eq',base64_decode($count_url)];
        
        // $count_detail_data = Db::name('count_detail_'.TIME_PREFIX)->where('count_url',urldecode($count_url))->select();
        $count_ip_arr = Db::name('count_detail_'.TIME_PREFIX)
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
        
        $Ind_ip_arr = Db::name('count_detail_'.TIME_PREFIX)
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

        /** 
     * 创建(导出)Excel数据表格 
     * @param  array   $list        要导出的数组格式的数据 
     * @param  string  $filename    导出的Excel表格数据表的文件名 
     * @param  array   $indexKey    $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值) 
     * @param  array   $startRow    第一条数据在Excel表格中起始行   
     * @param  [bool]  $excel2007   是否生成Excel2007(.xlsx)以上兼容的数据表 
     * 比如: $indexKey与$list数组对应关系如下: 
     *     $indexKey = array('id','username','sex','age'); 
     *     $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24)); 
     */  
    function exportExcel($filename = '',$startRow=1,$excel2007=false){  
        //文件引入  
        require_once EXTEND_PATH .'excel/PHPExcel/IOFactory.php';  
        require_once EXTEND_PATH.'excel/PHPExcel.php';  
        require_once EXTEND_PATH.'excel/PHPExcel/Writer/Excel2007.php'; 
        
        $list = $this->request->post();
        $map = unserialize(base64_decode($list['list']));
        $count_detail_list = Db::name('count_detail_'.TIME_PREFIX)->field('count_ip,copu_wechat,copy_time,origin_keyword,visit_time,country,province,city')->where($map)->order('visit_time desc')->select();
        
          
        $indexKey = array('count_ip','copu_wechat','copy_time','origin_keyword','visit_time','address'); 
        $list_data = array(array('count_ip'=>'用户ip','copu_wechat'=>'复制微信号','copy_time'=>'复制时间','origin_keyword'=>'复制来源关键词','visit_time'=>'访问时间','address'=>'访问地区')); 
        foreach($count_detail_list as $v){
            $list_data[] = $v;
        }
    
    
    
        // dump($list_data);exit();
    
        if(empty($filename)) $filename = $map['count_url'][1];  
        if( !is_array($indexKey)) return false;  
    
        $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');  
        //初始化PHPExcel()
        $objPHPExcel = new \PHPExcel();  
        
        //设置保存版本格式  
        if($excel2007){  
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);  
            $filename = $filename.'.xlsx';  
        }else{  
            $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);  
            $filename = $filename.'.xls';  
        }  

          
        //接下来就是写数据到表格里面去  
        $objActSheet = $objPHPExcel->getActiveSheet();  
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray(array('font' => array ('bold' => true)));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setSize(13);
    
        //$startRow = 1;  
        foreach ($list_data as $k=>$row) {
            if($k !== 0){
                $row['visit_time'] = date('Y-m-d H:i:s',$row['visit_time']);
                
                if($row['copy_time'] != ''){
                    $row['copy_time'] = date('Y-m-d H:i:s',$row['copy_time']);
                }

                $row['address'] = $row['country'].' '.$row['province'].' '.$row['city'];
                unset($row['country']);
                unset($row['province']);
                unset($row['city']);
            }
            
            foreach ($indexKey as $key => $value){
                //这里是设置单元格的内容  
                $objActSheet->setCellValue($header_arr[$key].$startRow,$row[$value]);  
            }  
            $startRow++;
        }  
          
        // 下载这个表格，在浏览器输出  
        header("Pragma: public");  
        header("Expires: 0");  
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
        header("Content-Type:application/force-download");  
        header("Content-Type:application/vnd.ms-execl");  
        header("Content-Type:application/octet-stream");  
        header("Content-Type:application/download");;  
        header('Content-Disposition:attachment;filename='.$filename.'');  
        header("Content-Transfer-Encoding:binary");  
        $objWriter->save('php://output');  
        }


    //进线页面

    public function add_advdata($cid){
        if($this->request->isPost()){
            $data = $this->request->post();
            $data['cid'] = $cid;
            $res = $this->advdata_model->save($data);
            if($res){
                $this->success('添加成功');
            }else{
                $this->success('添加失败');
            }
        }
        // $this->advdata_model
        // echo $cid;
    }

    public function advdata_page($count_url,$start_time = '',$end_time = ''){
        $count_url = base64_decode($count_url);
        $adcount_data = $this->adcount_model->field('id')->where('count_url',$count_url)->find();

        $map = [];

        if(!empty($start_time)){
            $startTotime  = strtotime($start_time);
            $endTotime = strtotime($end_time);
            $map['create_time'] = ['between',[$startTotime,$endTotime]];
        }else{//默认今天
            $startTotime=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endTotime=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $map['create_time'] = ['between',[$startTotime,$endTotime]];
        }

        $adv_data = $this->advdata_model->where('cid',$adcount_data['id'])->where($map)->select();

        //进线
        $inline = [];
        //点击量
        $click = [];
        foreach($adv_data as $v){
            if($v['type'] == 1){
                //进线
                $inline[] = $v;
            }elseif($v['type'] == 2){
                //点击量
                $click[] = $v;
            }
        }
        // dump($click);exit();
        $this->assign('count_url',$count_url);
        $this->assign('inline',$inline);
        $this->assign('click',$click);


        return $this->fetch('advdata_page',[
            'start_time'=>$start_time,
            'end_time'=>$end_time,
        ]);
    }
}