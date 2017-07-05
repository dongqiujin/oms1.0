<?php
class base_controller extends spController {
	
	public function __construct(){
		parent::__construct();

		$this->themes_dir = $GLOBALS['G_SP']['view']['config']['themes_dir'];
		$this->app_name = $GLOBALS['G_SP']['app']['name'];
		$this->base_url =  spBase::base_url();
        $this->website =  spBase::base_url(1);
        $this->public_dir = $this->website .'/'. PUBLIC_NAME;
        $this->statics_path = $this->website .'/app/'.$GLOBALS['G_SP']['app']['name'].'/statics';

        // 全局初始化
        $this->init();
	}

    private function init(){
        $this->name = $_SESSION['login'];
        $this->pid = $_GET['pid'];
        if (file_exists(ROOT_DIR.'/config/install.lock.php')){
            // 全局变量
            $sys_config = require APP_PATH.'/desktop/lib/sys_config.php';
            $GLOBALS['G_SP']['sp_cache'] = DATA_DIR.'/kvstore/system';
            foreach ((array)$sys_config as $key=>$sys){
                if (isset($sys['items'])){
                    foreach ((array)$sys['items'] as $item_key=>$items){
                        if (!isset($items['type']) || $items['type'] == 'text'){
                            $key_name = $key.'_'.$item_key;
                            $default = spAccess('r', $key_name);
                            $this->$key_name = $default ? $default : $items['default'];
                        }
                    }
                }
            }
        }        
    }

	/**
	 * 编辑模板时进行初始化
	 * @param string $tplname 模板文件名
	 * @param string $output 是否输出
	 */
	public function display($tplname, $output = TRUE){

		if ($output == FALSE){
			return parent::display($tplname,$output);
		}

		parent::display($tplname,$output);
	}


	/**
	 * 消息提示  应用程序的控制器类可以覆盖该函数以使用自定义的提示
	 * @param $msg   提示需要的相关信息
	 * @param $url   跳转地址
	 * @param $status 状态:error或者succ
	 *
	 */
	public function msg($msg, $url='', $status='error')
	{
		$this->msg = $msg;
		$this->url = $url ? $url : 'javascript:history.go(-1);';
		$this->status = $status;
		$this->display("message.html");
		exit();
	}

    /**
	 * 消息提示  应用程序的控制器类可以覆盖该函数以使用自定义的提示
	 * @param $msg   提示需要的相关信息
	 * @param $url   跳转地址
	 *
	 */
	public function error($msg)
	{
		$this->msg = $msg;
		$this->display("error.html");
        exit;
	}

}
