<?php
/**
 * 安装主程序
 * @package setup
 * @version v1.0
 * @author dongdong
 */
class setup extends base_controller
{
    var $character_set = 'utf8';//默认字符集编码
	
	var $collate = 'utf8_general_ci';//默认校验规则
	
	/**
	 * 安装程序初始化
	 * 安装前需进行判断是否已锁定安装程序
	 * @access public 
	 * @param $setup_check bool 访问首页自动判断是否安装检查
	 */
	public function __construct($setup_check=FALSE){
		parent::__construct();
		//判断是否锁定安装程序
		if ($setup_check==FALSE and file_exists($this->lockfile())){
			$this->_lock(TRUE);
		}
		//判断compire_dir目录是否存在且可写
		$this->_compire_check();
		//安装日志临时文件名
		$this->setup_log_filename = ROOT_DIR.'/config/setup.log.txt';
		//换行符
		if (preg_match('/win/i',PHP_OS)) $line_break = "\r\n";
		else $line_break = "\n";
		$this->line_break = $line_break;
		//当前版本号
		if (file_exists(ROOT_DIR.'/version.txt')){
			$this->version = @file_get_contents(ROOT_DIR.'/version.txt');
		}
	}
	
	/**
	 * 阅读安装协议
	 * 安装程序开始，也即第一步:显示安装协议
	 * @access public
	 */
	public function index(){
		$this->tpl_title = "第一步:安装协议";
		$this->display("setup_index.html");
	}
	
	/**
	 * 安装程序第二步：检查环境
	 * 
	 * @access public
	 */
	public function step1(){
		$this->tpl_title = "第二步:检查环境";
		
		// 环境检查---------------------------------------------------------------
		$mysql_ver = mysql_get_client_info();
		$gd_ver = spClass('lib_system')->get_gd_version().'.0';
		$this->system_check = array(
			array(
				'name' => 'PHP版本',
		        'need_ver' => '5.0',
			    'cur_ver' => PHP_VERSION,
			),
			array(
				'name' => 'MYSQL版本',
		        'need_ver' => '4.0',
			    'cur_ver' => $mysql_ver,
			),
			array(
				'name' => 'GD库',
		        'need_ver' => '1.0',
			    'cur_ver' => $gd_ver,
			),
		);
		//环境检查各项检查结果，全部通过为true
		if (PHP_VERSION>='5.0' and $mysql_ver>='4.0' and $gd_ver>='1.0'){
			$system_check_result = true;
		}
		
		// 目录权限检查-----------------------------------------------------------
		$check_dir = array(
			'config',
			'data',
		);
		$dir_length = count($check_dir);
		$allow_count = 0;//各项检查结果初始值0
		for($i=0;$i<$dir_length;$i++){
			$check_result[$i]['name'] = '/'.$check_dir[$i];
			$check_result[$i]['need_status'] = '可写';
			if (is_writable($check_dir[$i])){
				$allow_count++;
				$status = 'allow';
			}else $status = 'deny';
			$check_result[$i]['cur_status'] = $status;
		}
		$this->dir_check = $check_result;
		unset($check_result);
		//目录检查各项结果，全部通过为true
		if ($allow_count==$dir_length){
			$dir_check_result = true;
		}
		
		// 函数检查----------------------------------------------------------------
		$function_list = array(
			'fopen',
			'fwrite',
		);
		$function_length = count($function_list);
		$allow_count = 0;//各项检查结果初始值0
		for($i=0;$i<$function_length;$i++){
			$check_result[$i]['name'] = $function_list[$i];
			if (function_exists($function_list[$i])){
				$allow_count++;
				$support = 'allow';
			}else $support = 'deny';
			$check_result[$i]['is_support'] = $support;
			$check_result[$i]['advice'] = '无';
		}
		$this->function_check = $check_result;
		unset($check_result);
		//函数检查各项结果，全部通过为true
		if ($allow_count==$function_length){
			$function_check_result = true;
		}
		
		//综合检查结果
		if (!$function_check_result or !$system_check_result or !$dir_check_result){
			$this->disabled = 'disabled="disabled"';
		}
		
		$this->display("setup_step1.html");
	}
	
