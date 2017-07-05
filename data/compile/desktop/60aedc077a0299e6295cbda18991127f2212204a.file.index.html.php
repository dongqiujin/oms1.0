<?php /* Smarty version Smarty-3.0.6, created on 2015-11-24 19:03:08
         compiled from "G:\htdocs\www\flysky/app/desktop/view\index.html" */ ?>
<?php /*%%SmartyHeaderCode:27631565443ec148469-42345691%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60aedc077a0299e6295cbda18991127f2212204a' => 
    array (
      0 => 'G:\\htdocs\\www\\flysky/app/desktop/view\\index.html',
      1 => 1384618020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27631565443ec148469-42345691',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>订单管理系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['style'][0][0]->smarty_style(array('href'=>"css/index.css"),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/swfobject.js"),$_smarty_tpl);?>

</head>
<body>
<div id="header">
    <div>
        <div id="innerHeader">
            
            <div id="topguide">
                <ul id="topguide-entry">
                    <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
?>
                    <?php }} ?>
                </ul>
            </div>
        </div>
        <div class="c"></div>
        <div id="guide"></div>
    </div>
</div>
<div id="selector">
    <div id="left" class="inner"></div>
</div>
<div id="gird">
    <div class="inner">
        <iframe name="main" id="main" frameborder="0" scrolling="auto" style="height:99.9%;visibility:inherit;width:99.95%;z-index:1"></iframe>
    </div>
</div>
<!--下拉目录 开始-->
<div id="footer">
    <div id="innerFooter"></div>
</div>
<iframe name="notice" frameborder="0" style="height:0;width:0;"></iframe>
<div id="menu" style="display:none"></div>
<div id="showmenu" style="display:none"></div>
<script>
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");

var guides={
        <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
'<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
' : {
<?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['sk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['one']->value['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['two']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['two']->iteration=0;
if ($_smarty_tpl->tpl_vars['two']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value){
 $_smarty_tpl->tpl_vars['sk']->value = $_smarty_tpl->tpl_vars['two']->key;
 $_smarty_tpl->tpl_vars['two']->iteration++;
 $_smarty_tpl->tpl_vars['two']->last = $_smarty_tpl->tpl_vars['two']->iteration === $_smarty_tpl->tpl_vars['two']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['submenu']['last'] = $_smarty_tpl->tpl_vars['two']->last;
?>
    '<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['sk']->value;?>
' : {
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['ik'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['two']->value['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
if ($_smarty_tpl->tpl_vars['item']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['ik']->value = $_smarty_tpl->tpl_vars['item']->key;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['last'] = $_smarty_tpl->tpl_vars['item']->last;
?>
        '<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['sk']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['ik']->value;?>
' : ['<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
','']<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['last']){?>,<?php }?>
        <?php }} ?>
        }<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['submenu']['last']){?>,<?php }?>
        <?php }} ?>
        },
        <?php }} ?>
                'common' : {
                    'diy' : {
                    <?php  $_smarty_tpl->tpl_vars['menus'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('default_menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['menus']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['menus']->iteration=0;
if ($_smarty_tpl->tpl_vars['menus']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menus']->key => $_smarty_tpl->tpl_vars['menus']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['menus']->key;
 $_smarty_tpl->tpl_vars['menus']->iteration++;
 $_smarty_tpl->tpl_vars['menus']->last = $_smarty_tpl->tpl_vars['menus']->iteration === $_smarty_tpl->tpl_vars['menus']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['menu']['last'] = $_smarty_tpl->tpl_vars['menus']->last;
?>
                        'dly_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
' : ['<?php echo $_smarty_tpl->tpl_vars['menus']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['menus']->value['url'];?>
','']<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['menu']['last']){?>,<?php }?>
                        <?php }} ?>
                        }
                    }
                }
                var titles={
                        <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['sk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['sk']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
        <?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['one']->value['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['two']->key;
?>
            '<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
' : '<?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
',
        <?php }} ?>
            <?php }} ?>
                'diy' : ''
            }

//注意：下边参数必须是成套出现
//var cate   = 'glmk'; //默认显示主导航
//var action = 'glmk_1'; //默认显示方位
//var type   = 'glmk_1_1';//下级别导航明确

            var cate   = 'common';
            var action = '';
            var type   = '';

            function uptopguide(id){
                var obj = document.getElementById('topguide-entry');
                var objs=obj.getElementsByTagName('li');
                for(var i=0;i<objs.length;i++){
                    objs[i].className = objs[i].id==id ? 'li1' : '';
                }
            }
            function showguide(id){

                var obj = document.getElementById('showmenu');

                var guide = guides[id];
                var html  = '<dl>';

                for(i in guide){
                    var subs = guide[i];
                    html += '<dd class=rl>';
                    for(j in subs){
                        var sub = subs[j];
                        if(sub[2] == ''){
                            html += '<a href="javascript:" onclick="return initguide(\''+id+'\',\''+j+'\')"><span class=ah>'+sub[0]+'</span></a>';
                        } else {
                            if(sub[2] == 'm'){
                                html += '<a href="javascript:" onclick="return initguide2(\''+id+'\',\''+j+'\')"><span class=ah>'+sub[0]+'</span></a>';
                            } else {
                                html += '<a href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
                            }
                        }

                    }
                    html += '</dd>';
                }
                obj.innerHTML = html + '</dl>';

                var obj1  = document.getElementById(id);
                var left  = findPosX(obj1) + ietruebody().scrollLeft;
                var top   = findPosY(obj1) + ietruebody().scrollTop + 24;

                obj.style.display = "";
                obj.style.top   = top + 'px';
                obj.style.left  = left + 'px';

                addEvent(document,"mouseout",doc_mouseout);
            }
            function closeguide(){
                var obj = document.getElementById('showmenu');
                obj.style.display = "none";
                uptopguide(cate);
                removeEvent(document,"mouseout",doc_mouseout);
            }
            function upleft(t){
                var obj  = document.getElementById('left');
                var objs = obj.getElementsByTagName('a');
                for(var i=0;i<objs.length;i++){
                    objs[i].className = objs[i].id==t ? 'a1' : '';
                }
            }
            function showleft(id,t,url){
                cate = id;
                var obj = document.getElementById('left');
                var html = '<dl>';
                var guide = guides[id];
                url = typeof url != 'undefined' ? url : '';
                type = typeof t != 'undefined' ? t : '';
                for(i in guide){
                    var subs = guide[i];
                    html += '<dt>' + titles[i] + '</dt><dd>';
                    for(j in subs){
                        var sub = subs[j];

                        if(sub[2] == ''){
                            html += '<a id="'+j+'" href="javascript:" onclick="return initguide(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';
                        } else {
                            if(sub[2] == 'm'){
                                html += '<a id="'+j+'" href="javascript:" onclick="return initguide2(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';

                            } else {
                                html += '<a id="'+j+'" href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
                            }
                        }
                        if(url == ''){
                            if(type == ''){
                                url = sub[1];
                                type = j;
                            } else if(j == type){
                                url = sub[1];
                            }
                            action = i;
                        }
                    }
                    html += '</dd>';
                }
                obj.innerHTML = html + '</dl>';
                uptopguide(cate);
                upleft(type);
                parent.main.location = url;
                return false;
            }
            function showleft2(id,t,url){
                cate = id;
                var obj = document.getElementById('left');
                //var html = '<dl>';
                var guide = guides[id];
                url = typeof url != 'undefined' ? url : '';
                type = typeof t != 'undefined' ? t : '';
                for(i in guide){
                    var subs = guide[i];
                    //html += '<dt>' + titles[i] + '</dt><dd>';
                    for(j in subs){
                        var sub = subs[j];
                        //html += '<a id="'+j+'" href="javascript:" onclick="return initguide(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';
                        if(url == ''){
                            if(type == ''){
                                url = sub[1];
                                type = j;
                            } else if(j == type){
                                url = sub[1];
                            }
                            action = i;
                        }
                    }
                    //html += '</dd>';
                }
                //html += '<dt>'+type+'</dt><dd>';

                //html += '<iframe name="player" src="'+type+'_tree.htm" frameborder="0"  style="height:96%;width:132;z-index:1"></iframe>';
                //html += '</dd></dl>';
                obj.innerHTML = '<iframe name="tree" src="'+type+'_tree.htm" frameborder="0"  style="height:99.9%;width:134;z-index:1"></iframe>';
                uptopguide(cate);
                upleft(type);
                parent.main.location = url;
                return false;
            }
            function showtitle(){
                var obj = document.getElementById('guide');
                var guide = guides[cate];
                var username = '<?php echo $_smarty_tpl->getVariable('username')->value;?>
';
                var html = '';
                if(action && type){
                    html += '<h1><span class="fr1">' + titles[action] + ' &raquo; ' + guide[action][type][0] + '</span></h1>';
                } else {
                    html += '&nbsp;&nbsp;<a class="s0" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'passport','a'=>'logout'),$_smarty_tpl);?>
">退出</a></span>';
                }
                obj.innerHTML = html;
            }
            function initguide(id,t,url){
                showleft(id,t,url);
                showtitle();
                return false;
            }
            function initguide2(id,t,url){
                showleft2(id,t,url);
                showtitle();
                return false;
            }
            function showmenu(){
                var obj = document.getElementById('menu');
                //top.main.showselect('hidden');
                if(!IsElement('menubg')){
                    var html = '<div id="menu2" class="inner">';
                    for(i in guides){
                        if(i=='common') continue;
                        var guide = guides[i];
                        html += "<dl>";
                        for(j in guide){
                            html += "<dt><h3>" + titles[j] + "</h3></dt><dd>";
                            var subs = guide[j];
                            for(k in subs){
                                var sub = subs[k];
                                if(sub[2] == ''){
                                    html += '<a href="javascript:" onclick="return toguide(\''+i+'\',\''+k+'\')">'+sub[0]+'</a>';
                                } else {
                                    if(sub[2] == 'm'){
                                        html += '<a href="javascript:" onclick="return toguide2(\''+i+'\',\''+k+'\')">'+sub[0]+'</a>';
                                    } else {
                                        html += '<a href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
                                    }
                                }
                            }
                            html += "</dd>";
                        }
                        html += '</dl>';
                    }
                    html += '<div><a class="fr" style="color:#ff8800; position:absolute;right:1%;top:1%; cursor:pointer;" onclick="closemenu();">关闭</a></div></div>';
                    obj.innerHTML = html;
                    var obj2 = document.createElement("div");
                    obj2.id = "menubg";
                    obj.parentNode.insertBefore(obj2,obj);
                } else {
                    var obj2 = document.getElementById('menubg');
                    obj2.style.display = "";
                }
                obj.style.display = "";
                addEvent(document,"mousedown",doc_mousedown);
            }
            function closemenu(){
                var obj = document.getElementById('menu');
                obj.style.display = "none";
                var obj2 = document.getElementById('menubg');
                obj2.style.display = "none";
                removeEvent(document,"mousedown",doc_mousedown);
                //top.main.showselect('');
            }
            function toguide(id,t){
                closemenu();
                initguide(id,t);
                return false;
            }
            function toguide2(id,t){
                closemenu();
                initguide2(id,t);
                return false;
            }
            function doc_mousedown(e){
                var e = is_ie ? event: e;
                obj = document.getElementById("menu");
                _x  = is_ie ? e.x : e.pageX;
                _y  = is_ie ? e.y + ietruebody().scrollTop : e.pageY;
                _x1 = obj.offsetLeft;
                _x2 = obj.offsetLeft + obj.offsetWidth;
                _y1 = obj.offsetTop - 20;
                _y2 = obj.offsetTop + obj.offsetHeight;

                if(_x<_x1 || _x>_x2 || _y<_y1 || _y>_y2){
                    closemenu();
                }
            }
            function doc_mouseout(e){
                var e = is_ie ? event: e;
                obj = document.getElementById("showmenu");
                _x  = is_ie ? e.x : e.pageX;
                _y  = is_ie ? e.y + ietruebody().scrollTop : e.pageY;
                _x1 = obj.offsetLeft + 2;
                _x2 = obj.offsetLeft + obj.offsetWidth;
                _y1 = obj.offsetTop - 20;
                _y2 = obj.offsetTop + obj.offsetHeight;

                if(_x<_x1 || _x>_x2 || _y<_y1 || _y>_y2){
                    closeguide();
                }
            }
            function IsElement(id){
                return document.getElementById(id)!=null ? true : false;
            }
            function addEvent(el,evname,func){
                if(is_ie){
                    el.attachEvent("on" + evname,func);
                } else{
                    el.addEventListener(evname,func,true);
                }
            };
            function removeEvent(el,evname,func){
                if(is_ie){
                    el.detachEvent("on" + evname,func);
                } else{
                    el.removeEventListener(evname,func,true);
                }
            };
            function findPosX(obj){
                var curleft = 0;
                if (obj.offsetParent){
                    while (obj.offsetParent){
                        curleft += obj.offsetLeft
                        obj = obj.offsetParent;
                    }
                }
                else if (obj.x)
                    curleft += obj.x;
                return curleft - ietruebody().scrollLeft;
            }
            function findPosY(obj){
                var curtop = 0;
                if (obj.offsetParent){
                    while (obj.offsetParent){
                        curtop += obj.offsetTop
                        obj = obj.offsetParent;
                    }
                } else if (obj.y){
                    curtop += obj.y;
                }
                return curtop - ietruebody().scrollTop;;
            }
            function ietruebody(){
                return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
            }
            initguide(cate,type,'<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('app'=>'desktop','c'=>'ctl_customer','a'=>'index'),$_smarty_tpl);?>
');
</script>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['script'][0][0]->smarty_script(array('src'=>"js/DeployInit.js"),$_smarty_tpl);?>

</body>
</html>
