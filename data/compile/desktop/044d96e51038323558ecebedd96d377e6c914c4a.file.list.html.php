<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 22:55:36
         compiled from "D:\www\flysky/app/desktop/view\delivery/list.html" */ ?>
<?php /*%%SmartyHeaderCode:1541852878768b23117-51760767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '044d96e51038323558ecebedd96d377e6c914c4a' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\delivery/list.html',
      1 => 1384613732,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1541852878768b23117-51760767',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'D:\www\flysky\app\base\Drivers\Smarty\plugins\modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<style>
    .link {color:gray;cursor:pointer; padding:0px}
    .active {color:white;cursor:pointer; background-color:green; padding:4px}
</style>
<h1>
  <span class="action-span">
      <form action="<?php echo $_smarty_tpl->getVariable('selfUrl')->value;?>
/search/do" method="post" name="searchForm">
          <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/icon_search_g.gif",'width'=>"26",'height'=>"22",'bdelivery'=>"0",'alt'=>"SEARCH"),$_smarty_tpl);?>

          <select name="cus_id">
              <option value="">全部客户</option>
              <?php  $_smarty_tpl->tpl_vars['cus'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('customerList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cus']->key => $_smarty_tpl->tpl_vars['cus']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['cus']->key;
?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['cus']->value['cus_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cus']->value['cus_id']==$_smarty_tpl->getVariable('cus_id')->value){?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['cus']->value['cus_name'];?>
</option>
              <?php }} ?>
          </select>
          <!-- 关键字 -->
          发货时间：<input type="text" name="from_delivery_time" id="from_delivery_time" size="10" value="<?php echo $_smarty_tpl->getVariable('from_delivery_time')->value;?>
" onFocus="WdatePicker()" /> -
          <input type="text" name="to_delivery_time" id="to_delivery_time" size="10" value="<?php echo $_smarty_tpl->getVariable('to_delivery_time')->value;?>
" onFocus="WdatePicker()" />
          发货单号：<input type="text" name="delivery_bn" size="10" value="<?php echo $_smarty_tpl->getVariable('delivery_bn')->value;?>
" />
          <input type="submit" value="搜索" class="button" />
      </form>
  </span>
  <span class="action-span1">
      <?php if ($_smarty_tpl->getVariable('customer')->value['cus_name']){?>客户：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_name'];?>
<?php }?>  发货单列表：
      <a href="<?php echo $_smarty_tpl->getVariable('selfUrl')->value;?>
/print_status/0"><span class="<?php if ($_smarty_tpl->getVariable('print_status')->value=='0'){?>active<?php }else{ ?>link<?php }?>">未打印</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterUnPrint')->value;?>
)</span> &nbsp;&nbsp;&nbsp;
      <a href="<?php echo $_smarty_tpl->getVariable('selfUrl')->value;?>
/print_status/1"><span class="<?php if ($_smarty_tpl->getVariable('print_status')->value=='1'){?>active<?php }else{ ?>link<?php }?>">已打印</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterPrinted')->value;?>
)</span> &nbsp;&nbsp;&nbsp;
      <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'index'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
"><span class="<?php if ($_smarty_tpl->getVariable('print_status')->value==''){?>active<?php }else{ ?>link<?php }?>">全部</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterAll')->value;?>
)</span>
  </span>
    <div style="clear:both"></div>
</h1>

<div>
    <?php if ($_smarty_tpl->getVariable('allCustomer')->value!='true'){?><input type="button" value="打印" id="delivery" name="btn_operator" class="button" /><?php }?>
    <?php if ($_smarty_tpl->getVariable('allCustomer')->value!='true'&&$_smarty_tpl->getVariable('print_status')->value=='1'){?><input type="button" value="清单" id="inventory" name="btn_operator" class="button" /><?php }?>
</div>

<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'prints'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
" method="post" name="deliveryListForm" id="deliveryListForm" target="_blank">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <thead>
            <tr>
                <th class="tlt" width="50">
                    <input id="selectAll" type="checkbox" />
                </th>
                <?php if (!$_smarty_tpl->getVariable('customer')->value){?><th>客户</th><?php }?>
                <th><a href="javascript:;" class="sort" sort_name="delivery_bn" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>" >发货单号</a></th>
                <th><a href="javascript:;" class="sort" sort_name="delivery_time" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">生成时间</a></th>
                <th><a href="javascript:;" class="sort" sort_name="print_time" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">打印时间</a></th>
                <th><a href="javascript:;" class="sort" sort_name="print_status" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">打印状态</a></th>
                <th class="last">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  $_smarty_tpl->tpl_vars['delivery'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['delivery']->key => $_smarty_tpl->tpl_vars['delivery']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['delivery']->key;
?>
            <tr>
                <td align="center">
                    <?php if ($_smarty_tpl->getVariable('allCustomer')->value=='true'){?>-<?php }else{ ?><input type="checkbox" name="delivery_id[]" value="<?php echo $_smarty_tpl->tpl_vars['delivery']->value['delivery_id'];?>
" /><?php }?>
                </td>
                <?php if (!$_smarty_tpl->getVariable('customer')->value){?><td><?php echo $_smarty_tpl->tpl_vars['delivery']->value['cus_name'];?>
</td><?php }?>
                <td class="first-cell"><?php echo $_smarty_tpl->tpl_vars['delivery']->value['delivery_bn'];?>
</td>
                <td align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['delivery']->value['delivery_time'],'%Y-%m-%d %H:%M:%S');?>
</td>
                <td align="center"><?php echo (($tmp = @smarty_modifier_date_format($_smarty_tpl->tpl_vars['delivery']->value['print_time'],'%Y-%m-%d %H:%M:%S'))===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td align="center"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['delivery']->value['print_status_name'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td align="center" class="last">
                    <a title="发货明细" href="javascript:;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'border'=>"0",'height'=>"16",'src'=>"img/icon_view.gif",'class'=>"items",'delivery_id'=>$_smarty_tpl->tpl_vars['delivery']->value['delivery_id']),$_smarty_tpl);?>
</a>
                    <span style="width:50px;">&nbsp;</span>
                    <?php if ($_smarty_tpl->tpl_vars['delivery']->value['print_status']=='1'||$_smarty_tpl->getVariable('allCustomer')->value=='true'){?>-<?php }else{ ?>
                    <a title="回收站" class="recycle" delivery_id="<?php echo $_smarty_tpl->tpl_vars['delivery']->value['delivery_id'];?>
" href="javascript:;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'bdelivery'=>"0",'height'=>"16",'src'=>"img/del.png"),$_smarty_tpl);?>
</a>
                    <?php }?>
                </td>
            </tr>
            <?php }} else { ?>
            <tr><td class="no-records" colspan="6">没有发货单</td></tr>
            <?php } ?>
            </tbody>
        </table>
        <!-- end delivery list -->

        <!-- 分页 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td align="center" nowrap="true">
                    <div id="turn-page">
                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['pager'][0][0]->smarty_pager(array('pager'=>$_smarty_tpl->getVariable('pager')->value,'myclass'=>"yahoo2",'c'=>"ctl_delivery",'a'=>"index",'cus_id'=>$_smarty_tpl->getVariable('cus_id')->value,'print_status'=>$_smarty_tpl->getVariable('print_status')->value,'offset'=>"2"),$_smarty_tpl);?>

                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<script>

    // 打印
    $('delivery').addEvent('click', function(e){
        if (!$$('input[name="delivery_id[]"]').get('checked')) {
            alert('请选择需要打印的发货单');
            return;
        }
        var cus_id = '<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
';
        $('deliveryListForm').set('action', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'prints'),$_smarty_tpl);?>
/cus_id/' + cus_id);
        $('deliveryListForm').submit();
    });

    // 打印清单
    $('inventory').addEvent('click', function(e){
        var cus_id = '<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
';
        $('deliveryListForm').set('action', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'printInventory'),$_smarty_tpl);?>
/cus_id/' + cus_id);
        $('deliveryListForm').submit();
    });

    // 查看明细
    $$('.items').addEvent('click', function(e){
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'items'),$_smarty_tpl);?>
';
        var delivery_id = this.get('delivery_id');
        dialog('发货单明细', url, 'delivery_id='+delivery_id);
    });

    function dialog(title,url,data,width,height){
        width = width ? width : '680';
        height = height ? height : '350';
        new Dialog(url,{title:title, width:width,height:height,pins:true,async:'ajax',
            position: {
                offset: {x: 0, y: -60},
                intoView: true
            },
            asyncOptions: {
                method: 'post',
                data: data
            }
        });
    }

    // 全选与取消全选
    $('selectAll').addEvent('click', function(e){
        if (this.get('checked')) {
            $$('input[name="delivery_id[]"').set('checked', 'checked');
        } else {
            $$('input[name="delivery_id[]"').set('checked', '');
        }
    });

    $$('.recycle').addEvent('click',function(e){
        e.stop();
        var delivery_id = this.get('delivery_id');
        if (window.confirm('确定要删除吗?删除后不可恢复')){
            new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'del'),$_smarty_tpl);?>
/delivery_id/'+delivery_id,
                onComplete:function(re){
                    var result = JSON.decode(re);
                    if (result.rsp == 'succ') {
                        alert('删除成功');
                        self.window.location.reload();
                    }
                    else{
                        alert(result.res);
                        return false;
                    }
                }
            }).send();
        }
        return false;
    });

    // 排序
    $$('.sort').addEvent('click',function(e){
        var url = '<?php echo $_smarty_tpl->getVariable('selfUrl')->value;?>
';
        self.window.location = url + '/sort_name/' + this.get('sort_name') + '/sort_type/' + this.get('sort_type');
    });
</script>
