<?php
class desktop_controller extends spController {
	
	public function __construct(){
		parent::__construct();
		spBase::new_class('desktop_ctl_passport')->is_login();

		$this->themes_dir = $GLOBALS['G_SP']['view']['config']['themes_dir'];
		$this->app_name = $GLOBALS['G_SP']['app']['name'];
		$this->base_url =  spBase::base_url();
        $this->full_base_url = spBase::base_url(1);
        $this->public_dir = $this->full_base_url .'/'. PUBLIC_NAME;

        $this->db_prefix = $GLOBALS['G_SP']['db']['prefix'];
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
	 * @param $status 状态:error或者success
	 *
	 */
	public function msg($msg, $url='', $status='')
	{
		$this->msg = $msg;
		$this->url = $url ? 'self.window.location=\''.$url.'\'' : 'history.go(-1);';
		$this->status = $status;
		$this->display("msg.html");
		exit();
	}
}