	/**
	 * 安装第三步：填写安装配置
	 * @access public 
	 */
	public function step2(){
		$this->tpl_title = "第三步:配置文件";
		// 读取初始数据库配置信息
		$this->host = $GLOBALS['G_SP']['db']['host'];
		$this->port = $GLOBALS['G_SP']['db']['port']?$GLOBALS['G_SP']['db']['port']:'3306';
		$this->user = $GLOBALS['G_SP']['db']['login']?$GLOBALS['G_SP']['db']['login']:'root';
		$this->pass = $GLOBALS['G_SP']['db']['password'];
		$this->dbname = $GLOBALS['G_SP']['db']['database'];
		$this->prefix = $GLOBALS['G_SP']['db']['prefix']?$GLOBALS['G_SP']['db']['prefix']:'dong_';
		$this->display("setup_step2.html");
	}
	
	/**
	 * 开始安装
	 * 顺序依次是：更新配置文件、安装数据库及表数据、生成编译和缓文件
	 * @access public 
	 * @param spArgs POST或GET提交参数
	 */
	public function done(){
		
		sleep(1);//1秒后开始执行
		//清除安装日志文件
		if (file_exists($this->setup_log_filename)){
			unlink($this->setup_log_filename);
		}
		$args = $this->spArgs();
		
		//执行安装程序段------------------------
		//--更新配置文件
		$done1 = $this->_make_config($args);
		if (!$done1){
			die(json_encode(array('status'=>'error')));
		}
		//--安装数据表
		$done2 = $this->_create_table($args);
		if (!$done2){
			die(json_encode(array('status'=>'error')));
		}
		//--根据APP生成编译和缓文件
		$done3 = $this->_make_compire_cache_dir();
		if (!$done3){
			die(json_encode(array('status'=>'error')));
		}
		//--初始化数据
		$this->ini_install();
		error_log('all|'.$this->line_break,3,$this->setup_log_filename);
		die(json_encode(array('status'=>'succ')));
	}

	/**
	* 安装初始化数据
	*/
	public function ini_install(){
		$this->_ini_data('post_install');
	}

	/**
	* 维护初始化数据
	*/
	public function ini_update(){
		$this->_ini_data('post_update');
	}

	/**
	* 初始化数据
	* @param $method 初始化方法
	*/
	private function _ini_data($method='post_install'){
		$applist = spBase::applist();
		foreach ($applist as $app){
			$spclass_dir = APP_PATH.'/'.$app.'/task.php';
			if (file_exists($spclass_dir)){
				$class = spClass($app.'_task','',$spclass_dir);
				$class->$method($this->version);
			}
		}
		error_log('初始化数据'.'|succ'.$this->line_break,3,$this->setup_log_filename);
	}
	
	/**
	 * 获取安装日志文件信息 
	 * @param int $type 获取方式，默认1：行取；2：全取
	 * @param  int $cursor 当前指针
	 * @return json
	 */
	public function get_setup_log(){
		
		$args = $this->spArgs();
		$log_file = $this->setup_log_filename;
		$log_content = '';
		if (file_exists($log_file)){
			$fp = fopen($log_file, 'rb');
			fseek($fp, $args['cursor']);
			$log_content = fgets($fp);
			$cursor = ftell($fp);
			fclose($fp);
			$log_content = explode("|",str_replace($this->line_break, '', $log_content));
			$logcontent = array('item'=>$log_content[0], 'status'=>$log_content[1], 'cursor'=>$cursor);
			if ($log_content[0]=='all'){
				//--锁定安装程序
				$this->_make_lockfile();
				unlink($log_file);
			}
			if ($log_content[1]=='error'){
				//失败重新开始读
				$cursor = 0;
				unlink($log_file);
			}
			echo json_encode($logcontent);
			exit;
		}
	}
	
	/**
	 * 页面显示license证书信息
	 * @access public
	 */
	public function license(){
		$this->license_title = "安装协议";
		$license_path = ROOT_DIR.'/config/license.txt';
		$this->license_content = file_get_contents($license_path);
		$this->display("license.html");
	}
	
	/**
	 * 获取安装锁定文件名
	 * @access public
	 * @return path 路径
	 */
	public function lockfile(){
		return ROOT_DIR.'/config/install.lock.php';
	}
	
