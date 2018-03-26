<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head lang="en">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<meta name="renderer" content="webkit">
		<meta http-equiv="Cache-Control" content="no-siteapp" />

		<title>注册</title>
		
		<link href="/Public/Home/css/amazeui.min.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/dlstyle.css" rel="stylesheet" type="text/css"/>
		<script src="/Public/Home/js/jquery.min.js"></script>
		<script src="/Public/Home/js/amazeui.min.js"></script>

	</head>

	<body>

		<div class="login-boxtitle">
			<a href="home/demo.html"><img alt="" src="/Public/Home/images/logobig.png" /></a>
		</div>

		<div class="res-banner">
			<div class="res-main">
				<div class="login-banner-bg"><span></span><img src="/Public/Home/images/big.jpg" /></div>
				<div class="login-box">

					<div class="am-tabs" id="doc-my-tabs">
						<ul class="am-tabs-nav am-nav am-nav-tabs am-nav-justify">
							<li class="am-active"><a href="">邮箱注册</a></li>
							<li><a href="">手机号注册</a></li>
						</ul>

						<div class="am-tabs-bd">
							<div class="am-tab-panel am-active">
								<form method="post" action="">
									<div class="login-form">
							   			<div class="user-email">
											<label for="email"><i class="am-icon-envelope-o"></i></label>
											<input type="email" name="email" id="email" placeholder="请输入邮箱账号">
	                 					</div>										
	                 					<div class="user-pass">
									    	<label for="password"><i class="am-icon-lock"></i></label>
									    	<input type="password" name="password" placeholder="设置密码">
	                 					</div>										
	                 					<div class="user-pass">
									    	<label for="passwordRepeat"><i class="am-icon-lock"></i></label>
									    	<input type="password" name="repassword" placeholder="确认密码">
	                 					</div>	
	                 				</div>
	                 
								 	<div class="login-links">
										<label for="reader-me">
											<input type="checkbox"> 点击表示您同意商城《服务协议》
										</label>
								  	</div>
									<div class="am-cf">
										<input type="submit" name="" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
									</div>
                 				</form>

							</div>

							<div class="am-tab-panel">
								<form method="post" action="">
								<div class="login-form">
                 					<div class="user-phone">
								    	<label for="phone"><i class="am-icon-mobile-phone am-icon-md"></i></label>
								    	<input type="tel" name="phone" id="phone" placeholder="请输入手机号">
                 					</div>																			
									<div class="verification">
										<label for="code"><i class="am-icon-code-fork"></i></label>
										<input type="tel" name="code" id="code" placeholder="请输入验证码">
										<input type="button" name="" value="发送验证码" id="dyMobileButton" onclick="sendmsg(this)">
									</div>
	                 				<div class="user-pass">
									    <label for="password"><i class="am-icon-lock"></i></label>
									    <input type="password" name="password" placeholder="设置密码">
	                 				</div>										
	                 				<div class="user-pass">
									    <label for="passwordRepeat"><i class="am-icon-lock"></i></label>
									    <input type="password" name="repassword" placeholder="确认密码">
	                 				</div>
                 				</div>
							 	<div class="login-links">
									<label for="reader-me">
										<input type="checkbox"> 点击表示您同意商城《服务协议》
									</label>
							  	</div>
								<div class="am-cf">
									<input type="submit" name="" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
								</div>
								</form>
							</div>

							<script>
								$(function() {
								    $('#doc-my-tabs').tabs();
								  })
							</script>

						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer ">
			<div class="footer-hd ">
				<p>
					<a href="# ">恒望科技</a>
					<b>|</b>
					<a href="# ">商城首页</a>
					<b>|</b>
					<a href="# ">支付宝</a>
					<b>|</b>
					<a href="# ">物流</a>
				</p>
			</div>
			<div class="footer-bd ">
				<p>
					<a href="# ">关于恒望</a>
					<a href="# ">合作伙伴</a>
					<a href="# ">联系我们</a>
					<a href="# ">网站地图</a>
				</p>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript">

	//倒计时时间
	var time = 60;
	//设置定时器，
	function sendmsg(element){
		if(time ==60){
			//获取手机号
			var phone = $('#phone').val();
			//发送ajax请求
			$.ajax({
				'url':"/index.php/Home/Api/sendmsg",
				'type':'post',
				'data':"phone=" + phone,
				'dataType':'json',
				'success':function(response){
					alert(response.msg);
				}
			});
		}
		//倒计时效果
		if(time >0){
			time--;
			element.value = "重新发送：" + time + "s";
			//禁用button
			element.disabled = true;
			
		}
		//if(time =0){}
		//设置定时器
		setTimeout(function(){
			sendmsg(element);

		},1000);
	}
</script>