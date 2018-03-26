<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-21 16:06:11
 * @version $Id$
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{

		//构造方法
	public	function __construct(){
		//实现父类的构造方法
			parent::__construct();
			if(!session('?manager_info')){
				//没有登录，跳转登录页
				$this->redirect('Admin/Login/login');
			}
			$this->getauth();

			$this->checkauth();
		}

	//查询当前登录管理原拥有的菜单权限
	public function getauth(){
		if(session('?top')&&session('?second')){
			return;//打开，只查询一次； 注释此行，每次都查询数据表
		}

		//从session中获取管理员信息 role_id
		//$info = session('manager_info');
		//$role_id = $info['role_id'];
		$role_id = session('manager_info.role_id');

		//根据role_id 查询拥有的权限
		//特殊情况 超级管理员
		if($role_id ==1){
			//直接查询权限表  分别查询顶级权限和二级权限
			//查询所有的顶级权限
			$top = D('Auth') ->where('pid = 0 and is_nav = 1') -> select();
			//查询所有的二级权限
			$second = D('Auth') -> where("pid > 0 and is_nav = 1") -> select();
		}else{
			//不是超级管理员，根据role_id 查询角色表 获取role_auth_ids值
			$role = D('Role') ->where(['role_id' => $role_id]) ->find();
			//根据role_auth_ids值 查询权限表，使用where in 条件
			$role_auth_ids = $role['role_auth_ids'];
			//查询所拥有的顶级权限
			$top = D('Auth')->where("id in ({$role_auth_ids}) and pid=0 and is_nav = 1")->select();
			//查询所拥有的二级权限
			$second=D('Auth')->where("id in ({$role_auth_ids}) and pid>0 and is_nav = 1")->select();

		}
		session('top',$top);
		session('second',$second);

		// $this -> assign('top', $top);
		// $this -> assign('second', $second);
	}
	
	//权限检测
	public function checkauth(){
		// dump($c);
		// dump($a);die;
		//从session获取登录用户的role_id
		$role_id = session('manager_info.role_id');

		//超级管理员不用坐检测
		if($role_id == 1){
			return;
		}
		//获取当前页面的权限(控制器名称，方法名称)
		$c = CONTROLLER_NAME;
		$a = ACTION_NAME;
		//判断当前页面如果时特殊的，比如首页，不需要检测
		$ac = $c . '-' . $a;
		if($ac =="Index-index"){
			return true;
		}
		//根据role_id获取当前管理员拥有的权限信息（查询角色表）
		$role = D('Role')->where(['role_id'=>$role_id])->find();

		
		//判断管理员是否拥有当前页面的权限
		$role_auth_ac = explode(',',$role['role_auth_ac']);
		if(!in_array($ac,$role_auth_ac)){
			//没有权限
			$this->error('没有此页面的权限',U('Admin/Index/index'));
		}
		return true;
	}	
}

