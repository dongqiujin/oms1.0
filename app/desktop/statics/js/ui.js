/*
 * 弹框组件
 * @param target 弹出框内容元素
 * @param type 弹框类型:popup,nohead,notitle,noclose,nofoot
 * @param template 页面中模板位置ID
 * @param width 弹出框宽度 0 或'auto'为不限制
 * @param height 弹出框高度 0 或'auto'为不限制
 * @param title 弹出框标题
 * @param autoHide 是否一定时间自动关闭 false或具体数值(秒)
 * @param onLoad 载入时触发事件
 * @param onShow 显示时触发事件
 * @param onClose 关闭时触发事件
 * @param modal 是否在弹出时候其他区域不可操作
 * @param pins 是否把弹窗固定不动
 * @param single 单一窗口，还是多层窗口
 * @param effect 是否使用特效 false true or {style from to}
 * @param position 定位到哪里
 *      target 相对定位的目标
 *      to 相对定位基点x,y(九点定位:0/left/right/100%/center/50%,0/top/bottom/100%/center/50%)
 *      base 弹框的定位基点x,y(同上)
 *      offset 偏移目标位置
 *          x 横向偏移
 *          y 纵向偏移
 *      intoView 如果超出可视范围，是否滚动使之可见
 * @param useIframeShim 是否使用iframe遮盖
 * @param async 异步调用方式: false, frame, ajax
 * @param frameTpl iframe方式调用的模板
 * @param ajaxTpl ajax方式调用的模板
 * @param asyncOptions 异步请求的参数
 *      target 请求的缓存目标
 *      method 请求的方式
 *      data ajax/iframe方式请求的数据
 *      onRequest 请求时执行
 *      onSuccess 请求成功后执行
 *      onFailure 请求失败后执行
 *      etc. 还有更多Request里其它参数
 * @param component 弹出框的构成组件
 * @method getTemplate 获取模板
 * @method setTemplate 处理设置模板
 * @method maxSize 使窗口最大化
 * @method toElement 返回this.popUp窗体
 * @return this Popup instance
 */
