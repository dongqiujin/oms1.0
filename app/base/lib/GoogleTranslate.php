<?php
/**
 * 利用Google翻译API的多语言翻译类
 *
 * 出于性能的考虑，GoogleTranslate可以设置使用缓存
 * 
 * spGoogleTranslate的缓存可以选择使用数据库或是spAccess来进行缓存
 *
 * 同时此多语言翻译类也可以作为SpeedPHP框架的多语言引擎
 */
class GoogleTranslate
{
	// 默认是否开启缓存
	public $cache_enabled = TRUE;
	
	// 默认的数据缓存引擎，GoogleTranslatePlus_DB是数据库缓存，GoogleTranslatePlus_Access是使用spAccess缓存
	// 如果要使用GoogleTranslatePlus_DB，请按照GoogleTranslatePlus_DB类的注释说明建立数据表
	public $cache_engine = "GoogleTranslatePlus_Access";
	
	private $session_cached_array = array();
	
	// Google翻译API地址
	private $url = "http://ajax.googleapis.com/ajax/services/language/translate";
	// Google翻译版本
	private $version = "1.0";
	
	// 可供翻译的对应语言标识
	private $langs = array(
		'AFRIKAANS' => 'af', 
		'ALBANIAN' => 'sq', 
		'AMHARIC' => 'am', 
		'ARABIC' => 'ar', 
		'ARMENIAN' => 'hy', 
		'AZERBAIJANI' => 'az', 
		'BASQUE' => 'eu', 
		'BELARUSIAN' => 'be', 
		'BENGALI' => 'bn', 
		'BIHARI' => 'bh', 
		'BULGARIAN' => 'bg', 
		'BURMESE' => 'my', 
		'CATALAN' => 'ca', 
		'CHEROKEE' => 'chr', 
		'CHINESE' => 'zh', 
		'CHINESE_SIMPLIFIED' => 'zh-CN', // 函数名中使用zh_cn
		'CHINESE_TRADITIONAL' => 'zh-TW', // 函数名中使用zh_tw
		'CROATIAN' => 'hr', 
		'CZECH' => 'cs', 
		'DANISH' => 'da', 
		'DHIVEHI' => 'dv', 
		'DUTCH'=> 'nl',   
		'ENGLISH' => 'en', 
		'ESPERANTO' => 'eo', 
		'ESTONIAN' => 'et', 
		'FILIPINO' => 'tl', 
		'FINNISH' => 'fi', 
		'FRENCH' => 'fr', 
		'GALICIAN' => 'gl', 
		'GEORGIAN' => 'ka', 
		'GERMAN' => 'de', 
		'GREEK' => 'el', 
		'GUARANI' => 'gn', 
		'GUJARATI' => 'gu', 
		'HEBREW' => 'iw', 
		'HINDI' => 'hi', 
		'HUNGARIAN' => 'hu', 
		'ICELANDIC' => 'is', 
		'INDONESIAN' => 'id', 
		'INUKTITUT' => 'iu', 
		'ITALIAN' => 'it', 
		'JAPANESE' => 'ja', 
		'KANNADA' => 'kn', 
		'KAZAKH' => 'kk', 
		'KHMER' => 'km', 
		'KOREAN' => 'ko', 
		'KURDISH'=> 'ku', 
		'KYRGYZ'=> 'ky', 
		'LAOTHIAN'=> 'lo', 
		'LATVIAN' => 'lv', 
		'LITHUANIAN' => 'lt', 
		'MACEDONIAN' => 'mk', 
		'MALAY' => 'ms', 
		'MALAYALAM' => 'ml', 
		'MALTESE' => 'mt', 
		'MARATHI' => 'mr', 
		'MONGOLIAN' => 'mn', 
		'NEPALI' => 'ne', 
		'NORWEGIAN' => 'no', 
		'ORIYA' => 'or', 
		'PASHTO' => 'ps', 
		'PERSIAN' => 'fa', 
		'POLISH' => 'pl', 
		'PORTUGUESE' => 'pt-PT', // pt_pt
		'PUNJABI' => 'pa', 
		'ROMANIAN' => 'ro', 
		'RUSSIAN' => 'ru', 
		'SANSKRIT' => 'sa', 
		'SERBIAN' => 'sr', 
		'SINDHI' => 'sd', 
		'SINHALESE' => 'si', 
		'SLOVAK' => 'sk', 
		'SLOVENIAN' => 'sl', 
		'SPANISH' => 'es', 
		'SWAHILI' => 'sw', 
		'SWEDISH' => 'sv', 
		'TAJIK' => 'tg', 
		'TAMIL' => 'ta', 
		'TAGALOG' => 'tl', 
		'TELUGU' => 'te', 
		'THAI' => 'th', 
		'TIBETAN' => 'bo', 
		'TURKISH' => 'tr', 
		'UKRAINIAN' => 'uk', 
		'URDU' => 'ur', 
		'UZBEK' => 'uz', 
		'UIGHUR' => 'ug', 
		'VIETNAMESE' => 'vi', 
		'UNKNOWN' => '' 
	);
	
