<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 19:25:24
 * @version $Id$
 */
namespace Admin\Controller;

class TypeController extends CommonController{
	public function index(){
			$data=D('Type')->select();
			// dump($data);die;
			$this->assign('data',$data);
		$this->display();
	}

	//商品类型新增
	public function add(){

		if(IS_POST){
			//post请求
			$data = I('post.');
			//参数合法性检测
			if(empty($data['type_name'])){
				$this->error('类型不能为空');
			}

			//实例化一个模型
			$res = D('Type')->add($data);
			if($res){
				$this->success('添加成功',U('Admin/Type/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			//查询商品类型表所有的数据

			$this->display();
		}
		
	}
}