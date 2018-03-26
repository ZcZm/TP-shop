<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 16:51:34
 * @version $Id$
 */
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{
	//后台首页
	public function index(){
		$beijing = ['20.5', '10', '20', '15'];
		foreach($beijing as $k => &$v){
			//数据类型转换
			$v = (float)$v;
			//$beijing[$k] = (int)$v;
		}
		$beijing_json = json_encode($beijing);
		// var_dump($beijing_json);
		// echo $beijing_json;die;
		$this->assign('beijing',$beijing_json);
		//调用模版
		$this->display();
	}
}