	/**
	 * 获取数据库列表
	 * @access public
	 * @param $localhost 主机
	 * @param $port 端口
	 * @param $user 数据库用户名
	 * @param $pwd 数据库密码
	 * @return json 数据库列表json格式
	 */
	public function db_list(){
		$db = $this->spArgs();
		$connect = $this->connect($db);
		$db_filter = array('mysql','information_schema','phpmyadmin','performance_schema');
		$db_query = mysql_query("SHOW DATABASES",$connect);
		while( $db_rs = mysql_fetch_assoc($db_query)){
			if (in_array($db_rs['Database'],$db_filter)) continue;
			$dblist[] = $db_rs['Database'];
		}
		mysql_close($connect);
		echo json_encode($dblist);
		exit;
	}
	
	/**
	 * 连接数据库
	 * @access public
	 * @param $db 数组存储，包含：主机\端口\数据库用户名\数据库密码
	 * @return resource 数据库连接句柄资源
	 */
	public function connect($db){
		if (!$db){
			$db = $this->spArgs();
		}
		$host = $db['host'];
		$port = $db['port'];
		$user = $db['user'];
		$pass = $db['pass'];
		$connect = mysql_connect($host.":".$port,$user,$pass);
		if (!$connect){
			die(json_encode(array('status'=>'error')));
		}
		mysql_query("SET NAMES ".$this->character_set);
		return $connect;
	}
	
