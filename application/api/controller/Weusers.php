<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Weusers extends Controller
{
    public function query_remainder(){
        if($this->request->isPost()){
            $data = $this->request->post();
            //更新用户余额
            $res = Db::name('weusers')->field('remainder')->where('user_id',$data['user_id'])->find();
            //查询用户转发文章
            $art_msg = Db::name('share')
                        ->alias('s')
                        ->field('s.share_time,think_wearticle.*')
                        ->where('user_id',$data['user_id'])
                        ->join('think_wearticle as w','s.article_id = think_wearticle.id')
                        ->select();

            // dump($art_msg);exit();

            return json(['remainder'=>$res['remainder'],'art_msg'=>$art_msg]);
        }
    }

    public function apply_take_cash(){
        if($this->request->isPost()){
            $data = $this->request->post();
            //查询用户余额
            $res = Db::name('weusers')->field('remainder')->where('user_id',$data['user_id'])->find();
            if($data['cash'] > $res['remainder']){
                return json(['status'=>'ok','code'=>3,'msg'=>'超出最大金额']);
            }
            if($data['cash'] - floor($data['cash']) != 0){
                return json(['status'=>'ok','code'=>3,'msg'=>'提现需整数']);
            }
            $remainder = $res['remainder'] - $data['cash'];
            // 启动事务
            Db::startTrans();
            try{
                Db::name('weusers')->where('user_id',$data['user_id'])->update(['remainder'=>$remainder]);
                $takeMoneyMsg = [
                    'user_id'=>$data['user_id'],
                    'take_money'=>$data['cash'],
                    'create_time'=>date('Y-m-d H:i:s'),
                ];
                $info = Db::name('money_log')->insert($takeMoneyMsg);
                // 提交事务
                Db::commit(); 
                if($info){
                    return json(['status'=>'ok','code'=>1,'msg'=>'申请成功']);
                }else{
                    return json(['status'=>'ok','code'=>2,'msg'=>'申请失败']);
                }
            }catch(\Exception $e){
                // 回滚事务
                Db::rollback();
            }
        }
    }

    public function take_money_msg(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $res = Db::name('money_log')->where('user_id',$data['user_id'])->select();
            
            return json(['status'=>'ok','code'=>1,'msg'=>$res]);
        }
    }
}