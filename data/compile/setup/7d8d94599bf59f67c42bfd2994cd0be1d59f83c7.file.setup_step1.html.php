<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 19:24:27
         compiled from "D:\www\flysky/app/setup/view\setup_step1.html" */ ?>
<?php /*%%SmartyHeaderCode:20055278d56b3ea5a5-84170609%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d8d94599bf59f67c42bfd2994cd0be1d59f83c7' => 
    array (
      0 => 'D:\\www\\flysky/app/setup/view\\setup_step1.html',
      1 => 1310908249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20055278d56b3ea5a5-84170609',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("setup_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<div id="checking">
<form method="post">
<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
<tr>
<td valign="top" >
<div id="wrapper" style="padding:0px 0; margin-left:20px; overflow-y:auto; ">

<div style="float:left; ">
	<h3>环境检查</h3>
	<table border="0"  class="tb">
	<tbody>
	<tr>
		<th>项目</th>
		<th >所需配置</th>
		<th >当前服务器</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('system_check')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
?>
	<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</td>
	<td ><?php echo $_smarty_tpl->tpl_vars['items']->value['need_ver'];?>
</td>
	<td >
	<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['items']->value['cur_ver']>=$_smarty_tpl->tpl_vars['items']->value['need_ver']){?><?php echo "allow";?><?php }else{ ?><?php echo "deny";?><?php }?><?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"images/".$_tmp1.".gif",'border'=>"0"),$_smarty_tpl);?>

	<?php if ($_smarty_tpl->tpl_vars['items']->value['cur_ver']){?><?php echo $_smarty_tpl->tpl_vars['items']->value['cur_ver'];?>
<?php }?>
	</td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>
</div>
<div style="float:none; ">
	<h3 class="title">函数依赖性检查</h3>
	<table  class="tb">
	<tbody><tr>
		<th>函数名称</th>
		<th >检查结果</th>
		<th >建议</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('function_check')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
?>
	<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</td>
	<td ><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"images/".($_smarty_tpl->tpl_vars['items']->value['is_support']).".gif",'border'=>"0"),$_smarty_tpl);?>
</td>
	<td >
	<?php echo $_smarty_tpl->tpl_vars['items']->value['advice'];?>

	</td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>
</div>
<br/>
	<h3 class="title">目录、文件权限检查</h3>
	<table  class="tb">
		<tbody><tr>
		<th>目录文件</th>
		<th >所需状态</th>
		<th >当前状态</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dir_check')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
?>
	<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</td>
	<td ><?php echo $_smarty_tpl->tpl_vars['items']->value['need_status'];?>
</td>
	<td >
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"/images/".($_smarty_tpl->tpl_vars['items']->value['cur_status']).".gif",'border'=>"0"),$_smarty_tpl);?>

	</td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>
		
</div>
</td>

<td width="227" valign="top" background="<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/images/install-step2-zh_cn.gif">&nbsp;</td>
</tr>
<tr>
  <td><div id="install-btn"><input type="button"  id="js-pre-step" class="button" value="上一步：安装协议" onclick="javascript:window.location='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'index'),$_smarty_tpl);?>
'" />
      <input type="button" class="button" id="js-recheck" class="button" value="重新检查"  onclick="javascript:window.location='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'step1'),$_smarty_tpl);?>
'"/>
      <input type="button" class="button" id="js-submit"  class="button" value="下一步：配置系统"  <?php echo $_smarty_tpl->getVariable('disabled')->value;?>
 onclick="javascript:window.location='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'step2'),$_smarty_tpl);?>
'"/></div>
  </td>
  <td></td>
</tr>
</table>
</form>
</div>

<?php $_template = new Smarty_Internal_Template("setup_footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

