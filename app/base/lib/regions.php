<?php
/**
* 地区
* @copyright huahua.com 2011.8.27
*/
class regions extends spController{

    /**
    * 获取下一级地区列表
    * @access public
    * @param Number $parent_id 父ID
    * @return 地区JSON数据
    */
    public function get_region($parent_id='0'){
        $regionModel = spBase::new_class('base_mdl_region');
        $filter = array('parent_id'=>$parent_id);
        $regions = $regionModel->findAll($filter);
        return $regions;
    }

}