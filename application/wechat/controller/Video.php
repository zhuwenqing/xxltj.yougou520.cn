<?php
/**
 * Created by PhpStorm.
 * User: aeball
 * Date: 2017/5/13
 * Time: 14:42
 */

namespace app\wechat\controller;

use app\common\controller\HomeBase;
use think\View;
use app\common\model\Video as VideoModel;


/*
 * 视频上传下载专区
 * */
class Video extends HomeBase
{
    protected  $video_model;

    public function _initialize(){
        $this->video_model = new VideoModel();
    }

    /*
     * 显示视频列表
     * */
    public function index(){
        /*
         *
         * */
        $wevideos = $this->video_model->showAllVideo();
//        dump($wevideos);

        return $this->fetch('index', [
            'wevideos' => $wevideos,
        ]);
    }

    public function add(){
        return $this->fetch();
    }


    /*
     * 视频上传
     * */
    public function upload(){

        $mydata =  $this->request->param();

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('video');
        $file_img = request()->file('thumb');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'video');
        $info_img = $file_img->move(ROOT_PATH.'public'.DS.'uploads'.DS.'image');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg    echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg  echo $info->getFilename();
            //写入视频到
            $video_path = '/uploads/video/'.$info->getSaveName();
            $data['path'] = $video_path;
            $data['thumb'] = '/uploads/image/'.$info_img->getSaveName();

            $data['title'] = $mydata['title'];
            $data['create_time'] = time();
            $data['publish_time'] = time();

//            var_dump($data);
           $result = $this->video_model->save($data);
            if($result){
                $this->success('保存成功','Video/index',1);
            }else{
                $this->error('保存失败','Video/add');
            }

        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

    public function upload_img(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
//        dump($file);exit();
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
//            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getFilename();
            //写入视频到
         return   $image_path = '/public/uploads/'.$info->getExtension();

        }else{
            // 上传失败获取错误信息
            return $file->getError();

        }
    }

}