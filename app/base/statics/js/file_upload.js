var UA = {
    IE: ! - [1, ]/*,
    IE6: UA.IE && !('maxHeight' in doc.body.style),
    IE8: UA.IE && 'prototype' in Image,
    IE7: UA.IE && !UA.IE6 && !UA.IE8*/
};
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

//文件上传类
var FileUpload = Class.create();
FileUpload.prototype = {
    //表单对象，文件控件存放空间
    initialize: function(form, folder, options) {

        this.Form = document.getElementById(form); //表单
        this.Folder = document.getElementById(folder); //文件控件存放空间
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
            FileName: "photo[]", //文件上传控件的name，配合后台使用
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
    if (msg)
    {
        alert(msg);
    }
    if (url)
    {
        location.href = url || location.href;
    }   
}
