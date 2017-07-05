<?php /* Smarty version Smarty-3.0.6, created on 2013-11-05 20:37:26
         compiled from "D:\www\flysky/app/b2c/view\foot.html" */ ?>
<?php /*%%SmartyHeaderCode:21655278e686b19a11-05594619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ada89fc9962ce2e5158964248137aac44a5181b5' => 
    array (
      0 => 'D:\\www\\flysky/app/b2c/view\\foot.html',
      1 => 1316276070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21655278e686b19a11-05594619',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="footer" class="margin">
  <div class="foot-line"></div>
  <div class="container">
    <div class="fl">Copyright© 2011 - 2015 <a href="http://www.huahua365.com">huahua365.com</a>  Corporation Limited All Rights Reserved<br>
      版权所有©花花世界 <?php echo $_smarty_tpl->getVariable('sys_base_icp')->value;?>
</div>
    <div class="fr"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['img'][0][0]->smarty_img(array('src'=>"skin/service.png",'width'=>"96",'height'=>"32",'class'=>"fl"),$_smarty_tpl);?>
<strong><?php echo $_smarty_tpl->getVariable('sys_base_customer_center')->value;?>
</strong></div>
  </div>
</div>
<script>
(function(){
$('login_popup') && $('login_popup').addEvent('click',function(e){
    e.stop();
    new Dialog('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'ctl_member','a'=>'login'),$_smarty_tpl);?>
',{title:'登录', width:480,height:260,pins:true,async:'ajax'});
});

if ($('Slider')){
    var navs = $('Slider').getElements('li');

    var navSlideShow = new SlideShow($('Slider').getElement('.preview'), {
        selector: 'img',
        autoplay: true,
        transition: 'pushLeft',
        onShow: function(data){
            navs[data.previous.index].removeClass('curr');
            navs[data.next.index].addClass('curr');
        }
    });

    navs.each(function(item, index){
        item.addEvent('mouseenter', function(){
            var transition = (navSlideShow.index < index) ? 'pushLeft' : 'pushRight';
            navSlideShow.show(index, {transition: transition});
        });
    });
}
})();
</script>
</body>
</html>
