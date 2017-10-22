<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Cate as CateModel;
use think\Db;
class Cate extends Controller
{
	public function lst()
	{
		$list = CateModel::paginate(3);
		$this -> assign('list',$list);
		return $this -> fetch('lst');
	}



	public function edit()
	{	
		$id = input('id');
		$cates = Db::name('cate')->find(input('id'));
		if (request()->isPost()) {
			$data = [
			'id' => input('id'),
			'catename' => input('catename'),
			];
			$validate = \think\Loader::validate('cate');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate->getError());
				die;
			}
			$save = Db::name('cate') -> update($data);
			if ($save !== false) {
				return $this -> success('修改栏目信息成功！','lst');
			}else{
				return $this -> error('修改栏目信息失败！');
			}
		}
		$this -> assign('cates',$cates);
		return $this -> fetch('edit');
	}



	public function add()
	{
		if (request() -> isPost()) {
			$data = [
				'id' => input('id'),
				'catename' => input('catename'),
				
			];

			$validate = \think\Loader::validate('cate');
			if (!$validate->scene('add')->check($data)) {
				$this -> error($validate->getError());
				die;
			}

			if (Db::name('cate')->insert($data)) {
				return $this -> success('添加栏目成功！','lst');
			}else{
				return $this -> error('添加栏目失败！');
			}
			return;
		}
		return $this -> fetch('add');
	}



	public function del()
	{
       $id = input('id');
	       if (Db::name('cate')->delete(input('id'))) {
	       		$this -> success('删除栏目成功！','lst');
	       }else{
	      	 	$this -> error('删除栏目失败！');
	       }
	}



}