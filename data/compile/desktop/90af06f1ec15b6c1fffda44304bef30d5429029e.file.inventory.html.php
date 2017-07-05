<?php /* Smarty version Smarty-3.0.6, created on 2015-11-24 20:15:12
         compiled from "G:\htdocs\www\flysky/app/desktop/view\order/inventory.html" */ ?>
<?php /*%%SmartyHeaderCode:7528565454d065c529-45808998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90af06f1ec15b6c1fffda44304bef30d5429029e' => 
    array (
      0 => 'G:\\htdocs\\www\\flysky/app/desktop/view\\order/inventory.html',
      1 => 1406981786,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7528565454d065c529-45808998',
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

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/LodopFuncs.js"),$_smarty_tpl);?>

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
        <input  type="button"  value="打印" id="print" onclick="upStatus();">
        <input  type="button"  value="打印预览" onclick="prn2_preview();">
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
<div class="tabp pageTable" style="width:21cm; height:19.7cm; font-size:14px; background-color: white; margin-left:auto; padding-top:10px; margin-right:auto;" id="listDiv">
    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['print']['first']){?>
    <div style="text-align: center; font-size: 25px; line-height: 40px; "><?php echo $_smarty_tpl->getVariable('customer')->value['cus_company'];?>
</div>
    <div style="text-align: center;  line-height: 10px;">联系人：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_contacts'];?>
 &nbsp;&nbsp;&nbsp;  手机:<?php echo $_smarty_tpl->getVariable('customer')->value['cus_mobile'];?>
  &nbsp;&nbsp;&nbsp; 传真：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_fax'];?>
</div>
    <?php }?>

    <div style="margin-left:10px; width:20cm;margin-right:auto;">
        <table cellpadding="3" cellspacing="0" style="width:98%; border-collapse:collapse;border:none;">
            <thead>
            <tr style="border-bottom:1px #000000 solid; text-align: center;">
			<th width="10%" style="border-bottom:1px #000000 solid;">发货日期</th>
                <th width="8%" style="border-bottom:1px #000000 solid;">订单号</th>
                <th width="8%" style="border-bottom:1px #000000 solid;">纸质</th>
                <th width="15%" style="border-bottom:1px #000000 solid;">下单尺寸</th>
                <th width="7%" style="border-bottom:1px #000000 solid;">原订数</th>
                <th width="7%" style="border-bottom:1px #000000 solid;">送货数</th>
                <th width="10%" style="border-bottom:1px #000000 solid;">单价</th>
                <th width="10%" style="border-bottom:1px #000000 solid;">金额</th>
                <th width="25%" style="border-bottom:1px #000000 solid;">备  注</th>
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
			<td class="first-cell"><?php echo $_smarty_tpl->tpl_vars['product']->value['delivery_time'];?>
</td>
                <td class="first-cell"><?php echo $_smarty_tpl->tpl_vars['product']->value['order_bn'];?>
</td>
                <td ><?php echo $_smarty_tpl->tpl_vars['product']->value['type_name'];?>
</td>
                <td style="text-align: left;">
				<?php if ($_smarty_tpl->tpl_vars['product']->value['goods_type']=='goods'){?>
				<?php echo $_smarty_tpl->tpl_vars['product']->value['length'];?>
*<?php echo $_smarty_tpl->tpl_vars['product']->value['width'];?>
*<?php echo $_smarty_tpl->tpl_vars['product']->value['height'];?>

				<?php }else{ ?>
                <?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>

                    <?php if ($_smarty_tpl->tpl_vars['product']->value['length']){?> <?php echo $_smarty_tpl->tpl_vars['product']->value['length'];?>
*<?php echo $_smarty_tpl->tpl_vars['product']->value['width'];?>
<?php }?>
				<?php }?>
				</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['num'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['send_num'];?>
</td>
                <td class="center"><?php echo number_format($_smarty_tpl->tpl_vars['product']->value['price'],3);?>
</td>
                <td class="center"><?php echo number_format($_smarty_tpl->tpl_vars['product']->value['amount'],3);?>
</td>
                <td align="center"><?php echo $_smarty_tpl->tpl_vars['product']->value['memo'];?>
</td>
            </tr>
            <?php }} ?>

            <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['print']['last']){?>
            <tr style="text-align: center; ">
                <td colspan="8" style="padding-left: 250px; border-top:1px #000000 solid;">总数量：<?php echo $_smarty_tpl->getVariable('totalNums')->value;?>
,总金额：<?php echo $_smarty_tpl->getVariable('totalMoney')->value;?>
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

	$offheight=0;     //模板偏移量 宽
    $offwidth=0;    //模板偏移量 高               //table高

	var strHtmInstall="<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='/flysky/app/desktop/statics/js/install_lodop32.exe' target='_self'>执行安装</a>,安装后请刷新页面或重新进入。</font>";
	var strHtmUpdate="<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='/flysky/app/desktop/statics/js/install_lodop32.exe' target='_self'>执行升级</a>,升级后请重新进入。</font>";
	var strHtm64_Install="<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='/flysky/app/desktop/statics/js/install_lodop64.exe' target='_self'>执行安装</a>,安装后请刷新页面或重新进入。</font>";
	var strHtm64_Update="<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='/flysky/app/desktop/statics/js/install_lodop64.exe' target='_self'>执行升级</a>,升级后请重新进入。</font>";
	var strHtmFireFox="<br><br><font color='#FF00FF'>（注意：如曾安装过Lodop旧版附件npActiveXPLugin,请在【工具】->【附加组件】->【扩展】中先卸它）</font>";
	var strHtmChrome="<br><br><font color='#FF00FF'>(如果此前正常，仅因浏览器升级或重安装而出问题，需重新执行以上安装）</font>";

	$(function() {
		CheckIsInstall();
	});


	function upStatus()
	{
        LODOP=getLodop();
        LODOP.PRINT_INIT("发货单打印");            //打印初始化
        LODOP.PRINT_INITA("-1.5mm","0mm","100%","100%","");
        CreateAllPages();
        LODOP.PRINTA();              //弹出选择打印机
	}

	function prn2_preview() {	
			CreateAllPages();	
			LODOP.PREVIEW();	
	}

    function CreateAllPages(){
        LODOP=getLodop();
        var pageObj=$('.pageTable');
        var i;
        for (i = 0; i < pageObj.length; i++) {
            LODOP.NewPage();                                   //强制分页
            LODOP.SET_PRINT_PAGESIZE(1,"210mm","140mm","发货单");           //设定打印方向和打印纸张大小
      //      LODOP.SET_PRINT_STYLE(0,"Horient",2);         //水平居中
      //      LODOP.SET_PRINT_STYLEA(0,"Vorient",2);
      //      LODOP.SET_PRINT_MODE("POS_BASEON_PAPER",true);                      //设置默认基点（物理边缘）
            LODOP.SET_LICENSES("威海和信信息技术有限责任公司","5ED2BBBD6615C31A13D3473032DB8A38","","");
            LODOP.ADD_PRINT_HTM(0,0,"100%","100%",pageObj[i].innerHTML);
        }
    }
    function CheckIsInstall() {
        try{
            var LODOP=getLodop();
            if ((LODOP!=null)&&(typeof(LODOP.VERSION)!="undefined")){
                return true;
            }else{
                document.getElementById('printPaper').style.display='none';
                return false;
            }
            return true;
            // alert("本机已成功安装过Lodop控件!\n  版本号:"+LODOP.VERSION);
        }catch(err){
            //alert("Error:本机未安装或需要升级!");
        }
    }


    $("#printControl").floatdiv("righttop");
</script>