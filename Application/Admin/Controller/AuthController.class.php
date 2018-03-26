<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 19:25:24
 * @version $Id$
 */
namespace Admin\Controller;
class AuthController extends CommonController{
	public function index(){

		$data =D('Auth')->select();

		//使用递归函数进行处理
		$data = getTree($data);
		$this->assign('data',$data);
		$this->display();
	}
	//权限新增
	public function add(){
		if(IS_POST){
			$data = I('post.');
			//dump($data);die;
			//添加权限表
			$res = D('Auth')->add($data);
			if($res){
				$this->success('添加成功',U('Admin/Auth/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			//get请求，页面展示
		//查询所有的顶级权限，用于页面下拉列表展示
		$top_all = D('Auth')->where('pid=0')->select();
		$this->assign('top_all',$top_all);
		$this->display();
		}
		
	}
}