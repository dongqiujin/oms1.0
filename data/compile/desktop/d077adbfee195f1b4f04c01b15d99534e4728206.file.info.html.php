<?php /* Smarty version Smarty-3.0.6, created on 2013-11-16 23:53:54
         compiled from "H:\flysky\server\wamp\www\flysky/app/desktop/view\customer/info.html" */ ?>
<?php /*%%SmartyHeaderCode:1781528795122e8ec6-68019330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd077adbfee195f1b4f04c01b15d99534e4728206' => 
    array (
      0 => 'H:\\flysky\\server\\wamp\\www\\flysky/app/desktop/view\\customer/info.html',
      1 => 1384604204,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1781528795122e8ec6-68019330',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="dialog-forms">
    <form method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'save','isAjax'=>true),$_smarty_tpl);?>
" id="customer_form">
        <input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" />
        <input type="hidden" name="cus_id" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_id'];?>
" />
        <ul class="cus-edit">
            <li><em style="color:red;">*</em> 客户公司简称：<input type="text" name="cus_name" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_name'];?>
" required /></li>
            <li>客户公司名称：<input type="text" size="60" name="cus_company" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_company'];?>
" /></li>
            <li>客户公司地址：<input type="text" size="60" name="cus_address" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_address'];?>
" /></li>
            <li>客户代号：<input type="text" name="cus_bn" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_bn'];?>
" /></li>
            <li>联系人：<input type="text" name="cus_contacts" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_contacts'];?>
" /></li>
            <li>联系电话：<input type="text" name="cus_tel" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_tel'];?>
" /></li>
            <li>传真：<input type="text" name="cus_fax" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_fax'];?>
" /></li>
            <li>手机：<input type="text" name="cus_mobile" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_mobile'];?>
" /></li>
            <li>邮编：<input type="text" name="cus_zip" value="<?php echo $_smarty_tpl->getVariable('detail')->value['cus_zip'];?>
" /></li>
        </ul>
        <button type="submit">保存</button>　<button type="button" class="popup-btn-close">取消</button>
    </form>
</div>
<script>
    window.addEvent('domready',function(){

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
                        self.window.location.reload();
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
