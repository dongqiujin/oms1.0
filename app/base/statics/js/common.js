var Class = {
	create: function() {
		return function() {
			this.initialize.apply(this, arguments);
		};
	}
};
var Extend = function(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
};
var Bind = function(object, fun) {
	return function() {
		return fun.apply(object, arguments);
	};
};
var Each = function(list, fun) {
	for (var i = 0, len = list.length; i < len; i++) {
		fun(list[i], i);
	}
};
var addEvent = function(el, e, fn) {
	if (window.addEventListener) {
		el.addEventListener(e, fn, false);
	} else if (window.attachEvent) {
		el.attachEvent('on'+ e, fn);
	}
}
//文件上传类
var FileUpload = Class.create();
FileUpload.prototype = {
	//表单对象，文件控件存放空间
	initialize: function(form, folder, options) {

		this.Form = $(form); //表单
		this.Folder = $(folder); //文件控件存放空间
		this.Files = []; //文件集合
		this.SetOptions(options);

		this.FileName = this.options.FileName;
		this._FrameName = this.options.FrameName;
		this.Limit = this.options.Limit;
		this.Distinct = !! this.options.Distinct;
		this.ExtIn = this.options.ExtIn;
		this.ExtOut = this.options.ExtOut;

		this.onInitFile = this.options.onInitFile;
		this.onEmpty = this.options.onEmpty;
		this.onNotExtIn = this.options.onNotExtIn;
		this.onExtOut = this.options.onExtOut;
		this.onLimite = this.options.onLimite;
		this.onSame = this.options.onSame;
		this.onFail = this.options.onFail;
		this.onInit = this.options.onInit;

		if (!this._FrameName) {
			//为每个实例创建不同的iframe
			this._FrameName = "uploadFrame_" + Math.floor(Math.random() * 1000);
			//ie不能修改iframe的name
			var oFrame = UA.IE ? document.createElement("<iframe name=\"" + this._FrameName + "\">") : document.createElement("iframe");
			//为ff设置name
			oFrame.name = this._FrameName;
			oFrame.style.display = "none";
			//在ie文档未加载完用appendChild会报错
			document.body.insertBefore(oFrame, document.body.childNodes[0]);
		}

		//设置form属性，关键是target要指向iframe
		this.Form.target = this._FrameName;
		this.Form.method = "post";
		//注意ie的form没有enctype属性，要用encoding
		this.Form.encoding = "multipart/form-data";

		//整理一次
		this.Init();
	},
	//设置默认属性
	SetOptions: function(options) {
		this.options = { //默认值
			FileName: "sitecheck[]", //文件上传控件的name，配合后台使用
			Limit: 10, //文件数限制，0为不限制
			ExtIn: ["gif", "jpg", "png"], //允许后缀名
			Distinct: true, //是否不允许相同文件
			FrameName: "", //iframe的name，要自定义iframe的话这里设置name
			onInitFile: function(file) {file.value ? file.style.display = "none" : this.Folder.removeChild(file);}, //整理文件时执行(其中参数是file对象)
			onEmpty: function() {alert("请选择一个文件");}, //文件空值时执行
			onLimite: function() {alert("超过上传限制");}, //超过文件数限制时执行
			onSame: function() {alert("已经有相同文件");}, //有相同文件时执行
			onNotExtIn: function() {alert("只允许上传" + this.ExtIn.join("，") + "文件");}, //不是允许后缀名时执行
			ExtOut: [], //禁止后缀名，当设置了ExtIn则ExtOut无效
			onExtOut: function() {}, //是禁止后缀名时执行
			onFail: function(file) {this.Folder.removeChild(file);}, //文件不通过检测时执行(其中参数是file对象)
			onInit: function() {} //重置时执行
		};
		Extend(this.options, options || {});
	},
	//整理空间
	Init: function() {
		//整理文件集合
		this.Files = [];
		//整理文件空间，把有值的file放入文件集合
		Each(this.Folder.getElementsByTagName("input"), Bind(this, function(o) {
			if (o.type == "file") {
				o.value && this.Files.push(o);
				this.onInitFile(o);
			}
		}));
		//插入一个新的file
		var file = document.createElement("input");
		file.name = this.FileName;
		file.type = "file";
		file.onchange = Bind(this, function() {
			this.Check(file);
			this.Init();
		});
		this.Folder.appendChild(file);
		//执行附加程序
		this.onInit();
	},
	//检测file对象
	Check: function(file) {
		//检测变量
		var bCheck = true;
		//空值、文件数限制、后缀名、相同文件检测
		if (!file.value) {
			bCheck = false;
			this.onEmpty();
		} else if (this.Limit && this.Files.length >= this.Limit) {
			bCheck = false;
			this.onLimite();
		} else if ( !! this.ExtIn.length && ! RegExp("\.(" + this.ExtIn.join("|") + ")$", "i").test(file.value)) {
			//检测是否允许后缀名
			bCheck = false;
			this.onNotExtIn();
		} else if ( !! this.ExtOut.length && RegExp("\.(" + this.ExtOut.join("|") + ")$", "i").test(file.value)) {
			//检测是否禁止后缀名
			bCheck = false;
			this.onExtOut();
		} else if ( !! this.Distinct) {
			Each(this.Files, function(o) {
				if (o.value == file.value) {
					bCheck = false;
				}
			});
			if (!bCheck) {
				this.onSame();
			}
		}
		//没有通过检测
		! bCheck && this.onFail(file);
	},
	//删除指定file
	Delete: function(file) {
		//移除指定file
		if (!file) return;
		this.Folder.removeChild(file);
		this.Init();
	},
	//删除全部file
	Clear: function() {
		//清空文件空间
		Each(this.Files, Bind(this, function(o) {
			this.Folder.removeChild(o);
		}));
		this.Init();
	}
};
//在后台通过window.parent来访问主页面的函数
function Finish(msg,url) {
	alert(msg);
	location.href = url || location.href;
}

