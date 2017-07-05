<?php
/**
* 模块
* @author Mr 2011.7.26
*/
class ctl_module_img extends desktop_controller {

    public $module_type = array(
        '1' => '幻灯片',
        '2' => '友情链接',
    );

	public function index(){

        $args = $this->spArgs();
        
        // 搜索
        if ($args['search'] == 'do'){
            if ($args['title']){
                $filter = ' mark_type = '.$args['mark_type'].' AND `mark_title` like \'%'.$args['title'].'%\' ';
                $this->title = $args['mark_title'];
            }
        }else{
            $filter = array('mark_type'=>$args['mark_type']);
        }

        $module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
        $module_list = $module_imgModel->spPager($this->spArgs('p',1), 10)->findAll($filter);     
        $this->pager = $module_imgModel->spPager()->getPager();

        $this->module_list = $module_list;
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }

        $this->mark_type = $args['mark_type'];
        $this->mark_type_name = $this->module_type[$args['mark_type']];
		$this->display('module_img.html');
	}

	public function add(){
		$this->edit('add');
	}

	public function edit($action='edit'){
		$args = $this->spArgs();
        $module_id = $args['module_id'];
		$this->module_id = $module_id;	

		if ($action == 'edit'){
            $module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
            $module_img = $module_imgModel->find(array('module_id'=>$module_id));
		}

        $this->action = $action;
        $this->mark_type = $args['mark_type'];
        $this->module = $module_img;
        $this->mark_type_name = $this->module_type[$args['mark_type']];
		$this->display('module_img_edit.html');
	}

	public function save(){

		$args = $this->spArgs();
        $goto_url = spUrl('desktop','ctl_module_img','index',array('mark_type'=>$args['mark_type']));

        if ($args['mark_title']){
			$module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
            $module_img_id = $args['module_img_id'];

            // 判断模块是否已经存在
            $sql = 'SELECT `module_id` FROM `'.$this->db_prefix.'b2c_module_img` WHERE `mark_title`=\''.$args['mark_title'].'\' AND `module_id` <> \''.$args['module_id'].'\' ';
			if ($module_imgModel->findSql($sql)){
                $this->msg('模块已存在');
			}

			$module_img_sdf = array(
				'mark_type' => $args['mark_type'],
				'mark_title' => $args['mark_title'],
				'mark_link' => $args['mark_link'],
				'mark_order' => $args['mark_order'],
				'contents' => $args['contents'],
 			);

            $funcObj = spClass('func','',$GLOBALS['G_SP']['lib_path'].'/func.php');
            $pic_path = $thumb_path = '';
            if ($_FILES['module_pic']['size']){
                $pic = $funcObj->upload($_FILES['module_pic'],$pic_path,$thumb_path,$msg,'false');
                if (!$pic){
                    $this->msg('模块图片上传失败');
                }
                $module_img_sdf['mark_pic'] = $pic_path;
                $module_img_sdf['mark_thumb'] = $thumb_path;
                // 删除之前的图片
                if ($args['old_pic']){
                    unlink(PUBLIC_NAME.'/'.$args['old_pic']);
                }
                if ($args['old_thumb']){
                    unlink(PUBLIC_NAME.'/'.$args['old_thumb']);
                }
            }

			switch($args['action']){
				case 'add':
                    $module_img_sdf = array_merge($module_img_sdf, array('createtime'=>time()));
					$module_imgModel->create($module_img_sdf);
					break;
				case 'edit':
					$module_imgModel->update(array('module_id'=>$args['module_id']),$module_img_sdf);
					break;
			}
            $this->msg('保存成功',$goto_url,'succ');
		}else{
            $this->msg('模块标题不能为空');
		}
	}

    /**
    * 检测模块是否存在
    * @access public
    * @param post $args 待检测模块数据
    * @return json result
    */
    public function check_module_img_name(){
        $args = $this->spArgs();
        $module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
        // 判断模块是否已经存在
        $sql = 'SELECT `module_id` FROM `'.$this->db_prefix.'b2c_module_img` WHERE `mark_title`=\''.$args['mark_title'].'\' AND `module_id` <> \''.$args['module_id'].'\' ';
        if ($module_imgModel->findSql($sql)){
            $result['rsp'] = 'fail';
            $result['msg'] = '模块已存在';
        }else{
            $result['rsp'] = 'succ';
        }
        die(json_encode($result));
    }

	/**
	* 删除模块
	* @param String $_GET
	* @return json
	*/
	public function del(){
		$args = $this->spArgs();
        $module_id = $args['module_id'];
        if (empty($module_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
            $module_detail = $module_imgModel->find(array('module_id'=>$module_id));
            if ( $module_imgModel->delete(array('module_id'=>$module_id)) ){
                if ($module_detail['mark_pic']){
                    $pic_path = PUBLIC_NAME.'/'.$module_detail['mark_pic'];
                    unlink($pic_path);
                }
                if ($module_detail['mark_thumb']){
                    $thumbpath = PUBLIC_NAME.'/'.$module_detail['mark_thumb'];
                    unlink($thumbpath);
                }
                $result = array('rsp'=>'succ');
            }
        }
		die(json_encode($result));
	}

    /**
    * 模块操作
    * @access public
    * @param POST
    * @return boolean
    */
    public function operator(){
        $args = $this->spArgs();
        $update_data = array();
        $update_flag = true;
        $module_img_ids = $args['module_id'];
        if (empty($module_img_ids)){
            $this->msg('请选择要操作的模块');
            exit;
        }
        $module_imgModel = spClass('module_img','',APP_PATH.'/b2c/model/module_img.php');
        switch($args['action']){
            case '1':// 删除
                if ($module_img_ids){
                    foreach ( $module_img_ids as $module_id ){
                        $module_detail = $module_imgModel->find(array('module_id'=>$module_id));
                        $module_imgModel->delete(array('module_id'=>$module_id));
                        if ($module_detail['mark_pic']){
                            $pic_path = PUBLIC_NAME.'/'.$module_detail['mark_pic'];
                            unlink($pic_path);
                        }
                        if ($module_detail['mark_thumb']){
                            $thumbpath = PUBLIC_NAME.'/'.$module_detail['mark_thumb'];
                            unlink($thumbpath);
                        }
                    }
                }
                $update_flag = false;
                break;
        }
        $url = spUrl('desktop','ctl_module_img','index',array('mark_type'=>$args['mark_type']));
        $this->msg('操作成功', $url, 'succ');      
    }

}