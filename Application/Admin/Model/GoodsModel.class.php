<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-19 10:13:40
 * @version $Id$
 */
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
class GoodsModel extends Model{
	//	模型一些属性和方法
	//定义字段映射
	protected $_map = array(
		//form表单中的字段名称 => 数据表中的字段名称
		'name' => "goods_name",
		'price' => "goods_price",
		'number' => "goods_number",
	);

	//自动验证
	protected $_validate = array(
		//array(验证字段1，验证规则，错误提示，[验证条件，附加规则，验证时间])
		array('goods_name','require','商品名称不能为空'),
		array('goods_name','','商品名称不能重复',0,'unique',1),
		array('goods_price','require','商品价格不能为空'),
		array('goods_price','currency','商品价格格式不正确'),
		array('goods_number','require','商品数量不能为空'),
		array('goods_number','number','商品数量格式不正确'),

	);

	//自动完成
	protected $_auto = array(
		//完成字段1,完成规则,[完成条件，附加规则]
		array('goods_create_time','time',1,'function'),
	);

	//封装一个上传商品LOGO图片的方法
	public function upload_logo(&$data){
		//将图片保存到服务器，将图片路径保存到数据表
		
		//实例化upload类（自定义配置数据）
		$config = [
			'maxsize' 	=> 5*1024*1024,//上传文件的大小限制
			'exts' 	  	=> array('jpg','png','gif','jpeg'),//允许上传文件的后缀
			'rootPath'	=>ROOT_PATH . UPLOAD_PATH,//保存跟路径
			// 'rootPath'	=> '.' . UPLOAD_PATH,//保存跟路径
		];
		$upload = new \Think\Upload($config);
		//调用Upload类 uploadOne方法（传递文件数组参数）
		$res = $upload->uploadOne($_FILES['logo']);
		// dump($res);die;
		//判断结果，如果失败false 通过调用upload类的geterror方法获取错误信息
		if(!$res){
			$this -> error = $upload -> getError();
			return false;
		}
		//如果成功，拼接图片地址，（需要加到$data中去）
		
		$logo = UPLOAD_PATH . $res['savepath'] . $res['savename'];
		

		//生成缩略图
		//实例化Image类
		$image = new \Think\Image();
		//调用open方法打开原始图片
		$image->open('.' . $logo);
		// $image->open(ROOT_PATH . $logo);
		//调用thumb方法生成缩略图
		$image -> thumb(200,200);
		//调用save方法保存缩略图（另存为）
		$thumb_logo = UPLOAD_PATH . $res['savepath'] . 'thumb_' . $res['savename'];
		$image -> save('.' . $thumb_logo);
		// dump($logo);
		// 由于方法定义时，$data前使用了引用传值&，所有这里对$data的修改。会直接改到控制器中去
		// $data['goods_logo'] = $logo;
		// 将缩略图的路径保存到$data中，用于后续添加到数据表
		$data['goods_logo'] = $thumb_logo;


		return true;
	}	
	public function upload_pics($goods_id){
		if(min($_FILES['goods_pics']['error']) >0){
			return false;
		}

		//实例化upload类（自定义配置数据）
		$config = [
			'maxsize' 	=> 5*1024*1024,//上传文件的大小限制
			'exts' 	  	=> array('jpg','png','gif','jpeg'),//允许上传文件的后缀
			'rootPath'	=>ROOT_PATH . UPLOAD_PATH,//保存跟路径
			// 'rootPath'	=> '.' . UPLOAD_PATH,//保存跟路径
		];
		$upload = new \Think\Upload($config);
		// dump($_FILES);die;
		//调用upload类中的upload方法，进行多文件上传
		$res = $upload->upload(array($_FILES['goods_pics']));
		//判断结果并处理
		if(!$res){
			$this->error = $upload->getError();
			return false;
		}

		$data=[];
		//对结果数组中每一条数据进行处理
		foreach($res as $k => $v){
			//原始图片路径 /Public/Uploads/2018-01-24/abc.jpg
			$pics_origin = UPLOAD_PATH . $v['savepath'] . $v['savename'];
			//生成三张缩略图
			
			$image = new \Think\Image();
			$image -> open('.' . $pics_origin);
			//生成三种规格的缩略图 800*800
			$image -> thumb(800,800);
			$pics_big = UPLOAD_PATH . $v['savepath'] .'thumb800_' .  $v['savename'];
			$image ->save('.' . $pics_big);
			// 350*350
			$image ->thumb(350,350);
			$pics_mid = UPLOAD_PATH . $v['savepath'] .'thumb350_' .  $v['savename'];
			$image ->save('.' . $pics_mid);

			//50*50
			$image ->thumb(50,50);
			$pics_sma = UPLOAD_PATH . $v['savepath'] .'thumb50_' .  $v['savename'];
			$image ->save('.' . $pics_sma);

			//将数据保存到数据表
			$row = [
			'goods_id' =>$goods_id,
			'pics_big'	=>$pics_big,
			'pics_mid'	=>$pics_mid,
			'pics_sma'	=>$pics_sma,
			];
			// D('Goodspics') ->add($row);
			$data[] = $row;

		}
		//调用模型的addAll方法，批量添加多条数据，参数传递二维数组 
		D("Goodspics")->addAll($data);
		// dump($data);die;
		return true;
	}
}