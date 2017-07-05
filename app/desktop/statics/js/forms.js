function focusText(el, msg) {
    if (!el) return;
    el = el.length ? el: $(el);
    var txt;
    el.addEvents({
        'focus': function(e) {
            txt = msg || this.get('placeholder');
            if (!txt) return;
            try{
                this.getNext('span.success,span.error').destroy();
            }catch(e){}
            new Element('span.info', {
                html: txt
            }).inject(this, 'after');
        },
        'blur': function(e) {
            var tip;
            if ((tip = this.getNext('span.info'))) {
                txt = null;
                tip.destroy();
            }
        }
    });
}
//正则及表单验证函数段
var pattern = {
    required: /^.+$/,
    text: /^[\w-]+$/,
    numeric: /^\d*$/,
    cnChar: /^[\u4e00-\u9fff]*$/,
    cnName: /^[\u4e00-\u9fff]{2,}$/,
    password: /^\S{6,}$/,
    tel: /^(\(0\d{2,3}\)|0\d{2,3}-)?[2-9]\d{5,7}(\(\d{2,5}\)|-\d{2,5})?$|^(1(3|5|8)\d{9})?$/,
    mobile: /^(1(3|5|8)\d{9})?$/,
    email: /^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@(([0-9a-zA-Z])+([-\w]*[0-9a-zA-Z])*\.)+[a-zA-Z]{2,4})?$/,
    zip: /^\d{6}$/,
    url: /(http|https|ftp|rtsp|mms):(\/\/|\\\\)((\w|-)+[.])+[a-zA-Z]{2,4}(((\/[\~]*|\\[\~]*)(\w|-)*)|[.](\w)+)*(((([?](\w|-)+){1}[=]*))*((\w|-)+)((&|&amp;)(\w|-)+[\=](\w|-)+)*)*/ig,
    date: /^[12]\d{3}([\/-])(?:(?:(?:0?[1-9]|1[012])\1(?:0?[1-9]|[1-2]\d))|(?:(?:0?[469]|11)\1(?:30))|(?:(?:0?[13578]|1[02])\1(?:3[01])))$/,
    equal: function(v) {
        var flag = false;
        if (v.length>1) for (var i = 0, j = v.length - 1; i < j; i++) {
            if(v[i+1]!==v[0]) return false;
            flag = true;
        }
        return flag;
    },
    is: function(reg, text) {
        return this[reg].test(text);
    },
    say: function(reg, text) {
        alert(this[reg].test(text));
    }
};
function isEmpty(text) {
    return ! pattern.is("required", text);
}
function checkReg(reg, text) {
    return typeof(reg) == "string" ? pattern.is(reg, text) : reg.test(text);
}
//检测radio
function checkChecked(name) {
    var count = 0;
    for (var i = 0; i < name.length; i++) {
        if (name[i].checked == true) {
            count = 1;
            break;
        }
    }
    if (count == 0) return false;
}
function validator(form){
    if(!form) return;
    var verifiable = form.getElements('input,select,textarea').filter(function(el){
        return el.hasProperty('required') || el.get('pattern') || el.get('vtype') || el.get('equal');
    });
    return verifiable.every(function(el){
        var msg ='';
        try{msg = el.getParent().getElement('label').get('text');}catch(e){}
        if(el.hasProperty('required')){
            if(isEmpty(getValue(el))){
                return showError(el,msg + '本项必填');
            }
        }
        if(el.get('vtype')){
            var vtype=el.get('vtype').split('&&');
            return vtype.every(function(v){
                if(!pattern[v]) return true;
                if(!pattern[v].test(getValue(el))) return showError(el,msg + '格式不正确');
                return showSuccess(el);
            });
        }
        if(el.get('equal')) {
            var eq = form.getElements('[name="' + el.get('equal') + '"]').include(el);
            var v=[];
            eq.each(function(el){
                v.push(getValue(el));
            });
            if(!pattern.equal(v)) return showError(el, msg + '输入值不相等');
        }
        if(el.get('pattern')){
            if(!checkReg(new RegExp(el.get('pattern')),getValue(el))){
                return showError(el,msg += '格式不正确');
            }
        }
        return showSuccess(el);
    });
}
function showError(el,msg){
    el=$(el);
    el.focus();
    try{
        el.getNext('span.info,span.success').destroy();
    }catch(e){}
    var tag = el.getNext('span.error') || new Element('span.error').inject(el,'after');
    msg && tag.set('html',msg);
    return false;
}
function showSuccess(el,msg){
    el=$(el);
    try{
        el.getNext('span.error').destroy();
    }catch(e){}
    var tag = el.getNext('span.success') || new Element('span.success').inject(el,'after');
    msg && tag.set('html',msg);
    return true;
}
//取得元素值
function getValue(el, form) {
    if (typeOf(el) === 'element') {
        return $(el).get('value');
    }
    form = typeOf(form) === 'element' || (typeof(form) == 'string' && form.indexOf('#') == 0) ? $(form) : form ? document.getElement('[name="' + form + '"]') : '';
    el = (form ? form: document).getElements('[name="' + el + '"]');
    return el.match("[checked]").get('value');
}

