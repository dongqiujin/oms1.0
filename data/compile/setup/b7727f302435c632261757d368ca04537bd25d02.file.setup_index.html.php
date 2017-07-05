<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 23:52:19
         compiled from "H:\flysky\server\wamp\www\flysky/app/setup/view\setup_index.html" */ ?>
<?php /*%%SmartyHeaderCode:8092528794b31f2449-83252742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7727f302435c632261757d368ca04537bd25d02' => 
    array (
      0 => 'H:\\flysky\\server\\wamp\\www\\flysky/app/setup/view\\setup_index.html',
      1 => 1310908024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8092528794b31f2449-83252742',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("setup_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script>
$(function(){

	//加载license
	$("#license").load("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'license'),$_smarty_tpl);?>
");
	$('#js-agree').click(function(){
		var js_submit = $('#js-submit');
		if (js_submit.attr('disabled')){
			js_submit.attr('disabled','');
		}else{
			js_submit.attr('disabled','disabled');
		}
		
	});
});
</script>

<form method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'step1'),$_smarty_tpl);?>
" >
	<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
	<tr>
	<td valign="top">
	    <div id="wrapper1" style="padding:15px 0;">
	    <div id="license"></div>
	</div></td>
	<td width="227" valign="top" background="<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/images/install-step1-zh_cn.gif">&nbsp;</td>
	</tr>
	<tr>
	<td align="center" style="padding-top:10px;"><input type="checkbox" name="agree" id="js-agree" class="p" />
	  <label for="js-agree">我已仔细阅读，并同意上述条款中的所有内容</label><br />
	  <span id="install-btn"><input class="button" disabled="disabled" type="submit" id="js-submit" class="p" value="下一步：配置安装环境" /></span>
	</td>
	<td>&nbsp;</td>
	</tr>
	</table>
</form>

<?php $_template = new Smarty_Internal_Template("setup_footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

