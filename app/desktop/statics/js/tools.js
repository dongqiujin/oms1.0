/*
---

script: Fx.Scroll.js

name: Fx.Scroll

description: Effect to smoothly scroll any element, including the window.

license: MIT-style license

authors:
  - Valerio Proietti

requires:
  - Core/Fx
  - Core/Element.Event
  - Core/Element.Dimensions
  - /MooTools.More

provides: [Fx.Scroll]

...
*/

(function(){

Fx.Scroll = new Class({

    Extends: Fx,

    options: {
        offset: {x: 0, y: 0},
        wheelStops: true
    },

    initialize: function(element, options){
        this.element = this.subject = document.id(element);
        this.parent(options);

        if (typeOf(this.element) != 'element') this.element = document.id(this.element.getDocument().body);

        if (this.options.wheelStops){
            var stopper = this.element,
                cancel = this.cancel.pass(false, this);
            this.addEvent('start', function(){
                stopper.addEvent('mousewheel', cancel);
            }, true);
            this.addEvent('complete', function(){
                stopper.removeEvent('mousewheel', cancel);
            }, true);
        }
    },

    set: function(){
        var now = Array.flatten(arguments);
        if (Browser.firefox) now = [Math.round(now[0]), Math.round(now[1])]; // not needed anymore in newer firefox versions
        this.element.scrollTo(now[0], now[1]);
        return this;
    },

    compute: function(from, to, delta){
        return [0, 1].map(function(i){
            return Fx.compute(from[i], to[i], delta);
        });
    },

    start: function(x, y){
        if (!this.check(x, y)) return this;
        var scroll = this.element.getScroll();
        return this.parent([scroll.x, scroll.y], [x, y]);
    },

    calculateScroll: function(x, y){
        var element = this.element,
            scrollSize = element.getScrollSize(),
            scroll = element.getScroll(),
            size = element.getSize(),
            offset = this.options.offset,
            values = {x: x, y: y};

        for (var z in values){
            if (!values[z] && values[z] !== 0) values[z] = scroll[z];
            if (typeOf(values[z]) != 'number') values[z] = scrollSize[z] - size[z];
            values[z] += offset[z];
        }

        return [values.x, values.y];
    },

    toTop: function(){
        return this.start.apply(this, this.calculateScroll(false, 0));
    },

    toLeft: function(){
        return this.start.apply(this, this.calculateScroll(0, false));
    },

    toRight: function(){
        return this.start.apply(this, this.calculateScroll('right', false));
    },

    toBottom: function(){
        return this.start.apply(this, this.calculateScroll(false, 'bottom'));
    },

    toElement: function(el, axes){
        axes = axes ? Array.from(axes) : ['x', 'y'];
        var scroll = isBody(this.element) ? {x: 0, y: 0} : this.element.getScroll();
        var position = Object.map(document.id(el).getPosition(this.element), function(value, axis){
            return axes.contains(axis) ? value + scroll[axis] : false;
        });
        return this.start.apply(this, this.calculateScroll(position.x, position.y));
    },

    toElementEdge: function(el, axes, offset){
        axes = axes ? Array.from(axes) : ['x', 'y'];
        el = document.id(el);
        var to = {},
            position = el.getPosition(this.element),
            size = el.getSize(),
            scroll = this.element.getScroll(),
            containerSize = this.element.getSize(),
            edge = {
                x: position.x + size.x,
                y: position.y + size.y
            };

        ['x', 'y'].each(function(axis){
            if (axes.contains(axis)){
                if (edge[axis] > scroll[axis] + containerSize[axis]) to[axis] = edge[axis] - containerSize[axis];
                if (position[axis] < scroll[axis]) to[axis] = position[axis];
            }
            if (to[axis] == null) to[axis] = scroll[axis];
            if (offset && offset[axis]) to[axis] = to[axis] + offset[axis];
        }, this);

        if (to.x != scroll.x || to.y != scroll.y) this.start(to.x, to.y);
        return this;
    },

    toElementCenter: function(el, axes, offset){
        axes = axes ? Array.from(axes) : ['x', 'y'];
        el = document.id(el);
        var to = {},
            position = el.getPosition(this.element),
            size = el.getSize(),
            scroll = this.element.getScroll(),
            containerSize = this.element.getSize();

        ['x', 'y'].each(function(axis){
            if (axes.contains(axis)){
                to[axis] = position[axis] - (containerSize[axis] - size[axis]) / 2;
            }
            if (to[axis] == null) to[axis] = scroll[axis];
            if (offset && offset[axis]) to[axis] = to[axis] + offset[axis];
        }, this);

        if (to.x != scroll.x || to.y != scroll.y) this.start(to.x, to.y);
        return this;
    }

});



function isBody(element){
    return (/^(?:body|html)$/i).test(element.tagName);
}

})();


