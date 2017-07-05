<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 23:28:54
         compiled from "D:\www\flysky/app/desktop/view\delivery/print.html" */ ?>
<?php /*%%SmartyHeaderCode:2055752878f365022f2-05846013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd65904e583e459bfb6738f64c9ef7c3c4bfd1c2e' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\delivery/print.html',
      1 => 1384615732,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2055752878f365022f2-05846013',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'D:\www\flysky\app\base\Drivers\Smarty\plugins\modifier.date_format.php';
?><!DOCTYPE html>
<html>
<head>
    <!--<meta name=vs_targetSchema content="http://schemas.microsoft.com/intellisense/ie5">-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>打印发货单</title>
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
if ($_smarty_tpl->tpl_vars['order']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['order']->key;
 $_smarty_tpl->tpl_vars['order']->iteration++;
 $_smarty_tpl->tpl_vars['order']->last = $_smarty_tpl->tpl_vars['order']->iteration === $_smarty_tpl->tpl_vars['order']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['print']['last'] = $_smarty_tpl->tpl_vars['order']->last;
?>
<div class="tabp" style="width:21cm; height:14cm; font-size:14px; background-color: white; margin-left:auto;padding-left:-30px; padding-top:10px; margin-right:auto;" id="listDiv">
    <div style="text-align: center; font-size: 25px; line-height: 40px; ">海宁市飞天包装有限公司</div>
    <div style="text-align: center;  line-height: 10px;">联系人：胡先生 &nbsp;&nbsp;&nbsp;  手机:15968357090  &nbsp;&nbsp;&nbsp; 传真：0573 - 87276509</div>
    <div style="text-align: center; font-size:20px;font-weight:bold; margin-top:10px;">发 货 单</div>
    <div style="float: left;width:12cm; margin-top:-30px; height:96px;">
        <ul>
            <li>发货单号：<?php echo $_smarty_tpl->tpl_vars['order']->value['delivery_bn'];?>
</li>
            <li>日期：<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
</li>
            <li>致：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_company'];?>
</li>
            <li>地点：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_address'];?>
</li>
        </ul>
    </div>
    <div style="margin-top:-25px;">
        <ul>
            <li>客户代号：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_bn'];?>
</li>
            <li>联系人：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_contacts'];?>
</li>
            <li>手机：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_mobile'];?>
</li>
        </ul>
    </div>
    <div style="margin-left:10px; width:20cm;margin-right:auto; margin-top:-120px; padding-top:5px;">
        <table cellpadding="3" cellspacing="1" style="width:98%; border-collapse:collapse;border:none; margin-top:-10px;">
            <thead>
            <tr style="border-bottom:1px #000000 solid;border-top:1px #000000 solid; text-align: center;">
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
 $_from = $_smarty_tpl->tpl_vars['order']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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

            <tr style="text-align: center;border-top:1px #000000 solid; ">
                <td colspan="8" style="padding-left: 250px;">总金额：<?php echo $_smarty_tpl->tpl_vars['order']->value['total_money'];?>
</td>
            </tr>

            <tr height="<?php echo $_smarty_tpl->tpl_vars['order']->value['line_top'];?>
px">
                <td colspan="7">
                </td>
            </tr>

            <tr style="border-top:1px #000000 solid; text-align: left;">
                <td colspan="8">
                    <table style="width:100%;">
                        <tr>
                            <td style="width:30%;">客户意见：满意<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'height'=>"16",'src'=>"img/checkbox.png"),$_smarty_tpl);?>
 一般<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'height'=>"16",'src'=>"img/checkbox.png"),$_smarty_tpl);?>

                                差<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'height'=>"16",'src'=>"img/checkbox.png"),$_smarty_tpl);?>
 很差<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'height'=>"16",'src'=>"img/checkbox.png"),$_smarty_tpl);?>
</td>
                            <td style="width:15%;">打单：</td>
                            <td style="width:35%;">兹收到上列货品！ 收货人签字：</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>司机：</td>
                            <td></td>
                        </tr>
                        <tr style="padding-top:8px;">
                            <td colspan="3">备注：1、货物送到后请验收，否则造成损失由客户自行负责。2、本单据既为双方购销合同，又为双方债权债务凭证，客户签字或盖章后生效。若有合同双方发生纠纷，由供货方司法机关裁决。</td>
                        </tr>
                    </table>
                </td>
            </tr>
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

    //打印
    $('#print').click(function(e){
        $.get("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'doPrint'),$_smarty_tpl);?>
", { delivery_id: "<?php echo $_smarty_tpl->getVariable('deliveryIds')->value;?>
"} );
    });
</script>