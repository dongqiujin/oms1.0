<?php /* Smarty version Smarty-3.0.6, created on 2015-12-22 13:30:25
         compiled from "D:\wamp\www\flysky/app/desktop/view\msg.html" */ ?>
<?php /*%%SmartyHeaderCode:42655678dff19b5120-09415908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecf94049886608ff0e08924ecf3c6d3b327cb458' => 
    array (
      0 => 'D:\\wamp\\www\\flysky/app/desktop/view\\msg.html',
      1 => 1314892732,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42655678dff19b5120-09415908',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div class="form-div" style="text-align:center;">
<h2 class="title">提示信息</h2>

<?php if ($_smarty_tpl->getVariable('status')->value=='succ'){?><?php }else{ ?><p style="color:red;">失败</p><?php }?>
	  <?php echo $_smarty_tpl->getVariable('msg')->value;?>

	  <p>
		<button type="button" class="bt" onclick="javascript:<?php echo $_smarty_tpl->getVariable('url')->value;?>
;">返回</button>
	  </p>
</div>
