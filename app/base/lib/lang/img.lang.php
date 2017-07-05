<?php
$themes_dir = $GLOBALS['G_SP']['view']['config']['themes_dir'];
$themes_app_dir = $themes_dir . '/'. $GLOBALS['G_SP']['app_name'];
return array(
    '登录' => '<img src="'.$themes_dir.'/common/images/login.png" alt="登录" />',
    '大家好' => '<img src="./images/login.gif" alt="大家好" />',
    '关于' => '<img src="./images/about.gif" alt="关于" />',
	'您好' => 'hello',
	'请登录' => 'please login',
	'首页' => 'home',
	'会员' => 'member',
	'后台' => 'desktop',
);