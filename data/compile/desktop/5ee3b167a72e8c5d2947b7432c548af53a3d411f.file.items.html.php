<?php /* Smarty version Smarty-3.0.6, created on 2017-07-02 10:33:37
         compiled from "/data/httpd/myproject/myself/order/app/desktop/view/delivery/items.html" */ ?>
<?php /*%%SmartyHeaderCode:76599328559585b812bfd38-46615041%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ee3b167a72e8c5d2947b7432c548af53a3d411f' => 
    array (
      0 => '/data/httpd/myproject/myself/order/app/desktop/view/delivery/items.html',
      1 => 1498962813,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '76599328559585b812bfd38-46615041',
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
            <th><a href="javascript:;" class="sort" sort_name="type" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">产品名称</a></th>
            <th><a href="javascript:;">尺寸</a></th>
            <th><a href="javascript:;">颜色</a></th>
            <th><a href="javascript:;" class="sort" sort_name="num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">原订数</a></th>
            <th><a href="javascript:;" class="sort" sort_name="send_num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">已发货</a></th>
            <th><a href="javascript:;" class="sort" sort_name="price" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">单价</a></th>
            <th><a href="javascript:;" class="sort" sort_name="amount" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">金额</a></th>
            <th><a href="javascript:;">备注</a></th>
            <th class="last">操作</th>
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
        <tr id="item_<?php echo $_smarty_tpl->tpl_vars['order']->value['item_id'];?>
">
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['order_bn'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['name'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['size'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['color'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['num'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['send_num'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['price'];?>
</td>
            <td align="center"><?php if ($_smarty_tpl->tpl_vars['order']->value['num']==$_smarty_tpl->tpl_vars['order']->value['send_num']){?><?php echo $_smarty_tpl->tpl_vars['order']->value['amount'];?>
<?php }else{ ?><?php echo round($_smarty_tpl->tpl_vars['order']->value['price']*$_smarty_tpl->tpl_vars['order']->value['send_num'],4);?>
<?php }?></td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['memo'];?>
</td>
			<td align="center" class="last">
                    <a title="回收站" class="recycle-item" item_id="<?php echo $_smarty_tpl->tpl_vars['order']->value['item_id'];?>
" tid="<?php echo $_smarty_tpl->tpl_vars['order']->value['order_bn'];?>
" href="javascript:;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'bdelivery'=>"0",'height'=>"16",'src'=>"img/del.png"),$_smarty_tpl);?>
</a>
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

	//删除
	$$('.recycle-item').addEvent('click',function(e){
        e.stop();
        var item_id = this.get('item_id');
		var tid = this.get('tid');
        if (window.confirm('确定要删除发货明细:'+tid+'吗?删除后不可恢复')){
            new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'delItem'),$_smarty_tpl);?>
/item_id/'+item_id,
                onComplete:function(re){
                    var result = JSON.decode(re);
                    if (result.rsp == 'succ') {
						alert('删除成功');
						$('item_'+result.item_id).hide();
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

    // 取消
    $$('.popup-btn-close').addEvent('click', function(e){
        this.getParent('.popup-container').retrieve('instance').hide();
    });

</script>