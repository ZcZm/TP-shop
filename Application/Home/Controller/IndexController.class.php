<?php
//声明命名空间 和目录挂钩
namespace Home\Controller;
//引入父类控制器
use Think\Controller;
//定义当前控制器类
class IndexController extends Controller {
    public function index(){
    	$category = D('Category')->select();
    	$this->assign('category',$category);
    	//查询指定分类的信息及分类下的商品信息 分类id为13
    	$cate_info=D('Category')->where(['id'=>13])->find();
    	$this->assign('cate_info',$cate_info);
    	//查询模版
    	$goods = D('Goods')->where(['cate_id'=>13])->limit(12)->select();
    	$this->assign('goods',$goods);
    	//调用模版 
      	$this->display();
    }
    public function detail(){

     	//接收商品id参数
    	$id = I('get.id', 0, 'intval');
    	if($id <= 0){
    		$this -> error('参数错误');
    	}
    	//查询商品表基本信息
    	$goods = D('Goods') -> where(['id' => $id]) -> find();
    	$this -> assign('goods', $goods);

    	//查询商品相册图片信息
    	$goodspics = D('Goodspics') -> where(['goods_id' => $id]) -> select();
    	$this -> assign('goodspics', $goodspics);
		// dump($goodspics);die;
    	//查询商品属性名称信息
    	$attribute = D('Attribute') -> where(['type_id' => $goods['type_id']]) -> select();
    	$this -> assign('attribute', $attribute);

    	//查询商品属性值信息 tpshop_goods_attr表
    	$goodsattr = D('GoodsAttr') -> where(['goods_id' => $id]) -> select();
    	// dump($goodsattr);die;
    	//为了页面显示方便，将属性值 按照属性id进行分组
    	$new_goodsattr = [];
    	foreach($goodsattr as $k => $v){
	    	//['1' => [$v,$v1,$v2], '2' =>[$v]]
    		$new_goodsattr[$v['attr_id']][] = $v;
    	}
    	// dump($attribute);die;
    	// dump($new_goodsattr);die;
    	$this -> assign('new_goodsattr', $new_goodsattr);
    	$this -> display();


    }
}