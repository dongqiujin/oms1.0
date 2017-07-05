<?php
/**
* 模板函数
* @copyright huahua 2011.7.17
* @author Mr.dong
*/
class view {
	
	public function smarty_img($params){
		if (!isset($params['app'])){
			$app = $GLOBALS['G_SP']['app']['name'];
		}else{
			$app = $params['app'];
		}
		$src = spBase::base_url().'/app/'.$app.'/statics/'.$params['src'];
		//unset($params['src']);
		$other_params = '';
		if ($params){
			foreach ($params as $key=>$value){
				$other_params .= $key.'=\''.$value.'\' ';
			}
		}
		return '<img src='.$src.' border=\'0\' '.$other_params.' />';
	}

	public function smarty_style($params){
		if (!isset($params['app'])){
			$app = $GLOBALS['G_SP']['app']['name'];
		}else{
			$app = $params['app'];
		}
		$href = spBase::base_url().'/app/'.$app.'/statics/'.$params['href'];
		$rel = $params['rel'] ? $params['rel'] : 'stylesheet';
		$type = $params['type'] ? $params['type'] : 'text/css';
		return '<link href=\''.$href.'\' rel=\''.$rel.'\' type=\''.$type.'\' />';
	}

	public function smarty_script($params){
		if (!isset($params['app'])){
			$app = $GLOBALS['G_SP']['app']['name'];
		}else{
			$app = $params['app'];
		}
		$src = spBase::base_url().'/app/'.$app.'/statics/'.$params['src'];
		return '<script src=\''.$src.'\' ></script>';
	}

    public function smarty_pager($params){
        if( !isset($params['pager']) || empty($params['pager']) )return '';
        if (!isset($params['app'])){
			$params['app'] = $GLOBALS['G_SP']['app']['name'];
		}else{
			$params['app'] = $params['app'];
		}
        $args = array();
        foreach($params as $k=>$v){
            if( !in_array($k, array('app','c','a','pager','myclass','mypage')) ){
                $args[$k] = $v;
            }
        }
        $pagerhandle = isset($params['pager']['mypage']) ? $params['pager']['mypage'] : 'p';
        $html = "<div class=\"{$params['myclass']}\">";
        if( $params['pager']['current_page'] != $params['pager']['first_page'] ){
            $url = spUrl($params['app'], $params['c'], $params['a'], $args+array($pagerhandle=>$params['pager']['prev_page']));
            $html .= "<a href=\"{$url}\">&lt; Prev</a>";
        }else{
            $html .= "<span class=\"disabled\">&lt; Prev</span>";
        }
        foreach( $params['pager']['all_pages'] as $p ){
            if( $p == $params['pager']['current_page'] ){
                $html .= "<span class=\"current\">{$p}</span>";
            }else{
                $url = spUrl($params['app'],$params['c'], $params['a'], $args+array($pagerhandle=>$p));
                $html .= "<a href=\"$url\">{$p}</a>";
            }
        }
        if( $params['pager']['current_page'] != $params['pager']['last_page'] ){
            $url = spUrl($params['app'],$params['c'],$params['a'],$args+array($pagerhandle=>$params['pager']['next_page']));
            $html .= "<a href=\"$url\">Next &gt;</a>";
        }else{
            $html .= "<span class=\"disabled\">Next &gt;</span>";
        }
        $html .= '</div>';
        return $html;
    }

}