<?php /* Smarty version Smarty-3.0.6, created on 2015-12-22 13:33:48
         compiled from "D:\wamp\www\flysky/app/desktop/view\sys/backup.html" */ ?>
<?php /*%%SmartyHeaderCode:142935678e0bc12c355-19186442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b46bc117b39b4a7f290340a0c76ee3183f7f6fe8' => 
    array (
      0 => 'D:\\wamp\\www\\flysky/app/desktop/view\\sys/backup.html',
      1 => 1402491772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '142935678e0bc12c355-19186442',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div><h3>数据库备份</h3></div>
<form method="post" id="sys_form" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_sys','a'=>'doBackup'),$_smarty_tpl);?>
">
    <div class="tab-pane" id="tabPane1">
    </div>
    <div style="text-align:center;">
        <input type="button" id="backup" value="备份" />
    </div>
</form>
<script>
    $('backup').addEvent('click',function(e){
        $('backup').set('value', '正在备份,请稍候...');
        $('backup').set('disabled','disabled');
        $('sys_form').submit();
    });
</script>