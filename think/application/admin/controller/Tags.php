<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Tags as tagsModel;
use think\Db;
class Tags extends Controller
{
	public function lst()
	{
		$list = tagsModel::paginate(3);
		$this -> assign('list',$list);
		return $this -> fetch('lst');
	}



	public function edit()
	{	
		$id = input('id');
		$tagss = Db::name('tags')->find(input('id'));
		if (request()->isPost()) {
			$data = [
			'id' => input('id'),
			'tagname' => input('tagname'),
			];
			$validate = \think\Loader::validate('tags');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate->getError());
				die;
			}
			$save = Db::name('tags') -> update($data);
			if ($save !== false) {
				return $this -> success('修改标签信息成功！','lst');
			}else{
				return $this -> error('修改标签信息失败！');
			}
		}
		$this -> assign('tagss',$tagss);
		return $this -> fetch('edit');
	}



	public function add()
	{
		if (request() -> isPost()) {
			$data = [
				'id' => input('id'),
				'tagname' => input('tagname'),
				
			];

			$validate = \think\Loader::validate('tags');
			if (!$validate->scene('add')->check($data)) {
				$this -> error($validate->getError());
				die;
			}

			if (Db::name('tags')->insert($data)) {
				return $this -> success('添加标签成功！','lst');
			}else{
				return $this -> error('添加标签失败！');
			}
			return;
		}
		return $this -> fetch('add');
	}



	public function del()
	{
       $id = input('id');
	       if (Db::name('tags')->delete(input('id'))) {
	       		$this -> success('删除标签成功！','lst');
	       }else{
	      	 	$this -> error('删除标签失败！');
	       }
	}



}