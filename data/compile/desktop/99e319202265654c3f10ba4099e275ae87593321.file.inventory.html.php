<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 22:53:15
         compiled from "D:\www\flysky/app/desktop/view\order/inventory.html" */ ?>
<?php /*%%SmartyHeaderCode:16653528786dbc118d2-39151679%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99e319202265654c3f10ba4099e275ae87593321' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\order/inventory.html',
      1 => 1384613594,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16653528786dbc118d2-39151679',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
    <!--<meta name=vs_targetSchema content="http://schemas.microsoft.com/intellisense/ie5">-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $_smarty_tpl->getVariable('customer')->value['cus_name'];?>
订单列表</title>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/jquery-1.4.2.min.js"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/jquery.floatDiv.js"),$_smarty_tpl);?>

    <style media=print>
        .Noprint{display:none;}
        .PageNext{page-break-after: always;}
    </style>
    <style>
        .NOPRINT {
            font-family: "宋体";
            font-size: 12pt;
        }
        li {list-style-type:none; line-height: 20px;}
    </style>
</head>
<body style="background-color: gray;">

<div class="Noprint" id="printControl" style="width:400px; margin-left:auto; margin-right:auto; margin-bottom:30px;">
    <OBJECT  id=WebBrowser  classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2  height=0  width=0>
    </OBJECT>
    <input  type="button"  value="打印" id="print" onclick="document.all.WebBrowser.ExecWB(6,1)">
    <!--<input  type=button  value=直接打印  onclick=document.all.WebBrowser.ExecWB(6,6)>-->
    <input  type="button"  value="页面设置"  onclick="document.all.WebBrowser.ExecWB(8,1)">
    <input  type="button"  value="打印预览"  onclick="document.all.WebBrowser.ExecWB(7,1)">
</div>

<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('printData')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['order']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['order']->iteration=0;
 $_smarty_tpl->tpl_vars['order']->index=-1;
if ($_smarty_tpl->tpl_vars['order']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['order']->key;
 $_smarty_tpl->tpl_vars['order']->iteration++;
 $_smarty_tpl->tpl_vars['order']->index++;
 $_smarty_tpl->tpl_vars['order']->first = $_smarty_tpl->tpl_vars['order']->index === 0;
 $_smarty_tpl->tpl_vars['order']->last = $_smarty_tpl->tpl_vars['order']->iteration === $_smarty_tpl->tpl_vars['order']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['print']['first'] = $_smarty_tpl->tpl_vars['order']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['print']['last'] = $_smarty_tpl->tpl_vars['order']->last;
?>
<div class="tabp" style="width:21cm; height:19.7cm; font-size:14px; background-color: white; margin-left:auto; padding-top:10px; margin-right:auto;" id="listDiv">
    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['print']['first']){?>
    <div style="text-align: center; font-size: 25px; line-height: 40px; "><?php echo $_smarty_tpl->getVariable('customer')->value['cus_company'];?>
</div>
    <div style="text-align: center;  line-height: 10px;">联系人：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_contacts'];?>
 &nbsp;&nbsp;&nbsp;  手机:<?php echo $_smarty_tpl->getVariable('customer')->value['cus_mobile'];?>
  &nbsp;&nbsp;&nbsp; 传真：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_fax'];?>
</div>
    <?php }?>

    <div style="margin-left:10px; width:20cm;margin-right:auto;">
        <table cellpadding="3" cellspacing="1" style="width:98%; border-collapse:collapse;border:none;">
            <thead>
            <tr style="border-bottom:1px #000000 solid; text-align: center;">
                <th width="8%">订单号</th>
                <th width="8%">纸质</th>
                <th width="15%">下单尺寸</th>
                <th width="10%">原订数</th>
                <th width="10%">送货数</th>
                <th width="10%">单价</th>
                <th width="10%">金额</th>
                <th width="29%">备  注</th>
            </tr>
            </thead>
            <tbody>
            <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['order']->value['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
            <tr style="text-align: center;">
                <td class="first-cell"><?php echo $_smarty_tpl->tpl_vars['product']->value['order_bn'];?>
</td>
                <td ><?php echo $_smarty_tpl->tpl_vars['product']->value['type_name'];?>
</td>
                <td style="text-align: left;"><?php echo $_smarty_tpl->tpl_vars['product']->value['length'];?>
*<?php echo $_smarty_tpl->tpl_vars['product']->value['width'];?>
*<?php echo $_smarty_tpl->tpl_vars['product']->value['height'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['num'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['send_num'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['amount'];?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['memo'];?>
</td>
            </tr>
            <?php }} ?>

            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['print']['last']){?>
            <tr style="text-align: center;border-top:1px #000000 solid; ">
                <td colspan="8" style="padding-left: 250px;">总金额：<?php echo $_smarty_tpl->getVariable('totalMoney')->value;?>
</td>
            </tr>
            <?php }?>

            </tbody>
        </table>
    </div>
</div>

<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['print']['last']){?>
<div class="NOPRINT" style="height:20px;" ></div>
<!--分页-->
<div class="PageNext"></div>
<?php }?>

<?php }} ?>

</body>
</html>
<script>
    $("#printControl").floatdiv("righttop");
</script>