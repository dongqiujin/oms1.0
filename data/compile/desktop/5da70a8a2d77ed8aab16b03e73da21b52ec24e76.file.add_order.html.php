<?php /* Smarty version Smarty-3.0.6, created on 2013-11-07 21:17:42
         compiled from "D:\www\flysky/app/desktop/view\order/add_order.html" */ ?>
<?php /*%%SmartyHeaderCode:17893527b92f6c577e2-29294299%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5da70a8a2d77ed8aab16b03e73da21b52ec24e76' => 
    array (
      0 => 'D:\\www\\flysky/app/desktop/view\\order/add_order.html',
      1 => 1314892454,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17893527b92f6c577e2-29294299',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<h1>
  <span class="action-span"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'index'),$_smarty_tpl);?>
">订单列表</a></span>
  <span class="action-span1">添加订单</span>
  <div style="clear:both"></div>
</h1>
<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'save'),$_smarty_tpl);?>
" method="post" name="saveForm" id="saveForm">
<div class="form-div">
	<select name="type" id="type">
      <option value="name">按会员名</option>
	  <option value="email">按邮箱</option>
	  <option value="mobile">按手机号</option>
    </select>
    <input type="text" name="key_member" id="key_member" size="30" value="" />
    
	<input type="button" value="搜索" class="button" id="search_member" />
  <table>
    <thead>
	<tr><th>会员名</th><th>固定电话</th><th>手机</th><th>Email</th>
	<th>收货人姓名</th><th>收货人地址</th>
	</tr>
	</thead>
	<tbody id="member_list">
	</tbody>
  </table>
</div>

  <div class="list-div" id="listDiv">
    添加商品
	<p>
  按商品编号或商品名称搜索  <input type="text" value="" size="50" name="key_goods" id="key_goods" />
  <input type="button" onclick="searchGoods();" value=" 搜索 " class="button" name="search" />
  <select onchange="getGoodsInfo(this.value)" name="goodslist" id="goodslist_select" style="display:none;">
  </select>
</p>
    <table cellpadding="3" cellspacing="1">
      <thead>
        <tr>
          <th>商品名称</th>
		  <th>商品编号</th>
		  <th>价格</th>
		  <th>数量</th>
		  <th>小计</th>
          <th class="last">操作</th>
        </tr>
      </thead>
      <tbody id="goods_list">
      </tbody>
    </table>
  </div>
<br/>
<div class="form-div">
	其它信息
	<table>
	<tr>
		<td>配送费用</td><td><input type="text" name="cost_freight" value="" /></td>
		<td>支付状态</td><td>
		<select name="pay_status">
			<option value="0">未支付</option>
			<option value="1">已支付</option>
		</select>
		</td>
		<td>发货状态</td><td>
		<select name="ship_status">
			<option value="0">未发货</option>
			<option value="1">已发货</option>
		</select>
		</td>
	</tr>
	</table>
</div>

	
<div style="text-align:center;">
 <input type="button" value="下单" id="btn_order" name="btn_order" class="button" disabled="disabled" />
</div>
</form>

<script>
// 下单
var f = $('saveForm');
$('btn_order').addEvent('click', function(e){
	f.submit();
});


$('search_member').addEvent('click',function(e){
	e.stop();
	var type = $('type').get('value');
	var key_member = $('key_member').get('value');
	if (key_member){
	  new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'search_member'),$_smarty_tpl);?>
',
		onComplete:function(re){
		  var result = JSON.decode(re);
		  if (result.rsp == 'succ')
		  {
			var m = result.data;
			$('goodslist_select').empty();
			var ini_option = new Element('option', {'text':'请选择'});
			m.each(function(item,index){
			  var tr = new Element('tr', {});
			  var input = '<input type="radio" name="member_id" value="'+item.member_id+'" />';
			  var td = '<td>'+input+item.name+'</td>';
			  td += '<td>'+item.phone+'</td>';
			  td += '<td>'+item.mobile+'</td>';
			  td += '<td>'+item.email+'</td>';
			  td += '<td>'+item.area+'</td>';
			  td += '<td>'+item.address+'</td>';
			  tr.set('html', td);
			  tr.inject($('member_list'));
			});
		  }		  
		}
	  }).send('type='+type+'&value='+key_member);
	}
	return false;
});

// 搜索商品
function searchGoods(){
	var key_goods = $('key_goods').get('value');
	if (key_goods){
	  new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'search_goods'),$_smarty_tpl);?>
',
		onComplete:function(re){
		  var result = JSON.decode(re);
		  if (result.rsp == 'succ')
		  {
			var m = result.data;
			$('goodslist_select').empty().setStyle('display', '');
			var ini_option = new Element('option', {'text':'请选择商品'});
			ini_option.inject($('goodslist_select'));
			m.each(function(item,index){
			  var option = new Element('option', {'value':item.goods_id,'text':item.name});
			  option.inject($('goodslist_select'));
			});
		  }else{
			$('goodslist_select').empty();
			var ini_option = new Element('option', {'text':'没有查询到商品'});
			ini_option.inject($('goodslist_select'));
		  }
		}
	  }).send('key_goods='+key_goods);
	}
	return false;
}

// 获取商品信息
function getGoodsInfo(goods_id){
	new Request({url:'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_order','a'=>'goods_info'),$_smarty_tpl);?>
',
		onComplete:function(re){
		  var result = JSON.decode(re);
		  if (result.rsp == 'succ')
		  {
			$('btn_order').set('disabled', '');
			var g = result.data;
			var tr = new Element('tr', {});
			var td = '<td>'+g.name+'</td>';
			td += '<td>'+g.bn+'</td>';
			td += '<td>'+g.sales_price+'</td>';
			td += '<td><input type="text" name="num['+g.goods_id+']" goods_id='+g.goods_id+' price='+g.sales_price+' value="1" size="10" /></td>';
			td += '<td><span id="counter['+g.goods_id+']">'+g.sales_price+'</span></td>';
			td += '<td><a href="javascript:;" class="del" onclick="del_goods(this);">删除</a></td>';
			tr.set('html', td);
			tr.inject($('goods_list'));
			// 小计
			var goods_num = $$('input[name^=num]');
			goods_num.addEvent('change', function(e){
				var goods_id = this.get('goods_id'),price = this.get('price');
				var c = this.get('value') * price;
				$('counter['+goods_id+']').set('text', c);
			});
		  }
		}
	  }).send('goods_id='+goods_id);
}

function del_goods(obj){
	if (window.confirm('真的要删除吗?'))
	{
		$(obj).getParent('td').getParent('tr').destroy();
	}else{
		return false;
	}
}
</script>