var Popup = new Class({
    Implements: [Events, Options],
    options: {
        type: 'popup',
        template: null,
        width: 0,
        height: 0,
        title: '提示：',
        autoHide: false,
        /* onLoad: function(){},
         * onShow: function(){},
         * onClose: function(){},*/
        modal: false,
        pins: false,
        single: false,
        minHeight:220,
        minWidth:250,
        effect: {
            style: 'opacity',
            duration: 400,
            from: 0,
            to: 1,
            maskto: 0.3
        },
        position: {
            target: document.body,
            base: {x: 'center', y: 'center'},
            to: {x: 'center', y: 'center'},
            offset: {x: 0, y: 0},
            intoView: false
        },
        useIframeShim: false,
        async: false,
        frameTpl: '<iframe allowtransparency="allowtransparency" align="middle" frameborder="0" height="100%" width="100%" scrolling="auto" src="about:blank">请使用支持iframe框架的浏览器。</iframe>',
        ajaxTpl: '<div class="loading">loading...</div>',
        asyncOptions: {
            method: 'get'
            /*target: null,
            data: '',
            onRequest: function() {},
            onSuccess: function() {},
            onFailure: function() {}*/
        },
        component: {
            container: 'popup-container',
            body: 'popup-body',
            header: 'popup-header',
            close: 'popup-btn-close',
            content: 'popup-content',
            mask: 'popup-modalMask'
        }
    },
    initialize: function(target, options) {
        if (!target) return;
        this.target = target;
        this.setOptions(options);

        options = this.options;
        var asyncOptions = options.asyncOptions || {};
        var popUp = this.popUp = this.setTemplate(options.template);
        var el = new Element('div');
        this.body = popUp.getElement('.' + options.component.body) || el;
        this.header = popUp.getElement('.' + options.component.header) || el;
        this.title = this.header.getElement('h2') || el;
        this.close = popUp.getElement('.' + options.component.close) || el;
        this.content = popUp.getElement('.' + options.component.content) || el;
        this.size = {
            x: options.width && options.width.toInt() ? options.width.toInt() : '',
            y: options.height && options.height.toInt() ? options.height.toInt() : ''
        };
        options.title || (this.header.getElement('h2') && this.header.getElement('h2').destroy());
        popUp.retrieve('instance') || this.body.setStyles({
            width: this.size.x,
            height: this.size.y
        });
        this.fireEvent('load', this);
        if (typeOf(target) === 'string') {
            if (options.async === 'ajax') {
                this.RequestCache(Object.merge({
                    url: target + '',
                    update: this.content
                }, asyncOptions));
                if(!this.size.y && popUp.getSize().y >= $(document.body).getSize().y){
                    this.size.y = Math.min(options.minHeight.toInt(), $(document.body).getSize().y);
                    $(this.body).setStyle('height', this.size.y - this.popUp.getPatch().y);
                }
            }
            else {
                var url = asyncOptions.data ? target + (target.indexOf('?') > 1 ? '&' : '?') + asyncOptions.data : target + '';
                this.content.getElement('iframe').set('src', url).addEvent('load', (asyncOptions.onSuccess || function(){}).bind(this));
            }
        }
        if (options.modal) {
            var eff = !!options.effect ? {
                style: options.effect.style,
                duration: options.effect.duration,
                from: options.effect.from,
                to: options.effect.maskto
            } : false;
            this.mask = new Mask({
                'class': options.component.mask,
                'effect': eff
            });
        }
        this.hidden = true;
        this.attach(); //执行初始化加载
    },
    getTemplate: function(template, type) {
        var options = this.options;
        template = template || options.template;
        if (template && typeOf(template) === 'string') {
            if(!document.id(template)) return template;
            template = $(template);
        }
        if (typeOf(template) === 'element' && (/^(?:script|textarea)$/i).test(template.tagName)) return $(template).get('value') || $(template).get('html');
        type = type || options.type;
        var popUpTpl = [
            '<div class="{body}">',
            '<div class="{header}">',
            '<h2>{title}</h2>',
            '<span><button type="button" class="{close}" title="关闭" hidefocus><i>×</i></button></span>',
            '</div>',
            '<div class="{content}">{main}</div>',
            '</div>'
        ];
        if (type === 'nohead') popUpTpl[1] = popUpTpl[2] = popUpTpl[3] = popUpTpl[4] = '';
        else if (type === 'notitle') popUpTpl[2] = '';
        else if (type === 'noclose' || !!options.autoHide) popUpTpl[3] = '';

        return popUpTpl.join('\n');
    },
    setTemplate: function(template) {
        var options = this.options,
            single = document.getElement('[data-single=true].' + options.component.container);
            main = '';

        if(options.single && single) return single;

        template = '<div class="{container}" data-single="'+ !!options.single +'">' + this.getTemplate(template) + '</div>';
        if (typeOf(this.target) === 'element') {
            main = this.target.get('html');
        }
        else if (typeOf(this.target) === 'string') {
            main = options.async === 'ajax' ? options.ajaxTpl : options.frameTpl;
        }

        var component = Object.merge(options.component, {
            title: options.title,
            main: main
        });
        return new Element('div', {html: template.substitute(component)}).getFirst().inject(document.body);
    },
    attach: function() {
        this.show();
        //如果没有存储实例，就绑定关闭事件
        if (this.popUp.retrieve('instance')) {
            this.popUp.retrieve('instance').hidden = false;
            return;
        }
        this.popUp.addEvent('click', function(e){
            if($(e.target).hasClass(this.options.component.close)) this.hide();
        }.bind(this));
        // var closeBtn = this.popUp.getElements('.' + this.options.component.close);
        // closeBtn.length && closeBtn.addEvent('click', this.hide.bind(this));
        this.popUp.store('instance', this);
    },
    position: function(){
        var options = this.options, element;
        // if (options.single && this.popUp.retrieve('instance')) return;
        if (!this.size.x && Browser.ie && Browser.version < 8 && (this.body.getSize().x >= window.getSize().x)) this.body.setStyle('width', this.options.minWidth.toInt());
        if (this.size.y) element = this.popUp;
        else if(this.popUp.getSize().y >= document.body.getSize().y) element = document.body;
        if(typeOf(element) === 'element') this.setHeight(element);
        this.popUp.position(options.position);
        options.pins && this.popUp.pin();
    },
    setTitle: function(html) {
        this.title.set('html', html);
    },
    setHeight: function(el) {
        this.content.setStyle('height', el.getSize().y - this.popUp.getPatch().y - $(this.body).getPatch().y - $(this.header).outerSize().y - this.content.getPatch().y);
    },
    show: function() {
        if(!this.hidden) return this;
        this.popUp.setStyle('display', 'block');

        if(Browser.ie6 && this.options.useIframeShim) {
            new Element('iframe', {
                src: 'about:blank',
                style: 'position:absolute;z-index:-1;border:0 none;filter:alpha(opacity=0);top:-' + (this.popUp.getPatch().y || 0) + ';left:-' + (this.popUp.getPatch().x || 0) + ';width:' + (this.popUp.getSize().x || 0) + 'px;height:' + (this.popUp.getSize().y || 0) + 'px;'
            }).inject(this.popUp);
        }

        this.position();
        var eff = this.options.effect;
        if(eff) {
            if(eff === true || eff.style === 'opacity') this.popUp.setOpacity(eff.from || 0);
            new Fx.Tween(this.popUp,{duration: eff.duration || 400}).start(eff.style || 'opacity', eff.from || 0, eff.to || 1);
        }
        this.hidden = false;
        this.fireEvent('show', this);

        this.mask && this.mask.show();
        this.options.autoHide && this.hide.delay(this.options.autoHide.toInt() * 1000, this);

        return this;
    },
    hide: function() {
        if (this.hidden) return this;
        this.fireEvent('close', this);
        this.options.pins && this.popUp.pin(false, false, false);
        if (this.options.single) {
            this.popUp.setStyle('display', 'none');
            this.hidden = true;
            this.mask && this.mask.hide();
            return this;
        }
        var eff = this.options.effect;
        if(eff) {
            new Fx.Tween(this.popUp, {
                duration: eff.duration || 400,
                onComplete: function(){
                    this.popUp.destroy();
                }.bind(this)
            }).start(eff.style || 'opacity', eff.to || 1, eff.from || 0);
        }
        else {
            this.popUp.destroy();
        }
        this.hidden = true;
        if (this.mask && ($$('.' + this.options.component.container).every(function(el) {
            return !!this.hidden;
        }.bind(this)))) this.mask.hide();
        return this;
    },
    RequestCache: function(options) {
        var cache;
        if(!options) return null;
        if(options.target) {
            cache = options.target.retrieve('request:cache');
            if(cache) return cache.success(cache.response.text);
        }
        cache = new Request.HTML(options).send();
        options.target && options.target.store('request:cache', cache);
        return cache;
    },
    toElement: function() {
        return this.popUp;
    }
});

