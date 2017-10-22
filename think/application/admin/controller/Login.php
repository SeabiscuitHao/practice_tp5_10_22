<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin;
class Login extends Controller
{
	public function index()
	{
		if (request() -> isPost()) {
			$admin = new Admin();
			$data = input('post.');
			$num = $admin -> login($data);
			if ($num == 3) {
				$this -> success('登陆成功！等待跳转...','index/index');
			}elseif($num == 4){
				$this -> error('验证码不正确！');
			}else{
				$this -> error('用户信息不正确！');
			}
		}
		return $this -> fetch('login');
	}
}