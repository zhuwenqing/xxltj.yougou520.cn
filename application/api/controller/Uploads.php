<?php
namespace app\api\controller;

use think\Controller;
use think\Session;

/**
 * 通用上传接口
 * Class Upload
 * @package app\api\controller
 */
class Uploads extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        if (!Session::has('admin_id')) {
            $result = [
                'error'   => 1,
                'message' => '未登录'
            ];

            return json($result);
        }
    }

    /**
     * 通用图片上传接口
     * @return \think\response\Json
     */
    public function upload()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $file = $this->request->file('file');
        // dump($file->getInfo('name'));exit();
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
        $save_path   = '/uploads/';
        $savename = date('Ymd').DS.$file->getinfo('name');
        $pattern = '/[^\x00-\x80]/'; 
        if(preg_match($pattern,$savename)){ 
            return json(['msg'=>'不能含有中文']);
        }
        $info        = $file->validate($config)->move($upload_path,$savename);
        
        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }

        return json($result);
    }

    /**
     * 移动端通用批量图片上传接口
     * @return \think\response\Json
     */
    public function upload_m()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $result = [];
        $file = $this->request->file('file');
        foreach($file as $v){
            $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
            $save_path   = '/uploads/';
            $savename = date('Ymd').DS.$v->getinfo('name');
            $pattern = '/[^\x00-\x80]/'; 
            if(preg_match($pattern,$savename)){ 
                return json(['msg'=>'不能含有中文']);
            }
            $info        = $v->validate($config)->move($upload_path,$savename);
            
            if ($info) {
                $result[] = [
                    'error' => 0,
                    'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
                ];
            } else {
                $result[] = [
                    'error'   => 1,
                    'message' => $v->getError()
                ];
            }
        }
        // dump($file->getInfo('name'));exit();
        return json($result);
    }
    
}