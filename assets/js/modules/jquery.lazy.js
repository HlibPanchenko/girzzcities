/*! jQuery & Zepto Lazy v1.7.10 - http://jquery.eisbehr.de/lazy - MIT&GPL-2.0 license - Copyright 2012-2018 Daniel 'Eisbehr' Kern */
!(function (t, e) {
    "use strict";
    function r(r, a, i, u, l) {
        function f() {
            (L = t.devicePixelRatio > 1),
                (i = c(i)),
            a.delay >= 0 &&
            setTimeout(function () {
                s(!0);
            }, a.delay),
            (a.delay < 0 || a.combined) &&
            ((u.e = v(a.throttle, function (t) {
                "resize" === t.type && (w = B = -1), s(t.all);
            })),
                (u.a = function (t) {
                    (t = c(t)), i.push.apply(i, t);
                }),
                (u.g = function () {
                    return (i = n(i).filter(function () {
                        return !n(this).data(a.loadedName);
                    }));
                }),
                (u.f = function (t) {
                    for (var e = 0; e < t.length; e++) {
                        var r = i.filter(function () {
                            return this === t[e];
                        });
                        r.length && s(!1, r);
                    }
                }),
                s(),
                n(a.appendScroll).on("scroll." + l + " resize." + l, u.e));
        }
        function c(t) {
            var i = a.defaultImage,
                o = a.placeholder,
                u = a.imageBase,
                l = a.srcsetAttribute,
                f = a.loaderAttribute,
                c = a._f || {};
            t = n(t)
                .filter(function () {
                    var t = n(this),
                        r = m(this);
                    return !t.data(a.handledName) && (t.attr(a.attribute) || t.attr(l) || t.attr(f) || c[r] !== e);
                })
                .data("plugin_" + a.name, r);
            for (var s = 0, d = t.length; s < d; s++) {
                var A = n(t[s]),
                    g = m(t[s]),
                    h = A.attr(a.imageBaseAttribute) || u;
                g === N && h && A.attr(l) && A.attr(l, b(A.attr(l), h)),
                c[g] === e || A.attr(f) || A.attr(f, c[g]),
                    g === N && i && !A.attr(E) ? A.attr(E, i) : g === N || !o || (A.css(O) && "none" !== A.css(O)) || A.css(O, "url('" + o + "')");
            }
            return t;
        }
        function s(t, e) {
            if (!i.length) return void (a.autoDestroy && r.destroy());
            for (var o = e || i, u = !1, l = a.imageBase || "", f = a.srcsetAttribute, c = a.handledName, s = 0; s < o.length; s++)
                if (t || e || A(o[s])) {
                    var g = n(o[s]),
                        h = m(o[s]),
                        b = g.attr(a.attribute),
                        v = g.attr(a.imageBaseAttribute) || l,
                        p = g.attr(a.loaderAttribute);
                    g.data(c) ||
                    (a.visibleOnly && !g.is(":visible")) ||
                    !(((b || g.attr(f)) && ((h === N && (v + b !== g.attr(E) || g.attr(f) !== g.attr(F))) || (h !== N && v + b !== g.css(O)))) || p) ||
                    ((u = !0), g.data(c, !0), d(g, h, v, p));
                }
            u &&
            (i = n(i).filter(function () {
                return !n(this).data(c);
            }));
        }
        function d(t, e, r, i) {
            ++z;
            var o = function () {
                y("onError", t), p(), (o = n.noop);
            };
            y("beforeLoad", t);
            var u = a.attribute,
                l = a.srcsetAttribute,
                f = a.sizesAttribute,
                c = a.retinaAttribute,
                s = a.removeAttribute,
                d = a.loadedName,
                A = t.attr(c);
            if (i) {
                var g = function () {
                    s && t.removeAttr(a.loaderAttribute), t.data(d, !0), y(T, t), setTimeout(p, 1), (g = n.noop);
                };
                t.off(I).one(I, o).one(D, g),
                y(i, t, function (e) {
                    e ? (t.off(D), g()) : (t.off(I), o());
                }) || t.trigger(I);
            } else {
                var h = n(new Image());
                h.one(I, o).one(D, function () {
                    t.hide(),
                        e === N ? t.attr(C, h.attr(C)).attr(F, h.attr(F)).attr(E, h.attr(E)) : t.css(O, "url('" + h.attr(E) + "')"),
                        t[a.effect](a.effectTime),
                    s && (t.removeAttr(u + " " + l + " " + c + " " + a.imageBaseAttribute), f !== C && t.removeAttr(f)),
                        t.data(d, !0),
                        y(T, t),
                        h.remove(),
                        p();
                });
                var m = (L && A ? A : t.attr(u)) || "";
                h
                    .attr(C, t.attr(f))
                    .attr(F, t.attr(l))
                    .attr(E, m ? r + m : null),
                h.complete && h.trigger(D);
            }
        }
        function A(t) {
            var e = t.getBoundingClientRect(),
                r = a.scrollDirection,
                n = a.threshold,
                i = h() + n > e.top && -n < e.bottom,
                o = g() + n > e.left && -n < e.right;
            return "vertical" === r ? i : "horizontal" === r ? o : i && o;
        }
        function g() {
            return w >= 0 ? w : (w = n(t).width());
        }
        function h() {
            return B >= 0 ? B : (B = n(t).height());
        }
        function m(t) {
            return t.tagName.toLowerCase();
        }
        function b(t, e) {
            if (e) {
                var r = t.split(",");
                t = "";
                for (var a = 0, n = r.length; a < n; a++) t += e + r[a].trim() + (a !== n - 1 ? "," : "");
            }
            return t;
        }
        function v(t, e) {
            var n,
                i = 0;
            return function (o, u) {
                function l() {
                    (i = +new Date()), e.call(r, o);
                }
                var f = +new Date() - i;
                n && clearTimeout(n), f > t || !a.enableThrottle || u ? l() : (n = setTimeout(l, t - f));
            };
        }
        function p() {
            --z, i.length || z || y("onFinishedAll");
        }
        function y(t, e, n) {
            return !!(t = a[t]) && (t.apply(r, [].slice.call(arguments, 1)), !0);
        }
        var z = 0,
            w = -1,
            B = -1,
            L = !1,
            T = "afterLoad",
            D = "load",
            I = "error",
            N = "img",
            E = "src",
            F = "srcset",
            C = "sizes",
            O = "background-image";
        "event" === a.bind || o ? f() : n(t).on(D + "." + l, f);
    }
    function a(a, o) {
        var u = this,
            l = n.extend({}, u.config, o),
            f = {},
            c = l.name + "-" + ++i;
        return (
            (u.config = function (t, r) {
                return r === e ? l[t] : ((l[t] = r), u);
            }),
                (u.addItems = function (t) {
                    return f.a && f.a("string" === n.type(t) ? n(t) : t), u;
                }),
                (u.getItems = function () {
                    return f.g ? f.g() : {};
                }),
                (u.update = function (t) {
                    return f.e && f.e({}, !t), u;
                }),
                (u.force = function (t) {
                    return f.f && f.f("string" === n.type(t) ? n(t) : t), u;
                }),
                (u.loadAll = function () {
                    return f.e && f.e({ all: !0 }, !0), u;
                }),
                (u.destroy = function () {
                    return n(l.appendScroll).off("." + c, f.e), n(t).off("." + c), (f = {}), e;
                }),
                r(u, l, a, f, c),
                l.chainable ? a : u
        );
    }
    var n = t.jQuery || t.Zepto,
        i = 0,
        o = !1;
    (n.fn.Lazy = n.fn.lazy = function (t) {
        return new a(this, t);
    }),
        (n.Lazy = n.lazy = function (t, r, i) {
            if ((n.isFunction(r) && ((i = r), (r = [])), n.isFunction(i))) {
                (t = n.isArray(t) ? t : [t]), (r = n.isArray(r) ? r : [r]);
                for (var o = a.prototype.config, u = o._f || (o._f = {}), l = 0, f = t.length; l < f; l++) (o[t[l]] === e || n.isFunction(o[t[l]])) && (o[t[l]] = i);
                for (var c = 0, s = r.length; c < s; c++) u[r[c]] = t[0];
            }
        }),
        (a.prototype.config = {
            name: "lazy",
            chainable: !0,
            autoDestroy: !0,
            bind: "load",
            threshold: 500,
            visibleOnly: !1,
            appendScroll: t,
            scrollDirection: "both",
            imageBase: null,
            defaultImage: "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",
            placeholder: null,
            delay: -1,
            combined: !1,
            attribute: "data-src",
            srcsetAttribute: "data-srcset",
            sizesAttribute: "data-sizes",
            retinaAttribute: "data-retina",
            loaderAttribute: "data-loader",
            imageBaseAttribute: "data-imagebase",
            removeAttribute: !0,
            handledName: "handled",
            loadedName: "loaded",
            effect: "show",
            effectTime: 0,
            enableThrottle: !0,
            throttle: 250,
            beforeLoad: e,
            afterLoad: e,
            onError: e,
            onFinishedAll: e,
        }),
        n(t).on("load", function () {
            o = !0;
        });
})(window);
