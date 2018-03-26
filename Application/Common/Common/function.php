<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-21 11:30:26
 * @version $Id$
 */

//密码加密函数
function encrypt_password($password){
	//加盐
	$salt = "amdhglxpkab520nghnu";
	return md5(md5($password) . $salt);
}
//手机号加密

function remove_xss($string){
	//相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

#递归方法实现无限极分类
function getTree($list,$pid=0,$level=0) {
    static $tree = array();
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1);
        }
    }
    return $tree;
}

//手机号加密函数
function encrypt_phone($phone){
    return substr($phone,0,3) . '****' . substr($phone,7,4);
}

//封装一个使用curl函数库发送请求的函数
function curl_request($url,$post=false,$params = array(),$https = false){
    //使用curl_init函数进行初始化
    $ch = curl_init($url);  
    //使用curl_setopt函数设置一些请求选项
    if($post){
        //需要设置请求方式为post,并且设置请求参数
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
    }
    
   
    if($https){
         //https 请求 跳过证书验证
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//禁止服务端验证证书
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//禁止验证证书中的公用名
    }
    //设置curl_exec返回值，ture 表示成功时直接返回字符串格式的数据
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //使用curl_exec函数设置一些请求选项
    $result = curl_exec($ch);
    //使用curl_close函数关闭请求
    curl_close($ch);
    return $result;
}

