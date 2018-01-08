<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Share extends Controller
{
    public function save_share_art(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $startTotime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
            $endTotime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);


            
            // dump($userData);exit();
            $map = [
                'user_id'=>['eq',$data['user_id']],
                'article_id'=>['eq',$data['article_id']],
                'share_time'=>['between',[$startTotime,$endTotime]],
            ];
            $is_article = Db::name('share')->where($map)->find();
            if(!$is_article){
                $data['share_time'] = date('Y-m-d H:i:s');
                $res = Db::name('share')->insert($data);
                if($res){
                    $reward = Db::name('wearticle')->field('reward')->where('id',$data['article_id'])->find();
                    $userm = Db::name('weusers')->field('totalmoney,remainder')->where('user_id',$data['user_id'])->find();
        
                    $userData = [
                        'totalmoney'=>$userm['totalmoney'] + $reward['reward'],
                        'remainder'=>$userm['remainder'] + $reward['reward'],
                    ];

                    $uupdate = Db::name('weusers')->where('user_id',$data['user_id'])->update($userData);
                    if($uupdate){
                        return json(['status'=>'ok','code'=>1,'msg'=>'转发成功']);
                    }else{
                        return json(['status'=>'ok','code'=>2,'msg'=>'转发成功,金额添加失败']);
                    }
                }else{
                    return json(['status'=>'ok','code'=>2,'msg'=>'转发失败']);
                }
            }else{
                return json(['status'=>'ok','code'=>3,'msg'=>'已转,明天再来']);
            }

        }
    }
}