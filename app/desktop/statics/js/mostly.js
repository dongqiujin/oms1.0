var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");

var guides={
	'gj' : {
		'gj_' : {
			'gj_1' : ['企业邮局','qyyj.htm',''],          //没做
			'gj_2' : ['日程管理','kq_rclxlb.htm',''],
			'gj_3' : ['网络硬盘','wlyp.htm',''],          //没做
			'gj_4' : ['快捷便签','kjbq.htm',''],          //没做
			'gj_5' : ['名片管理','mpgl.htm',''],          //没做
			'gj_6' : ['常用查询','cycx.htm',''],          //没做
			'gj_7' : ['个人信息','grxx.htm','']}},
	'bg' : {
		'bg_1' : {
			'bg_1_1' : ['发起传阅','gwcy.htm',''],
			'bg_1_2' : ['已发文件','gwcyf.htm',''],
			'bg_1_3' : ['收到文件','gwcys.htm',''],
			'bg_1_4' : ['模块设置','mksz_1.htm','']},
		 'bg_2' : {
			'bg_2_1' : ['创建审批','gwsp.htm',''],
			'bg_2_2' : ['已发审批','gwspf.htm',''],
			'bg_2_3' : ['收到审批','gwsps.htm',''],
			'bg_2_4' : ['模块设置','gwlx.htm','']},
         'bg_3' : {
			'bg_3_1' : ['流程模型列表','gw_lcmx.htm',''],
			'bg_3_2' : ['创建流程申请','gw_cjlc.htm',''],
			'bg_3_3' : ['收发流程申请','gw_sflc.htm','']}},		
	'rs' : {
		'rs_' : {
			'rs_1' : ['人事档案','yhss.htm',''],         
			'rs_2' : ['学历统计','xltj.htm',''],
			'rs_3' : ['个人信息','grxx.htm',''],         
			'rs_4' : ['模块设置','zwgl.htm','']}}, 
		
	'da' : {
		'da_' : {
			'glmk_1_1' : ['档案管理','glmk_1_1_list.htm','m']}},		
	'jx' : {
		'jx_' : {
			'jx_1_1' : ['网络学校','wlxx.htm','']}},			
	'dx' : {
		'dx_' : {
			'dx_1' : ['新建短信','dx_add.htm',''],
			'bg_2' : ['已发短信','dx_li1.htm',''],
			'bg_3' : ['短信模板','dx_li2.htm',''],
			'bg_4' : ['历史记录','dx_li3.htm','']}},	 //合并	dx_li3.htm dx_li4.htm	
   'system' : {
		'system_1' : {
			'system_1_1' : ['新增会员','#',''],
			'system_1_2' : ['会员管理','#',''],
			'system_1_3' : ['到期会员','#',''],
			'system_1_4' : ['操作日志','#','']
			},
	    'system_2' : {
			'system_2_1' : ['机构管理','jggl.htm',''],
			'system_2_2' : ['模块管理','mkgl.htm',''],
			'system_2_3' : ['用户管理','yhgl.htm',''],
			'system_2_4' : ['操作日志','rz.htm',''],
			'system_2_5' : ['内容模块','#',''],
			'system_2_6' : ['页面版式','#',''],
			'system_2_7' : ['背景图片','#',''],
			'system_2_8' : ['样式风格','#',''],
			'system_2_9' : ['保存设置','#','']}},
			
	'common' : {
		'diy' : {
			'diy_1' : ['企业邮局','qyyj.htm',''],
			'diy_2' : ['日程管理','kq_rclxlb.htm',''],
			'diy_3' : ['网络硬盘','wlyp.htm',''],
			'diy_4' : ['快捷便签','kjbq.htm',''],
			'diy_5' : ['名片管理','mpgl.htm',''],
			'diy_6' : ['常用查询','cycx.htm',''],
			'diy_7' : ['个人信息','grxx.htm','']}}
}
var titles={
	'gj_' : '日常工具',	
//	'bg_' : '办公管理',
	'bg_1' : '文件流转',
	'bg_2' : '公文审批',
	'bg_3' : '工作流程',
	'rs_' : '人事管理',	
	'da_' : '档案管理',
	'jx_' : '网络学校',	
	'dx_' : '短信平台',	
	'diy' : '常用选项',
	'system_1' : '会员信息管理',
	'system_2' : '系统管理'
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
	obj.style.top	= top + 'px';
	obj.style.left	= left + 'px';
	
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
	var html = '<span class="fr s1" style="margin:0 16px">用户: admin　级别: manager　|　<a class="s0"  href="javascript:" onclick="return skin(\'?adskin=2\');">默认风格</a>  <a class="s0" href="vbscript:parent.main.location.reload" >刷新</a> <a class="s0" href="vbscript:history.back" >上一步</a> <a class="s0" href="vbscript:history.forward">下一步</a> <a class="s0" href="vbscript:exitsystem()">退出</a></span>';
	if(action && type){
		html += '<h1><span class="fr1">' + titles[action] + ' &raquo; ' + guide[action][type][0] + '</span></h1>';
	} else {
		html += '<h1><span class="fr1">开始页</span></h1>';
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
	obj	= document.getElementById("menu");
	_x	= is_ie ? e.x : e.pageX;
	_y	= is_ie ? e.y + ietruebody().scrollTop : e.pageY;
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
	obj	= document.getElementById("showmenu");
	_x	= is_ie ? e.x : e.pageX;
	_y	= is_ie ? e.y + ietruebody().scrollTop : e.pageY;
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
initguide(cate,type,'main.htm');