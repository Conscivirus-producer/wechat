<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
'DB_TYPE'=>'mysql',// 数据库类型
'DB_HOST'=>'localhost',// 服务器地址
'DB_NAME'=>'wechat_schema',// 数据库名
'DB_USER'=>'root',// 用户名
'DB_PWD'=>'2324150778t',// 密码
'DB_PORT'=>3306,// 端口
'DB_PREFIX'=>'T_',// 数据库表前缀
'DB_CHARSET'=>'utf8',// 数据库字符集
'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL)
);