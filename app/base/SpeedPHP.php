<?php
/////////////////////////////////////////////////////////////////
// SpeedPHP中文PHP框架, Copyright (C) 2008 - 2010 SpeedPHP.com //
/////////////////////////////////////////////////////////////////

define('SP_VERSION', '3.1.66'); // 当前框架版本

/**
 * spCore
 *
 * SpeedPHP应用框架的系统执行程序
 */

// 定义系统路径
if(!defined('SP_PATH')) define('SP_PATH', dirname(__FILE__).'/app/base');
if(!defined('APP_PATH')) define('APP_PATH', dirname(__FILE__).'/app');

// 载入核心函数库
require(SP_PATH."/spFunctions.php");

// 自定义函数库
require(APP_PATH."/base/lib/functions.php");

// 载入核心类库
require(SP_PATH.'/spBase.php');
// 获取所有app名称
$spConfig['app_list'] = spBase::applist();

if(get_magic_quotes_gpc()){
	spBase::strip_magic_quotes($_GET);
	spBase::strip_magic_quotes($_POST);
}
$_SERVER['PATH_INFO'] = spBase::request()->get_path_info();
if ($_SERVER['PATH_INFO'] == '/') $_SERVER['PATH_INFO'] = '';

if (substr(PHP_VERSION, 0, 1) != '5')spError("SpeedPHP框架环境要求PHP5！");

// 根据不同URL路由获取当前APP名称
if(defined('PATH_INFO') && PATH_INFO == true){
	$url_args = explode("/", $_SERVER['PATH_INFO']);
	if (!isset($url_args[1]) || !in_array($url_args[1], $spConfig['app_list'])){
		$spConfig['app']['name'] = 'desktop';
	}else{
		$spConfig['app']['name'] = $url_args[1];
	}
}elseif(defined('REWRITE') && REWRITE == true){
	
}else{
	$spConfig['app']['name'] = $_GET['app'];
}

// 读取不同APP的配置文件
$app_config_path = APP_PATH.'/'.$spConfig['app']['name'].'/config.php';
if (file_exists($app_config_path)){
	require($app_config_path);
}else{
	//PATH_INFO路由配置
	$spConfig['url'] = array( // URL设置
		'url_path_info' => PATH_INFO, // 是否使用path_info方式的URL
	);
	/*
	//伪静态配置
	$spConfig['launch'] = array(
		'router_prefilter' => array(
		   array('spUrlRewrite', 'setReWrite'),  // 对路由进行挂靠，处理转向地址  
		),
		'function_url' => array(  
		   array("spUrlRewrite", "getReWrite"),  // 对spUrl进行挂靠，让spUrl可以进行Url_ReWrite地址的生成  
		),
	);
	//Url_ReWrite的设置
	$spConfig['ext'] = array(  
		'spUrlRewrite' => array(
			'hide_default' => true, // 隐藏默认的main/index名称，但这前提是需要隐藏的默认动作是无GET参数的  
			'sep' => '/', // 网址参数分隔符，建议是“-_/”之一
			'args_path_info' => true, // 地址参数是否使用path_info的方式，默认否  
			'suffix' => '.html', // 生成地址的结尾符
			'map' => array(
				'message' => 'message@index',
				'main-index' => 'main@index',
				'about' => 'main@about',
				'main-page' => 'main@page',
				'topic-index' => 'topic@index',
				'topic-page' => 'topic@page',
			),
			'args' => array(
				'topic-page' => array('id'),
			),
		),
	);
	*/
	// 模板视图配置
	$spConfig['view'] = array(
		'enabled' => true, // 开启视图
		'config' =>array(
			'template_dir' => APP_PATH.'/'.$spConfig['app']['name'].'/view', // 模板目录
			'themes_dir' => APP_PATH.'/'.$spConfig['app']['name'].'/statics', // 媒体文件目录名
			'compile_dir' => DATA_DIR.'/compile/'.$spConfig['app']['name'], // 编译目录
			'cache_dir' => DATA_DIR.'/cache/'.$spConfig['app']['name'], // 缓存目录
			'left_delimiter' => '<{',  // smarty左限定符
			'right_delimiter' => '}>', // smarty右限定符
		),
	);
	$spConfig['sp_cache'] = DATA_DIR.'/kvstore/'.$spConfig['app']['name']; // 框架临时文件夹目录

    /*
	//多语言支持
	$spConfig['lang'] = array( 
		'cn' => 'default', // 默认语言，这里中文为默认语言
		'en' => array("GoogleTranslate","zh_cn2en"), // 英文
		'tw' => array("GoogleTranslate","zh_cn2zh_tw"), // 繁体中文
		'fr' => array("GoogleTranslate","zh_cn2fr"),  // 法语
		'de' => array("GoogleTranslate","zh_cn2de"),   // 德语
		'it' => array("GoogleTranslate","zh_cn2it"),   // 意大利语
		'th' => array("GoogleTranslate","zh_cn2th"),   // 泰国语
		'el' => array("GoogleTranslate","zh_cn2el"),  // 希腊语
		'ar' => array("GoogleTranslate","zh_cn2ar"),  // 阿拉伯语
		'ko' => array("GoogleTranslate","zh_cn2ko"),   // 韩语
		'hu' => array("GoogleTranslate","zh_cn2hu"),   // 匈牙利语
		'img' => APP_PATH."/lib/lang/img.lang.php",   // 自定义的语言，也可以是上面任何一种语言
		'mas_en' => APP_PATH."/lib/lang/zh2en.lang.php",
	);
    */

    // smarty函数配置
    $spConfig['view_registered_functions'] = array(
		'img' => array('view', 'smarty_img'),
		'style' => array('view', 'smarty_style'),
		'script' => array('view', 'smarty_script'),
		'pager' => array('view', 'smarty_pager'),
	);

	// 全局路径设置
	$spConfig['include_path'] = array(
	   APP_PATH.'/base/lib',
	);
	
	// 当前模块附加的配置
	$spConfig['controller_path'] = APP_PATH.'/'.$spConfig['app']['name'].'/controller';
	$spConfig['model_path'] = APP_PATH.'/'.$spConfig['app']['name'].'/model';
    $spConfig['dbschema_path'] = APP_PATH.'/'.$spConfig['app']['name'].'/dbschema';
    $spConfig['lib_path'] = APP_PATH.'/'.$spConfig['app']['name'].'/lib';
}

