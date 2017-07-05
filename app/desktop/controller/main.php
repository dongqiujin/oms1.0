<?php
class main extends desktop_controller {

	public function index(){


		// 菜单
		import($GLOBALS['G_SP']['lib_path'].'/menu.php');
		$this->menu = menu::get($default_menu);
		$this->default_menu = $default_menu;

		$this->username = $_SESSION['login_id'];
		$this->display('index.html');
	}

	public function welcome(){

		$this->display('welcome.html');
	}

}
