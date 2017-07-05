<?php
/**
 * 后端公共函数库
 * @author dongdong
 */
class func extends desktop_controller {
	
	public function __construct(){
		parent::__construct();
        $GLOBALS['G_SP']['sp_cache'] = DATA_DIR.'/kvstore/system';
	}

    public function getPaperType()
    {
        $config = include_once $GLOBALS['G_SP']['lib_path'].'/sys_config.php';
        $paperType = array();
        foreach ($config['paper_type']['item'] as $key=>$val) {
            $paperType[$key] = array(
                'type_id' => $key,
                'short_name' => $val['short_name'],
                'full_name' => $val['full_name']
            );
        }
        return $paperType;
    }
	
	/**
	 * 上传图片
	 * @access public
	 * @param $files
	 * @return boolean
	 */
	function upload($files,&$pic_path,&$thumb_path=array(),&$msg='',$autoThumb=false,$type='pic'){
        $upload_dir = array(
            PUBLIC_DIR,
            spAccess('r', 'sys_image_pic_path'),
            spAccess('r', 'sys_image_thumb_path'),
        );
		$upFlie = spClass("uploadFile", $upload_dir);
        $upFlie->autoThumb = $autoThumb;
        $common_size = spAccess('r', 'sys_image_thumb_normal_size');
        $common_size = explode('*', $common_size);
        $thumbWidth = $common_size[0];
        $thumbHeight = $common_size[1];
        $result = $upFlie->upload($files,$thumbWidth,$thumbHeight);
        $upFile->maxsize = spAccess('r', 'sys_image_maxsize');

        if (!$autoThumb){
            $sys_config = require $GLOBALS['G_SP']['lib_path'].'/sys_config.php';
            $sys_items = $sys_config['sys_image'];
            foreach ($sys_items['items'] as $item_key=>$items){
                if (isset($items['thumb']) && $items['thumb'] == 'true'){
                    if ($type == 'pic' && strstr($item_key, 'photo')) continue;
                    if ($type == 'photo' && !strstr($item_key, 'photo')) continue;
                    $thumb_size = spAccess('r',  $key.'_'.$item_key);
                    $thumb_size = $thumb_size ? $thumb_size : $items['default'];
                    if (!empty($thumb_size)){
                         $thumb_size_tmp = explode('*',$thumb_size);
                         $upFlie->thumb($upFlie->imgPath, $thumb_size_tmp[0], $thumb_size_tmp[1]); 
                         $thumb_path[$item_key] = $upFlie->thumb_name;
                    }
                }
            }
        }else{
            $thumb_path = $upFlie->thumb_name;
        }
		$msg = $upFlie->error;
        $pic_path = $upFlie->pic_name;

		if ($result){
			return true;
		}else{
			return false;
		}
	}
	
}