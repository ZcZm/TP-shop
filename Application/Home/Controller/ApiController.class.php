<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller{
	//发送注册验证码
	public function sendmsg(){
		//接收参数
		$phone = I('post.phone');
		//判断发送频率（扩展，可以限制IP）
		
		$last_time = session('register_time_' . $phone) ? : 0;
		$time = time();
		if($time - $last_time <60){
			//发送太频繁
			$return = [
				'code' =>10003,
				'msg'  =>'发送太频繁'
			];
			$this->ajaxReturn($return);
		}
		//处理数据
		//准备请求地址 请求参数
		$url = "https://way.jd.com/chuangxin/dxjk5";
		$appkey = ".....";
		$code = mt_rand(1000,9999);
		$content = ".....";

		$resquest_url = $url . "?appkey=$appkey&mobile=$phone&content=$content";
		//使用url_request 函数发送请求
	/*	$res = curl_request($resquest_url,false,array(),true);
		//返回数据
		if(!$res){
			//请求失败
			$return = [
				'code' => 10001,
				'msg'  => "发送失败"
			];
			$this->ajaxReturn($return);
		}
		//解析数据 将json格式字符串转化为数组
		$arr = json_decode($res,true);
		if($arr['code'] != 10000){
			//发送失败
			$return = [
				'code' =>10002,
				'msg'  =>"发送失败"
			];
			$this ->ajaxReturn($return);
		}*/

		//将验证码保存到session中 用于后续的校验
		session('register_code_' . $phone,$code);
		//记录发送时间
		session('register_time_' . $phone,time());
		//发送成功
			$return = [
				'code' =>10000,
				'msg'  =>"发送成功"
			];
			$this ->ajaxReturn($return);
	}
}