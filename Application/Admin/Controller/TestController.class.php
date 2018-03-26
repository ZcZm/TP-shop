<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-19 10:17:25
 * @version $Id$
 */

namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller{
	public function index(){
		// echo encrypt_password('123456');die;
		//实例化模型
		//1:普通实例化方式 new+ 模型名称
		// $model = new \Admin\Model\GoodsModel();
		
		//2:快速实例化 D函数(实例化自己定义的类)object(Admin\Model\GoodsModel)
		//可以调用自己的方法和父类中的方法
		// $model = D('Goods');
		// dump($model);
		//3:快速实例化 M函数(实例化父类)object(Think\Model)
		//只能调用父类自己的的方法
		// $model = M('Goods');
		// dump($model);

		//M和D函数不传递参数 
		//用法就一样了。实例化一个父类模型
		// $model = D();
		// $model = M();
		// dump($model);
		

		//特殊实例化
		
		//第二个参数传null，表示没有前缀
		// $model = M('Advice',null);

		$model = D('Advice');
		dump($model);
	}
	public function chaxun(){
		//find 方法 查询一条数据
		// $model = D('Goods');
		// $goods = $model->find(2);
		// dump($goods);
		//select方法 查询多条数据
		// $model = D('Goods');
		// $data = $model->select(2);
		// $data = $model->select('1,3');//where in (2,3)
		// dump($data);
		// $model = D('Goods');
		// //辅助方法where
		// // $data = $model->where("id=2 and goods_price = 2222")->select();
		// $data = $model->where(['id'=>2,'goods_price'=>2222])->select();
		// dump($data);

		//统计查询
		// $model = D('Goods');
		// $total = $model->count();
		// dump($total);


		//连表查询
		$adviceModel = D('Advice');
		$data = $adviceModel->alias('a')->field('a.*,u.username')->join("left join tpshop_user as u on a.user_id = u.id")->select();
		dump($data);
	}
	//cookie使用
	public function test_cookie(){
		//cookie设置
		cookie('name','张小小');//setcookie() , $_COOKIE['name'] = ['张小小']

		//cookie读取
		$name = cookie('name');
		dump($name);
		//cookie删除
		cookie('name',null);
		dump(cookie($name));

		//option参数使用
		//expire 有效期保存时间
		// cookie('sex','男','expire=3');
		cookie('sex','男','3');
		dump(cookie('sex'));

		//cookie可以传数组，但一般我们手动转成字符串 json_encode
	}

	//session用法
	public function test_session(){
		//设置session
		$user = [
			'username' =>'琴女',
			'sex' => '女',
			'age' => 90,
		];
		session('user',$user);
		//通过点语法直接读取数组中的一个键值对
		$age = session('user.age');
		dump($age);

		session('user.age',19);
		$age = session('user.age');

		dump($age);
		$bool = session('?user');
		dump($bool);
	}
	public function test_xss(){
		$name = 'test<script>alert("abc");</script>test';
		$name = remove_xss($name);
		dump($name);
	}
}