// 载入配置文件
$GLOBALS['G_SP'] = spConfigReady(require(SP_PATH."/spConfig.php"),$spConfig);

// 根据配置文件进行一些全局变量的定义
if('debug' == $GLOBALS['G_SP']['mode']){
	define("SP_DEBUG",TRUE); // 当前正在调试模式下
}else{
	define("SP_DEBUG",FALSE); // 当前正在部署模式下
}
// 如果是调试模式，打开警告输出
if (SP_DEBUG) {
	if( substr(PHP_VERSION, 0, 3) == "5.3" ){
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
	}else{
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	}
} else {
	error_reporting(0);
}
@set_magic_quotes_runtime(0);

// 自动开启SESSION
if($GLOBALS['G_SP']['auto_session'])@session_start();

// 载入核心MVC架构文件
import($GLOBALS['G_SP']["sp_core_path"]."/spController.php", FALSE, TRUE);
if ($spConfig['app']['name'] != 'desktop'){
	import(SP_PATH.'/controller/base_controller.php');
}else{
	import($spConfig['controller_path'].'/desktop_controller.php');
}
import($GLOBALS['G_SP']["sp_core_path"]."/spModel.php", FALSE, TRUE);
import(SP_PATH.'/model/base_model.php');
import($GLOBALS['G_SP']["sp_core_path"]."/spView.php", FALSE, TRUE);

// 当在二级目录中使用SpeedPHP框架时，自动获取当前访问的文件名
if('' == $GLOBALS['G_SP']['url']["url_path_base"]){
	if(basename($_SERVER['SCRIPT_NAME']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['G_SP']['url']["url_path_base"] = $_SERVER['SCRIPT_NAME'];
	elseif (basename($_SERVER['PHP_SELF']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['G_SP']['url']["url_path_base"] = $_SERVER['PHP_SELF'];
	elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === basename($_SERVER['SCRIPT_FILENAME']))
		$GLOBALS['G_SP']['url']["url_path_base"] = $_SERVER['ORIG_SCRIPT_NAME'];
}

// 在使用PATH_INFO的情况下，对路由进行预处理
if(TRUE == $GLOBALS['G_SP']['url']["url_path_info"] && !empty($_SERVER['PATH_INFO'])){
	$url_args = explode("/", $_SERVER['PATH_INFO']);$url_sort = array();
	if (in_array($url_args[1], $spConfig['app_list'])){
		$start_sort = 2;
		$ctl_sort = 2;
		$act_sort = 3;		
	}else{
		$start_sort = 1;
		$ctl_sort = 1;
		$act_sort = 2;
	}
	for($u = $start_sort; $u < count($url_args); $u++){
		if($u == $ctl_sort)$url_sort[$GLOBALS['G_SP']["url_controller"]] = $url_args[$u];
		elseif($u == $act_sort)$url_sort[$GLOBALS['G_SP']["url_action"]] = $url_args[$u];
		else {$url_sort[$url_args[$u]] = isset($url_args[$u+1]) ? $url_args[$u+1] : "";$u+=1;}
	}
	if("POST" == strtoupper($_SERVER['REQUEST_METHOD'])){
		$_REQUEST = $_POST =  $_POST + $url_sort;
	}else{
		$_REQUEST = $_GET = $_GET + $url_sort;
	}
}

// 构造执行路由
$__controller = isset($_REQUEST[$GLOBALS['G_SP']["url_controller"]]) ? 
	$_REQUEST[$GLOBALS['G_SP']["url_controller"]] : 
	$GLOBALS['G_SP']["default_controller"];
$__action = isset($_REQUEST[$GLOBALS['G_SP']["url_action"]]) ? 
	$_REQUEST[$GLOBALS['G_SP']["url_action"]] : 
	$GLOBALS['G_SP']["default_action"];

// 自动执行用户代码
if(TRUE == $GLOBALS['G_SP']['auto_sp_run'])spRun();