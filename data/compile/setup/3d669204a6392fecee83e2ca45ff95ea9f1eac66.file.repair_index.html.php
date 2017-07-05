<?php /* Smarty version Smarty-3.0.6, created on 2013-11-06 22:04:25
         compiled from "D:\www\flysky/app/setup/view\repair_index.html" */ ?>
<?php /*%%SmartyHeaderCode:16119527a4c69cf88b1-72272904%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d669204a6392fecee83e2ca45ff95ea9f1eac66' => 
    array (
      0 => 'D:\\www\\flysky/app/setup/view\\repair_index.html',
      1 => 1312703378,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16119527a4c69cf88b1-72272904',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("setup_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/jquery.validate.js",'app'=>"base"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/jquery.form.js",'app'=>"base"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/validate.message_cn.js",'app'=>"base"),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/timers.js",'app'=>"base"),$_smarty_tpl);?>

<script>
$(function(){

	var seconds = new Date().getSeconds();
	//开始维护
	$("#repair").click(function(){

		$.getJSON("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'repair','a'=>'start_repair','seconds'=>"+seconds+"),$_smarty_tpl);?>
", function(json){

		});
		$('#dialog').dialog('open');
	    //清空维护内容
	    $("#repair_item").html('');
	    $(".ui-dialog-titlebar-close").hide();
	    $($(".ui-button-text-only")[2]).hide();
	    $("body").oneTime('1s', get_repair_log);
	});

	//弹窗初始化参数
	$('#dialog').dialog({
		autoOpen: false,
		width: 450,
		height: 300,
		modal: true,
		buttons: {
			"关闭": function() { 
				$(this).dialog("close");
			} 
		}
	});

	//获取维护日志
	var cursor = 0;
	function get_repair_log(){

		$("#repair_title").text('维护程序进行中...');
		var second = new Date().getSeconds();
		$.getJSON("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'repair','a'=>'get_repair_log','second'=>"+second+"),$_smarty_tpl);?>
", { type: "1", cursor: cursor }, function(json){
			cursor = json.cursor;
			if (json.item=='all'){//维护完成处理
				$("#repair_title").text("维护程序完成");
				$($(".ui-button-text-only")[2]).show();
				$(".ui-dialog-titlebar-close").show();
				cursor = 0;
				$("#repair_item").prepend('<div style="color:blue;font-size:14px;font-weight:bold;">恭喜董公：大功告成！</div> ');
				$("body").stopTime('log');
				return false;
		    }
		    if (json.item){
				if ($("#repair_item:contains('"+json.item+"')")){
					var status_name;
					if (json.status=='error') status_name = '.......................<font color=red>失败</font>';
					else  status_name = '.......................<font color=blue>成功</font>';
					$("#repair_item").prepend( json.item + status_name + "<br/>" );
				}
		    }
			if (json.status=='error'){//维护失败处理
				$("#repair_title").text('维护程序终止');
				$("body").stopTime('log');
				$(".ui-dialog-titlebar-close").show();
	        	$($(".ui-button-text-only")[2]).show();
	        	cursor = 0;
				return false;
			}
			//定时执行获取
			$("body").everyTime('1000ms', 'log', get_repair_log);
		});
	}
	
});
</script>

<div id="checking">
<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
<tr>
<td valign="top">
<div id="wrapper">
  <h3>修复程序</h3>

		<div id="dialog" title="维护程序监视器" style="display:none;">
			<div id="repair_title">维护程序正在初始化，请稍候...
			<img id='title_loading' border='0' src='' />
			</div>
			<hr>
			<div id="repair_item"></div>
		</div>

		
</div>
</td>
<td width="227" valign="top" background="<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/images/install-step3-zh_cn.gif">&nbsp;</td>
</tr>
<tr>
  <td>
  <div id="install-btn"><input id="repair" type="button" class="button" value="维护" /></div>
  </td>
  <td></td>
</tr>
</table>
</div>

<?php $_template = new Smarty_Internal_Template("setup_footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>