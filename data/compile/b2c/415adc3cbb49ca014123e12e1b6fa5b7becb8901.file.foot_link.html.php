<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 20:37:26
         compiled from "D:\www\flysky/app/b2c/view\foot_link.html" */ ?>
<?php /*%%SmartyHeaderCode:255165278e6868bf485-42825621%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '415adc3cbb49ca014123e12e1b6fa5b7becb8901' => 
    array (
      0 => 'D:\\www\\flysky/app/b2c/view\\foot_link.html',
      1 => 1314520892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255165278e6868bf485-42825621',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="flink margin">
    <div class="head clearfix">
      <h2 class="fl"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r54_c9.png",'width'=>"68",'height'=>"14"),$_smarty_tpl);?>
 </h2>
      <div class="more fr"> </div>
    </div>
    <?php  $_smarty_tpl->tpl_vars['links'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('module_link')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['links']->key => $_smarty_tpl->tpl_vars['links']->value){
?><a href="<?php echo $_smarty_tpl->tpl_vars['links']->value['mark_link'];?>
"><img src="<?php echo $_smarty_tpl->getVariable('public_dir')->value;?>
/<?php echo $_smarty_tpl->tpl_vars['links']->value['mark_pic'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['links']->value['mark_title'];?>
" /></a><?php }} ?>
  </div>