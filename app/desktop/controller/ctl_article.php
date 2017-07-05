<?php
/**
* 文章
* @author Mr 2011.7.26
*/
class ctl_article extends desktop_controller {

	public function index(){

        $args = $this->spArgs();
        $this->type = $args['type'];
        if ($args['sort_name']){
            $sort = $args['sort_name'] . ' ' . $args['sort_type'];
        }else{
            $sort = 'createtime asc';
        }

        $filter = array('type'=>$args['type']);
        
        // 搜索
        if ($args['search'] == 'do'){
            if ($args['cat_id']){
                $filter = array_merge($filter,array('cat_id'=>$args['cat_id']));
            }
            if ($args['title']){
                $filter = ' `title` like \'%'.$args['title'].'%\' ';
                $this->title = $args['title'];
            }
        }

        $catModel = spBase::new_class('b2c_mdl_cat');
        $articleModel = spBase::new_class('b2c_mdl_article');
        $article_list = $articleModel->spPager($this->spArgs('p',1), 10)->findAll($filter,$sort);
        if ($article_list){
            foreach ( $article_list as $key=>$article ){
                $cat = $catModel->find(array('cat_id'=>$article['cat_id']));
                $article_list[$key]['cat_name'] = $cat['cat_name'];
            }
        }         
        $this->pager = $articleModel->spPager()->getPager();

        // 文章分类
		$cat = spClass('ctl_cat', '', APP_PATH.'/desktop/controller/ctl_cat.php');
		$cat->show('2');

        $this->article_list = $article_list;
        $this->article_type_name = $args['type'] == '1' ? '文章' : '自定义页';
        $this->sort_name = $args['sort_name'];
        $this->sort_type = $args['sort_type'];
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
		$this->display('article.html');
	}

	public function add(){
		$this->edit('add');
	}

	public function edit($action='edit'){
		$args = $this->spArgs();
        $article_id = $args['article_id'];
		$this->article_id = $article_id;	
        $this->type = $args['type'];

		if ($action == 'edit'){
			$articleModel = spBase::new_class('b2c_mdl_article');
            $article = $articleModel->find(array('article_id'=>$article_id));
		}

        if ($this->type == '1'){
            // 文章分类
            $cat = spClass('ctl_cat', '', APP_PATH.'/desktop/controller/ctl_cat.php');
            $cat->show('2');
        }

        $this->article_type_name = $args['type'] == '1' ? '文章' : '自定义页';
		$this->action = $action;
        $this->article = $article;
		$this->display('article_edit.html');
	}

	public function save(){

		$args = $this->spArgs();
        $goto_url = spUrl('desktop','ctl_article','index',array('class'=>'2','type'=>$args['type']));

		if ($args['title']){
			$articleModel = spBase::new_class('b2c_mdl_article');
            $article_id = $args['article_id'];

            // 判断文章是否已经存在
            $sql = 'SELECT `article_id` FROM `'.$this->db_prefix.'b2c_article` WHERE `title`=\''.$args['title'].'\' AND `article_id` <> \''.$args['article_id'].'\' ';
			if ($articleModel->findSql($sql)){
                $this->msg('文章已存在');
			}

			$article_sdf = array(
				'cat_id' => $args['cat_id'],
				'title' => $args['title'],
				'type' => $args['type'],
                'a_order' => $args['a_order'],
				'visit' => $args['visit'],
				'contents' => $args['contents'],
				'createtime' => time(),
 			);

			switch($args['action']){
				case 'add':
					$articleModel->create($article_sdf);
					break;
				case 'edit':
                    $article_sdf = array_merge($article_sdf, array('lastmodify'=>time()));
					$articleModel->update(array('article_id'=>$args['article_id']),$article_sdf);
					break;
			}
            $this->msg('保存成功',$goto_url,'succ');
		}else{
            $this->msg('文章标题不能为空');
		}
	}

    /**
    * 检测文章是否存在
    * @access public
    * @param post $args 待检测文章数据
    * @return json result
    */
    public function check_article_name(){
        $args = $this->spArgs();
        $articleModel = spBase::new_class('b2c_mdl_article');
        // 判断文章是否已经存在
        $sql = 'SELECT `article_id` FROM `'.$this->db_prefix.'b2c_article` WHERE `title`=\''.$args['title'].'\' AND `article_id` <> \''.$args['article_id'].'\' ';
        if ($articleModel->findSql($sql)){
            $result['rsp'] = 'fail';
            $result['msg'] = '文章已存在';
        }else{
            $result['rsp'] = 'succ';
        }
        die(json_encode($result));
    }

	/**
	* 删除文章
	* @param String $_GET
	* @return json
	*/
	public function del(){
		$args = $this->spArgs();
        $article_id = $args['article_id'];
        if (empty($article_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $articleModel = spBase::new_class('b2c_mdl_article');
            if ( $articleModel->delete(array('article_id'=>$article_id)) ){
                $result = array('rsp'=>'succ');
            }
        }
		die(json_encode($result));
	}

    /**
    * 文章操作
    * @access public
    * @param POST
    * @return boolean
    */
    public function operator(){
        $args = $this->spArgs();
        $update_data = array();
        $update_flag = true;
        $article_ids = $args['article_id'];
        if (empty($article_ids)){
            $this->msg('请选择要操作的文章');
            exit;
        }
        $articleModel = spBase::new_class('b2c_mdl_article');
        switch($args['action']){
            case '1':// 删除
                if ($article_ids){
                    foreach ( $article_ids as $article_id ){
                        $articleModel->delete(array('article_id'=>$article_id));
                    }
                }
                $update_flag = false;
                break;
            case '8': // 转移分类
                $update_data = array('cat_id'=>$args['target_cat']);
                break;
        }
        if ($update_flag){
            if ($article_ids){
                foreach ( $article_ids as $article_id ){
                    $articleModel->update(array('article_id'=>$article_id), $update_data);
                }
            }
        }
        $url = spUrl('desktop','ctl_article','index',array('class'=>'2'));
        $this->msg('操作成功', $url, 'succ');      
    }

}