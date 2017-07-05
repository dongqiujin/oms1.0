<?php /* Smarty version Smarty-3.0.6, created on 2015-11-24 19:07:51
         compiled from "G:\htdocs\www\flysky/app/desktop/view\delivery/print.html" */ ?>
<?php /*%%SmartyHeaderCode:1908565445079505e5-36179858%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4223e50d2db8b2f36937d43312e0692716ec4ca2' => 
    array (
      0 => 'G:\\htdocs\\www\\flysky/app/desktop/view\\delivery/print.html',
      1 => 1447491064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1908565445079505e5-36179858',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'G:\htdocs\www\flysky\app\base\Drivers\Smarty\plugins\modifier.date_format.php';
?><!DOCTYPE html>
<html>
<head>
    <!--<meta name=vs_targetSchema content="http://schemas.microsoft.com/intellisense/ie5">-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>打印发货单</title>
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
        <OBJECT  id=WebBrowser  classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2  height=0  width=0>
        </OBJECT>
        <input  type="button"  value="打印" id="print" onclick="upStatus();">
        <input  type="button"  value="打印预览" onclick="prn2_preview();">
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



<div class="tabp pageTable" style="width:21cm; height:12.5cm; font-size:14px; background-color: white; margin-left:auto;padding-left:-30px; padding-top:10px; margin-right:auto;" id="listDiv">
    <div style="text-align: center; font-size: 25px; line-height: 30px; ">海宁市飞天包装有限公司</div>
    <div style="text-align: center;  line-height: 10px;">联系人：胡先生 &nbsp;&nbsp;&nbsp;  手机:15968357090  &nbsp;&nbsp;&nbsp; 传真：0573 - 87270063</div>
    <div style="text-align: center; font-size:20px;font-weight:bold; margin-top:5px;">发 货 单</div>

	<div>
	<table cellpadding="3" cellspacing="1" style="width:85%; border-collapse:collapse;border:none; margin-top:-25px;margin-left:30px;">
		<tbody>
            <tr style="height:12px;">
				<td width="62%">发货单号：<?php echo $_smarty_tpl->tpl_vars['order']->value['delivery_bn'];?>
</td>
				<td>客户代号：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_bn'];?>
</td>
		    </tr>
			<tr>
				<td>日期：<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
</td>
				<td>联系人：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_contacts'];?>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;手机：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_mobile'];?>
</td>
			</tr>
			<tr>
				<td>致：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_company'];?>
</td>
				<td>地点：<?php echo $_smarty_tpl->tpl_vars['order']->value['customer']['cus_address'];?>
</td>
			</tr>
		</tbody>
	</table>
	</div>

    <div style="margin-left:10px; width:20cm;margin-right:auto; padding-top:5px;margin-top:-5px;">
        <table cellpadding="3" cellspacing="0" style="width:98%; border-collapse:collapse;border:1px solid black; border-left:none; border-right:none;border-bottom:none;">
            <tr style="border-bottom:1px solid black;">
                <th width="8%" style="border-bottom:1px solid black;">订单号</th>
                <th width="8%" style="border-bottom:1px solid black;">纸质</th>
                <th width="15%"  style="border-bottom:1px solid black;">下单尺寸</th>
                <th width="10%"  style="border-bottom:1px solid black;">原订数</th>
                <th width="10%"  style="border-bottom:1px solid black;">送货数</th>
                <th width="10%"  style="border-bottom:1px solid black;">单价</th>
                <th width="10%"  style="border-bottom:1px solid black;">金额</th>
                <th width="29%"  style="border-bottom:1px solid black;">备  注</th>
            </tr>
            <tbody>
            <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['order']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
            <tr style="text-align: center;">
                <td class="first-cell"  height="10px;"><?php echo $_smarty_tpl->tpl_vars['product']->value['order_bn'];?>
</td>
                <td  ><?php if ($_smarty_tpl->tpl_vars['product']->value['goods_type']=='goods'){?><?php echo $_smarty_tpl->tpl_vars['product']->value['type_name'];?>
<?php }else{ ?>配件<?php }?></td>
                <td style="text-align: center;">
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
                <td class="center" ><?php echo $_smarty_tpl->tpl_vars['product']->value['num'];?>
</td>
                <td class="center" ><?php echo $_smarty_tpl->tpl_vars['product']->value['send_num'];?>
</td>
                <td class="center" ><?php echo number_format($_smarty_tpl->tpl_vars['product']->value['price'],3);?>
</td>
                <td class="center" ><?php if ($_smarty_tpl->tpl_vars['product']->value['num']==$_smarty_tpl->tpl_vars['product']->value['send_num']){?><?php echo number_format($_smarty_tpl->tpl_vars['product']->value['amount'],3);?>
<?php }else{ ?><?php echo number_format(round($_smarty_tpl->tpl_vars['product']->value['price']*$_smarty_tpl->tpl_vars['product']->value['send_num'],3),3);?>
<?php }?></td>
                <td align="center" ><?php echo $_smarty_tpl->tpl_vars['product']->value['memo'];?>
</td>
            </tr>
            <?php }} ?>

            <tr style="text-align: center;">
                <td colspan="8" style="padding-left: 250px;border-top:1px solid black;">总数量：<?php echo $_smarty_tpl->tpl_vars['order']->value['total_nums'];?>
，总金额：<?php echo $_smarty_tpl->tpl_vars['order']->value['total_money'];?>
</td>
            </tr>

            <tr height="<?php echo $_smarty_tpl->tpl_vars['order']->value['line_top'];?>
px">
                <td colspan="7">
                </td>
            </tr>

            <tr style="text-align: left;">
                <td colspan="8">
                    <table cellpadding="3" cellspacing="0" style="border-collapse:collapse; width:100%;margin-top:-8px;">
                        <tr height="35">
                            <td style="width:35%; border-top:1px solid black;">客户意见：满意<input type="checkbox" /> 一般<input type="checkbox" />
                                差<input type="checkbox" /> 很差<input type="checkbox" /></td>
                            <td style="width:10%; border-top:1px solid black;">打单：</td>
                            <td style="width:36%; border-top:1px solid black;">兹收到上列货品！ 收货人签字：</td>
                        </tr>
                        <tr style="padding-top:0px; border-bottom:none;font-size:12px;padding-right:20px;">
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
<div class="NOPRINT" style="height:5px;" ></div>
<!--分页-->
<div class="PageNext"></div>
<?php }?>

<?php }} ?>

</body>
</html>

<script type="text/javascript">

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
        LODOP.PRINT_INITA("0mm","0mm","100%","100%","");
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

    //打印
    $('#print').click(function(e){
        $.get("<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'doPrint'),$_smarty_tpl);?>
", { delivery_id: "<?php echo $_smarty_tpl->getVariable('deliveryIds')->value;?>
"} );
    });
</script>