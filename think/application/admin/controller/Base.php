<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
class Base extends Controller
{
	public function _initialize()
	{
		if (!session('username')) {
			$this -> error('请先登录系统！');
		}
	}
}