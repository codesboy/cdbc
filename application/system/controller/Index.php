<?php
namespace app\system\controller;
// use think\Controller;
use app\system\model\Menu;
// use app\index\model\AddForm;
class Index extends Base
{
	public function index()
	{
		$menu=new Menu();
		$json=$menu->getmenu();
		// return $json;
		// dump($json);
		$this->assign('json',$json);
		// return $this->fetch('public/left2');
		// return $this->fetch('index');
		return $this->fetch();
	}




}