<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Article as ArticleModel;
class Article extends Controller
{
	public function index()
	{
		return $this -> fetch('index');
	}



	public function lst()
	{
		$list = ArticleModel::paginate(4);
		$this -> assign('list',$list);
		return $this -> fetch('lst');
	}



	public function edit()
	{	
		$id = input('id');
		$articles = Db::name('article')->find(input('id'));
		if (request()->isPost()) {
			$data = [
			'id' => input('id'),
			'title' => input('title'),
			'author' => input('author'),
			'keywords' => str_replace('，',',',input('keywords')),
			'cateid' => input('cateid'),
			'state' => input('state'),
			'pic' => input('pic'),
			'desc' => input('desc'),
			'time' => time(),
			'content' => input('content'),
			'click' => '',
			];
			
	        if ($_FILES['pic']['tmp_name']) {
		        $file = request() -> file('pic');
		        $info = $file -> move(ROOT_PATH . 'public' . DS . 'static/uploads');
		        $data['pic'] = '/uploads/'.$info -> getSaveName();
	        }
			$validate = \think\Loader::validate('article');
			if (!$validate -> scene('edit') -> check($data)) {
				$this -> error($validate->getError());
				die;
			}
			$save = Db::name('article') -> update($data);
			if ($save !== false) {
				return $this -> success('修改文章信息成功！','lst');
			}else{
				return $this -> error('修改文章信息失败！');
			}
		}
		$cates = Db::name('cate')->select();
		$this -> assign('cates',$cates);
		$this -> assign('articles',$articles);
		return $this -> fetch('edit');
	}



	public function add()
	{
		if (request() -> isPost()) {
			$data = [
				'title' => input('title'),
				'author' => input('author'),
				'keywords' => str_replace('，',',',input('keywords')),
				'cateid' => input('cateid'),
				'state' => input('state'),
				'pic' => input('pic'),
				'desc' => input('desc'),
				'time' => time(),
				'content' => input('content'),
				'click' => '',
			];
			if ($data['click'] == '') {
				$data['click'] = 0;
			}
			if (input('state') == 'on') {
				$data['state'] = 1;
			}else{
				$data['state'] = 0;
			}
	        if ($_FILES['pic']['tmp_name']) {
		        $file = request() -> file('pic');
		        $info = $file -> move(ROOT_PATH . 'public' . DS . 'static/uploads');
		        $data['pic'] = '/uploads/'.$info -> getSaveName();
	        }

			$validate = \think\Loader::validate('article');
			if (!$validate->scene('add')->check($data)) {
				$this -> error($validate->getError());
				die;
			}

			if (Db::name('article')->insert($data)) {
				return $this -> success('添加文章成功！','lst');
			}else{
				return $this -> error('添加文章失败！');
			}
			return;
		}
		$cates = Db::name('cate')->select();
		$this -> assign('cates',$cates);
		return $this -> fetch('add');
	}



	public function del()
	{
       $id = input('id');
	       if (Db::name('article')->delete(input('id'))) {
	       		$this -> success('删除文章成功！','lst');
	       }else{
	      	 	$this -> error('删除文章失败！');
	       }
	}



}