function initTree(t) {
	var tree = $(t);
	if (!tree) return;
	tree.style.display = "none";
	var lis = tree.getElementsByTagName("li");
	for (var i = 0; i < lis.length; i++) {
		lis[i].id = "li" + i;
		var uls = lis[i].getElementsByTagName("ul");
		if (uls.length !== 0) {
			uls[0].id = "ul" + i;
			uls[0].style.display = "none";
			var as = lis[i].getElementsByTagName("a");
			as[0].id = "a" + i;
			as[0].className = "folder";
			as[0].href = "#this";
			as[0].tget = uls[0];
			as[0].onclick = function() {
				openTag(this, this.tget);
			};
		}
	}
	tree.style.display = "block";
}
function openTag(a, t) {
	if (t.style.display == "block") {
		t.style.display = "none";
		a.className = "folder";
	} else {
		t.style.display = "block";
		a.className = "";
	}
}

function formatHTML(id) {
	var html = $(id).value;
	html = html.replace(/&/g, '&amp;');
	html = html.replace(/</g, '&lt;');
	html = html.replace(/>/g, '&gt;');
	html = html.replace(/"/g, '&quot;');
	html = html.replace(/ /g, '&nbsp;');
	html = html.replace(/\r\n|\n|\r/g, "<br />$&");
	$(id).value = html;
}
function escapeHTML(id) {
	var html = $(id).value;
	html = html.replace(/<br[^>]*>(\r\n|\n|\r)?/ig, "$1");
	html = html.replace()
	$(id).value = html;
}
function getParent(id,tag){
	var p = $(id);
	var reg = new RegExp("^(?:"+tag+")$", 'i');
	while(!(/^(?:body|html)$/i).test(p.tagName)) {
		if(reg.test(p.tagName)) return p;
		p = p.parentNode;
	}
}
function simple_editor(id) {
	escapeHTML(id);
	if(getParent(id, 'form')) addEvent(getParent(id, 'form'), 'submit', function(){
		formatHTML(id);
	});
}

function full_editor(id) {
    KE.show({
	id: id,
	//cssPath : <{style href="css/editor.css" app="base"}>,
	afterCreate : function(id) {
			KE.event.ctrl(document, 13, function() {
				KE.sync(id);
				document.forms['example'].submit();
			});
			KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
				KE.sync(id);
				document.forms['example'].submit();
			});
		}
	});
}