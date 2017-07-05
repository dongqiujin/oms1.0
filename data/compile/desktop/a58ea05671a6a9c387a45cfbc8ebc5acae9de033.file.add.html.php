<?php /* Smarty version Smarty-3.0.6, created on 2015-11-24 20:01:01
         compiled from "G:\htdocs\www\flysky/app/desktop/view\order/add.html" */ ?>
<?php /*%%SmartyHeaderCode:277175654517d344172-91834985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a58ea05671a6a9c387a45cfbc8ebc5acae9de033' => 
    array (
      0 => 'G:\\htdocs\\www\\flysky/app/desktop/view\\order/add.html',
      1 => 1402228824,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '277175654517d344172-91834985',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'G:\htdocs\www\flysky\app\base\Drivers\Smarty\plugins\modifier.date_format.php';
?><h1>
  <span class="action-span">电话：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_tel'];?>
  / <?php echo $_smarty_tpl->getVariable('customer')->value['cus_mobile'];?>
</span>
  <span class="action-span1">客户：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_name'];?>
  &nbsp;&nbsp;&nbsp;&nbsp;日期：<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
</span>
  <div style="clear:both"></div>
</h1>
<form method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'doSave','isAjax'=>true),$_smarty_tpl);?>
" id="order_form">
  <div class="list-div" id="listDiv">
      <input type="hidden" name="cus_id" value="<?php echo $_smarty_tpl->getVariable('customer')->value['cus_id'];?>
" />
      <input type="hidden" id="maxGid" value="0" />
      <input type="hidden" id="curGid" value="0" />

      <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('paperType')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['type_id']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
          <?php if ($_smarty_tpl->tpl_vars['val']->value['price']){?>
              <div id='priceTips<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
' class="tips" style="display: none; position: absolute; background-color:#FBFBFB; line-height:20px; border: 1px solid #CCCCCC; ">
                  <?php  $_smarty_tpl->tpl_vars['price'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['price']->key => $_smarty_tpl->tpl_vars['price']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['price']->key;
?>
                  <input type="radio" name="customerPrice[<?php echo $_smarty_tpl->tpl_vars['val']->value['type_id'];?>
][]" class="choice-price" value="<?php echo $_smarty_tpl->tpl_vars['price']->value;?>
" size="6" /> <?php echo $_smarty_tpl->tpl_vars['price']->value;?>

                  <?php }} ?>
                  <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/close.gif",'width'=>"16",'onclick'=>"HideTips(\"priceTips".($_smarty_tpl->tpl_vars['type_id']->value)."\");",'height'=>"16",'border'=>"0",'alt'=>"关闭"),$_smarty_tpl);?>

              </div>
          <?php }?>
      <?php }} ?>

    <table cellpadding="3" cellspacing="1">
      <thead>
        <tr>
          <th>纸质</th>
		  <th>尺寸</th>
		  <th>原订数</th>
		  <th>单价</th>
		  <th>金额</th>
            <th>备注</th>
          <th class="last">
		  操作 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/add.png",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"添加",'id'=>"addGoods"),$_smarty_tpl);?>

		  <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/adds.gif",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"添加配件",'id'=>"addProducts"),$_smarty_tpl);?>

		  </th>
        </tr>
      </thead>
      <tbody id="goods_list">
      </tbody>
    </table>
  </div>

<div style="text-align:center;">
    <button type="submit">保存</button>　
    <button type="button" class="popup-btn-close">取消</button>
</div>
</form>

<script>

    // 保存
    var f = $('order_form');
    var action = f.get('action');
    f.addEvent('submit',function(e){
        e.stop();
        if(!validator(this)) return false;

        var submit_btn = this.getElement('[type=submit]');
        new Request({url:action,
            onRequest:function(e){
                submit_btn.set('value', '下单处理中...');
                submit_btn.set('disabled', true);
            },
            onComplete:function(re){
                var result = JSON.decode(re);
                if (result.rsp == 'succ')
                {
                    alert(result.msg);
                    self.window.location.href = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index','cus_id'=>$_smarty_tpl->getVariable('cus_id')->value),$_smarty_tpl);?>
';
                }else{
                    submit_btn.set('disabled', false);
                    submit_btn.set('value', '保存');
                    alert(result.msg);
                    return false;
                }
            }
        }).send(f.toQueryString());
    });

    // 添加纸
    $('addGoods').addEvent('click', function(e){
        var paperType = '', html = '';
        var maxGid = parseInt($('maxGid').get('value')) + 1;
        $('maxGid').set('value', maxGid);
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('paperType')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['type_id']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['type_id']->value!=4){?>
        paperType += '<input type="radio" name="paper_type['+maxGid+']" value="<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
" class="paper_type" price_num="<?php echo $_smarty_tpl->tpl_vars['val']->value['price_num'];?>
" price="<?php echo $_smarty_tpl->tpl_vars['val']->value['price'][0];?>
" type_id="<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
" />';
        paperType += '<?php echo $_smarty_tpl->tpl_vars['val']->value['short_name'];?>
';
		<?php }?>
        <?php }} ?>

        var delButton = "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'delGoods'),$_smarty_tpl);?>
";
        html += '<td>'+paperType+'<input type="hidden" name="type[]" value=""/><input type="text" name="price[]" atype="price"  value="" size="6" required autocomplete="off" /></td>';
        html += '<td><input type="hidden" size="30" name="name[]"  value=""/>';
        html += '长:<input type="text" size="3" name="length[]" atype="length"  value="" autocomplete="off" required/>*';
        html += '宽:<input type="text" size="3" name="width[]" atype="width"  value="" autocomplete="off" required />*';
        html += '高:<input type="text" size="3" name="height[]" atype="height"  value="" autocomplete="off" required />';
        html += '</td>';
        html += '<td><input type="text" size="3" name="num[]" atype="num" value="" autocomplete="off" required /></td>';
        html += '<td><input type="hidden" size="3" name="sale_price[]"  value="" /><span btype="sale_price">-</span></td>';
        html += '<td><input type="hidden" size="3" name="amount[]" value="" /><span btype="amount">-</span></td>';
        html += '<td><input type="text" size="20" name="memo[]" value="" /></td>';
        html += '<td>'+delButton+'</td>';
        html += '</tr>';

        var tr = new Element('tr', {id:'gid_'+maxGid,goods_type:'goods',html: html}).inject($('goods_list'));

        // 选择纸质
        $$('.paper_type').addEvent('click', function(e){
            var price_num = this.get('price_num');
            var type_id = this.get('type_id');
            var gid = this.getParent('td').getParent('tr').get('id');
            hideAllTips();
            if (price_num > 1) {
                $('curGid').set('value', gid);
				this.getParent('td').getChildren('input[name="type[]"]').set('value', type_id);
                ShowTips('priceTips'+type_id);
            } else {
                var price = this.get('price');
                this.getParent('td').getChildren('input[atype=price]').set('value', price).fireEvent('change');
            }
            this.getParent('td').getChildren('input[name="type[]"]').set('value', type_id);
        });

        // 选择价格
        $$('.choice-price').addEvent('click', function(e){
            var price = this.get('value');
            var curGid = $('curGid').get('value');
            $(curGid).getElement('input[atype=price]').set('value', price).fireEvent('change');
            this.getParent().hide();
        });

        $$("input[atype]").addEvent('change', function(e){
            changetotalgoods(this);
        });

        $$('.delGoods').addEvent('click', function(e){
            if (confirm('确认要删除吗?')) {
                this.getParent('tr').destroy();
            }
        });
    });
    $('addGoods').fireEvent('click');


	// 添加配件
    $('addProducts').addEvent('click', function(e){
        var paperType = '', html = '';
        var maxGid = parseInt($('maxGid').get('value')) + 1;
        $('maxGid').set('value', maxGid);

        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('paperType')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['type_id']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['type_id']->value==4){?>
        paperType += '<input type="radio" name="paper_type['+maxGid+']" value="<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
" class="paper_type" price_num="<?php echo $_smarty_tpl->tpl_vars['val']->value['price_num'];?>
" price="<?php echo $_smarty_tpl->tpl_vars['val']->value['price'][0];?>
" type_id="<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
" />';
        paperType += '<?php echo $_smarty_tpl->tpl_vars['val']->value['short_name'];?>
';
		<?php }?>
        <?php }} ?>

        var delButton = "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'delGoods'),$_smarty_tpl);?>
";
        html += '<td>'+paperType+'<input type="hidden" name="type[]" value=""/><input type="text" name="price[]" atype="price"  value="" size="6" required /></td>';
        html += '<td>';
        html += '名称：<input type="text" size="30" name="name[]"  value=""/><br/> 长:<input type="text" size="3" name="length[]" atype="length"  value=""/><input type="hidden" size="3" name="height[]" atype="height"  value=""/>*宽：<input type="text" size="3" atype="width" name="width[]"  value="" autocomplete="off" required/>';
        html += '</td>';
        html += '<td><input type="text" size="3" name="num[]" atype="num" value="" autocomplete="off" required /></td>';
        html += '<td><input type="hidden" size="3" name="sale_price[]"  value="" /><span btype="sale_price">-</span></td>';
        html += '<td><input type="hidden" size="3" name="amount[]" value="" /><span btype="amount">-</span></td>';
        html += '<td><input type="text" size="20" name="memo[]" value="" /></td>';
        html += '<td>'+delButton+'</td>';
        html += '</tr>';

        var tr = new Element('tr', {id:'gid_'+maxGid,goods_type:'products', html: html}).inject($('goods_list'));


		// 选择纸质
        $$('.paper_type').addEvent('click', function(e){
            var price_num = this.get('price_num');
            var type_id = this.get('type_id');
            var gid = this.getParent('td').getParent('tr').get('id');
            hideAllTips();
            if (price_num > 1) {
                $('curGid').set('value', gid);
				this.getParent('td').getChildren('input[name="type[]"]').set('value', type_id);
                ShowTips('priceTips'+type_id);
            } else {
                var price = this.get('price');
                this.getParent('td').getChildren('input[atype=price]').set('value', price).fireEvent('change');
            }
            this.getParent('td').getChildren('input[name="type[]"]').set('value', type_id);
        });

        // 选择价格
        $$('.choice-price').addEvent('click', function(e){
            var price = this.get('value');
            var curGid = $('curGid').get('value');
            $(curGid).getElement('input[atype=price]').set('value', price).fireEvent('change');
            this.getParent().hide();
        });


        $$("input[atype]").addEvent('change', function(e){
            changetotalgoods(this);
        });

        $$('.delGoods').addEvent('click', function(e){
            if (confirm('确认要删除吗?')) {
                this.getParent('tr').destroy();
            }
        });
    });

    function changetotalgoods(e){
        var _ca = e.getNext('.error');
        var tr = e.getParent('tr');

        if (/^\d+(\.\d+)?$/.test(e.value)){
            if (parseFloat(e.value) <= 0){
                if (!_ca){
                    new Element('span',{'class':'error caution notice-inline',html:'错误'}).inject(e,'after');
                    e.set('value', '0');
                }
                return;
            }else{
                if (_ca) _ca.remove();
            }
        }else{
            if (!_ca){
                new Element('span',{'class':"error caution notice-inline",html:"错误"}).inject(e,'after');
                e.set('value', '0');
            }
        }


        var goods_type = tr.get('goods_type');
        var price = parseFloat(tr.getElement('input[atype=price]').get('value')) || 0;
        var num = tr.getElement('input[atype=num]').get('value') || 1;
        if (num == 1) tr.getElement('input[atype=num]').set('value', num);

//alert(goods_type);
		if (goods_type == 'goods') {
			var length = parseFloat(tr.getElement('input[atype=length]').get('value')) || 0;
			var width = parseFloat(tr.getElement('input[atype=width]').get('value')) || 0;
			var height = parseFloat(tr.getElement('input[atype=height]').get('value')) || 0;
			
			if (!price || !length || !width || !height) {
				return;
			}

			//少于30个，每个加0.2元
			//if(num < 30){
				//price += 0.2;
			//}

			var sale_price = price * ((length + width + 8) / 100) * ((width + height + 4) / 100);
		} else {
            var length = parseFloat(tr.getElement('input[atype=length]').get('value')) || 0;
            var width = parseFloat(tr.getElement('input[atype=width]').get('value')) || 0;
            if (!price) {
                return;
            }
            if (length && width) {
                var sale_price = price * (length / 100) * (width / 100);
            } else {
			var sale_price = price;
	    }
	    }

        //销售价
        tr.getElement('input[name=sale_price[]]').set('value', parseFloat(sale_price).toFixed(3));
        tr.getElement('span[btype=sale_price]').set('text',  parseFloat(sale_price).toFixed(3));


        //金额
        tr.getElement('input[name=amount[]]').set('value', parseFloat(num * sale_price).toFixed(3));
        tr.getElement('span[btype=amount]').set('text', parseFloat(num * sale_price).toFixed(3));
    }

    function ShowTips(e)
    {
        $$('.tips').hide();
        if (document.getElementById(e)) {
            var div = document.getElementById(e);
            div.style.display="block";
            div.style.left=document.body.scrollLeft+e.clientX+20;
            div.style.top=document.body.scrollTop+e.clientY;
        }
    }

    function HideTips(e)
    {
        if (document.getElementById(e)) {
            var div=document.getElementById(e);
            div.style.display="none";
        }
    }

    // 隐藏价格
    function hideAllTips()
    {
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('paperType')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['type_id']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
          HideTips('priceTips'+<?php echo $_smarty_tpl->tpl_vars['type_id']->value;?>
);
    <?php }} ?>
    }

    // 取消
    $$('.popup-btn-close').addEvent('click', function(e){
        this.getParent('.popup-container').retrieve('instance').hide();
    });

</script>
