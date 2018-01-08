<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use app\common\model\Record as RecordModel;
use app\common\model\Adcategory as CategoryModel;


class Record extends AdminBase
{
    protected $record_model;
    protected $category_model;

    public function _initialize(){
        parent::_initialize();
        $this->category_model = new CategoryModel();
        $this->record_model = new RecordModel();
        $category_level_list  = $this->category_model->getLevelList(2);
        $this->assign('category_level_list', $category_level_list);
    }

    public function index($keyword = '',$channel = '',$start_time = '',$end_time = ''){
        $map = [];
        if($channel != '')
            $map['channel'] = ['eq',$channel];
        if($keyword != '')
            $map['media|main'] = ['like',"%".$keyword."%"];

        if(empty($end_time) && empty($start_time) && empty($keyword) && empty($channel)){
            $map['end_time'] = ['like',"%".date('Y-m-d')."%"];
        }elseif(!empty($start_time) && !empty($end_time)){
            $map['end_time'] = ['between',[substr($start_time,0,10),substr($end_time,0,10)]];
        }elseif(!empty($start_time)){
            $map['end_time'] = ['egt',substr($start_time,0,10)];
        }elseif(!empty($end_time)){
            $map['end_time'] = ['like',"%".substr($end_time,0,10)."%"];
        }
        
        
        $result = $this->record_model
                        ->alias('r')
                        ->field('r.*,think_adcategory.name')
                        ->join('think_adcategory','r.channel = think_adcategory.id')
                        ->where($map)
                        ->select();
        $summation = [
            'summation_seat'=>0,//全部总坐席
            'summation_inline'=>0,//全部总进线
            'summation_deal_num'=>0,//全部总成交单数
            'summation_deal_price'=>0,//全部总成交金额
            'summation_actual_adv_cost'=>0,//全部总实际广告费
            'summation_service_cost'=>0,//全部总服务费
            'summation_adv_cost'=>0,//全部总广告费
            'summation_production_ratio'=>0,//全部总投产比
        ];
                        
        if(empty($result)){
            $arr = [];
        }else{

            foreach($result as $val){
                $summation['summation_seat'] += $val['seat'];
                $summation['summation_inline'] += $val['inline'];
                $summation['summation_deal_num'] += $val['deal_num'];
                $summation['summation_deal_price'] += $val['deal_price'];
                $summation['summation_actual_adv_cost'] += $val['actual_adv_cost'];
                $summation['summation_service_cost'] += $val['service_cost'];
                $summation['summation_adv_cost'] += $val['adv_cost'];
                $summation['summation_production_ratio'] = round($summation['summation_deal_price'] / $summation['summation_adv_cost'],2);
    
                $key = substr($val['end_time'],0,10);
                $arr[$key]['data_result'][] = $val;
                if(!array_key_exists('total_seat',$arr[$key])){
                    $arr[$key]['total_seat'] = $val['seat'];
                    $arr[$key]['total_inline'] = $val['inline'];
                    $arr[$key]['total_deal_num'] = $val['deal_num'];
                    $arr[$key]['total_deal_price'] = $val['deal_price'];
                    $arr[$key]['total_actual_adv_cost'] = $val['actual_adv_cost'];
                    $arr[$key]['total_service_cost'] = $val['service_cost'];
                    $arr[$key]['total_adv_cost'] = $val['adv_cost'];
                }else{
                    $arr[$key]['total_seat'] += $val['seat'];//每天总坐席
                    $arr[$key]['total_inline'] += $val['inline'];//每天总进线
                    $arr[$key]['total_deal_num'] += $val['deal_num'];//每天总成交单数
                    $arr[$key]['total_deal_price'] += $val['deal_price'];//每天总成交金额
                    $arr[$key]['total_actual_adv_cost'] += $val['actual_adv_cost'];//每天总实际广告费
                    $arr[$key]['total_service_cost'] += $val['service_cost'];//每天总服务费
                    $arr[$key]['total_adv_cost'] += $val['adv_cost'];//每天总广告费
                }
                $arr[$key]['total_production_ratio'] = round($arr[$key]['total_deal_price'] / $arr[$key]['total_adv_cost'],2);//每天总投产比
            }
        }


        // dump($summation);
        // exit();
        $this->assign('summation',$summation);
        $this->assign('results',$arr);
        return $this->fetch('index',['keyword'=>$keyword,'start_time'=>$start_time,'end_time'=>$end_time]);
    }

    public function add(){
        return $this->fetch();
    }

    public function save(){
        if($this->request->isPost()){
            $data = $this->request->post();
            //对接人
            $data['pick_up'] = session('admin_nickname');
            $data['admin_id'] = session('admin_id');
            //均线价是广告费除于进线 注：不是实际广告费
            if($data['inline'] == 0){
                $data['average_inline_price'] = 0;
            }else{
                $data['average_inline_price'] = round($data['adv_cost'] / $data['inline'],2);
            }
            //均单价是开单金额除于成单数
            if($data['deal_num'] == 0){
                $data['average_deal_price'] = 0;
            }else{
                $data['average_deal_price'] = round($data['deal_price'] / $data['deal_num'],2);
            }
            //服务费是广告费减实际广告费
            $data['service_cost'] = $data['adv_cost'] - $data['actual_adv_cost'];
            //投产比是开单金额除于广告费
            $data['production_ratio'] = round($data['deal_price'] / $data['adv_cost'],2);
            $result = $this->record_model->allowField(true)->save($data);
            if($result){
                $this->success('记录成功');
            }else{
                $this->error('记录失败');
            }
        }
    }

    public function edit($id){
        $record = $this->record_model->where('id',$id)->find();
        $this->assign('record',$record);
        return $this->fetch();
    }

    public function update($id){
        if($this->request->isPost()){
            $data = $this->request->post();
            //对接人
            $data['pick_up'] = session('admin_nickname');
            //均线价是广告费除于进线 注：不是实际广告费
            $data['average_inline_price'] = round($data['adv_cost'] / $data['inline'],2);
            //均单价是开单金额除于成单数
            if($data['deal_num'] == 0){
                $data['average_deal_price'] = 0;
            }else{
                $data['average_deal_price'] = round($data['deal_price'] / $data['deal_num'],2);
            }
            //服务费是广告费减实际广告费
            $data['service_cost'] = $data['adv_cost'] - $data['actual_adv_cost'];
            //投产比是开单金额除于广告费
            $data['production_ratio'] = round($data['deal_price'] / $data['adv_cost'],2);
            $result = $this->record_model->allowField(true)->where('id',$id)->update($data);
            if($result){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
    }   
}