// pin
Element.implement({
    pin: function(enable, forceScroll, restore){
        //if(this.getStyle('display') == 'none') this.setStyle('display', '');
        if (enable !== false){
            if (!this.retrieve('pin:_pinned')){
                var scroll = window.getScroll();
                this.store('pin:_original', this.getStyles('position', 'top', 'left'));
                var pinnedPosition = this.getPosition(!Browser.ie6 ? document.body : this.getOffsetParent());
                var currentPosition = {
                    left: pinnedPosition.x - scroll.x,
                    top: pinnedPosition.y - scroll.y
                };
                if (!Browser.ie6){
                    this.setStyle('position', 'fixed').setStyles(currentPosition);
                } else {
                    if(!!forceScroll) this.setPosition({
                        x: this.getOffsets().x + scroll.x,
                        y: this.getOffsets().y + scroll.y
                    });
                    if (this.getStyle('position') == 'static') this.setStyle('position', 'absolute');

                    var position = {
                        x: this.getLeft() - scroll.x,
                        y: this.getTop() - scroll.y
                    };
                    var scrollFixer = function(){
                        if (!this.retrieve('pin:_pinned') || this.getStyle('left').toInt() >= document.body.clientWidth || this.getStyle('top').toInt() >= document.body.clientHeight) return;
                        var scroll = window.getScroll();
                        this.setStyles({
                            left: position.x + scroll.x,
                            top: position.y + scroll.y
                        });
                    }.bind(this);

                    this.store('pin:_scrollFixer', scrollFixer);
                    window.addEvent('scroll', scrollFixer);
                }
                this.store('pin:_pinned', true);
            }
        } else {
            if (!this.retrieve('pin:_pinned')) return this;
            if(!!restore) this.setStyles(this.retrieve('pin:_original', {}));
            this.eliminate('pin:_original');
            this.store('pin:_pinned', false);
            if (Browser.ie6) {
                window.removeEvent('scroll', this.retrieve('pin:_scrollFixer'));
                this.eliminate('pin:_scrollFixer');
            }
        }
        return this;
    },
    togglePin: function(){
        return this.pin(!this.retrieve('pin:_pinned'));
    }
});