	/**
	 * 分析数据表、索引具体代码段
	 * @access public
	 * @param String $app app名称
	 * @param array $db 数据 表文件数组
	 * @param string $prefix 表前缀
	 * @param string $type 操作类型：默认为空表示安装数据表；repair:为维护数据表
	 */
	public function exec_table($app, $db, $prefix, $type=NULL){
		
		$tb_key = array_keys($db);//表名
		$table_name = str_replace('_','',$prefix).'_'.$app.'_'.$tb_key[0];
		$engine = $db[$tb_key[0]]['engine'];//存储引擎
		$engine_name = $engine;
		$charset = $db[$tb_key[0]]['charset'];//字符集
		$collate = $db[$tb_key[0]]['collate'];//校验规则
		$columns = $db[$tb_key[0]]['columns'];//字段
		$table_comment = $db[$tb_key[0]]['comment'];//表注释
		$auto_increment_num = 0;
		$table_exists = false;
		if ($type == 'repair'){
			//判断当前表是否存在，则取出所有字段名称
			$database = $GLOBALS['G_SP']['db']['database'];
			$tb_result = @mysql_list_tables($database);
			while ($tbrow = @mysql_fetch_row($tb_result)){
				if ($table_name == $tbrow[0]){
					//获取当前表所有字段
					$field_result = @mysql_list_fields($database, $table_name);
					$field_nums = @mysql_num_fields($field_result);
					$fields = array();
					$fields_info = array();
					for ($i=0;$i<$field_nums;$i++){
						$field_name = @mysql_field_name($field_result, $i);
						$fields[] = $field_name;
						$fields_info[$field_name] = @mysql_fetch_field($field_result, $i);
					}
					$table_exists = true;
					break;
				}
			}
		}		
				
		$column = array();
		if ($columns)
		foreach ($columns as $k=>$v){
			$col = "";
			$data_type = $unsigend = $required = $default = $auto_increment = $unique = $primary = $comment = '';
			if ($auto_increment_num>1){
				error_log('数据表:'.$table_name.'(auto_increment必须唯一)|'.'error'.$this->line_break,3,$this->setup_log_filename);
				return false;
			}
			if ( !isset($v['type']) or empty($v['type']) ){
				error_log('数据表:'.$table_name.'(字段:'.$k.'没有定义数据类型)|'.'error'.$this->line_break,3,$this->setup_log_filename);
				return false;
			}
			$data_type = $v['type'];
			//判断char与varchar特殊字段是否指定长度
			if (!preg_match("/(\S*)\((\d+)\)$/i",$data_type)){
				if (preg_match("/^(char)|^(varchar)/i",$data_type)){
				error_log('数据表:'.$table_name.'(字段:'.$k.'没有定义数据长度)|'.'error'.$this->line_break,3,$this->setup_log_filename);
				return false;
				}
			}
			$enum_type = array();
			if (is_array($data_type)){
				foreach ($data_type as $ek=>$ev){
					$enum_type[] = "'".$ek."'";
				}
				$enum_type = implode(',',$enum_type);
				$data_type = 'enum('.$enum_type.')';
			}
			if (isset($v['required']) and $v['required']) $required = 'NOT NULL';
			if (isset($v['default'])) $default = 'DEFAULT \''.$v['default'].'\'';
			if (isset($v['auto_increment']) and $v['auto_increment']) $auto_increment = 'AUTO_INCREMENT';
			if ($auto_increment=='AUTO_INCREMENT') $auto_increment_num++;
			if (isset($v['unsigned']) and $v['unsigned']) $unsigend = 'UNSIGNED';
			if (isset($v['comment']) and $v['comment']) $comment = 'COMMENT \''.$v['comment'].'\'';
			if (isset($v['primary']) and $v['primary']) $primary = "PRIMARY KEY";
			if (isset($v['unique']) and $v['unique']) $unique = 'UNIQUE KEY';
			$col = $k.' '.$data_type.' '.$unsigend.' '.$required.' '.$default.' '.$auto_increment
			            .' '.$unique.' '.$primary.' '.$comment.' ';
				  
			//维护操作处理-----------------------------
			if ($type == 'repair' and $table_exists){
				//更新表字段
				if (in_array($k,$fields)){
					$operator = "MODIFY";
					$operator_name = "更新";
				
					//更新判断表当中是否已经存在：primary_key、unique_key，否则才更新
					if ($fields_info[$k]->primary_key){
						$col = str_replace("PRIMARY KEY","",$col);
					}
					if ($fields_info[$k]->unique_key){
						$col = str_replace("UNIQUE KEY","",$col);
					}
				}else{
					$operator = "ADD";
					$operator_name = "添加";
				}
				$tbsql = "ALTER TABLE {$table_name} {$operator} {$col}";

				if (mysql_query($tbsql)){
					$modify_result = 'succ';
				}else{
					$modify_result = 'error';
				}
				error_log($operator_name.'数据表('.$table_name.')字段'.$k.'|'.$modify_result.$this->line_break,3,$this->setup_log_filename);
				if ( $modify_result=='error' ){
					return false;
				}
			}else{//安装操作处理
				$column[] = $col;
			}
			            
		}
		if ($column) $column = implode(',',$column);
		
		//删除数据表中不存在的字段
		if ($type == 'repair' and $table_exists){
			$noexists_field = array_diff($fields, array_keys($columns));
			if ($noexists_field)
			foreach ($noexists_field as $fk=>$fv){
				mysql_query("ALTER TABLE {$table_name} DROP {$fv}");
			}
		}
		
		if (!$table_exists){
		    mysql_query("DROP TABLE IF EXISTS {$table_name}");
			if ($engine) $engine = " ENGINE ".$engine;
			if ($charset) $charset = " DEFAULT CHARSET=".$charset;
			if ($collate) $collate = " COLLATE ".$collate;
			$table_sql = "CREATE TABLE {$table_name} ({$column}) {$engine}{$charset}{$collate} COMMENT '".$table_comment."' ";
			if (mysql_query($table_sql)){
				$table_result = 'succ';
			}else{
				$table_result = 'error';
			}
			unset($table_sql);
			error_log('创建数据表:'.$table_name.'|'.$table_result.$this->line_break,3,$this->setup_log_filename);
			if ( $table_result=='error' ){
				return false;
			}
		}

		//获取当前表所有的索引
		if ($type == 'repair' and $table_exists){
			$exists_indexs = array();
			$index_query = @mysql_query("SHOW INDEX FROM {$table_name}");
			while ($index_row = @mysql_fetch_assoc($index_query)){
				if ($index_row['Non_unique']==1){
					$exists_indexs[] = $index_row['Key_name'];
				}
			}
		}
				
		//生成索引SQL
		$indexs = $db[$tb_key[0]]['index'];
		$index = array();
		if ($indexs)
		foreach ($indexs as $k=>$v){
			$index_type = '';
			if (is_array($v['columns'])){
				$index_columns = implode(',',$v['columns']);
			}else{
				$index_columns = $v['columns'];
			}
			//索引类型
			if (isset($v['index_type']) and !empty($v['index_type'])){
				$index_type = strtoupper($v['index_type']);
			}
			if (strtolower($engine_name)!='myisam' and strtolower($index_type)=='fulltext'){
				error_log('存储引擎:'.$engine.'的数据表:'.$table_name.'(不支持全文索引fulltext)|'.'error'.$this->line_break,3,$this->setup_log_filename);
				return false;
			}
			if ($exists_indexs and in_array($k,$exists_indexs)){
				//更新索引
				$index_sql = "ALTER TABLE {$table_name} DROP INDEX {$k} , ADD INDEX {$k} ($index_columns)";
				$index_operator = "更新";
			}else{
				//创建索引
				$index_sql = "CREATE {$index_type} INDEX ".$k." ON {$table_name} ($index_columns)";
				$index_operator = "创建";
			}
			if (mysql_query($index_sql)){
				$index_result = 'succ';
			}else{
				$index_result = 'error';
			}
			unset($index_sql);unset($engine_name);
			error_log($index_operator.'数据表'.$table_name.'索引,字段:'.$index_columns.'|'.$index_result.$this->line_break,3,$this->setup_log_filename);
			if ( $index_result=='error' ){
				return false;
			}
		}
		
		if ($type == 'repair' and $table_exists){
			//删除数据表中不存在的索引
			$noindexs = array_diff($exists_indexs, array_keys($indexs));
			if ($noindexs)
			foreach ($noindexs as $ik=>$iv){
				$drop_index = mysql_query("ALTER TABLE {$table_name} DROP INDEX {$iv}");
				if ($drop_index){
					$drop_index_result = 'succ';
				}else{
					$drop_index_result = 'error';
				}
				error_log('删除数据表'.$table_name.'索引'.$iv.'|'.$drop_index_result.$this->line_break,3,$this->setup_log_filename);
				if ( $drop_index_result=='error' ){
					return false;
				}
			}
			//更新表注释、存储引擎、字符集有校验规则
			@mysql_query("ALTER TABLE {$table_name} COMMENT='".$table_comment."'");
			@mysql_query("ALTER TABLE {$table_name} ENGINE='".$engine."'");
			@mysql_query("ALTER TABLE {$table_name} DEFAULT CHARACTER SET {$charset} COLLATE {$collate} ");
		}
		return true;
	}
	
