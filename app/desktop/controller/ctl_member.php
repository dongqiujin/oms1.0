<?php
/**
* 会员
* @author Mr 2011.7.26
*/
class ctl_member extends desktop_controller {

	public function index(){

        $args = $this->spArgs();
        if ($args['sort_name']){
            $sort = $args['sort_name'] . ' ' . $args['sort_type'];
        }else{
            $sort = 'createtime desc';
        }
        
        // 搜索
        if ($args['search'] == 'do'){
            $filter = array();
            switch($args['type']){
                case '1': // 已激活
                case '2': // 未激活
                    $status = $args['type'] == '1' ? '1' : '0';
                    $filter = array('status'=>$status);
                    break;
            }
            if ($args['name']){
                $filter = ' `name` like \''.$args['name'].'%\' ';
                $this->name = $args['name'];
            }
            if ($args['email']){
                $filter = ' `email` like \''.$args['email'].'%\' ';
                $this->email = $args['email'];
            }
        }

        $memberModel = spBase::new_class('b2c_mdl_member');
        $member_list = $memberModel->spPager($this->spArgs('p',1), 10)->findAll($filter,$sort);
        $this->pager = $memberModel->spPager()->getPager();

        $this->member_list = $member_list;
        $this->sort_name = $args['sort_name'];
        $this->sort_type = $args['sort_type'];
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
		$this->display('member.html');
	}

    /**
    * 收货地址
    * @access public
    * @param Number $member_id 会员ID
    * @reutrn 会员信息
    */
    public function consignee(){
        $member_id = $this->spArgs('member_id');
        $memberModel = spBase::new_class('b2c_mdl_member');
        $members = $memberModel->spLinker()->find(array('member_id'=>$member_id));

        // 省市区region_id
        $consignee_area = $members['detail']['consignee_area'];
        $consignee_area = explode(':', $consignee_area);
        $consignee_area = explode('/', $consignee_area[2]);
        $this->province_id = $consignee_area[0];
        $this->city_id = $consignee_area[1];
        $this->district_id = $consignee_area[2];

        // 省级地区列表
        $regionModel = spClass('regions');
        $this->provice_list = $regionModel->get_region();

        $this->member = $members;
        $this->display('member_consignee.html');
    }

    /**
    * 修改收货地址
    * @access public 
    * @param $_POST
    * @return boolean
    */
    public function save_consignee(){
        $args = $this->spArgs();
        $member_id = $args['member_id'];
        $member_detailModel = spClass('member_detail', '', APP_PATH.'/b2c/model/member_detail.php');

        // 地区
        $regionModel = spBase::new_class('base_mdl_region');
        $region_province = $regionModel->find(array('region_id'=>$args['province']));
        $province_name = $region_province['region_name'];
        $region_city = $regionModel->find(array('region_id'=>$args['city']));
        $city_name = $region_city['region_name'];
        $region_district = $regionModel->find(array('region_id'=>$args['district']));
        $district_name = $region_district['region_name'];
        $consignee_area = ':'.$province_name.'/'.$city_name.'/'.$district_name.':'.$args['province'].'/'.$args['city'].'/'.$args['district'];

        $member_detail_sdf = array(
            'member_id' => $member_id,
            'consignee_name' => $args['consignee_name'],
            'consignee_sex' => $args['consignee_sex'],
            'consignee_age' => $args['consignee_age'],
            'consignee_phone' => $args['consignee_phone'],
            'consignee_mobile' => $args['consignee_mobile'],
            'consignee_postcode' => $args['consignee_postcode'],
            'consignee_area' => $consignee_area,
            'consignee_address' => $args['consignee_address'],
        );
        if ( $member_detailModel->findCount(array('member_id'=>$member_id)) ){
            $filter = array_shift($member_detail_sdf);
            $res = $member_detailModel->update($filter, $member_detail_sdf);
        }else{
            $res = $member_detailModel->create($member_detail_sdf);
        }
        $result['rsp'] = 'succ';
        die(json_encode($result));
    }    

    /**
    * 获取地区
    * @access public
    * @param Number $parent_id 父ID
    * @return 地区JSON数据
    */
    public function get_region(){
        $parent_id = $this->spArgs('parent_id');

        $regionModel = spClass('regions');
        $regions = $regionModel->get_region($parent_id);

        die(json_encode($regions));
    }

	/**
	* 删除会员
	* @param String $_GET
	* @return json
	*/
	public function del(){
		$args = $this->spArgs();
        $member_id = $args['member_id'];
        if (empty($member_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $memberModel = spBase::new_class('b2c_mdl_member');
            if ( $memberModel->spLinker()->delete(array('member_id'=>$member_id)) ){
                $result = array('rsp'=>'succ');
            }
        }
		die(json_encode($result));
	}

    /**
    * 会员操作
    * @access public
    * @param POST
    * @return boolean
    */
    public function operator(){
        $args = $this->spArgs();
        $update_data = array();
        $update_flag = true;
        $member_ids = $args['member_id'];
        if (empty($member_ids)){
            $this->msg('请选择要操作的会员');
            exit;
        }
        $memberModel = spBase::new_class('b2c_mdl_member');
        switch($args['action']){
            case '1':// 删除
                if ($member_ids){
                    foreach ( $member_ids as $member_id ){
                        $memberModel->spLinker()->delete(array('member_id'=>$member_id));
                    }
                }
                $update_flag = false;
                break;
        }
        $url = spUrl('desktop','ctl_member','index',array('class'=>'2'));
        $this->msg('操作成功', $url, 'succ');      
    }

    /**
    * 发送邮件
    * @access public
    * @param Number $member_id 会员ID
    * @reutrn
    */
    public function sendmail(){
        $args = $this->spArgs();
        $member_id = $args['member_id'];
        $memberModel = spBase::new_class('b2c_mdl_member');
        $this->member = $memberModel->find(array('member_id'=>$member_id));

        // 邮件模板内容
        $this->conf_email_title = spAccess('r', 'conf_email_title');
        $this->conf_email_content = base64_decode(unserialize(spAccess('r', 'conf_email_content')));

        $this->display('sendmail.html');
    }

    // 发邮件
    public function send(){
        $args = $this->spArgs();
        $email = spClass('sendemail','',APP_PATH.'/b2c/lib/sendemail.php');
        
        $msg = $email->send($args['sendto'], $args['conf_email_title'], $args['conf_email_content']);
        if ($msg === true){
            $result['rsp'] = 'succ';
        }else{
            $result['rsp'] = 'fail';
            $result['msg'] = @implode(',', $msg);
        }
        die(json_encode($result));
    }

    /**
    * 保存邮件模板
    * @access public
    * @param Number $_POST
    * @reutrn
    */
    public function save_mail_template(){
        $args = $this->spArgs();
        spAccess('w', 'conf_email_title', $args['conf_email_title']);
        spAccess('w', 'conf_email_content', serialize(base64_encode($args['conf_email_content'])));
        $result['rsp'] = 'succ';
        die(json_encode($result));
    }

}