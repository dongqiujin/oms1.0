<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 19:24:34
         compiled from "D:\www\flysky/app/setup/view\setup_step2.html" */ ?>
<?php /*%%SmartyHeaderCode:276265278d572d04ff5-01545544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '224a20126eb4787702cd3f2c06ac1c4b5d3fd66a' => 
    array (
      0 => 'D:\\www\\flysky/app/setup/view\\setup_step2.html',
      1 => 1310915306,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '276265278d572d04ff5-01545544',
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
	
	$('#dialog').dialog({
		autoOpen: false,
		width: 450,
		height: 300,
		modal: true,
		buttons: {
			"进入首页": function() { 
				var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'index'),$_smarty_tpl);?>
';
				top.window.location = url;
			},
			"进入后台": function() { 
				var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'main','a'=>'index'),$_smarty_tpl);?>
';
				top.window.location = url;
			},
			"关闭": function() { 
				$(this).dialog("close");
			} 
		}
	});

	var seconds = new Date().getSeconds();
	var src_start_loading = "<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/common/images/loading-line-start.gif";
	var src_stop_loading = "<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/common/images/loading-line-stop.gif";
	//表单提交
    var options = {
       target:'',
       dataType:'json',
       url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'done','seconds'=>"+seconds+"),$_smarty_tpl);?>
",
       beforeSubmit:function(formData, forms, options){
           //提交前的处理
           if(!check_connect(true)) return false;
           else{
			   $('#dialog').dialog('open');
			   //清空安装内容
			   $("#setup_item").html('');
			   $(".ui-dialog-titlebar-close").hide();
			   $($(".ui-button-text-only")[0]).hide();
			   $($(".ui-button-text-only")[1]).hide();
			   $($(".ui-button-text-only")[2]).hide();
			   $("body").oneTime('1s', get_setup_log);
               return true;
           }
       },
       success:function(responseJson, statusText){
		   
       },
       error:function(xmlhttprequest, txtStatus){
   	       $(this.target).html("网络加载失败，请重试！");
       },
    };
    
    //表单验证
	$("#js-setting").validate({
		errorPlacement: function(error, element) {
	    	error.appendTo(element.parent());
		},
		submitHandler:function(form){
			$(form).ajaxSubmit(options);
	        return false;
        },
		onclick: true,
		success: 'allow',
        rules: {
		   host: {
		      required: true,
		   },
		   user: {
			  required: true,
		   },
		   database: {
		      required: true,
		   },
		   admin_name: {
		      required: true,
		   },
		   admin_password: {
		      required: true,
		      minlength: 2
		   },
		   admin_password2: {
		      required: true,
		      minlength: 2,
		      equalTo: "#admin_password"
		   },
		},
		messages: {
		   host: {
		      required: " ",
		   },
		   user: {
		      required: " ",
		   },
		   database: {
		      required: " ",
		   },
		   admin_name: {
		      required: " ",
		   },
		   admin_password: {
		      required: " ",
		      minlength: $.format("密码不能小于{0}个字符")
		   },
		   admin_password2: {
			   required: " ",
			   minlength: "确认密码不能小于2个字符",
			   equalTo: "两次输入密码不一致"
		   },
		}
	});

	//选择数据库
	var selectObj = $("select[name=js-db-list]");
	$('input[name=js-go]').click(function(){
		$("input[name=js-go]").hide();
		$("#loading").show();
		var db = get_dbconf();
		if(!check_connect()) return;
		selectObj.empty();
		$.getJSON("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'db_list'),$_smarty_tpl);?>
", { host: db['host'], port: db['port'], user: db['user'], pass: db['pass'] }, function(json){
			$("input[name=js-go]").show();
			$("#loading").hide();
			selectObj.children("option").text('请选择');
			$.each(json,function(i,n){
				option = "<option value="+n+">"+n+"</option>";
				selectObj.append(option);
			});
		});
	});
	selectObj.change(function(e){
		$("#db-name").val(selectObj.val());
	})

	//验证数据库连接是否正确
	function check_connect(show_success){
		var db = get_dbconf(),flag=true;
		$.ajax({
			'dataType': 'json',
			'url': "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'connect','seconds'=>"+seconds+"),$_smarty_tpl);?>
",
			'type': 'GET',
			'data': { host: db['host'], port: db['port'], user: db['user'], pass: db['pass'] },
			'async': false,
			'success': function(data){
			    if (data && data.status=='error'){
					alert('数据库连接失败，请检查输入是否正确');
					$("input[name=js-go]").show();
					$("#loading").hide();
					flag = false;
			    }else{
				    if (show_success!=true)
			    	alert('连接成功，请选择数据库');
			    }
			}
		});
		return flag;
	}
	//获取连接初始值 
	function get_dbconf(){
		var db = new Array();
		db['host'] = $("#host").val();
		db['port'] = $("#port").val();
	    db['user'] = $("#user").val();
	    db['pass'] = $("#pass").val();
	    return db;
	}

	//获取安装日志
	var cursor = 0;
	function get_setup_log(){

		$("#setup_title").text('安装程序进行中...');
		var second = new Date().getSeconds();
		$.getJSON("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'get_setup_log','second'=>"+second+"),$_smarty_tpl);?>
", { type: "1", cursor: cursor }, function(json){
			cursor = json.cursor;
			if (json.item=='all'){//安装完成处理
				$("#setup_title").text("安装程序完成");
				$($(".ui-button-text-only")[0]).show();
				$($(".ui-button-text-only")[1]).show();
				cursor = 0;
				$("#setup_item").prepend('<div style="color:blue;font-size:14px;font-weight:bold;">恭喜董公：大功告成！</div> ');
				$("body").stopTime('log');
				return false;
		    }
			if (json.item && $("#setup_item:contains('"+json.item+"')")){
				var status_name;
				if (json.status=='error') status_name = '.......................<font color=red>失败</font>';
				else  status_name = '.......................<font color=blue>成功</font>';
				$("#setup_item").prepend( json.item + status_name + "<br/>" );
			}
			if (json.status=='error'){//安装失败处理
				$("#setup_title").text('安装程序终止');
				$("body").stopTime('log');
				$(".ui-dialog-titlebar-close").show();
	        	$($(".ui-button-text-only")[2]).show();
	        	cursor = 0;
				return false;
			}
			//定时执行获取
			$("body").everyTime('500ms', 'log', get_setup_log);
		});
	}
	
});
</script>
<div id="checking">
<form id="js-setting">
<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
<tr>
<td valign="top"><div id="wrapper">
  <h3>数据库帐号:</h3>

		<table width="450" class="list">
		<tr>
			<td width="90" align="left">数据库主机：</td>
			<td align="left"><input type="text" id="host" name="host"  value="<?php echo $_smarty_tpl->getVariable('host')->value;?>
" /><em class="c-red">*</em> </td>
		</tr>
		<tr>
			<td width="90" align="left">端口号：</td>
			<td align="left"><input type="text" id="port" name="port"  value="<?php echo $_smarty_tpl->getVariable('port')->value;?>
" size="6" /></td>
		</tr>
		<tr>
			<td width="90" align="left">用户名：</td>
			<td align="left"><input type="text" id="user" name="user"  value="<?php echo $_smarty_tpl->getVariable('user')->value;?>
" /><em class="c-red">*</em></td>
		</tr>
		<tr>
			<td width="90" align="left">密码：</td>
			<td align="left"><input type="password" id="pass" name="pass"  value="<?php echo $_smarty_tpl->getVariable('pass')->value;?>
" /></td>
		</tr>
		<tr>
			<td width="90" align="left">数据库名：</td>
			<td align="left"><input type="text" name="database" id="db-name"  value="<?php echo $_smarty_tpl->getVariable('dbname')->value;?>
" /><em class="c-red">*</em>
				<br/>
				可输入新的数据库名，也可以选择：
				<select name="js-db-list">
					<option>已有数据库</option>
				</select>
				<span id="loading" style="display:none;"><img src="<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/common/images/loading.gif" /></span>
				<input type="button" name="js-go" class="button" value="搜" />
		   </td>
		</tr>
		<tr>
			<td width="90" align="left">表前缀：</td>
			<td align="left"><input type="text" name="prefix" size="10" value="<?php echo $_smarty_tpl->getVariable('prefix')->value;?>
" /></td>
		</tr>
		</table>
		
		<div id="dialog" title="安装程序监视器" style="display:none;">
			<div id="setup_title">安装程序正在初始化，请稍候...
			<img id='title_loading' border='0' src='' />
			</div>
			<hr>
			<div id="setup_item"></div>
		</div>
		
        <h3>管理员帐号</h3>

			<table width="450" class="list">
			<tr>
				<td width="90" align="left">管理员帐号：</td>
				<td align="left"><input type="text" name="admin_name" size="12" value="" /><em class="c-red">*</em></td>
			</tr>
			<tr>
				<td width="90" align="left">管理员密码：</td>
				<td align="left"><input type="password" id="admin_password" name="admin_password"  value="" /><em class="c-red">*</em></td>
			</tr>
			<tr>
				<td width="90" align="left">确认密码:</td>
				<td align="left"><input type="password" name="admin_password2"  value="" /><em class="c-red">*</em></td>
			</tr>
			<tr>
				<td width="90" align="left">电子邮箱：</td>
				<td align="left"><input type="text" name="admin_email" size="20" value="" /></td>
			</tr>
			</table>
		

		
</div></td>
<td width="227" valign="top" background="<?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>
/images/install-step3-zh_cn.gif">&nbsp;</td>
</tr>
<tr>
  <td><div id="install-btn"><input type="button"  id="js-pre-step" class="button" value="上一步：检测系统环境" onclick="javascript:window.location='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'setup','c'=>'setup','a'=>'step1'),$_smarty_tpl);?>
'" />
	  <input id="js-install-at-once" type="submit" class="button" value="立即安装" /></div>
  </td>
  <td></td>
</tr>
</table>
</form>
</div>

<?php $_template = new Smarty_Internal_Template("setup_footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