	//以下部分为安装程序私有方法////////////////////////////////////////////////////
	/**
	 * 更新配置文件
	 * @access private
	 * @param $args 提交的配置文件参数
	 */
	private function _make_config($args){
		$config_filename = ROOT_DIR.'/config/config.php';
		if (!file_exists($config_filename)){
			$result = 'error';
		}else{
			$buffer = file_get_contents($config_filename);
			$fp = fopen($config_filename, 'w');
			$buffer = preg_replace('/[\'\"]__SQL_HOST__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_HOST__\' , '.'\''.$args['host'].'\'', $buffer);
			$buffer = preg_replace('/[\'\"]__SQL_PORT__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_PORT__\' , '.'\''.$args['port'].'\'', $buffer);
			$buffer = preg_replace('/[\'\"]__SQL_LOGIN__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_LOGIN__\' , '.'\''.$args['user'].'\'', $buffer);
			$buffer = preg_replace('/[\'\"]__SQL_PASSWORD__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_PASSWORD__\' , '.'\''.$args['pass'].'\'', $buffer);
			$buffer = preg_replace('/[\'\"]__SQL_DATABASE__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_DATABASE__\' , '.'\''.$args['database'].'\'', $buffer);
			$buffer = preg_replace('/[\'\"]__SQL_PREFIX__[\'\"]\s*\,\s*[\'\"](.*)[\'\"]/', '\'__SQL_PREFIX__\' , '.'\''.$args['prefix'].'\'', $buffer);
			fwrite($fp, $buffer);
			fclose($fp);
			$result = 'succ';
		}
		error_log('更新配置文件|'.$result.$this->line_break,3,$this->setup_log_filename);
		if ($result=='succ') return true;
		else return false;
	}
	
