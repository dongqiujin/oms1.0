<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 20:37:23
         compiled from "D:\www\flysky/app/b2c/view\index.html" */ ?>
<?php /*%%SmartyHeaderCode:127985278e683cf7689-87456875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ff8ee8ea0275d22aab046e59c37d607a1419875' => 
    array (
      0 => 'D:\\www\\flysky/app/b2c/view\\index.html',
      1 => 1318516261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127985278e683cf7689-87456875',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<!-- 正文部分开始 -->
<div id="container" class="container clearfix">
  <div class="slider fl" id="Slider">
    <div class="preview clearfix">
      <?php  $_smarty_tpl->tpl_vars['hdp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('module_hdp')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hdp']->key => $_smarty_tpl->tpl_vars['hdp']->value){
?><a href="<?php echo $_smarty_tpl->tpl_vars['hdp']->value['mark_link'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('public_dir')->value;?>
/<?php echo $_smarty_tpl->tpl_vars['hdp']->value['mark_pic'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['hdp']->value['mark_title'];?>
" /></a> <?php }} ?>  </div>
    <ul class="menu clearfix">
      <?php  $_smarty_tpl->tpl_vars['hdp_title'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('module_hdp')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hdp_title']->key => $_smarty_tpl->tpl_vars['hdp_title']->value){
?>
      <li class="curr"><?php echo $_smarty_tpl->tpl_vars['hdp_title']->value['mark_title'];?>
</li>
	  <?php }} ?>
    </ul>
  </div>
  <div class="news fr">
    <div class="head clearfix">
      <h2 class="fl"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r1_c27.png",'width'=>"68",'height'=>"14"),$_smarty_tpl);?>
 </h2>
      <div class="more fr"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_article','a'=>'lists','cid'=>$_smarty_tpl->getVariable('g_cid')->value),$_smarty_tpl);?>
" target="_blank">更多>></a></div>
    </div>
    <div class="section">
      <ul>
	    <?php  $_smarty_tpl->tpl_vars['gonggao'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('gonggao_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gonggao']->key => $_smarty_tpl->tpl_vars['gonggao']->value){
?>
        <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_article','a'=>'view','id'=>$_smarty_tpl->tpl_vars['gonggao']->value['article_id'],'cat_id'=>$_smarty_tpl->getVariable('g_cid')->value),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['gonggao']->value['title'];?>
 </a></li>
		<?php }} ?>
      </ul>
    </div>
  </div>
  <div class="cat margin fl">
    <div class="head"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r6_c1.png",'width'=>"720",'height'=>"31"),$_smarty_tpl);?>
</div>
    <div class="section clearfix">
	  <div class="fl line-right">
        <h3><?php echo $_smarty_tpl->getVariable('flower_cat_name')->value;?>
</h3>
        <dl>
		<?php  $_smarty_tpl->tpl_vars['flower'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('flower_cat')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['flower']->key => $_smarty_tpl->tpl_vars['flower']->value){
?>
		  <?php if ($_smarty_tpl->tpl_vars['flower']->value['cat_name']!='颜色'){?>
          <dt><?php echo $_smarty_tpl->tpl_vars['flower']->value['cat_name'];?>
</dt>
          <dd><?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['flower']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
?>
		  <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'index'),$_smarty_tpl);?>
/cid/<?php echo $_smarty_tpl->tpl_vars['items']->value['cat_id'];?>
/pid/<?php echo $_smarty_tpl->getVariable('flower_cat_id')->value;?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value['cat_name'];?>
</a>
		  <?php }} ?>
		  </dd>
		  <?php }?>
		<?php }} ?>
        </dl>
        <h3><?php echo $_smarty_tpl->getVariable('elec_cat_name')->value;?>
</h3>
        <dl>
		<?php  $_smarty_tpl->tpl_vars['elec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('elec_cat')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['elec']->key => $_smarty_tpl->tpl_vars['elec']->value){
?>
          <?php if ($_smarty_tpl->tpl_vars['elec']->value['cat_name']!='用途'){?><dt><?php echo $_smarty_tpl->tpl_vars['elec']->value['cat_name'];?>
</dt><?php }?>
          <dd>
		  <?php  $_smarty_tpl->tpl_vars['elec_items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['elec']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['elec_items']->key => $_smarty_tpl->tpl_vars['elec_items']->value){
?>
		  <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'index'),$_smarty_tpl);?>
/cid/<?php echo $_smarty_tpl->tpl_vars['elec_items']->value['cat_id'];?>
/pid/<?php echo $_smarty_tpl->getVariable('elec_cat_id')->value;?>
"><?php echo $_smarty_tpl->tpl_vars['elec_items']->value['cat_name'];?>
</a> 
		  <?php }} ?></dd>
		<?php }} ?>
        </dl>
      </div>
      <div class="fl line-right">
	    <?php  $_smarty_tpl->tpl_vars['other'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('other_cat')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['other']->key => $_smarty_tpl->tpl_vars['other']->value){
?>
        <h3><?php echo $_smarty_tpl->tpl_vars['other']->value['cat_name'];?>
</h3>
		<?php if ($_smarty_tpl->tpl_vars['other']->value['child'][0]['child']){?>
			<?php  $_smarty_tpl->tpl_vars['other_father'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['other']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['other_father']->key => $_smarty_tpl->tpl_vars['other_father']->value){
?>
			<dl>
			  <?php if (!in_array($_smarty_tpl->tpl_vars['other_father']->value['cat_name'],array('用途','卡通','礼盒'))){?><dt><?php echo $_smarty_tpl->tpl_vars['other_father']->value['cat_name'];?>
</dt><?php }?>
			  <dd>
			  <?php  $_smarty_tpl->tpl_vars['other_son'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['other_father']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['other_son']->key => $_smarty_tpl->tpl_vars['other_son']->value){
?>
			  <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'index'),$_smarty_tpl);?>
/cid/<?php echo $_smarty_tpl->tpl_vars['other_son']->value['cat_id'];?>
/pid/<?php echo $_smarty_tpl->tpl_vars['other']->value['cat_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['other_son']->value['cat_name'];?>
</a> 
			  <?php }} ?>
			  </dd>
			</dl>
			<?php }} ?>
		<?php }else{ ?>
			<dl>
			  <dd>
			  <?php  $_smarty_tpl->tpl_vars['other_father'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['other']->value['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['other_father']->key => $_smarty_tpl->tpl_vars['other_father']->value){
?>
			  <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'index'),$_smarty_tpl);?>
/cid/<?php echo $_smarty_tpl->tpl_vars['other_father']->value['cat_id'];?>
/pid/<?php echo $_smarty_tpl->tpl_vars['other']->value['cat_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['other_father']->value['cat_name'];?>
</a> 
			  <?php }} ?>
			  </dd>
			</dl>
		<?php }?>		

		<?php }} ?>
      </div>
    </div>
  </div>
  <div class="rank margin fr">
    <div class="head"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r6_c25.png",'width'=>"220",'height'=>"40"),$_smarty_tpl);?>
</div>
    <div class="section">
      <ul class="clearfix">
	    <?php  $_smarty_tpl->tpl_vars['sales'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sales_num_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sales']->key => $_smarty_tpl->tpl_vars['sales']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['sales']->key;
?>
        <li>
          <div class="fl"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['sales']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('public_dir')->value;?>
/<?php echo $_smarty_tpl->tpl_vars['sales']->value['images']['thumb']['thumb_rank_size'];?>
"  /></a></div>
          <div class="fr"><img src="<?php echo $_smarty_tpl->getVariable('statics_path')->value;?>
/skin/no<?php echo $_smarty_tpl->tpl_vars['keys']->value+1;?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['sales']->value['name'];?>
" width="18" height="5" />
            <h3><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['sales']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><?php echo $_smarty_tpl->tpl_vars['sales']->value['name'];?>
</a></h3>
            <p>销售价:<i>￥<?php echo $_smarty_tpl->tpl_vars['sales']->value['sales_price'];?>
</i></p>
          </div>
        </li>
		<?php }} ?>
      </ul>
    </div>
  </div>
  <div class="hot margin">
    <div class="head clearfix">
      <h2 class="fl"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r20_c3.png",'width'=>"84",'height'=>"19"),$_smarty_tpl);?>
 </h2>
      <div class="more fr"><a href="#">更多>></a></div>
    </div>
    <div class="section">
      <ul class="clearfix">
	    <?php  $_smarty_tpl->tpl_vars['hot'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hot_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hot']->key => $_smarty_tpl->tpl_vars['hot']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['hot']->key;
?>
        <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['hot']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('public_dir')->value;?>
/<?php echo $_smarty_tpl->tpl_vars['hot']->value['images']['thumb']['thumb_normal_size'];?>
"  /></a>
          <h3><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['hot']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><?php echo $_smarty_tpl->tpl_vars['hot']->value['name'];?>
</a></h3>
          <del>市场价:￥<?php echo $_smarty_tpl->tpl_vars['hot']->value['market_price'];?>
</del>
          <p>销售价:<i>￥<?php echo $_smarty_tpl->tpl_vars['hot']->value['sales_price'];?>
</i></p>
        </li>
		<?php }} ?>
      </ul>
    </div>
  </div>
  <div class="hot margin">
    <div class="head clearfix nobg">
      <h2 class="fl"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/tt_r25_c3.png",'width'=>"84",'height'=>"19"),$_smarty_tpl);?>
 </h2>
      <div class="more fr"><a href="#">更多>></a></div>
    </div>
    <div class="section">
      <ul class="clearfix">
	    <?php  $_smarty_tpl->tpl_vars['special'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('special_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['special']->key => $_smarty_tpl->tpl_vars['special']->value){
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['special']->key;
?>
        <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['special']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('public_dir')->value;?>
/<?php echo $_smarty_tpl->tpl_vars['special']->value['images']['thumb']['thumb_normal_size'];?>
"  /></a>
          <h3><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_goods','a'=>'view','id'=>$_smarty_tpl->tpl_vars['special']->value['goods_id']),$_smarty_tpl);?>
.html" target="_blank"><?php echo $_smarty_tpl->tpl_vars['special']->value['name'];?>
</a></h3>
          <del>市场价:￥<?php echo $_smarty_tpl->tpl_vars['special']->value['market_price'];?>
</del>
          <p>销售价:<i>￥<?php echo $_smarty_tpl->tpl_vars['special']->value['sales_price'];?>
</i></p>
        </li>
		<?php }} ?>
      </ul>
    </div>
  </div>
  <?php $_template = new Smarty_Internal_Template("foot_link.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
</div>
<!-- 正文部分结束 -->
<?php $_template = new Smarty_Internal_Template("foot.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>