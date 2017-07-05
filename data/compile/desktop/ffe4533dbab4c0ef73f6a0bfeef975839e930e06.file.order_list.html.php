<?php /* Smarty version Smarty-3.0.6, created on 2017-07-02 22:32:33
         compiled from "/data/httpd/myproject/myself/order/app/desktop/view/order/order_list.html" */ ?>
<?php /*%%SmartyHeaderCode:69559215959590401e1c465-39809370%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ffe4533dbab4c0ef73f6a0bfeef975839e930e06' => 
    array (
      0 => '/data/httpd/myproject/myself/order/app/desktop/view/order/order_list.html',
      1 => 1498997637,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69559215959590401e1c465-39809370',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/data/httpd/myproject/myself/order/app/base/Drivers/Smarty/plugins/modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<style>
   .link {color:gray;cursor:pointer; padding:0px}
   .active {color:white;cursor:pointer; background-color:green; padding:4px}
</style>
<h1>
  <div>
      <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
/search/do/<?php if ($_smarty_tpl->getVariable('ship_status')->value){?>ship_status/<?php echo $_smarty_tpl->getVariable('ship_status')->value;?>
<?php }?>" method="post" name="searchForm">
          <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"img/icon_search_g.gif",'width'=>"26",'height'=>"22",'border'=>"0",'alt'=>"SEARCH"),$_smarty_tpl);?>

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
          下单时间：<input type="text" name="from_create_time" id="from_create_time" size="10" value="<?php echo $_smarty_tpl->getVariable('from_create_time')->value;?>
" onFocus="WdatePicker()" /> -
          <input type="text" name="to_create_time" id="to_create_time" size="10" value="<?php echo $_smarty_tpl->getVariable('to_create_time')->value;?>
" onFocus="WdatePicker()" />
          发货时间：<input type="text" name="from_delivery_time" id="from_delivery_time" size="10" value="<?php echo $_smarty_tpl->getVariable('from_delivery_time')->value;?>
" onFocus="WdatePicker()" /> -
          <input type="text" name="to_delivery_time" id="to_delivery_time" size="10" value="<?php echo $_smarty_tpl->getVariable('to_delivery_time')->value;?>
" onFocus="WdatePicker()" />
          订单号：<input type="text" name="order_bn" size="10" value="<?php echo $_smarty_tpl->getVariable('order_bn')->value;?>
" />
          产品名称：<input type="text" name="product_name" size="6" value="<?php echo $_smarty_tpl->getVariable('product_name')->value;?>
" />
          尺寸：<input type="text" name="product_size" size="6" value="<?php echo $_smarty_tpl->getVariable('product_size')->value;?>
" />
          颜色：<input type="text" name="product_color" size="6" value="<?php echo $_smarty_tpl->getVariable('product_color')->value;?>
" />
          <input type="submit" value="搜索" class="button" />
      </form>
  </div>
  
  <div style="clear:both"></div>
</h1>

<div>
    <?php if ($_smarty_tpl->getVariable('allCustomer')->value!='true'){?><input type="button" value="发货" id="delivery" name="btn_operator" class="button" /><?php }?>
    <span class="action-span1">
      <?php if ($_smarty_tpl->getVariable('customer')->value['cus_name']){?>客户：<?php echo $_smarty_tpl->getVariable('customer')->value['cus_name'];?>
<?php }?> 订单列表：
      <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('cus_id')->value){?>/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
<?php }?>/ship_status/waiting"><span class="<?php if ($_smarty_tpl->getVariable('ship_status')->value=='waiting'){?>active<?php }else{ ?>link<?php }?>">待发货</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterWaiting')->value;?>
)</span> &nbsp;&nbsp;&nbsp;
      <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('cus_id')->value){?>/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
<?php }?>/ship_status/1"><span class="<?php if ($_smarty_tpl->getVariable('ship_status')->value=='1'){?>active<?php }else{ ?>link<?php }?>">已发货</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterShiped')->value;?>
)</span> &nbsp;&nbsp;&nbsp;
      <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('cus_id')->value){?>/cus_id/<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
<?php }?>/ship_status/all"><span class="<?php if ($_smarty_tpl->getVariable('ship_status')->value=='all'){?>active<?php }else{ ?>link<?php }?>">全部</span></a><span style="color:red;">(<?php echo $_smarty_tpl->getVariable('counterAll')->value;?>
)</span>
  </span>
</div>

<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'operator'),$_smarty_tpl);?>
" method="post" name="actionForm" id="actionForm">
  <input type="hidden" name="selfUrl" id="selfUrl" value="<?php echo $_smarty_tpl->getVariable('selfUrl')->value;?>
" />
  <div class="list-div" id="listDiv">
    <table cellpadding="3" cellspacing="1">
      <thead>
        <tr style="text-align: center;">
          <th>
            <input id="selectAll" type="checkbox" />
          </th>
          <?php if (!$_smarty_tpl->getVariable('customer')->value){?><th>客户</th><?php }?>
          <th><a href="javascript:;" class="sort" sort_name="order_bn" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>" >订单号</a></th>
          <th><a href="javascript:;" class="sort" sort_name="name" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">产品名称</a></th>
          <th><a href="javascript:;" class="sort" sort_name="size" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">尺寸</a></th>
          <th><a href="javascript:;" class="sort" sort_name="color" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">颜色</a></th>
          <th><a href="javascript:;" class="sort" sort_name="num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">原订数</a></th>
          <th><a href="javascript:;" class="sort" sort_name="send_num" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">已发货</a></th>
		  <th><a href="javascript:;" class="sort" sort_name="price" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">单价</a></th>
          <th><a href="javascript:;" class="sort" sort_name="amount" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">金额</a></th>
          <th><a href="javascript:;" class="sort" sort_name="create_time" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">下单时间</a></th>
          <th><a href="javascript:;">发货时间</a></th>
            <th><a href="javascript:;" class="sort" sort_name="ship_status" sort_type="<?php if ($_smarty_tpl->getVariable('sort_type')->value=='asc'){?>desc<?php }else{ ?>asc<?php }?>">发货状态</a></th>
          <th><a href="javascript:;">备注</a></th>
          <th class="last">操作</th>
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
        <tr>
          <td align="center">
              <?php if ($_smarty_tpl->tpl_vars['order']->value['ship_status']=='1'||$_smarty_tpl->getVariable('allCustomer')->value=='true'){?>-<?php }else{ ?><input type="checkbox" name="order_id[]" value="<?php echo $_smarty_tpl->tpl_vars['order']->value['order_id'];?>
" /><?php }?>
          </td>
          <?php if (!$_smarty_tpl->getVariable('customer')->value){?><td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['cus_name'];?>
</td><?php }?>
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
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['amount'];?>
</td>
          <td align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['order']->value['create_time'],'%Y-%m-%d %H:%M:%S');?>
</td>
          <td align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['order']->value['delivery_time'],'%Y-%m-%d %H:%M:%S');?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['ship_status_name'];?>
</td>
            <td align="center"><?php echo $_smarty_tpl->tpl_vars['order']->value['memo'];?>
</td>
          <td align="center" class="last">
            <a title="回收站" class="recycle" order_id="<?php echo $_smarty_tpl->tpl_vars['order']->value['order_id'];?>
" href="javascript:;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('width'=>"16",'border'=>"0",'height'=>"16",'src'=>"img/del.png"),$_smarty_tpl);?>
</a>
          </td>
        </tr>
        <?php }} else { ?>
        <tr><td class="no-records" colspan="13">没有订单</td></tr>
        <?php } ?>
      </tbody>
    </table>
    <!-- end order list -->

    <!-- 分页 -->
    <table id="page-table" cellspacing="0">
      <tr>
        <td align="center" nowrap="true">
          <div id="turn-page">
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['pager'][0][0]->smarty_pager(array('pager'=>$_smarty_tpl->getVariable('pager')->value,'myclass'=>"yahoo2",'c'=>"ctl_order",'a'=>"index",'cus_id'=>$_smarty_tpl->getVariable('cus_id')->value,'ship_status'=>$_smarty_tpl->getVariable('ship_status')->value,'offset'=>"1"),$_smarty_tpl);?>

          </div>
        </td>
      </tr>
    </table>

    <div>
      <input type="hidden" name="act" value="batch" />
      <select name="action" id="operator">
        <option value="">请选择...</option>
        <option value="1">删除</option>
      </select>
      <input type="button" value="确定" id="btn_operator" name="btn_operator" class="button" disabled="disabled" />
    </div>
    </div>

    <div style="margin-top:20px;">
        <div style="float:left;margin-right:50px;font-size:14px;color:blue;">
          <h1>产品、尺寸、颜色统计：</h1>
          <ul>
              <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('total_products_all')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['size'];?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['color'];?>
，原订数:<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
， 已发货:<?php echo $_smarty_tpl->tpl_vars['item']->value['send_num'];?>
</li>
              <?php }} ?>
          </ul>
        </div>

        <div style="float:left;margin-right:50px;font-size:14px;color:blue;">
          <h1>产品名称统计：</h1>
          <ul>
              <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('total_products_name')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
，原订数:<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
，已发货:<?php echo $_smarty_tpl->tpl_vars['item']->value['send_num'];?>
</li>
              <?php }} ?>
          </ul>
        </div>

        <div style="float:left;margin-right:50px;font-size:14px;color:blue;">
          <h1>产品尺寸统计：</h1>
          <ul>
              <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('total_products_size')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['item']->value['size'];?>
，原订数:<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
，已发货:<?php echo $_smarty_tpl->tpl_vars['item']->value['send_num'];?>
</li>
              <?php }} ?>
          </ul>
        </div>

        <div style="margin-right:50px;font-size:14px;color:blue;">
          <h1>产品颜色统计：</h1>
          <ul>
              <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('total_products_color')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['item']->value['color'];?>
，原订数:<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
，已发货:<?php echo $_smarty_tpl->tpl_vars['item']->value['send_num'];?>
</li>
              <?php }} ?>
          </ul>
        </div>

  </div>
</form>

<script>
	// 字段编辑
	function editab(obj,order_id,field){
		// 原始内容
		var old_value = $(obj).get('text');
		// 隐藏原值
		$(obj).set('text', '');
		// 创建输入框
		var input = new Element('input', {'type':'text', 'name':field, 'size':'', 'value':old_value});
		input.inject($(obj));
		input.focus();
		input.addEvents({
			'blur': function(e){
			    var new_value = this.get('value');
				if (old_value == new_value)
				{
					$(obj).empty();
					$(obj).set('text', new_value);
				}else{
					new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'editab'),$_smarty_tpl);?>
',
						onComplete:function(re){
						  var result = JSON.decode(re);
						  if (result.rsp == 'succ') {
							 $(obj).empty();
							 $(obj).set('text', new_value);
						  }
						  else{
							alert(result.msg);
							input.focus();
							return false;
						  }
						}
					  }).send('order_id='+order_id+'&'+field+'='+new_value+'&field_name='+field);
				}
			}
		});
	}

	// 状态切换
	function toggle(obj,order_id,field){
		// 原始状态
		var old_status = $(obj).get('src');
		var old_value = $(obj).get('alt');
		var new_value = '';
		if (old_value == '0')
		{
			var new_src = '<?php echo $_smarty_tpl->getVariable('base_url')->value;?>
/app/desktop/statics/img/yes.gif';
			var new_value = '1';
		}else{
			var new_src = '<?php echo $_smarty_tpl->getVariable('base_url')->value;?>
/app/desktop/statics/img/no.gif';
			var new_value = '0';
		}
		
		new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'editab'),$_smarty_tpl);?>
',
			onComplete:function(re){
			  var result = JSON.decode(re);
			  if (result.rsp == 'succ') {
				 $(obj).set('src', new_src);
				 $(obj).set('alt', new_value);
			  }
			  else{
				alert(result.msg);
				return false;
			  }
			}
		  }).send('order_id='+order_id+'&'+field+'='+new_value+'&field_name='+field);
	}

    // 下单
    $$('.order').addEvent('click', function(e){
        var cus_id = this.get('cus_id');
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'add'),$_smarty_tpl);?>
/cus_id/' + cus_id;
        dialog('客户下单', url, '', 700, 450);
    });

    // 发货
    $('delivery').addEvent('click', function(e){
        var cus_id = '<?php echo $_smarty_tpl->getVariable('cus_id')->value;?>
';
        var data = $('actionForm').toQueryString();
        var url = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'delivery'),$_smarty_tpl);?>
/cus_id/' + cus_id;
        dialog('发货', url, data, 700, 450);
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
            $$('input[name="order_id[]"').set('checked', 'checked');
        } else {
            $$('input[name="order_id[]"').set('checked', '');
        }
    });

  // 操作
  $('operator').addEvent('change', function(e){

    if (this.get('value')) {
      $('btn_operator').set('disabled', '');
    }else{
      $('btn_operator').set('disabled', 'disabled');
    }
  });

  // 确定操作
  var actionForm = $('actionForm');
  $('btn_operator').addEvent('click', function(e){
    var operator = $('operator').get('value');
    if (operator == '1' && window.confirm('确定要删除吗?删除后不可恢复')){
      actionForm.submit();
    }

    if (operator != '1') {
      actionForm.submit();
    }
  });

  $$('.recycle').addEvent('click',function(e){
    e.stop();
    var order_id = this.get('order_id');
    if (window.confirm('确定要删除吗?删除后不可恢复')){
      new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'del'),$_smarty_tpl);?>
/order_id/'+order_id,
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
