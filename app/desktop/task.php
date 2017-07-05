<?php
/**
* 任务初始化
*/
class desktop_task extends spController
{
	/*
	* 安装初始化
	*/
	function post_install($version){

		// 系统配置初始化
		$sys_config = require APP_PATH.'/desktop/lib/sys_config.php';
        $GLOBALS['G_SP']['sp_cache'] = DATA_DIR.'/kvstore/system';
		foreach ((array)$sys_config as $key=>$sys){
            if (isset($sys['items'])){
                foreach ((array)$sys['items'] as $item_key=>$items){
                    $item_name = $key.'_'.$item_key;
                    spAccess('w', $item_name, $items['default']);
                }
            }
        }
	}

	/*
	* 维护初始化
	*/
	function post_update(){
		//  
		
	}

}	