<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 23:57:28
         compiled from "H:\flysky\server\wamp\www\flysky/app/desktop/view\customer/price.html" */ ?>
<?php /*%%SmartyHeaderCode:24187528795e8ac3d84-69976551%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96817e547fb4197b5c3c38b3fcde1e3d7298d638' => 
    array (
      0 => 'H:\\flysky\\server\\wamp\\www\\flysky/app/desktop/view\\customer/price.html',
      1 => 1384532862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24187528795e8ac3d84-69976551',
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
        <ul class="cus-edit">
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('paperType')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
            <div>
                <?php echo $_smarty_tpl->tpl_vars['val']->value['full_name'];?>
:

                <?php if ($_smarty_tpl->tpl_vars['val']->value['price']){?>
                    <?php  $_smarty_tpl->tpl_vars['price'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['price']->key => $_smarty_tpl->tpl_vars['price']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['price']->key;
?>
                         <?php if ($_smarty_tpl->tpl_vars['k']->value>0){?><span><?php }?>
                         <input type="text" name="price[<?php echo $_smarty_tpl->tpl_vars['val']->value['type_id'];?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['price']->value;?>
" size="6" />
                         <?php if ($_smarty_tpl->tpl_vars['k']->value>0){?>
                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'del-input'),$_smarty_tpl);?>

                            </span>
                         <?php }?>
                    <?php }} ?>
                <?php }else{ ?>
                    <input type="text" name="price[<?php echo $_smarty_tpl->tpl_vars['val']->value['type_id'];?>
][]" value="" size="6" />
                <?php }?>

                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/add.png",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"添加",'class'=>"add",'type_id'=>($_smarty_tpl->tpl_vars['val']->value['type_id'])),$_smarty_tpl);?>

            </div>
            <?php }} ?>
        </ul>
        <button type="submit">保存</button>　<button type="button" class="popup-btn-close">取消</button>
    </form>
</div>
<script>
    window.addEvent('domready',function(){

        // 添加
        $$('.add').addEvent('click', function(e){
            var type_id = this.get('type_id');
            var input = '<input type="text" name="price['+ type_id +'][]" value="" size="6" />';
            input += "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'del-input'),$_smarty_tpl);?>
";
            var price = new Element('span', {html: input}).inject(this, 'before');
            price.getElement('.del-input').addEvent('click', function(e){
                this.getParent('span').destroy();
            });
        });

        $$('.del-input').addEvent('click', function(e){
            this.getParent('span').destroy();
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