//Mask
var Mask = new Class({
    Implements: [Options, Events],
    options: {
        target:null,
        'class': 'mask',
        width: 0,
        height: 0,
        effect: {
            style: 'opacity',
            duration: 400,
            from: 0,
            to: 0.3
        }
    },
    initialize: function(options) {
        this.target = (options && options.target) || document.id(document.body);
        //this.target.store('mask', this);
        this.setOptions(options);

        this.element = $$('div[rel=mask].' + this.options['class'])[0] || new Element('div[rel=mask].' + this.options['class']).inject(this.target);
        this.hidden = true;
    },
    setSize: function() {
        this.element.setStyles({
            width: this.options.width.toInt() || Math.max(this.target.getScrollSize().x, this.target.getSize().x, this.target.clientWidth),
            height: this.options.height.toInt() || Math.max(this.target.getScrollSize().y, this.target.getSize().y, this.target.clientHeight)
        });
    },
    show: function() {
        if (!this.hidden) return;
        window.addEvent('resize', this.setSize.bind(this));
        this.setSize();

        this.element.setStyle('display','block');
        var eff = this.options.effect;
        if(eff) {
            // this.opacity = this.element.get('opacity');
            if(eff === true || eff.style == 'opacity') this.element.setOpacity(eff.from || 0);
            new Fx.Tween(this.element,{duration: eff.duration || 400}).start(eff.style || 'opacity', eff.from || 0, eff.to);
        }
        this.hidden = false;
    },
    hide: function() {
        if (this.hidden) return;
        window.removeEvent('resize', this.setSize.bind(this));

        var eff = this.options.effect;
        if(eff) {
            new Fx.Tween(this.element, {
                duration:eff.duration || 400,
                onComplete: function(){
                    this.element.setStyle('display','none');
                }.bind(this)
            }).start(eff.style || 'opacity', eff.to, eff.from || 0);
        }
        else {
            this.element.setStyle('display','none');
        }
        this.hidden = true;
    },
    toggle: function() {
        this[this.hidden ? 'show' : 'hide']();
    }
});

var Dialog = new Class({
    Extends: Popup,
    initialize: function(target,options){
        options = Object.merge({
            width:330,
            template: $('popup-template'),
            position: {
                intoView: true
            }
        }, options || {});
        this.parent(target,options);
    }
});
Dialog.alert = function(msg, title) {
    var html = '<div class="message-main"><div class="figure"><dfn class="alert">alert!</dfn><span class="mark">' + msg + '</span></div> <div class="bottom"> <button type="button" class="popup-btn-close"><i><i>确定</i></i></button> </div></div>';
    new Dialog(new Element('div', {html: html}), {
        width: 400,
        title: title || '请注意',
        modal: true,
        pins: true,
        single: false,
        effect: false,
        position: {
            intoView: true
        }
    });
};
Dialog.confirm = function(msg, callback) {
    var html = '<div class="message-main"><div class="figure"><dfn class="confirm">confirm!</dfn><span class="mark">' + msg + '</span></div> <div class="bottom"><button type="button" class="btn-confirm" data-return="1"><i><i>确认</i></i></button>　 <button type="button" class="btn-cancel" data-return="0"><i><i>取消</i></i></button></div></div>';
    new Dialog(new Element('div', {html: html}), {
        width: 400,
        title: '请确认',
        modal: true,
        pins: true,
        single: false,
        effect: false,
        position: {
            intoView: true
        },
        onLoad: function() {
            var _this = this, _return;
            this.content.getElements('[data-return]').addEvent('click', function(e){
                _return = !!this.get('data-return').toInt();
                _this.hide();
                callback && callback.call(this, _return);
            });
        }
    });
};

