<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 20:54:10
         compiled from "D:\www\flysky/app/desktop/view\customer/list.html" */ ?>
<?php /*%%SmartyHeaderCode:2363752876af2d95c44-84486844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c224530e81039ca3ddc8f581f99e221e56a9d90f' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\customer/list.html',
      1 => 1384606438,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2363752876af2d95c44-84486844',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<h1>
    <span class="action-span">
        <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
/search/do" method="post" name="searchForm">
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/icon_search_g.gif",'width'=>"26",'height'=>"22",'border'=>"0",'alt'=>"SEARCH"),$_smarty_tpl);?>

            客户名称：<input type="text" name="cus_name" size="15"  value="<?php echo $_smarty_tpl->getVariable('cus_name')->value;?>
" />
            <input type="submit" value="搜索" class="button" />
        </form>
    </span>
    <span class="action-span1" style="cursor: hand;" id="add">
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/customer/add_customer.png",'width'=>"24",'height'=>"24",'border'=>"0",'style'=>"cursor: hand;",'alt'=>"添加客户"),$_smarty_tpl);?>

    </span>
    <div style="clear:both"></div>
</h1>

<?php  $_smarty_tpl->tpl_vars['cus'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cus']->key => $_smarty_tpl->tpl_vars['cus']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['cus']->key;
?>
    <div style="<?php if (($_smarty_tpl->tpl_vars['keys']->value+1)%15!=0){?>float:left;<?php }?>width:150px; margin:5px; margin-bottom:10px; text-align: center;" class="customer">
        <div style="text-align: center;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/customer/customer.png",'width'=>"32",'height'=>"32",'border'=>"0",'alt'=>"{".($_smarty_tpl->tpl_vars['cus']->value).".cus_name}"),$_smarty_tpl);?>
</div>
        <p><?php echo $_smarty_tpl->tpl_vars['cus']->value['cus_name'];?>
</p>
        <div style="margin-top:-15px;">
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/edit.png",'style'=>"cursor:hand;",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"编辑",'class'=>"edit",'cus_id'=>($_smarty_tpl->tpl_vars['cus']->value['cus_id'])),$_smarty_tpl);?>

        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/dollar.png",'style'=>"cursor:hand;",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"单价",'class'=>"price",'cus_id'=>($_smarty_tpl->tpl_vars['cus']->value['cus_id'])),$_smarty_tpl);?>

        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/order.png",'style'=>"cursor:hand;",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"下单",'class'=>"order",'cus_id'=>($_smarty_tpl->tpl_vars['cus']->value['cus_id'])),$_smarty_tpl);?>

        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->tpl_vars['cus']->value['cus_id'];?>
/ship_status/waiting">
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/icon_docs.gif",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"订单列表"),$_smarty_tpl);?>

        </a>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_delivery','a'=>'index'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->tpl_vars['cus']->value['cus_id'];?>
/print_status/0">
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/print.png",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"发货单列表"),$_smarty_tpl);?>

        </a>
        </div>
    </div>
<?php }} ?>

<script>

    $$('.customer').addEvent('mouseover', function(e){
        this.setStyle('background-color','#BBDDE5');
    });
    $$('.customer').addEvent('mouseout', function(e){
        this.setStyle('background-color','');
    });

    // 添加客户信息
    $('add').addEvent('click', function(e){
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'add'),$_smarty_tpl);?>
';
        dialog('添加客户信息', url);
    });

    // 编辑客户信息
    $$('.edit').addEvent('click', function(e){
        var cus_id = this.get('cus_id');
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'edit'),$_smarty_tpl);?>
/cus_id/' + cus_id;
        dialog('编辑客户信息', url);
    });

    // 单价维护
    $$('.price').addEvent('click', function(e){
        var cus_id = this.get('cus_id');
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'price'),$_smarty_tpl);?>
/cus_id/' + cus_id;
        dialog('客户单价维护', url);
    });

    // 下单
    $$('.order').addEvent('click', function(e){
        var cus_id = this.get('cus_id');
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'add'),$_smarty_tpl);?>
/cus_id/' + cus_id;
        dialog('客户下单', url, '', 800, 450);
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
</script>
