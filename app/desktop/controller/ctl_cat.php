<?php
/**
* 分类
* @author Mr 2011.7.26
*/
class ctl_cat extends desktop_controller {

    public function __construct(){
        parent::__construct();
        $this->class_id = $this->spArgs('class') ? $this->spArgs('class') : '1';
    }

    public function index(){

        $this->show();
        $this->display('cat.html');
    }

    public function add(){
        $this->edit('add');
    }

    public function edit($action='edit'){
        $args = $this->spArgs();
        $this->pid = $args['pid'];
        $this->cid = $action == 'add' ? $args['cid'] : $args['pid'];

        if ($action == 'edit'){
            // 分类详情
            $catModel = spBase::new_class('b2c_mdl_cat');
            $cat_detail = $catModel->find(array('cat_id'=>$args['cid']));
            $this->cat_detail = $cat_detail;
        }
        $this->show('2');
        $this->action = $action;
        $this->display('cat_edit.html');
    }

    public function save(){
        $args = $this->spArgs();
        if ($args['cat_name']){
            $catModel = spBase::new_class('b2c_mdl_cat');
            $data = array(
                'parent_id' => $args['pid'],
                'cat_name' => $args['cat_name'],
                'cat_order' => $args['cat_order'],
                'disabled' => $args['disabled'],
                'class' => $args['class_id'],
            );
            // 判断同级分类是否已经存在
            $db_prefix = $GLOBALS['G_SP']['db']['prefix'];
            $sql = 'SELECT `cat_id` FROM `'.$db_prefix.'b2c_cat` WHERE `cat_name`=\''.$args['cat_name'].'\' AND parent_id=\''.$args['pid'].'\' AND `cat_id` <> \''.$args['cat_id'].'\' ';

            if ($catModel->findSql($sql)){
                die(json_encode(array('rsp'=>'fail','msg'=>'分类已存在')));
            }
            switch($args['action']){
                case 'add':
                    $catModel->create($data);
                    break;
                case 'edit':
                    $catModel->update(array('cat_id'=>$args['cat_id']),$data);
                    break;
            }
            $url = spUrl('desktop', 'cat', 'index');
            die(json_encode(array('rsp'=>'succ')));
        }else{
            die(json_encode(array('rsp'=>'fail','msg'=>'请输入分类名称')));
        }
    }

    /**
    * 删除分类
    * @param String $_GET
    * @return json
    */
    public function del(){
        $args = $this->spArgs();
        $catModel = spBase::new_class('b2c_mdl_cat');
        $result = array();
        switch($args['action']){
            case 'ask':
                if ($catModel->find(array('parent_id'=>$args['cid']))){
                    $result['rsp'] = 'fail';
                }else{
                    $catModel->delete(array('cat_id'=>$args['cid']));
                    $result['rsp'] = 'succ';
                }
                break;
            case 'del':
                if ($catModel->delete(array('parent_id'=>$args['cid']))){
                    $catModel->delete(array('cat_id'=>$args['cid']));
                    $result['rsp'] = 'succ';
                }else{
                    $result['rsp'] = 'fail';
                }
                break;
        }
        die(json_encode($result));
    }

    /**
    * 设为导航
    * @param String $_GET
    * @return json
    */
    public function daohang(){
        $args = $this->spArgs();
        $catModel = spBase::new_class('b2c_mdl_cat');
        $update_data = array('daohang'=>$args['daohang']);
        $catModel->update(array('cat_id'=>$args['cid']),$update_data);
        die(json_encode(array('rsp'=>'succ')));
    }

    /**
    * 扩展分类
    * @param
    */
    public function ext_cat(){
        $this->show('3');
        $this->ext_cat_id = $this->spArgs('ext_cat_id');
        $this->display('ext_cat.html');
    }

