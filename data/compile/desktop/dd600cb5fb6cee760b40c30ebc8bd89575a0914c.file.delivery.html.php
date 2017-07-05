<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 21:04:58
         compiled from "D:\www\flysky/app/desktop/view\order/delivery.html" */ ?>
<?php /*%%SmartyHeaderCode:2166352876d7a5afce3-14669531%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd600cb5fb6cee760b40c30ebc8bd89575a0914c' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\order/delivery.html',
      1 => 1384607092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2166352876d7a5afce3-14669531',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'D:\www\flysky\app\base\Drivers\Smarty\plugins\modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<h1>
    <span class="action-span">电话：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_tel'];?>
  / <?php echo $_smarty_tpl->getVariable('customer')->value['cus_mobile'];?>
</span>
    <span class="action-span1">客户：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_name'];?>
  &nbsp;&nbsp;&nbsp;&nbsp;日期：<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
</span>
    <div style="clear:both"></div>
</h1>

<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'makeDelivery'),$_smarty_tpl);?>
" method="post" name="deliveryForm" id="deliveryForm">
    <input type="hidden" name="cus_id" value="<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
" />
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <thead>
            <tr>
                <th><a href="javascript:;" >订单号</a></th>
                <th><a href="javascript:;" >纸质</a></th>
                <th><a href="javascript:;">尺寸</a></th>
                <th><a href="javascript:;" >原订数</a></th>
                <th><a href="javascript:;" >已发数</a></th>
                <th><a href="javascript:;" >剩余数</a></th>
            </tr>
            </thead>
            <tbody>
            <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('order_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['order']->key;
?>
            <tr id="pr_<?php echo $_smarty_tpl->tpl_vars['order']->value['order_id'];?>
">
                <td class="first-cell"><?php echo $_smarty_tpl->tpl_vars['order']->value['order_bn'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['type_name'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['length'];?>
*<?php echo $_smarty_tpl->tpl_vars['order']->value['width'];?>
*<?php echo $_smarty_tpl->tpl_vars['order']->value['height'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['num'];?>
</td>
                <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['send_num'];?>
</td>
                <td class="center">
                    <?php $_smarty_tpl->tpl_vars["remain_num"] = new Smarty_variable((($_smarty_tpl->tpl_vars['order']->value['num']-$_smarty_tpl->tpl_vars['order']->value['send_num'])), null, null);?>
                    <input type="text" name="send_num[<?php echo $_smarty_tpl->tpl_vars['order']->value['order_id'];?>
]" size="8" value="<?php echo $_smarty_tpl->getVariable('remain_num')->value;?>
" class="send_num" order_id="<?php echo $_smarty_tpl->tpl_vars['order']->value['order_id'];?>
" max="<?php echo $_smarty_tpl->getVariable('remain_num')->value;?>
" min="0" required />
                </td>
            </tr>
            <?php }} else { ?>
            <tr><td class="no-records" colspan="13">请选择要发货订单</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="text-align:center;">
        <button type="submit">生成发货单</button>　
        <button type="button" class="popup-btn-close">取消</button>
    </div>
</form>

<script>

    // 保存
    var f = $('deliveryForm');
    var action = f.get('action');
    f.addEvent('submit',function(e){
        e.stop();
        if(!validator(this)) return false;

        var submit_btn = this.getElement('[type=submit]');
        new Request({url:action,
            onRequest:function(e){
                submit_btn.set('value', '发货中...');
                submit_btn.set('disabled', true);
            },
            onComplete:function(re){
                var result = JSON.decode(re);
                if (result.rsp == 'succ')
                {
                    alert(result.msg);
                    self.window.location = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'index'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
/print_status/0';
                }else{
                    submit_btn.set('value', '发货');
                    submit_btn.set('disabled', false);
                    alert(result.msg);
                    return false;
                }
            }
        }).send(f.toQueryString());
    });

    $$(".send_num").addEvent('change', function(e){
        send_num_filter(this);
    });

    function send_num_filter(e)
    {
        var _ca = e.getNext('.error');
        var tr = e.getParent('tr');
        var order_id = e.get('order_id');
        var max = e.get('max');
        var min = e.get('min');

        if (/^\d+$/.test(e.value)){
            if (parseInt(e.value) < min || parseInt(e.value) > max){
                if (!_ca){
                    new Element('span',{'class':'error caution notice-inline',html:'最多发货数量:'+max}).inject(e,'after');
                    e.set('value', '0');
                }
                return;
            }else{
                if (_ca) _ca.remove();
            }
        }else{
            if (!_ca){
                new Element('span',{'class':"error caution notice-inline",html:"发货数输入有误"}).inject(e,'after');
                e.set('value', '0');
                return;
            }
        }
    }

</script>
