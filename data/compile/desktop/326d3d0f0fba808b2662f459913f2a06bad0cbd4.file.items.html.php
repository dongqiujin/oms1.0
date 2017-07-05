<?php /* Smarty version Smarty-3.0.6, created on 2013-11-15 20:51:43
         compiled from "D:\www\flysky/app/desktop/view\delivery/items.html" */ ?>
<?php /*%%SmartyHeaderCode:8691528618dfe44772-36776760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '326d3d0f0fba808b2662f459913f2a06bad0cbd4' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\delivery/items.html',
      1 => 1384519901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8691528618dfe44772-36776760',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="list-div" id="listDiv">
    <table cellpadding="3" cellspacing="1">
        <thead>
        <tr>
            <th><a href="javascript:;" class="sort" sort_name="order_bn" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>" >订单号</a></th>
            <th><a href="javascript:;" class="sort" sort_name="type" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">纸质</a></th>
            <th><a href="javascript:;">尺寸</a></th>
            <th><a href="javascript:;" class="sort" sort_name="num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">原订数</a></th>
            <th><a href="javascript:;" class="sort" sort_name="send_num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">已发货</a></th>
            <th><a href="javascript:;" class="sort" sort_name="price" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">单价</a></th>
            <th><a href="javascript:;" class="sort" sort_name="amount" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">金额</a></th>
            <th><a href="javascript:;">备注</a></th>
        </tr>
        </thead>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['order']->key;
?>
        <tr>
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
            <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['price'];?>
</td>
            <td class="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['amount'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['memo'];?>
</td>
        </tr>
        <?php }} else { ?>
        <tr><td class="no-records" colspan="13">没有明细</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div style="text-align:center;">
    <button type="button" class="popup-btn-close">关闭</button>
</div>
<script>

    // 取消
    $$('.popup-btn-close').addEvent('click', function(e){
        this.getParent('.popup-container').retrieve('instance').hide();
    });

</script>