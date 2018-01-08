<?php

namespace app\common\model;

use think\Model;

class Weditor extends Model
{
	protected $insert = ['create_time'];

	protected function setCreateTimeAttr(){
		return time();
	}
}