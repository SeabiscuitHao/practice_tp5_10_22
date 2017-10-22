<?php
namespace app\index\controller;
use think\Db;
use app\index\controller\Base;
class Index extends Base
{
    public function index()
    {
        $articleres = Db::name('article') -> order('id desc') -> paginate(4);
        $this -> assign('articleres',$articleres);
        return $this -> fetch('index');
    }
}
