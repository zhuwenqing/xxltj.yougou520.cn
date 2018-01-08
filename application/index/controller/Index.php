<?php
namespace app\index\controller;

use app\common\controller\HomeBase;  // model
use think\Db;                       // db
use app\common\model\Article as ArticleModel;
use app\common\model\Adcount as AdcountModel;
use think\View;
use app\api\controller\Ip as IpLocation;

class Index extends HomeBase
{
    /*
     * 微转测试
     * */
    public  function ski(){
        return $this->fetch();
    }


    /*
     *
     * */
    public function index()
    {
        // echo 'heladfadfo';
        return $this->fetch('mbaidu');
        // if(is_mobile()){
        //     echo 'ismobile';
        //     return $this->fetch('mbaidu');
        // }else{
        //     echo 'isnotmobile';
        //     return $this->fetch('index');
        // }
    }

    /*
    虚拟的搜索搜索页面
    */
    public function show()
    {
        return $this->fetch('show');
    }

    /*
  测试屏蔽地域和PC端访问
                * */
    public function test(){
//        $is_mobile = is_mobile();
        if(is_mobile()){
            echo ' is mobile';
            // 如果是手机端那么久判断是否是这些地区   北上广
            $location = new IpLocation() ;
            $myip  = $location->getIP();
            $mylocation = $location->getlocation($myip);
            $mycity = $mylocation['country'];
            var_dump($mycity);
            if(strstr($mycity,'广州') || strstr($mycity,'北京')){
                // 打开审核页
                echo '打开审核页';
                return $this->fetch('hzcheck');
            }else{
                echo '不是广州打开加粉页';
                return $this->fetch('test');
            }
        }else{
            // 显示审核页
           // echo 'is not mobile';
            return $this->fetch('hzcheck');
        }

//
    }

    public function house(){
        return $this->fetch();
    }

    public function insertIndexSql(){
        $this->adcount_model = new AdcountModel();
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
                $this->adcount_model->where('count_url',$v['count_url'])->update($arr);
            }
            // $redis->set('url_list',$url_list);
            // dump($url_list);
        //     return "成功";
        // }else{
        //     return "失败";
        // }
        
    }


}
