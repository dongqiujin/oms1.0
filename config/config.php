<?php
/*************数据库配置*******************/
define('__SQL_DRIVER__', 'mysql');//驱动类型默认mysql
define('__SQL_HOST__' , 'localhost');//主机地址
define('__SQL_PORT__' , '3306');//端口
define('__SQL_LOGIN__' , 'root');//数据库用户名
define('__SQL_PASSWORD__' , '');//数据库密码
define('__SQL_DATABASE__' , 'myself_order');//数据库名
define('__SQL_PREFIX__' , '');//表前缀

$spConfig = array(
	"db" => array(
        'driver' => __SQL_DRIVER__,
		'host' => __SQL_HOST__,
		'port' => __SQL_PORT__,
		'login' => __SQL_LOGIN__,
		'password' => __SQL_PASSWORD__,
		'database' => __SQL_DATABASE__,
		'prefix' => __SQL_PREFIX__
	),
);

define("APP_PATH", ROOT_DIR.'/app');
define("SP_PATH", APP_PATH.'/base');
define("DATA_DIR", ROOT_DIR.'/data');
define("PUBLIC_NAME",'public');
define("PUBLIC_DIR", ROOT_DIR.'/'.PUBLIC_NAME);
@date_default_timezone_set('PRC');