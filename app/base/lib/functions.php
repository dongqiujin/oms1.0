<?php
// 用户自定义函数

/**
 * 如果magic_quotes_gpc开启，则去除转义符
 * @param $_GET、$_POST、$_COOKIE
 * @return 返回去除转义符后的值
 */
function defined_stripslashe(&$var){
	if (is_array($var)){
		foreach ($var as $k=>$v){
			defined_stripslashe($var[$k]);
		}
	}else{
		if ($var)
		$var = stripslashes($var);
	}
}

/**
 * 获取当前时间搓
 * 
 */
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());   
    return ((float)$usec + (float)$sec);   
}

/**
* 获取时间差，返回天、时、分、秒
*/
function timediff($begin_time,$end_time)
{
     if($begin_time < $end_time){
        $starttime = $begin_time;
        $endtime = $end_time;
     }
     else{
        $starttime = $end_time;
        $endtime = $begin_time;
     }
     $timediff = $endtime-$starttime;
     $days = intval($timediff/86400);
     $remain = $timediff%86400;
     $hours = intval($remain/3600);
     $remain = $remain%3600;
     $mins = intval($remain/60);
     $secs = $remain%60;
     $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
     return $res;
}

/**
 * 加密函数
 * 将字符串加上私密进行加密，解密时需要加密时的私密
 * @param string $txt 待加密字符串
 * @param string $key 私密
 * @return string
 */
function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
	   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
	   $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}
/**
 * 解密函数
 * 对字符串进行解密
 * @param string $txt 待解密字符串
 * @param string $key 私密
 * @return string
 */
function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
	   $md5 = $txt[$i];
	   $tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
	   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
	   $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

/**
 * 
 */
function translateto_cn($w)
{  
    return spClass("GoogleTranslate")->t("en", "zh-cn",$w); // 调用了GoogleTranslate的t方法  
}  

function base_url(){
	if(defined('BASE_URL')){
		$url = parse_url(constant('BASE_URL'));
		return $url['path'];
	}
	require 'request.php';
	$base_url = request::get_base_url();

	if($base_url == '/'){
		$base_url = '';
	}

	return $base_url;
}





