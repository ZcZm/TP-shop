<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 14:43:10
 * @version $Id$
 */

//声明命名空间
namespace Home\Controller;
//引入父类控制器
use Think\Controller;
//定义当前控制器类
class TestController extends Controller{
	public function index(){
		// echo "123";
		//普通模式：http://www.tpshop.com/?m=home&c=Test&a=index
		//pathinfo模式：http://www.tpshop.com/index.php/home/Test/index/id/1/page/10
		//rewrite模式：http://www.tpshop.com/home/Test/index
		$this->display('index');
	}

	//快递查询
	public function kuaidi(){
		//准备参数以及url
		//https://www.kuaidi100.com/query?type=yunda&postid=3101314976598
		$url = "https://www.kuaidi100.com/query";
		$type = "yunda";
		$postid = "3101314976598";
		$url = $url . "?type=" . $type . "&postid=" . $postid;

		//发送请求
		$res = curl_request($url,false,array(),true);
		// dump($res);die;
		if(!$res){
			die("请求失败");
		}
		$data = json_decode($res,true);
		if($data['status'] != 200){
			die($data['message']);
		}
		foreach ($data['data'] as $k => $v) {
			echo $v['time'] . "----" . $v['context'] . "<br />";
		}

		//如果是ajax请求
		$return = array(
			'code' => 10000,
			'msg'  => 'success',
			'data' => $data['data']
		);

		$this->ajaxReturn($return);
		$this->assign('data',$data['data']);
		$this->display();
	}
}

