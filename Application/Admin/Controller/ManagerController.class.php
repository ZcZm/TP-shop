<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 17:11:29
 * @version $Id$
 */
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends CommonController{
	//管理员列表页
	public function index(){
		//调用模版
		$model = D('Manager');
		$data = $model->select();
		$this->assign('data',$data);
		$this->display();
	}
	public function add(){
		$this->display();
	}
	public function edit(){
		$this->display();
	}
	public function del(){
		
	}
}
