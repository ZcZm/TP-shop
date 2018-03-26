<?php
return array(
	//'配置项'=>'配置值'
	///* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'tpshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'chao',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'tpshop_',    // 数据库表前缀

    //加载额外的函数文件
    "LOAD_EXT_FILE"         =>  'str',//如果有多个文件，用逗号分开，比如'str,str1'

    //加载自定义的配置文件
    'LOAD_EXT_CONFIG' => 'db',//如果有多个文件，用逗号分开
);

