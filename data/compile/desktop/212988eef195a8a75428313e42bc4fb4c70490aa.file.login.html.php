<?php /* Smarty version Smarty-3.0.6, created on 2015-11-24 19:01:55
         compiled from "G:\htdocs\www\flysky/app/desktop/view\login.html" */ ?>
<?php /*%%SmartyHeaderCode:8398565443a364fdd1-49021369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '212988eef195a8a75428313e42bc4fb4c70490aa' => 
    array (
      0 => 'G:\\htdocs\\www\\flysky/app/desktop/view\\login.html',
      1 => 1384530200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8398565443a364fdd1-49021369',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>飞天包装</title>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['style'][0][0]->smarty_style(array('href'=>"css/login.css"),$_smarty_tpl);?>

</head>
<body id="login">
<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'passport','a'=>'login'),$_smarty_tpl);?>
" id="loginForm" method="post" onsubmit="return check(this)">
  <h3>飞天包装订单管理系统</h3>
  <div class="login">
    <label for="userName"><span>用户名：</span><input name="username" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
" type="text" class="text" id="userName" /></label>
    <label for="passWord"><span>密　码：</span>
    <input type="password" class="text" name="password" id="passWord" /></label>
    <?php if ($_smarty_tpl->getVariable('msg')->value){?>
    <label style="color:red;"><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</label>
    <?php }?>
    <label id="submit"><input name="" type="submit" class="bt" value="确定" /></label>
  </div>
</form>

<script>
document.getElementById('userName').focus();
function chkrd(f) {
    f = document.getElementsByName(f);
    var ck = false;
    for(var i = 0; i < f.length; i++) {
        if(f[i].checked){
            ck = true;
            break;
        }
    }
    return ck;
}
function check(f){
    if(f.username.value == '') {
        alert('请输入用户名！');
        f.username.focus();
        return false;
    }
    if(f.password.value == '') {
        alert('请输入密码！');
        f.password.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>