//Tips
var Ex_Tip = new Class({
    Extends: Popup,
    /*options: {
        intoView: true,
        onShow: function(){},
        onClose: function(){}
    },*/
    initialize: function(msg,options){
        if(!msg) return;
        options = options || {};
        var target = new Element('div[html=' + msg + ']');
        var relative = options.relative || document.body,
            rel = (/^(?:body|html)$/i).test(relative.tagName.toLowerCase()),
            x = rel ? 'center' : 0,
            y = rel ? 0 : 'top',
            pins = !!rel,
            offsetY = rel ? 0 : 'bottom';

        this.options = Object.merge(this.options, {
            type: options.type || 'nofoot',
            template: options.template || $('xtip-template'),
            modal: false,
            pins: pins,
            single: false,
            effect: true,
            position: {
                target: relative,
                to: {x: x, y: y},
                base: {x: 0, y: offsetY},
                offset: {
                    x: options.offset && options.offset.x ? options.offset.x : 0,
                    y: options.offset && options.offset.y ? options.offset.y : 0
                },
                intoView: options.intoView !== undefined ? options.intoView : true
            },
            component: {
                container: 'xtip-container',
                body: 'xtip-body',
                header: 'xtip-header',
                close: 'xtip-close',
                content: 'xtip-content'
            }
        });
        this.parent(target, options);
    }
});

/*
 * tooltips,需要在元素上添加自定义属性"data-tip"
 */
var Tips = function(elements, msg) {
    elements = $(elements) || $$('[data-tip]');
    if(!elements || !elements.length) return null;
    //build elements
    var container = $('xtips-container') || new Element('div', {
        html: '<div id="xtips-container" class="xtips-container"><i class="xtips-arr">◆</i><i class="xtips-arr2">◆</i><div id="xtips-content"></div></div>'
    }).getFirst().inject(document.body);
    var content = $('xtips-content');

    return elements.addEvents({
        mouseenter: function() {
            var text = msg || this.get('data-tip');
            if(!text) return;
            content.set('text', text); // set message
            //position it and set width?
            var position = this.getPosition(),
                size = container.getSize();
            container.setStyle('display', 'block').setStyles({
                left: Math.max(position.x - 4, 0),
                top: Math.max(position.y - container.getSize().y - 6, 0),
                width: this.get('data-tip-width') ? this.get('data-tip-width') : container.getSize().x > window.getSize().x ? window.getSize().x : '',
                opacity: 0
            }).tween('opacity', 0, Browser.ie6 ? 1 : 0.95);
        },
        mouseleave: function() {
            container.tween('opacity', Browser.ie6 ? 1 : 0.95, 0);
        }
    });
};
Element.implement({
    tips: function(msg){
        return Tips(this, msg);
    }
});
window.addEvent('domready', function(){
    Tips();
});

//Message box
function Message(msg, type, delay, callback, template){
    if(!msg) return null;
    if(typeOf(type) === 'number') {
        delay = type;
        type = 'show';
    }
    else if(typeOf(delay) === 'function') {
        callback = delay;
        delay = 3;
    }
    else {
        type = type || 'show';
        delay = delay && delay.toInt() ? delay.toInt() : 3;
    }
    var component = {
        container: type +'-message',
        body: type +'-message-body',
        content: type +'-message-content'
    };
    new Popup(new Element('div[html=' + msg + ']'), {
        type: 'nohead',
        template: template || $('message-template'),
        modal: false,
        pins: true,
        single: false,
        effect: true,
        autoHide: delay,
        component: component,
        onClose: typeOf(callback) === 'function' ? callback.bind(this) : function() {}
    });
    return (type == 'error' ? false : true); 
}
Message.show = function(msg, delay, callback) {
    Message(msg + '', 'show', delay, callback);
};
Message.error = function(msg, delay, callback) {
    return Message(msg + '', 'error', delay, callback);
};
Message.success = function(msg, delay, callback) {
    return Message(msg + '', 'success', delay, callback);
};

var Tab = function(handle, options) {
    handle = $(handle);
    if(!handle) return;
    options = Object.merge({
        event: 'click',
        trigger: 'ul li',
        content: '.content',
        current: 'curr'
    }, options || {});
    handle.getElements(options.trigger).each(function(item, i){
        item.addEvent(options.event, function(e){
            this.addClass(options.current).getSiblings('.' + options.current).removeClass(options.current);
            handle.getElements(options.content)[i].show().getSiblings(options.content).hide();
        });
    });
};

var selectAll = function(id,check){
    id = $(id);
    check = $$(check);
    if(!id || (id.get('tag') !== 'input' && id.get('type') !== 'checkbox') || !check.length) return;
    $(id).addEvent('change',function(e){
        check.set('checked', !!this.checked);
    });
};

//ie隔行变色
if(Browser.ie && Browser.version < 9){
    window.addEvent('domready', function(){
        $$('tbody tr:nth-child(even)').addClass('even');
    });
}