    /**
    * 显示方式
    * @param Number $type 默认为li列表,下拉框为2,选择框3
    */
    public function show($type='1'){
        $catModel = spBase::new_class('b2c_mdl_cat');
        $this->goodsModel = spBase::new_class('b2c_mdl_goods');
        $cat_data = $catModel->findAll(array('class'=>$this->class_id));
        $Tree = spClass('Tree', array($cat_data), APP_PATH.'/base/lib/Tree.php');
        $this->tree_data = $Tree->leaf();
        return $this->_show(false,'',0,$type);
    }

    private function _show($is_child=false,$child=array(),$grade=0,$show_type='1'){
        if (!$is_child){
            $tree = $this->tree_data;
        }else{
            $tree = $child;
        }
        if (empty($tree)){
            return;
        }

        foreach ((array)$tree as $key=>$v){
            if ($this->goods_cat == 'true' && $v['parent_id'] != '0') continue;
            // 显示分类
            $space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $grade);
            $img = isset($v['child']) ? '-' : '+';

            $goods_num = $this->goodsModel->findCount(array('cat_id'=>$v['cat_id']));
            $disabled = $v['disabled'] == '0' ? '是' : '否';

            switch($show_type){
                case '1':
                    $daohang = $v['daohang'] == '0' ? '<a href=\'javascript:;\' class=\'set_daohang\' cid=\''.$v['cat_id'].'\' pid=\''.$v['parent_id'].'\'>设为导航</a>' : '<a href=\'javascript:;\' class=\'cancel_daohang\' cid=\''.$v['cat_id'].'\' pid=\''.$v['parent_id'].'\'>取消导航</a>';
                    $daohang = $this->class_id == '1' && $v['parent_id'] == '0' ? $daohang : '';
                    $this->cat .= '<tr onmouseover="javascript:$(this).setStyle(\'color\',\'red\');" onmouseout="javascript:$(this).setStyle(\'color\',\'black\');">';
                    $this->cat .= '<td>'.$space.$img.$v['cat_name'].'</td><td align="center">'.$goods_num.'</td><td align="center">'.$daohang.'</td> <td align="center">'.$disabled.'</td> <td align="center">'.$v['cat_order'].'</td> <td align="center"><a href=\'javascript:;\' class=\'add\'  cid=\''.$v['cat_id'].'\' pid=\''.$v['parent_id'].'\'>添加子类</a>  <a href=\'javascript:;\' class=\'edit\' cid=\''.$v['cat_id'].'\' pid=\''.$v['parent_id'].'\'>编辑</a>  <a href=\'javascript:;\' class=\'del\' cid=\''.$v['cat_id'].'\' pid=\''.$v['parent_id'].'\'>删除</a></td>';
                    break;
                case '2':
                    $this->cat .= '<option value=\''.$v['cat_id'].'\'>'.$space.$img.$v['cat_name'].'</option>';
                    break;
                case '3':
                    $this->cat .= '<ul>';
                    if($v['disabled'] == '0' && $v['parent_id'] != '0'){
                        $checkbox = '<input type=\'checkbox\' label=\''.$v['cat_name'].'\' name=\'cat_id[]\' value=\''.$v['cat_id'].'\' />';
                    }
                    $this->cat .= '<li>'.$space.$checkbox.$v['cat_name'].'</li>';
                    break;
            }

            // 递归显示
            if (isset($v['child'])){
                $grade++;
                switch($show_type){
                    case '1':
                        //$this->cat .= '<tr>';
                        break;
                    case '3':
                        $this->cat .= '<li>';
                        break;
                }
                $this->_show(true,$v['child'],$grade,$show_type);
                switch($show_type){
                    case '1':
                        //$this->cat .= '</tr>';
                        break;
                    case '3':
                        $this->cat .= '</li>';
                        break;
                }
                $grade--;
            }

            switch($show_type){
                case '1':
                    $this->cat .= '</tr>';
                    break;
                case '3':
                    $this->cat .= '</ul>';
                    break;
            }
        }
    }

}
