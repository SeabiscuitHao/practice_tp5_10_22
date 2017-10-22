<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Admin extends Controller
{
	public function index()
	{
		return $this -> fetch('index');
	}



	public function lst()
	{
		$list = Db::name('admin') -> order('id') -> paginate(4);
		$this -> assign('list',$list);
		return $this -> fetch('lst');
	}



	public function edit()
	{	
		$id = input('id');
		$admins = Db::name('admin')->find(input('id'));
		if (request()->isPost()) {
			$data = [
			'id' => input('id'),
			'username' => input('username'),
			];
			if (input('password')) {
				$data['password'] = input('password');
			}else{
				$data['password'] = $admins['password'];
			}

			$validate = \think\Loader::validate('Admin');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate->getError());
				die;
			}
			$save = Db::name('admin') -> update($data);
			if ($save !== false) {
				return $this -> success('修改管理员信息成功！','lst');
			}else{
				return $this -> error('修改管理员信息失败！');
			}
		}
		
		$this -> assign('admins',$admins);
		return $this -> fetch('edit');
	}




	public function add()
	{
		if (request() -> isPost()) {
			$data = [
				'username' => input('username'),
				'password' => input('password'),
			];
			$validate = \think\Loader::validate('Admin');
			if (!$validate->scene('add')->check($data)) {
				$this -> error($validate->getError());
				die;
			}
			if (Db::name('admin')->insert($data)) {
				return $this -> success('添加管理成功！','lst');
			}else{
				return $this -> error('添加管理员失败！');
			}
			return;
		}
		return $this -> fetch('add');
	}



	public function del()
	{
       $id = input('id');
       if ($id != 1) {
	       if (Db::name('admin')->delete(input('id'))) {
	       		$this -> success('删除管理员成功！','lst');
	       }else{
	      	 	$this -> error('删除管理员失败！');
	       }
       }else{
   			return $this -> error('初始化管理员不能删除！');
       }
	}

	public function logout()
	{
		session(null);
		return $this -> success('退出成功！','Login/index');
	}

}