<?php /* Smarty version Smarty-3.0.6, created on 2017-05-30 16:27:36
         compiled from "/data/httpd/myproject/myself/order/app/desktop/view/customer/price.html" */ ?>
<?php /*%%SmartyHeaderCode:2083001134592d2cf8480e15-48394143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f6924c0357125cef4fba740cc6adec504102998' => 
    array (
      0 => '/data/httpd/myproject/myself/order/app/desktop/view/customer/price.html',
      1 => 1496132854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2083001134592d2cf8480e15-48394143',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="dialog-forms">
    <form method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'setPrice','isAjax'=>true),$_smarty_tpl);?>
" id="customer_form">
        <input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" />
        <input type="hidden" name="cus_id" value="<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
" />

            <table>
            <thead>
                <th>产品名称</th>
                <th>产品尺寸</th>
                <th>产品颜色</th>
                <th>价格(多个价格，以逗号隔开)</th>
                <th>
                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/add.png",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"添加",'class'=>"add"),$_smarty_tpl);?>

                </th>
            </thead>
            <tbody id="product_body"  >
                <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('price')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
                <tr>
                    <td>
                        <input type="hidden" name="product[price_id][]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['price_id'];?>
" size="20" />
                        <input type="text" name="product[product_name][]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_name'];?>
" size="30" />
                    </td>
                    <td>
                        <input type="text" name="product[product_size][]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_size'];?>
" size="10" />
                    </td>
                    <td>
                        <input type="text" name="product[product_color][]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_color'];?>
" size="10" />
                    </td>
                    <td>
                        <input type="text" name="product[price][]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
" size="50" style="font-size:15px;color:blue;" /> 
                    </td>
                    <td>
                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'del-input'),$_smarty_tpl);?>

                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            </table>
            <div style="text-align: center;">
            <button type="submit">保存</button>　<button type="button" class="popup-btn-close">取消</button>
            </div>

    </form>
</div>
<script>
    window.addEvent('domready',function(){

        // 添加
        var delImg = "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'del-input'),$_smarty_tpl);?>
";
        $$('.add').addEvent('click', function(e){
            var input = '<td>';
                input += '    <input type="text" name="product[product_name][]" value="" size="20" />';
                input += '</td>';
                input += '<td>';
                input += '    <input type="text" name="product[product_size][]" value="" size="10" />';
                input += '</td>';
                input += '<td>';
                input += '    <input type="text" name="product[product_color][]" value="" size="10" />';
                input += '</td>';
                input += '<td>';
                input += '    <input type="text" name="product[price][]" value="" size="50"  style="font-size:15px;color:blue;" />';
                input += '</td>';
                input += '<td>';
                input += delImg;
                input += '</td>';

            var price = new Element('tr', {html: input}).inject('product_body', 'after');

            price.getElement('.del-input').addEvent('click', function(e){
                this.getParent('tr').destroy();
            });
        });

        $$('.del-input').addEvent('click', function(e){
            this.getParent('tr').destroy();
        });

        // 保存
        var f = $('customer_form');
        var action = f.get('action');
        f.addEvent('submit',function(e){
            e.stop();
            if(!validator(this)) return false;

            var submit_btn = this.getElement('[type=submit]');
            new Request({url:action,
                onRequest:function(e){
                    submit_btn.set('disabled', true);
                },
                onComplete:function(re){
                    var result = JSON.decode(re);
                    if (result.rsp == 'succ')
                    {
                        alert(result.msg);
                        submit_btn.getParent('.popup-container').retrieve('instance').hide();
//                        self.window.location.reload();
                    }else{
                        submit_btn.set('disabled', false);
                        alert(result.msg);
                        return false;
                    }
                }
            }).send(f.toQueryString());
        });

        // 取消
        $$('.popup-btn-close').addEvent('click', function(e){
            this.getParent('.popup-container').retrieve('instance').hide();
        });

    });
</script>
