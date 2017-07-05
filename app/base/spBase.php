<?php
class spBase{

	private static $request_obj = null;
	private static $new_class_obj = null;
	private static $_base_url = array();
    static $base_url = null;
	private static $_applist = array();

	public static function applist(){
		if (!self::$_applist){
			$hander = opendir(APP_PATH);
			$applist = array();
			while($file = readdir($hander)){
				if ($file != '.' && $file != '..' && $file != '.svn' && is_dir(APP_PATH.'/'.$file)){
					$applist[] = $file;
				}
			}
			closedir($hander);
			self::$_applist = $applist;
		}
		return self::$_applist;
	}

	static function request(){
        if(!isset(self::$request_obj)){
            self::$request_obj = spBase::new_class('base_request', array('1'));
        }
        return self::$request_obj;
    }

	static function new_class($class_name,$arg=array()){
        if(!isset(self::$new_class_obj[$class_name])){
            self::$new_class_obj[$class_name] = self::autoload($class_name, $arg);
        }
        return self::$new_class_obj[$class_name];
    }

	static function base_url($full=false){
		$c = ($full) ? 'true' : 'false';
		if(!isset(self::$_base_url[$c])){
			if(defined('BASE_URL')){
				if($full){
					self::$_base_url[$c] = constant('BASE_URL');
				}else{
					$url = parse_url(constant('BASE_URL'));
					if(isset($url['path'])){
						self::$_base_url[$c] = $url['path'];
					}else{
						self::$_base_url[$c] = '';
					}
				}
			}else{
				if(!isset(self::$base_url)){
					self::$base_url = self::request()->get_base_url();
				}

				if(self::$base_url == '/'){
					self::$base_url = '';
				}

				if($full){
					self::$_base_url[$c] = strtolower(self::request()->get_schema()).'://'.self::request()->get_host().self::$base_url;
				}else{
					self::$_base_url[$c] = self::$base_url;
				}
			}
		}
		return self::$_base_url[$c];
	}

	static function strip_magic_quotes(&$var){
        foreach($var as $k=>$v){
            if(is_array($v)){
                self::strip_magic_quotes($var[$k]);
            }else{
                $var[$k] = stripcslashes($v);
            }
        }
    }

	static function autoload($class_name,$args=array())
    {
        $p = strpos($class_name,'_');

        if($p){
            $owner = substr($class_name,0,$p);
            $class_name = substr($class_name,$p+1);
            $tick = substr($class_name,0,4);
            switch($tick){
            case 'ctl_':
                $path = APP_PATH.'/'.$owner.'/controller/'.str_replace('_','/',substr($class_name,4)).'.php';
                if(file_exists($path)){
                    require_once $path;
                }else{
                    trigger_error('controller file is not found',E_USER_ERROR);
                    exit;
                }
				break;
            case 'mdl_':
                $path = APP_PATH.'/'.$owner.'/model/'.str_replace('_','/',substr($class_name,4)).'.php';
                if(file_exists($path)){
                    require_once $path;
                }else{
					trigger_error('model file is not found',E_USER_ERROR);
                    exit;
                }
				break;
            default:
                $path = APP_PATH.'/'.$owner.'/lib/'.str_replace('_','/',$class_name).'.php';
                if(file_exists($path)){
                    require_once $path;
                }else{
					trigger_error('lib file is not found',E_USER_ERROR);
                    exit;
                }
            }
        }elseif(file_exists($path = APP_PATH.'/base/lib/'.$class_name.'.php')){
            require_once $path;
        }else{
			trigger_error('base_lib file is not found',E_USER_ERROR);
            exit;
        }
		if ($path){
			$argString = '';$comma = '';
			if(null != $args)for ($i = 0; $i < count($args); $i ++) { $argString .= $comma . "\$args[$i]"; $comma = ', '; }
			$class_name = str_replace('_','',substr($class_name,strrpos($class_name,'_')));
			eval("\$class_instance = new \$class_name(\$argString);");
			return $class_instance;
		}else{
			return false;
		}
    }

}