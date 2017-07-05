<?php
/**
* 菜单类
* @package menu
* @copyright huahua 2011.7.23
* @author Mr.dong
*/
class menu{
	
	/**
	* 获取菜单
	* @access public
	* @return Array
	*/
	public static function get(&$default_menu){
		$xml_path = APP_PATH.'/'.$GLOBALS['G_SP']['app']['name'].'/menu.xml';
		$dom = new DOMDocument();
		$dom->load($xml_path);
		$menuDom = $dom->getElementsByTagName('menu');
		$menu_arr = array();
		$default_menu = array();
		foreach ($menuDom as $k=>$menu)
		{
			$menu_arr[$k] = array(
				'name' => $menu->getAttribute('name'),
				'id' => $menu->getAttribute('id'),
			);
			$submenuDom = $menu->getElementsByTagName('submenu');
			foreach($submenuDom as $sk=>$submenu){
				$menu_arr[$k]['submenu'][$sk] = array(
					'name' => $submenu->getAttribute('name'),
				);
				$itemDom = $submenu->getElementsByTagName('item');
				foreach($itemDom as $ik=>$item){
					if ($item->getAttribute('display') == 'false') continue;
					$ctl = $item->getAttribute('ctl');
					$act = $item->getAttribute('act');
					$params = $item->getAttribute('params');
                    if ($params){
                        $para = array();
                        foreach (explode('|',$params) as $val){
                            $p = explode('=',$val);
                            $para[$p[0]] = $p[1];
                        }
                    }
					$menu_arr[$k]['submenu'][$sk]['item'][$ik] = array(
						'name' => $item->nodeValue,
						'ctl' => $ctl,
						'act' => $act,
						'url' => spUrl('desktop',$ctl,$act,$para),
					);
					if ($item->getAttribute('default') == 'true'){
						$default_menu[] = $menu_arr[$k]['submenu'][$sk]['item'][$ik];
					}
				}
			}
		}
		return $menu_arr;
	}

}