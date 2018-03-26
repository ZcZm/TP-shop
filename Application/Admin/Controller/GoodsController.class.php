<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-18 18:46:43
 * @version $Id$
 */
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController{
	public function index(){
		$model = D('Goods');
	
		//查询总记录数
		$total = $model->count();
		$pagesize = 3;
		//实例化分页类
		$page = new \Think\Page($total,$pagesize);
		//定制分页lan显示
		$page ->setConfig('prev','上一页');
		$page ->setConfig('next','下一页');
		$page ->setConfig('first','首页');
		$page ->setConfig('last','末页');
		$page ->setConfig('last','末页');
		$page -> setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER% ');//分页显示定制
		$page ->rollPage = 3;//分页栏每页显示的页数
		$page ->lastSuffix = false;//最后一页是否显示总页数
		//调用show方法获取分页栏代码
		$page_html = $page->show();
		$this->assign('page_html',$page_html);
		//获取当前页数据
		$data = $model->field('id,goods_name,goods_price,goods_number,goods_logo,goods_create_time')->order('id desc')->limit($page->firstRow,$page->listRows)->select();
		$this->assign('data',$data);
		$this->display();
	}
	public function add(){
		//一个方法处理两个业务逻辑：页面展示 表单提交
		if(IS_POST){
			//post表单提交
			// $data = $_POST;
			$data = I('post.');//相当于使用$_POST I函数第三个参数过滤方法默认是htmlspecialchars
			// dump($data);die;
			
			//实例化一个模型
			$model = D('Goods');
			$data['goods_introduce'] = I('post.introduce','','remove_xss');
			// dump($data['goods_introduce']);die;
			//商品logo图片上传
			$upload_res = $model -> upload_logo($data);
			if(!$upload_res){
				//通过模型的error属性获取到错误信息
				$error = $model -> getError();
				$this -> error($error);
			}
			// dump($upload_res);dump($data);die;
			if(!$model -> create($data)){
				//数据创建失败 返回false
				$error = $model->getError();
				$error = $error ? $error: "数据错误";
				$this->error($error);
			}
			//调用模型的ADD方法添加一条数据
			$res = $model -> add();
			// dump($res);die;
			if($res){
				//商品相册图片的上传
				$upload_pics_res = $model->upload_pics($res);

				
				
				// dump($upload_pics_res);die;
				if(!$upload_pics_res){
					$this->error("商品添加成功，相册图片上传失败");
				}
				// dump($upload_pics_res);
				// die;
			//商品属性值的添加，将商品的属性名称对应的属性值添加到tpshop_goods_attr表
			
			$attr_values = $data['attr_value'];
				$goodsattr = [];
				foreach ($attr_values as $k => $v) {
					//$k就是attr_id
					foreach ($v as  $value) {
						//$value 就是一个属性值，
						$row = [
							'goods_id' =>$res,
							'attr_id'  =>$k,
							'attr_value'=>$value
						];
						$goodsattr[] = $row;
					}
				}
				// dump($data);die;
				//批量添加
				D('GoodsAttr')->addAll($goodsattr);
			$this->success("添加成功",U("Admin/Goods/index"));
			}else{
				$this->error("添加失败");
			}
		}else{
			//get请求 页面展示	
			//查询所有的商品类型，用于下拉列表展示
			$type = D('Type')->select();
			$this->assign('type',$type);
			//查询所有的商品分类，用于下拉列表展示
			$cate = D('Category')->select();
			$this->assign('cate',$cate);
			$this->display();
		}
	}
	public function edit(){
		//一个方法处理两个业务逻辑 页面展示 表单提交
		if(IS_POST){
			//post表单提交
			$data = I('post.');
			// $data['goods_create_time'] = time();
			// dump($data);die;
			$model = D('Goods');
			$data['goods_introduce'] = I('post.introduce','','remove_xss');
			if($_FILES['logo']['error'] == 0){
				$upload_res = $model -> upload_logo($data);
						if(!$upload_res){
							//通过模型的error属性获取到错误信息
							$error = $model -> getError();
							$this -> error($error);
						}
			}
			
			if(!$model ->create($data)){
				$error = $model->getError();
				$error = $error ? $error : "数据错误";
				$this->error($error);
			}
			//调用模型的save方法，修改数据表的内容，返回受影响的行数
			$res = $model -> save();
			if($res !== false){

				//继续上传相册图片 
				$model ->upload_pics($data['id']);


				$this->success("修改成功",U('Admin/Goods/index'));
			}else{
				$this->error("修改失败");
			}
			
		}else{
			//接收ID参数 
		$id = I('get.id');
		//根据id查询数据表
		$goods = D('Goods')->where(['id'=>$id])->find();
		$this->assign('goods',$goods);

		//查询相册图片
		$goodspics = D('Goodspics')->where(['goods_id'=>$id])->select();
		//dump($goodspics);die;
		$this->assign('goodspics',$goodspics);
		$this->display();
		}
		
	}
	public function detail(){
		$this->display();
	}
	public function del(){
		//接收id参数
		$id = I('get.id');
		//实例化模型
		$model = D('Goods');
		//调用模型的delete方法
		// $model ->delete($id);
		$res = $model->where(['id'=>$id])->delete();
		if($res !==false){
			$this->success("删除成功",U('Admin/Goods/index'));
		}else{
			$this->error("删除失败");
		}
	}
	//ajax请求删除相册图片
	public function delpics(){
		//接收参数
		$id = I('post.pics_id');
		//根据id删除相册表对应的记录
		$res = D('Goodspics')->where(['id' => $id])->delete();
		if($res !== false){
			$return =[
				'code' => 10000,
				'msg' => 'success'
			];
			$this->ajaxReturn($return);
		}else{
			$return =[
				'code' => 10001,
				'msg' => '删除失败'
			];
			$this->ajaxReturn($return);
		}
	}

	//ajax根据type_id获取商品属性名称
	public function getattr(){
		// dump($_POST);die;
		$type_id = I('post.type_id',0,'intval');
		// dump($type_id);die;
		if($type_id<=0){
			//参数错误
			$return =[
				'code'=>10001,
				'msg'=>'参数错误'
			];
			$this->ajaxReturn($return);
		}
		//根据type_id查询属性表
		$data = D('Attribute')->where(['type_id'=>$type_id])->select();
		//将data中每条数据的attr_values转化为数组
		foreach ($data as $k => &$v) {
			//将attr_values转化为数组，重新赋值进行覆盖
			$v['attr_values'] = explode(',',$v['attr_values']);
		}
		unset($k,$v);
		//返回数据
			$return =[
				'code'=>10000,
				'msg'=>'成功',
				'data'=>$data
			];
			$this->ajaxReturn($return);
	}

}