<?php
session_start();
class passport extends spController
{
	function __construct(){
		parent::__construct();
	}
	
	public function is_login(){
		if (!isset($_SESSION['login_id']) || !$_SESSION['login_id']){
			$url = spUrl('desktop','passport','login');
			header('Location:'.$url);
			exit;
		}
	}
	
	function do_login($username){
		$_SESSION['login_id'] = $username;
	}

	function do_logout(){
		$_SESSION['login_id'] = '';
		unset($_SESSION['login_id']);
		session_destroy();
	}

	function logout(){
		$this->do_logout();
		$url = spUrl('desktop','passport','login');
		header('Location:'.$url);
		exit;
	}

	function login(){
		if ($_POST){
			$args = $this->spArgs('','','post');
			$admin = spBase::new_class('desktop_mdl_admin');
			if (get_magic_quotes_gpc()){
				$username = stripslashes($args['username']);
			    $password = stripslashes($args['password']);
			}
			$username = addslashes($args['username']);
			$password = addslashes($args['password']);
			$site = addslashes($args['site']);
			if ($username && $password){
				$filter = array('username'=>$username);
				$admin_detail = $admin->find($filter,'','username,password');
				if ($username == $admin_detail['username'] && md5($password) == $admin_detail['password']){
					$this->do_login($username, $site);
					$url = spUrl('desktop','main','index');
			        header('Location:'.$url);
					exit;
				}else{
					$this->msg = '用户名和密码错误';
				}
			}else{
				$this->msg = '请输入用户名和密码';
			}
			$this->username = $username;
		}
	    $this->display('login.html');
	}
}	