<?php /* Smarty version Smarty-3.0.6, created on 2017-06-04 23:38:36
         compiled from "/data/httpd/myproject/myself/order/app/desktop/view/order/add.html" */ ?>
<?php /*%%SmartyHeaderCode:12230801475934297c26e3b1-75637188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2ce885f95dc054d3bf34e54862f3d9cd906a48a' => 
    array (
      0 => '/data/httpd/myproject/myself/order/app/desktop/view/order/add.html',
      1 => 1496590709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12230801475934297c26e3b1-75637188',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/httpd/myproject/myself/order/app/base/Drivers/Smarty/plugins/modifier.date_format.php';
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
          <th>产品名称</th>
		  <th>尺寸</th>
          <th>颜色</th>
		  <th>收货数量</th>
		  <th>单价</th>
		  <th>金额</th>
            <th>备注</th>
          <th class="last">
		  操作 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/add.png",'width'=>"16",'height'=>"16",'border'=>"0",'alt'=>"添加",'id'=>"addGoods"),$_smarty_tpl);?>

		 
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

    //产品名称
    var pNameOptions = '<option value=""></option>';
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pNameList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
        pNameOptions += '<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>'
    <?php }} ?>

    //产品尺寸
    var pSizeOptions = '<option value=""></option>';
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pSizeList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
        pSizeOptions += '<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>'
    <?php }} ?>

    //产品颜色
    var pColorOptions = '<option value=""></option>';
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pColorList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
        pColorOptions += '<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>'
    <?php }} ?>

    // 添加产品
    $('addGoods').addEvent('click', function(e){
        var paperType = '', html = '';
        var maxGid = parseInt($('maxGid').get('value')) + 1;
        $('maxGid').set('value', maxGid);

        var delButton = "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>'img/del.png','width'=>'16','height'=>'16','border'=>'0','alt'=>'删除','class'=>'delGoods'),$_smarty_tpl);?>
";
        html += '<td><select name="product_name[]" class="product_name" required>'+pNameOptions+'</select></td>';
        html += '<td><select name="product_size[]" class="product_size" required>'+pSizeOptions+'</select></td>';
        html += '<td><select name="product_color[]" class="product_color" required>'+pColorOptions+'</select></td>';
        html += '<td><input type="text" size="6" name="num[]" atype="num" value="" autocomplete="off" required /></td>';
        html += '<td><input type="hidden" size="3" name="sale_price[]"  atype="price"  value="" /><span btype="sale_price">-</span></td>';
        html += '<td><input type="hidden" size="3" name="amount[]" atype="amount" value="" /><span btype="amount">-</span></td>';
        html += '<td><input type="text" size="20" name="memo[]" value="" /></td>';
        html += '<td>'+delButton+'</td>';
        html += '</tr>';

        var tr = new Element('tr', {id:'gid_'+maxGid,goods_type:'goods',html: html}).inject($('goods_list'));

        //读取单价
        $$('.product_name').addEvent('change', function(e){
            getPrice(maxGid);
        });
        $$('.product_size').addEvent('change', function(e){
            getPrice(maxGid);
        });
        $$('.product_color').addEvent('change', function(e){
            getPrice(maxGid);
        });

        //收获数量绑定
        $$("input[atype=num]").addEvent('change', function(e){
            totalAmount(maxGid);
        });

        $$('.delGoods').addEvent('click', function(e){
            if (confirm('确认要删除吗?')) {
                this.getParent('tr').destroy();
            }
        });
    });
    $('addGoods').fireEvent('click');

    //异步读取价格
    function getPrice(gid) {
        var productName = '';
        var productSize = '';
        var productColor = '';
        productName = $('gid_'+gid).getElement('.product_name').value || '';
        productSize = $('gid_'+gid).getElement('.product_size').value || '';
        productColor = $('gid_'+gid).getElement('.product_color').value || '';

        if (!productName || !productSize || !productColor) {
            return;
        }

        new Request.JSON({
            url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'getMemberPrice','isAjax'=>true),$_smarty_tpl);?>
",
            method: 'post',
            data: 'product_name='+productName+'&product_size='+productSize+'&product_color='+productColor,
            onSuccess: function(res) {
                if (res.rsp == 'succ') {
                    var priceList = res.data;
                    if (res.nums <= 0) {
                        $('gid_'+gid).getElement('input[atype=price]').set('value', '0');
                        $('gid_'+gid).getElement('span[btype=sale_price]').set('html', '-');
                        totalAmount(gid);
                        return;
                    }

                    if (res.nums == 1) {
                        $('gid_'+gid).getElement('input[atype=price]').set('value', priceList[0]);
                        $('gid_'+gid).getElement('span[btype=sale_price]').set('text', priceList[0]);
                        //计算金额
                        totalAmount(gid);
                    } else if (res.nums > 1) {
                        var priceHtml = '';
                        priceList.each(function(price){
                            priceHtml += '<input type="radio" name="choice_price" class="choice_price" value="'+price+'" />'+price;
                        });
                        $('gid_'+gid).getElement('span[btype=sale_price]').set('html', priceHtml);

                        //选择价格绑定事件
                        $$(".choice_price").addEvent('change', function(e){
                            choicePrice(gid);
                        });
                    }
                }
            }
        }).send();
    }

    //选择价格
    function choicePrice(gid)
    {
        var choicePrice = $('gid_'+gid).getElement('input[class=choice_price]:checked').value;

        $('gid_'+gid).getElement('input[atype=price]').set('value', choicePrice);
        $('gid_'+gid).getElement('span[btype=sale_price]').set('text', choicePrice);

        totalAmount(gid);
    }

    //计算金额
    function totalAmount(gid)
    {
        var price = $('gid_'+gid).getElement('input[atype=price]').value || 0;
        var num = $('gid_'+gid).getElement('input[atype=num]').value || 0;
        var amount = parseFloat(price * num).toFixed(3);

        $('gid_'+gid).getElement('input[atype=amount]').set('value', amount);
        $('gid_'+gid).getElement('span[btype=amount]').set('text', amount);
    }

    // 取消
    $$('.popup-btn-close').addEvent('click', function(e){
        this.getParent('.popup-container').retrieve('instance').hide();
    });

</script>