	/**
	 * 生成安装锁定文件 
	 * @access private
	 */
	private function _make_lockfile(){
		$lock_filename = $this->lockfile();
		$fp = fopen($lock_filename, 'a');
		$lock_content = 'Lock setup program!';
		if (fwrite($fp, $lock_content) === FALSE){
			$result = 'error';
		}else{
			$result = 'succ';
		}
		fclose($fp);
		
		//error_log('锁定安装程序|'.$result.$this->line_break,3,$this->setup_log_filename);
		if ($result=='succ') return true;
		else return false;
	}
	
	/**
	 * 创建数据库 create_database
	 * @access private
	 * @param array $db 数据库名
	 */
    private function _create_database($db){
		
    	if (!mysql_select_db($db)){
			//如果数据库存在,则删除
			mysql_query("DROP DATABASE IF EXISTS {$db}");
    		$dbsql = "CREATE DATABASE IF NOT EXISTS {$db} 
    		          DEFAULT CHARACTER SET {$this->character_set} COLLATE {$this->collate}";
    		if (mysql_query($dbsql)){
    			$result = 'succ';
    		}else{
    			$result = 'error';
    		}
    		$msg = '创建数据库';
    	}else{
    		$msg = '打开数据库';
    		$result = 'succ';
    	}
    	error_log($msg.'|'.$result.$this->line_break,3,$this->setup_log_filename);
    	
    	if ($result=='succ') return true;
		else return false;
	}
	
	/**
	 * 创建数据表 create_table
	 * @access private
	 * @param array $dbinfo 数据库配置参数:主机：端口、数据库用户名、密码、数据库名、表前缀,管理员帐号信息
	 */
    private function _create_table($dbinfo){
        
    	$conn = $this->connect($dbinfo);
    	if (!$conn){
    		$result = 'error';
    		error_log('数据库连接|'.$result.$this->line_break, 3 ,$this->setup_log_filename);
    		return false;
    	}else{
    		//创建并打开数据库
    		$select_db = $this->_create_database($dbinfo['database']);
    		if (!$select_db) return false;
    		mysql_select_db($dbinfo['database'],$conn);
    		//读取dbschema下的所有表文件
			$applist = spBase::applist();
			foreach ($applist as $app){
				$dbschema_dir = APP_PATH.'/'.$app.'/dbschema';
				$prefix = $dbinfo['prefix'] ? $dbinfo['prefix'] : $GLOBALS['G_SP']['db']['prefix'];
				$dh = opendir($dbschema_dir);
				while ( ($file = readdir($dh)) !== false){
				if (substr($file,strripos($file,'.')) == '.php'){
					$db = array();
					$run_result = true;
					include_once $dbschema_dir.'/'.$file;
					//分析并创建数据表、索引及其它表结构信息
					$run_result = $this->exec_table($app, $db, $prefix);
					if (!$run_result) return false;
				}
				}
				closedir($dh);
			}
			//--安装数据
			if ($this->_setup_data($dbinfo)){
				return true;
			}
    	}
		return true;
	}
	
