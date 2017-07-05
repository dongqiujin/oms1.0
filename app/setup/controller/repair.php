<?php
/**
 * 数据库维护
 * @package repair
 * @version v1.0
 * @author dongdong
 */
class repair extends base_controller
{
	/**
	 * 维护程序初始化
	 * @access public 
	 */
	public function __construct(){
		parent::__construct();
		//安装日志临时文件名
		$this->setup_log_filename = ROOT_DIR.'/config/setup.log.txt';
		//换行符
		if (preg_match('/win/i',PHP_OS)) $line_break = "\r\n";
		else $line_break = "\n";
		$this->line_break = $line_break;

	}
	
	/**
	 * 维护入口页面
	 * @access public
	 */
	public function index(){
		$this->tpl_title = "维护程序";
		$this->display('repair_index.html');
	}
	
	/**
	 * 维护主程序
	 * @access public
	 */
	public function start_repair(){
		
		$spclass_dir = APP_PATH.'/setup/controller/setup.php';
		$setupObj = spClass('setup', array(true), $spclass_dir);
		$dbinfo = array();
		$dbinfo['host'] = $GLOBALS['G_SP']['db']['host'];
		$dbinfo['port'] = $GLOBALS['G_SP']['db']['port'];
		$dbinfo['user'] = $GLOBALS['G_SP']['db']['login'];
		$dbinfo['pass'] = $GLOBALS['G_SP']['db']['password'];
		$dbinfo['database'] = $GLOBALS['G_SP']['db']['database'];
		$prefix = $dbinfo['prefix'] = $GLOBALS['G_SP']['db']['prefix'];
		$conn = $setupObj->connect($dbinfo);
    	if (!is_resource($conn)){
    		$result = 'error';
    		error_log('数据库连接|'.$result.$this->line_break, 3 ,$this->setup_log_filename);
    		die(json_encode(array('status'=>'error')));
    	}else{
    		mysql_select_db($dbinfo['database'],$conn);
    		//读取dbschema下的所有表文件
			$applist = spBase::applist();
			foreach ($applist as $app){
				$dbschema_dir = APP_PATH.'/'.$app.'/dbschema';
				$dh = opendir($dbschema_dir);
				while ( ($file = readdir($dh)) !== false){
				if (substr($file,strripos($file,'.')) == '.php'){
					$db = array();
					$run_result = true;
					include_once $dbschema_dir.'/'.$file;
                    $filename = substr($file, 0, strrpos($file, '.'));
                    $lastModify = spAccess('r', $filename);
                    $curModify = filemtime($dbschema_dir.'/'.$file);
                    if ($curModify != $lastModify){
                        spAccess('w', $filename, $curModify);
                        //维护分析并创建数据表、索引及其它表结构信息
                        $run_result = $setupObj->exec_table($app, $db, $prefix, 'repair');
                        if (!$run_result){
                            die(json_encode(array('status'=>'error')));
                        }
                    }
				}
				}
				closedir($dh);
			}
    	}
		//维护初始化数据
        $setupObj->ini_update();
    	error_log('all|succ'.$this->line_break,3,$this->setup_log_filename);
		die(json_encode(array('status'=>'succ')));
	}
	
	/**
	 * 获取维护日志文件信息 
	 * @param int $type 获取方式，默认1：行取；2：全取
	 * @param  int $cursor 当前指针
	 * @return json
	 */
	public function get_repair_log(){
		
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
	
}	