	// 构造函数检查是否存在JSON函数
	public function __construct() {
		if(!function_exists("json_decode"))spError("Missing the JSON Classes!");
		$params = spExt("GoogleTranslate");
		$this->cache_enabled = isset($params["cache_enabled"]) ? $params["cache_enabled"] : $this->cache_enabled;
		$this->cache_engine = isset($params["cache_engine"]) ? $params["cache_engine"] : $this->cache_engine;
		$this->url = isset($params["url"]) ? $params["url"] : $this->url;
		$this->version = isset($params["version"]) ? $params["version"] : $this->version;
	}
	
	/**
	 * 魔术函数，实现语言对应翻译
	 */
	public function __call($funcname, $args){
		$name = explode("2", $funcname);if(!isset($name[1]))return $args[0];
		return $this->t($name[0],$name[1],$args[0]);
	}
	
	/* 
	 * 对词语进行翻译
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 */
	public function t($from, $to, $str){
		$strname = md5($from.$to.$str);
		if( !empty( $this->session_cached_array[$strname] ) )return $this->session_cached_array[$strname];
		if( TRUE == $this->cache_enabled ){
			$value = $this->get_cached_request($from, $to, $str);
		}else{
			$value = $this->get_request($this->url_format($from, $to, $str));
		}
		$this->session_cached_array[$strname] = $value;
		return empty($value) ? $str : $value;
	}
	/* 
	 * 使用缓存方式获取翻译数据
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 */
	public function get_cached_request($from, $to, $str){
		$value = spClass($this->cache_engine)->get_cached($from, $to, md5($str));
		if( FALSE == $value ){
			$value = $this->get_request($this->url_format($from, $to, $str));
			spClass($this->cache_engine)->set_cached($from, $to, md5($str), $value);
		}
		return $value;
	}
	/* 
	 * 使用获取翻译数据
	 *
	 * @param url    已构造的网络地址
	 */
	private function get_request($url){
		if(function_exists("curl_init")){
			$json_response = json_decode($this->get_by_curl($url));
		}else{
			$json_response = json_decode(@file_get_contents($this->url ."?". $url));
		}
		if( !empty($json_response) && $json_response->responseStatus == 200 ){
			return $json_response->responseData->translatedText;
		}else{
			return false;
		}
	}
	/* 
	 * 使用CURL函数来获取翻译数据
	 *
	 * @param url    已构造的网络地址
	 */
	private function get_by_curl($url){
		$ch = @curl_init(); 
		@curl_setopt($ch, CURLOPT_URL, $this->url); 
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		@curl_setopt($ch, CURLOPT_REFERER, !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : ""); 
		@curl_setopt($ch, CURLOPT_POST, 1); 
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $url); 
		$body = @curl_exec($ch); 
		@curl_close($ch); 
		return $body;
	}
	/* 
	 * 对翻译的词语及语言进行URL构造
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 */
	private function url_format($from, $to, $str){
		$langs_list = array_map( "strtolower", array_values($this->langs) );
		$from = str_ireplace("_", "-", $from);
		$to = str_ireplace("_", "-", $to);
		if( !in_array($from, $langs_list) )return false;
		if( !in_array($to, $langs_list) )return false;
		$params = array(
			"v" => $this->version,
			"q" => $str,
			"langpair" => $from."|".$to
		);
		$url = ""; 
		foreach($params as $k=>$p)$url .= $k."=".urlencode($p)."&";
		return $url;
	}
}
/**
 * 使用SpeedPHP框架的spAccess来进行多语言翻译缓存
 */
class GoogleTranslatePlus_Access
{
	/* 
	 * 获取缓存的翻译数据
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 */
	public function get_cached($from, $to, $str){
		$lang = spAccess('r',$from."|".$to);
		return ( !empty($lang[$str]) ) ? $lang[$str] : FALSE;
	}
	/* 
	 * 设置缓存的翻译数据
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 * @param value    翻译值
	 */
	public function set_cached($from, $to, $str, $value){
		$lang = spAccess('r',$from."|".$to);
		$lang[$str] = $value;
		spAccess('w',$from."|".$to,$lang);
	}
}

/**
 * 使用SpeedPHP框架的数据库类来进行多语言翻译缓存
 *
 * 需要先按照以下方式先建立google_translate_cached数据表
 * 
 * CREATE TABLE `google_translate_cached` (
 *   `google_translate_id` bigint(20) NOT NULL AUTO_INCREMENT,
 *   `gtran_from` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
 *   `gtran_to` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
 *   `gtran_str` varchar(250) DEFAULT NULL,
 *   `gtran_value` varchar(250) DEFAULT NULL,
 *   PRIMARY KEY (`google_translate_id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 *
**/
class GoogleTranslatePlus_DB extends spModel
{
	var $pk = "google_translate_id";
	var $table = "google_translate_cached";
	/* 
	 * 获取缓存的翻译数据
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 */	
	public function get_cached($from, $to, $str){
		$conditions = array(
			'gtran_from' => $from,
			'gtran_to' => $to,
			'gtran_str' => $str,
		);
		$result = $this->find($conditions);
		return (FALSE == $result) ? FALSE : $result["gtran_value"];
	}
	/* 
	 * 设置缓存的翻译数据
	 *
	 * @param from    原文语言的标识
	 * @param to    目标语言的标识
	 * @param str    需要翻译的字符串
	 * @param value    翻译值
	 */
	public function set_cached($from, $to, $str, $value){
		$newrows = array(
			'gtran_from' => $from,
			'gtran_to' => $to,
			'gtran_str' => $str,
			'gtran_value' => $value
		);
		$this->create($newrows);
	}
}