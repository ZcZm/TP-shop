<?php
namespace Home\Controller;
use Think\Model;
class UserModel extends Model{
	//自动验证规则
	protected $_validate = array(
		array('email','require','邮箱不能为空'),
		array('email','email','邮箱格式不正确'),
		array('email','邮箱已被注册',0,'unique'),

		array('phone','require','手机号不能为空'),
		array('phone','^1[34578]\d{9}$/','手机号格式不正确'),
		array('phone','','手机号已经被注册',0,'手机号格式不正确'),

		array('password','require','密码不能为空'),
		array('password','repassword','两次密码必须一致',0,'confirm'),
		);

	//自动完成规则
	protected $_auto = array(
		array('password','encrypt_password',3,'functon'),
		array('create_time','time',1,'functon'),
		);
}