<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller{

	//注册
	public function register(){
		if(IS_POST){
			//接收数据
			$data = I('post.');
			//手机号注册
			if($data['phone']){
				//短信验证码校验
				$code = session('register_code_' . $data['phone']);
				if(empty($data['code']) || $data['code'] != $code){
					//短信验证错误
					$this->error('短信验证码错误');
				}
				//验证码有效期
				$send_time = session('register_time_' . $data['phone']);
				$time = time();
				if($time - $send_time > 300){
					$this->error('验证码失效');
				}

				//验证成功后失效
				session('register_code_' . $data['phone'],null);
				session('register_time_' . $data['phone'],null); 
			}
			//参数检测 自动验证
			$model = D('User');
			if(!$model->create($data)){
				//验证失败
				$error = $model->getError();
				$this->error($error);
			}
			//进行注册 添加数据到数据表
			$res = $model->add();
			if($res){
				//注册成功
				$this->success('注册成功',U('Home/User/login'));
			}else{
				$this->error('注册失败');
			}
		}else{
			//临时关闭模版布局
			layout(false);
			$this->display();
		}
		
	}
	public function login(){
		if(IS_POST){
			//表单提交
			//接收数据
			$data = I('post.');
			//参数检测
			if(empty($data['username'])||empty($data['password'])){
				//参数错误
				$this->error('参数错误');
			}
			//根据username字段查询
			$user = D('User')->where([
				'username'=>$data['username'],
				'password'=>encrypt_password($data['password'])
				])->find();
			if(!$user){
				//根据email字段查询
				$user = D('User')->where([
					'email'=>$data['username'],
					'password'=>encrypt_password($data['password'])
					])->find();
			}
			if(!$user){
				//根据phone字段查询
				$user = D('User')->where([
					'phone'=>$data['username'],
					'password'=>encrypt_password($data['password'])
					])->find();
			}
			//判断用户是否查询到
			if(!$user){
				//用户名不存在或者密码错误
				$this->error('用户名或者密码错误');
			}else{
				//登录成功
				//设置登录标识
				session('user_info',$user);
				//调用cart模型方法，将cookie中的购物车数据迁移到数据表中
				D('Cart')->cookieTodb();
				//从session读取back_url
				$back_url = session('back_url');
				$back_url = $back_url ? $back_url : U('Home/Index/index');
				$this->success('登录成功',$back_url);
			}

		}else{
			layout(false);
			$this->display();
		}
	
	}


	public function logout(){
		//清空session
		session(null);
		$this->redirect('Home/User/login');
	}
}