Element.implement({
    zoomImg: function(maxwidth, maxheight, v) {
        if (this.get('tag') != 'img' || ! this.width) return;
        var thisSize = {
            'width': this.width,
            'height': this.height
        };
        if (thisSize.width > maxwidth) {
            var overSize = thisSize.width - maxwidth;
            var zoomSizeW = thisSize.width - overSize;
            var zommC = (zoomSizeW / thisSize.width).toFloat();
            var zoomSizeH = (thisSize.height * zommC).toInt();
            Object.append(thisSize, {
                'width': zoomSizeW,
                'height': zoomSizeH
            });
        }
        if (thisSize.height > maxheight) {
            var overSize = thisSize.height - maxheight;
            var zoomSizeH = thisSize.height - overSize;
            var zommC = (zoomSizeH / thisSize.height).toFloat();
            var zoomSizeW = (thisSize.width * zommC).toInt();
            Object.append(thisSize, {
                'width': zoomSizeW,
                'height': zoomSizeH
            });
        }
        if (!v) return this.set(thisSize);
        return thisSize;
    },  
    hide: function(){
        var d;
        try {
            //IE fails here if the element is not in the dom
            d = this.getStyle('display');
        } catch(e){}
        if (d == 'none') return this;
        return this.store('element:_originalDisplay', d || '').setStyle('display', 'none');
    },
    show: function(display){
        if (!display && this.isDisplay()) return this;
        this.fireEvent('onshow', this);
        display = display || this.retrieve('element:_originalDisplay') || '';
        return this.setStyle('display', (display == 'none') ? 'block' : display);
    },
    isDisplay: function() {
        return !(this.getStyle('display') == 'none' || (this.offsetWidth + this.offsetHeight) === 0);
    },
    //获取padding,margin,border值
    getPatch: function() {
        var args = arguments.length ? Array.from(arguments) : ['margin', 'padding', 'border'];
        var _return = {
            x: 0,
            y: 0
        };

        Object.each({x: ['left', 'right'], y: ['top', 'bottom']}, function(p2, p1) {
            p2.each(function(p) {
                try {
                    args.each(function(arg) {
                        arg += '-' + p;
                        if (arg == 'border') arg += '-width';
                        _return[p1] += this.getStyle(arg).toInt() || 0;
                    }, this);
                } catch(e) {}
            }, this);
        }, this);
        return _return;
    },
    // the elements outer size
    outerSize: function(){
        if(this.getStyle('display') === 'none') return {x: 0, y: 0};
        return {
            x: (this.getStyle('width').toInt() || 0) + this.getPatch().x,
            y: (this.getStyle('height').toInt() || 0) + this.getPatch().y
        };
    },
    hasProperty: function(attr){
        if(!attr) return;
        var tag = this.get('tag');
        attr = attr.toLowerCase();
        if(this.hasAttribute){
            return this.hasAttribute(attr);
        }
        if(Browser.ie6 &&
          (("input"==tag && "checked"==attr) ||
          ("option"==tag && "selected"==attr) ||
          ("select"==tag && "multiple"==attr))){
            return this.getAttribute(attr);
        }
        return null!=this.getAttribute(attr);
    }
});




//position the element
(function(){
Element.implement({
    position: function(options){
        options = Object.merge({
            target: document.body,
            to: {x:'center', y:'center'}, //定位到目标元素的基点
            base: {x:'center', y:'center'}, //此元素定位基点 --为数值时类似offset
            offset: {
                x: 0,
                y: 0
            },
            // true 或 to:滑动使this可视。in:把this限制在视窗内
            intoView: false
        }, options);

        this.setStyle('position', 'absolute');

        var el = options.target || $(document.body);
        var base = getOffset(this, options.base);
        var to = getOffset(el, options.to);
        var x = to.x - base.x + el.getPosition().x + el.getScroll().x + options.offset.x;
        var y = to.y - base.y + el.getPosition().y + el.getScroll().y + options.offset.y;

        if(options.intoView === 'in'){
            x = x.limit(0, window.getScroll().x + window.getSize().x - this.getSize().x);
            y = y.limit(0, window.getScroll().y + window.getSize().y - this.getSize().y);
        }

        this.setStyles({
            left: x,
            top: y
        });
        if(options.intoView === true || options.intoView === 'to')
            try{
                new Fx.Scroll(document).toElementEdge(this);
            } catch(e){}
        return this;
    }
});
//取得九点定位的坐标
function getOffset(el, base) {
    var size = el.getSize(), x, y;
    base = base || {x: 'center', y: 'center'};
    switch(base.x.toString().toLowerCase()) {
    case '0':
    case 'left':
        x = 0;
        break;
    case '100%':
    case 'right':
        x = size.x;
        break;
    case '50%':
    case 'center':
        x = size.x / 2;
        break;
    default:
        x = base.x.toInt();
        break;
    }
    switch(base.y.toString().toLowerCase()) {
    case '0':
    case 'top':
        y = 0;
        break;
    case '100%':
    case 'bottom':
        y = size.y;
        break;
    case '50%':
    case 'center':
        y = size.y / 2;
        break;
    default:
        y = base.y.toInt();
        break;
    }

    return {x: x, y: y};
}
})();

