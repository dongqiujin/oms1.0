<?php
/**
* 系统配置
* @author Mr.dong
* @copyrigt huahua 2011.8.14
*/
class ctl_sys extends desktop_controller {

    public function __construct(){
        parent::__construct();
        $this->sys_config = require $GLOBALS['G_SP']['lib_path'].'/sys_config.php';
        $GLOBALS['G_SP']['sp_cache'] = DATA_DIR.'/kvstore/system';
    }

    /**
    * 系统配置展示
    * @access public
    */
	public function index(){

		// 获取系统配置
        $sys_config = $this->sys_config;
        foreach ((array)$sys_config as $key=>$sys){
            if (isset($sys['items'])){
                foreach ((array)$sys['items'] as $item_key=>$items){
                    $default = spAccess('r',  $key.'_'.$item_key);
                    if ($items['type'] == 'checkbox' && !empty($default)){
                        $default = explode(',',$default);
                    }
                    if ($default){
                        $sys_config[$key]['items'][$item_key]['default'] = $default;
                    }
                }
            }
        }
        $this->sys_config = $sys_config;
		$this->display('sys/index.html');
	}

    public function backup()
    {
        $this->display('sys/backup.html');
    }

    public function doBackup()
    {
        // 设置SQL文件保存文件名
        $filename=date("Y-m-d_H-i-s")."-22.sql";
        // 所保存的文件名
        header("Content-disposition:filename=".$filename);
        header("Content-type:application/octetstream");
        header("Pragma:no-cache");
        header("Expires:0");

        $connect = mysql_connect($GLOBALS['G_SP']['db']['host'].":".$GLOBALS['G_SP']['db']['port'],$GLOBALS['G_SP']['db']['login'],$GLOBALS['G_SP']['db']['password']);
        mysql_query("SET NAMES utf8");
        $database = $GLOBALS['G_SP']['db']['database'];
        $tb_result = @mysql_list_tables($GLOBALS['G_SP']['db']['database']);
        while ($tbrow = @mysql_fetch_row($tb_result)){
            $tableName = $tbrow[0];

            $createtable = mysql_query("SHOW CREATE TABLE $tableName");
            $create = mysql_fetch_row($createtable);
            $tabledump = $create[1].";\n\n";

            $rows = mysql_query("SELECT * FROM {$tableName}");
            $field_result = @mysql_list_fields($database, $tableName);
            $field_nums = @mysql_num_fields($field_result);
            while ($row = mysql_fetch_row($rows))
            {
                $comma = "";
                $tabledump .= "INSERT INTO {$tableName} VALUES(";
                for($i = 0; $i < $field_nums; $i++)
                {
                    $tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
                    $comma = ",";
                }
                $tabledump .= ");\n";
            }
            $tabledump .= "\n";
            echo $tabledump;
        }
        exit;
    }

    /**
    * 系统配置保存
    * @access public
    * @param $_POST
    * @return 将配置保存到文本中
    */
    public function save(){
        $args = $this->spArgs();
        if ($args){
            foreach ((array)$this->sys_config as $key=>$sys){
                if (isset($sys['items'])){
                    foreach ((array)$sys['items'] as $item_key=>$items){
                        $item_name = $key.'_'.$item_key;
                        if ($items['type'] == 'checkbox'){
                            $val = implode(',', $args[$item_name]);
                            $args[$item_name] = $val;
                        }
                        spAccess('w', $item_name, $args[$item_name]);
                    }
                }
            }
        }
        $url = spUrl('desktop','ctl_sys','index');
        $this->msg('保存成功',$url,'succ');
    }

    /**
    * 系统配置操作
    * @access public
    * @param $_POST
    * @return boolean
    */
    public function operator(){
        $args = $this->spArgs();
        $result = array();
        if (method_exists($this, $args['action'])){
            $result = $this->$args['action']($args['value']);
        }else{
            $result['rsp'] = 'fail';
            $result['msg'] = '没有定义动作方法';
        }
        die(json_encode($result));
    }

    /**
    * 邮件测试
    * @param String $mailto
    * @return 
    */
    private function sendemail($mailto){
        if ( empty($mailto) ) return array('rsp'=>'fail', 'msg'=>'请填写邮件地址');

        $email = spClass('sendemail','',APP_PATH.'/b2c/lib/sendemail.php');
        $result = $email->send($mailto);

        if ($result === true){
            return array('rsp'=>'succ', 'msg'=>'邮件发送成功');
        }else{
            $msg = $result ? implode(',', $result) : '邮件发送失败';
            return array('rsp'=>'fail', 'msg'=>$msg);
        }
    }

}
