<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 16:39:56
 * @version $Id$
 */
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
	//后台登录页
	public function login(){

		//一个方法处理两个逻辑
		if(IS_POST){

			//post请求 表单提交
			$username = I('post.username');
			$password = I('post.password');
			$code = I('post.code');
			//参数检测
			if(empty($username)||empty($password)||empty($code)){
				$this->error('参数不全');
			}
			//验证码校验
			//实例化Verify类
			$verify = new \Think\Verify();
			//调用check方法校验
			$check = $verify ->check($code);
			if(!$check){
				//验证码错误
				$this->error('验证码错误');
			}
			//根据用户名查询表
			$info = D('Manager') ->where(['username' => $username]) -> find();
			//如果查询到这个用户，比对密码（将明文加密）
			if($info && $info['password'] == encrypt_password($password)){
				//用户名一致且密码一致，登录成功
				//设置登录标识session
				session('manager_info',$info);
				$this->success('登录成功',U('Admin/Index/index'));
			}else{
				//登录失败
				
				$this->error('用户名或密码错误,请重新输入');
			}
		}else{
			//页面展示
			//1:如果已登录 可以直接跳转到后台首页
			// if(session('?manager_info')){
			// 	$this->redirect('Admin/Index/index');
			// }
			// //2:如果已登录 也可以自动退出重新打开登录页面
			if(session('?manager_info')){
				session(null);
			}
			//临时关闭全局布局
			layout(false);
			//调用模版
			$this->display();
		}
		
	}
	public function logout(){
		//销毁session数据
		session(null);
		//跳转到登录
		$this->redirect('Admin/Login/login');
	}

	//生成验证码
	public function captcha(){
		//实例化Verify这个类
		//自定义配置
		/*'useImgBg'  =>  false,           // 使用背景图片 
        'fontSize'  =>  25,              // 验证码字体大小(px)
        'useCurve'  =>  true,            // 是否画混淆曲线
        'useNoise'  =>  true,            // 是否添加杂点	
        'imageH'    =>  0,               // 验证码图片高度
        'imageW'    =>  0,               // 验证码图片宽度
        'length'    =>  5,               // 验证码位数
        'fontttf'   =>  '',              // 验证码字体，不设置随机获取
        'bg'        =>  array(243, 251, 254),  // 背景颜色
        'reset'     =>  true,           // 验证成功后是否重置*/
		$config = [
			'length' => 4,
			'useCurve'  =>  false,            // 是否画混淆曲线
       		'useNoise'  =>  true,            // 是否添加杂点
		];
		$verify = new \Think\Verify($config);
		//调用entry方法生成并输出验证码
		$verify -> entry();
	}


	public function ajaxlogin(){

		//post请求 表单提交
			$username = I('post.username');
			$password = I('post.password');
			$code = I('post.code');
			//参数检测
			// dump(I('post.'));die;
			if(empty($username)||empty($password)||empty($code)){
				// $this->error('参数不全');
				$return = [
					'code' => 10001,//错误码
					'msg'  => '参数不全',
				];
				// echo json_encode($return);die;
				$this->ajaxReturn($return);
			}
			//验证码校验
			//实例化Verify类
			$verify = new \Think\Verify();
			//调用check方法校验
			$check = $verify ->check($code);
			if(!$check){
				//验证码错误
				// $this->error('验证码错误');
				$return = [
					'code' => 10002,//错误码
					'msg'  => '验证码错误',
				];
				// echo json_encode($return);die;
				$this->ajaxReturn($return);
			}
			//根据用户名查询表
			$info = D('Manager') ->where(['username' => $username]) -> find();
			//如果查询到这个用户，比对密码（将明文加密）
			if($info && $info['password'] == encrypt_password($password)){
				//用户名一致且密码一致，登录成功
				//设置登录标识session
				session('manager_info',$info);
				// $this->success('登录成功',U('Admin/Index/index'));
				$return = [
					'code' => 10000,//错误码
					'msg'  => '登录成功',
				];
				// echo json_encode($return);die;
				$this->ajaxReturn($return);
			}else{
				//登录失败
				
				// $this->error('用户名或密码错误,请重新输入');
				$return = [
					'code' => 10003,//错误码
					'msg'  => '用户名或密码错误',
				];
				// echo json_encode($return);die;
				$this->ajaxReturn($return);
			}
		
		// $return = [
		// 	'code' =>100,
		// 	'msg'  =>'success',
		// ];
		// echo json_encode($return);die;
	}
}