<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
	//加入购物车
	public function addcart(){
		if(IS_POST){
			//接收数据
			$data =I('post.');
			// dump($data);die;
			if(empty($data['goods_id'])||empty($data['goods_attr_ids'])||empty($data['number'])){
				$this->error('参数错误');
			}
			//将数据保存
			$res = D('Cart') -> addCart($data['goods_id'],$data['number'],$data['goods_attr_ids']);
			if($res){
				//查询商品基本信息用于页面展示
				$goods =D('Goods')->where(['id'=>$data['goods_id']])->find();
				$this->assign('goods',$goods);
				$this->display();
			}else{
				$this->error('添加失败');

			}
		}else{
			$this->error('没有此页面',U('Home/Index/index'));
		}
		
	}
	//展示
	public function cart(){
		$data = D('Cart') ->getAllCart();
		//遍历，对每一条数据，查询商品基本信息
		// dump($data);die;
		foreach ($data as &$v) {
			//商品的基本信息
			$goods =D('Goods')->where(['id'=>$v['goods_id']]) ->find();
			$v['goods'] = $goods;
			//查询属性名称 属性值信息
			// dump($v);
			$goodsattr = D('GoodsAttr')->alias('t1')->field('t1.*,t2.attr_name')->join("left join tpshop_attribute as t2 on t1.attr_id = t2.attr_id")->where("t1.id in ({$v['goods_attr_ids']})")->select();
			$v['goodsattr'] = $goodsattr;
			
			// dump($goodsattr);die;
		}
		// dump($data);die;
		unset($v);   
		// die;
		$this->assign('data',$data);
		$this->display();
	}

	//ajax请求修改购买数量
	public function changenum(){
		//接收数据
		$data = I('post.');
		//参数检测 略
		//调用模型的changeNum方法
		$res = D('Cart')->changeNum($data['goods_id'],$data['number'],$data['goods_attr_ids']);
		if($res){
			$return = [
				'code' => 10000,
				'msg' =>'success'
			];
			$this->ajaxReturn($return);
		}else{
				$return = [
				'code' => 10001,
				'msg' =>'修改失败'
			];
			$this->ajaxReturn($return);
		}
	}

	//ajax请求删除
	public function delcart(){
		//接受数据
		$data =I('post.');

		$res = D('Cart')->delCart($data['goods_id'],$data['goods_attr_ids']);
		if($res){
			$return = [
				'code' => 10000,
				'msg' =>'success'
			];
			$this->ajaxReturn($return);
		}else{
			$return = [
				'code' => 10001,
				'msg' =>'删除失败'
			];
			$this->ajaxReturn($return);
		}
	}

	//结算
	public function flow2(){
		//判断登陆
		if(!session('?user_info')){
			//没有登录 跳转到登录
			session('back_url',U('Home/Cart/cart'));
			$this->redirect('Home/User/login');
		}

		//接受数据
		$cart_ids = I('get.cart_ids');
		//参数检测
		$cart_arr = explode(',',$cart_ids);
		foreach ($cart_arr as $v) {
			if(!is_numeric($v)||intval($v) != $v){
				$this->error('参数错误');
			}
		}
		unset($v);

		//获取session里用户得到id
		$user_id = session('user_info.id');
		//查询收货地址的信息
		$address = D('Address')->where(['user_id'=>$user_id])->select();
		$this->assign('address',$address);
		// dump($address);die;
		
		//根据cart_ids查询购物记录 连表查询商品基本信息
		$data = D('Cart')->alias('c')->field("c.*,g.goods_name,g.goods_logo,g.goods_price")->join("left join tpshop_goods as g on c.goods_id = g.id")->where("c.id in ({$cart_ids})")->select();
		// dump($data);die;
		
		$total_price = 0;
		foreach ($data as &$v) {
			//遍历 查询每条数据的商品属性名 和属性值
			$goodsattr = D('GoodsAttr')->alias('t1')->field('t1.*,t2.attr_name') ->join("left join tpshop_attribute as t2 on t1.attr_id = t2.attr_id")->where("t1.id in ({$v['goods_attr_ids']})")->select();
			$v['goodsattr'] = $goodsattr;
			//计算总金额
			$total_price += $v['goods_price'] * $v['number'];
		}
		// dump($data);die;
		$this->assign('data',$data);
		$this->assign('total_price',$total_price);
		$this->display();
	}

	//提交表单
	public function createorder(){
		//接收参数
		$data = I('post.');
		// dump($data);die;
		//生成订单号
		$order_sn = time() . mt_rand(10000,99999);
		//根据cart_id 查询商品价格 购买数量
		$cart_data = D('Cart')->alias('c')->field('c.*,g.goods_price,g.goods_name,g.goods_logo')->join("left join tpshop_goods as g on c.goods_id= g.id")->where("c.id in ({$data['cart_ids']})")->select();
		// dump($cart_data);die;
		// 累加计算 总金额
		$order_amount = 0;
		foreach ($cart_data as $v) {
			$order_amount += $v['goods_price'] * $v['number'];
		}
		// dump($order_amount);die;
		$user_id = session('user_info.id');
		//根据address_id 查询收货地址信息
		$address = D('Address')->where(['id'=>$data['address_id']])->find();
		//创建时间
		$create_time = time();
		//组装订单表一条数据
		$row = [
			'order_sn'     		=> $order_sn,
			'order_amount' 		=> $order_amount,
			'user_id'     		=> $user_id,
			'consignee_name'  	=> $address['consignee'],
			'consignee_phone' 	=> $address['phone'],
			'consignee_address' => $address['address'],
			'shipping_type' 	=> $data['shipping_type'],
			'pay_type' 			=> $data['pay_type'],
			'create_time' 		=> $create_time
		];
		//添加数据到订单表
		$order_id = D('Order')->add($row);
		if($order_id){
			//向订单商品表添加多条数据
			$goods_all = [];
			foreach ($cart_data as $v) {
				$goods_row = [
					'order_id'       => $order_id,
					'goods_id'     	 => $v['goods_id'],
					'goods_name'     => $v['goods_name'],
					'goods_logo'     => $v['goods_logo'],
					'goods_price'    => $v['goods_price'],
					'number'      	 => $v['number'],
					'goods_attr_ids' => $v['goods_attr_ids']
				];
				$goods_all[] = $goods_row;
			}
			//批量添加到订单商品表
			D('OrderGoods')->addAll($goods_all);

			//删除购物车记录
			D('Cart')->where("id in ({$data['cart_ids']})")->delete();

			//往后就是支付流程
			if($data['pay_type'] ==0){
				//银联
			}elseif ($data['pay_type'] == 1) {
				//微信
			}else{
				//支付宝
			}

			//模拟支付成功跳转
			$this->redirect('Home/Cart/flow3');
		}
	}

	//支付成功提示页面
	public function flow3(){
		$this->display();
	}
}
