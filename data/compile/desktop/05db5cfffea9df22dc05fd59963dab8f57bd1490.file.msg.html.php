<?php /* Smarty version Smarty-3.0.6, created on 2013-11-13 23:05:44
         compiled from "D:\www\flysky/app/desktop/view\msg.html" */ ?>
<?php /*%%SmartyHeaderCode:882852839548ee7107-10676472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05db5cfffea9df22dc05fd59963dab8f57bd1490' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\msg.html',
      1 => 1314892733,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '882852839548ee7107-10676472',
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
