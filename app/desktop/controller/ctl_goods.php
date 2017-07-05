<?php
/**
* 商品管理
* @author Mr 2011.7.26
*/
class ctl_goods extends desktop_controller {

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
                case '5': // 上架
                case '6': // 下架
                    $marketable = $args['type'] == '5' ? '1' : '0';
                    $filter = array('marketable'=>$marketable);
                    break;
                case '1': // 热销
                case '2': // 取消热销
                    $is_hot = $args['type'] == '1' ? '1' : '0';
                    $filter = array('is_hot'=>$is_hot);
                    break;
                case '3': // 特惠
                case '4': // 取消特惠
                    $is_special = $args['type'] == '3' ? '1' : '0';
                    $filter = array('is_special'=>$is_special);
                    break;
            }
            if ($args['cat_id']){
                $filter = array_merge($filter,array('cat_id'=>$args['cat_id']));
            }
            if ($args['name']){
                $filter = ' `name` like \'%'.$args['name'].'%\' ';
                $this->name = $args['name'];
            }
            if ($args['bn']){
                $filter = ' bn like \'%'.$args['bn'].'%\' ';
                $this->bn = $args['bn'];
            }
        }

        $goodsModel = spBase::new_class('b2c_mdl_goods');
        $goods_list = $goodsModel->spPager($this->spArgs('p',1), 20)->findAll($filter,$sort);
		$this->pager = $goodsModel->spPager()->getPager();

        // 商品分类
		$cat = spClass('ctl_cat', '', APP_PATH.'/desktop/controller/ctl_cat.php');
		$cat->show('2');

        $this->goods_list = $goods_list;
        $this->sort_name = $args['sort_name'];
        $this->sort_type = $args['sort_type'];
        $this->type = $args['type'];
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
		$this->display('goods/goods_list.html');
	}

	public function add(){
		$this->edit('add');
	}

	public function edit($action='edit'){
		$args = $this->spArgs();
        $goods_id = $args['goods_id'];
		$this->goods_id = $goods_id;		

		if ($action == 'edit'){
			$goodsModel = spBase::new_class('b2c_mdl_goods');
            $goods = $goodsModel->spLinker()->find(array('goods_id'=>$goods_id));

            // 扩展分类
            $ext_cat_names = $ext_cat_id = array();
            $catModel = spBase::new_class('b2c_mdl_cat');
            if ($goods['goods_cat']){
                foreach ($goods['goods_cat'] as $ext_cat){
                    $cats = $catModel->find(array('cat_id'=>$ext_cat['cat_id']));
                    $ext_cat_names[] = $cats['cat_name'];
                    $ext_cat_id[] = $ext_cat['cat_id'];
                }
                $ext_cat_names = $ext_cat_names ? implode(',',$ext_cat_names) : '';
                $ext_cat_id = $ext_cat_id ? implode(',',$ext_cat_id) : '';
            }

            // 商品相册
            if ($goods['goods_img']){
                $imagesModel = spBase::new_class('b2c_mdl_images');
                $goods_img = $goods['goods_img'];
                $flag = count($goods_img) > '1' ? true : false;
                foreach ($goods_img as $key=>$img){
                    $images = $imagesModel->find(array('img_id'=>$img['img_id']));
                    $thumb = unserialize($images['thumb']);
                    if (is_array($thumb)){
                        $thumb = isset($thumb['thumb_normal_size']) ? $thumb['thumb_normal_size'] : $thumb['thumb_photo_big'];
                    }else{
                        $thumb = $images['thumb'];
                    }
                    if ($img['is_cover']){
                        $goods['pic'] = $images['pic'];
                        $goods['thumb'] = $thumb;
                    }
                    if ($flag && $img['is_cover'] == '1'){
                        unset($goods['goods_img'][$key]);
                        continue;
                    }
                    $goods['goods_img'][$key]['pic'] = $images['pic'];
                    $goods['goods_img'][$key]['thumb'] = $thumb;
                }
            }
		}

        // 商品分类
		$cat = spClass('ctl_cat', '', APP_PATH.'/desktop/controller/ctl_cat.php');
        $cat->goods_cat = 'true';
		$cat->show('2');

		$this->action = $action;
        $this->goods = $goods;
        $this->ext_cat_names = $ext_cat_names;
        $this->ext_cat_id = $ext_cat_id;
		$this->display('goods/goods.html');
	}

	public function save(){

        $goto_url = spUrl('desktop','ctl_goods','index');
		$args = $this->spArgs();

		if ($args['name'] && $args['cat_id']){
			$goodsModel = spBase::new_class('b2c_mdl_goods');
            $goods_imgModel = spClass('goods_img', '', APP_PATH.'/b2c/model/goods_img.php');
            $goods_catModel = spClass('goods_cat', '', APP_PATH.'/b2c/model/goods_cat.php');
            $funcObj = spClass('func','',$GLOBALS['G_SP']['lib_path'].'/func.php');
            $imgaegsModel = spBase::new_class('b2c_mdl_images');
            $goods_id = $args['goods_id'];

            // 判断商品是否已经存在
            $sql = 'SELECT `goods_id` FROM `'.$this->db_prefix.'b2c_goods` WHERE `name`=\''.$args['name'].'\' AND `goods_id` <> \''.$args['goods_id'].'\' ';
			if ($goodsModel->findSql($sql)){
                echo "<script>window.parent.Finish('商品已存在');parent.$('save').set('disabled', false);</script>";
                exit;
			}

            // 扩展分类
            if ($args['ext_cat_id']){
                $cat = explode(',',$args['ext_cat_id']);
                $ext_cat_sdf = array();
                foreach ($cat as $cat_id){
                    $ext_cat_sdf[] = array(
                        'cat_id' => $cat_id,
                    );
                }
            }

            // 商品图片及缩略图
            $pic_path = $thumb_path = '';
            if ($_FILES['pic']['size']){
                $pic = $funcObj->upload($_FILES['pic'],$pic_path,$thumb_path,$msg,false);
                if (!$pic){
                    echo "<script>window.parent.Finish('{$msg}');parent.$('save').set('disabled', false);</script>";
                    exit;
                }
            }
            if ($pic_path || $thumb_path){
                $images_sdf = array(
                    'pic' => $pic_path,
                    'thumb' => serialize($thumb_path),
                );
                $img_id = $imgaegsModel->create($images_sdf);
                $goods_img_sdf[] = array(
                    'img_id' => $img_id,
                    'is_cover' => '1',
                );
            }

            // 商品相册
            if ($_FILES['photo']){
                $photo = count($_FILES['photo']['name']);
                for ($i=0;$i<=$photo;$i++){
                    if ($_FILES['photo']['size'][$i]){
                        $files = array(
                            'name' => $_FILES['photo']['name'][$i],
                            'tmp_name' => $_FILES['photo']['tmp_name'][$i],
                            'type' => $_FILES['photo']['type'][$i],
                            'size' => $_FILES['photo']['size'][$i],
                            'error' => $_FILES['photo']['error'][$i],
                        );
                        $photo_result = $funcObj->upload($files,$photo_pic_path,$photo_thumb_path,$msg,false,'photo');
                        if (!$photo_result){
                            echo "<script>window.parent.Finish('{$msg}');parent.$('save').set('disabled', false);</script>";
                            exit;
                        }
                        if ($photo_pic_path){
                            $images_sdf = array(
                                'pic' => $photo_pic_path,
                                'thumb' => serialize($photo_thumb_path),
                            );
                            $img_id = $imgaegsModel->create($images_sdf);
                            $goods_img_sdf[] = array(
                                'img_id' => $img_id,
                                'is_cover' => '0',
                            );
                        }
                    }
                }
            }

			$goods_sdf = array(
				'cat_id' => $args['cat_id'],
				'name' => $args['name'],
				'bn' => $args['bn'],
				'market_price' => $args['market_price'],
                'sales_num' => $args['sales_num'],
				'sales_price' => $args['sales_price'],
				'marketable' => $args['marketable'],
				'stock' => $args['stock'],
				'is_best' => $args['is_best'],
				'is_new' => $args['is_new'],
				'is_hot' => $args['is_hot'],
				'is_special' => $args['is_special'],
				'createtime' => time(),
                'goods_contents' => array(
                    'material' => $args['material'],
                    'packaging' => $args['packaging'],
                    'flower_language' => $args['flower_language'],
                    'attached' => $args['attached'],
                    'delivery' => $args['delivery'],
                    'description' => $args['description'],
                    'contents' => $args['contents'],
                ),
                'goods_cat' => $ext_cat_sdf,
                'goods_img' => $goods_img_sdf,
			);

            // 还原缩略图标识
            if ($pic_path){
                $goods_imgModel->update(array('goods_id'=>$goods_id),array('is_cover'=>'0'));
            }

            // 清除管理员删除的商品相册
            $del_img_ids = explode(',',$args['del_img_ids']);
            if ($del_img_ids){
                foreach ($del_img_ids as $img_id){
                    if (!$img_id) continue;
                    $images = $imgaegsModel->find(array('img_id'=>$img_id));
                    $goods_imgModel->delete(array('img_id'=>$img_id,'goods_id'=>$goods_id));
                    $imgaegsModel->delete(array('img_id'=>$img_id));
                    // 删除原图
                    $pic_path = PUBLIC_NAME.'/'.$images['pic'];
                    unlink($pic_path);
                    // 删除缩略图
                    $thumb_list = unserialize($images['thumb']);
                    if ($thumb_list){
                        foreach ( $thumb_list as $thumb_path ){
                            if (empty($thumb_path)) continue;
                            $thumbpath = PUBLIC_NAME.'/'.$thumb_path;
                            unlink($thumbpath);
                        }
                    }else{
                        $thumb_path = PUBLIC_NAME.'/'.$images['thumb'];
                        unlink($thumb_path);
                    }
                }
            }

			switch($args['action']){
				case 'add':
					$goodsModel->spLinker()->create($goods_sdf);
					break;
				case 'edit':
                    unset($goods_sdf['createtime']);
					$goodsModel->spLinker()->update(array('goods_id'=>$args['goods_id']),$goods_sdf);

                    // 扩展分类更新
                    $goods_catModel->delete(array('goods_id'=>$args['goods_id']));
                    if ($ext_cat_sdf){
                        foreach ($ext_cat_sdf as $ext){
                            $ext_data = array(
                                'goods_id'=>$args['goods_id'],
                                'cat_id'=>$ext['cat_id'],
                            );
                            $goods_catModel->create($ext_data);
                        }
                    }
                    
                    // 商品相册更新
                    if ($goods_img_sdf){
                        foreach ($goods_img_sdf as $img){
                            $img_data = array(
                                'goods_id'=>$goods_id,
                                'img_id'=>$img['img_id'],
                                'is_cover'=>$img['is_cover'],
                            );
                            $goods_imgModel->create($img_data);
                        }
                    }
					break;
			}
            echo "<script>window.parent.Finish('保存成功','{$goto_url}');</script>";
            exit;
		}else{
            echo "<script>window.parent.Finish('商品名称与分类不能为空');parent.$('save').set('disabled', false);</script>";
            exit;
		}
	}

    /**
    * 单个字段在线编辑
    * @access public
    * @param $_POST
    * @return boolean
    */
    public function editab(){
        $args = $this->spArgs();
        $repeat_check = array('name'=>'商品名称','bn'=>'商品编号');
        $goodsModel = spBase::new_class('b2c_mdl_goods');
        $field_name = $args['field_name'];
        if (IS_NULL($args[$field_name])){
            $result['rsp'] = 'fail';
            $result['msg'] = '不能设置空值';
            die(json_encode($result));
        }
        if (in_array($args['field_name'], array_keys($repeat_check))){
            $sql = 'SELECT `goods_id` FROM `'.$this->db_prefix.'b2c_goods` WHERE `'.$field_name.'`=\''.$args[$field_name].'\' AND `goods_id` <> \''.$args['goods_id'].'\' ';
            if ($goodsModel->findSql($sql)){
                $result['rsp'] = 'fail';
                $result['msg'] = $repeat_check[$field_name].'已存在';
                die(json_encode($result));
            }
        }
        
        // 更新字段值
        $update = array($field_name=>$args[$field_name]);
        if ($goodsModel->update(array('goods_id'=>$args['goods_id']), $update)){
            $result['rsp'] = 'succ';
        }else{
            $result['rsp'] = 'fail';
        }
        die(json_encode($result));
    }

    /**
    * 检测商品是否存在
    * @access public
    * @param post $args 待检测商品数据
    * @return json result
    */
    public function check_goods_name(){
        $args = $this->spArgs();
        $goodsModel = spBase::new_class('b2c_mdl_goods');
        // 判断商品是否已经存在
        $sql = 'SELECT `goods_id` FROM `'.$this->db_prefix.'b2c_goods` WHERE `name`=\''.$args['name'].'\' AND `goods_id` <> \''.$args['goods_id'].'\' ';
        if ($goodsModel->findSql($sql)){
            $result['rsp'] = 'fail';
            $result['msg'] = '商品已存在';
        }else{
            $result['rsp'] = 'succ';
        }
        die(json_encode($result));
    }

	/**
	* 删除商品
	* @param String $_GET
	* @return json
	*/
	public function del(){
		$args = $this->spArgs();
        $goods_id = $args['goods_id'];
        if (empty($goods_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $result = $this->_del_goods($goods_id);
        }
		die(json_encode($result));
	}

    /**
    * 商品操作
    * @access public
    * @param POST
    * @return boolean
    */
    public function operator(){
        $args = $this->spArgs();
        $update_data = array();
        $update_flag = true;
        $goods_ids = $args['goods_id'];
        if (empty($goods_ids)){
            $this->msg('请选择要操作的商品');
            exit;
        }
        switch($args['action']){
            case '1':// 删除
                if ($goods_ids){
                    foreach ( $goods_ids as $goods_id ){
                        $this->_del_goods($goods_id);
                    }
                }
                $update_flag = false;
                break;
            case '2': // 上架
            case '3': // 下架
                $marketable = $args['action'] == '2' ? '1' : '0';
                $update_data = array('marketable'=>$marketable);
                break;
            case '4': // 热销
            case '5': // 取消热销
                $is_hot = $args['action'] == '4' ? '1' : '0';
                $update_data = array('is_hot'=>$is_hot);
                break;
            case '6': // 特惠
            case '7': // 取消特惠
                $is_special = $args['action'] == '6' ? '1' : '0';
                $update_data = array('is_special'=>$is_special);
                break;
            case '8': // 转移分类
                $update_data = array('cat_id'=>$args['target_cat']);
                break;
        }
        if ($update_flag){
            $goodsModel = spBase::new_class('b2c_mdl_goods');
            if ($goods_ids){
                foreach ( $goods_ids as $goods_id ){
                    $goodsModel->update(array('goods_id'=>$goods_id), $update_data);
                }
            }
        }
        $url = spUrl('desktop','ctl_goods','index');
        $this->msg('操作成功', $url, 'succ');      
    }

    private function _del_goods($goods_id){
        $goodsModel = spBase::new_class('b2c_mdl_goods');
        $goods_imgModel = spClass('goods_img', '', APP_PATH.'/b2c/model/goods_img.php');
        $imgaegsModel = spBase::new_class('b2c_mdl_images');
        
        // 查找商品与图片关联数据
        $goods_img = $goods_imgModel->findAll(array('goods_id'=>$goods_id));
        if($goodsModel->spLinker()->delete(array('goods_id'=>$goods_id))){
            // 删除商品图片
            if ($goods_img){
                foreach ($goods_img as $img){
                    $img_id = $img['img_id'];
                    $images = $imgaegsModel->find(array('img_id'=>$img_id));
                    $imgaegsModel->delete(array('img_id'=>$img_id));
                    $pic_path = PUBLIC_NAME.'/'.$images['pic'];
                    $thumb_path = PUBLIC_NAME.'/'.$images['thumb'];
                    unlink($pic_path);unlink($thumb_path);
                }
            }
            $result['rsp'] = 'succ';
        }else{
            $result['rsp'] = 'fail';
            $result['res'] = '删除失败';
        }
        return $result;
    }


}