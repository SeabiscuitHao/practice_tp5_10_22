<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate{

	protected $rule = [
	    'title'  => 'require|max:25|unique:article',
	    'author'   => 'require'
	];
	protected $msg = [
	    'title.require' => '文章名称必须填写',
	    'title.max'     => '文章名称长度最多不能超过25个字符',
	    'author.require' => '文章作者必须填写',
	    'title.unique' => '文章名称不能重复',
	];
	protected $sence = [
		'add'  =>  ['title','author'],
		'edit'  =>  ['title','author'],
	];

}