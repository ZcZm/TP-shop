<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 19:25:24
 * @version $Id$
 */
namespace Admin\Controller;

class AttributeController extends CommonController{
	public function index(){
		//查询属性表信息 链表查询tpshop_name字段
		$data = D('Attribute')->alias('a')->field('a.*,t.type_name')->join("left join tpshop_type as t on a.type_id = t.type_id")->select();
		// dump($data);die;
		$this->assign('data',$data);
		$this->display();
	}
	public function add(){

		if(IS_POST){

			$data = I('post.');
			// dump($data);die;
			$res = D('Attribute')->add($data);
			if($res){
				$this->success('添加成功',U('Admin/Attribute/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$data =D('Type')->select();
			$this->assign('data',$data);
			$this->display();
		}
		
	}
}