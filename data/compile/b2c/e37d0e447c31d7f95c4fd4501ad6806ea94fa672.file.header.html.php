<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 20:37:25
         compiled from "D:\www\flysky/app/b2c/view\header.html" */ ?>
<?php /*%%SmartyHeaderCode:239035278e685ad9358-52104390%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e37d0e447c31d7f95c4fd4501ad6806ea94fa672' => 
    array (
      0 => 'D:\\www\\flysky/app/b2c/view\\header.html',
      1 => 1337510482,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239035278e685ad9358-52104390',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if ($_smarty_tpl->getVariable('goods')->value['name']){?><?php echo $_smarty_tpl->getVariable('goods')->value['name'];?>
-<?php }?><?php if ($_smarty_tpl->getVariable('cur_cat_name')->value){?><?php echo $_smarty_tpl->getVariable('cur_cat_name')->value;?>
-<?php }?><?php echo $_smarty_tpl->getVariable('sys_base_sitename')->value;?>
</title>
<meta name="keywords" content="<?php echo $_smarty_tpl->getVariable('sys_base_keywords')->value;?>
,<?php echo $_smarty_tpl->getVariable('goods')->value['name'];?>
">
<meta name="description" content="<?php echo $_smarty_tpl->getVariable('sys_base_description')->value;?>
,<?php echo $_smarty_tpl->getVariable('goods')->value['goods_contents']['flower_language'];?>
,<?php echo $_smarty_tpl->getVariable('goods')->value['name'];?>
">
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['style'][0][0]->smarty_style(array('href'=>"skin/screen.css"),$_smarty_tpl);?>

<!--[if lte ie 7]><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['style'][0][0]->smarty_style(array('href'=>"skin/ie.css"),$_smarty_tpl);?>
<![endif]-->
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['style'][0][0]->smarty_style(array('href'=>"skin/public.css"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/moo.js"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/tools.js"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/ui.js"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/SlideShow.js"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/forms.js"),$_smarty_tpl);?>

<script>
function addFav(url,title) {
    url = url || window.location.href;
    var title = document.title;
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("msie 8") > - 1 || ua.indexOf("msie 9") > -1) {
        try{
            window.external.addToFavoritesBar(url, title, 'slice'); //ie8
        }catch(e){
            alert("加入收藏失败，请按ctrl+D进行添加");
        }
    } else {
        try {
            window.external.AddFavorite(url, title);
        } catch(e) {
            try {
                window.sidebar.addPanel(title, url, ""); //firefox
            } catch(e) {
                alert("加入收藏失败，请按ctrl+d进行添加");
            }
        }
    }
    return false;
}
</script>
</head>

<body>
<div id="top" class="clearfix">
  <div class="container">
    <div class="fl"><?php if ($_smarty_tpl->getVariable('name')->value){?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_member_center','a'=>'index'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('name')->value;?>
</a><?php }?>您好，欢迎来到花花世界！</div>
    <div class="fr"><?php if (empty($_smarty_tpl->getVariable('name',null,true,false)->value)){?><a href="javascript:;" id="login_popup" class="red">[登录]</a> <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_member','a'=>'reg'),$_smarty_tpl);?>
" class="red">[注册]</a><?php }else{ ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_member_center','a'=>'index','b'=>'member_id'),$_smarty_tpl);?>
">会员中心</a> | <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_member','a'=>'logout'),$_smarty_tpl);?>
">退出</a><?php }?> <a href="index.php/ctl_member/guanzhu" class="red">[关注]</a> | <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_article','a'=>'view','id'=>'1'),$_smarty_tpl);?>
">关于我们</a> | <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_article','a'=>'view','id'=>'2'),$_smarty_tpl);?>
">联系我们</a> | <a href="http://www.huahua365.com" onclick="addFav();return false;" rel="sidebar" title="花花世界">收藏本站</a></div>
  </div>
</div>
<div id="header">
  <div class="container clearfix">
    <div class="fl logo"><a href="/"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/logo.png",'width'=>"177",'height'=>"56",'alt'=>"花花世界"),$_smarty_tpl);?>
</a>　　<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/slogon.png",'alt'=>"花花365，新鲜每一天",'width'=>"155",'height'=>"21",'vspace'=>"15"),$_smarty_tpl);?>
</div>
    <div class="search fl">
      <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'search','a'=>'index'),$_smarty_tpl);?>
" method="post">
        <input type="text" name="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
" /><button type="submit"><i>搜索</i></button>
      </form>
    </div>
    <div class="fr"> <i>订购热线</i>
      <em><?php echo $_smarty_tpl->getVariable('sys_base_hotline')->value;?>
</em> </div>
  </div>
</div>
<div id="nav">
  <ul class="container clearfix">
    <li <?php if (!$_smarty_tpl->getVariable('pid')->value){?>class="curr"<?php }?>><a href="<?php echo $_smarty_tpl->getVariable('website')->value;?>
">首页</a></li>
    <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('daohang')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
?>
    <li <?php if ($_smarty_tpl->getVariable('pid')->value==$_smarty_tpl->tpl_vars['menu']->value['cat_id']){?>class="curr"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'index'),$_smarty_tpl);?>
/pid/<?php echo $_smarty_tpl->tpl_vars['menu']->value['cat_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['cat_name'];?>
</a></li>
    <?php }} ?>
  </ul>
</div>
