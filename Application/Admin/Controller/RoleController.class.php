<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 19:25:24
 * @version $Id$
 */
namespace Admin\Controller;

class RoleController extends CommonController{
	public function index(){
		//查询角色表数据
		$data =D('Role')->select();
		$this->assign('data',$data);
		$this->display();
	}

	//为角色分配权限
	public function setauth(){
		if(IS_POST){
			//post请求 表单提交
			$data =I('post.');
			// dump($data);die;
			//修改到角色表中 将$data['id']从数组装换为字符串ids

			$role_auth_ids = implode(',',$data['id']);
			// dump($role_auth_ids);die;
			
			//查询权限基本信息，将控制器和方法名称拼接起来，role_auth_ac字段
			$auth = D('Auth')->where("id in ({$role_auth_ids})")->select();
			$role_auth_ac = '';
			//遍历数据进行拼接
			foreach ($auth as $v) {
				//顶级权限不需要拼接
				if($v['pid']>0){
					$role_auth_ac .= $v['auth_c'] . '-' . $v['auth_a'] . ',';
				}
				
			}
			//去出最后一个逗号
			$role_auth_ac =trim($role_auth_ac,',');
			//组装一条数据
			$row = [
				'role_id' =>$data['role_id'],
				'role_auth_ids'=>$role_auth_ids,
				'role_auth_ac' =>$role_auth_ac 
			];
			// dump($row);
			//修改到角色表中
			$res = D('Role')->save($row);	
			// dump($res);die;
			if(res !==false){
				$this->success('设置成功',U('Admin/Role/index'));
			}else{
				$this->error('设置失败');
			}
		}else{
			//get请求 页面展示
			//接收参数角色id
		$id = I('get.id');
		//查询角色表 获取角色信息（包含拥有的权限ids）
		$role = D('Role')->where(['role_id'=>$id])->find();
		//查询所有的顶级权限
		$top_all = D('Auth')->where("pid=0")->select();
		//差选所有的二级权限
		$second_all = D('Auth')->where("pid>0")->select();
		$this->assign('role',$role);
		$this->assign('top_all',$top_all);
		$this->assign('second_all',$second_all);
		$this->display();
		}
		
	}

	//添加角色
	public function add(){
		if(IS_POST){
			$role_name  = I('post.role_name');
			$res = D('Role')->add(["role_name"=>$role_name]);
			//dump($role_name);die;
			if($res){
				$this->success('添加成功',U('Admin/Role/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
		
	}


	public function edit(){
		if(IS_POST){
			$data =I('post.');
			// dump($data);die;
			// $res = D('Role')->where(['role_id' => $data['id']])->save(['role_name'=>$data['role_name']]);
			$model = D('Role');
			$model->create($data);
			$res = $model->where(['role_id' => $data['id']])->save();

			if($res){
				$this->success('修改成功',U('Admin/Role/index'));
			}else{
				$this->error('修改失败');
			}
		}else{
			$id = I('get.id');
		$role = D('role')->where(['role_id'=>$id])->find();
		// dump($role);die;
		$this->assign('role',$role);
		$this->display();
		}
		
	}
	public function del(){
		// echo 1;die;
		$id = I('get.id');
		$res = D('Role')->delete($id);
		if($res){
				$this->success('删除成功',U('Admin/Role/index'));
			}else{
				$this->error('删除失败');
			}
	}
}