	/**
	 * 安装数据
	 * @access private
	 * @param $args 管理员信息:帐号username，密码password、邮箱email,表前缀prefix
	 */
    private function _setup_data($args){
		
		$applist = spBase::applist();
		foreach ($applist as $app){
			$dbschema_dir = APP_PATH.'/'.$app.'/sql';
			$prefix = $args['prefix'] ? $args['prefix'] : $GLOBALS['G_SP']['db']['prefix'];
			$dh = opendir($dbschema_dir);
			if ($dh){
				while ( ($file = readdir($dh)) !== false){
				if ( substr($file,strripos($file,'.')) == '.sql' ){
					$sql = file_get_contents($dbschema_dir.'/'.$file);
                    $sql = str_replace('hua_', $prefix, $sql);
					//清空数据表
					$table = explode('.',$file);
					$table_name = str_replace('_','',$prefix).'_'.$app.'_'.$table[0];
					@mysql_query("TRUNCATE TABLE {$table_name}");

                    $sql_arr = explode("\n", $sql);
                    if (count($sql_arr)>1){
                        foreach ($sql_arr as $insert_sql){
                            if (!mysql_query($insert_sql)){
                                $load_result = 'error';
                                break;
                            }
                        }
                        $load_result = 'succ';
                    }else{
                        //导入数据
                        if (mysql_query($sql)){
                            $load_result = 'succ';
                        }else{
                            $load_result = 'error';
                        }
                    }
					error_log('导入sql文件'.$file.'到数据表'.$table[0].'|'.$load_result.$this->line_break,3,$this->setup_log_filename);
					if ($load_result=='error') return false;
				}
				}
			}
		}
		//插入管理员数据
		$table_name = str_replace('_','',$prefix).'_desktop_admin';
		$sql = "INSERT INTO {$table_name}(username,password,email,status) VALUES('".$args['admin_name']."','".md5($args['admin_password'])."','".$args['email']."','0')";
		if (mysql_query($sql)){
			$result = 'succ';
		}else{
			$result = 'error';
		}
		mysql_close($conn);
		error_log('添加管理员帐号信息到表'.$table_name.'|'.$result.$this->line_break,3,$this->setup_log_filename);
		if ($result=='error') return false;
		else return true;
	}
	
	/**
	 * 创建各APP目录下的编译及缓存文件夹
	 * @access private
	 */
    private function _make_compire_cache_dir(){
		
    	$app_dirname = spBase::applist();
    	$count_dirname = count($app_dirname);
    	for ($i=0;$i<$count_dirname;$i++){
    		//编译目录
    		$compile_dir = DATA_DIR.'/compile/'.$app_dirname[$i];
			if(!is_dir($compile_dir)){
				$return_compile = __mkdirs($compile_dir);
			}else{
				$return_compile = true;
			}
			if ($return_compile) $result = 'succ';else $result = 'error';
			error_log('APP:'.$app_dirname[$i].'编译目录创建|'.$result.$this->line_break,3,$this->setup_log_filename);
			if (!$return_compile) return false;
			
			//缓存目录
			$cache_dir = DATA_DIR.'/cache/'.$app_dirname[$i];
			if(!is_dir($cache_dir)) $return_cache = __mkdirs($cache_dir);
    		if(!is_dir($cache_dir)){
				$return_cache = __mkdirs($cache_dir);
			}else{
				$return_cache = true;
			}
			if ($return_cache) $result = 'succ';else $result = 'error';
			error_log('APP:'.$app_dirname[$i].'缓存目录创建|'.$result.$this->line_break,3,$this->setup_log_filename);
			if (!$return_cache) return false;
    	}
    	return true;
	}
	
	/**
	 * 锁定安装程序
	 * 对完成安装的程序进行锁定，也可进行提示已锁定信息
	 * @access private
	 * @param bool $status 锁定标识
	 * @return void
	 */
	private function _lock($status=FALSE){
		//未锁定处理
		if ($status==FALSE){
			//锁定操作
			$this->_make_lockfile();
		}else{
			$msg = '安装程序已锁定，如需重新安装，请删除 '.$this->lockfile();
			$this->_msg($msg);
		}
	}
	
	/**
	 * compire_dir目录是否存在且可写
	 * @access private
	 */
	private function _compire_check(){
		$data_dir = ROOT_DIR.'/'.$GLOBALS['G_SP']['_compile_dir'];
		if (!file_exists($data_dir)){
			$msg = $data_dir.'目录不存在，请先创建，并设置为777可写权限';
			$flag = true;
			
		}elseif (!is_writable($data_dir)){
			$msg = $data_dir.'目录不可写，请设置为777可写权限';
			$flag = true;
		}
		if ($flag==true){
			$this->_msg($msg);
		}
		$compile_dir = $GLOBALS['G_SP']['view']['config']['compile_dir'];
		if(!is_dir($compile_dir)) __mkdirs($compile_dir);
	}
	
	/**
	 * 提示消息
	 * @access private
	 * @param string $msg 消息
	 * @return void
	 */
	private function _msg($msg=''){
		header('Content-type:text/html',1,401);
	    header("Content-type: text/html; charset=utf-8");
		echo '<h3>'.$msg.'</h3><hr />';
        exit;
	}
}	