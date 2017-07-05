<?php
/**
* 模块
* @author Mr 2011.7.26
*/
class ctl_module extends desktop_controller {

	public function index(){

        $args = $this->spArgs();
        
        // 搜索
        if ($args['search'] == 'do'){
            if ($args['title']){
                $filter = ' `mark_title` like \'%'.$args['title'].'%\' ';
                $this->title = $args['mark_title'];
            }
        }

        $moduleModel = spBase::new_class('b2c_mdl_module');
        $module_list = $moduleModel->spPager($this->spArgs('p',1), 10)->findAll($filter);     
        $this->pager = $moduleModel->spPager()->getPager();

        $this->module_list = $module_list;
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
		$this->display('module.html');
	}

	public function add(){
		$this->edit('add');
	}

	public function edit($action='edit'){
		$args = $this->spArgs();
        $module_id = $args['module_id'];
		$this->module_id = $module_id;	

		if ($action == 'edit'){
			$moduleModel = spBase::new_class('b2c_mdl_module');
            $module = $moduleModel->find(array('module_id'=>$module_id));
		}

        $this->action = $action;
        $this->module = $module;
		$this->display('module_edit.html');
	}

	public function save(){

		$args = $this->spArgs();
        $goto_url = spUrl('desktop','ctl_module','index');

        if ($args['mark_type']){
			$moduleModel = spBase::new_class('b2c_mdl_module');
            $module_id = $args['module_id'];

            // 判断模块是否已经存在
            $sql = 'SELECT `module_id` FROM `'.$this->db_prefix.'b2c_module` WHERE `mark_type`=\''.$args['mark_type'].'\' AND `module_id` <> \''.$args['module_id'].'\' ';
			if ($moduleModel->findSql($sql)){
                $this->msg('模块已存在');
			}

			$module_sdf = array(
				'mark_type' => $args['mark_type'],
				'mark_title' => $args['mark_title'],
				'contents' => $args['contents'],
 			);

			switch($args['action']){
				case 'add':
					$moduleModel->create($module_sdf);
					break;
				case 'edit':
					$moduleModel->update(array('module_id'=>$args['module_id']),$module_sdf);
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
    public function check_module_name(){
        $args = $this->spArgs();
        $moduleModel = spBase::new_class('b2c_mdl_module');
        // 判断模块是否已经存在
        $sql = 'SELECT `module_id` FROM `'.$this->db_prefix.'b2c_module` WHERE `mark_type`=\''.$args['mark_type'].'\' AND `module_id` <> \''.$args['module_id'].'\' ';
        if ($moduleModel->findSql($sql)){
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
            $moduleModel = spBase::new_class('b2c_mdl_module');
            if ( $moduleModel->delete(array('module_id'=>$module_id)) ){
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
        $module_ids = $args['module_id'];
        if (empty($module_ids)){
            $this->msg('请选择要操作的模块');
            exit;
        }
        $moduleModel = spBase::new_class('b2c_mdl_module');
        switch($args['action']){
            case '1':// 删除
                if ($module_ids){
                    foreach ( $module_ids as $module_id ){
                        $moduleModel->delete(array('module_id'=>$module_id));
                    }
                }
                $update_flag = false;
                break;
        }
        $url = spUrl('desktop','ctl_module','index');
        $this->msg('操作成功', $url, 'succ');      
    }

}