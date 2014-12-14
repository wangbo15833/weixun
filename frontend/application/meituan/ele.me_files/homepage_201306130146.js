/*! jQuery UI - v1.9.2 - 2013-04-27
 * http://jqueryui.com
 * Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.position.js, jquery.ui.draggable.js, jquery.ui.autocomplete.js, jquery.ui.menu.js, jquery.ui.slider.js
 * Copyright 2013 jQuery Foundation and other contributors Licensed MIT */
(function(f, b) {
    function a(j, m) {
        var k, h, l, e = j.nodeName.toLowerCase();
        return "area" === e ? (k = j.parentNode, h = k.name, !j.href || !h || k.nodeName.toLowerCase() !== "map" ? !1 : (l = f("img[usemap=#" + h + "]")[0], !!l && c(l))) : (/input|select|textarea|button|object/.test(e) ? !j.disabled: "a" === e ? j.href || m: m) && c(j)
    }
    function c(e) {
        return f.expr.filters.visible(e) && !f(e).parents().andSelf().filter(function() {
            return f.css(this, "visibility") === "hidden"
        }).length
    }
    var g = 0,
        d = /^ui-id-\d+$/;
    f.ui = f.ui || {};
    if (f.ui.version) {
        return
    }
    f.extend(f.ui, {
        version: "1.9.2",
        keyCode: {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            NUMPAD_ADD: 107,
            NUMPAD_DECIMAL: 110,
            NUMPAD_DIVIDE: 111,
            NUMPAD_ENTER: 108,
            NUMPAD_MULTIPLY: 106,
            NUMPAD_SUBTRACT: 109,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    }),
        f.fn.extend({
            _focus: f.fn.focus,
            focus: function(e, h) {
                return typeof e == "number" ? this.each(function() {
                    var i = this;
                    setTimeout(function() {
                            f(i).focus(),
                                h && h.call(i)
                        },
                        e)
                }) : this._focus.apply(this, arguments)
            },
            scrollParent: function() {
                var e;
                return f.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? e = this.parents().filter(function() {
                    return /(relative|absolute|fixed)/.test(f.css(this, "position")) && /(auto|scroll)/.test(f.css(this, "overflow") + f.css(this, "overflow-y") + f.css(this, "overflow-x"))
                }).eq(0) : e = this.parents().filter(function() {
                    return /(auto|scroll)/.test(f.css(this, "overflow") + f.css(this, "overflow-y") + f.css(this, "overflow-x"))
                }).eq(0),
                    /fixed/.test(this.css("position")) || !e.length ? f(document) : e
            },
            zIndex: function(k) {
                if (k !== b) {
                    return this.css("zIndex", k)
                }
                if (this.length) {
                    var j = f(this[0]),
                        e,
                        h;
                    while (j.length && j[0] !== document) {
                        e = j.css("position");
                        if (e === "absolute" || e === "relative" || e === "fixed") {
                            h = parseInt(j.css("zIndex"), 10);
                            if (!isNaN(h) && h !== 0) {
                                return h
                            }
                        }
                        j = j.parent()
                    }
                }
                return 0
            },
            uniqueId: function() {
                return this.each(function() {
                    this.id || (this.id = "ui-id-" + ++g)
                })
            },
            removeUniqueId: function() {
                return this.each(function() {
                    d.test(this.id) && f(this).removeAttr("id")
                })
            }
        }),
        f.extend(f.expr[":"], {
            data: f.expr.createPseudo ? f.expr.createPseudo(function(e) {
                return function(h) {
                    return !! f.data(h, e)
                }
            }) : function(e, i, h) {
                return !! f.data(e, h[3])
            },
            focusable: function(e) {
                return a(e, !isNaN(f.attr(e, "tabindex")))
            },
            tabbable: function(e) {
                var i = f.attr(e, "tabindex"),
                    h = isNaN(i);
                return (h || i >= 0) && a(e, !h)
            }
        }),
        f(function() {
            var e = document.body,
                h = e.appendChild(h = document.createElement("div"));
            h.offsetHeight,
                f.extend(h.style, {
                    minHeight: "100px",
                    height: "auto",
                    padding: 0,
                    borderWidth: 0
                }),
                f.support.minHeight = h.offsetHeight === 100,
                f.support.selectstart = "onselectstart" in h,
                e.removeChild(h).style.display = "none"
        }),
        f("<a>").outerWidth(1).jquery || f.each(["Width", "Height"],
            function(m, k) {
                function e(i, q, p, o) {
                    return f.each(h,
                        function() {
                            q -= parseFloat(f.css(i, "padding" + this)) || 0,
                                p && (q -= parseFloat(f.css(i, "border" + this + "Width")) || 0),
                                o && (q -= parseFloat(f.css(i, "margin" + this)) || 0)
                        }),
                        q
                }
                var h = k === "Width" ? ["Left", "Right"] : ["Top", "Bottom"],
                    j = k.toLowerCase(),
                    l = {
                        innerWidth: f.fn.innerWidth,
                        innerHeight: f.fn.innerHeight,
                        outerWidth: f.fn.outerWidth,
                        outerHeight: f.fn.outerHeight
                    };
                f.fn["inner" + k] = function(i) {
                    return i === b ? l["inner" + k].call(this) : this.each(function() {
                        f(this).css(j, e(this, i) + "px")
                    })
                },
                    f.fn["outer" + k] = function(i, o) {
                        return typeof i != "number" ? l["outer" + k].call(this, i) : this.each(function() {
                            f(this).css(j, e(this, i, !0, o) + "px")
                        })
                    }
            }),
        f("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (f.fn.removeData = function(e) {
            return function(h) {
                return arguments.length ? e.call(this, f.camelCase(h)) : e.call(this)
            }
        } (f.fn.removeData)),
        function() {
            var e = /msie ([\w.]+)/.exec(navigator.userAgent.toLowerCase()) || [];
            f.ui.ie = e.length ? !0 : !1,
                f.ui.ie6 = parseFloat(e[1], 10) === 6
        } (),
        f.fn.extend({
            disableSelection: function() {
                return this.bind((f.support.selectstart ? "selectstart": "mousedown") + ".ui-disableSelection",
                    function(h) {
                        h.preventDefault()
                    })
            },
            enableSelection: function() {
                return this.unbind(".ui-disableSelection")
            }
        }),
        f.extend(f.ui, {
            plugin: {
                add: function(h, l, k) {
                    var e, j = f.ui[h].prototype;
                    for (e in k) {
                        j.plugins[e] = j.plugins[e] || [],
                            j.plugins[e].push([l, k[e]])
                    }
                },
                call: function(l, j, m) {
                    var k, h = l.plugins[j];
                    if (!h || !l.element[0].parentNode || l.element[0].parentNode.nodeType === 11) {
                        return
                    }
                    for (k = 0; k < h.length; k++) {
                        l.options[h[k][0]] && h[k][1].apply(l.element, m)
                    }
                }
            },
            contains: f.contains,
            hasScroll: function(h, k) {
                if (f(h).css("overflow") === "hidden") {
                    return ! 1
                }
                var j = k && k === "left" ? "scrollLeft": "scrollTop",
                    e = !1;
                return h[j] > 0 ? !0 : (h[j] = 1, e = h[j] > 0, h[j] = 0, e)
            },
            isOverAxis: function(i, h, j) {
                return i > h && i < h + j
            },
            isOver: function(h, m, k, e, j, l) {
                return f.ui.isOverAxis(h, k, j) && f.ui.isOverAxis(m, e, l)
            }
        })
})(jQuery); (function(d, b) {
    var f = 0,
        c = Array.prototype.slice,
        a = d.cleanData;
    d.cleanData = function(e) {
        for (var i = 0,
                 h; (h = e[i]) != null; i++) {
            try {
                d(h).triggerHandler("remove")
            } catch(g) {}
        }
        a(e)
    },
        d.widget = function(j, p, l) {
            var h, k, m, g, e = j.split(".")[0];
            j = j.split(".")[1],
                h = e + "-" + j,
                l || (l = p, p = d.Widget),
                d.expr[":"][h.toLowerCase()] = function(i) {
                    return !! d.data(i, h)
                },
                d[e] = d[e] || {},
                k = d[e][j],
                m = d[e][j] = function(n, i) {
                    if (!this._createWidget) {
                        return new m(n, i)
                    }
                    arguments.length && this._createWidget(n, i)
                },
                d.extend(m, k, {
                    version: l.version,
                    _proto: d.extend({},
                        l),
                    _childConstructors: []
                }),
                g = new p,
                g.options = d.widget.extend({},
                    g.options),
                d.each(l,
                    function(o, n) {
                        d.isFunction(n) && (l[o] = function() {
                            var q = function() {
                                    return p.prototype[o].apply(this, arguments)
                                },
                                i = function(r) {
                                    return p.prototype[o].apply(this, r)
                                };
                            return function() {
                                var r = this._super,
                                    v = this._superApply,
                                    u;
                                return this._super = q,
                                    this._superApply = i,
                                    u = n.apply(this, arguments),
                                    this._super = r,
                                    this._superApply = v,
                                    u
                            }
                        } ())
                    }),
                m.prototype = d.widget.extend(g, {
                        widgetEventPrefix: k ? g.widgetEventPrefix: j
                    },
                    l, {
                        constructor: m,
                        namespace: e,
                        widgetName: j,
                        widgetBaseClass: h,
                        widgetFullName: h
                    }),
                k ? (d.each(k._childConstructors,
                    function(i, q) {
                        var o = q.prototype;
                        d.widget(o.namespace + "." + o.widgetName, m, q._proto)
                    }), delete k._childConstructors) : p._childConstructors.push(m),
                d.widget.bridge(j, m)
        },
        d.widget.extend = function(l) {
            var h = c.call(arguments, 1),
                j = 0,
                k = h.length,
                g,
                e;
            for (; j < k; j++) {
                for (g in h[j]) {
                    e = h[j][g],
                        h[j].hasOwnProperty(g) && e !== b && (d.isPlainObject(e) ? l[g] = d.isPlainObject(l[g]) ? d.widget.extend({},
                            l[g], e) : d.widget.extend({},
                            e) : l[g] = e)
                }
            }
            return l
        },
        d.widget.bridge = function(h, e) {
            var g = e.prototype.widgetFullName || h;
            d.fn[h] = function(l) {
                var j = typeof l == "string",
                    i = c.call(arguments, 1),
                    k = this;
                return l = !j && i.length ? d.widget.extend.apply(null, [l].concat(i)) : l,
                    j ? this.each(function() {
                        var n, m = d.data(this, g);
                        if (!m) {
                            return d.error("cannot call methods on " + h + " prior to initialization; attempted to call method '" + l + "'")
                        }
                        if (!d.isFunction(m[l]) || l.charAt(0) === "_") {
                            return d.error("no such method '" + l + "' for " + h + " widget instance")
                        }
                        n = m[l].apply(m, i);
                        if (n !== m && n !== b) {
                            return k = n && n.jquery ? k.pushStack(n.get()) : n,
                                !1
                        }
                    }) : this.each(function() {
                        var m = d.data(this, g);
                        m ? m.option(l || {})._init() : d.data(this, g, new e(l, this))
                    }),
                    k
            }
        },
        d.Widget = function() {},
        d.Widget._childConstructors = [],
        d.Widget.prototype = {
            widgetName: "widget",
            widgetEventPrefix: "",
            defaultElement: "<div>",
            options: {
                disabled: !1,
                create: null
            },
            _createWidget: function(e, g) {
                g = d(g || this.defaultElement || this)[0],
                    this.element = d(g),
                    this.uuid = f++,
                    this.eventNamespace = "." + this.widgetName + this.uuid,
                    this.options = d.widget.extend({},
                        this.options, this._getCreateOptions(), e),
                    this.bindings = d(),
                    this.hoverable = d(),
                    this.focusable = d(),
                    g !== this && (d.data(g, this.widgetName, this), d.data(g, this.widgetFullName, this), this._on(!0, this.element, {
                        remove: function(h) {
                            h.target === g && this.destroy()
                        }
                    }), this.document = d(g.style ? g.ownerDocument: g.document || g), this.window = d(this.document[0].defaultView || this.document[0].parentWindow)),
                    this._create(),
                    this._trigger("create", null, this._getCreateEventData()),
                    this._init()
            },
            _getCreateOptions: d.noop,
            _getCreateEventData: d.noop,
            _create: d.noop,
            _init: d.noop,
            destroy: function() {
                this._destroy(),
                    this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(d.camelCase(this.widgetFullName)),
                    this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled"),
                    this.bindings.unbind(this.eventNamespace),
                    this.hoverable.removeClass("ui-state-hover"),
                    this.focusable.removeClass("ui-state-focus")
            },
            _destroy: d.noop,
            widget: function() {
                return this.element
            },
            option: function(l, j) {
                var g = l,
                    h, k, e;
                if (arguments.length === 0) {
                    return d.widget.extend({},
                        this.options)
                }
                if (typeof l == "string") {
                    g = {},
                        h = l.split("."),
                        l = h.shift();
                    if (h.length) {
                        k = g[l] = d.widget.extend({},
                            this.options[l]);
                        for (e = 0; e < h.length - 1; e++) {
                            k[h[e]] = k[h[e]] || {},
                                k = k[h[e]]
                        }
                        l = h.pop();
                        if (j === b) {
                            return k[l] === b ? null: k[l]
                        }
                        k[l] = j
                    } else {
                        if (j === b) {
                            return this.options[l] === b ? null: this.options[l]
                        }
                        g[l] = j
                    }
                }
                return this._setOptions(g),
                    this
            },
            _setOptions: function(h) {
                var g;
                for (g in h) {
                    this._setOption(g, h[g])
                }
                return this
            },
            _setOption: function(h, g) {
                return this.options[h] = g,
                    h === "disabled" && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !!g).attr("aria-disabled", g), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")),
                    this
            },
            enable: function() {
                return this._setOption("disabled", !1)
            },
            disable: function() {
                return this._setOption("disabled", !0)
            },
            _on: function(g, k, j) {
                var e, h = this;
                typeof g != "boolean" && (j = k, k = g, g = !1),
                    j ? (k = e = d(k), this.bindings = this.bindings.add(k)) : (j = k, k = this.element, e = this.widget()),
                    d.each(j,
                        function(p, s) {
                            function n() {
                                if (!g && (h.options.disabled === !0 || d(this).hasClass("ui-state-disabled"))) {
                                    return
                                }
                                return (typeof s == "string" ? h[s] : s).apply(h, arguments)
                            }
                            typeof s != "string" && (n.guid = s.guid = s.guid || n.guid || d.guid++);
                            var m = p.match(/^(\w+)\s*(.*)$/),
                                q = m[1] + h.eventNamespace,
                                i = m[2];
                            i ? e.delegate(i, q, n) : k.bind(q, n)
                        })
            },
            _off: function(h, g) {
                g = (g || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace,
                    h.unbind(g).undelegate(g)
            },
            _delay: function(i, g) {
                function j() {
                    return (typeof i == "string" ? h[i] : i).apply(h, arguments)
                }
                var h = this;
                return setTimeout(j, g || 0)
            },
            _hoverable: function(e) {
                this.hoverable = this.hoverable.add(e),
                    this._on(e, {
                        mouseenter: function(g) {
                            d(g.currentTarget).addClass("ui-state-hover")
                        },
                        mouseleave: function(g) {
                            d(g.currentTarget).removeClass("ui-state-hover")
                        }
                    })
            },
            _focusable: function(e) {
                this.focusable = this.focusable.add(e),
                    this._on(e, {
                        focusin: function(g) {
                            d(g.currentTarget).addClass("ui-state-focus")
                        },
                        focusout: function(g) {
                            d(g.currentTarget).removeClass("ui-state-focus")
                        }
                    })
            },
            _trigger: function(g, l, j) {
                var e, h, k = this.options[g];
                j = j || {},
                    l = d.Event(l),
                    l.type = (g === this.widgetEventPrefix ? g: this.widgetEventPrefix + g).toLowerCase(),
                    l.target = this.element[0],
                    h = l.originalEvent;
                if (h) {
                    for (e in h) {
                        e in l || (l[e] = h[e])
                    }
                }
                return this.element.trigger(l, j),
                    !(d.isFunction(k) && k.apply(this.element[0], [l].concat(j)) === !1 || l.isDefaultPrevented())
            }
        },
        d.each({
                show: "fadeIn",
                hide: "fadeOut"
            },
            function(e, g) {
                d.Widget.prototype["_" + e] = function(l, j, k) {
                    typeof j == "string" && (j = {
                        effect: j
                    });
                    var m, h = j ? j === !0 || typeof j == "number" ? g: j.effect || g: e;
                    j = j || {},
                        typeof j == "number" && (j = {
                            duration: j
                        }),
                        m = !d.isEmptyObject(j),
                        j.complete = k,
                        j.delay && l.delay(j.delay),
                        m && d.effects && (d.effects.effect[h] || d.uiBackCompat !== !1 && d.effects[h]) ? l[e](j) : h !== e && l[h] ? l[h](j.duration, j.easing, k) : l.queue(function(i) {
                            d(this)[e](),
                                k && k.call(l[0]),
                                i()
                        })
                }
            }),
        d.uiBackCompat !== !1 && (d.Widget.prototype._getCreateOptions = function() {
            return d.metadata && d.metadata.get(this.element[0])[this.widgetName]
        })
})(jQuery); (function(b, a) {
    var c = !1;
    b(document).mouseup(function(d) {
        c = !1
    }),
        b.widget("ui.mouse", {
            version: "1.9.2",
            options: {
                cancel: "input,textarea,button,select,option",
                distance: 1,
                delay: 0
            },
            _mouseInit: function() {
                var d = this;
                this.element.bind("mousedown." + this.widgetName,
                    function(f) {
                        return d._mouseDown(f)
                    }).bind("click." + this.widgetName,
                    function(e) {
                        if (!0 === b.data(e.target, d.widgetName + ".preventClickEvent")) {
                            return b.removeData(e.target, d.widgetName + ".preventClickEvent"),
                                e.stopImmediatePropagation(),
                                !1
                        }
                    }),
                    this.started = !1
            },
            _mouseDestroy: function() {
                this.element.unbind("." + this.widgetName),
                    this._mouseMoveDelegate && b(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
            },
            _mouseDown: function(e) {
                if (c) {
                    return
                }
                this._mouseStarted && this._mouseUp(e),
                    this._mouseDownEvent = e;
                var g = this,
                    d = e.which === 1,
                    f = typeof this.options.cancel == "string" && e.target.nodeName ? b(e.target).closest(this.options.cancel).length: !1;
                if (!d || f || !this._mouseCapture(e)) {
                    return ! 0
                }
                this.mouseDelayMet = !this.options.delay,
                    this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function() {
                            g.mouseDelayMet = !0
                        },
                        this.options.delay));
                if (this._mouseDistanceMet(e) && this._mouseDelayMet(e)) {
                    this._mouseStarted = this._mouseStart(e) !== !1;
                    if (!this._mouseStarted) {
                        return e.preventDefault(),
                            !0
                    }
                }
                return ! 0 === b.data(e.target, this.widgetName + ".preventClickEvent") && b.removeData(e.target, this.widgetName + ".preventClickEvent"),
                    this._mouseMoveDelegate = function(h) {
                        return g._mouseMove(h)
                    },
                    this._mouseUpDelegate = function(h) {
                        return g._mouseUp(h)
                    },
                    b(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate),
                    e.preventDefault(),
                    c = !0,
                    !0
            },
            _mouseMove: function(d) {
                return ! b.ui.ie || document.documentMode >= 9 || !!d.button ? this._mouseStarted ? (this._mouseDrag(d), d.preventDefault()) : (this._mouseDistanceMet(d) && this._mouseDelayMet(d) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, d) !== !1, this._mouseStarted ? this._mouseDrag(d) : this._mouseUp(d)), !this._mouseStarted) : this._mouseUp(d)
            },
            _mouseUp: function(d) {
                return b(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate),
                    this._mouseStarted && (this._mouseStarted = !1, d.target === this._mouseDownEvent.target && b.data(d.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(d)),
                    !1
            },
            _mouseDistanceMet: function(d) {
                return Math.max(Math.abs(this._mouseDownEvent.pageX - d.pageX), Math.abs(this._mouseDownEvent.pageY - d.pageY)) >= this.options.distance
            },
            _mouseDelayMet: function(d) {
                return this.mouseDelayMet
            },
            _mouseStart: function(d) {},
            _mouseDrag: function(d) {},
            _mouseStop: function(d) {},
            _mouseCapture: function(d) {
                return ! 0
            }
        })
})(jQuery); (function(w, A) {
    function q(c, a, f) {
        return [parseInt(c[0], 10) * (k.test(c[0]) ? a / 100 : 1), parseInt(c[1], 10) * (k.test(c[1]) ? f / 100 : 1)]
    }
    function d(a, c) {
        return parseInt(w.css(a, c), 10) || 0
    }
    w.ui = w.ui || {};
    var j, b = Math.max,
        m = Math.abs,
        B = Math.round,
        g = /left|center|right/,
        z = /top|center|bottom/,
        y = /[\+\-]\d+%?/,
        v = /^\w+/,
        k = /%$/,
        x = w.fn.position;
    w.position = {
        scrollbarWidth: function() {
            if (j !== A) {
                return j
            }
            var e, a, c = w("<div style='display:block;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
                f = c.children()[0];
            return w("body").append(c),
                e = f.offsetWidth,
                c.css("overflow", "scroll"),
                a = f.offsetWidth,
                e === a && (a = c[0].clientWidth),
                c.remove(),
                j = e - a
        },
        getScrollInfo: function(c) {
            var h = c.isWindow ? "": c.element.css("overflow-x"),
                f = c.isWindow ? "": c.element.css("overflow-y"),
                a = h === "scroll" || h === "auto" && c.width < c.element[0].scrollWidth,
                e = f === "scroll" || f === "auto" && c.height < c.element[0].scrollHeight;
            return {
                width: a ? w.position.scrollbarWidth() : 0,
                height: e ? w.position.scrollbarWidth() : 0
            }
        },
        getWithinInfo: function(a) {
            var e = w(a || window),
                c = w.isWindow(e[0]);
            return {
                element: e,
                isWindow: c,
                offset: e.offset() || {
                    left: 0,
                    top: 0
                },
                scrollLeft: e.scrollLeft(),
                scrollTop: e.scrollTop(),
                width: c ? e.width() : e.outerWidth(),
                height: c ? e.height() : e.outerHeight()
            }
        }
    },
        w.fn.position = function(u) {
            if (!u || !u.of) {
                return x.apply(this, arguments)
            }
            u = w.extend({},
                u);
            var a, e, i, s, c, h = w(u.of),
                p = w.position.getWithinInfo(u.within),
                o = w.position.getScrollInfo(p),
                r = h[0],
                C = (u.collision || "flip").split(" "),
                f = {};
            return r.nodeType === 9 ? (e = h.width(), i = h.height(), s = {
                top: 0,
                left: 0
            }) : w.isWindow(r) ? (e = h.width(), i = h.height(), s = {
                top: h.scrollTop(),
                left: h.scrollLeft()
            }) : r.preventDefault ? (u.at = "left top", e = i = 0, s = {
                top: r.pageY,
                left: r.pageX
            }) : (e = h.outerWidth(), i = h.outerHeight(), s = h.offset()),
                c = w.extend({},
                    s),
                w.each(["my", "at"],
                    function() {
                        var t = (u[this] || "").split(" "),
                            D,
                            l;
                        t.length === 1 && (t = g.test(t[0]) ? t.concat(["center"]) : z.test(t[0]) ? ["center"].concat(t) : ["center", "center"]),
                            t[0] = g.test(t[0]) ? t[0] : "center",
                            t[1] = z.test(t[1]) ? t[1] : "center",
                            D = y.exec(t[0]),
                            l = y.exec(t[1]),
                            f[this] = [D ? D[0] : 0, l ? l[0] : 0],
                            u[this] = [v.exec(t[0])[0], v.exec(t[1])[0]]
                    }),
                C.length === 1 && (C[1] = C[0]),
                u.at[0] === "right" ? c.left += e: u.at[0] === "center" && (c.left += e / 2),
                u.at[1] === "bottom" ? c.top += i: u.at[1] === "center" && (c.top += i / 2),
                a = q(f.at, e, i),
                c.left += a[0],
                c.top += a[1],
                this.each(function() {
                    var n, K, H = w(this),
                        E = H.outerWidth(),
                        G = H.outerHeight(),
                        J = d(this, "marginLeft"),
                        I = d(this, "marginTop"),
                        D = E + J + d(this, "marginRight") + o.width,
                        F = G + I + d(this, "marginBottom") + o.height,
                        l = w.extend({},
                            c),
                        t = q(f.my, H.outerWidth(), H.outerHeight());
                    u.my[0] === "right" ? l.left -= E: u.my[0] === "center" && (l.left -= E / 2),
                        u.my[1] === "bottom" ? l.top -= G: u.my[1] === "center" && (l.top -= G / 2),
                        l.left += t[0],
                        l.top += t[1],
                        w.support.offsetFractions || (l.left = B(l.left), l.top = B(l.top)),
                        n = {
                            marginLeft: J,
                            marginTop: I
                        },
                        w.each(["left", "top"],
                            function(M, L) {
                                w.ui.position[C[M]] && w.ui.position[C[M]][L](l, {
                                    targetWidth: e,
                                    targetHeight: i,
                                    elemWidth: E,
                                    elemHeight: G,
                                    collisionPosition: n,
                                    collisionWidth: D,
                                    collisionHeight: F,
                                    offset: [a[0] + t[0], a[1] + t[1]],
                                    my: u.my,
                                    at: u.at,
                                    within: p,
                                    elem: H
                                })
                            }),
                        w.fn.bgiframe && H.bgiframe(),
                        u.using && (K = function(O) {
                            var Q = s.left - l.left,
                                N = Q + e - E,
                                P = s.top - l.top,
                                L = P + i - G,
                                M = {
                                    target: {
                                        element: h,
                                        left: s.left,
                                        top: s.top,
                                        width: e,
                                        height: i
                                    },
                                    element: {
                                        element: H,
                                        left: l.left,
                                        top: l.top,
                                        width: E,
                                        height: G
                                    },
                                    horizontal: N < 0 ? "left": Q > 0 ? "right": "center",
                                    vertical: L < 0 ? "top": P > 0 ? "bottom": "middle"
                                };
                            e < E && m(Q + N) < e && (M.horizontal = "center"),
                                i < G && m(P + L) < i && (M.vertical = "middle"),
                                b(m(Q), m(N)) > b(m(P), m(L)) ? M.important = "horizontal": M.important = "vertical",
                                u.using.call(this, O, M)
                        }),
                        H.offset(w.extend(l, {
                            using: K
                        }))
                })
        },
        w.ui.position = {
            fit: {
                left: function(r, E) {
                    var h = E.within,
                        l = h.isWindow ? h.scrollLeft: h.offset.left,
                        F = h.width,
                        c = r.left - E.collisionPosition.marginLeft,
                        D = l - c,
                        C = c + E.collisionWidth - F - l,
                        p;
                    E.collisionWidth > F ? D > 0 && C <= 0 ? (p = r.left + D + E.collisionWidth - F - l, r.left += D - p) : C > 0 && D <= 0 ? r.left = l: D > C ? r.left = l + F - E.collisionWidth: r.left = l: D > 0 ? r.left += D: C > 0 ? r.left -= C: r.left = b(r.left - c, r.left)
                },
                top: function(r, E) {
                    var h = E.within,
                        l = h.isWindow ? h.scrollTop: h.offset.top,
                        F = E.within.height,
                        c = r.top - E.collisionPosition.marginTop,
                        D = l - c,
                        C = c + E.collisionHeight - F - l,
                        p;
                    E.collisionHeight > F ? D > 0 && C <= 0 ? (p = r.top + D + E.collisionHeight - F - l, r.top += D - p) : C > 0 && D <= 0 ? r.top = l: D > C ? r.top = l + F - E.collisionHeight: r.top = l: D > 0 ? r.top += D: C > 0 ? r.top -= C: r.top = b(r.top - c, r.top)
                }
            },
            flip: {
                left: function(I, N) {
                    var E = N.within,
                        i = E.offset.left + E.scrollLeft,
                        O = E.width,
                        D = E.isWindow ? E.scrollLeft: E.offset.left,
                        M = I.left - N.collisionPosition.marginLeft,
                        L = M - D,
                        H = M + N.collisionWidth - O - D,
                        F = N.my[0] === "left" ? -N.elemWidth: N.my[0] === "right" ? N.elemWidth: 0,
                        K = N.at[0] === "left" ? N.targetWidth: N.at[0] === "right" ? -N.targetWidth: 0,
                        G = -2 * N.offset[0],
                        C,
                        J;
                    if (L < 0) {
                        C = I.left + F + K + G + N.collisionWidth - O - i;
                        if (C < 0 || C < m(L)) {
                            I.left += F + K + G
                        }
                    } else {
                        if (H > 0) {
                            J = I.left - N.collisionPosition.marginLeft + F + K + G - D;
                            if (J > 0 || m(J) < H) {
                                I.left += F + K + G
                            }
                        }
                    }
                },
                top: function(I, O) {
                    var E = O.within,
                        i = E.offset.top + E.scrollTop,
                        P = E.height,
                        D = E.isWindow ? E.scrollTop: E.offset.top,
                        N = I.top - O.collisionPosition.marginTop,
                        L = N - D,
                        H = N + O.collisionHeight - P - D,
                        F = O.my[1] === "top",
                        K = F ? -O.elemHeight: O.my[1] === "bottom" ? O.elemHeight: 0,
                        G = O.at[1] === "top" ? O.targetHeight: O.at[1] === "bottom" ? -O.targetHeight: 0,
                        C = -2 * O.offset[1],
                        J,
                        M;
                    L < 0 ? (M = I.top + K + G + C + O.collisionHeight - P - i, I.top + K + G + C > L && (M < 0 || M < m(L)) && (I.top += K + G + C)) : H > 0 && (J = I.top - O.collisionPosition.marginTop + K + G + C - D, I.top + K + G + C > H && (J > 0 || m(J) < H) && (I.top += K + G + C))
                }
            },
            flipfit: {
                left: function() {
                    w.ui.position.flip.left.apply(this, arguments),
                        w.ui.position.fit.left.apply(this, arguments)
                },
                top: function() {
                    w.ui.position.flip.top.apply(this, arguments),
                        w.ui.position.fit.top.apply(this, arguments)
                }
            }
        },
        function() {
            var e, p, h, c, f, l = document.getElementsByTagName("body")[0],
                a = document.createElement("div");
            e = document.createElement(l ? "div": "body"),
                h = {
                    visibility: "hidden",
                    width: 0,
                    height: 0,
                    border: 0,
                    margin: 0,
                    background: "none"
                },
                l && w.extend(h, {
                    position: "absolute",
                    left: "-1000px",
                    top: "-1000px"
                });
            for (f in h) {
                e.style[f] = h[f]
            }
            e.appendChild(a),
                p = l || document.documentElement,
                p.insertBefore(e, p.firstChild),
                a.style.cssText = "position: absolute; left: 10.7432222px;",
                c = w(a).offset().left,
                w.support.offsetFractions = c > 10 && c < 11,
                e.innerHTML = "",
                p.removeChild(e)
        } (),
        w.uiBackCompat !== !1 &&
            function(a) {
                var c = a.fn.position;
                a.fn.position = function(h) {
                    if (!h || !h.offset) {
                        return c.call(this, h)
                    }
                    var e = h.offset.split(" "),
                        f = h.at.split(" ");
                    return e.length === 1 && (e[1] = e[0]),
                        /^\d/.test(e[0]) && (e[0] = "+" + e[0]),
                        /^\d/.test(e[1]) && (e[1] = "+" + e[1]),
                        f.length === 1 && (/left|center|right/.test(f[0]) ? f[1] = "center": (f[1] = f[0], f[0] = "center")),
                        c.call(this, a.extend(h, {
                            at: f[0] + e[0] + " " + f[1] + e[1],
                            offset: A
                        }))
                }
            } (jQuery)
})(jQuery); (function(b, a) {
    b.widget("ui.draggable", b.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "drag",
        options: {
            addClasses: !0,
            appendTo: "parent",
            axis: !1,
            connectToSortable: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            iframeFix: !1,
            opacity: !1,
            refreshPositions: !1,
            revert: !1,
            revertDuration: 500,
            scope: "default",
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: !1,
            snapMode: "both",
            snapTolerance: 20,
            stack: !1,
            zIndex: !1
        },
        _create: function() {
            this.options.helper == "original" && !/^(?:r|a|f)/.test(this.element.css("position")) && (this.element[0].style.position = "relative"),
                this.options.addClasses && this.element.addClass("ui-draggable"),
                this.options.disabled && this.element.addClass("ui-draggable-disabled"),
                this._mouseInit()
        },
        _destroy: function() {
            this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"),
                this._mouseDestroy()
        },
        _mouseCapture: function(c) {
            var d = this.options;
            return this.helper || d.disabled || b(c.target).is(".ui-resizable-handle") ? !1 : (this.handle = this._getHandle(c), this.handle ? (b(d.iframeFix === !0 ? "iframe": d.iframeFix).each(function() {
                b('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
                    width: this.offsetWidth + "px",
                    height: this.offsetHeight + "px",
                    position: "absolute",
                    opacity: "0.001",
                    zIndex: 1000
                }).css(b(this).offset()).appendTo("body")
            }), !0) : !1)
        },
        _mouseStart: function(c) {
            var d = this.options;
            return this.helper = this._createHelper(c),
                this.helper.addClass("ui-draggable-dragging"),
                this._cacheHelperProportions(),
                b.ui.ddmanager && (b.ui.ddmanager.current = this),
                this._cacheMargins(),
                this.cssPosition = this.helper.css("position"),
                this.scrollParent = this.helper.scrollParent(),
                this.offset = this.positionAbs = this.element.offset(),
                this.offset = {
                    top: this.offset.top - this.margins.top,
                    left: this.offset.left - this.margins.left
                },
                b.extend(this.offset, {
                    click: {
                        left: c.pageX - this.offset.left,
                        top: c.pageY - this.offset.top
                    },
                    parent: this._getParentOffset(),
                    relative: this._getRelativeOffset()
                }),
                this.originalPosition = this.position = this._generatePosition(c),
                this.originalPageX = c.pageX,
                this.originalPageY = c.pageY,
                d.cursorAt && this._adjustOffsetFromHelper(d.cursorAt),
                d.containment && this._setContainment(),
                this._trigger("start", c) === !1 ? (this._clear(), !1) : (this._cacheHelperProportions(), b.ui.ddmanager && !d.dropBehaviour && b.ui.ddmanager.prepareOffsets(this, c), this._mouseDrag(c, !0), b.ui.ddmanager && b.ui.ddmanager.dragStart(this, c), !0)
        },
        _mouseDrag: function(c, e) {
            this.position = this._generatePosition(c),
                this.positionAbs = this._convertPositionTo("absolute");
            if (!e) {
                var d = this._uiHash();
                if (this._trigger("drag", c, d) === !1) {
                    return this._mouseUp({}),
                        !1
                }
                this.position = d.position
            }
            if (!this.options.axis || this.options.axis != "y") {
                this.helper[0].style.left = this.position.left + "px"
            }
            if (!this.options.axis || this.options.axis != "x") {
                this.helper[0].style.top = this.position.top + "px"
            }
            return b.ui.ddmanager && b.ui.ddmanager.drag(this, c),
                !1
        },
        _mouseStop: function(d) {
            var g = !1;
            b.ui.ddmanager && !this.options.dropBehaviour && (g = b.ui.ddmanager.drop(this, d)),
                this.dropped && (g = this.dropped, this.dropped = !1);
            var f = this.element[0],
                c = !1;
            while (f && (f = f.parentNode)) {
                f == document && (c = !0)
            }
            if (!c && this.options.helper === "original") {
                return ! 1
            }
            if (this.options.revert == "invalid" && !g || this.options.revert == "valid" && g || this.options.revert === !0 || b.isFunction(this.options.revert) && this.options.revert.call(this.element, g)) {
                var e = this;
                b(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10),
                    function() {
                        e._trigger("stop", d) !== !1 && e._clear()
                    })
            } else {
                this._trigger("stop", d) !== !1 && this._clear()
            }
            return ! 1
        },
        _mouseUp: function(c) {
            return b("div.ui-draggable-iframeFix").each(function() {
                this.parentNode.removeChild(this)
            }),
                b.ui.ddmanager && b.ui.ddmanager.dragStop(this, c),
                b.ui.mouse.prototype._mouseUp.call(this, c)
        },
        cancel: function() {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(),
                this
        },
        _getHandle: function(c) {
            var d = !this.options.handle || !b(this.options.handle, this.element).length ? !0 : !1;
            return b(this.options.handle, this.element).find("*").andSelf().each(function() {
                this == c.target && (d = !0)
            }),
                d
        },
        _createHelper: function(c) {
            var e = this.options,
                d = b.isFunction(e.helper) ? b(e.helper.apply(this.element[0], [c])) : e.helper == "clone" ? this.element.clone().removeAttr("id") : this.element;
            return d.parents("body").length || d.appendTo(e.appendTo == "parent" ? this.element[0].parentNode: e.appendTo),
                d[0] != this.element[0] && !/(fixed|absolute)/.test(d.css("position")) && d.css("position", "absolute"),
                d
        },
        _adjustOffsetFromHelper: function(c) {
            typeof c == "string" && (c = c.split(" ")),
                b.isArray(c) && (c = {
                    left: +c[0],
                    top: +c[1] || 0
                }),
                "left" in c && (this.offset.click.left = c.left + this.margins.left),
                "right" in c && (this.offset.click.left = this.helperProportions.width - c.right + this.margins.left),
                "top" in c && (this.offset.click.top = c.top + this.margins.top),
                "bottom" in c && (this.offset.click.top = this.helperProportions.height - c.bottom + this.margins.top)
        },
        _getParentOffset: function() {
            this.offsetParent = this.helper.offsetParent();
            var c = this.offsetParent.offset();
            this.cssPosition == "absolute" && this.scrollParent[0] != document && b.contains(this.scrollParent[0], this.offsetParent[0]) && (c.left += this.scrollParent.scrollLeft(), c.top += this.scrollParent.scrollTop());
            if (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == "html" && b.ui.ie) {
                c = {
                    top: 0,
                    left: 0
                }
            }
            return {
                top: c.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: c.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if (this.cssPosition == "relative") {
                var c = this.element.position();
                return {
                    top: c.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: c.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {
                top: 0,
                left: 0
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: parseInt(this.element.css("marginLeft"), 10) || 0,
                top: parseInt(this.element.css("marginTop"), 10) || 0,
                right: parseInt(this.element.css("marginRight"), 10) || 0,
                bottom: parseInt(this.element.css("marginBottom"), 10) || 0
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var d = this.options;
            d.containment == "parent" && (d.containment = this.helper[0].parentNode);
            if (d.containment == "document" || d.containment == "window") {
                this.containment = [d.containment == "document" ? 0 : b(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, d.containment == "document" ? 0 : b(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, (d.containment == "document" ? 0 : b(window).scrollLeft()) + b(d.containment == "document" ? document: window).width() - this.helperProportions.width - this.margins.left, (d.containment == "document" ? 0 : b(window).scrollTop()) + (b(d.containment == "document" ? document: window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]
            }
            if (!/^(document|window|parent)$/.test(d.containment) && d.containment.constructor != Array) {
                var g = b(d.containment),
                    f = g[0];
                if (!f) {
                    return
                }
                var c = g.offset(),
                    e = b(f).css("overflow") != "hidden";
                this.containment = [(parseInt(b(f).css("borderLeftWidth"), 10) || 0) + (parseInt(b(f).css("paddingLeft"), 10) || 0), (parseInt(b(f).css("borderTopWidth"), 10) || 0) + (parseInt(b(f).css("paddingTop"), 10) || 0), (e ? Math.max(f.scrollWidth, f.offsetWidth) : f.offsetWidth) - (parseInt(b(f).css("borderLeftWidth"), 10) || 0) - (parseInt(b(f).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (e ? Math.max(f.scrollHeight, f.offsetHeight) : f.offsetHeight) - (parseInt(b(f).css("borderTopWidth"), 10) || 0) - (parseInt(b(f).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom],
                    this.relative_container = g
            } else {
                d.containment.constructor == Array && (this.containment = d.containment)
            }
        },
        _convertPositionTo: function(d, h) {
            h || (h = this.position);
            var f = d == "absolute" ? 1 : -1,
                c = this.options,
                e = this.cssPosition != "absolute" || this.scrollParent[0] != document && !!b.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent: this.offsetParent,
                g = /(html|body)/i.test(e[0].tagName);
            return {
                top: h.top + this.offset.relative.top * f + this.offset.parent.top * f - (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : g ? 0 : e.scrollTop()) * f,
                left: h.left + this.offset.relative.left * f + this.offset.parent.left * f - (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : g ? 0 : e.scrollLeft()) * f
            }
        },
        _generatePosition: function(p) {
            var e = this.options,
                c = this.cssPosition != "absolute" || this.scrollParent[0] != document && !!b.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent: this.offsetParent,
                h = /(html|body)/i.test(c[0].tagName),
                q = p.pageX,
                d = p.pageY;
            if (this.originalPosition) {
                var m;
                if (this.containment) {
                    if (this.relative_container) {
                        var k = this.relative_container.offset();
                        m = [this.containment[0] + k.left, this.containment[1] + k.top, this.containment[2] + k.left, this.containment[3] + k.top]
                    } else {
                        m = this.containment
                    }
                    p.pageX - this.offset.click.left < m[0] && (q = m[0] + this.offset.click.left),
                        p.pageY - this.offset.click.top < m[1] && (d = m[1] + this.offset.click.top),
                        p.pageX - this.offset.click.left > m[2] && (q = m[2] + this.offset.click.left),
                        p.pageY - this.offset.click.top > m[3] && (d = m[3] + this.offset.click.top)
                }
                if (e.grid) {
                    var j = e.grid[1] ? this.originalPageY + Math.round((d - this.originalPageY) / e.grid[1]) * e.grid[1] : this.originalPageY;
                    d = m ? j - this.offset.click.top < m[1] || j - this.offset.click.top > m[3] ? j - this.offset.click.top < m[1] ? j + e.grid[1] : j - e.grid[1] : j: j;
                    var g = e.grid[0] ? this.originalPageX + Math.round((q - this.originalPageX) / e.grid[0]) * e.grid[0] : this.originalPageX;
                    q = m ? g - this.offset.click.left < m[0] || g - this.offset.click.left > m[2] ? g - this.offset.click.left < m[0] ? g + e.grid[0] : g - e.grid[0] : g: g
                }
            }
            return {
                top: d - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : h ? 0 : c.scrollTop()),
                left: q - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : h ? 0 : c.scrollLeft())
            }
        },
        _clear: function() {
            this.helper.removeClass("ui-draggable-dragging"),
                this.helper[0] != this.element[0] && !this.cancelHelperRemoval && this.helper.remove(),
                this.helper = null,
                this.cancelHelperRemoval = !1
        },
        _trigger: function(c, e, d) {
            return d = d || this._uiHash(),
                b.ui.plugin.call(this, c, [e, d]),
                c == "drag" && (this.positionAbs = this._convertPositionTo("absolute")),
                b.Widget.prototype._trigger.call(this, c, e, d)
        },
        plugins: {},
        _uiHash: function(c) {
            return {
                helper: this.helper,
                position: this.position,
                originalPosition: this.originalPosition,
                offset: this.positionAbs
            }
        }
    }),
        b.ui.plugin.add("draggable", "connectToSortable", {
            start: function(d, g) {
                var f = b(this).data("draggable"),
                    c = f.options,
                    e = b.extend({},
                        g, {
                            item: f.element
                        });
                f.sortables = [],
                    b(c.connectToSortable).each(function() {
                        var h = b.data(this, "sortable");
                        h && !h.options.disabled && (f.sortables.push({
                            instance: h,
                            shouldRevert: h.options.revert
                        }), h.refreshPositions(), h._trigger("activate", d, e))
                    })
            },
            stop: function(d, f) {
                var e = b(this).data("draggable"),
                    c = b.extend({},
                        f, {
                            item: e.element
                        });
                b.each(e.sortables,
                    function() {
                        this.instance.isOver ? (this.instance.isOver = 0, e.cancelHelperRemoval = !0, this.instance.cancelHelperRemoval = !1, this.shouldRevert && (this.instance.options.revert = !0), this.instance._mouseStop(d), this.instance.options.helper = this.instance.options._helper, e.options.helper == "original" && this.instance.currentItem.css({
                            top: "auto",
                            left: "auto"
                        })) : (this.instance.cancelHelperRemoval = !1, this.instance._trigger("deactivate", d, c))
                    })
            },
            drag: function(d, g) {
                var f = b(this).data("draggable"),
                    c = this,
                    e = function(v) {
                        var k = this.offset.click.top,
                            h = this.offset.click.left,
                            l = this.positionAbs.top,
                            w = this.positionAbs.left,
                            j = v.height,
                            q = v.width,
                            p = v.top,
                            m = v.left;
                        return b.ui.isOver(l + k, w + h, p, m, j, q)
                    };
                b.each(f.sortables,
                    function(i) {
                        var j = !1,
                            h = this;
                        this.instance.positionAbs = f.positionAbs,
                            this.instance.helperProportions = f.helperProportions,
                            this.instance.offset.click = f.offset.click,
                            this.instance._intersectsWith(this.instance.containerCache) && (j = !0, b.each(f.sortables,
                                function() {
                                    return this.instance.positionAbs = f.positionAbs,
                                        this.instance.helperProportions = f.helperProportions,
                                        this.instance.offset.click = f.offset.click,
                                        this != h && this.instance._intersectsWith(this.instance.containerCache) && b.ui.contains(h.instance.element[0], this.instance.element[0]) && (j = !1),
                                        j
                                })),
                            j ? (this.instance.isOver || (this.instance.isOver = 1, this.instance.currentItem = b(c).clone().removeAttr("id").appendTo(this.instance.element).data("sortable-item", !0), this.instance.options._helper = this.instance.options.helper, this.instance.options.helper = function() {
                                return g.helper[0]
                            },
                                d.target = this.instance.currentItem[0], this.instance._mouseCapture(d, !0), this.instance._mouseStart(d, !0, !0), this.instance.offset.click.top = f.offset.click.top, this.instance.offset.click.left = f.offset.click.left, this.instance.offset.parent.left -= f.offset.parent.left - this.instance.offset.parent.left, this.instance.offset.parent.top -= f.offset.parent.top - this.instance.offset.parent.top, f._trigger("toSortable", d), f.dropped = this.instance.element, f.currentItem = f.element, this.instance.fromOutside = f), this.instance.currentItem && this.instance._mouseDrag(d)) : this.instance.isOver && (this.instance.isOver = 0, this.instance.cancelHelperRemoval = !0, this.instance.options.revert = !1, this.instance._trigger("out", d, this.instance._uiHash(this.instance)), this.instance._mouseStop(d, !0), this.instance.options.helper = this.instance.options._helper, this.instance.currentItem.remove(), this.instance.placeholder && this.instance.placeholder.remove(), f._trigger("fromSortable", d), f.dropped = !1)
                    })
            }
        }),
        b.ui.plugin.add("draggable", "cursor", {
            start: function(d, f) {
                var e = b("body"),
                    c = b(this).data("draggable").options;
                e.css("cursor") && (c._cursor = e.css("cursor")),
                    e.css("cursor", c.cursor)
            },
            stop: function(c, e) {
                var d = b(this).data("draggable").options;
                d._cursor && b("body").css("cursor", d._cursor)
            }
        }),
        b.ui.plugin.add("draggable", "opacity", {
            start: function(d, f) {
                var e = b(f.helper),
                    c = b(this).data("draggable").options;
                e.css("opacity") && (c._opacity = e.css("opacity")),
                    e.css("opacity", c.opacity)
            },
            stop: function(c, e) {
                var d = b(this).data("draggable").options;
                d._opacity && b(e.helper).css("opacity", d._opacity)
            }
        }),
        b.ui.plugin.add("draggable", "scroll", {
            start: function(c, e) {
                var d = b(this).data("draggable");
                d.scrollParent[0] != document && d.scrollParent[0].tagName != "HTML" && (d.overflowOffset = d.scrollParent.offset())
            },
            drag: function(d, g) {
                var f = b(this).data("draggable"),
                    c = f.options,
                    e = !1;
                if (f.scrollParent[0] != document && f.scrollParent[0].tagName != "HTML") {
                    if (!c.axis || c.axis != "x") {
                        f.overflowOffset.top + f.scrollParent[0].offsetHeight - d.pageY < c.scrollSensitivity ? f.scrollParent[0].scrollTop = e = f.scrollParent[0].scrollTop + c.scrollSpeed: d.pageY - f.overflowOffset.top < c.scrollSensitivity && (f.scrollParent[0].scrollTop = e = f.scrollParent[0].scrollTop - c.scrollSpeed)
                    }
                    if (!c.axis || c.axis != "y") {
                        f.overflowOffset.left + f.scrollParent[0].offsetWidth - d.pageX < c.scrollSensitivity ? f.scrollParent[0].scrollLeft = e = f.scrollParent[0].scrollLeft + c.scrollSpeed: d.pageX - f.overflowOffset.left < c.scrollSensitivity && (f.scrollParent[0].scrollLeft = e = f.scrollParent[0].scrollLeft - c.scrollSpeed)
                    }
                } else {
                    if (!c.axis || c.axis != "x") {
                        d.pageY - b(document).scrollTop() < c.scrollSensitivity ? e = b(document).scrollTop(b(document).scrollTop() - c.scrollSpeed) : b(window).height() - (d.pageY - b(document).scrollTop()) < c.scrollSensitivity && (e = b(document).scrollTop(b(document).scrollTop() + c.scrollSpeed))
                    }
                    if (!c.axis || c.axis != "y") {
                        d.pageX - b(document).scrollLeft() < c.scrollSensitivity ? e = b(document).scrollLeft(b(document).scrollLeft() - c.scrollSpeed) : b(window).width() - (d.pageX - b(document).scrollLeft()) < c.scrollSensitivity && (e = b(document).scrollLeft(b(document).scrollLeft() + c.scrollSpeed))
                    }
                }
                e !== !1 && b.ui.ddmanager && !c.dropBehaviour && b.ui.ddmanager.prepareOffsets(f, d)
            }
        }),
        b.ui.plugin.add("draggable", "snap", {
            start: function(d, f) {
                var e = b(this).data("draggable"),
                    c = e.options;
                e.snapElements = [],
                    b(c.snap.constructor != String ? c.snap.items || ":data(draggable)": c.snap).each(function() {
                        var g = b(this),
                            h = g.offset();
                        this != e.element[0] && e.snapElements.push({
                            item: this,
                            width: g.outerWidth(),
                            height: g.outerHeight(),
                            top: h.top,
                            left: h.left
                        })
                    })
            },
            drag: function(q, B) {
                var x = b(this).data("draggable"),
                    E = x.options,
                    w = E.snapTolerance,
                    A = B.offset.left,
                    k = A + x.helperProportions.width,
                    L = B.offset.top,
                    H = L + x.helperProportions.height;
                for (var D = x.snapElements.length - 1; D >= 0; D--) {
                    var J = x.snapElements[D].left,
                        F = J + x.snapElements[D].width,
                        z = x.snapElements[D].top,
                        I = z + x.snapElements[D].height;
                    if (! (J - w < A && A < F + w && z - w < L && L < I + w || J - w < A && A < F + w && z - w < H && H < I + w || J - w < k && k < F + w && z - w < L && L < I + w || J - w < k && k < F + w && z - w < H && H < I + w)) {
                        x.snapElements[D].snapping && x.options.snap.release && x.options.snap.release.call(x.element, q, b.extend(x._uiHash(), {
                            snapItem: x.snapElements[D].item
                        })),
                            x.snapElements[D].snapping = !1;
                        continue
                    }
                    if (E.snapMode != "inner") {
                        var j = Math.abs(z - H) <= w,
                            C = Math.abs(I - L) <= w,
                            G = Math.abs(J - k) <= w,
                            e = Math.abs(F - A) <= w;
                        j && (B.position.top = x._convertPositionTo("relative", {
                            top: z - x.helperProportions.height,
                            left: 0
                        }).top - x.margins.top),
                            C && (B.position.top = x._convertPositionTo("relative", {
                                top: I,
                                left: 0
                            }).top - x.margins.top),
                            G && (B.position.left = x._convertPositionTo("relative", {
                                top: 0,
                                left: J - x.helperProportions.width
                            }).left - x.margins.left),
                            e && (B.position.left = x._convertPositionTo("relative", {
                                top: 0,
                                left: F
                            }).left - x.margins.left)
                    }
                    var K = j || C || G || e;
                    if (E.snapMode != "outer") {
                        var j = Math.abs(z - L) <= w,
                            C = Math.abs(I - H) <= w,
                            G = Math.abs(J - A) <= w,
                            e = Math.abs(F - k) <= w;
                        j && (B.position.top = x._convertPositionTo("relative", {
                            top: z,
                            left: 0
                        }).top - x.margins.top),
                            C && (B.position.top = x._convertPositionTo("relative", {
                                top: I - x.helperProportions.height,
                                left: 0
                            }).top - x.margins.top),
                            G && (B.position.left = x._convertPositionTo("relative", {
                                top: 0,
                                left: J
                            }).left - x.margins.left),
                            e && (B.position.left = x._convertPositionTo("relative", {
                                top: 0,
                                left: F - x.helperProportions.width
                            }).left - x.margins.left)
                    } ! x.snapElements[D].snapping && (j || C || G || e || K) && x.options.snap.snap && x.options.snap.snap.call(x.element, q, b.extend(x._uiHash(), {
                        snapItem: x.snapElements[D].item
                    })),
                        x.snapElements[D].snapping = j || C || G || e || K
                }
            }
        }),
        b.ui.plugin.add("draggable", "stack", {
            start: function(d, g) {
                var f = b(this).data("draggable").options,
                    c = b.makeArray(b(f.stack)).sort(function(h, i) {
                        return (parseInt(b(h).css("zIndex"), 10) || 0) - (parseInt(b(i).css("zIndex"), 10) || 0)
                    });
                if (!c.length) {
                    return
                }
                var e = parseInt(c[0].style.zIndex) || 0;
                b(c).each(function(h) {
                    this.style.zIndex = e + h
                }),
                    this[0].style.zIndex = e + c.length
            }
        }),
        b.ui.plugin.add("draggable", "zIndex", {
            start: function(d, f) {
                var e = b(f.helper),
                    c = b(this).data("draggable").options;
                e.css("zIndex") && (c._zIndex = e.css("zIndex")),
                    e.css("zIndex", c.zIndex)
            },
            stop: function(c, e) {
                var d = b(this).data("draggable").options;
                d._zIndex && b(e.helper).css("zIndex", d._zIndex)
            }
        })
})(jQuery); (function(b, a) {
    var c = 0;
    b.widget("ui.autocomplete", {
        version: "1.9.2",
        defaultElement: "<input>",
        options: {
            appendTo: "body",
            autoFocus: !1,
            delay: 300,
            minLength: 1,
            position: {
                my: "left top",
                at: "left bottom",
                collision: "none"
            },
            source: null,
            change: null,
            close: null,
            focus: null,
            open: null,
            response: null,
            search: null,
            select: null
        },
        pending: 0,
        _create: function() {
            var d, f, e;
            this.isMultiLine = this._isMultiLine(),
                this.valueMethod = this.element[this.element.is("input,textarea") ? "val": "text"],
                this.isNewMenu = !0,
                this.element.addClass("ui-autocomplete-input").attr("autocomplete", "off"),
                this._on(this.element, {
                    keydown: function(g) {
                        if (this.element.prop("readOnly")) {
                            d = !0,
                                e = !0,
                                f = !0;
                            return
                        }
                        d = !1,
                            e = !1,
                            f = !1;
                        var h = b.ui.keyCode;
                        switch (g.keyCode) {
                            case h.PAGE_UP:
                                d = !0,
                                    this._move("previousPage", g);
                                break;
                            case h.PAGE_DOWN:
                                d = !0,
                                    this._move("nextPage", g);
                                break;
                            case h.UP:
                                d = !0,
                                    this._keyEvent("previous", g);
                                break;
                            case h.DOWN:
                                d = !0,
                                    this._keyEvent("next", g);
                                break;
                            case h.ENTER:
                            case h.NUMPAD_ENTER:
                                this.menu.active && (d = !0, g.preventDefault(), this.menu.select(g));
                                break;
                            case h.TAB:
                                this.menu.active && this.menu.select(g);
                                break;
                            case h.ESCAPE:
                                this.menu.element.is(":visible") && (this._value(this.term), this.close(g), g.preventDefault());
                                break;
                            default:
                                f = !0,
                                    this._searchTimeout(g)
                        }
                    },
                    keypress: function(h) {
                        if (d) {
                            d = !1,
                                h.preventDefault();
                            return
                        }
                        if (f) {
                            return
                        }
                        var g = b.ui.keyCode;
                        switch (h.keyCode) {
                            case g.PAGE_UP:
                                this._move("previousPage", h);
                                break;
                            case g.PAGE_DOWN:
                                this._move("nextPage", h);
                                break;
                            case g.UP:
                                this._keyEvent("previous", h);
                                break;
                            case g.DOWN:
                                this._keyEvent("next", h)
                        }
                    },
                    input: function(g) {
                        if (e) {
                            e = !1,
                                g.preventDefault();
                            return
                        }
                        this._searchTimeout(g)
                    },
                    focus: function() {
                        this.selectedItem = null,
                            this.previous = this._value()
                    },
                    blur: function(g) {
                        if (this.cancelBlur) {
                            delete this.cancelBlur;
                            return
                        }
                        clearTimeout(this.searching),
                            this.close(g),
                            this._change(g)
                    }
                }),
                this._initSource(),
                this.menu = b("<ul>").addClass("ui-autocomplete").appendTo(this.document.find(this.options.appendTo || "body")[0]).menu({
                    input: b(),
                    role: null
                }).zIndex(this.element.zIndex() + 1).hide().data("menu"),
                this._on(this.menu.element, {
                    mousedown: function(g) {
                        g.preventDefault(),
                            this.cancelBlur = !0,
                            this._delay(function() {
                                delete this.cancelBlur
                            });
                        var h = this.menu.element[0];
                        b(g.target).closest(".ui-menu-item").length || this._delay(function() {
                            var i = this;
                            this.document.one("mousedown",
                                function(j) {
                                    j.target !== i.element[0] && j.target !== h && !b.contains(h, j.target) && i.close()
                                })
                        })
                    },
                    menufocus: function(g, i) {
                        if (this.isNewMenu) {
                            this.isNewMenu = !1;
                            if (g.originalEvent && /^mouse/.test(g.originalEvent.type)) {
                                this.menu.blur(),
                                    this.document.one("mousemove",
                                        function() {
                                            b(g.target).trigger(g.originalEvent)
                                        });
                                return
                            }
                        }
                        var h = i.item.data("ui-autocomplete-item") || i.item.data("item.autocomplete"); ! 1 !== this._trigger("focus", g, {
                            item: h
                        }) ? g.originalEvent && /^key/.test(g.originalEvent.type) && this._value(h.value) : this.liveRegion.text(h.value)
                    },
                    menuselect: function(i, g) {
                        var j = g.item.data("ui-autocomplete-item") || g.item.data("item.autocomplete"),
                            h = this.previous;
                        this.element[0] !== this.document[0].activeElement && (this.element.focus(), this.previous = h, this._delay(function() {
                            this.previous = h,
                                this.selectedItem = j
                        })),
                            !1 !== this._trigger("select", i, {
                                item: j
                            }) && this._value(j.value),
                            this.term = this._value(),
                            this.close(i),
                            this.selectedItem = j
                    }
                }),
                this.liveRegion = b("<span>", {
                    role: "status",
                    "aria-live": "polite"
                }).addClass("ui-helper-hidden-accessible").insertAfter(this.element),
                b.fn.bgiframe && this.menu.element.bgiframe(),
                this._on(this.window, {
                    beforeunload: function() {
                        this.element.removeAttr("autocomplete")
                    }
                })
        },
        _destroy: function() {
            clearTimeout(this.searching),
                this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete"),
                this.menu.element.remove(),
                this.liveRegion.remove()
        },
        _setOption: function(f, d) {
            this._super(f, d),
                f === "source" && this._initSource(),
                f === "appendTo" && this.menu.element.appendTo(this.document.find(d || "body")[0]),
                f === "disabled" && d && this.xhr && this.xhr.abort()
        },
        _isMultiLine: function() {
            return this.element.is("textarea") ? !0 : this.element.is("input") ? !1 : this.element.prop("isContentEditable")
        },
        _initSource: function() {
            var d, f, e = this;
            b.isArray(this.options.source) ? (d = this.options.source, this.source = function(h, g) {
                g(b.ui.autocomplete.filter(d, h.term))
            }) : typeof this.options.source == "string" ? (f = this.options.source, this.source = function(h, g) {
                e.xhr && e.xhr.abort(),
                    e.xhr = b.ajax({
                        url: f,
                        data: h,
                        dataType: "json",
                        success: function(i) {
                            g(i)
                        },
                        error: function() {
                            g([])
                        }
                    })
            }) : this.source = this.options.source
        },
        _searchTimeout: function(d) {
            clearTimeout(this.searching),
                this.searching = this._delay(function() {
                        this.term !== this._value() && (this.selectedItem = null, this.search(null, d))
                    },
                    this.options.delay)
        },
        search: function(f, d) {
            f = f != null ? f: this._value(),
                this.term = this._value();
            if (f.length < this.options.minLength) {
                return this.close(d)
            }
            if (this._trigger("search", d) === !1) {
                return
            }
            return this._search(f)
        },
        _search: function(d) {
            this.pending++,
                this.element.addClass("ui-autocomplete-loading"),
                this.cancelSearch = !1,
                this.source({
                        term: d
                    },
                    this._response())
        },
        _response: function() {
            var f = this,
                d = ++c;
            return function(e) {
                d === c && f.__response(e),
                    f.pending--,
                    f.pending || f.element.removeClass("ui-autocomplete-loading")
            }
        },
        __response: function(d) {
            d && (d = this._normalize(d)),
                this._trigger("response", null, {
                    content: d
                }),
                !this.options.disabled && d && d.length && !this.cancelSearch ? (this._suggest(d), this._trigger("open")) : this._close()
        },
        close: function(d) {
            this.cancelSearch = !0,
                this._close(d)
        },
        _close: function(d) {
            this.menu.element.is(":visible") && (this.menu.element.hide(), this.menu.blur(), this.isNewMenu = !0, this._trigger("close", d))
        },
        _change: function(d) {
            this.previous !== this._value() && this._trigger("change", d, {
                item: this.selectedItem
            })
        },
        _normalize: function(d) {
            return d.length && d[0].label && d[0].value ? d: b.map(d,
                function(e) {
                    return typeof e == "string" ? {
                        label: e,
                        value: e
                    }: b.extend({
                            label: e.label || e.value,
                            value: e.value || e.label
                        },
                        e)
                })
        },
        _suggest: function(d) {
            var e = this.menu.element.empty().zIndex(this.element.zIndex() + 1);
            this._renderMenu(e, d),
                this.menu.refresh(),
                e.show(),
                this._resizeMenu(),
                e.position(b.extend({
                        of: this.element
                    },
                    this.options.position)),
                this.options.autoFocus && this.menu.next()
        },
        _resizeMenu: function() {
            var d = this.menu.element;
            d.outerWidth(Math.max(d.width("").outerWidth() + 1, this.element.outerWidth()))
        },
        _renderMenu: function(d, f) {
            var e = this;
            b.each(f,
                function(g, h) {
                    e._renderItemData(d, h)
                })
        },
        _renderItemData: function(f, d) {
            return this._renderItem(f, d).data("ui-autocomplete-item", d)
        },
        _renderItem: function(d, e) {
            return b("<li>").append(b("<a>").text(e.label)).appendTo(d)
        },
        _move: function(f, d) {
            if (!this.menu.element.is(":visible")) {
                this.search(null, d);
                return
            }
            if (this.menu.isFirstItem() && /^previous/.test(f) || this.menu.isLastItem() && /^next/.test(f)) {
                this._value(this.term),
                    this.menu.blur();
                return
            }
            this.menu[f](d)
        },
        widget: function() {
            return this.menu.element
        },
        _value: function() {
            return this.valueMethod.apply(this.element, arguments)
        },
        _keyEvent: function(f, d) {
            if (!this.isMultiLine || this.menu.element.is(":visible")) {
                this._move(f, d),
                    d.preventDefault()
            }
        }
    }),
        b.extend(b.ui.autocomplete, {
            escapeRegex: function(d) {
                return d.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            },
            filter: function(d, f) {
                var e = new RegExp(b.ui.autocomplete.escapeRegex(f), "i");
                return b.grep(d,
                    function(g) {
                        return e.test(g.label || g.value || g)
                    })
            }
        }),
        b.widget("ui.autocomplete", b.ui.autocomplete, {
            options: {
                messages: {
                    noResults: "No search results.",
                    results: function(d) {
                        return d + (d > 1 ? " results are": " result is") + " available, use up and down arrow keys to navigate."
                    }
                }
            },
            __response: function(f) {
                var d;
                this._superApply(arguments);
                if (this.options.disabled || this.cancelSearch) {
                    return
                }
                f && f.length ? d = this.options.messages.results(f.length) : d = this.options.messages.noResults,
                    this.liveRegion.text(d)
            }
        })
})(jQuery); (function(b, a) {
    var c = !1;
    b.widget("ui.menu", {
        version: "1.9.2",
        defaultElement: "<ul>",
        delay: 300,
        options: {
            icons: {
                submenu: "ui-icon-carat-1-e"
            },
            menus: "ul",
            position: {
                my: "left top",
                at: "right top"
            },
            role: "menu",
            blur: null,
            focus: null,
            select: null
        },
        _create: function() {
            this.activeMenu = this.element,
                this.element.uniqueId().addClass("ui-menu ui-widget ui-widget-content ui-corner-all").toggleClass("ui-menu-icons", !!this.element.find(".ui-icon").length).attr({
                    role: this.options.role,
                    tabIndex: 0
                }).bind("click" + this.eventNamespace, b.proxy(function(d) {
                            this.options.disabled && d.preventDefault()
                        },
                        this)),
                this.options.disabled && this.element.addClass("ui-state-disabled").attr("aria-disabled", "true"),
                this._on({
                    "mousedown .ui-menu-item > a": function(d) {
                        d.preventDefault()
                    },
                    "click .ui-state-disabled > a": function(d) {
                        d.preventDefault()
                    },
                    "click .ui-menu-item:has(a)": function(d) {
                        var e = b(d.target).closest(".ui-menu-item"); ! c && e.not(".ui-state-disabled").length && (c = !0, this.select(d), e.has(".ui-menu").length ? this.expand(d) : this.element.is(":focus") || (this.element.trigger("focus", [!0]), this.active && this.active.parents(".ui-menu").length === 1 && clearTimeout(this.timer)))
                    },
                    "mouseenter .ui-menu-item": function(d) {
                        var e = b(d.currentTarget);
                        e.siblings().children(".ui-state-active").removeClass("ui-state-active"),
                            this.focus(d, e)
                    },
                    mouseleave: "collapseAll",
                    "mouseleave .ui-menu": "collapseAll",
                    focus: function(f, d) {
                        var g = this.active || this.element.children(".ui-menu-item").eq(0);
                        d || this.focus(f, g)
                    },
                    blur: function(d) {
                        this._delay(function() {
                            b.contains(this.element[0], this.document[0].activeElement) || this.collapseAll(d)
                        })
                    },
                    keydown: "_keydown"
                }),
                this.refresh(),
                this._on(this.document, {
                    click: function(d) {
                        b(d.target).closest(".ui-menu").length || this.collapseAll(d),
                            c = !1
                    }
                })
        },
        _destroy: function() {
            this.element.removeAttr("aria-activedescendant").find(".ui-menu").andSelf().removeClass("ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons").removeAttr("role").removeAttr("tabIndex").removeAttr("aria-labelledby").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-disabled").removeUniqueId().show(),
                this.element.find(".ui-menu-item").removeClass("ui-menu-item").removeAttr("role").removeAttr("aria-disabled").children("a").removeUniqueId().removeClass("ui-corner-all ui-state-hover").removeAttr("tabIndex").removeAttr("role").removeAttr("aria-haspopup").children().each(function() {
                    var d = b(this);
                    d.data("ui-menu-submenu-carat") && d.remove()
                }),
                this.element.find(".ui-menu-divider").removeClass("ui-menu-divider ui-widget-content")
        },
        _keydown: function(g) {
            function d(i) {
                return i.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            }
            var l, j, f, h, k, e = !0;
            switch (g.keyCode) {
                case b.ui.keyCode.PAGE_UP:
                    this.previousPage(g);
                    break;
                case b.ui.keyCode.PAGE_DOWN:
                    this.nextPage(g);
                    break;
                case b.ui.keyCode.HOME:
                    this._move("first", "first", g);
                    break;
                case b.ui.keyCode.END:
                    this._move("last", "last", g);
                    break;
                case b.ui.keyCode.UP:
                    this.previous(g);
                    break;
                case b.ui.keyCode.DOWN:
                    this.next(g);
                    break;
                case b.ui.keyCode.LEFT:
                    this.collapse(g);
                    break;
                case b.ui.keyCode.RIGHT:
                    this.active && !this.active.is(".ui-state-disabled") && this.expand(g);
                    break;
                case b.ui.keyCode.ENTER:
                case b.ui.keyCode.SPACE:
                    this._activate(g);
                    break;
                case b.ui.keyCode.ESCAPE:
                    this.collapse(g);
                    break;
                default:
                    e = !1,
                        j = this.previousFilter || "",
                        f = String.fromCharCode(g.keyCode),
                        h = !1,
                        clearTimeout(this.filterTimer),
                        f === j ? h = !0 : f = j + f,
                        k = new RegExp("^" + d(f), "i"),
                        l = this.activeMenu.children(".ui-menu-item").filter(function() {
                            return k.test(b(this).children("a").text())
                        }),
                        l = h && l.index(this.active.next()) !== -1 ? this.active.nextAll(".ui-menu-item") : l,
                        l.length || (f = String.fromCharCode(g.keyCode), k = new RegExp("^" + d(f), "i"), l = this.activeMenu.children(".ui-menu-item").filter(function() {
                            return k.test(b(this).children("a").text())
                        })),
                        l.length ? (this.focus(g, l), l.length > 1 ? (this.previousFilter = f, this.filterTimer = this._delay(function() {
                                delete this.previousFilter
                            },
                            1000)) : delete this.previousFilter) : delete this.previousFilter
            }
            e && g.preventDefault()
        },
        _activate: function(d) {
            this.active.is(".ui-state-disabled") || (this.active.children("a[aria-haspopup='true']").length ? this.expand(d) : this.select(d))
        },
        refresh: function() {
            var d, f = this.options.icons.submenu,
                e = this.element.find(this.options.menus);
            e.filter(":not(.ui-menu)").addClass("ui-menu ui-widget ui-widget-content ui-corner-all").hide().attr({
                role: this.options.role,
                "aria-hidden": "true",
                "aria-expanded": "false"
            }).each(function() {
                    var h = b(this),
                        j = h.prev("a"),
                        g = b("<span>").addClass("ui-menu-icon ui-icon " + f).data("ui-menu-submenu-carat", !0);
                    j.attr("aria-haspopup", "true").prepend(g),
                        h.attr("aria-labelledby", j.attr("id"))
                }),
                d = e.add(this.element),
                d.children(":not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role", "presentation").children("a").uniqueId().addClass("ui-corner-all").attr({
                    tabIndex: -1,
                    role: this._itemRole()
                }),
                d.children(":not(.ui-menu-item)").each(function() {
                    var g = b(this);
                    /[^\-—–\s]/.test(g.text()) || g.addClass("ui-widget-content ui-menu-divider")
                }),
                d.children(".ui-state-disabled").attr("aria-disabled", "true"),
                this.active && !b.contains(this.element[0], this.active[0]) && this.blur()
        },
        _itemRole: function() {
            return {
                menu: "menuitem",
                listbox: "option"
            } [this.options.role]
        },
        focus: function(g, d) {
            var h, f;
            this.blur(g, g && g.type === "focus"),
                this._scrollIntoView(d),
                this.active = d.first(),
                f = this.active.children("a").addClass("ui-state-focus"),
                this.options.role && this.element.attr("aria-activedescendant", f.attr("id")),
                this.active.parent().closest(".ui-menu-item").children("a:first").addClass("ui-state-active"),
                g && g.type === "keydown" ? this._close() : this.timer = this._delay(function() {
                        this._close()
                    },
                    this.delay),
                h = d.children(".ui-menu"),
                h.length && /^mouse/.test(g.type) && this._startOpening(h),
                this.activeMenu = d.parent(),
                this._trigger("focus", g, {
                    item: d
                })
        },
        _scrollIntoView: function(f) {
            var k, h, e, g, j, d;
            this._hasScroll() && (k = parseFloat(b.css(this.activeMenu[0], "borderTopWidth")) || 0, h = parseFloat(b.css(this.activeMenu[0], "paddingTop")) || 0, e = f.offset().top - this.activeMenu.offset().top - k - h, g = this.activeMenu.scrollTop(), j = this.activeMenu.height(), d = f.height(), e < 0 ? this.activeMenu.scrollTop(g + e) : e + d > j && this.activeMenu.scrollTop(g + e - j + d))
        },
        blur: function(f, d) {
            d || clearTimeout(this.timer);
            if (!this.active) {
                return
            }
            this.active.children("a").removeClass("ui-state-focus"),
                this.active = null,
                this._trigger("blur", f, {
                    item: this.active
                })
        },
        _startOpening: function(d) {
            clearTimeout(this.timer);
            if (d.attr("aria-hidden") !== "true") {
                return
            }
            this.timer = this._delay(function() {
                    this._close(),
                        this._open(d)
                },
                this.delay)
        },
        _open: function(d) {
            var e = b.extend({
                    of: this.active
                },
                this.options.position);
            clearTimeout(this.timer),
                this.element.find(".ui-menu").not(d.parents(".ui-menu")).hide().attr("aria-hidden", "true"),
                d.show().removeAttr("aria-hidden").attr("aria-expanded", "true").position(e)
        },
        collapseAll: function(d, e) {
            clearTimeout(this.timer),
                this.timer = this._delay(function() {
                        var f = e ? this.element: b(d && d.target).closest(this.element.find(".ui-menu"));
                        f.length || (f = this.element),
                            this._close(f),
                            this.blur(d),
                            this.activeMenu = f
                    },
                    this.delay)
        },
        _close: function(d) {
            d || (d = this.active ? this.active.parent() : this.element),
                d.find(".ui-menu").hide().attr("aria-hidden", "true").attr("aria-expanded", "false").end().find("a.ui-state-active").removeClass("ui-state-active")
        },
        collapse: function(f) {
            var d = this.active && this.active.parent().closest(".ui-menu-item", this.element);
            d && d.length && (this._close(), this.focus(f, d))
        },
        expand: function(f) {
            var d = this.active && this.active.children(".ui-menu ").children(".ui-menu-item").first();
            d && d.length && (this._open(d.parent()), this._delay(function() {
                this.focus(f, d)
            }))
        },
        next: function(d) {
            this._move("next", "first", d)
        },
        previous: function(d) {
            this._move("prev", "last", d)
        },
        isFirstItem: function() {
            return this.active && !this.active.prevAll(".ui-menu-item").length
        },
        isLastItem: function() {
            return this.active && !this.active.nextAll(".ui-menu-item").length
        },
        _move: function(g, d, h) {
            var f;
            this.active && (g === "first" || g === "last" ? f = this.active[g === "first" ? "prevAll": "nextAll"](".ui-menu-item").eq( - 1) : f = this.active[g + "All"](".ui-menu-item").eq(0));
            if (!f || !f.length || !this.active) {
                f = this.activeMenu.children(".ui-menu-item")[d]()
            }
            this.focus(h, f)
        },
        nextPage: function(e) {
            var g, f, d;
            if (!this.active) {
                this.next(e);
                return
            }
            if (this.isLastItem()) {
                return
            }
            this._hasScroll() ? (f = this.active.offset().top, d = this.element.height(), this.active.nextAll(".ui-menu-item").each(function() {
                return g = b(this),
                    g.offset().top - f - d < 0
            }), this.focus(e, g)) : this.focus(e, this.activeMenu.children(".ui-menu-item")[this.active ? "last": "first"]())
        },
        previousPage: function(e) {
            var g, f, d;
            if (!this.active) {
                this.next(e);
                return
            }
            if (this.isFirstItem()) {
                return
            }
            this._hasScroll() ? (f = this.active.offset().top, d = this.element.height(), this.active.prevAll(".ui-menu-item").each(function() {
                return g = b(this),
                    g.offset().top - f + d > 0
            }), this.focus(e, g)) : this.focus(e, this.activeMenu.children(".ui-menu-item").first())
        },
        _hasScroll: function() {
            return this.element.outerHeight() < this.element.prop("scrollHeight")
        },
        select: function(d) {
            this.active = this.active || b(d.target).closest(".ui-menu-item");
            var e = {
                item: this.active
            };
            this.active.has(".ui-menu").length || this.collapseAll(d, !0),
                this._trigger("select", d, e)
        }
    })
})(jQuery); (function(b, a) {
    var c = 5;
    b.widget("ui.slider", b.ui.mouse, {
        version: "1.9.2",
        widgetEventPrefix: "slide",
        options: {
            animate: !1,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: !1,
            step: 1,
            value: 0,
            values: null
        },
        _create: function() {
            var f, h, e = this.options,
                g = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),
                j = "<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>",
                d = [];
            this._keySliding = !1,
                this._mouseSliding = !1,
                this._animateOff = !0,
                this._handleIndex = null,
                this._detectOrientation(),
                this._mouseInit(),
                this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget ui-widget-content ui-corner-all" + (e.disabled ? " ui-slider-disabled ui-disabled": "")),
                this.range = b([]),
                e.range && (e.range === !0 && (e.values || (e.values = [this._valueMin(), this._valueMin()]), e.values.length && e.values.length !== 2 && (e.values = [e.values[0], e.values[0]])), this.range = b("<div></div>").appendTo(this.element).addClass("ui-slider-range ui-widget-header" + (e.range === "min" || e.range === "max" ? " ui-slider-range-" + e.range: ""))),
                h = e.values && e.values.length || 1;
            for (f = g.length; f < h; f++) {
                d.push(j)
            }
            this.handles = g.add(b(d.join("")).appendTo(this.element)),
                this.handle = this.handles.eq(0),
                this.handles.add(this.range).filter("a").click(function(i) {
                    i.preventDefault()
                }).mouseenter(function() {
                        e.disabled || b(this).addClass("ui-state-hover")
                    }).mouseleave(function() {
                        b(this).removeClass("ui-state-hover")
                    }).focus(function() {
                        e.disabled ? b(this).blur() : (b(".ui-slider .ui-state-focus").removeClass("ui-state-focus"), b(this).addClass("ui-state-focus"))
                    }).blur(function() {
                        b(this).removeClass("ui-state-focus")
                    }),
                this.handles.each(function(i) {
                    b(this).data("ui-slider-handle-index", i)
                }),
                this._on(this.handles, {
                    keydown: function(m) {
                        var p, l, n, q, k = b(m.target).data("ui-slider-handle-index");
                        switch (m.keyCode) {
                            case b.ui.keyCode.HOME:
                            case b.ui.keyCode.END:
                            case b.ui.keyCode.PAGE_UP:
                            case b.ui.keyCode.PAGE_DOWN:
                            case b.ui.keyCode.UP:
                            case b.ui.keyCode.RIGHT:
                            case b.ui.keyCode.DOWN:
                            case b.ui.keyCode.LEFT:
                                m.preventDefault();
                                if (!this._keySliding) {
                                    this._keySliding = !0,
                                        b(m.target).addClass("ui-state-active"),
                                        p = this._start(m, k);
                                    if (p === !1) {
                                        return
                                    }
                                }
                        }
                        q = this.options.step,
                            this.options.values && this.options.values.length ? l = n = this.values(k) : l = n = this.value();
                        switch (m.keyCode) {
                            case b.ui.keyCode.HOME:
                                n = this._valueMin();
                                break;
                            case b.ui.keyCode.END:
                                n = this._valueMax();
                                break;
                            case b.ui.keyCode.PAGE_UP:
                                n = this._trimAlignValue(l + (this._valueMax() - this._valueMin()) / c);
                                break;
                            case b.ui.keyCode.PAGE_DOWN:
                                n = this._trimAlignValue(l - (this._valueMax() - this._valueMin()) / c);
                                break;
                            case b.ui.keyCode.UP:
                            case b.ui.keyCode.RIGHT:
                                if (l === this._valueMax()) {
                                    return
                                }
                                n = this._trimAlignValue(l + q);
                                break;
                            case b.ui.keyCode.DOWN:
                            case b.ui.keyCode.LEFT:
                                if (l === this._valueMin()) {
                                    return
                                }
                                n = this._trimAlignValue(l - q)
                        }
                        this._slide(m, k, n)
                    },
                    keyup: function(i) {
                        var k = b(i.target).data("ui-slider-handle-index");
                        this._keySliding && (this._keySliding = !1, this._stop(i, k), this._change(i, k), b(i.target).removeClass("ui-state-active"))
                    }
                }),
                this._refreshValue(),
                this._animateOff = !1
        },
        _destroy: function() {
            this.handles.remove(),
                this.range.remove(),
                this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all"),
                this._mouseDestroy()
        },
        _mouseCapture: function(v) {
            var g, d, j, w, e, q, p, k, h = this,
                m = this.options;
            return m.disabled ? !1 : (this.elementSize = {
                width: this.element.outerWidth(),
                height: this.element.outerHeight()
            },
                this.elementOffset = this.element.offset(), g = {
                x: v.pageX,
                y: v.pageY
            },
                d = this._normValueFromMouse(g), j = this._valueMax() - this._valueMin() + 1, this.handles.each(function(f) {
                var i = Math.abs(d - h.values(f));
                j > i && (j = i, w = b(this), e = f)
            }), m.range === !0 && this.values(1) === m.min && (e += 1, w = b(this.handles[e])), q = this._start(v, e), q === !1 ? !1 : (this._mouseSliding = !0, this._handleIndex = e, w.addClass("ui-state-active").focus(), p = w.offset(), k = !b(v.target).parents().andSelf().is(".ui-slider-handle"), this._clickOffset = k ? {
                left: 0,
                top: 0
            }: {
                left: v.pageX - p.left - w.width() / 2,
                top: v.pageY - p.top - w.height() / 2 - (parseInt(w.css("borderTopWidth"), 10) || 0) - (parseInt(w.css("borderBottomWidth"), 10) || 0) + (parseInt(w.css("marginTop"), 10) || 0)
            },
                this.handles.hasClass("ui-state-hover") || this._slide(v, e, d), this._animateOff = !0, !0))
        },
        _mouseStart: function() {
            return ! 0
        },
        _mouseDrag: function(f) {
            var d = {
                    x: f.pageX,
                    y: f.pageY
                },
                g = this._normValueFromMouse(d);
            return this._slide(f, this._handleIndex, g),
                !1
        },
        _mouseStop: function(d) {
            return this.handles.removeClass("ui-state-active"),
                this._mouseSliding = !1,
                this._stop(d, this._handleIndex),
                this._change(d, this._handleIndex),
                this._handleIndex = null,
                this._clickOffset = null,
                this._animateOff = !1,
                !1
        },
        _detectOrientation: function() {
            this.orientation = this.options.orientation === "vertical" ? "vertical": "horizontal"
        },
        _normValueFromMouse: function(j) {
            var f, k, h, d, g;
            return this.orientation === "horizontal" ? (f = this.elementSize.width, k = j.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left: 0)) : (f = this.elementSize.height, k = j.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top: 0)),
                h = k / f,
                h > 1 && (h = 1),
                h < 0 && (h = 0),
                this.orientation === "vertical" && (h = 1 - h),
                d = this._valueMax() - this._valueMin(),
                g = this._valueMin() + h * d,
                this._trimAlignValue(g)
        },
        _start: function(f, d) {
            var g = {
                handle: this.handles[d],
                value: this.value()
            };
            return this.options.values && this.options.values.length && (g.value = this.values(d), g.values = this.values()),
                this._trigger("start", f, g)
        },
        _slide: function(j, f, k) {
            var h, d, g;
            this.options.values && this.options.values.length ? (h = this.values(f ? 0 : 1), this.options.values.length === 2 && this.options.range === !0 && (f === 0 && k > h || f === 1 && k < h) && (k = h), k !== this.values(f) && (d = this.values(), d[f] = k, g = this._trigger("slide", j, {
                handle: this.handles[f],
                value: k,
                values: d
            }), h = this.values(f ? 0 : 1), g !== !1 && this.values(f, k, !0))) : k !== this.value() && (g = this._trigger("slide", j, {
                handle: this.handles[f],
                value: k
            }), g !== !1 && this.value(k))
        },
        _stop: function(f, d) {
            var g = {
                handle: this.handles[d],
                value: this.value()
            };
            this.options.values && this.options.values.length && (g.value = this.values(d), g.values = this.values()),
                this._trigger("stop", f, g)
        },
        _change: function(f, d) {
            if (!this._keySliding && !this._mouseSliding) {
                var g = {
                    handle: this.handles[d],
                    value: this.value()
                };
                this.options.values && this.options.values.length && (g.value = this.values(d), g.values = this.values()),
                    this._trigger("change", f, g)
            }
        },
        value: function(d) {
            if (arguments.length) {
                this.options.value = this._trimAlignValue(d),
                    this._refreshValue(),
                    this._change(null, 0);
                return
            }
            return this._value()
        },
        values: function(e, h) {
            var g, d, f;
            if (arguments.length > 1) {
                this.options.values[e] = this._trimAlignValue(h),
                    this._refreshValue(),
                    this._change(null, e);
                return
            }
            if (!arguments.length) {
                return this._values()
            }
            if (!b.isArray(arguments[0])) {
                return this.options.values && this.options.values.length ? this._values(e) : this.value()
            }
            g = this.options.values,
                d = arguments[0];
            for (f = 0; f < g.length; f += 1) {
                g[f] = this._trimAlignValue(d[f]),
                    this._change(null, f)
            }
            this._refreshValue()
        },
        _setOption: function(e, g) {
            var f, d = 0;
            b.isArray(this.options.values) && (d = this.options.values.length),
                b.Widget.prototype._setOption.apply(this, arguments);
            switch (e) {
                case "disabled":
                    g ? (this.handles.filter(".ui-state-focus").blur(), this.handles.removeClass("ui-state-hover"), this.handles.prop("disabled", !0), this.element.addClass("ui-disabled")) : (this.handles.prop("disabled", !1), this.element.removeClass("ui-disabled"));
                    break;
                case "orientation":
                    this._detectOrientation(),
                        this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation),
                        this._refreshValue();
                    break;
                case "value":
                    this._animateOff = !0,
                        this._refreshValue(),
                        this._change(null, 0),
                        this._animateOff = !1;
                    break;
                case "values":
                    this._animateOff = !0,
                        this._refreshValue();
                    for (f = 0; f < d; f += 1) {
                        this._change(null, f)
                    }
                    this._animateOff = !1;
                    break;
                case "min":
                case "max":
                    this._animateOff = !0,
                        this._refreshValue(),
                        this._animateOff = !1
            }
        },
        _value: function() {
            var d = this.options.value;
            return d = this._trimAlignValue(d),
                d
        },
        _values: function(g) {
            var d, h, f;
            if (arguments.length) {
                return d = this.options.values[g],
                    d = this._trimAlignValue(d),
                    d
            }
            h = this.options.values.slice();
            for (f = 0; f < h.length; f += 1) {
                h[f] = this._trimAlignValue(h[f])
            }
            return h
        },
        _trimAlignValue: function(g) {
            if (g <= this._valueMin()) {
                return this._valueMin()
            }
            if (g >= this._valueMax()) {
                return this._valueMax()
            }
            var d = this.options.step > 0 ? this.options.step: 1,
                h = (g - this._valueMin()) % d,
                f = g - h;
            return Math.abs(h) * 2 >= d && (f += h > 0 ? d: -d),
                parseFloat(f.toFixed(5))
        },
        _valueMin: function() {
            return this.options.min
        },
        _valueMax: function() {
            return this.options.max
        },
        _refreshValue: function() {
            var q, g, d, j, v, e = this.options.range,
                p = this.options,
                m = this,
                k = this._animateOff ? !1 : p.animate,
                h = {};
            this.options.values && this.options.values.length ? this.handles.each(function(f) {
                g = (m.values(f) - m._valueMin()) / (m._valueMax() - m._valueMin()) * 100,
                    h[m.orientation === "horizontal" ? "left": "bottom"] = g + "%",
                    b(this).stop(1, 1)[k ? "animate": "css"](h, p.animate),
                    m.options.range === !0 && (m.orientation === "horizontal" ? (f === 0 && m.range.stop(1, 1)[k ? "animate": "css"]({
                            left: g + "%"
                        },
                        p.animate), f === 1 && m.range[k ? "animate": "css"]({
                            width: g - q + "%"
                        },
                        {
                            queue: !1,
                            duration: p.animate
                        })) : (f === 0 && m.range.stop(1, 1)[k ? "animate": "css"]({
                            bottom: g + "%"
                        },
                        p.animate), f === 1 && m.range[k ? "animate": "css"]({
                            height: g - q + "%"
                        },
                        {
                            queue: !1,
                            duration: p.animate
                        }))),
                    q = g
            }) : (d = this.value(), j = this._valueMin(), v = this._valueMax(), g = v !== j ? (d - j) / (v - j) * 100 : 0, h[this.orientation === "horizontal" ? "left": "bottom"] = g + "%", this.handle.stop(1, 1)[k ? "animate": "css"](h, p.animate), e === "min" && this.orientation === "horizontal" && this.range.stop(1, 1)[k ? "animate": "css"]({
                    width: g + "%"
                },
                p.animate), e === "max" && this.orientation === "horizontal" && this.range[k ? "animate": "css"]({
                    width: 100 - g + "%"
                },
                {
                    queue: !1,
                    duration: p.animate
                }), e === "min" && this.orientation === "vertical" && this.range.stop(1, 1)[k ? "animate": "css"]({
                    height: g + "%"
                },
                p.animate), e === "max" && this.orientation === "vertical" && this.range[k ? "animate": "css"]({
                    height: 100 - g + "%"
                },
                {
                    queue: !1,
                    duration: p.animate
                }))
        }
    })
})(jQuery);
/*! http://mths.be/placeholder v2.0.7 by @mathias */
(function(r, p, n) {
    var w = "placeholder" in p.createElement("input"),
        t = "placeholder" in p.createElement("textarea"),
        o = n.fn,
        u = n.valHooks,
        l,
        m;
    if (w && t) {
        m = o.placeholder = function() {
            return this
        };
        m.input = m.textarea = true
    } else {
        m = o.placeholder = function() {
            var a = this;
            a.filter((w ? "textarea": ":input") + "[placeholder]").not(".placeholder").bind({
                "focus.placeholder": v,
                "blur.placeholder": s
            }).data("placeholder-enabled", true).trigger("blur.placeholder");
            return a
        };
        m.input = w;
        m.textarea = t;
        l = {
            get: function(a) {
                var b = n(a);
                return b.data("placeholder-enabled") && b.hasClass("placeholder") ? "": a.value
            },
            set: function(a, c) {
                var b = n(a);
                if (!b.data("placeholder-enabled")) {
                    return a.value = c
                }
                if (c == "") {
                    a.value = c;
                    if (a != p.activeElement) {
                        s.call(a)
                    }
                } else {
                    if (b.hasClass("placeholder")) {
                        v.call(a, true, c) || (a.value = c)
                    } else {
                        a.value = c
                    }
                }
                return b
            }
        };
        w || (u.input = l);
        t || (u.textarea = l);
        n(function() {
            n(p).delegate("form", "submit.placeholder",
                function() {
                    var a = n(".placeholder", this).each(v);
                    setTimeout(function() {
                            a.each(s)
                        },
                        10)
                })
        });
        n(r).bind("beforeunload.placeholder",
            function() {
                n(".placeholder").each(function() {
                    this.value = ""
                })
            })
    }
    function q(a) {
        var b = {},
            c = /^jQuery\d+$/;
        n.each(a.attributes,
            function(d, e) {
                if (e.specified && !c.test(e.name)) {
                    b[e.name] = e.value
                }
            });
        return b
    }
    function v(a, d) {
        var b = this,
            c = n(b);
        if (b.value == c.attr("placeholder") && c.hasClass("placeholder")) {
            if (c.data("placeholder-password")) {
                c = c.hide().next().show().attr("id", c.removeAttr("id").data("placeholder-id"));
                if (a === true) {
                    return c[0].value = d
                }
                c.focus()
            } else {
                b.value = "";
                c.removeClass("placeholder");
                b == p.activeElement && b.select()
            }
        }
    }
    function s() {
        var c, b = this,
            d = n(b),
            a = d,
            e = this.id;
        if (b.value == "") {
            if (b.type == "password") {
                if (!d.data("placeholder-textinput")) {
                    try {
                        c = d.clone().attr({
                            type: "text"
                        })
                    } catch(f) {
                        c = n("<input>").attr(n.extend(q(this), {
                            type: "text"
                        }))
                    }
                    c.removeAttr("name").data({
                        "placeholder-password": true,
                        "placeholder-id": e
                    }).bind("focus.placeholder", v);
                    d.data({
                        "placeholder-textinput": c,
                        "placeholder-id": e
                    }).before(c)
                }
                d = d.removeAttr("id").hide().prev().attr("id", e).show()
            }
            d.addClass("placeholder");
            d[0].value = d.attr("placeholder")
        } else {
            d.removeClass("placeholder")
        }
    }
} (this, document, jQuery)); (function(d) {
    var a = d("html");
    var e = false;
    var f = {};
    var g = [];
    function b(k) {
        d.each(f,
            function(l, m) {
                if (!i(l, g)) {
                    m.dom.parent(".eleme_dropdown").removeClass("open");
                    if (m.fnHide) {
                        m.fnHide()
                    }
                    delete f[l]
                }
            });
        g = [];
        if (!h(f)) {
            a.unbind("click", b);
            e = false
        }
    }
    function c(m, n, k) {
        var l = m.data("__rsiId") || j();
        if (!m.data("__rsiId")) {
            m.data("__rsiId", l)
        } else {
            if (f[l]) {
                return
            }
        }
        f[l] = {
            dom: m,
            fnShow: n,
            fnHide: k
        };
        g.push(l);
        if (!m.data("__rsiEvent")) {
            m.bind("click",
                function() {
                    g.push(d(this).data("__rsiId"))
                });
            m.data("__rsiEvent", true)
        }
        m.parent(".eleme_dropdown").addClass("open");
        if (n) {
            n()
        }
        if (h(f) && !e) {
            a.bind("click", b);
            e = true
        }
    }
    d.fn.uDropdown = function(l, k) {
        this.each(function() {
            var n = d(this);
            var m = n.children(".e_toggle");
            var o = n.children(".e_dropdown");
            m.bind("click",
                function() {
                    c(o, l, k)
                })
        })
    };
    d.fn.uCloseDropdown = function() {
        this.each(function() {
            var m = d(this).children(".e_dropdown");
            var l = m.data("__rsiId");
            if (!l) {
                return
            }
            var k = d.inArray(l, g);
            if (k >= 0) {
                g.splice(k, 1)
            }
        });
        a.click()
    };
    function i(l, k) {
        return d.inArray(l, k) >= 0
    }
    function h(k) {
        if (!Object.keys) {
            Object.keys = function(n) {
                var m = [];
                for (var l in n) {
                    if (n.hasOwnProperty(l)) {
                        m.push(l)
                    }
                }
                return m
            }
        }
        h = function(l) {
            if (d.isArray(l)) {
                return l.length
            } else {
                if (d.isPlainObject(l)) {
                    return Object.keys(l).length
                }
            }
            return 0
        };
        return h(k)
    }
    function j(k) {
        var m = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz".split("");
        var l = m.length;
        j = function(n) {
            n = n || 16;
            if (n > 128) {
                n = 128
            }
            var p = "";
            for (var o = 0; o < n; o++) {
                p += m[Math.floor(Math.random() * l)]
            }
            return p
        };
        return j(k)
    }
})(jQuery);
function init_google_places_service() {
    var b = document.createElement("div");
    b.innerHTML = "";
    var a = new google.maps.places.PlacesService(b);
    return a
}
function google_place_search(g, m, d, j) {
    var k = new google.maps.LatLngBounds(new google.maps.LatLng(30.817, 121.169), new google.maps.LatLng(31.452, 121.984));
    var l = new google.maps.LatLngBounds(new google.maps.LatLng(30.817, 121.169), new google.maps.LatLng(31.452, 121.984));
    var c = new google.maps.LatLngBounds(new google.maps.LatLng(39.771, 116.208), new google.maps.LatLng(40.037, 116.508));
    var n = new google.maps.LatLngBounds(new google.maps.LatLng(22.665, 113.034), new google.maps.LatLng(23.787, 113.988));
    var b = new google.maps.LatLngBounds(new google.maps.LatLng(29.989, 119.91), new google.maps.LatLng(30.513, 120.591));
    var i = new google.maps.LatLngBounds(new google.maps.LatLng(38.871, 116.925), new google.maps.LatLng(39.659, 117.937));
    var h = {
        "021": k,
        "010": c,
        "020": n,
        "0571": b,
        "022": i,
        "021_0571": l.union(b)
    };
    var a = null;
    if (typeof m == "undefined") {
        a = null
    } else {
        a = h[m]
    }
    if (typeof g == "undefined") {
        g = ""
    }
    var e = {
        query: g,
        bounds: a
    };
    var f = init_google_places_service();
    f.textSearch(e,
        function(s, p) {
            var q = [];
            if (p == google.maps.places.PlacesServiceStatus.OK) {
                for (var r = 0; r < s.length; r++) {
                    var o = s[r];
                    var t = {};
                    t.id = o.id;
                    t.name = o.name;
                    t.address = o.formatted_address;
                    t.lat = o.geometry.location.lat();
                    t.lng = o.geometry.location.lng();
                    q.push(t)
                }
            }
            j(q)
        })
}
function google_place_search_test_callback(d, b) {
    if (b == google.maps.places.PlacesServiceStatus.OK) {
        for (var c = 0; c < d.length; c++) {
            var a = d[c];
            console.log(a);
            console.log(a.geometry.location.lat());
            console.log(a.geometry.location.lng())
        }
    }
};
eleme = window.eleme || {};
eleme.address_search_results = [];
function mapabc_place_search(b, e, a, f) {
    if (typeof e == "undefined") {
        e = "total"
    }
    var c = "http://search1.mapabc.com/sisserver?highLight=false&srctype=DIBIAO:10000%2BPOI&config=BESN&searchType=&number=10&batch=1&a_k=20efa86ab304f8541054c8623e1959d2abaf0ccc64567b4178682443983ce50b40ca88b507a88283&resType=JSON&enc=utf-8&sr=0&ctx=1735785";
    var d = {
        dataType: "jsonp",
        url: c,
        data: {
            searchName: b,
            cityCode: e
        },
        success: function(g) {
            alert("never")
        },
        timeout: 5000,
        cache: true,
        error: function(h, i, g) {}
    };
    $.ajax(d);
    MAjaxRequest.ReturnData = function(g, n) {
        var l = [];
        var h = [];
        if (typeof n != "undefined" && typeof n.poilist != "undefined") {
            l = n.poilist
        }
        for (var k = 0; k < l.length; k++) {
            if (k >= a) {
                break
            }
            var m = l[k];
            var j = city_code_map[m.citycode];
            if (typeof j == "undefined") {
                j = ""
            }
            h.push({
                id: m.pguid,
                name: m.name,
                address: j + m.address,
                lat: m.y,
                lng: m.x
            })
        }
        if (typeof f != "undefined") {
            f(h)
        }
    }
}
var MAjaxRequest = {};
function mapabc_place_search_test_callback(c) {
    for (var b = 0; b < c.length; b++) {
        var a = c[b]
    }
}
var city_code_map = {
    "010": "北京市",
    "021": "上海市",
    "022": "天津市",
    "023": "重庆市",
    "852": "香港",
    "853": "澳门",
    "0310": "邯郸市",
    "0311": "石家庄",
    "0312": "保定市",
    "0313": "张家口",
    "0314": "承德市",
    "0315": "唐山市",
    "0316": "廊坊市",
    "0317": "沧州市",
    "0318": "衡水市",
    "0319": "邢台市",
    "0335": "秦皇岛",
    "0570": "衢州市",
    "0571": "杭州市",
    "0572": "湖州市",
    "0573": "嘉兴市",
    "0574": "宁波市",
    "0575": "绍兴市",
    "0576": "台州市",
    "0577": "温州市",
    "0578": "丽水市",
    "0579": "金华市",
    "0580": "舟山市",
    "024": "沈阳市",
    "0410": "铁岭市",
    "0411": "大连市",
    "0412": "鞍山市",
    "0413": "抚顺市",
    "0414": "本溪市",
    "0415": "丹东市",
    "0416": "锦州市",
    "0417": "营口市",
    "0418": "阜新市",
    "0419": "辽阳市",
    "0421": "朝阳市",
    "0427": "盘锦市",
    "0429": "葫芦岛",
    "027": "武汉市",
    "0710": "襄城市",
    "0711": "鄂州市",
    "0712": "孝感市",
    "0713": "黄州市",
    "0714": "黄石市",
    "0715": "咸宁市",
    "0716": "荆沙市",
    "0717": "宜昌市",
    "0718": "恩施市",
    "0719": "十堰市",
    "0722": "随枣市",
    "0724": "荆门市",
    "0728": "江汉市",
    "025": "南京市",
    "0510": "无锡市",
    "0511": "镇江市",
    "0512": "苏州市",
    "0513": "南通市",
    "0514": "扬州市",
    "0515": "盐城市",
    "0516": "徐州市",
    "0517": "淮阴市",
    "0517": "淮安市",
    "0518": "连云港",
    "0519": "常州市",
    "0523": "泰州市",
    "0470": "海拉尔",
    "0471": "呼和浩特",
    "0472": "包头市",
    "0473": "乌海市",
    "0474": "集宁市",
    "0475": "通辽市",
    "0476": "赤峰市",
    "0477": "东胜市",
    "0478": "临河市",
    "0479": "锡林浩特",
    "0482": "乌兰浩特",
    "0483": "阿拉善左旗",
    "0790": "新余市",
    "0791": "南昌市",
    "0792": "九江市",
    "0793": "上饶市",
    "0794": "临川市",
    "0795": "宜春市",
    "0796": "吉安市",
    "0797": "赣州市",
    "0798": "景德镇",
    "0799": "萍乡市",
    "0701": "鹰潭市",
    "0350": "忻州市",
    "0351": "太原市",
    "0352": "大同市",
    "0353": "阳泉市",
    "0354": "榆次市",
    "0355": "长治市",
    "0356": "晋城市",
    "0357": "临汾市",
    "0358": "离石市",
    "0359": "运城市",
    "0930": "临夏市",
    "0931": "兰州市",
    "0932": "定西市",
    "0933": "平凉市",
    "0934": "西峰市",
    "0935": "武威市",
    "0936": "张掖市",
    "0937": "酒泉市",
    "0938": "天水市",
    "0941": "甘南州",
    "0943": "白银市",
    "0530": "菏泽市",
    "0531": "济南市",
    "0532": "青岛市",
    "0533": "淄博市",
    "0534": "德州市",
    "0535": "烟台市",
    "0536": "淮坊市",
    "0537": "济宁市",
    "0538": "泰安市",
    "0539": "临沂市",
    "0450": "阿城市",
    "0451": "哈尔滨",
    "0452": "齐齐哈尔",
    "0453": "牡丹江",
    "0454": "佳木斯",
    "0455": "绥化市",
    "0456": "黑河市",
    "0457": "加格达奇",
    "0458": "伊春市",
    "0459": "大庆市",
    "0591": "福州市",
    "0592": "厦门市",
    "0593": "宁德市",
    "0594": "莆田市",
    "0595": "泉州市",
    "0595": "晋江市",
    "0596": "漳州市",
    "0597": "龙岩市",
    "0598": "三明市",
    "0599": "南平市",
    "020": "广州市",
    "0751": "韶关市",
    "0752": "惠州市",
    "0753": "梅州市",
    "0754": "汕头市",
    "0755": "深圳市",
    "0756": "珠海市",
    "0757": "佛山市",
    "0758": "肇庆市",
    "0759": "湛江市",
    "0760": "中山市",
    "0762": "河源市",
    "0763": "清远市",
    "0765": "顺德市",
    "0766": "云浮市",
    "0768": "潮州市",
    "0769": "东莞市",
    "0660": "汕尾市",
    "0661": "潮阳市",
    "0662": "阳江市",
    "0663": "揭西市",
    "028": "成都市",
    "0810": "涪陵市",
    "0811": "重庆市",
    "0812": "攀枝花",
    "0813": "自贡市",
    "0814": "永川市",
    "0816": "绵阳市",
    "0817": "南充市",
    "0818": "达县市",
    "0819": "万县市",
    "0825": "遂宁市",
    "0826": "广安市",
    "0827": "巴中市",
    "0830": "泸州市",
    "0831": "宜宾市",
    "0832": "内江市",
    "0833": "乐山市",
    "0834": "西昌市",
    "0835": "雅安市",
    "0836": "康定市",
    "0837": "马尔康",
    "0838": "德阳市",
    "0839": "广元市",
    "0840": "泸州市",
    "0730": "岳阳市",
    "0731": "长沙市",
    "0732": "湘潭市",
    "0733": "株州市",
    "0734": "衡阳市",
    "0735": "郴州市",
    "0736": "常德市",
    "0737": "益阳市",
    "0738": "娄底市",
    "0739": "邵阳市",
    "0743": "吉首市",
    "0744": "张家界",
    "0745": "怀化市",
    "0746": "永州冷",
    "0370": "商丘市",
    "0371": "郑州市",
    "0372": "安阳市",
    "0373": "新乡市",
    "0374": "许昌市",
    "0375": "平顶山",
    "0376": "信阳市",
    "0377": "南阳市",
    "0378": "开封市",
    "0379": "洛阳市",
    "0391": "焦作市",
    "0392": "鹤壁市",
    "0393": "濮阳市",
    "0394": "周口市",
    "0395": "漯河市",
    "0396": "驻马店",
    "0398": "三门峡",
    "0870": "昭通市",
    "0871": "昆明市",
    "0872": "大理市",
    "0873": "个旧市",
    "0874": "曲靖市",
    "0875": "保山市",
    "0876": "文山市",
    "0877": "玉溪市",
    "0878": "楚雄市",
    "0879": "思茅市",
    "0691": "景洪市",
    "0692": "潞西市",
    "0881": "东川市",
    "0883": "临沧市",
    "0886": "六库市",
    "0887": "中甸市",
    "0888": "丽江市",
    "0550": "滁州市",
    "0551": "合肥市",
    "0552": "蚌埠市",
    "0553": "芜湖市",
    "0554": "淮南市",
    "0555": "马鞍山",
    "0556": "安庆市",
    "0557": "宿州市",
    "0558": "阜阳市",
    "0559": "黄山市",
    "0561": "淮北市",
    "0562": "铜陵市",
    "0563": "宣城市",
    "0564": "六安市",
    "0565": "巢湖市",
    "0566": "贵池市",
    "0951": "银川市",
    "0952": "石嘴山",
    "0953": "吴忠市",
    "0954": "固原市",
    "0431": "长春市",
    "0432": "吉林市",
    "0433": "延吉市",
    "0434": "四平市",
    "0435": "通化市",
    "0436": "白城市",
    "0437": "辽源市",
    "0438": "松原市",
    "0439": "浑江市",
    "0440": "珲春市",
    "0770": "防城港",
    "0771": "南宁市",
    "0772": "柳州市",
    "0773": "桂林市",
    "0774": "梧州市",
    "0775": "玉林市",
    "0776": "百色市",
    "0777": "钦州市",
    "0778": "河池市",
    "0779": "北海市",
    "0851": "贵阳市",
    "0852": "遵义市",
    "0853": "安顺市",
    "0854": "都均市",
    "0855": "凯里市",
    "0856": "铜仁市",
    "0857": "毕节市",
    "0858": "六盘水",
    "0859": "兴义市",
    "029": "西安市",
    "0910": "咸阳市",
    "0911": "延安市",
    "0912": "榆林市",
    "0913": "渭南市",
    "0914": "商洛市",
    "0915": "安康市",
    "0916": "汉中市",
    "0917": "宝鸡市",
    "0919": "铜川市",
    "0971": "西宁市",
    "0972": "海东市",
    "0973": "同仁市",
    "0974": "共和市",
    "0975": "玛沁市",
    "0976": "玉树市",
    "0977": "德令哈",
    "0890": "儋州市",
    "0898": "海口市",
    "0899": "三亚市",
    "0891": "拉萨市",
    "0892": "日喀则",
    "0893": "山南市"
};
jQuery.fn.pagination = function(a, b) {
    b = jQuery.extend({
            items_per_page: 10,
            num_display_entries: 10,
            current_page: 0,
            num_edge_entries: 0,
            link_to: "#",
            prev_text: "Prev",
            next_text: "Next",
            ellipse_text: "...",
            prev_show_always: true,
            next_show_always: true,
            callback: function() {
                return false
            }
        },
        b || {});
    return this.each(function() {
        function f() {
            return Math.ceil(a / b.items_per_page)
        }
        function h() {
            var k = Math.ceil(b.num_display_entries / 2);
            var l = f();
            var j = l - b.num_display_entries;
            var m = g > k ? Math.max(Math.min(g - k, j), 0) : 0;
            var i = g > k ? Math.min(g + k, l) : Math.min(b.num_display_entries, l);
            return [m, i]
        }
        function e(j, i) {
            g = j;
            c();
            var k = b.callback(j, d);
            if (!k) {
                if (i.stopPropagation) {
                    i.stopPropagation()
                } else {
                    i.cancelBubble = true
                }
            }
            return k
        }
        function c() {
            d.empty();
            var k = h();
            var o = f();
            var p = function(i) {
                return function(q) {
                    return e(i, q)
                }
            };
            var n = function(i, q) {
                i = i < 0 ? 0 : (i < o ? i: o - 1);
                q = jQuery.extend({
                        text: i + 1,
                        classes: ""
                    },
                    q || {});
                if (i == g) {
                    var r = jQuery("<span class='current'>" + (q.text) + "</span>")
                } else {
                    var r = jQuery("<a>" + (q.text) + "</a>").bind("click", p(i)).attr("href", b.link_to.replace(/__id__/, i))
                }
                if (q.classes) {
                    r.addClass(q.classes)
                }
                d.append(r)
            };
            if (b.prev_text && (g > 0 || b.prev_show_always)) {
                n(g - 1, {
                    text: b.prev_text,
                    classes: "prev"
                })
            }
            if (k[0] > 0 && b.num_edge_entries > 0) {
                var j = Math.min(b.num_edge_entries, k[0]);
                for (var l = 0; l < j; l++) {
                    n(l)
                }
                if (b.num_edge_entries < k[0] && b.ellipse_text) {
                    jQuery("<span>" + b.ellipse_text + "</span>").appendTo(d)
                }
            }
            for (var l = k[0]; l < k[1]; l++) {
                n(l)
            }
            if (k[1] < o && b.num_edge_entries > 0) {
                if (o - b.num_edge_entries > k[1] && b.ellipse_text) {
                    jQuery("<span>" + b.ellipse_text + "</span>").appendTo(d)
                }
                var m = Math.max(o - b.num_edge_entries, k[1]);
                for (var l = m; l < o; l++) {
                    n(l)
                }
            }
            if (b.next_text && (g < o - 1 || b.next_show_always)) {
                n(g + 1, {
                    text: b.next_text,
                    classes: "next"
                })
            }
        }
        var g = b.current_page;
        a = (!a || a < 0) ? 1 : a;
        b.items_per_page = (!b.items_per_page || b.items_per_page < 0) ? 1 : b.items_per_page;
        var d = jQuery(this);
        this.selectPage = function(i) {
            e(i)
        };
        this.prevPage = function() {
            if (g > 0) {
                e(g - 1);
                return true
            } else {
                return false
            }
        };
        this.nextPage = function() {
            if (g < f() - 1) {
                e(g + 1);
                return true
            } else {
                return false
            }
        };
        c();
        b.callback(g, this)
    })
};
window.ElemeMap = new(function ElemeMap() {
    var I = {
        PIN: eleme.staticHost + "/images/forward/homepage/icon-pin.png?v=5",
        PIN_UP: eleme.staticHost + "/images/forward/homepage/icon-pin-up.png?v=5",
        MARKER: eleme.staticHost + "/images/forward/homepage/icon-marker.png?v=5"
    };
    var g = {
        SUCCESS: "E0",
        NO_RESULT: "E1"
    };
    var T = get_entry_url();

    var H = {
        getUserAddr: T + web_url+"index/getDistrict",
        deletePlace: T + "/homepage/deletePlace",
        getRestaurantCount: T + "/homepage/getRestaurantCount",
        searchPoi: T + "/homepage/searchPoi"
    };
    //alert(H.getUserAddr);
    var k = {
        MAX: 20,
        PER_PAGE: 10,
        MAX_ELEME_POI_NUM: 5
    };
    var a = {
        ZOOM: [4, 18],
        ZOOM_DEFAULT: 13,
        RESOLUTION_MAX: 0.6
    };
    var s = {
        "1": {
            cityId: 1,
            cityName: "上海",
            cityCode: "021",
            lng: 121.48,
            lat: 31.22
        },
        "2": {
            cityId: 2,
            cityName: "杭州",
            cityCode: "0571",
            lng: 120.15,
            lat: 30.28
        },
        "3": {
            cityId: 3,
            cityName: "北京",
            cityCode: "010",
            lng: 116.3812,
            lat: 39.9698
        },
        "4": {
            cityId: 4,
            cityName: "广州",
            cityCode: "020",
            lng: 113.3578,
            lat: 23.0915
        },
        "5": {
            cityId: 5,
            cityName: "天津",
            cityCode: "022"
        }
    };
    var L = this;
    var u, v, M;
    var U, D, t;
    var l, r, W, y;
    var o, aa, f, X, N, C, e, x, n, Q, ab, S, w, j, J, c, P, B, G, A; (function() {
        u = false;
        v = $.Deferred();
        $(document).ready(function() {
            o = $("#em_mapFrame");
            aa = $("#em_mapWrapper");
            f = $("#em_mapContainer");
            X = $("#em_mapMask");
            N = $("#em_searchWrapper");
            C = $("#em_searchCity");
            e = $("#em_searchInput");
            x = $("#em_searchButton");
            n = $("#em_resultWrapper");
            Q = $("#em_resultLoading");
            ab = $("#em_resultBlock");
            S = $("#em_resultMain");
            w = $("#em_resultTotal");
            j = $("#em_resultList");
            J = $("#em_resultPaging");
            c = $("#em_resultNone");
            P = $("#em_dropWrapper");
            B = $("#em_dropPin");
            G = $("#em_userAddrList");
            A = $("#em_userAddrNone");
            $("#em_close").on("click", Z);
            z();
            m();
            K();
            v.resolve()
        })
    })();
    L.open = function(ac) {
        v.done(function() {
            d(ac)
        })
    };
    L.close = function() {
        v.done(Z)
    };
    L.search = function(ac) {
        v.done(function() {
            Y(ac)
        })
    };
    function d(af) {
        if (u) {
            return
        }
        if (!s[af] || !s[af].lng || !s[af].lat) {
            return
        }
        M = s[af];
        try {
            var ad = window.localStorage,
                ac = ad.getItem("visited");
            if (!ac) {
                ad.setItem("visited", true);
                X.show()
            }
        } catch(ae) {
            X.show()
        }
        u = true;
        l = [];
        r = [];
        W = [];
        y = 0;
        o.fadeIn(function() {
            e.trigger("focus");
            q()
        });
        C.text(M.cityName);
        U = new AMap.Map(f.attr("id"), {
            level: a.ZOOM_DEFAULT,
            center: new AMap.LngLat(M.lng, M.lat),
            zooms: a.ZOOM,
            dragEnable: true,
            zoomEnable: true,
            keyboardEnable: false,
            jogEnable: true,
            continuousZoomEnable: true,
            doubleClickZoom: true,
            scrollWheel: true
        });
        U.plugin("AMap.ToolBar",
            function() {
                U.addControl(new AMap.ToolBar({
                    offset: new AMap.Pixel(20, 65),
                    ruler: true,
                    direction: false,
                    autoPosition: false
                }))
            });
        D = new AMap.Geocoder({
            poinum: 1
        });
        t = new AMap.PoiSearch({
            number: k.MAX,
            batch: 1
        });
        U.bind(U, "dragend", O);
        U.bind(U, "zoomchange", O);
        U.bind(U, "click", b)
    }
    function Z() {
        if (!u) {
            return
        }
        o.fadeOut(function() {
            U.destroy();
            U = null;
            D = null;
            t = null;
            C.text("");
            e.val("");
            n.hide();
            aa.removeClass("fix-margin");
            l = null;
            r = null;
            W = null;
            y = 0;
            u = false;
            M = null
        })
    }
    function Y(ac) {
        if (!u || !ac) {
            return
        }
        X.fadeOut("slow");
        i();
        e.val(ac);
        e.blur();
        e.autocomplete("close");
        E();
        if (n.is(":hidden")) {
            n.show();
            n.animate({
                    width: "250px"
                },
                function() {
                    aa.addClass("fix-margin")
                })
        }
        ab.hide();
        Q.show();
        var ad = $.getJSON(H.searchPoi, {
            kw: ac,
            cityId: M.cityId
        });
        t.byKeywords(ac, M.cityCode,
            function(ae) {
                var af = [];
                ad.success(function(ag) {
                    af = ag
                });
                ad.always(function() {
                    if (!af.length && ae.status != g.SUCCESS) {
                        if (ae.status == "E1") {
                            c.show()
                        } else {
                            j.html('<li class="empty-result">地图服务异常，请稍后再搜索。</li>')
                        }
                        w.text("0");
                        J.hide();
                        Q.hide();
                        ab.show();
                        return
                    }
                    ae.list = ae.list || [];
                    if (af.length > k.MAX_ELEME_POI_NUM) {
                        af = af.slice(0, k.MAX_ELEME_POI_NUM)
                    }
                    $.each(af,
                        function(ag, ah) {
                            ah.x = ah.lng;
                            ah.y = ah.lat
                        });
                    ae.list = af.concat(ae.list);
                    if (ae.list.length > 100) {
                        ae.list.splice(100)
                    }
                    F(ae.list)
                })
            })
    }
    function z() {
        $.getJSON(H.getUserAddr,
            function(ac) {
                if (!ac.places || !ac.places.length) {
                    G.hide();
                    A.show();
                    return
                }
                $.each(ac.places,
                    function(af, ae) {
                        var ah = ae.is_entry ? "/at/entry_id/": "/place/";
                        var ag = ['<li class="', (!ae.address ? "patch-height": ""), '" data-sn="', ae.sn, '">', '<a class="del">删除</a>', '<a class="place" href="', T, ah, ae.id, '" title="', ae.name_full, '" target="_blank">', ae.name_full, "</a>", (ae.address ? ('<p class="addr">' + ae.address + "</p>") : ""), "</li>"].join("");
                        var ad = $(ag);
                        ad.find(".del").on("click",
                            function() {
                                $.get(H.deletePlace, {
                                        id: ae.id
                                    },
                                    function(ai) {
                                        if (ai) {
                                            ad.slideUp("fast").remove();
                                            if (!G.html()) {
                                                G.hide();
                                                A.show()
                                            }
                                        }
                                    })
                            });
                        //console.log(ad);
                        G.append(ad)
                    })
            });
        $("#em_userAddr").uDropdown()
    }
    function q() {
        if (G.html()) {
            $("#em_userAddrBtn").trigger("click")
        }
    }
    function i() {
        $("html").trigger("click")
    }
    function m() {
        e.autocomplete({
            position: {
                my: "left top",
                at: "left-68 bottom+5"
            },
            source: function(ad, ac) {
                t.inputPrompt(ad.term, M.cityCode,
                    function(ae) {
                        if (ae.status != g.SUCCESS) {
                            return
                        }
                        ac(ae.list)
                    })
            },
            select: function(ac, ad) {
                Y(ad.item.label)
            },
            minLength: 2,
            delay: 500,
            open: function() {
                N.addClass("patch-radius")
            },
            close: function() {
                N.removeClass("patch-radius")
            }
        });
        e.on("keyup",
            function(ac) {
                if (ac.which != 13) {
                    return
                }
                Y(e.val())
            });
        x.on("click",
            function() {
                Y(e.val())
            })
    }
    function F(ac) {
        c.hide();
        $.each(ac,
            function(ae, ad) {
                l.push({
                    id: ae,
                    name: ad.name,
                    addr: ad.address || "",
                    lng: ad.x,
                    lat: ad.y
                })
            });
        w.text(l.length);
        if (l.length <= k.PER_PAGE) {
            J.hide();
            J.empty();
            R(0)
        } else {
            J.show();
            J.pagination(l.length, {
                current_page: 0,
                items_per_page: k.PER_PAGE,
                num_display_entries: 3,
                num_edge_entries: 1,
                link_to: "#",
                prev_text: "&lt;",
                next_text: "&gt;",
                ellipse_text: "&#8230;",
                prev_show_always: false,
                next_show_always: false,
                callback: function(ad) {
                    R(ad)
                }
            })
        }
    }
    function E() {
        U.clearOverlays();
        l = [];
        r = [];
        w.text("0");
        j.empty();
        J.hide()
    }
    function R(ae) {
        if (r.length) {
            $.each(r,
                function(ah, ag) {
                    ag.hide()
                })
        }
        var af = ae * k.PER_PAGE,
            ac = Math.min(af + k.PER_PAGE, l.length);
        r = l.slice(af, ac);
        _gaq.push(["_trackEvent", "homepage_map", "page_" + ae]);
        if (! (r[0] instanceof h)) {
            Q.show();
            ab.hide();
            var ad = [];
            $.each(r,
                function(ah, ag) {
                    ad.push(ag.lng + "," + ag.lat)
                });
            $.getJSON(H.getRestaurantCount, {
                    posArray: ad
                },
                function(ag) {
                    $.each(ag,
                        function(ai, aj) {
                            var ah = af + ai;
                            l[ah].count = aj;
                            l[ah] = new h(l[ah]);
                            r[ai] = l[ah]
                        });
                    p()
                })
        } else {
            p()
        }
    }
    function p() {
        Q.hide();
        ab.show();
        S.scrollTop(0);
        if (r.length == 1) {
            U.setZoomAndCenter(a.ZOOM[1], r[0].marker.getPosition());
            r[0].show();
            r[0].select();
            return
        }
        var ap = 90,
            af = -90,
            ad = 180,
            ah = -180;
        $.each(r,
            function(av, au) {
                au.show();
                var aw = au.marker.getPosition();
                if (aw.lat < ap) {
                    ap = aw.lat
                }
                if (aw.lat > af) {
                    af = aw.lat
                }
                if (aw.lng < ad) {
                    ad = aw.lng
                }
                if (aw.lng > ah) {
                    ah = aw.lng
                }
            });
        var am = (ad + ah) / 2,
            al = (ap + af) / 2,
            ac = new AMap.LngLat(am, al),
            ao = new AMap.LngLat(ad, ap),
            ak = new AMap.LngLat(ah, ap),
            ai = new AMap.LngLat(ad, af),
            at = U.getSize(),
            ae = 1.1,
            an = ae * (at.width / at.height),
            aj = U.getDistance(ao, ak) * an,
            ar = U.getDistance(ao, ai) * ae,
            aq = a.ZOOM[1],
            ag = a.RESOLUTION_MAX;
        while (((aj / ag) > at.width) || ((ar / ag) > at.height)) {
            aq--;
            ag *= 2
        }
        U.setZoomAndCenter(aq, ac);
        r[0].select()
    }
    function O() {
        b(true)
    }
    function b(ae) {
        var ag = null;
        for (var ad = 0; r[ad]; ad++) {
            if (r[ad].selected) {
                ag = r[ad]
            }
        }
        for (var ac = 0; W[ac]; ac++) {
            if (W[ac].selected) {
                ag = W[ac]
            }
        }
        if (ag) {
            if (ae === true) {
                var af = U.getBounds();
                if (ag.info.lat < af.southwest.lat || ag.info.lat > af.northeast.lat || ag.info.lng < af.southwest.lng || ag.info.lng > af.northeast.lng) {
                    ag.unselect()
                }
            } else {
                ag.unselect()
            }
        }
    }
    function K() {
        B.on("mousedown",
            function() {
                i();
                B.addClass("pin-up")
            });
        B.on("mouseout",
            function() {
                B.removeClass("pin-up")
            });
        B.draggable({
            helper: "clone",
            containment: f,
            cursor: "crosshair",
            cursorAt: {
                left: 17,
                top: 9
            },
            start: function(ad, ac) {
                B.hide()
            },
            stop: function(ad, ac) {
                B.show();
                b();
                if (ac.position.top > 180 || ac.position.left > 30) {
                    W.push(new V(ac.offset))
                }
            }
        })
    }
    function h(ad) {
        var am = this;
        var al, ac;
        var ao, ah;
        var at, ag, af, ak; (function(az) {
            al = az;
            al.order = al.id % 10;
            al.label = "abcdefghij".split("")[al.order];
            am.info = al;
            ac = false;
            am.selected = ac;
            var ax = al.count ? "": " zero-result",
                aA = al.count ? "查看餐厅": "努力覆盖中";
            href = al.count ? ([' href="', T, "/geoplace/from_place?", $.param({
                lat: al.lat,
                lng: al.lng,
                name: encodeURIComponent(al.name)
            }), '" '].join("")) : "";
            btn_click = al.count ? " onclick=\"_gaq.push(['_trackEvent','enter_entry','enter_entry_by_map_search','" + al.name + "']);\"": "";
            var aw = al.count ? "附近有 <strong>" + al.count + "</strong> 家外卖餐厅": "附近没有外卖餐厅";
            var ay = ['<li class="search_result result-block">', '<i class="icon-marker marker-', al.label, '"></i>', "<div>", '<p class="name">', al.name, "</p>", '<p class="addr">', al.addr, "</p>", '<p class="amount', ax, '">', aw, "</p>", "</div>", "</li>"].join("");
            var av = ['<div class="info_window info-window">', '<a class="close"></a>', '<p class="name">', al.name, "</p>", '<p class="addr">', al.addr, "</p>", '<p class="amount', ax, '">', aw, "</p>", '<a class="btn', ax, '"', href, btn_click, ' target="_blank">', aA, "</a>", '<!--[if lte IE 9]><i class="triangle"></i><![endif]-->', "</div>"].join("");
            ao = $(ay);
            ao.on("click", aj);
            ao.on("mouseenter",
                function() {
                    ap(true)
                });
            ao.on("mouseleave",
                function() {
                    if (ac) {
                        return
                    }
                    ai()
                });
            var au = -31 * al.order;
            at = new AMap.Icon({
                size: new AMap.Size(31, 40),
                imageOffset: new AMap.Pixel(au, 0),
                image: I.MARKER
            });
            ag = new AMap.Icon({
                size: new AMap.Size(31, 40),
                imageOffset: new AMap.Pixel(au, -40),
                image: I.MARKER
            });
            af = new AMap.Marker({
                id: "result_" + al.id,
                position: new AMap.LngLat(al.lng, al.lat),
                icon: at,
                offset: new AMap.Pixel( - 15, -38),
                visible: false,
                draggable: false
            });
            am.marker = af;
            U.addOverlays(af);
            U.bind(af, "click",
                function() {
                    aj(true)
                });
            U.bind(af, "mousemove",
                function(aD) {
                    ao.addClass("current");
                    ap();
                    var aC = {
                        x: aD.clientX,
                        y: aD.clientY
                    };
                    var aB = function(aF) {
                        var aE = {
                            x: aF.clientX,
                            y: aF.clientY
                        };
                        if (Math.abs(aC.x - aE.x) > 10 && Math.abs(aC.y - aE.y) > 10) {
                            if (!ac) {
                                ao.removeClass("current");
                                ai()
                            }
                            $(window).off("mousemove", aB)
                        }
                    };
                    $(window).on("mousemove", aB)
                });
            ah = $(av);
            ah.find(".close").on("click", ae);
            ak = new AMap.InfoWindow({
                isCustom: true,
                autoMove: true,
                size: new AMap.Size(280, 138),
                offset: new AMap.Pixel( - 145, -48),
                content: ah[0]
            });
            U.bind(ak, "open",
                function() {
                    var aH = f.offset(),
                        aG = ah.offset(),
                        aE = f.width(),
                        aF = ah.width();
                    var aC = aG.left - aH.left,
                        aD = aG.top - aH.top,
                        aB = (aG.left + aF) - (aH.left + aE);
                    if (aC < 73 && aD < 220) {
                        U.panBy(73 - aC, 0)
                    }
                })
        })(ad);
        am.destroy = aq;
        am.show = ar;
        am.hide = an;
        am.select = aj;
        am.unselect = ae;
        function aq() {
            ao.remove();
            ao = null;
            af = null;
            if (ak.getIsOpen()) {
                ak.close()
            }
            ah = null;
            ak = null;
            al = null
        }
        function ar() {
            ao.appendTo(j);
            af.setVisible(true)
        }
        function an() {
            ac = false;
            am.selected = false;
            ao.detach();
            af.setVisible(false);
            if (ak.getIsOpen()) {
                ak.close()
            }
        }
        function aj(au) {
            if (ac) {
                return
            }
            ac = true;
            am.selected = true;
            $.each(r,
                function(ax, aw) {
                    if (aw != am) {
                        aw.unselect()
                    }
                });
            if (au === true) {
                var av = S.scrollTop() + ao.position().top;
                S.scrollTop(av)
            }
            ao.addClass("current");
            ap();
            ak.open(U, af.getPosition())
        }
        function ae() {
            if (!ac) {
                return
            }
            ac = false;
            am.selected = false;
            ao.removeClass("current");
            ai();
            if (ak.getIsOpen()) {
                ak.close()
            }
        }
        function ap(au) {
            af.icon = ag;
            af.zIndex = au ? 200 : 100;
            U.updateOverlay(af)
        }
        function ai() {
            af.icon = at;
            af.zIndex = 1;
            U.updateOverlay(af)
        }
    }
    function V(ai) {
        var am = this;
        var aj, ag;
        var ak;
        var an, al, ad, ac; (function(ar) {
            aj = {
                id: y++
            };
            am.info = aj;
            ag = false;
            am.selected = false;
            var aq = f.offset(),
                ap = ar.left - aq.left,
                at = ar.top - aq.top;
            var ao = U.containTolnglat(new AMap.Pixel(ap, at));
            aj.lng = ao.lng;
            aj.lat = ao.lat;
            an = new AMap.Icon({
                size: new AMap.Size(27, 34),
                imageOffset: new AMap.Pixel(0, 0),
                image: I.PIN
            });
            al = new AMap.Icon({
                size: new AMap.Size(27, 34),
                imageOffset: new AMap.Pixel(0, 0),
                image: I.PIN_UP
            });
            ad = new AMap.Marker({
                id: "pin_" + aj.id,
                position: ao,
                offset: new AMap.Pixel(8, 0),
                icon: an,
                draggable: true
            });
            U.addOverlays(ad);
            ah();
            U.bind(ad, "click", ah);
            U.bind(ad, "dragstart",
                function() {
                    ad.setIcon(al)
                });
            U.bind(ad, "dragend",
                function() {
                    ad.setIcon(an);
                    ah(true)
                })
        })(ai);
        am.select = ah;
        am.unselect = ae;
        function ah(at) {
            ag = true;
            am.selected = true;
            if (ac && at !== true) {
                ac.open(U, ad.getPosition());
                return
            }
            var ao = ad.getPosition();
            aj.lng = ao.lng;
            aj.lat = ao.lat;
            var ar = $.Deferred();
            D.regeocode(ad.getPosition(),
                function(av) {
                    if (av.status == g.SUCCESS) {
                        var au = av.list[0].poilist[0];
                        aj.name = au.name;
                        aj.addr = au.address
                    } else {
                        aj.none = true
                    }
                    ar.resolve()
                });
            var ap = [aj.lng, aj.lat].join(",");
            var aq = $.getJSON(H.getRestaurantCount, {
                    posArray: [ap]
                },
                function(au) {
                    aj.count = au[0]
                });
            $.when(ar, aq).done(af)
        }
        function ae() {
            ag = false;
            am.selected = false;
            if (ac && ac.getIsOpen()) {
                ac.close()
            }
        }
        function af() {
            if (ac && ac.getIsOpen()) {
                ac.close()
            }
            var aq = aj.count ? "": " zero-result",
                ar = aj.count ? "查看餐厅": "努力覆盖中";
            href = aj.count ? ([' href="', T, "/geoplace/from_place?", $.param({
                lat: aj.lat,
                lng: aj.lng,
                name: encodeURIComponent(aj.name)
            }), '" '].join("")) : "";
            btn_click = aj.count ? " onclick=\"_gaq.push(['_trackEvent','enter_entry','enter_entry_by_map_search','" + aj.name + "']);\"": "";
            var ap = aj.count ? "附近有 <strong>" + aj.count + "</strong> 家外卖餐厅": "附近没有外卖餐厅";
            var ao = ['<div class="info_window info-window">', '<a class="close"></a>', '<p class="name">', aj.name, "</p>", '<p class="addr">', aj.addr, "</p>", '<p class="amount', aq, '">', ap, "</p>", '<a class="btn', aq, '"', href, btn_click, '" target="_blank">', ar, "</a>", '<!--[if lte IE 9]><i class="triangle"></i><![endif]-->', "</div>"].join("");
            ak = $(ao);
            ak.find(".close").on("click", ae);
            ac = new AMap.InfoWindow({
                isCustom: true,
                autoMove: true,
                size: new AMap.Size(280, 138),
                offset: new AMap.Pixel( - 130, -7),
                content: ak[0]
            });
            U.bind(ac, "open",
                function() {
                    var aw = f.offset(),
                        av = ak.offset();
                    var at = av.left - aw.left,
                        au = av.top - aw.top;
                    if (at < 73 && au < 220) {
                        U.panBy(73 - at, 0)
                    }
                });
            ac.open(U, ad.getPosition())
        }
    }
})(); (function(c) {
    var b = new Object();
    b = {
        debug: false,
        city_obj: c(".city_obj"),
        city_target: c(".city_obj a"),
        city_wrapper: c(".city_wrapper"),
        city_name: c(".city_name"),
        center_obj: c("#city_4"),
        frame: c(".homepage-map"),
        move_delay: 500,
        city_fade_delay: 400,
        callback: function() {
            this.d_obj.click()
        },
        c_obj: c("#select_city"),
        d_obj: c("#select_district"),
        z_obj: c("#select_zone"),
        getd_url: base_url+ "index/getDistrict",
        getd_url1: base_url + "travel/getTravel",
        getd_url2: base_url + "happy/get_category",
        getd_url3: base_url + "play/get_category",
        getd_url4: base_url + "live/get_category",
        getd_url5: base_url + "service/get_category",
        getz_url: get_entry_url() + "/homepage/getZone",
        gete_url: get_entry_url() + "/homepage/getEntry",
        backTC_obj: c(".to_city"),
        backTD_obj: c(".to_zone"),
        selectd_city_code: "",
        nav: {
            city: null,
            district: null,
            zone: null
        },
        data: {
            cid: 1,
            district: null,
            zone: null
        },
        sf_delay: 100,
        step2_in: function(e) {
            c(".city_fr").fadeIn(this.sf_delay,
                function() {
                    e.call()
                })
        },
        step2_out: function(e) {
            c(".city_fr").fadeOut(this.sf_delay,
                function() {
                    e.call()
                })
        },
        step3_in: function(e) {
            c(".entry_fr").fadeIn(this.sf_delay,
                function() {
                    c(".econ").css("overflow-y", "auto")
                });
            if (e) {
                c(".azgroup").show()
            } else {
                c(".azgroup").hide()
            }
        },
        step3_out: function(e) {
            c(".econ").css("overflow-y", "hidden");
            c(".entry_fr").fadeOut(this.sf_delay,
                function() {
                    e.call()
                })
        },
        cmplete_data: {}
    };
    if (b.debug) {
        console.log("Debug is now On !")
    }
    b.init = function() {

        var e = this;
        if (c.browser.msie && c.browser.version < 9) {
            e.move_delay = 10;
            e.sf_delay = 10
        }
        e.city_target.click(function() {
            c("#search_input").data();
            c(".area_guess, .arrow,").remove();
            var p = c(this),
                l = p.parent("li"),
                q = l.siblings("li"),
                m = l.attr("data-id") == 0,
                o = l.attr("data-id") == 0,
                t = l.attr("data-id") == 0,
                j = l.attr("data-id") == 0,
                v = (!q.eq(0).is(":animated") && q.eq(0).css("visibility") != "hidden" && (!m && !o && !t && !j));
            var u = {
                "北京": "010",
                "上海": "021",
                "杭州": "0571",
                "广州": "020",
                "天津": "022"
            };
            if (v) {
                var k = e.center_obj.offset().left - l.offset().left;
                var g = e.center_obj.offset().top - l.offset().top;
                var h = 1;
                q.animate({
                        opacity: 0
                    },
                    e.city_fade_delay,
                    function() {
                        c(this).css("visibility", "hidden");
                        if (h == q.length) {
                            s()
                        }
                        h += 1
                    });
                c(".fade_item").fadeOut();
                p.removeClass("hover");
                c(".content").attr("id", "step2");
                var f = l.find(".city_name").text();

                e.selected_city_code = u[f];
                function s() {
                    e.city_wrapper.animate({
                            marginLeft: k,
                            marginTop: g
                        },
                        500,
                        function() {
                            e.backTC_obj.removeClass("hide");
                            e.show_select();
                            e.nav.city = f
                        })
                }
                var r = l.data("id");
                var searchUrl = '';
                if(r == 6){
                    searchUrl =e.getd_url2;
                }else if(r == 7){
                    searchUrl =e.getd_url5;
                }else if(r == 5){
                    searchUrl =e.getd_url4;
                }else if(r == 4){
                    searchUrl =e.getd_url1;
                }else if(r == 3){
                    searchUrl =e.getd_url3;
                }else{
                    searchUrl = e.getd_url;
                }
                e.data.cid = r;
                c.get(searchUrl, {
                        city: r
                    },
                    function(n) {
                        if (e.debug) {
                            console.log(n)
                        }
                        e.data.district = n;
                        l.find(".city_name").hide();
                        //console.log(f);
                        e.c_obj.html(f);
                        e.z_obj.parent("span").hide()
                    },
                    "json")
            }
            if (m) {
                ElemeMap.open(1)
            } else {
                if (o) {
                    ElemeMap.open(2)
                } else {
                    if (t) {
                        ElemeMap.open(4)
                    } else {
                        if (j) {
                            ElemeMap.open(3)
                        }
                    }
                }
            }
        });
        e.select_event();
        e.jumpToEntry();
        e.jumpFromEntry();
        e.back_event();
        e.azsort();
        e.myaddress_event()
    };
    b.show_select = function() {
        var e = this;
        c(".select_fr").fadeIn(e.sf_delay);
        if (e.callback) {
            e.callback()
        }
    };
    b.hide_select = function(f) {
        var e = this;
        c(".select_fr").fadeOut(e.sf_delay,
            function() {
                f.call()
            })
    };
    b.select_event = function() {
        var e = this;
        e.d_obj.click(function() {
            var f = e.data.district,
                g = c(this);
            if (!f) {
                var h = e.data.cid;
                if (h != 1 && h != 2) {
                    c.get(e.getd_url, {
                            city: h
                        },
                        function(j) {
                            if (e.debug) {
                                console.log(j)
                            }
                            e.data.district = j;
                            b.select_panel(j, g)
                        },
                        "json")
                }
            } else {

                var h = e.data.cid;
                //console.log(h);
                //if (h != 1 && h != 2) {
                b.select_panel(f, g)
                //}
            }
        });
        c(".step2_select_panel[data-obj=select_district]").find("a").live("click",
            function() {
                var f = c(this).data("val");
                e.nav.district = c(this).text();
                e.d_obj.removeClass("current").html(e.nav.district);
                e.z_obj.data("did", f);
                c.get(e.getz_url, {
                        district: f
                    },
                    function(g) {
                        if (e.debug) {
                            console.log(g)
                        }
                        e.data.zone = g;
                        e.z_obj.parent("span").show();
                        e.z_obj.click().addClass("current")
                    },
                    "json")
            })
    };
    b.select_panel = function(j, k) {
        if (b.debug) {
            console.dir(j)
        }
        var h = "";
        c.each(j,
            function(m, l) {
                var new_url = '';
                if(l.cid == 2) new_url = 'gourmet/getGourmet/'+l.cid+'?ctype='+l.value;
                else if(l.cid == 3) new_url = 'play/showPlaylList/'+l.cid+'?ctype='+l.value;
                else if(l.cid == 4) new_url = 'travel/showTravelList/';
                else if(l.cid == 5) new_url = 'live/showLiveList/'+l.cid+'?ctype='+l.value;
                else if(l.cid == 6) new_url = 'happy/showHappylList/'+l.cid+'?ctype='+l.value;
                else if(l.cid == 7) new_url = 'service/showLiveList/'+l.cid+'?ctype='+l.value;
                else new_url = 'index/show_secondIndex/'+l.cid+'?ctype='+l.value;
                h += '<li><a href="'+base_url+ new_url +'" data-val="' + l.value + '" data-needAz="' + l.needAz + '">' + l.name + "</a></li>"
            });
        var f = c(h).length,
            g = f % 4,
            e = 4 - g;
        if (g != 0) {
            for (i = 0; i < e; i++) {
                h += "<li></li>"
            }
        }
        h = '<ul data-obj="' + k.attr("id") + '" class="step2_select_panel">' + h + "</ul>";
        c(".step2_select_panel").remove();
        c(".selections").append(h)
    };
    b.jumpToEntry = function() {
        var e = this;
        c(".step2_select_panel[data-obj=select_zone]").find("a").live("click",
            function() {
                var g = c(this).data("val"),
                    f = c(this).data("needaz");
                e.nav.zone = c(this).text();
                c("#entry_con,.azgroup").html("");
                c("#home_nav").html("").append(e.entryNavHtml(e.nav));
                c(".step2_select_panel[data-obj=select_zone]").remove();
                c.get(e.gete_url, {
                        zone: g
                    },
                    function(h) {
                        c("#entry_con").html(e.entryConHtml(h.entrys));
                        c(".azgroup").html(e.entryAzHtml(h.az));
                        e.step2_out(function() {
                            e.step3_in(f)
                        })
                    },
                    "json")
            });
        e.z_obj.click(function() {
            var f = c(this).data("did");
            a(e.data.zone, e.getz_url, {
                    district: f
                },
                function(g) {
                    if (g.length === 1) {
                        b.select_panel(g, c("#select_zone"));
                        b.z_obj.parent("span").hide();
                        c(".step2_select_panel[data-obj=select_zone]").find("a").click()
                    } else {
                        b.select_panel(g, c("#select_zone"))
                    }
                },
                "json")
        })
    };
    b.jumpFromEntry = function() {
        var e = this;
        e.backTD_obj.click(function() {
            e.step3_out(function() {
                e.step2_in(function() {
                    if (c(".select_fr").find(".select:visible").length === 3) {
                        e.z_obj.click()
                    } else {
                        if (c(".select_fr").find(".select:visible").length === 2) {
                            e.d_obj.click()
                        }
                    }
                })
            })
        })
    };
    b.entryConHtml = function(f) {
        var e = "";
        c.each(f,
            function(h, g) {
                e += '<li data-az="' + g.az + '"><a href="' + get_entry_url() + "/at/entry/" + g.sn + '" title="' + g.name + '" class="entry_by_select_flow" target="_blank">' + g.name + "</a></li>"
            });
        return e
    };
    b.MyEntryConHtml = function(f) {
        var e = "";
        c.each(f,
            function(h, g) {
                if (g.is_entry) {
                    e += '<li data-sn="' + g.sn + '"><a href="' + get_entry_url() + "/at/entry_id/" + g.id + '" title="' + g.name + '" class="entry_by_my_entry" target="_blank">' + g.name + '</a><i class="icon-trash"></i></li>'
                }
                if (g.is_geohash) {
                    e += '<li data-sn="' + g.sn + '"><a href="' + get_entry_url() + "/place/" + g.id + '" title="' + g.name + '" class="entry_by_my_entry" target="_blank">' + g.name + '</a><i class="icon-trash"></i></li>'
                }
            });
        return e
    };
    b.entryAzHtml = function(f) {
        var e = '<a class="all active" data-val="0" href="javascript:;">全部</a>';
        c.each(f,
            function(h, g) {
                e += '<a class="com" data-val="' + g + '" href="javascript:;">' + g.toLocaleUpperCase() + "</a>"
            });
        return e
    };
    b.entryNavHtml = function(f) {
        var e = "";
        c.each(f,
            function(h, g) {
                e += (h == "city") ? g: '<i class="icon-dot"></i>' + g
            });
        return e
    };
    b.back_event = function() {
        var e = this;
        e.backTC_obj.click(function() {
            e.hide_select(function() {
                c(".step2_select_panel").remove();
                c(".select").find("b").html(function() {
                    return c(this).data("name")
                });
                e.showcity()
            });
            e.city_name.fadeIn()
        })
    };
    b.showcity = function() {
        var e = this;
        e.city_wrapper.animate({
                marginLeft: 0,
                marginTop: 0
            },
            500,
            function() {
                e.city_obj.css("visibility", "visible").animate({
                        opacity: 1
                    },
                    e.city_fade_delay);
                e.city_target.addClass("hover");
                c(".content").attr("id", "step1");
                c(".fade_item").fadeIn()
            })
    };
    b.azsort = function() {
        c(".azgroup").find("a").live("click",
            function() {
                c(".azgroup").find("a").removeClass("active");
                var e = c(this).addClass("active").data("val");
                if (e == 0) {
                    c("#entry_con").find("li").show()
                } else {
                    c("#entry_con").find("li").hide();
                    c("#entry_con").find("li[data-az=" + e + "]").show()
                }
            })
    };
    b.myaddress_event = function() {
        var e = this;
        c(".btn-addr").click(function() {
            c(".fade_item").fadeOut();
            c(".area_guess").hide();
            c(".arrow").hide();
            c("#home_nav").html("").append("我的地址");
            c.get(get_entry_url() + "/homepage/getMyEntry",
                function(f) {
                    c("#entry_con").html("").append(e.MyEntryConHtml(f.places))
                },
                "json");
            e.step2_out(function() {
                e.step3_in()
            })
        });
        c(".to_zone,.to_city").live("click",
            function() {
                if (c("#step1").length > 0) {
                    c(".fade_item").fadeIn()
                }
            })
    };
    function d(e) {
        var f = {};
        f.left = e.offset().left;
        f.top = e.offset().top + e.height() + 8;
        return f
    }
    function a(h, e, j, g, f) {
        if (!h) {
            c.get(e, j,
                function(k) {
                    g.call({},
                        k)
                },
                f)
        } else {
            g.call({},
                h)
        }
    }
    c.extend({
        homepage: b
    });
    //点击选择弹出层
    c("#select_district").click(function() {
        c(this).addClass("current").html("请选择");
        c("#select_zone").parent("span").hide()
    });
    c(document).ready(function() {
        var e = c(".area_guess"),
            g = c(".arrow");
        if (e.length > 0) {
            _gaq.push(["_trackEvent", "enter_entry", "guess_entry_show", name]);
            var f = e.attr("from_city");
            c("#" + f).append(g, e);
            g.slideDown(500,
                function() {
                    e.slideDown(500)
                });
            c("#rm_auto_addr").click(function() {
                e.remove();
                g.remove()
            })
        }
        c.homepage.init();
        c(".entry_by_entry_search").live("click",
            function() {
                var h = c(this).html();
                _gaq.push(["_trackEvent", "enter_entry", "enter_entry_by_entry_search", h])
            });
        c(".entry_by_select_flow").live("click",
            function() {
                var h = c(this).html();
                _gaq.push(["_trackEvent", "enter_entry", "enter_entry_by_select_flow", h])
            });
        c(".entry_by_my_entry").live("click",
            function() {
                var h = c(this).html();
                _gaq.push(["_trackEvent", "enter_entry", "enter_entry_by_my_entry", h])
            })
    })
})(jQuery);