var Q = "top",
    it = "bottom",
    rt = "right",
    Z = "left",
    pn = "auto",
    ye = [Q, it, rt, Z],
    Ut = "start",
    me = "end",
    Wo = "clippingParents",
    Qn = "viewport",
    de = "popper",
    Fo = "reference",
    zn = ye.reduce(function (o, t) {
        return o.concat([t + "-" + Ut, t + "-" + me]);
    }, []),
    Zn = [].concat(ye, [pn]).reduce(function (o, t) {
        return o.concat([t, t + "-" + Ut, t + "-" + me]);
    }, []),
    zo = "beforeRead",
    Ko = "read",
    Yo = "afterRead",
    qo = "beforeMain",
    Uo = "main",
    Go = "afterMain",
    Xo = "beforeWrite",
    Qo = "write",
    Zo = "afterWrite",
    Jo = [zo, Ko, Yo, qo, Uo, Go, Xo, Qo, Zo];
function Et(o) {
    return o ? (o.nodeName || "").toLowerCase() : null;
}
function at(o) {
    if (o == null) return window;
    if (o.toString() !== "[object Window]") {
        var t = o.ownerDocument;
        return (t && t.defaultView) || window;
    }
    return o;
}
function Gt(o) {
    var t = at(o).Element;
    return o instanceof t || o instanceof Element;
}
function dt(o) {
    var t = at(o).HTMLElement;
    return o instanceof t || o instanceof HTMLElement;
}
function Jn(o) {
    if (typeof ShadowRoot > "u") return !1;
    var t = at(o).ShadowRoot;
    return o instanceof t || o instanceof ShadowRoot;
}
function dl(o) {
    var t = o.state;
    Object.keys(t.elements).forEach(function (s) {
        var r = t.styles[s] || {},
            l = t.attributes[s] || {},
            d = t.elements[s];
        !dt(d) ||
            !Et(d) ||
            (Object.assign(d.style, r),
            Object.keys(l).forEach(function (u) {
                var h = l[u];
                h === !1
                    ? d.removeAttribute(u)
                    : d.setAttribute(u, h === !0 ? "" : h);
            }));
    });
}
function fl(o) {
    var t = o.state,
        s = {
            popper: {
                position: t.options.strategy,
                left: "0",
                top: "0",
                margin: "0",
            },
            arrow: { position: "absolute" },
            reference: {},
        };
    return (
        Object.assign(t.elements.popper.style, s.popper),
        (t.styles = s),
        t.elements.arrow && Object.assign(t.elements.arrow.style, s.arrow),
        function () {
            Object.keys(t.elements).forEach(function (r) {
                var l = t.elements[r],
                    d = t.attributes[r] || {},
                    u = Object.keys(
                        t.styles.hasOwnProperty(r) ? t.styles[r] : s[r]
                    ),
                    h = u.reduce(function (m, c) {
                        return (m[c] = ""), m;
                    }, {});
                !dt(l) ||
                    !Et(l) ||
                    (Object.assign(l.style, h),
                    Object.keys(d).forEach(function (m) {
                        l.removeAttribute(m);
                    }));
            });
        }
    );
}
const ts = {
    name: "applyStyles",
    enabled: !0,
    phase: "write",
    fn: dl,
    effect: fl,
    requires: ["computeStyles"],
};
function yt(o) {
    return o.split("-")[0];
}
var qt = Math.max,
    un = Math.min,
    ge = Math.round;
function Kn() {
    var o = navigator.userAgentData;
    return o != null && o.brands && Array.isArray(o.brands)
        ? o.brands
              .map(function (t) {
                  return t.brand + "/" + t.version;
              })
              .join(" ")
        : navigator.userAgent;
}
function ti() {
    return !/^((?!chrome|android).)*safari/i.test(Kn());
}
function we(o, t, s) {
    t === void 0 && (t = !1), s === void 0 && (s = !1);
    var r = o.getBoundingClientRect(),
        l = 1,
        d = 1;
    t &&
        dt(o) &&
        ((l = (o.offsetWidth > 0 && ge(r.width) / o.offsetWidth) || 1),
        (d = (o.offsetHeight > 0 && ge(r.height) / o.offsetHeight) || 1));
    var u = Gt(o) ? at(o) : window,
        h = u.visualViewport,
        m = !ti() && s,
        c = (r.left + (m && h ? h.offsetLeft : 0)) / l,
        g = (r.top + (m && h ? h.offsetTop : 0)) / d,
        v = r.width / l,
        A = r.height / d;
    return {
        width: v,
        height: A,
        top: g,
        right: c + v,
        bottom: g + A,
        left: c,
        x: c,
        y: g,
    };
}
function es(o) {
    var t = we(o),
        s = o.offsetWidth,
        r = o.offsetHeight;
    return (
        Math.abs(t.width - s) <= 1 && (s = t.width),
        Math.abs(t.height - r) <= 1 && (r = t.height),
        { x: o.offsetLeft, y: o.offsetTop, width: s, height: r }
    );
}
function ei(o, t) {
    var s = t.getRootNode && t.getRootNode();
    if (o.contains(t)) return !0;
    if (s && Jn(s)) {
        var r = t;
        do {
            if (r && o.isSameNode(r)) return !0;
            r = r.parentNode || r.host;
        } while (r);
    }
    return !1;
}
function Lt(o) {
    return at(o).getComputedStyle(o);
}
function hl(o) {
    return ["table", "td", "th"].indexOf(Et(o)) >= 0;
}
function Rt(o) {
    return ((Gt(o) ? o.ownerDocument : o.document) || window.document)
        .documentElement;
}
function mn(o) {
    return Et(o) === "html"
        ? o
        : o.assignedSlot || o.parentNode || (Jn(o) ? o.host : null) || Rt(o);
}
function oo(o) {
    return !dt(o) || Lt(o).position === "fixed" ? null : o.offsetParent;
}
function pl(o) {
    var t = /firefox/i.test(Kn()),
        s = /Trident/i.test(Kn());
    if (s && dt(o)) {
        var r = Lt(o);
        if (r.position === "fixed") return null;
    }
    var l = mn(o);
    for (
        Jn(l) && (l = l.host);
        dt(l) && ["html", "body"].indexOf(Et(l)) < 0;

    ) {
        var d = Lt(l);
        if (
            d.transform !== "none" ||
            d.perspective !== "none" ||
            d.contain === "paint" ||
            ["transform", "perspective"].indexOf(d.willChange) !== -1 ||
            (t && d.willChange === "filter") ||
            (t && d.filter && d.filter !== "none")
        )
            return l;
        l = l.parentNode;
    }
    return null;
}
function Re(o) {
    for (var t = at(o), s = oo(o); s && hl(s) && Lt(s).position === "static"; )
        s = oo(s);
    return s &&
        (Et(s) === "html" || (Et(s) === "body" && Lt(s).position === "static"))
        ? t
        : s || pl(o) || t;
}
function ns(o) {
    return ["top", "bottom"].indexOf(o) >= 0 ? "x" : "y";
}
function Ie(o, t, s) {
    return qt(o, un(t, s));
}
function ml(o, t, s) {
    var r = Ie(o, t, s);
    return r > s ? s : r;
}
function ni() {
    return { top: 0, right: 0, bottom: 0, left: 0 };
}
function si(o) {
    return Object.assign({}, ni(), o);
}
function oi(o, t) {
    return t.reduce(function (s, r) {
        return (s[r] = o), s;
    }, {});
}
var gl = function (t, s) {
    return (
        (t =
            typeof t == "function"
                ? t(Object.assign({}, s.rects, { placement: s.placement }))
                : t),
        si(typeof t != "number" ? t : oi(t, ye))
    );
};
function wl(o) {
    var t,
        s = o.state,
        r = o.name,
        l = o.options,
        d = s.elements.arrow,
        u = s.modifiersData.popperOffsets,
        h = yt(s.placement),
        m = ns(h),
        c = [Z, rt].indexOf(h) >= 0,
        g = c ? "height" : "width";
    if (!(!d || !u)) {
        var v = gl(l.padding, s),
            A = es(d),
            _ = m === "y" ? Q : Z,
            E = m === "y" ? it : rt,
            y =
                s.rects.reference[g] +
                s.rects.reference[m] -
                u[m] -
                s.rects.popper[g],
            x = u[m] - s.rects.reference[m],
            D = Re(d),
            I = D ? (m === "y" ? D.clientHeight || 0 : D.clientWidth || 0) : 0,
            P = y / 2 - x / 2,
            T = v[_],
            $ = I - A[g] - v[E],
            L = I / 2 - A[g] / 2 + P,
            O = Ie(T, L, $),
            M = m;
        s.modifiersData[r] =
            ((t = {}), (t[M] = O), (t.centerOffset = O - L), t);
    }
}
function bl(o) {
    var t = o.state,
        s = o.options,
        r = s.element,
        l = r === void 0 ? "[data-popper-arrow]" : r;
    l != null &&
        ((typeof l == "string" &&
            ((l = t.elements.popper.querySelector(l)), !l)) ||
            (ei(t.elements.popper, l) && (t.elements.arrow = l)));
}
const ii = {
    name: "arrow",
    enabled: !0,
    phase: "main",
    fn: wl,
    effect: bl,
    requires: ["popperOffsets"],
    requiresIfExists: ["preventOverflow"],
};
function be(o) {
    return o.split("-")[1];
}
var _l = { top: "auto", right: "auto", bottom: "auto", left: "auto" };
function vl(o, t) {
    var s = o.x,
        r = o.y,
        l = t.devicePixelRatio || 1;
    return { x: ge(s * l) / l || 0, y: ge(r * l) / l || 0 };
}
function io(o) {
    var t,
        s = o.popper,
        r = o.popperRect,
        l = o.placement,
        d = o.variation,
        u = o.offsets,
        h = o.position,
        m = o.gpuAcceleration,
        c = o.adaptive,
        g = o.roundOffsets,
        v = o.isFixed,
        A = u.x,
        _ = A === void 0 ? 0 : A,
        E = u.y,
        y = E === void 0 ? 0 : E,
        x = typeof g == "function" ? g({ x: _, y }) : { x: _, y };
    (_ = x.x), (y = x.y);
    var D = u.hasOwnProperty("x"),
        I = u.hasOwnProperty("y"),
        P = Z,
        T = Q,
        $ = window;
    if (c) {
        var L = Re(s),
            O = "clientHeight",
            M = "clientWidth";
        if (
            (L === at(s) &&
                ((L = Rt(s)),
                Lt(L).position !== "static" &&
                    h === "absolute" &&
                    ((O = "scrollHeight"), (M = "scrollWidth"))),
            (L = L),
            l === Q || ((l === Z || l === rt) && d === me))
        ) {
            T = it;
            var k =
                v && L === $ && $.visualViewport
                    ? $.visualViewport.height
                    : L[O];
            (y -= k - r.height), (y *= m ? 1 : -1);
        }
        if (l === Z || ((l === Q || l === it) && d === me)) {
            P = rt;
            var b =
                v && L === $ && $.visualViewport
                    ? $.visualViewport.width
                    : L[M];
            (_ -= b - r.width), (_ *= m ? 1 : -1);
        }
    }
    var B = Object.assign({ position: h }, c && _l),
        et = g === !0 ? vl({ x: _, y }, at(s)) : { x: _, y };
    if (((_ = et.x), (y = et.y), m)) {
        var W;
        return Object.assign(
            {},
            B,
            ((W = {}),
            (W[T] = I ? "0" : ""),
            (W[P] = D ? "0" : ""),
            (W.transform =
                ($.devicePixelRatio || 1) <= 1
                    ? "translate(" + _ + "px, " + y + "px)"
                    : "translate3d(" + _ + "px, " + y + "px, 0)"),
            W)
        );
    }
    return Object.assign(
        {},
        B,
        ((t = {}),
        (t[T] = I ? y + "px" : ""),
        (t[P] = D ? _ + "px" : ""),
        (t.transform = ""),
        t)
    );
}
function yl(o) {
    var t = o.state,
        s = o.options,
        r = s.gpuAcceleration,
        l = r === void 0 ? !0 : r,
        d = s.adaptive,
        u = d === void 0 ? !0 : d,
        h = s.roundOffsets,
        m = h === void 0 ? !0 : h,
        c = {
            placement: yt(t.placement),
            variation: be(t.placement),
            popper: t.elements.popper,
            popperRect: t.rects.popper,
            gpuAcceleration: l,
            isFixed: t.options.strategy === "fixed",
        };
    t.modifiersData.popperOffsets != null &&
        (t.styles.popper = Object.assign(
            {},
            t.styles.popper,
            io(
                Object.assign({}, c, {
                    offsets: t.modifiersData.popperOffsets,
                    position: t.options.strategy,
                    adaptive: u,
                    roundOffsets: m,
                })
            )
        )),
        t.modifiersData.arrow != null &&
            (t.styles.arrow = Object.assign(
                {},
                t.styles.arrow,
                io(
                    Object.assign({}, c, {
                        offsets: t.modifiersData.arrow,
                        position: "absolute",
                        adaptive: !1,
                        roundOffsets: m,
                    })
                )
            )),
        (t.attributes.popper = Object.assign({}, t.attributes.popper, {
            "data-popper-placement": t.placement,
        }));
}
const ss = {
    name: "computeStyles",
    enabled: !0,
    phase: "beforeWrite",
    fn: yl,
    data: {},
};
var Ze = { passive: !0 };
function El(o) {
    var t = o.state,
        s = o.instance,
        r = o.options,
        l = r.scroll,
        d = l === void 0 ? !0 : l,
        u = r.resize,
        h = u === void 0 ? !0 : u,
        m = at(t.elements.popper),
        c = [].concat(t.scrollParents.reference, t.scrollParents.popper);
    return (
        d &&
            c.forEach(function (g) {
                g.addEventListener("scroll", s.update, Ze);
            }),
        h && m.addEventListener("resize", s.update, Ze),
        function () {
            d &&
                c.forEach(function (g) {
                    g.removeEventListener("scroll", s.update, Ze);
                }),
                h && m.removeEventListener("resize", s.update, Ze);
        }
    );
}
const os = {
    name: "eventListeners",
    enabled: !0,
    phase: "write",
    fn: function () {},
    effect: El,
    data: {},
};
var Al = { left: "right", right: "left", bottom: "top", top: "bottom" };
function rn(o) {
    return o.replace(/left|right|bottom|top/g, function (t) {
        return Al[t];
    });
}
var Tl = { start: "end", end: "start" };
function ro(o) {
    return o.replace(/start|end/g, function (t) {
        return Tl[t];
    });
}
function is(o) {
    var t = at(o),
        s = t.pageXOffset,
        r = t.pageYOffset;
    return { scrollLeft: s, scrollTop: r };
}
function rs(o) {
    return we(Rt(o)).left + is(o).scrollLeft;
}
function Cl(o, t) {
    var s = at(o),
        r = Rt(o),
        l = s.visualViewport,
        d = r.clientWidth,
        u = r.clientHeight,
        h = 0,
        m = 0;
    if (l) {
        (d = l.width), (u = l.height);
        var c = ti();
        (c || (!c && t === "fixed")) && ((h = l.offsetLeft), (m = l.offsetTop));
    }
    return { width: d, height: u, x: h + rs(o), y: m };
}
function Ol(o) {
    var t,
        s = Rt(o),
        r = is(o),
        l = (t = o.ownerDocument) == null ? void 0 : t.body,
        d = qt(
            s.scrollWidth,
            s.clientWidth,
            l ? l.scrollWidth : 0,
            l ? l.clientWidth : 0
        ),
        u = qt(
            s.scrollHeight,
            s.clientHeight,
            l ? l.scrollHeight : 0,
            l ? l.clientHeight : 0
        ),
        h = -r.scrollLeft + rs(o),
        m = -r.scrollTop;
    return (
        Lt(l || s).direction === "rtl" &&
            (h += qt(s.clientWidth, l ? l.clientWidth : 0) - d),
        { width: d, height: u, x: h, y: m }
    );
}
function as(o) {
    var t = Lt(o),
        s = t.overflow,
        r = t.overflowX,
        l = t.overflowY;
    return /auto|scroll|overlay|hidden/.test(s + l + r);
}
function ri(o) {
    return ["html", "body", "#document"].indexOf(Et(o)) >= 0
        ? o.ownerDocument.body
        : dt(o) && as(o)
        ? o
        : ri(mn(o));
}
function Me(o, t) {
    var s;
    t === void 0 && (t = []);
    var r = ri(o),
        l = r === ((s = o.ownerDocument) == null ? void 0 : s.body),
        d = at(r),
        u = l ? [d].concat(d.visualViewport || [], as(r) ? r : []) : r,
        h = t.concat(u);
    return l ? h : h.concat(Me(mn(u)));
}
function Yn(o) {
    return Object.assign({}, o, {
        left: o.x,
        top: o.y,
        right: o.x + o.width,
        bottom: o.y + o.height,
    });
}
function Sl(o, t) {
    var s = we(o, !1, t === "fixed");
    return (
        (s.top = s.top + o.clientTop),
        (s.left = s.left + o.clientLeft),
        (s.bottom = s.top + o.clientHeight),
        (s.right = s.left + o.clientWidth),
        (s.width = o.clientWidth),
        (s.height = o.clientHeight),
        (s.x = s.left),
        (s.y = s.top),
        s
    );
}
function ao(o, t, s) {
    return t === Qn ? Yn(Cl(o, s)) : Gt(t) ? Sl(t, s) : Yn(Ol(Rt(o)));
}
function xl(o) {
    var t = Me(mn(o)),
        s = ["absolute", "fixed"].indexOf(Lt(o).position) >= 0,
        r = s && dt(o) ? Re(o) : o;
    return Gt(r)
        ? t.filter(function (l) {
              return Gt(l) && ei(l, r) && Et(l) !== "body";
          })
        : [];
}
function $l(o, t, s, r) {
    var l = t === "clippingParents" ? xl(o) : [].concat(t),
        d = [].concat(l, [s]),
        u = d[0],
        h = d.reduce(function (m, c) {
            var g = ao(o, c, r);
            return (
                (m.top = qt(g.top, m.top)),
                (m.right = un(g.right, m.right)),
                (m.bottom = un(g.bottom, m.bottom)),
                (m.left = qt(g.left, m.left)),
                m
            );
        }, ao(o, u, r));
    return (
        (h.width = h.right - h.left),
        (h.height = h.bottom - h.top),
        (h.x = h.left),
        (h.y = h.top),
        h
    );
}
function ai(o) {
    var t = o.reference,
        s = o.element,
        r = o.placement,
        l = r ? yt(r) : null,
        d = r ? be(r) : null,
        u = t.x + t.width / 2 - s.width / 2,
        h = t.y + t.height / 2 - s.height / 2,
        m;
    switch (l) {
        case Q:
            m = { x: u, y: t.y - s.height };
            break;
        case it:
            m = { x: u, y: t.y + t.height };
            break;
        case rt:
            m = { x: t.x + t.width, y: h };
            break;
        case Z:
            m = { x: t.x - s.width, y: h };
            break;
        default:
            m = { x: t.x, y: t.y };
    }
    var c = l ? ns(l) : null;
    if (c != null) {
        var g = c === "y" ? "height" : "width";
        switch (d) {
            case Ut:
                m[c] = m[c] - (t[g] / 2 - s[g] / 2);
                break;
            case me:
                m[c] = m[c] + (t[g] / 2 - s[g] / 2);
                break;
        }
    }
    return m;
}
function _e(o, t) {
    t === void 0 && (t = {});
    var s = t,
        r = s.placement,
        l = r === void 0 ? o.placement : r,
        d = s.strategy,
        u = d === void 0 ? o.strategy : d,
        h = s.boundary,
        m = h === void 0 ? Wo : h,
        c = s.rootBoundary,
        g = c === void 0 ? Qn : c,
        v = s.elementContext,
        A = v === void 0 ? de : v,
        _ = s.altBoundary,
        E = _ === void 0 ? !1 : _,
        y = s.padding,
        x = y === void 0 ? 0 : y,
        D = si(typeof x != "number" ? x : oi(x, ye)),
        I = A === de ? Fo : de,
        P = o.rects.popper,
        T = o.elements[E ? I : A],
        $ = $l(Gt(T) ? T : T.contextElement || Rt(o.elements.popper), m, g, u),
        L = we(o.elements.reference),
        O = ai({
            reference: L,
            element: P,
            strategy: "absolute",
            placement: l,
        }),
        M = Yn(Object.assign({}, P, O)),
        k = A === de ? M : L,
        b = {
            top: $.top - k.top + D.top,
            bottom: k.bottom - $.bottom + D.bottom,
            left: $.left - k.left + D.left,
            right: k.right - $.right + D.right,
        },
        B = o.modifiersData.offset;
    if (A === de && B) {
        var et = B[l];
        Object.keys(b).forEach(function (W) {
            var lt = [rt, it].indexOf(W) >= 0 ? 1 : -1,
                _t = [Q, it].indexOf(W) >= 0 ? "y" : "x";
            b[W] += et[_t] * lt;
        });
    }
    return b;
}
function Ll(o, t) {
    t === void 0 && (t = {});
    var s = t,
        r = s.placement,
        l = s.boundary,
        d = s.rootBoundary,
        u = s.padding,
        h = s.flipVariations,
        m = s.allowedAutoPlacements,
        c = m === void 0 ? Zn : m,
        g = be(r),
        v = g
            ? h
                ? zn
                : zn.filter(function (E) {
                      return be(E) === g;
                  })
            : ye,
        A = v.filter(function (E) {
            return c.indexOf(E) >= 0;
        });
    A.length === 0 && (A = v);
    var _ = A.reduce(function (E, y) {
        return (
            (E[y] = _e(o, {
                placement: y,
                boundary: l,
                rootBoundary: d,
                padding: u,
            })[yt(y)]),
            E
        );
    }, {});
    return Object.keys(_).sort(function (E, y) {
        return _[E] - _[y];
    });
}
function kl(o) {
    if (yt(o) === pn) return [];
    var t = rn(o);
    return [ro(o), t, ro(t)];
}
function Nl(o) {
    var t = o.state,
        s = o.options,
        r = o.name;
    if (!t.modifiersData[r]._skip) {
        for (
            var l = s.mainAxis,
                d = l === void 0 ? !0 : l,
                u = s.altAxis,
                h = u === void 0 ? !0 : u,
                m = s.fallbackPlacements,
                c = s.padding,
                g = s.boundary,
                v = s.rootBoundary,
                A = s.altBoundary,
                _ = s.flipVariations,
                E = _ === void 0 ? !0 : _,
                y = s.allowedAutoPlacements,
                x = t.options.placement,
                D = yt(x),
                I = D === x,
                P = m || (I || !E ? [rn(x)] : kl(x)),
                T = [x].concat(P).reduce(function (At, st) {
                    return At.concat(
                        yt(st) === pn
                            ? Ll(t, {
                                  placement: st,
                                  boundary: g,
                                  rootBoundary: v,
                                  padding: c,
                                  flipVariations: E,
                                  allowedAutoPlacements: y,
                              })
                            : st
                    );
                }, []),
                $ = t.rects.reference,
                L = t.rects.popper,
                O = new Map(),
                M = !0,
                k = T[0],
                b = 0;
            b < T.length;
            b++
        ) {
            var B = T[b],
                et = yt(B),
                W = be(B) === Ut,
                lt = [Q, it].indexOf(et) >= 0,
                _t = lt ? "width" : "height",
                z = _e(t, {
                    placement: B,
                    boundary: g,
                    rootBoundary: v,
                    altBoundary: A,
                    padding: c,
                }),
                Y = lt ? (W ? rt : Z) : W ? it : Q;
            $[_t] > L[_t] && (Y = rn(Y));
            var q = rn(Y),
                G = [];
            if (
                (d && G.push(z[et] <= 0),
                h && G.push(z[Y] <= 0, z[q] <= 0),
                G.every(function (At) {
                    return At;
                }))
            ) {
                (k = B), (M = !1);
                break;
            }
            O.set(B, G);
        }
        if (M)
            for (
                var nt = E ? 3 : 1,
                    Ce = function (st) {
                        var Tt = T.find(function (ee) {
                            var pt = O.get(ee);
                            if (pt)
                                return pt.slice(0, st).every(function (jt) {
                                    return jt;
                                });
                        });
                        if (Tt) return (k = Tt), "break";
                    },
                    ct = nt;
                ct > 0;
                ct--
            ) {
                var vt = Ce(ct);
                if (vt === "break") break;
            }
        t.placement !== k &&
            ((t.modifiersData[r]._skip = !0),
            (t.placement = k),
            (t.reset = !0));
    }
}
const li = {
    name: "flip",
    enabled: !0,
    phase: "main",
    fn: Nl,
    requiresIfExists: ["offset"],
    data: { _skip: !1 },
};
function lo(o, t, s) {
    return (
        s === void 0 && (s = { x: 0, y: 0 }),
        {
            top: o.top - t.height - s.y,
            right: o.right - t.width + s.x,
            bottom: o.bottom - t.height + s.y,
            left: o.left - t.width - s.x,
        }
    );
}
function co(o) {
    return [Q, rt, it, Z].some(function (t) {
        return o[t] >= 0;
    });
}
function Dl(o) {
    var t = o.state,
        s = o.name,
        r = t.rects.reference,
        l = t.rects.popper,
        d = t.modifiersData.preventOverflow,
        u = _e(t, { elementContext: "reference" }),
        h = _e(t, { altBoundary: !0 }),
        m = lo(u, r),
        c = lo(h, l, d),
        g = co(m),
        v = co(c);
    (t.modifiersData[s] = {
        referenceClippingOffsets: m,
        popperEscapeOffsets: c,
        isReferenceHidden: g,
        hasPopperEscaped: v,
    }),
        (t.attributes.popper = Object.assign({}, t.attributes.popper, {
            "data-popper-reference-hidden": g,
            "data-popper-escaped": v,
        }));
}
const ci = {
    name: "hide",
    enabled: !0,
    phase: "main",
    requiresIfExists: ["preventOverflow"],
    fn: Dl,
};
function Pl(o, t, s) {
    var r = yt(o),
        l = [Z, Q].indexOf(r) >= 0 ? -1 : 1,
        d =
            typeof s == "function"
                ? s(Object.assign({}, t, { placement: o }))
                : s,
        u = d[0],
        h = d[1];
    return (
        (u = u || 0),
        (h = (h || 0) * l),
        [Z, rt].indexOf(r) >= 0 ? { x: h, y: u } : { x: u, y: h }
    );
}
function Il(o) {
    var t = o.state,
        s = o.options,
        r = o.name,
        l = s.offset,
        d = l === void 0 ? [0, 0] : l,
        u = Zn.reduce(function (g, v) {
            return (g[v] = Pl(v, t.rects, d)), g;
        }, {}),
        h = u[t.placement],
        m = h.x,
        c = h.y;
    t.modifiersData.popperOffsets != null &&
        ((t.modifiersData.popperOffsets.x += m),
        (t.modifiersData.popperOffsets.y += c)),
        (t.modifiersData[r] = u);
}
const ui = {
    name: "offset",
    enabled: !0,
    phase: "main",
    requires: ["popperOffsets"],
    fn: Il,
};
function Ml(o) {
    var t = o.state,
        s = o.name;
    t.modifiersData[s] = ai({
        reference: t.rects.reference,
        element: t.rects.popper,
        strategy: "absolute",
        placement: t.placement,
    });
}
const ls = {
    name: "popperOffsets",
    enabled: !0,
    phase: "read",
    fn: Ml,
    data: {},
};
function Bl(o) {
    return o === "x" ? "y" : "x";
}
function Rl(o) {
    var t = o.state,
        s = o.options,
        r = o.name,
        l = s.mainAxis,
        d = l === void 0 ? !0 : l,
        u = s.altAxis,
        h = u === void 0 ? !1 : u,
        m = s.boundary,
        c = s.rootBoundary,
        g = s.altBoundary,
        v = s.padding,
        A = s.tether,
        _ = A === void 0 ? !0 : A,
        E = s.tetherOffset,
        y = E === void 0 ? 0 : E,
        x = _e(t, { boundary: m, rootBoundary: c, padding: v, altBoundary: g }),
        D = yt(t.placement),
        I = be(t.placement),
        P = !I,
        T = ns(D),
        $ = Bl(T),
        L = t.modifiersData.popperOffsets,
        O = t.rects.reference,
        M = t.rects.popper,
        k =
            typeof y == "function"
                ? y(Object.assign({}, t.rects, { placement: t.placement }))
                : y,
        b =
            typeof k == "number"
                ? { mainAxis: k, altAxis: k }
                : Object.assign({ mainAxis: 0, altAxis: 0 }, k),
        B = t.modifiersData.offset ? t.modifiersData.offset[t.placement] : null,
        et = { x: 0, y: 0 };
    if (L) {
        if (d) {
            var W,
                lt = T === "y" ? Q : Z,
                _t = T === "y" ? it : rt,
                z = T === "y" ? "height" : "width",
                Y = L[T],
                q = Y + x[lt],
                G = Y - x[_t],
                nt = _ ? -M[z] / 2 : 0,
                Ce = I === Ut ? O[z] : M[z],
                ct = I === Ut ? -M[z] : -O[z],
                vt = t.elements.arrow,
                At = _ && vt ? es(vt) : { width: 0, height: 0 },
                st = t.modifiersData["arrow#persistent"]
                    ? t.modifiersData["arrow#persistent"].padding
                    : ni(),
                Tt = st[lt],
                ee = st[_t],
                pt = Ie(0, O[z], At[z]),
                jt = P
                    ? O[z] / 2 - nt - pt - Tt - b.mainAxis
                    : Ce - pt - Tt - b.mainAxis,
                ne = P
                    ? -O[z] / 2 + nt + pt + ee + b.mainAxis
                    : ct + pt + ee + b.mainAxis,
                Oe = t.elements.arrow && Re(t.elements.arrow),
                X = Oe
                    ? T === "y"
                        ? Oe.clientTop || 0
                        : Oe.clientLeft || 0
                    : 0,
                ut = (W = B == null ? void 0 : B[T]) != null ? W : 0,
                _n = Y + jt - ut - X,
                J = Y + ne - ut,
                se = Ie(_ ? un(q, _n) : q, Y, _ ? qt(G, J) : G);
            (L[T] = se), (et[T] = se - Y);
        }
        if (h) {
            var Se,
                Ye = T === "x" ? Q : Z,
                S = T === "x" ? it : rt,
                F = L[$],
                ot = $ === "y" ? "height" : "width",
                Ct = F + x[Ye],
                V = F - x[S],
                H = [Q, Z].indexOf(D) !== -1,
                xe = (Se = B == null ? void 0 : B[$]) != null ? Se : 0,
                Wt = H ? Ct : F - O[ot] - M[ot] - xe + b.altAxis,
                U = H ? F + O[ot] + M[ot] - xe - b.altAxis : V,
                qe = _ && H ? ml(Wt, F, U) : Ie(_ ? Wt : Ct, F, _ ? U : V);
            (L[$] = qe), (et[$] = qe - F);
        }
        t.modifiersData[r] = et;
    }
}
const di = {
    name: "preventOverflow",
    enabled: !0,
    phase: "main",
    fn: Rl,
    requiresIfExists: ["offset"],
};
function Vl(o) {
    return { scrollLeft: o.scrollLeft, scrollTop: o.scrollTop };
}
function Hl(o) {
    return o === at(o) || !dt(o) ? is(o) : Vl(o);
}
function jl(o) {
    var t = o.getBoundingClientRect(),
        s = ge(t.width) / o.offsetWidth || 1,
        r = ge(t.height) / o.offsetHeight || 1;
    return s !== 1 || r !== 1;
}
function Wl(o, t, s) {
    s === void 0 && (s = !1);
    var r = dt(t),
        l = dt(t) && jl(t),
        d = Rt(t),
        u = we(o, l, s),
        h = { scrollLeft: 0, scrollTop: 0 },
        m = { x: 0, y: 0 };
    return (
        (r || (!r && !s)) &&
            ((Et(t) !== "body" || as(d)) && (h = Hl(t)),
            dt(t)
                ? ((m = we(t, !0)), (m.x += t.clientLeft), (m.y += t.clientTop))
                : d && (m.x = rs(d))),
        {
            x: u.left + h.scrollLeft - m.x,
            y: u.top + h.scrollTop - m.y,
            width: u.width,
            height: u.height,
        }
    );
}
function Fl(o) {
    var t = new Map(),
        s = new Set(),
        r = [];
    o.forEach(function (d) {
        t.set(d.name, d);
    });
    function l(d) {
        s.add(d.name);
        var u = [].concat(d.requires || [], d.requiresIfExists || []);
        u.forEach(function (h) {
            if (!s.has(h)) {
                var m = t.get(h);
                m && l(m);
            }
        }),
            r.push(d);
    }
    return (
        o.forEach(function (d) {
            s.has(d.name) || l(d);
        }),
        r
    );
}
function zl(o) {
    var t = Fl(o);
    return Jo.reduce(function (s, r) {
        return s.concat(
            t.filter(function (l) {
                return l.phase === r;
            })
        );
    }, []);
}
function Kl(o) {
    var t;
    return function () {
        return (
            t ||
                (t = new Promise(function (s) {
                    Promise.resolve().then(function () {
                        (t = void 0), s(o());
                    });
                })),
            t
        );
    };
}
function Yl(o) {
    var t = o.reduce(function (s, r) {
        var l = s[r.name];
        return (
            (s[r.name] = l
                ? Object.assign({}, l, r, {
                      options: Object.assign({}, l.options, r.options),
                      data: Object.assign({}, l.data, r.data),
                  })
                : r),
            s
        );
    }, {});
    return Object.keys(t).map(function (s) {
        return t[s];
    });
}
var uo = { placement: "bottom", modifiers: [], strategy: "absolute" };
function fo() {
    for (var o = arguments.length, t = new Array(o), s = 0; s < o; s++)
        t[s] = arguments[s];
    return !t.some(function (r) {
        return !(r && typeof r.getBoundingClientRect == "function");
    });
}
function gn(o) {
    o === void 0 && (o = {});
    var t = o,
        s = t.defaultModifiers,
        r = s === void 0 ? [] : s,
        l = t.defaultOptions,
        d = l === void 0 ? uo : l;
    return function (h, m, c) {
        c === void 0 && (c = d);
        var g = {
                placement: "bottom",
                orderedModifiers: [],
                options: Object.assign({}, uo, d),
                modifiersData: {},
                elements: { reference: h, popper: m },
                attributes: {},
                styles: {},
            },
            v = [],
            A = !1,
            _ = {
                state: g,
                setOptions: function (D) {
                    var I = typeof D == "function" ? D(g.options) : D;
                    y(),
                        (g.options = Object.assign({}, d, g.options, I)),
                        (g.scrollParents = {
                            reference: Gt(h)
                                ? Me(h)
                                : h.contextElement
                                ? Me(h.contextElement)
                                : [],
                            popper: Me(m),
                        });
                    var P = zl(Yl([].concat(r, g.options.modifiers)));
                    return (
                        (g.orderedModifiers = P.filter(function (T) {
                            return T.enabled;
                        })),
                        E(),
                        _.update()
                    );
                },
                forceUpdate: function () {
                    if (!A) {
                        var D = g.elements,
                            I = D.reference,
                            P = D.popper;
                        if (fo(I, P)) {
                            (g.rects = {
                                reference: Wl(
                                    I,
                                    Re(P),
                                    g.options.strategy === "fixed"
                                ),
                                popper: es(P),
                            }),
                                (g.reset = !1),
                                (g.placement = g.options.placement),
                                g.orderedModifiers.forEach(function (b) {
                                    return (g.modifiersData[b.name] =
                                        Object.assign({}, b.data));
                                });
                            for (
                                var T = 0;
                                T < g.orderedModifiers.length;
                                T++
                            ) {
                                if (g.reset === !0) {
                                    (g.reset = !1), (T = -1);
                                    continue;
                                }
                                var $ = g.orderedModifiers[T],
                                    L = $.fn,
                                    O = $.options,
                                    M = O === void 0 ? {} : O,
                                    k = $.name;
                                typeof L == "function" &&
                                    (g =
                                        L({
                                            state: g,
                                            options: M,
                                            name: k,
                                            instance: _,
                                        }) || g);
                            }
                        }
                    }
                },
                update: Kl(function () {
                    return new Promise(function (x) {
                        _.forceUpdate(), x(g);
                    });
                }),
                destroy: function () {
                    y(), (A = !0);
                },
            };
        if (!fo(h, m)) return _;
        _.setOptions(c).then(function (x) {
            !A && c.onFirstUpdate && c.onFirstUpdate(x);
        });
        function E() {
            g.orderedModifiers.forEach(function (x) {
                var D = x.name,
                    I = x.options,
                    P = I === void 0 ? {} : I,
                    T = x.effect;
                if (typeof T == "function") {
                    var $ = T({ state: g, name: D, instance: _, options: P }),
                        L = function () {};
                    v.push($ || L);
                }
            });
        }
        function y() {
            v.forEach(function (x) {
                return x();
            }),
                (v = []);
        }
        return _;
    };
}
var ql = gn(),
    Ul = [os, ls, ss, ts],
    Gl = gn({ defaultModifiers: Ul }),
    Xl = [os, ls, ss, ts, ui, li, di, ii, ci],
    cs = gn({ defaultModifiers: Xl });
const us = Object.freeze(
    Object.defineProperty(
        {
            __proto__: null,
            afterMain: Go,
            afterRead: Yo,
            afterWrite: Zo,
            applyStyles: ts,
            arrow: ii,
            auto: pn,
            basePlacements: ye,
            beforeMain: qo,
            beforeRead: zo,
            beforeWrite: Xo,
            bottom: it,
            clippingParents: Wo,
            computeStyles: ss,
            createPopper: cs,
            createPopperBase: ql,
            createPopperLite: Gl,
            detectOverflow: _e,
            end: me,
            eventListeners: os,
            flip: li,
            hide: ci,
            left: Z,
            main: Uo,
            modifierPhases: Jo,
            offset: ui,
            placements: Zn,
            popper: de,
            popperGenerator: gn,
            popperOffsets: ls,
            preventOverflow: di,
            read: Ko,
            reference: Fo,
            right: rt,
            start: Ut,
            top: Q,
            variationPlacements: zn,
            viewport: Qn,
            write: Qo,
        },
        Symbol.toStringTag,
        { value: "Module" }
    )
);
/*!
 * Bootstrap v5.2.3 (https://getbootstrap.com/)
 * Copyright 2011-2022 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 */ const Ql = 1e6,
    Zl = 1e3,
    qn = "transitionend",
    Jl = (o) =>
        o == null
            ? `${o}`
            : Object.prototype.toString
                  .call(o)
                  .match(/\s([a-z]+)/i)[1]
                  .toLowerCase(),
    tc = (o) => {
        do o += Math.floor(Math.random() * Ql);
        while (document.getElementById(o));
        return o;
    },
    fi = (o) => {
        let t = o.getAttribute("data-bs-target");
        if (!t || t === "#") {
            let s = o.getAttribute("href");
            if (!s || (!s.includes("#") && !s.startsWith("."))) return null;
            s.includes("#") &&
                !s.startsWith("#") &&
                (s = `#${s.split("#")[1]}`),
                (t = s && s !== "#" ? s.trim() : null);
        }
        return t;
    },
    hi = (o) => {
        const t = fi(o);
        return t && document.querySelector(t) ? t : null;
    },
    St = (o) => {
        const t = fi(o);
        return t ? document.querySelector(t) : null;
    },
    ec = (o) => {
        if (!o) return 0;
        let { transitionDuration: t, transitionDelay: s } =
            window.getComputedStyle(o);
        const r = Number.parseFloat(t),
            l = Number.parseFloat(s);
        return !r && !l
            ? 0
            : ((t = t.split(",")[0]),
              (s = s.split(",")[0]),
              (Number.parseFloat(t) + Number.parseFloat(s)) * Zl);
    },
    pi = (o) => {
        o.dispatchEvent(new Event(qn));
    },
    xt = (o) =>
        !o || typeof o != "object"
            ? !1
            : (typeof o.jquery < "u" && (o = o[0]), typeof o.nodeType < "u"),
    Mt = (o) =>
        xt(o)
            ? o.jquery
                ? o[0]
                : o
            : typeof o == "string" && o.length > 0
            ? document.querySelector(o)
            : null,
    Ee = (o) => {
        if (!xt(o) || o.getClientRects().length === 0) return !1;
        const t =
                getComputedStyle(o).getPropertyValue("visibility") ===
                "visible",
            s = o.closest("details:not([open])");
        if (!s) return t;
        if (s !== o) {
            const r = o.closest("summary");
            if ((r && r.parentNode !== s) || r === null) return !1;
        }
        return t;
    },
    Bt = (o) =>
        !o ||
        o.nodeType !== Node.ELEMENT_NODE ||
        o.classList.contains("disabled")
            ? !0
            : typeof o.disabled < "u"
            ? o.disabled
            : o.hasAttribute("disabled") &&
              o.getAttribute("disabled") !== "false",
    mi = (o) => {
        if (!document.documentElement.attachShadow) return null;
        if (typeof o.getRootNode == "function") {
            const t = o.getRootNode();
            return t instanceof ShadowRoot ? t : null;
        }
        return o instanceof ShadowRoot
            ? o
            : o.parentNode
            ? mi(o.parentNode)
            : null;
    },
    dn = () => {},
    Ve = (o) => {
        o.offsetHeight;
    },
    gi = () =>
        window.jQuery && !document.body.hasAttribute("data-bs-no-jquery")
            ? window.jQuery
            : null,
    kn = [],
    nc = (o) => {
        document.readyState === "loading"
            ? (kn.length ||
                  document.addEventListener("DOMContentLoaded", () => {
                      for (const t of kn) t();
                  }),
              kn.push(o))
            : o();
    },
    ft = () => document.documentElement.dir === "rtl",
    ht = (o) => {
        nc(() => {
            const t = gi();
            if (t) {
                const s = o.NAME,
                    r = t.fn[s];
                (t.fn[s] = o.jQueryInterface),
                    (t.fn[s].Constructor = o),
                    (t.fn[s].noConflict = () => (
                        (t.fn[s] = r), o.jQueryInterface
                    ));
            }
        });
    },
    Ot = (o) => {
        typeof o == "function" && o();
    },
    wi = (o, t, s = !0) => {
        if (!s) {
            Ot(o);
            return;
        }
        const r = 5,
            l = ec(t) + r;
        let d = !1;
        const u = ({ target: h }) => {
            h === t && ((d = !0), t.removeEventListener(qn, u), Ot(o));
        };
        t.addEventListener(qn, u),
            setTimeout(() => {
                d || pi(t);
            }, l);
    },
    ds = (o, t, s, r) => {
        const l = o.length;
        let d = o.indexOf(t);
        return d === -1
            ? !s && r
                ? o[l - 1]
                : o[0]
            : ((d += s ? 1 : -1),
              r && (d = (d + l) % l),
              o[Math.max(0, Math.min(d, l - 1))]);
    },
    sc = /[^.]*(?=\..*)\.|.*/,
    oc = /\..*/,
    ic = /::\d+$/,
    Nn = {};
let ho = 1;
const bi = { mouseenter: "mouseover", mouseleave: "mouseout" },
    rc = new Set([
        "click",
        "dblclick",
        "mouseup",
        "mousedown",
        "contextmenu",
        "mousewheel",
        "DOMMouseScroll",
        "mouseover",
        "mouseout",
        "mousemove",
        "selectstart",
        "selectend",
        "keydown",
        "keypress",
        "keyup",
        "orientationchange",
        "touchstart",
        "touchmove",
        "touchend",
        "touchcancel",
        "pointerdown",
        "pointermove",
        "pointerup",
        "pointerleave",
        "pointercancel",
        "gesturestart",
        "gesturechange",
        "gestureend",
        "focus",
        "blur",
        "change",
        "reset",
        "select",
        "submit",
        "focusin",
        "focusout",
        "load",
        "unload",
        "beforeunload",
        "resize",
        "move",
        "DOMContentLoaded",
        "readystatechange",
        "error",
        "abort",
        "scroll",
    ]);
function _i(o, t) {
    return (t && `${t}::${ho++}`) || o.uidEvent || ho++;
}
function vi(o) {
    const t = _i(o);
    return (o.uidEvent = t), (Nn[t] = Nn[t] || {}), Nn[t];
}
function ac(o, t) {
    return function s(r) {
        return (
            fs(r, { delegateTarget: o }),
            s.oneOff && p.off(o, r.type, t),
            t.apply(o, [r])
        );
    };
}
function lc(o, t, s) {
    return function r(l) {
        const d = o.querySelectorAll(t);
        for (let { target: u } = l; u && u !== this; u = u.parentNode)
            for (const h of d)
                if (h === u)
                    return (
                        fs(l, { delegateTarget: u }),
                        r.oneOff && p.off(o, l.type, t, s),
                        s.apply(u, [l])
                    );
    };
}
function yi(o, t, s = null) {
    return Object.values(o).find(
        (r) => r.callable === t && r.delegationSelector === s
    );
}
function Ei(o, t, s) {
    const r = typeof t == "string",
        l = r ? s : t || s;
    let d = Ai(o);
    return rc.has(d) || (d = o), [r, l, d];
}
function po(o, t, s, r, l) {
    if (typeof t != "string" || !o) return;
    let [d, u, h] = Ei(t, s, r);
    t in bi &&
        (u = ((E) =>
            function (y) {
                if (
                    !y.relatedTarget ||
                    (y.relatedTarget !== y.delegateTarget &&
                        !y.delegateTarget.contains(y.relatedTarget))
                )
                    return E.call(this, y);
            })(u));
    const m = vi(o),
        c = m[h] || (m[h] = {}),
        g = yi(c, u, d ? s : null);
    if (g) {
        g.oneOff = g.oneOff && l;
        return;
    }
    const v = _i(u, t.replace(sc, "")),
        A = d ? lc(o, s, u) : ac(o, u);
    (A.delegationSelector = d ? s : null),
        (A.callable = u),
        (A.oneOff = l),
        (A.uidEvent = v),
        (c[v] = A),
        o.addEventListener(h, A, d);
}
function Un(o, t, s, r, l) {
    const d = yi(t[s], r, l);
    d && (o.removeEventListener(s, d, !!l), delete t[s][d.uidEvent]);
}
function cc(o, t, s, r) {
    const l = t[s] || {};
    for (const d of Object.keys(l))
        if (d.includes(r)) {
            const u = l[d];
            Un(o, t, s, u.callable, u.delegationSelector);
        }
}
function Ai(o) {
    return (o = o.replace(oc, "")), bi[o] || o;
}
const p = {
    on(o, t, s, r) {
        po(o, t, s, r, !1);
    },
    one(o, t, s, r) {
        po(o, t, s, r, !0);
    },
    off(o, t, s, r) {
        if (typeof t != "string" || !o) return;
        const [l, d, u] = Ei(t, s, r),
            h = u !== t,
            m = vi(o),
            c = m[u] || {},
            g = t.startsWith(".");
        if (typeof d < "u") {
            if (!Object.keys(c).length) return;
            Un(o, m, u, d, l ? s : null);
            return;
        }
        if (g) for (const v of Object.keys(m)) cc(o, m, v, t.slice(1));
        for (const v of Object.keys(c)) {
            const A = v.replace(ic, "");
            if (!h || t.includes(A)) {
                const _ = c[v];
                Un(o, m, u, _.callable, _.delegationSelector);
            }
        }
    },
    trigger(o, t, s) {
        if (typeof t != "string" || !o) return null;
        const r = gi(),
            l = Ai(t),
            d = t !== l;
        let u = null,
            h = !0,
            m = !0,
            c = !1;
        d &&
            r &&
            ((u = r.Event(t, s)),
            r(o).trigger(u),
            (h = !u.isPropagationStopped()),
            (m = !u.isImmediatePropagationStopped()),
            (c = u.isDefaultPrevented()));
        let g = new Event(t, { bubbles: h, cancelable: !0 });
        return (
            (g = fs(g, s)),
            c && g.preventDefault(),
            m && o.dispatchEvent(g),
            g.defaultPrevented && u && u.preventDefault(),
            g
        );
    },
};
function fs(o, t) {
    for (const [s, r] of Object.entries(t || {}))
        try {
            o[s] = r;
        } catch {
            Object.defineProperty(o, s, {
                configurable: !0,
                get() {
                    return r;
                },
            });
        }
    return o;
}
const Pt = new Map(),
    Dn = {
        set(o, t, s) {
            Pt.has(o) || Pt.set(o, new Map());
            const r = Pt.get(o);
            if (!r.has(t) && r.size !== 0) {
                console.error(
                    `Bootstrap doesn't allow more than one instance per element. Bound instance: ${
                        Array.from(r.keys())[0]
                    }.`
                );
                return;
            }
            r.set(t, s);
        },
        get(o, t) {
            return (Pt.has(o) && Pt.get(o).get(t)) || null;
        },
        remove(o, t) {
            if (!Pt.has(o)) return;
            const s = Pt.get(o);
            s.delete(t), s.size === 0 && Pt.delete(o);
        },
    };
function mo(o) {
    if (o === "true") return !0;
    if (o === "false") return !1;
    if (o === Number(o).toString()) return Number(o);
    if (o === "" || o === "null") return null;
    if (typeof o != "string") return o;
    try {
        return JSON.parse(decodeURIComponent(o));
    } catch {
        return o;
    }
}
function Pn(o) {
    return o.replace(/[A-Z]/g, (t) => `-${t.toLowerCase()}`);
}
const $t = {
    setDataAttribute(o, t, s) {
        o.setAttribute(`data-bs-${Pn(t)}`, s);
    },
    removeDataAttribute(o, t) {
        o.removeAttribute(`data-bs-${Pn(t)}`);
    },
    getDataAttributes(o) {
        if (!o) return {};
        const t = {},
            s = Object.keys(o.dataset).filter(
                (r) => r.startsWith("bs") && !r.startsWith("bsConfig")
            );
        for (const r of s) {
            let l = r.replace(/^bs/, "");
            (l = l.charAt(0).toLowerCase() + l.slice(1, l.length)),
                (t[l] = mo(o.dataset[r]));
        }
        return t;
    },
    getDataAttribute(o, t) {
        return mo(o.getAttribute(`data-bs-${Pn(t)}`));
    },
};
class He {
    static get Default() {
        return {};
    }
    static get DefaultType() {
        return {};
    }
    static get NAME() {
        throw new Error(
            'You have to implement the static method "NAME", for each component!'
        );
    }
    _getConfig(t) {
        return (
            (t = this._mergeConfigObj(t)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    _configAfterMerge(t) {
        return t;
    }
    _mergeConfigObj(t, s) {
        const r = xt(s) ? $t.getDataAttribute(s, "config") : {};
        return {
            ...this.constructor.Default,
            ...(typeof r == "object" ? r : {}),
            ...(xt(s) ? $t.getDataAttributes(s) : {}),
            ...(typeof t == "object" ? t : {}),
        };
    }
    _typeCheckConfig(t, s = this.constructor.DefaultType) {
        for (const r of Object.keys(s)) {
            const l = s[r],
                d = t[r],
                u = xt(d) ? "element" : Jl(d);
            if (!new RegExp(l).test(u))
                throw new TypeError(
                    `${this.constructor.NAME.toUpperCase()}: Option "${r}" provided type "${u}" but expected type "${l}".`
                );
        }
    }
}
const uc = "5.2.3";
class wt extends He {
    constructor(t, s) {
        super(),
            (t = Mt(t)),
            t &&
                ((this._element = t),
                (this._config = this._getConfig(s)),
                Dn.set(this._element, this.constructor.DATA_KEY, this));
    }
    dispose() {
        Dn.remove(this._element, this.constructor.DATA_KEY),
            p.off(this._element, this.constructor.EVENT_KEY);
        for (const t of Object.getOwnPropertyNames(this)) this[t] = null;
    }
    _queueCallback(t, s, r = !0) {
        wi(t, s, r);
    }
    _getConfig(t) {
        return (
            (t = this._mergeConfigObj(t, this._element)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    static getInstance(t) {
        return Dn.get(Mt(t), this.DATA_KEY);
    }
    static getOrCreateInstance(t, s = {}) {
        return (
            this.getInstance(t) || new this(t, typeof s == "object" ? s : null)
        );
    }
    static get VERSION() {
        return uc;
    }
    static get DATA_KEY() {
        return `bs.${this.NAME}`;
    }
    static get EVENT_KEY() {
        return `.${this.DATA_KEY}`;
    }
    static eventName(t) {
        return `${t}${this.EVENT_KEY}`;
    }
}
const wn = (o, t = "hide") => {
        const s = `click.dismiss${o.EVENT_KEY}`,
            r = o.NAME;
        p.on(document, s, `[data-bs-dismiss="${r}"]`, function (l) {
            if (
                (["A", "AREA"].includes(this.tagName) && l.preventDefault(),
                Bt(this))
            )
                return;
            const d = St(this) || this.closest(`.${r}`);
            o.getOrCreateInstance(d)[t]();
        });
    },
    dc = "alert",
    fc = "bs.alert",
    Ti = `.${fc}`,
    hc = `close${Ti}`,
    pc = `closed${Ti}`,
    mc = "fade",
    gc = "show";
class je extends wt {
    static get NAME() {
        return dc;
    }
    close() {
        if (p.trigger(this._element, hc).defaultPrevented) return;
        this._element.classList.remove(gc);
        const s = this._element.classList.contains(mc);
        this._queueCallback(() => this._destroyElement(), this._element, s);
    }
    _destroyElement() {
        this._element.remove(), p.trigger(this._element, pc), this.dispose();
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = je.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (s[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                s[t](this);
            }
        });
    }
}
wn(je, "close");
ht(je);
const wc = "button",
    bc = "bs.button",
    _c = `.${bc}`,
    vc = ".data-api",
    yc = "active",
    go = '[data-bs-toggle="button"]',
    Ec = `click${_c}${vc}`;
class We extends wt {
    static get NAME() {
        return wc;
    }
    toggle() {
        this._element.setAttribute(
            "aria-pressed",
            this._element.classList.toggle(yc)
        );
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = We.getOrCreateInstance(this);
            t === "toggle" && s[t]();
        });
    }
}
p.on(document, Ec, go, (o) => {
    o.preventDefault();
    const t = o.target.closest(go);
    We.getOrCreateInstance(t).toggle();
});
ht(We);
const C = {
        find(o, t = document.documentElement) {
            return [].concat(...Element.prototype.querySelectorAll.call(t, o));
        },
        findOne(o, t = document.documentElement) {
            return Element.prototype.querySelector.call(t, o);
        },
        children(o, t) {
            return [].concat(...o.children).filter((s) => s.matches(t));
        },
        parents(o, t) {
            const s = [];
            let r = o.parentNode.closest(t);
            for (; r; ) s.push(r), (r = r.parentNode.closest(t));
            return s;
        },
        prev(o, t) {
            let s = o.previousElementSibling;
            for (; s; ) {
                if (s.matches(t)) return [s];
                s = s.previousElementSibling;
            }
            return [];
        },
        next(o, t) {
            let s = o.nextElementSibling;
            for (; s; ) {
                if (s.matches(t)) return [s];
                s = s.nextElementSibling;
            }
            return [];
        },
        focusableChildren(o) {
            const t = [
                "a",
                "button",
                "input",
                "textarea",
                "select",
                "details",
                "[tabindex]",
                '[contenteditable="true"]',
            ]
                .map((s) => `${s}:not([tabindex^="-"])`)
                .join(",");
            return this.find(t, o).filter((s) => !Bt(s) && Ee(s));
        },
    },
    Ac = "swipe",
    Ae = ".bs.swipe",
    Tc = `touchstart${Ae}`,
    Cc = `touchmove${Ae}`,
    Oc = `touchend${Ae}`,
    Sc = `pointerdown${Ae}`,
    xc = `pointerup${Ae}`,
    $c = "touch",
    Lc = "pen",
    kc = "pointer-event",
    Nc = 40,
    Dc = { endCallback: null, leftCallback: null, rightCallback: null },
    Pc = {
        endCallback: "(function|null)",
        leftCallback: "(function|null)",
        rightCallback: "(function|null)",
    };
class fn extends He {
    constructor(t, s) {
        super(),
            (this._element = t),
            !(!t || !fn.isSupported()) &&
                ((this._config = this._getConfig(s)),
                (this._deltaX = 0),
                (this._supportPointerEvents = !!window.PointerEvent),
                this._initEvents());
    }
    static get Default() {
        return Dc;
    }
    static get DefaultType() {
        return Pc;
    }
    static get NAME() {
        return Ac;
    }
    dispose() {
        p.off(this._element, Ae);
    }
    _start(t) {
        if (!this._supportPointerEvents) {
            this._deltaX = t.touches[0].clientX;
            return;
        }
        this._eventIsPointerPenTouch(t) && (this._deltaX = t.clientX);
    }
    _end(t) {
        this._eventIsPointerPenTouch(t) &&
            (this._deltaX = t.clientX - this._deltaX),
            this._handleSwipe(),
            Ot(this._config.endCallback);
    }
    _move(t) {
        this._deltaX =
            t.touches && t.touches.length > 1
                ? 0
                : t.touches[0].clientX - this._deltaX;
    }
    _handleSwipe() {
        const t = Math.abs(this._deltaX);
        if (t <= Nc) return;
        const s = t / this._deltaX;
        (this._deltaX = 0),
            s &&
                Ot(
                    s > 0
                        ? this._config.rightCallback
                        : this._config.leftCallback
                );
    }
    _initEvents() {
        this._supportPointerEvents
            ? (p.on(this._element, Sc, (t) => this._start(t)),
              p.on(this._element, xc, (t) => this._end(t)),
              this._element.classList.add(kc))
            : (p.on(this._element, Tc, (t) => this._start(t)),
              p.on(this._element, Cc, (t) => this._move(t)),
              p.on(this._element, Oc, (t) => this._end(t)));
    }
    _eventIsPointerPenTouch(t) {
        return (
            this._supportPointerEvents &&
            (t.pointerType === Lc || t.pointerType === $c)
        );
    }
    static isSupported() {
        return (
            "ontouchstart" in document.documentElement ||
            navigator.maxTouchPoints > 0
        );
    }
}
const Ic = "carousel",
    Mc = "bs.carousel",
    Vt = `.${Mc}`,
    Ci = ".data-api",
    Bc = "ArrowLeft",
    Rc = "ArrowRight",
    Vc = 500,
    De = "next",
    ce = "prev",
    fe = "left",
    an = "right",
    Hc = `slide${Vt}`,
    In = `slid${Vt}`,
    jc = `keydown${Vt}`,
    Wc = `mouseenter${Vt}`,
    Fc = `mouseleave${Vt}`,
    zc = `dragstart${Vt}`,
    Kc = `load${Vt}${Ci}`,
    Yc = `click${Vt}${Ci}`,
    Oi = "carousel",
    Je = "active",
    qc = "slide",
    Uc = "carousel-item-end",
    Gc = "carousel-item-start",
    Xc = "carousel-item-next",
    Qc = "carousel-item-prev",
    Si = ".active",
    xi = ".carousel-item",
    Zc = Si + xi,
    Jc = ".carousel-item img",
    tu = ".carousel-indicators",
    eu = "[data-bs-slide], [data-bs-slide-to]",
    nu = '[data-bs-ride="carousel"]',
    su = { [Bc]: an, [Rc]: fe },
    ou = {
        interval: 5e3,
        keyboard: !0,
        pause: "hover",
        ride: !1,
        touch: !0,
        wrap: !0,
    },
    iu = {
        interval: "(number|boolean)",
        keyboard: "boolean",
        pause: "(string|boolean)",
        ride: "(boolean|string)",
        touch: "boolean",
        wrap: "boolean",
    };
class Te extends wt {
    constructor(t, s) {
        super(t, s),
            (this._interval = null),
            (this._activeElement = null),
            (this._isSliding = !1),
            (this.touchTimeout = null),
            (this._swipeHelper = null),
            (this._indicatorsElement = C.findOne(tu, this._element)),
            this._addEventListeners(),
            this._config.ride === Oi && this.cycle();
    }
    static get Default() {
        return ou;
    }
    static get DefaultType() {
        return iu;
    }
    static get NAME() {
        return Ic;
    }
    next() {
        this._slide(De);
    }
    nextWhenVisible() {
        !document.hidden && Ee(this._element) && this.next();
    }
    prev() {
        this._slide(ce);
    }
    pause() {
        this._isSliding && pi(this._element), this._clearInterval();
    }
    cycle() {
        this._clearInterval(),
            this._updateInterval(),
            (this._interval = setInterval(
                () => this.nextWhenVisible(),
                this._config.interval
            ));
    }
    _maybeEnableCycle() {
        if (this._config.ride) {
            if (this._isSliding) {
                p.one(this._element, In, () => this.cycle());
                return;
            }
            this.cycle();
        }
    }
    to(t) {
        const s = this._getItems();
        if (t > s.length - 1 || t < 0) return;
        if (this._isSliding) {
            p.one(this._element, In, () => this.to(t));
            return;
        }
        const r = this._getItemIndex(this._getActive());
        if (r === t) return;
        const l = t > r ? De : ce;
        this._slide(l, s[t]);
    }
    dispose() {
        this._swipeHelper && this._swipeHelper.dispose(), super.dispose();
    }
    _configAfterMerge(t) {
        return (t.defaultInterval = t.interval), t;
    }
    _addEventListeners() {
        this._config.keyboard &&
            p.on(this._element, jc, (t) => this._keydown(t)),
            this._config.pause === "hover" &&
                (p.on(this._element, Wc, () => this.pause()),
                p.on(this._element, Fc, () => this._maybeEnableCycle())),
            this._config.touch &&
                fn.isSupported() &&
                this._addTouchEventListeners();
    }
    _addTouchEventListeners() {
        for (const r of C.find(Jc, this._element))
            p.on(r, zc, (l) => l.preventDefault());
        const s = {
            leftCallback: () => this._slide(this._directionToOrder(fe)),
            rightCallback: () => this._slide(this._directionToOrder(an)),
            endCallback: () => {
                this._config.pause === "hover" &&
                    (this.pause(),
                    this.touchTimeout && clearTimeout(this.touchTimeout),
                    (this.touchTimeout = setTimeout(
                        () => this._maybeEnableCycle(),
                        Vc + this._config.interval
                    )));
            },
        };
        this._swipeHelper = new fn(this._element, s);
    }
    _keydown(t) {
        if (/input|textarea/i.test(t.target.tagName)) return;
        const s = su[t.key];
        s && (t.preventDefault(), this._slide(this._directionToOrder(s)));
    }
    _getItemIndex(t) {
        return this._getItems().indexOf(t);
    }
    _setActiveIndicatorElement(t) {
        if (!this._indicatorsElement) return;
        const s = C.findOne(Si, this._indicatorsElement);
        s.classList.remove(Je), s.removeAttribute("aria-current");
        const r = C.findOne(
            `[data-bs-slide-to="${t}"]`,
            this._indicatorsElement
        );
        r && (r.classList.add(Je), r.setAttribute("aria-current", "true"));
    }
    _updateInterval() {
        const t = this._activeElement || this._getActive();
        if (!t) return;
        const s = Number.parseInt(t.getAttribute("data-bs-interval"), 10);
        this._config.interval = s || this._config.defaultInterval;
    }
    _slide(t, s = null) {
        if (this._isSliding) return;
        const r = this._getActive(),
            l = t === De,
            d = s || ds(this._getItems(), r, l, this._config.wrap);
        if (d === r) return;
        const u = this._getItemIndex(d),
            h = (_) =>
                p.trigger(this._element, _, {
                    relatedTarget: d,
                    direction: this._orderToDirection(t),
                    from: this._getItemIndex(r),
                    to: u,
                });
        if (h(Hc).defaultPrevented || !r || !d) return;
        const c = !!this._interval;
        this.pause(),
            (this._isSliding = !0),
            this._setActiveIndicatorElement(u),
            (this._activeElement = d);
        const g = l ? Gc : Uc,
            v = l ? Xc : Qc;
        d.classList.add(v), Ve(d), r.classList.add(g), d.classList.add(g);
        const A = () => {
            d.classList.remove(g, v),
                d.classList.add(Je),
                r.classList.remove(Je, v, g),
                (this._isSliding = !1),
                h(In);
        };
        this._queueCallback(A, r, this._isAnimated()), c && this.cycle();
    }
    _isAnimated() {
        return this._element.classList.contains(qc);
    }
    _getActive() {
        return C.findOne(Zc, this._element);
    }
    _getItems() {
        return C.find(xi, this._element);
    }
    _clearInterval() {
        this._interval &&
            (clearInterval(this._interval), (this._interval = null));
    }
    _directionToOrder(t) {
        return ft() ? (t === fe ? ce : De) : t === fe ? De : ce;
    }
    _orderToDirection(t) {
        return ft() ? (t === ce ? fe : an) : t === ce ? an : fe;
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = Te.getOrCreateInstance(this, t);
            if (typeof t == "number") {
                s.to(t);
                return;
            }
            if (typeof t == "string") {
                if (s[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
}
p.on(document, Yc, eu, function (o) {
    const t = St(this);
    if (!t || !t.classList.contains(Oi)) return;
    o.preventDefault();
    const s = Te.getOrCreateInstance(t),
        r = this.getAttribute("data-bs-slide-to");
    if (r) {
        s.to(r), s._maybeEnableCycle();
        return;
    }
    if ($t.getDataAttribute(this, "slide") === "next") {
        s.next(), s._maybeEnableCycle();
        return;
    }
    s.prev(), s._maybeEnableCycle();
});
p.on(window, Kc, () => {
    const o = C.find(nu);
    for (const t of o) Te.getOrCreateInstance(t);
});
ht(Te);
const ru = "collapse",
    au = "bs.collapse",
    Fe = `.${au}`,
    lu = ".data-api",
    cu = `show${Fe}`,
    uu = `shown${Fe}`,
    du = `hide${Fe}`,
    fu = `hidden${Fe}`,
    hu = `click${Fe}${lu}`,
    Mn = "show",
    pe = "collapse",
    tn = "collapsing",
    pu = "collapsed",
    mu = `:scope .${pe} .${pe}`,
    gu = "collapse-horizontal",
    wu = "width",
    bu = "height",
    _u = ".collapse.show, .collapse.collapsing",
    Gn = '[data-bs-toggle="collapse"]',
    vu = { parent: null, toggle: !0 },
    yu = { parent: "(null|element)", toggle: "boolean" };
class ve extends wt {
    constructor(t, s) {
        super(t, s), (this._isTransitioning = !1), (this._triggerArray = []);
        const r = C.find(Gn);
        for (const l of r) {
            const d = hi(l),
                u = C.find(d).filter((h) => h === this._element);
            d !== null && u.length && this._triggerArray.push(l);
        }
        this._initializeChildren(),
            this._config.parent ||
                this._addAriaAndCollapsedClass(
                    this._triggerArray,
                    this._isShown()
                ),
            this._config.toggle && this.toggle();
    }
    static get Default() {
        return vu;
    }
    static get DefaultType() {
        return yu;
    }
    static get NAME() {
        return ru;
    }
    toggle() {
        this._isShown() ? this.hide() : this.show();
    }
    show() {
        if (this._isTransitioning || this._isShown()) return;
        let t = [];
        if (
            (this._config.parent &&
                (t = this._getFirstLevelChildren(_u)
                    .filter((h) => h !== this._element)
                    .map((h) => ve.getOrCreateInstance(h, { toggle: !1 }))),
            (t.length && t[0]._isTransitioning) ||
                p.trigger(this._element, cu).defaultPrevented)
        )
            return;
        for (const h of t) h.hide();
        const r = this._getDimension();
        this._element.classList.remove(pe),
            this._element.classList.add(tn),
            (this._element.style[r] = 0),
            this._addAriaAndCollapsedClass(this._triggerArray, !0),
            (this._isTransitioning = !0);
        const l = () => {
                (this._isTransitioning = !1),
                    this._element.classList.remove(tn),
                    this._element.classList.add(pe, Mn),
                    (this._element.style[r] = ""),
                    p.trigger(this._element, uu);
            },
            u = `scroll${r[0].toUpperCase() + r.slice(1)}`;
        this._queueCallback(l, this._element, !0),
            (this._element.style[r] = `${this._element[u]}px`);
    }
    hide() {
        if (
            this._isTransitioning ||
            !this._isShown() ||
            p.trigger(this._element, du).defaultPrevented
        )
            return;
        const s = this._getDimension();
        (this._element.style[s] = `${
            this._element.getBoundingClientRect()[s]
        }px`),
            Ve(this._element),
            this._element.classList.add(tn),
            this._element.classList.remove(pe, Mn);
        for (const l of this._triggerArray) {
            const d = St(l);
            d && !this._isShown(d) && this._addAriaAndCollapsedClass([l], !1);
        }
        this._isTransitioning = !0;
        const r = () => {
            (this._isTransitioning = !1),
                this._element.classList.remove(tn),
                this._element.classList.add(pe),
                p.trigger(this._element, fu);
        };
        (this._element.style[s] = ""),
            this._queueCallback(r, this._element, !0);
    }
    _isShown(t = this._element) {
        return t.classList.contains(Mn);
    }
    _configAfterMerge(t) {
        return (t.toggle = !!t.toggle), (t.parent = Mt(t.parent)), t;
    }
    _getDimension() {
        return this._element.classList.contains(gu) ? wu : bu;
    }
    _initializeChildren() {
        if (!this._config.parent) return;
        const t = this._getFirstLevelChildren(Gn);
        for (const s of t) {
            const r = St(s);
            r && this._addAriaAndCollapsedClass([s], this._isShown(r));
        }
    }
    _getFirstLevelChildren(t) {
        const s = C.find(mu, this._config.parent);
        return C.find(t, this._config.parent).filter((r) => !s.includes(r));
    }
    _addAriaAndCollapsedClass(t, s) {
        if (t.length)
            for (const r of t)
                r.classList.toggle(pu, !s), r.setAttribute("aria-expanded", s);
    }
    static jQueryInterface(t) {
        const s = {};
        return (
            typeof t == "string" && /show|hide/.test(t) && (s.toggle = !1),
            this.each(function () {
                const r = ve.getOrCreateInstance(this, s);
                if (typeof t == "string") {
                    if (typeof r[t] > "u")
                        throw new TypeError(`No method named "${t}"`);
                    r[t]();
                }
            })
        );
    }
}
p.on(document, hu, Gn, function (o) {
    (o.target.tagName === "A" ||
        (o.delegateTarget && o.delegateTarget.tagName === "A")) &&
        o.preventDefault();
    const t = hi(this),
        s = C.find(t);
    for (const r of s) ve.getOrCreateInstance(r, { toggle: !1 }).toggle();
});
ht(ve);
const wo = "dropdown",
    Eu = "bs.dropdown",
    Zt = `.${Eu}`,
    hs = ".data-api",
    Au = "Escape",
    bo = "Tab",
    Tu = "ArrowUp",
    _o = "ArrowDown",
    Cu = 2,
    Ou = `hide${Zt}`,
    Su = `hidden${Zt}`,
    xu = `show${Zt}`,
    $u = `shown${Zt}`,
    $i = `click${Zt}${hs}`,
    Li = `keydown${Zt}${hs}`,
    Lu = `keyup${Zt}${hs}`,
    he = "show",
    ku = "dropup",
    Nu = "dropend",
    Du = "dropstart",
    Pu = "dropup-center",
    Iu = "dropdown-center",
    Kt = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)',
    Mu = `${Kt}.${he}`,
    ln = ".dropdown-menu",
    Bu = ".navbar",
    Ru = ".navbar-nav",
    Vu = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",
    Hu = ft() ? "top-end" : "top-start",
    ju = ft() ? "top-start" : "top-end",
    Wu = ft() ? "bottom-end" : "bottom-start",
    Fu = ft() ? "bottom-start" : "bottom-end",
    zu = ft() ? "left-start" : "right-start",
    Ku = ft() ? "right-start" : "left-start",
    Yu = "top",
    qu = "bottom",
    Uu = {
        autoClose: !0,
        boundary: "clippingParents",
        display: "dynamic",
        offset: [0, 2],
        popperConfig: null,
        reference: "toggle",
    },
    Gu = {
        autoClose: "(boolean|string)",
        boundary: "(string|element)",
        display: "string",
        offset: "(array|string|function)",
        popperConfig: "(null|object|function)",
        reference: "(string|element|object)",
    };
class gt extends wt {
    constructor(t, s) {
        super(t, s),
            (this._popper = null),
            (this._parent = this._element.parentNode),
            (this._menu =
                C.next(this._element, ln)[0] ||
                C.prev(this._element, ln)[0] ||
                C.findOne(ln, this._parent)),
            (this._inNavbar = this._detectNavbar());
    }
    static get Default() {
        return Uu;
    }
    static get DefaultType() {
        return Gu;
    }
    static get NAME() {
        return wo;
    }
    toggle() {
        return this._isShown() ? this.hide() : this.show();
    }
    show() {
        if (Bt(this._element) || this._isShown()) return;
        const t = { relatedTarget: this._element };
        if (!p.trigger(this._element, xu, t).defaultPrevented) {
            if (
                (this._createPopper(),
                "ontouchstart" in document.documentElement &&
                    !this._parent.closest(Ru))
            )
                for (const r of [].concat(...document.body.children))
                    p.on(r, "mouseover", dn);
            this._element.focus(),
                this._element.setAttribute("aria-expanded", !0),
                this._menu.classList.add(he),
                this._element.classList.add(he),
                p.trigger(this._element, $u, t);
        }
    }
    hide() {
        if (Bt(this._element) || !this._isShown()) return;
        const t = { relatedTarget: this._element };
        this._completeHide(t);
    }
    dispose() {
        this._popper && this._popper.destroy(), super.dispose();
    }
    update() {
        (this._inNavbar = this._detectNavbar()),
            this._popper && this._popper.update();
    }
    _completeHide(t) {
        if (!p.trigger(this._element, Ou, t).defaultPrevented) {
            if ("ontouchstart" in document.documentElement)
                for (const r of [].concat(...document.body.children))
                    p.off(r, "mouseover", dn);
            this._popper && this._popper.destroy(),
                this._menu.classList.remove(he),
                this._element.classList.remove(he),
                this._element.setAttribute("aria-expanded", "false"),
                $t.removeDataAttribute(this._menu, "popper"),
                p.trigger(this._element, Su, t);
        }
    }
    _getConfig(t) {
        if (
            ((t = super._getConfig(t)),
            typeof t.reference == "object" &&
                !xt(t.reference) &&
                typeof t.reference.getBoundingClientRect != "function")
        )
            throw new TypeError(
                `${wo.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`
            );
        return t;
    }
    _createPopper() {
        if (typeof us > "u")
            throw new TypeError(
                "Bootstrap's dropdowns require Popper (https://popper.js.org)"
            );
        let t = this._element;
        this._config.reference === "parent"
            ? (t = this._parent)
            : xt(this._config.reference)
            ? (t = Mt(this._config.reference))
            : typeof this._config.reference == "object" &&
              (t = this._config.reference);
        const s = this._getPopperConfig();
        this._popper = cs(t, this._menu, s);
    }
    _isShown() {
        return this._menu.classList.contains(he);
    }
    _getPlacement() {
        const t = this._parent;
        if (t.classList.contains(Nu)) return zu;
        if (t.classList.contains(Du)) return Ku;
        if (t.classList.contains(Pu)) return Yu;
        if (t.classList.contains(Iu)) return qu;
        const s =
            getComputedStyle(this._menu)
                .getPropertyValue("--bs-position")
                .trim() === "end";
        return t.classList.contains(ku) ? (s ? ju : Hu) : s ? Fu : Wu;
    }
    _detectNavbar() {
        return this._element.closest(Bu) !== null;
    }
    _getOffset() {
        const { offset: t } = this._config;
        return typeof t == "string"
            ? t.split(",").map((s) => Number.parseInt(s, 10))
            : typeof t == "function"
            ? (s) => t(s, this._element)
            : t;
    }
    _getPopperConfig() {
        const t = {
            placement: this._getPlacement(),
            modifiers: [
                {
                    name: "preventOverflow",
                    options: { boundary: this._config.boundary },
                },
                { name: "offset", options: { offset: this._getOffset() } },
            ],
        };
        return (
            (this._inNavbar || this._config.display === "static") &&
                ($t.setDataAttribute(this._menu, "popper", "static"),
                (t.modifiers = [{ name: "applyStyles", enabled: !1 }])),
            {
                ...t,
                ...(typeof this._config.popperConfig == "function"
                    ? this._config.popperConfig(t)
                    : this._config.popperConfig),
            }
        );
    }
    _selectMenuItem({ key: t, target: s }) {
        const r = C.find(Vu, this._menu).filter((l) => Ee(l));
        r.length && ds(r, s, t === _o, !r.includes(s)).focus();
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = gt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
    static clearMenus(t) {
        if (t.button === Cu || (t.type === "keyup" && t.key !== bo)) return;
        const s = C.find(Mu);
        for (const r of s) {
            const l = gt.getInstance(r);
            if (!l || l._config.autoClose === !1) continue;
            const d = t.composedPath(),
                u = d.includes(l._menu);
            if (
                d.includes(l._element) ||
                (l._config.autoClose === "inside" && !u) ||
                (l._config.autoClose === "outside" && u) ||
                (l._menu.contains(t.target) &&
                    ((t.type === "keyup" && t.key === bo) ||
                        /input|select|option|textarea|form/i.test(
                            t.target.tagName
                        )))
            )
                continue;
            const h = { relatedTarget: l._element };
            t.type === "click" && (h.clickEvent = t), l._completeHide(h);
        }
    }
    static dataApiKeydownHandler(t) {
        const s = /input|textarea/i.test(t.target.tagName),
            r = t.key === Au,
            l = [Tu, _o].includes(t.key);
        if ((!l && !r) || (s && !r)) return;
        t.preventDefault();
        const d = this.matches(Kt)
                ? this
                : C.prev(this, Kt)[0] ||
                  C.next(this, Kt)[0] ||
                  C.findOne(Kt, t.delegateTarget.parentNode),
            u = gt.getOrCreateInstance(d);
        if (l) {
            t.stopPropagation(), u.show(), u._selectMenuItem(t);
            return;
        }
        u._isShown() && (t.stopPropagation(), u.hide(), d.focus());
    }
}
p.on(document, Li, Kt, gt.dataApiKeydownHandler);
p.on(document, Li, ln, gt.dataApiKeydownHandler);
p.on(document, $i, gt.clearMenus);
p.on(document, Lu, gt.clearMenus);
p.on(document, $i, Kt, function (o) {
    o.preventDefault(), gt.getOrCreateInstance(this).toggle();
});
ht(gt);
const vo = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
    yo = ".sticky-top",
    en = "padding-right",
    Eo = "margin-right";
class Xn {
    constructor() {
        this._element = document.body;
    }
    getWidth() {
        const t = document.documentElement.clientWidth;
        return Math.abs(window.innerWidth - t);
    }
    hide() {
        const t = this.getWidth();
        this._disableOverFlow(),
            this._setElementAttributes(this._element, en, (s) => s + t),
            this._setElementAttributes(vo, en, (s) => s + t),
            this._setElementAttributes(yo, Eo, (s) => s - t);
    }
    reset() {
        this._resetElementAttributes(this._element, "overflow"),
            this._resetElementAttributes(this._element, en),
            this._resetElementAttributes(vo, en),
            this._resetElementAttributes(yo, Eo);
    }
    isOverflowing() {
        return this.getWidth() > 0;
    }
    _disableOverFlow() {
        this._saveInitialAttribute(this._element, "overflow"),
            (this._element.style.overflow = "hidden");
    }
    _setElementAttributes(t, s, r) {
        const l = this.getWidth(),
            d = (u) => {
                if (
                    u !== this._element &&
                    window.innerWidth > u.clientWidth + l
                )
                    return;
                this._saveInitialAttribute(u, s);
                const h = window.getComputedStyle(u).getPropertyValue(s);
                u.style.setProperty(s, `${r(Number.parseFloat(h))}px`);
            };
        this._applyManipulationCallback(t, d);
    }
    _saveInitialAttribute(t, s) {
        const r = t.style.getPropertyValue(s);
        r && $t.setDataAttribute(t, s, r);
    }
    _resetElementAttributes(t, s) {
        const r = (l) => {
            const d = $t.getDataAttribute(l, s);
            if (d === null) {
                l.style.removeProperty(s);
                return;
            }
            $t.removeDataAttribute(l, s), l.style.setProperty(s, d);
        };
        this._applyManipulationCallback(t, r);
    }
    _applyManipulationCallback(t, s) {
        if (xt(t)) {
            s(t);
            return;
        }
        for (const r of C.find(t, this._element)) s(r);
    }
}
const ki = "backdrop",
    Xu = "fade",
    Ao = "show",
    To = `mousedown.bs.${ki}`,
    Qu = {
        className: "modal-backdrop",
        clickCallback: null,
        isAnimated: !1,
        isVisible: !0,
        rootElement: "body",
    },
    Zu = {
        className: "string",
        clickCallback: "(function|null)",
        isAnimated: "boolean",
        isVisible: "boolean",
        rootElement: "(element|string)",
    };
class Ni extends He {
    constructor(t) {
        super(),
            (this._config = this._getConfig(t)),
            (this._isAppended = !1),
            (this._element = null);
    }
    static get Default() {
        return Qu;
    }
    static get DefaultType() {
        return Zu;
    }
    static get NAME() {
        return ki;
    }
    show(t) {
        if (!this._config.isVisible) {
            Ot(t);
            return;
        }
        this._append();
        const s = this._getElement();
        this._config.isAnimated && Ve(s),
            s.classList.add(Ao),
            this._emulateAnimation(() => {
                Ot(t);
            });
    }
    hide(t) {
        if (!this._config.isVisible) {
            Ot(t);
            return;
        }
        this._getElement().classList.remove(Ao),
            this._emulateAnimation(() => {
                this.dispose(), Ot(t);
            });
    }
    dispose() {
        this._isAppended &&
            (p.off(this._element, To),
            this._element.remove(),
            (this._isAppended = !1));
    }
    _getElement() {
        if (!this._element) {
            const t = document.createElement("div");
            (t.className = this._config.className),
                this._config.isAnimated && t.classList.add(Xu),
                (this._element = t);
        }
        return this._element;
    }
    _configAfterMerge(t) {
        return (t.rootElement = Mt(t.rootElement)), t;
    }
    _append() {
        if (this._isAppended) return;
        const t = this._getElement();
        this._config.rootElement.append(t),
            p.on(t, To, () => {
                Ot(this._config.clickCallback);
            }),
            (this._isAppended = !0);
    }
    _emulateAnimation(t) {
        wi(t, this._getElement(), this._config.isAnimated);
    }
}
const Ju = "focustrap",
    td = "bs.focustrap",
    hn = `.${td}`,
    ed = `focusin${hn}`,
    nd = `keydown.tab${hn}`,
    sd = "Tab",
    od = "forward",
    Co = "backward",
    id = { autofocus: !0, trapElement: null },
    rd = { autofocus: "boolean", trapElement: "element" };
class Di extends He {
    constructor(t) {
        super(),
            (this._config = this._getConfig(t)),
            (this._isActive = !1),
            (this._lastTabNavDirection = null);
    }
    static get Default() {
        return id;
    }
    static get DefaultType() {
        return rd;
    }
    static get NAME() {
        return Ju;
    }
    activate() {
        this._isActive ||
            (this._config.autofocus && this._config.trapElement.focus(),
            p.off(document, hn),
            p.on(document, ed, (t) => this._handleFocusin(t)),
            p.on(document, nd, (t) => this._handleKeydown(t)),
            (this._isActive = !0));
    }
    deactivate() {
        this._isActive && ((this._isActive = !1), p.off(document, hn));
    }
    _handleFocusin(t) {
        const { trapElement: s } = this._config;
        if (t.target === document || t.target === s || s.contains(t.target))
            return;
        const r = C.focusableChildren(s);
        r.length === 0
            ? s.focus()
            : this._lastTabNavDirection === Co
            ? r[r.length - 1].focus()
            : r[0].focus();
    }
    _handleKeydown(t) {
        t.key === sd && (this._lastTabNavDirection = t.shiftKey ? Co : od);
    }
}
const ad = "modal",
    ld = "bs.modal",
    bt = `.${ld}`,
    cd = ".data-api",
    ud = "Escape",
    dd = `hide${bt}`,
    fd = `hidePrevented${bt}`,
    Pi = `hidden${bt}`,
    Ii = `show${bt}`,
    hd = `shown${bt}`,
    pd = `resize${bt}`,
    md = `click.dismiss${bt}`,
    gd = `mousedown.dismiss${bt}`,
    wd = `keydown.dismiss${bt}`,
    bd = `click${bt}${cd}`,
    Oo = "modal-open",
    _d = "fade",
    So = "show",
    Bn = "modal-static",
    vd = ".modal.show",
    yd = ".modal-dialog",
    Ed = ".modal-body",
    Ad = '[data-bs-toggle="modal"]',
    Td = { backdrop: !0, focus: !0, keyboard: !0 },
    Cd = {
        backdrop: "(boolean|string)",
        focus: "boolean",
        keyboard: "boolean",
    };
class Xt extends wt {
    constructor(t, s) {
        super(t, s),
            (this._dialog = C.findOne(yd, this._element)),
            (this._backdrop = this._initializeBackDrop()),
            (this._focustrap = this._initializeFocusTrap()),
            (this._isShown = !1),
            (this._isTransitioning = !1),
            (this._scrollBar = new Xn()),
            this._addEventListeners();
    }
    static get Default() {
        return Td;
    }
    static get DefaultType() {
        return Cd;
    }
    static get NAME() {
        return ad;
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t);
    }
    show(t) {
        this._isShown ||
            this._isTransitioning ||
            p.trigger(this._element, Ii, { relatedTarget: t })
                .defaultPrevented ||
            ((this._isShown = !0),
            (this._isTransitioning = !0),
            this._scrollBar.hide(),
            document.body.classList.add(Oo),
            this._adjustDialog(),
            this._backdrop.show(() => this._showElement(t)));
    }
    hide() {
        !this._isShown ||
            this._isTransitioning ||
            p.trigger(this._element, dd).defaultPrevented ||
            ((this._isShown = !1),
            (this._isTransitioning = !0),
            this._focustrap.deactivate(),
            this._element.classList.remove(So),
            this._queueCallback(
                () => this._hideModal(),
                this._element,
                this._isAnimated()
            ));
    }
    dispose() {
        for (const t of [window, this._dialog]) p.off(t, bt);
        this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose();
    }
    handleUpdate() {
        this._adjustDialog();
    }
    _initializeBackDrop() {
        return new Ni({
            isVisible: !!this._config.backdrop,
            isAnimated: this._isAnimated(),
        });
    }
    _initializeFocusTrap() {
        return new Di({ trapElement: this._element });
    }
    _showElement(t) {
        document.body.contains(this._element) ||
            document.body.append(this._element),
            (this._element.style.display = "block"),
            this._element.removeAttribute("aria-hidden"),
            this._element.setAttribute("aria-modal", !0),
            this._element.setAttribute("role", "dialog"),
            (this._element.scrollTop = 0);
        const s = C.findOne(Ed, this._dialog);
        s && (s.scrollTop = 0),
            Ve(this._element),
            this._element.classList.add(So);
        const r = () => {
            this._config.focus && this._focustrap.activate(),
                (this._isTransitioning = !1),
                p.trigger(this._element, hd, { relatedTarget: t });
        };
        this._queueCallback(r, this._dialog, this._isAnimated());
    }
    _addEventListeners() {
        p.on(this._element, wd, (t) => {
            if (t.key === ud) {
                if (this._config.keyboard) {
                    t.preventDefault(), this.hide();
                    return;
                }
                this._triggerBackdropTransition();
            }
        }),
            p.on(window, pd, () => {
                this._isShown && !this._isTransitioning && this._adjustDialog();
            }),
            p.on(this._element, gd, (t) => {
                p.one(this._element, md, (s) => {
                    if (
                        !(
                            this._element !== t.target ||
                            this._element !== s.target
                        )
                    ) {
                        if (this._config.backdrop === "static") {
                            this._triggerBackdropTransition();
                            return;
                        }
                        this._config.backdrop && this.hide();
                    }
                });
            });
    }
    _hideModal() {
        (this._element.style.display = "none"),
            this._element.setAttribute("aria-hidden", !0),
            this._element.removeAttribute("aria-modal"),
            this._element.removeAttribute("role"),
            (this._isTransitioning = !1),
            this._backdrop.hide(() => {
                document.body.classList.remove(Oo),
                    this._resetAdjustments(),
                    this._scrollBar.reset(),
                    p.trigger(this._element, Pi);
            });
    }
    _isAnimated() {
        return this._element.classList.contains(_d);
    }
    _triggerBackdropTransition() {
        if (p.trigger(this._element, fd).defaultPrevented) return;
        const s =
                this._element.scrollHeight >
                document.documentElement.clientHeight,
            r = this._element.style.overflowY;
        r === "hidden" ||
            this._element.classList.contains(Bn) ||
            (s || (this._element.style.overflowY = "hidden"),
            this._element.classList.add(Bn),
            this._queueCallback(() => {
                this._element.classList.remove(Bn),
                    this._queueCallback(() => {
                        this._element.style.overflowY = r;
                    }, this._dialog);
            }, this._dialog),
            this._element.focus());
    }
    _adjustDialog() {
        const t =
                this._element.scrollHeight >
                document.documentElement.clientHeight,
            s = this._scrollBar.getWidth(),
            r = s > 0;
        if (r && !t) {
            const l = ft() ? "paddingLeft" : "paddingRight";
            this._element.style[l] = `${s}px`;
        }
        if (!r && t) {
            const l = ft() ? "paddingRight" : "paddingLeft";
            this._element.style[l] = `${s}px`;
        }
    }
    _resetAdjustments() {
        (this._element.style.paddingLeft = ""),
            (this._element.style.paddingRight = "");
    }
    static jQueryInterface(t, s) {
        return this.each(function () {
            const r = Xt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof r[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                r[t](s);
            }
        });
    }
}
p.on(document, bd, Ad, function (o) {
    const t = St(this);
    ["A", "AREA"].includes(this.tagName) && o.preventDefault(),
        p.one(t, Ii, (l) => {
            l.defaultPrevented ||
                p.one(t, Pi, () => {
                    Ee(this) && this.focus();
                });
        });
    const s = C.findOne(vd);
    s && Xt.getInstance(s).hide(), Xt.getOrCreateInstance(t).toggle(this);
});
wn(Xt);
ht(Xt);
const Od = "offcanvas",
    Sd = "bs.offcanvas",
    Nt = `.${Sd}`,
    Mi = ".data-api",
    xd = `load${Nt}${Mi}`,
    $d = "Escape",
    xo = "show",
    $o = "showing",
    Lo = "hiding",
    Ld = "offcanvas-backdrop",
    Bi = ".offcanvas.show",
    kd = `show${Nt}`,
    Nd = `shown${Nt}`,
    Dd = `hide${Nt}`,
    ko = `hidePrevented${Nt}`,
    Ri = `hidden${Nt}`,
    Pd = `resize${Nt}`,
    Id = `click${Nt}${Mi}`,
    Md = `keydown.dismiss${Nt}`,
    Bd = '[data-bs-toggle="offcanvas"]',
    Rd = { backdrop: !0, keyboard: !0, scroll: !1 },
    Vd = {
        backdrop: "(boolean|string)",
        keyboard: "boolean",
        scroll: "boolean",
    };
class kt extends wt {
    constructor(t, s) {
        super(t, s),
            (this._isShown = !1),
            (this._backdrop = this._initializeBackDrop()),
            (this._focustrap = this._initializeFocusTrap()),
            this._addEventListeners();
    }
    static get Default() {
        return Rd;
    }
    static get DefaultType() {
        return Vd;
    }
    static get NAME() {
        return Od;
    }
    toggle(t) {
        return this._isShown ? this.hide() : this.show(t);
    }
    show(t) {
        if (
            this._isShown ||
            p.trigger(this._element, kd, { relatedTarget: t }).defaultPrevented
        )
            return;
        (this._isShown = !0),
            this._backdrop.show(),
            this._config.scroll || new Xn().hide(),
            this._element.setAttribute("aria-modal", !0),
            this._element.setAttribute("role", "dialog"),
            this._element.classList.add($o);
        const r = () => {
            (!this._config.scroll || this._config.backdrop) &&
                this._focustrap.activate(),
                this._element.classList.add(xo),
                this._element.classList.remove($o),
                p.trigger(this._element, Nd, { relatedTarget: t });
        };
        this._queueCallback(r, this._element, !0);
    }
    hide() {
        if (!this._isShown || p.trigger(this._element, Dd).defaultPrevented)
            return;
        this._focustrap.deactivate(),
            this._element.blur(),
            (this._isShown = !1),
            this._element.classList.add(Lo),
            this._backdrop.hide();
        const s = () => {
            this._element.classList.remove(xo, Lo),
                this._element.removeAttribute("aria-modal"),
                this._element.removeAttribute("role"),
                this._config.scroll || new Xn().reset(),
                p.trigger(this._element, Ri);
        };
        this._queueCallback(s, this._element, !0);
    }
    dispose() {
        this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose();
    }
    _initializeBackDrop() {
        const t = () => {
                if (this._config.backdrop === "static") {
                    p.trigger(this._element, ko);
                    return;
                }
                this.hide();
            },
            s = !!this._config.backdrop;
        return new Ni({
            className: Ld,
            isVisible: s,
            isAnimated: !0,
            rootElement: this._element.parentNode,
            clickCallback: s ? t : null,
        });
    }
    _initializeFocusTrap() {
        return new Di({ trapElement: this._element });
    }
    _addEventListeners() {
        p.on(this._element, Md, (t) => {
            if (t.key === $d) {
                if (!this._config.keyboard) {
                    p.trigger(this._element, ko);
                    return;
                }
                this.hide();
            }
        });
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = kt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (s[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                s[t](this);
            }
        });
    }
}
p.on(document, Id, Bd, function (o) {
    const t = St(this);
    if ((["A", "AREA"].includes(this.tagName) && o.preventDefault(), Bt(this)))
        return;
    p.one(t, Ri, () => {
        Ee(this) && this.focus();
    });
    const s = C.findOne(Bi);
    s && s !== t && kt.getInstance(s).hide(),
        kt.getOrCreateInstance(t).toggle(this);
});
p.on(window, xd, () => {
    for (const o of C.find(Bi)) kt.getOrCreateInstance(o).show();
});
p.on(window, Pd, () => {
    for (const o of C.find("[aria-modal][class*=show][class*=offcanvas-]"))
        getComputedStyle(o).position !== "fixed" &&
            kt.getOrCreateInstance(o).hide();
});
wn(kt);
ht(kt);
const Hd = new Set([
        "background",
        "cite",
        "href",
        "itemtype",
        "longdesc",
        "poster",
        "src",
        "xlink:href",
    ]),
    jd = /^aria-[\w-]*$/i,
    Wd = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i,
    Fd =
        /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i,
    zd = (o, t) => {
        const s = o.nodeName.toLowerCase();
        return t.includes(s)
            ? Hd.has(s)
                ? !!(Wd.test(o.nodeValue) || Fd.test(o.nodeValue))
                : !0
            : t.filter((r) => r instanceof RegExp).some((r) => r.test(s));
    },
    Vi = {
        "*": ["class", "dir", "id", "lang", "role", jd],
        a: ["target", "href", "title", "rel"],
        area: [],
        b: [],
        br: [],
        col: [],
        code: [],
        div: [],
        em: [],
        hr: [],
        h1: [],
        h2: [],
        h3: [],
        h4: [],
        h5: [],
        h6: [],
        i: [],
        img: ["src", "srcset", "alt", "title", "width", "height"],
        li: [],
        ol: [],
        p: [],
        pre: [],
        s: [],
        small: [],
        span: [],
        sub: [],
        sup: [],
        strong: [],
        u: [],
        ul: [],
    };
function Kd(o, t, s) {
    if (!o.length) return o;
    if (s && typeof s == "function") return s(o);
    const l = new window.DOMParser().parseFromString(o, "text/html"),
        d = [].concat(...l.body.querySelectorAll("*"));
    for (const u of d) {
        const h = u.nodeName.toLowerCase();
        if (!Object.keys(t).includes(h)) {
            u.remove();
            continue;
        }
        const m = [].concat(...u.attributes),
            c = [].concat(t["*"] || [], t[h] || []);
        for (const g of m) zd(g, c) || u.removeAttribute(g.nodeName);
    }
    return l.body.innerHTML;
}
const Yd = "TemplateFactory",
    qd = {
        allowList: Vi,
        content: {},
        extraClass: "",
        html: !1,
        sanitize: !0,
        sanitizeFn: null,
        template: "<div></div>",
    },
    Ud = {
        allowList: "object",
        content: "object",
        extraClass: "(string|function)",
        html: "boolean",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        template: "string",
    },
    Gd = {
        entry: "(string|element|function|null)",
        selector: "(string|element)",
    };
class Xd extends He {
    constructor(t) {
        super(), (this._config = this._getConfig(t));
    }
    static get Default() {
        return qd;
    }
    static get DefaultType() {
        return Ud;
    }
    static get NAME() {
        return Yd;
    }
    getContent() {
        return Object.values(this._config.content)
            .map((t) => this._resolvePossibleFunction(t))
            .filter(Boolean);
    }
    hasContent() {
        return this.getContent().length > 0;
    }
    changeContent(t) {
        return (
            this._checkContent(t),
            (this._config.content = { ...this._config.content, ...t }),
            this
        );
    }
    toHtml() {
        const t = document.createElement("div");
        t.innerHTML = this._maybeSanitize(this._config.template);
        for (const [l, d] of Object.entries(this._config.content))
            this._setContent(t, d, l);
        const s = t.children[0],
            r = this._resolvePossibleFunction(this._config.extraClass);
        return r && s.classList.add(...r.split(" ")), s;
    }
    _typeCheckConfig(t) {
        super._typeCheckConfig(t), this._checkContent(t.content);
    }
    _checkContent(t) {
        for (const [s, r] of Object.entries(t))
            super._typeCheckConfig({ selector: s, entry: r }, Gd);
    }
    _setContent(t, s, r) {
        const l = C.findOne(r, t);
        if (l) {
            if (((s = this._resolvePossibleFunction(s)), !s)) {
                l.remove();
                return;
            }
            if (xt(s)) {
                this._putElementInTemplate(Mt(s), l);
                return;
            }
            if (this._config.html) {
                l.innerHTML = this._maybeSanitize(s);
                return;
            }
            l.textContent = s;
        }
    }
    _maybeSanitize(t) {
        return this._config.sanitize
            ? Kd(t, this._config.allowList, this._config.sanitizeFn)
            : t;
    }
    _resolvePossibleFunction(t) {
        return typeof t == "function" ? t(this) : t;
    }
    _putElementInTemplate(t, s) {
        if (this._config.html) {
            (s.innerHTML = ""), s.append(t);
            return;
        }
        s.textContent = t.textContent;
    }
}
const Qd = "tooltip",
    Zd = new Set(["sanitize", "allowList", "sanitizeFn"]),
    Rn = "fade",
    Jd = "modal",
    nn = "show",
    tf = ".tooltip-inner",
    No = `.${Jd}`,
    Do = "hide.bs.modal",
    Pe = "hover",
    Vn = "focus",
    ef = "click",
    nf = "manual",
    sf = "hide",
    of = "hidden",
    rf = "show",
    af = "shown",
    lf = "inserted",
    cf = "click",
    uf = "focusin",
    df = "focusout",
    ff = "mouseenter",
    hf = "mouseleave",
    pf = {
        AUTO: "auto",
        TOP: "top",
        RIGHT: ft() ? "left" : "right",
        BOTTOM: "bottom",
        LEFT: ft() ? "right" : "left",
    },
    mf = {
        allowList: Vi,
        animation: !0,
        boundary: "clippingParents",
        container: !1,
        customClass: "",
        delay: 0,
        fallbackPlacements: ["top", "right", "bottom", "left"],
        html: !1,
        offset: [0, 0],
        placement: "top",
        popperConfig: null,
        sanitize: !0,
        sanitizeFn: null,
        selector: !1,
        template:
            '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        title: "",
        trigger: "hover focus",
    },
    gf = {
        allowList: "object",
        animation: "boolean",
        boundary: "(string|element)",
        container: "(string|element|boolean)",
        customClass: "(string|function)",
        delay: "(number|object)",
        fallbackPlacements: "array",
        html: "boolean",
        offset: "(array|string|function)",
        placement: "(string|function)",
        popperConfig: "(null|object|function)",
        sanitize: "boolean",
        sanitizeFn: "(null|function)",
        selector: "(string|boolean)",
        template: "string",
        title: "(string|element|function)",
        trigger: "string",
    };
class Jt extends wt {
    constructor(t, s) {
        if (typeof us > "u")
            throw new TypeError(
                "Bootstrap's tooltips require Popper (https://popper.js.org)"
            );
        super(t, s),
            (this._isEnabled = !0),
            (this._timeout = 0),
            (this._isHovered = null),
            (this._activeTrigger = {}),
            (this._popper = null),
            (this._templateFactory = null),
            (this._newContent = null),
            (this.tip = null),
            this._setListeners(),
            this._config.selector || this._fixTitle();
    }
    static get Default() {
        return mf;
    }
    static get DefaultType() {
        return gf;
    }
    static get NAME() {
        return Qd;
    }
    enable() {
        this._isEnabled = !0;
    }
    disable() {
        this._isEnabled = !1;
    }
    toggleEnabled() {
        this._isEnabled = !this._isEnabled;
    }
    toggle() {
        if (this._isEnabled) {
            if (
                ((this._activeTrigger.click = !this._activeTrigger.click),
                this._isShown())
            ) {
                this._leave();
                return;
            }
            this._enter();
        }
    }
    dispose() {
        clearTimeout(this._timeout),
            p.off(this._element.closest(No), Do, this._hideModalHandler),
            this._element.getAttribute("data-bs-original-title") &&
                this._element.setAttribute(
                    "title",
                    this._element.getAttribute("data-bs-original-title")
                ),
            this._disposePopper(),
            super.dispose();
    }
    show() {
        if (this._element.style.display === "none")
            throw new Error("Please use show on visible elements");
        if (!(this._isWithContent() && this._isEnabled)) return;
        const t = p.trigger(this._element, this.constructor.eventName(rf)),
            r = (
                mi(this._element) || this._element.ownerDocument.documentElement
            ).contains(this._element);
        if (t.defaultPrevented || !r) return;
        this._disposePopper();
        const l = this._getTipElement();
        this._element.setAttribute("aria-describedby", l.getAttribute("id"));
        const { container: d } = this._config;
        if (
            (this._element.ownerDocument.documentElement.contains(this.tip) ||
                (d.append(l),
                p.trigger(this._element, this.constructor.eventName(lf))),
            (this._popper = this._createPopper(l)),
            l.classList.add(nn),
            "ontouchstart" in document.documentElement)
        )
            for (const h of [].concat(...document.body.children))
                p.on(h, "mouseover", dn);
        const u = () => {
            p.trigger(this._element, this.constructor.eventName(af)),
                this._isHovered === !1 && this._leave(),
                (this._isHovered = !1);
        };
        this._queueCallback(u, this.tip, this._isAnimated());
    }
    hide() {
        if (
            !this._isShown() ||
            p.trigger(this._element, this.constructor.eventName(sf))
                .defaultPrevented
        )
            return;
        if (
            (this._getTipElement().classList.remove(nn),
            "ontouchstart" in document.documentElement)
        )
            for (const l of [].concat(...document.body.children))
                p.off(l, "mouseover", dn);
        (this._activeTrigger[ef] = !1),
            (this._activeTrigger[Vn] = !1),
            (this._activeTrigger[Pe] = !1),
            (this._isHovered = null);
        const r = () => {
            this._isWithActiveTrigger() ||
                (this._isHovered || this._disposePopper(),
                this._element.removeAttribute("aria-describedby"),
                p.trigger(this._element, this.constructor.eventName(of)));
        };
        this._queueCallback(r, this.tip, this._isAnimated());
    }
    update() {
        this._popper && this._popper.update();
    }
    _isWithContent() {
        return !!this._getTitle();
    }
    _getTipElement() {
        return (
            this.tip ||
                (this.tip = this._createTipElement(
                    this._newContent || this._getContentForTemplate()
                )),
            this.tip
        );
    }
    _createTipElement(t) {
        const s = this._getTemplateFactory(t).toHtml();
        if (!s) return null;
        s.classList.remove(Rn, nn),
            s.classList.add(`bs-${this.constructor.NAME}-auto`);
        const r = tc(this.constructor.NAME).toString();
        return (
            s.setAttribute("id", r),
            this._isAnimated() && s.classList.add(Rn),
            s
        );
    }
    setContent(t) {
        (this._newContent = t),
            this._isShown() && (this._disposePopper(), this.show());
    }
    _getTemplateFactory(t) {
        return (
            this._templateFactory
                ? this._templateFactory.changeContent(t)
                : (this._templateFactory = new Xd({
                      ...this._config,
                      content: t,
                      extraClass: this._resolvePossibleFunction(
                          this._config.customClass
                      ),
                  })),
            this._templateFactory
        );
    }
    _getContentForTemplate() {
        return { [tf]: this._getTitle() };
    }
    _getTitle() {
        return (
            this._resolvePossibleFunction(this._config.title) ||
            this._element.getAttribute("data-bs-original-title")
        );
    }
    _initializeOnDelegatedTarget(t) {
        return this.constructor.getOrCreateInstance(
            t.delegateTarget,
            this._getDelegateConfig()
        );
    }
    _isAnimated() {
        return (
            this._config.animation ||
            (this.tip && this.tip.classList.contains(Rn))
        );
    }
    _isShown() {
        return this.tip && this.tip.classList.contains(nn);
    }
    _createPopper(t) {
        const s =
                typeof this._config.placement == "function"
                    ? this._config.placement.call(this, t, this._element)
                    : this._config.placement,
            r = pf[s.toUpperCase()];
        return cs(this._element, t, this._getPopperConfig(r));
    }
    _getOffset() {
        const { offset: t } = this._config;
        return typeof t == "string"
            ? t.split(",").map((s) => Number.parseInt(s, 10))
            : typeof t == "function"
            ? (s) => t(s, this._element)
            : t;
    }
    _resolvePossibleFunction(t) {
        return typeof t == "function" ? t.call(this._element) : t;
    }
    _getPopperConfig(t) {
        const s = {
            placement: t,
            modifiers: [
                {
                    name: "flip",
                    options: {
                        fallbackPlacements: this._config.fallbackPlacements,
                    },
                },
                { name: "offset", options: { offset: this._getOffset() } },
                {
                    name: "preventOverflow",
                    options: { boundary: this._config.boundary },
                },
                {
                    name: "arrow",
                    options: { element: `.${this.constructor.NAME}-arrow` },
                },
                {
                    name: "preSetPlacement",
                    enabled: !0,
                    phase: "beforeMain",
                    fn: (r) => {
                        this._getTipElement().setAttribute(
                            "data-popper-placement",
                            r.state.placement
                        );
                    },
                },
            ],
        };
        return {
            ...s,
            ...(typeof this._config.popperConfig == "function"
                ? this._config.popperConfig(s)
                : this._config.popperConfig),
        };
    }
    _setListeners() {
        const t = this._config.trigger.split(" ");
        for (const s of t)
            if (s === "click")
                p.on(
                    this._element,
                    this.constructor.eventName(cf),
                    this._config.selector,
                    (r) => {
                        this._initializeOnDelegatedTarget(r).toggle();
                    }
                );
            else if (s !== nf) {
                const r =
                        s === Pe
                            ? this.constructor.eventName(ff)
                            : this.constructor.eventName(uf),
                    l =
                        s === Pe
                            ? this.constructor.eventName(hf)
                            : this.constructor.eventName(df);
                p.on(this._element, r, this._config.selector, (d) => {
                    const u = this._initializeOnDelegatedTarget(d);
                    (u._activeTrigger[d.type === "focusin" ? Vn : Pe] = !0),
                        u._enter();
                }),
                    p.on(this._element, l, this._config.selector, (d) => {
                        const u = this._initializeOnDelegatedTarget(d);
                        (u._activeTrigger[d.type === "focusout" ? Vn : Pe] =
                            u._element.contains(d.relatedTarget)),
                            u._leave();
                    });
            }
        (this._hideModalHandler = () => {
            this._element && this.hide();
        }),
            p.on(this._element.closest(No), Do, this._hideModalHandler);
    }
    _fixTitle() {
        const t = this._element.getAttribute("title");
        t &&
            (!this._element.getAttribute("aria-label") &&
                !this._element.textContent.trim() &&
                this._element.setAttribute("aria-label", t),
            this._element.setAttribute("data-bs-original-title", t),
            this._element.removeAttribute("title"));
    }
    _enter() {
        if (this._isShown() || this._isHovered) {
            this._isHovered = !0;
            return;
        }
        (this._isHovered = !0),
            this._setTimeout(() => {
                this._isHovered && this.show();
            }, this._config.delay.show);
    }
    _leave() {
        this._isWithActiveTrigger() ||
            ((this._isHovered = !1),
            this._setTimeout(() => {
                this._isHovered || this.hide();
            }, this._config.delay.hide));
    }
    _setTimeout(t, s) {
        clearTimeout(this._timeout), (this._timeout = setTimeout(t, s));
    }
    _isWithActiveTrigger() {
        return Object.values(this._activeTrigger).includes(!0);
    }
    _getConfig(t) {
        const s = $t.getDataAttributes(this._element);
        for (const r of Object.keys(s)) Zd.has(r) && delete s[r];
        return (
            (t = { ...s, ...(typeof t == "object" && t ? t : {}) }),
            (t = this._mergeConfigObj(t)),
            (t = this._configAfterMerge(t)),
            this._typeCheckConfig(t),
            t
        );
    }
    _configAfterMerge(t) {
        return (
            (t.container =
                t.container === !1 ? document.body : Mt(t.container)),
            typeof t.delay == "number" &&
                (t.delay = { show: t.delay, hide: t.delay }),
            typeof t.title == "number" && (t.title = t.title.toString()),
            typeof t.content == "number" && (t.content = t.content.toString()),
            t
        );
    }
    _getDelegateConfig() {
        const t = {};
        for (const s in this._config)
            this.constructor.Default[s] !== this._config[s] &&
                (t[s] = this._config[s]);
        return (t.selector = !1), (t.trigger = "manual"), t;
    }
    _disposePopper() {
        this._popper && (this._popper.destroy(), (this._popper = null)),
            this.tip && (this.tip.remove(), (this.tip = null));
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = Jt.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
}
ht(Jt);
const wf = "popover",
    bf = ".popover-header",
    _f = ".popover-body",
    vf = {
        ...Jt.Default,
        content: "",
        offset: [0, 8],
        placement: "right",
        template:
            '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        trigger: "click",
    },
    yf = { ...Jt.DefaultType, content: "(null|string|element|function)" };
class bn extends Jt {
    static get Default() {
        return vf;
    }
    static get DefaultType() {
        return yf;
    }
    static get NAME() {
        return wf;
    }
    _isWithContent() {
        return this._getTitle() || this._getContent();
    }
    _getContentForTemplate() {
        return { [bf]: this._getTitle(), [_f]: this._getContent() };
    }
    _getContent() {
        return this._resolvePossibleFunction(this._config.content);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = bn.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
}
ht(bn);
const Ef = "scrollspy",
    Af = "bs.scrollspy",
    ps = `.${Af}`,
    Tf = ".data-api",
    Cf = `activate${ps}`,
    Po = `click${ps}`,
    Of = `load${ps}${Tf}`,
    Sf = "dropdown-item",
    ue = "active",
    xf = '[data-bs-spy="scroll"]',
    Hn = "[href]",
    $f = ".nav, .list-group",
    Io = ".nav-link",
    Lf = ".nav-item",
    kf = ".list-group-item",
    Nf = `${Io}, ${Lf} > ${Io}, ${kf}`,
    Df = ".dropdown",
    Pf = ".dropdown-toggle",
    If = {
        offset: null,
        rootMargin: "0px 0px -25%",
        smoothScroll: !1,
        target: null,
        threshold: [0.1, 0.5, 1],
    },
    Mf = {
        offset: "(number|null)",
        rootMargin: "string",
        smoothScroll: "boolean",
        target: "element",
        threshold: "array",
    };
class ze extends wt {
    constructor(t, s) {
        super(t, s),
            (this._targetLinks = new Map()),
            (this._observableSections = new Map()),
            (this._rootElement =
                getComputedStyle(this._element).overflowY === "visible"
                    ? null
                    : this._element),
            (this._activeTarget = null),
            (this._observer = null),
            (this._previousScrollData = {
                visibleEntryTop: 0,
                parentScrollTop: 0,
            }),
            this.refresh();
    }
    static get Default() {
        return If;
    }
    static get DefaultType() {
        return Mf;
    }
    static get NAME() {
        return Ef;
    }
    refresh() {
        this._initializeTargetsAndObservables(),
            this._maybeEnableSmoothScroll(),
            this._observer
                ? this._observer.disconnect()
                : (this._observer = this._getNewObserver());
        for (const t of this._observableSections.values())
            this._observer.observe(t);
    }
    dispose() {
        this._observer.disconnect(), super.dispose();
    }
    _configAfterMerge(t) {
        return (
            (t.target = Mt(t.target) || document.body),
            (t.rootMargin = t.offset ? `${t.offset}px 0px -30%` : t.rootMargin),
            typeof t.threshold == "string" &&
                (t.threshold = t.threshold
                    .split(",")
                    .map((s) => Number.parseFloat(s))),
            t
        );
    }
    _maybeEnableSmoothScroll() {
        this._config.smoothScroll &&
            (p.off(this._config.target, Po),
            p.on(this._config.target, Po, Hn, (t) => {
                const s = this._observableSections.get(t.target.hash);
                if (s) {
                    t.preventDefault();
                    const r = this._rootElement || window,
                        l = s.offsetTop - this._element.offsetTop;
                    if (r.scrollTo) {
                        r.scrollTo({ top: l, behavior: "smooth" });
                        return;
                    }
                    r.scrollTop = l;
                }
            }));
    }
    _getNewObserver() {
        const t = {
            root: this._rootElement,
            threshold: this._config.threshold,
            rootMargin: this._config.rootMargin,
        };
        return new IntersectionObserver((s) => this._observerCallback(s), t);
    }
    _observerCallback(t) {
        const s = (u) => this._targetLinks.get(`#${u.target.id}`),
            r = (u) => {
                (this._previousScrollData.visibleEntryTop = u.target.offsetTop),
                    this._process(s(u));
            },
            l = (this._rootElement || document.documentElement).scrollTop,
            d = l >= this._previousScrollData.parentScrollTop;
        this._previousScrollData.parentScrollTop = l;
        for (const u of t) {
            if (!u.isIntersecting) {
                (this._activeTarget = null), this._clearActiveClass(s(u));
                continue;
            }
            const h =
                u.target.offsetTop >= this._previousScrollData.visibleEntryTop;
            if (d && h) {
                if ((r(u), !l)) return;
                continue;
            }
            !d && !h && r(u);
        }
    }
    _initializeTargetsAndObservables() {
        (this._targetLinks = new Map()), (this._observableSections = new Map());
        const t = C.find(Hn, this._config.target);
        for (const s of t) {
            if (!s.hash || Bt(s)) continue;
            const r = C.findOne(s.hash, this._element);
            Ee(r) &&
                (this._targetLinks.set(s.hash, s),
                this._observableSections.set(s.hash, r));
        }
    }
    _process(t) {
        this._activeTarget !== t &&
            (this._clearActiveClass(this._config.target),
            (this._activeTarget = t),
            t.classList.add(ue),
            this._activateParents(t),
            p.trigger(this._element, Cf, { relatedTarget: t }));
    }
    _activateParents(t) {
        if (t.classList.contains(Sf)) {
            C.findOne(Pf, t.closest(Df)).classList.add(ue);
            return;
        }
        for (const s of C.parents(t, $f))
            for (const r of C.prev(s, Nf)) r.classList.add(ue);
    }
    _clearActiveClass(t) {
        t.classList.remove(ue);
        const s = C.find(`${Hn}.${ue}`, t);
        for (const r of s) r.classList.remove(ue);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = ze.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (s[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
}
p.on(window, Of, () => {
    for (const o of C.find(xf)) ze.getOrCreateInstance(o);
});
ht(ze);
const Bf = "tab",
    Rf = "bs.tab",
    te = `.${Rf}`,
    Vf = `hide${te}`,
    Hf = `hidden${te}`,
    jf = `show${te}`,
    Wf = `shown${te}`,
    Ff = `click${te}`,
    zf = `keydown${te}`,
    Kf = `load${te}`,
    Yf = "ArrowLeft",
    Mo = "ArrowRight",
    qf = "ArrowUp",
    Bo = "ArrowDown",
    Yt = "active",
    Ro = "fade",
    jn = "show",
    Uf = "dropdown",
    Gf = ".dropdown-toggle",
    Xf = ".dropdown-menu",
    Wn = ":not(.dropdown-toggle)",
    Qf = '.list-group, .nav, [role="tablist"]',
    Zf = ".nav-item, .list-group-item",
    Jf = `.nav-link${Wn}, .list-group-item${Wn}, [role="tab"]${Wn}`,
    Hi =
        '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]',
    Fn = `${Jf}, ${Hi}`,
    th = `.${Yt}[data-bs-toggle="tab"], .${Yt}[data-bs-toggle="pill"], .${Yt}[data-bs-toggle="list"]`;
class Qt extends wt {
    constructor(t) {
        super(t),
            (this._parent = this._element.closest(Qf)),
            this._parent &&
                (this._setInitialAttributes(this._parent, this._getChildren()),
                p.on(this._element, zf, (s) => this._keydown(s)));
    }
    static get NAME() {
        return Bf;
    }
    show() {
        const t = this._element;
        if (this._elemIsActive(t)) return;
        const s = this._getActiveElem(),
            r = s ? p.trigger(s, Vf, { relatedTarget: t }) : null;
        p.trigger(t, jf, { relatedTarget: s }).defaultPrevented ||
            (r && r.defaultPrevented) ||
            (this._deactivate(s, t), this._activate(t, s));
    }
    _activate(t, s) {
        if (!t) return;
        t.classList.add(Yt), this._activate(St(t));
        const r = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.add(jn);
                return;
            }
            t.removeAttribute("tabindex"),
                t.setAttribute("aria-selected", !0),
                this._toggleDropDown(t, !0),
                p.trigger(t, Wf, { relatedTarget: s });
        };
        this._queueCallback(r, t, t.classList.contains(Ro));
    }
    _deactivate(t, s) {
        if (!t) return;
        t.classList.remove(Yt), t.blur(), this._deactivate(St(t));
        const r = () => {
            if (t.getAttribute("role") !== "tab") {
                t.classList.remove(jn);
                return;
            }
            t.setAttribute("aria-selected", !1),
                t.setAttribute("tabindex", "-1"),
                this._toggleDropDown(t, !1),
                p.trigger(t, Hf, { relatedTarget: s });
        };
        this._queueCallback(r, t, t.classList.contains(Ro));
    }
    _keydown(t) {
        if (![Yf, Mo, qf, Bo].includes(t.key)) return;
        t.stopPropagation(), t.preventDefault();
        const s = [Mo, Bo].includes(t.key),
            r = ds(
                this._getChildren().filter((l) => !Bt(l)),
                t.target,
                s,
                !0
            );
        r && (r.focus({ preventScroll: !0 }), Qt.getOrCreateInstance(r).show());
    }
    _getChildren() {
        return C.find(Fn, this._parent);
    }
    _getActiveElem() {
        return this._getChildren().find((t) => this._elemIsActive(t)) || null;
    }
    _setInitialAttributes(t, s) {
        this._setAttributeIfNotExists(t, "role", "tablist");
        for (const r of s) this._setInitialAttributesOnChild(r);
    }
    _setInitialAttributesOnChild(t) {
        t = this._getInnerElement(t);
        const s = this._elemIsActive(t),
            r = this._getOuterElement(t);
        t.setAttribute("aria-selected", s),
            r !== t && this._setAttributeIfNotExists(r, "role", "presentation"),
            s || t.setAttribute("tabindex", "-1"),
            this._setAttributeIfNotExists(t, "role", "tab"),
            this._setInitialAttributesOnTargetPanel(t);
    }
    _setInitialAttributesOnTargetPanel(t) {
        const s = St(t);
        s &&
            (this._setAttributeIfNotExists(s, "role", "tabpanel"),
            t.id &&
                this._setAttributeIfNotExists(
                    s,
                    "aria-labelledby",
                    `#${t.id}`
                ));
    }
    _toggleDropDown(t, s) {
        const r = this._getOuterElement(t);
        if (!r.classList.contains(Uf)) return;
        const l = (d, u) => {
            const h = C.findOne(d, r);
            h && h.classList.toggle(u, s);
        };
        l(Gf, Yt), l(Xf, jn), r.setAttribute("aria-expanded", s);
    }
    _setAttributeIfNotExists(t, s, r) {
        t.hasAttribute(s) || t.setAttribute(s, r);
    }
    _elemIsActive(t) {
        return t.classList.contains(Yt);
    }
    _getInnerElement(t) {
        return t.matches(Fn) ? t : C.findOne(Fn, t);
    }
    _getOuterElement(t) {
        return t.closest(Zf) || t;
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = Qt.getOrCreateInstance(this);
            if (typeof t == "string") {
                if (s[t] === void 0 || t.startsWith("_") || t === "constructor")
                    throw new TypeError(`No method named "${t}"`);
                s[t]();
            }
        });
    }
}
p.on(document, Ff, Hi, function (o) {
    ["A", "AREA"].includes(this.tagName) && o.preventDefault(),
        !Bt(this) && Qt.getOrCreateInstance(this).show();
});
p.on(window, Kf, () => {
    for (const o of C.find(th)) Qt.getOrCreateInstance(o);
});
ht(Qt);
const eh = "toast",
    nh = "bs.toast",
    Ht = `.${nh}`,
    sh = `mouseover${Ht}`,
    oh = `mouseout${Ht}`,
    ih = `focusin${Ht}`,
    rh = `focusout${Ht}`,
    ah = `hide${Ht}`,
    lh = `hidden${Ht}`,
    ch = `show${Ht}`,
    uh = `shown${Ht}`,
    dh = "fade",
    Vo = "hide",
    sn = "show",
    on = "showing",
    fh = { animation: "boolean", autohide: "boolean", delay: "number" },
    hh = { animation: !0, autohide: !0, delay: 5e3 };
class Ke extends wt {
    constructor(t, s) {
        super(t, s),
            (this._timeout = null),
            (this._hasMouseInteraction = !1),
            (this._hasKeyboardInteraction = !1),
            this._setListeners();
    }
    static get Default() {
        return hh;
    }
    static get DefaultType() {
        return fh;
    }
    static get NAME() {
        return eh;
    }
    show() {
        if (p.trigger(this._element, ch).defaultPrevented) return;
        this._clearTimeout(),
            this._config.animation && this._element.classList.add(dh);
        const s = () => {
            this._element.classList.remove(on),
                p.trigger(this._element, uh),
                this._maybeScheduleHide();
        };
        this._element.classList.remove(Vo),
            Ve(this._element),
            this._element.classList.add(sn, on),
            this._queueCallback(s, this._element, this._config.animation);
    }
    hide() {
        if (!this.isShown() || p.trigger(this._element, ah).defaultPrevented)
            return;
        const s = () => {
            this._element.classList.add(Vo),
                this._element.classList.remove(on, sn),
                p.trigger(this._element, lh);
        };
        this._element.classList.add(on),
            this._queueCallback(s, this._element, this._config.animation);
    }
    dispose() {
        this._clearTimeout(),
            this.isShown() && this._element.classList.remove(sn),
            super.dispose();
    }
    isShown() {
        return this._element.classList.contains(sn);
    }
    _maybeScheduleHide() {
        this._config.autohide &&
            (this._hasMouseInteraction ||
                this._hasKeyboardInteraction ||
                (this._timeout = setTimeout(() => {
                    this.hide();
                }, this._config.delay)));
    }
    _onInteraction(t, s) {
        switch (t.type) {
            case "mouseover":
            case "mouseout": {
                this._hasMouseInteraction = s;
                break;
            }
            case "focusin":
            case "focusout": {
                this._hasKeyboardInteraction = s;
                break;
            }
        }
        if (s) {
            this._clearTimeout();
            return;
        }
        const r = t.relatedTarget;
        this._element === r ||
            this._element.contains(r) ||
            this._maybeScheduleHide();
    }
    _setListeners() {
        p.on(this._element, sh, (t) => this._onInteraction(t, !0)),
            p.on(this._element, oh, (t) => this._onInteraction(t, !1)),
            p.on(this._element, ih, (t) => this._onInteraction(t, !0)),
            p.on(this._element, rh, (t) => this._onInteraction(t, !1));
    }
    _clearTimeout() {
        clearTimeout(this._timeout), (this._timeout = null);
    }
    static jQueryInterface(t) {
        return this.each(function () {
            const s = Ke.getOrCreateInstance(this, t);
            if (typeof t == "string") {
                if (typeof s[t] > "u")
                    throw new TypeError(`No method named "${t}"`);
                s[t](this);
            }
        });
    }
}
wn(Ke);
ht(Ke);
const ph = Object.freeze(
    Object.defineProperty(
        {
            __proto__: null,
            Alert: je,
            Button: We,
            Carousel: Te,
            Collapse: ve,
            Dropdown: gt,
            Modal: Xt,
            Offcanvas: kt,
            Popover: bn,
            ScrollSpy: ze,
            Tab: Qt,
            Toast: Ke,
            Tooltip: Jt,
        },
        Symbol.toStringTag,
        { value: "Module" }
    )
);
var It =
    typeof globalThis < "u"
        ? globalThis
        : typeof window < "u"
        ? window
        : typeof global < "u"
        ? global
        : typeof self < "u"
        ? self
        : {};
function mh(o) {
    return o &&
        o.__esModule &&
        Object.prototype.hasOwnProperty.call(o, "default")
        ? o.default
        : o;
}
var ji = { exports: {} };
/*!
 * sweetalert2 v11.7.12
 * Released under the MIT License.
 */ (function (o, t) {
    (function (s, r) {
        o.exports = r();
    })(It, function () {
        const r = {},
            l = () => {
                r.previousActiveElement instanceof HTMLElement
                    ? (r.previousActiveElement.focus(),
                      (r.previousActiveElement = null))
                    : document.body && document.body.focus();
            },
            d = (e) =>
                new Promise((n) => {
                    if (!e) return n();
                    const i = window.scrollX,
                        a = window.scrollY;
                    (r.restoreFocusTimeout = setTimeout(() => {
                        l(), n();
                    }, 100)),
                        window.scrollTo(i, a);
                });
        var u = {
            promise: new WeakMap(),
            innerParams: new WeakMap(),
            domCache: new WeakMap(),
        };
        const h = "swal2-",
            c = [
                "container",
                "shown",
                "height-auto",
                "iosfix",
                "popup",
                "modal",
                "no-backdrop",
                "no-transition",
                "toast",
                "toast-shown",
                "show",
                "hide",
                "close",
                "title",
                "html-container",
                "actions",
                "confirm",
                "deny",
                "cancel",
                "default-outline",
                "footer",
                "icon",
                "icon-content",
                "image",
                "input",
                "file",
                "range",
                "select",
                "radio",
                "checkbox",
                "label",
                "textarea",
                "inputerror",
                "input-label",
                "validation-message",
                "progress-steps",
                "active-progress-step",
                "progress-step",
                "progress-step-line",
                "loader",
                "loading",
                "styled",
                "top",
                "top-start",
                "top-end",
                "top-left",
                "top-right",
                "center",
                "center-start",
                "center-end",
                "center-left",
                "center-right",
                "bottom",
                "bottom-start",
                "bottom-end",
                "bottom-left",
                "bottom-right",
                "grow-row",
                "grow-column",
                "grow-fullscreen",
                "rtl",
                "timer-progress-bar",
                "timer-progress-bar-container",
                "scrollbar-measure",
                "icon-success",
                "icon-warning",
                "icon-info",
                "icon-question",
                "icon-error",
            ].reduce((e, n) => ((e[n] = h + n), e), {}),
            v = ["success", "warning", "info", "question", "error"].reduce(
                (e, n) => ((e[n] = h + n), e),
                {}
            ),
            A = "SweetAlert2:",
            _ = (e) => e.charAt(0).toUpperCase() + e.slice(1),
            E = (e) => {
                console.warn(`${A} ${typeof e == "object" ? e.join(" ") : e}`);
            },
            y = (e) => {
                console.error(`${A} ${e}`);
            },
            x = [],
            D = (e) => {
                x.includes(e) || (x.push(e), E(e));
            },
            I = (e, n) => {
                D(
                    `"${e}" is deprecated and will be removed in the next major release. Please use "${n}" instead.`
                );
            },
            P = (e) => (typeof e == "function" ? e() : e),
            T = (e) => e && typeof e.toPromise == "function",
            $ = (e) => (T(e) ? e.toPromise() : Promise.resolve(e)),
            L = (e) => e && Promise.resolve(e) === e,
            O = () => document.body.querySelector(`.${c.container}`),
            M = (e) => {
                const n = O();
                return n ? n.querySelector(e) : null;
            },
            k = (e) => M(`.${e}`),
            b = () => k(c.popup),
            B = () => k(c.icon),
            et = () => k(c["icon-content"]),
            W = () => k(c.title),
            lt = () => k(c["html-container"]),
            _t = () => k(c.image),
            z = () => k(c["progress-steps"]),
            Y = () => k(c["validation-message"]),
            q = () => M(`.${c.actions} .${c.confirm}`),
            G = () => M(`.${c.actions} .${c.cancel}`),
            nt = () => M(`.${c.actions} .${c.deny}`),
            Ce = () => k(c["input-label"]),
            ct = () => M(`.${c.loader}`),
            vt = () => k(c.actions),
            At = () => k(c.footer),
            st = () => k(c["timer-progress-bar"]),
            Tt = () => k(c.close),
            ee = `
  a[href],
  area[href],
  input:not([disabled]),
  select:not([disabled]),
  textarea:not([disabled]),
  button:not([disabled]),
  iframe,
  object,
  embed,
  [tabindex="0"],
  [contenteditable],
  audio[controls],
  video[controls],
  summary
`,
            pt = () => {
                const e = b().querySelectorAll(
                        '[tabindex]:not([tabindex="-1"]):not([tabindex="0"])'
                    ),
                    n = Array.from(e).sort((f, w) => {
                        const N = parseInt(f.getAttribute("tabindex")),
                            j = parseInt(w.getAttribute("tabindex"));
                        return N > j ? 1 : N < j ? -1 : 0;
                    }),
                    i = b().querySelectorAll(ee),
                    a = Array.from(i).filter(
                        (f) => f.getAttribute("tabindex") !== "-1"
                    );
                return [...new Set(n.concat(a))].filter((f) => U(f));
            },
            jt = () =>
                ut(document.body, c.shown) &&
                !ut(document.body, c["toast-shown"]) &&
                !ut(document.body, c["no-backdrop"]),
            ne = () => b() && ut(b(), c.toast),
            Oe = () => b().hasAttribute("data-loading"),
            X = (e, n) => {
                if (((e.textContent = ""), n)) {
                    const a = new DOMParser().parseFromString(n, "text/html");
                    Array.from(a.querySelector("head").childNodes).forEach(
                        (f) => {
                            e.appendChild(f);
                        }
                    ),
                        Array.from(a.querySelector("body").childNodes).forEach(
                            (f) => {
                                f instanceof HTMLVideoElement ||
                                f instanceof HTMLAudioElement
                                    ? e.appendChild(f.cloneNode(!0))
                                    : e.appendChild(f);
                            }
                        );
                }
            },
            ut = (e, n) => {
                if (!n) return !1;
                const i = n.split(/\s+/);
                for (let a = 0; a < i.length; a++)
                    if (!e.classList.contains(i[a])) return !1;
                return !0;
            },
            _n = (e, n) => {
                Array.from(e.classList).forEach((i) => {
                    !Object.values(c).includes(i) &&
                        !Object.values(v).includes(i) &&
                        !Object.values(n.showClass).includes(i) &&
                        e.classList.remove(i);
                });
            },
            J = (e, n, i) => {
                if ((_n(e, n), n.customClass && n.customClass[i])) {
                    if (
                        typeof n.customClass[i] != "string" &&
                        !n.customClass[i].forEach
                    ) {
                        E(
                            `Invalid type of customClass.${i}! Expected string or iterable object, got "${typeof n
                                .customClass[i]}"`
                        );
                        return;
                    }
                    S(e, n.customClass[i]);
                }
            },
            se = (e, n) => {
                if (!n) return null;
                switch (n) {
                    case "select":
                    case "textarea":
                    case "file":
                        return e.querySelector(`.${c.popup} > .${c[n]}`);
                    case "checkbox":
                        return e.querySelector(
                            `.${c.popup} > .${c.checkbox} input`
                        );
                    case "radio":
                        return (
                            e.querySelector(
                                `.${c.popup} > .${c.radio} input:checked`
                            ) ||
                            e.querySelector(
                                `.${c.popup} > .${c.radio} input:first-child`
                            )
                        );
                    case "range":
                        return e.querySelector(
                            `.${c.popup} > .${c.range} input`
                        );
                    default:
                        return e.querySelector(`.${c.popup} > .${c.input}`);
                }
            },
            Se = (e) => {
                if ((e.focus(), e.type !== "file")) {
                    const n = e.value;
                    (e.value = ""), (e.value = n);
                }
            },
            Ye = (e, n, i) => {
                !e ||
                    !n ||
                    (typeof n == "string" &&
                        (n = n.split(/\s+/).filter(Boolean)),
                    n.forEach((a) => {
                        Array.isArray(e)
                            ? e.forEach((f) => {
                                  i
                                      ? f.classList.add(a)
                                      : f.classList.remove(a);
                              })
                            : i
                            ? e.classList.add(a)
                            : e.classList.remove(a);
                    }));
            },
            S = (e, n) => {
                Ye(e, n, !0);
            },
            F = (e, n) => {
                Ye(e, n, !1);
            },
            ot = (e, n) => {
                const i = Array.from(e.children);
                for (let a = 0; a < i.length; a++) {
                    const f = i[a];
                    if (f instanceof HTMLElement && ut(f, n)) return f;
                }
            },
            Ct = (e, n, i) => {
                i === `${parseInt(i)}` && (i = parseInt(i)),
                    i || parseInt(i) === 0
                        ? (e.style[n] = typeof i == "number" ? `${i}px` : i)
                        : e.style.removeProperty(n);
            },
            V = function (e) {
                let n =
                    arguments.length > 1 && arguments[1] !== void 0
                        ? arguments[1]
                        : "flex";
                e && (e.style.display = n);
            },
            H = (e) => {
                e && (e.style.display = "none");
            },
            xe = (e, n, i, a) => {
                const f = e.querySelector(n);
                f && (f.style[i] = a);
            },
            Wt = function (e, n) {
                let i =
                    arguments.length > 2 && arguments[2] !== void 0
                        ? arguments[2]
                        : "flex";
                n ? V(e, i) : H(e);
            },
            U = (e) =>
                !!(
                    e &&
                    (e.offsetWidth ||
                        e.offsetHeight ||
                        e.getClientRects().length)
                ),
            qe = () => !U(q()) && !U(nt()) && !U(G()),
            gs = (e) => e.scrollHeight > e.clientHeight,
            ws = (e) => {
                const n = window.getComputedStyle(e),
                    i = parseFloat(
                        n.getPropertyValue("animation-duration") || "0"
                    ),
                    a = parseFloat(
                        n.getPropertyValue("transition-duration") || "0"
                    );
                return i > 0 || a > 0;
            },
            vn = function (e) {
                let n =
                    arguments.length > 1 && arguments[1] !== void 0
                        ? arguments[1]
                        : !1;
                const i = st();
                U(i) &&
                    (n &&
                        ((i.style.transition = "none"),
                        (i.style.width = "100%")),
                    setTimeout(() => {
                        (i.style.transition = `width ${e / 1e3}s linear`),
                            (i.style.width = "0%");
                    }, 10));
            },
            zi = () => {
                const e = st(),
                    n = parseInt(window.getComputedStyle(e).width);
                e.style.removeProperty("transition"), (e.style.width = "100%");
                const i = parseInt(window.getComputedStyle(e).width),
                    a = (n / i) * 100;
                e.style.width = `${a}%`;
            },
            bs = () => typeof window > "u" || typeof document > "u",
            Ki = `
 <div aria-labelledby="${c.title}" aria-describedby="${c["html-container"]}" class="${c.popup}" tabindex="-1">
   <button type="button" class="${c.close}"></button>
   <ul class="${c["progress-steps"]}"></ul>
   <div class="${c.icon}"></div>
   <img class="${c.image}" />
   <h2 class="${c.title}" id="${c.title}"></h2>
   <div class="${c["html-container"]}" id="${c["html-container"]}"></div>
   <input class="${c.input}" />
   <input type="file" class="${c.file}" />
   <div class="${c.range}">
     <input type="range" />
     <output></output>
   </div>
   <select class="${c.select}"></select>
   <div class="${c.radio}"></div>
   <label for="${c.checkbox}" class="${c.checkbox}">
     <input type="checkbox" />
     <span class="${c.label}"></span>
   </label>
   <textarea class="${c.textarea}"></textarea>
   <div class="${c["validation-message"]}" id="${c["validation-message"]}"></div>
   <div class="${c.actions}">
     <div class="${c.loader}"></div>
     <button type="button" class="${c.confirm}"></button>
     <button type="button" class="${c.deny}"></button>
     <button type="button" class="${c.cancel}"></button>
   </div>
   <div class="${c.footer}"></div>
   <div class="${c["timer-progress-bar-container"]}">
     <div class="${c["timer-progress-bar"]}"></div>
   </div>
 </div>
`.replace(/(^|\n)\s*/g, ""),
            Yi = () => {
                const e = O();
                return e
                    ? (e.remove(),
                      F(
                          [document.documentElement, document.body],
                          [c["no-backdrop"], c["toast-shown"], c["has-column"]]
                      ),
                      !0)
                    : !1;
            },
            Ft = () => {
                r.currentInstance.resetValidationMessage();
            },
            qi = () => {
                const e = b(),
                    n = ot(e, c.input),
                    i = ot(e, c.file),
                    a = e.querySelector(`.${c.range} input`),
                    f = e.querySelector(`.${c.range} output`),
                    w = ot(e, c.select),
                    N = e.querySelector(`.${c.checkbox} input`),
                    j = ot(e, c.textarea);
                (n.oninput = Ft),
                    (i.onchange = Ft),
                    (w.onchange = Ft),
                    (N.onchange = Ft),
                    (j.oninput = Ft),
                    (a.oninput = () => {
                        Ft(), (f.value = a.value);
                    }),
                    (a.onchange = () => {
                        Ft(), (f.value = a.value);
                    });
            },
            Ui = (e) => (typeof e == "string" ? document.querySelector(e) : e),
            Gi = (e) => {
                const n = b();
                n.setAttribute("role", e.toast ? "alert" : "dialog"),
                    n.setAttribute(
                        "aria-live",
                        e.toast ? "polite" : "assertive"
                    ),
                    e.toast || n.setAttribute("aria-modal", "true");
            },
            Xi = (e) => {
                window.getComputedStyle(e).direction === "rtl" && S(O(), c.rtl);
            },
            Qi = (e) => {
                const n = Yi();
                if (bs()) {
                    y("SweetAlert2 requires document to initialize");
                    return;
                }
                const i = document.createElement("div");
                (i.className = c.container),
                    n && S(i, c["no-transition"]),
                    X(i, Ki);
                const a = Ui(e.target);
                a.appendChild(i), Gi(e), Xi(a), qi();
            },
            yn = (e, n) => {
                e instanceof HTMLElement
                    ? n.appendChild(e)
                    : typeof e == "object"
                    ? Zi(e, n)
                    : e && X(n, e);
            },
            Zi = (e, n) => {
                e.jquery ? Ji(n, e) : X(n, e.toString());
            },
            Ji = (e, n) => {
                if (((e.textContent = ""), 0 in n))
                    for (let i = 0; i in n; i++)
                        e.appendChild(n[i].cloneNode(!0));
                else e.appendChild(n.cloneNode(!0));
            },
            $e = (() => {
                if (bs()) return !1;
                const e = document.createElement("div"),
                    n = {
                        WebkitAnimation: "webkitAnimationEnd",
                        animation: "animationend",
                    };
                for (const i in n)
                    if (
                        Object.prototype.hasOwnProperty.call(n, i) &&
                        typeof e.style[i] < "u"
                    )
                        return n[i];
                return !1;
            })(),
            tr = (e, n) => {
                const i = vt(),
                    a = ct();
                !n.showConfirmButton && !n.showDenyButton && !n.showCancelButton
                    ? H(i)
                    : V(i),
                    J(i, n, "actions"),
                    er(i, a, n),
                    X(a, n.loaderHtml),
                    J(a, n, "loader");
            };
        function er(e, n, i) {
            const a = q(),
                f = nt(),
                w = G();
            En(a, "confirm", i),
                En(f, "deny", i),
                En(w, "cancel", i),
                nr(a, f, w, i),
                i.reverseButtons &&
                    (i.toast
                        ? (e.insertBefore(w, a), e.insertBefore(f, a))
                        : (e.insertBefore(w, n),
                          e.insertBefore(f, n),
                          e.insertBefore(a, n)));
        }
        function nr(e, n, i, a) {
            if (!a.buttonsStyling) {
                F([e, n, i], c.styled);
                return;
            }
            S([e, n, i], c.styled),
                a.confirmButtonColor &&
                    ((e.style.backgroundColor = a.confirmButtonColor),
                    S(e, c["default-outline"])),
                a.denyButtonColor &&
                    ((n.style.backgroundColor = a.denyButtonColor),
                    S(n, c["default-outline"])),
                a.cancelButtonColor &&
                    ((i.style.backgroundColor = a.cancelButtonColor),
                    S(i, c["default-outline"]));
        }
        function En(e, n, i) {
            Wt(e, i[`show${_(n)}Button`], "inline-block"),
                X(e, i[`${n}ButtonText`]),
                e.setAttribute("aria-label", i[`${n}ButtonAriaLabel`]),
                (e.className = c[n]),
                J(e, i, `${n}Button`),
                S(e, i[`${n}ButtonClass`]);
        }
        const sr = (e, n) => {
                const i = Tt();
                i &&
                    (X(i, n.closeButtonHtml || ""),
                    J(i, n, "closeButton"),
                    Wt(i, n.showCloseButton),
                    i.setAttribute("aria-label", n.closeButtonAriaLabel || ""));
            },
            or = (e, n) => {
                const i = O();
                i &&
                    (ir(i, n.backdrop),
                    rr(i, n.position),
                    ar(i, n.grow),
                    J(i, n, "container"));
            };
        function ir(e, n) {
            typeof n == "string"
                ? (e.style.background = n)
                : n ||
                  S(
                      [document.documentElement, document.body],
                      c["no-backdrop"]
                  );
        }
        function rr(e, n) {
            n in c
                ? S(e, c[n])
                : (E(
                      'The "position" parameter is not valid, defaulting to "center"'
                  ),
                  S(e, c.center));
        }
        function ar(e, n) {
            if (n && typeof n == "string") {
                const i = `grow-${n}`;
                i in c && S(e, c[i]);
            }
        }
        const lr = [
                "input",
                "file",
                "range",
                "select",
                "radio",
                "checkbox",
                "textarea",
            ],
            cr = (e, n) => {
                const i = b(),
                    a = u.innerParams.get(e),
                    f = !a || n.input !== a.input;
                lr.forEach((w) => {
                    const N = ot(i, c[w]);
                    fr(w, n.inputAttributes), (N.className = c[w]), f && H(N);
                }),
                    n.input && (f && ur(n), hr(n));
            },
            ur = (e) => {
                if (!tt[e.input]) {
                    y(
                        `Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "${e.input}"`
                    );
                    return;
                }
                const n = _s(e.input),
                    i = tt[e.input](n, e);
                V(n),
                    e.inputAutoFocus &&
                        setTimeout(() => {
                            Se(i);
                        });
            },
            dr = (e) => {
                for (let n = 0; n < e.attributes.length; n++) {
                    const i = e.attributes[n].name;
                    ["type", "value", "style"].includes(i) ||
                        e.removeAttribute(i);
                }
            },
            fr = (e, n) => {
                const i = se(b(), e);
                if (i) {
                    dr(i);
                    for (const a in n) i.setAttribute(a, n[a]);
                }
            },
            hr = (e) => {
                const n = _s(e.input);
                typeof e.customClass == "object" && S(n, e.customClass.input);
            },
            An = (e, n) => {
                (!e.placeholder || n.inputPlaceholder) &&
                    (e.placeholder = n.inputPlaceholder);
            },
            Le = (e, n, i) => {
                if (i.inputLabel) {
                    e.id = c.input;
                    const a = document.createElement("label"),
                        f = c["input-label"];
                    a.setAttribute("for", e.id),
                        (a.className = f),
                        typeof i.customClass == "object" &&
                            S(a, i.customClass.inputLabel),
                        (a.innerText = i.inputLabel),
                        n.insertAdjacentElement("beforebegin", a);
                }
            },
            _s = (e) => ot(b(), c[e] || c.input),
            Ue = (e, n) => {
                ["string", "number"].includes(typeof n)
                    ? (e.value = `${n}`)
                    : L(n) ||
                      E(
                          `Unexpected type of inputValue! Expected "string", "number" or "Promise", got "${typeof n}"`
                      );
            },
            tt = {};
        (tt.text =
            tt.email =
            tt.password =
            tt.number =
            tt.tel =
            tt.url =
                (e, n) => (
                    Ue(e, n.inputValue),
                    Le(e, e, n),
                    An(e, n),
                    (e.type = n.input),
                    e
                )),
            (tt.file = (e, n) => (Le(e, e, n), An(e, n), e)),
            (tt.range = (e, n) => {
                const i = e.querySelector("input"),
                    a = e.querySelector("output");
                return (
                    Ue(i, n.inputValue),
                    (i.type = n.input),
                    Ue(a, n.inputValue),
                    Le(i, e, n),
                    e
                );
            }),
            (tt.select = (e, n) => {
                if (((e.textContent = ""), n.inputPlaceholder)) {
                    const i = document.createElement("option");
                    X(i, n.inputPlaceholder),
                        (i.value = ""),
                        (i.disabled = !0),
                        (i.selected = !0),
                        e.appendChild(i);
                }
                return Le(e, e, n), e;
            }),
            (tt.radio = (e) => ((e.textContent = ""), e)),
            (tt.checkbox = (e, n) => {
                const i = se(b(), "checkbox");
                (i.value = "1"),
                    (i.id = c.checkbox),
                    (i.checked = !!n.inputValue);
                const a = e.querySelector("span");
                return X(a, n.inputPlaceholder), i;
            }),
            (tt.textarea = (e, n) => {
                Ue(e, n.inputValue), An(e, n), Le(e, e, n);
                const i = (a) =>
                    parseInt(window.getComputedStyle(a).marginLeft) +
                    parseInt(window.getComputedStyle(a).marginRight);
                return (
                    setTimeout(() => {
                        if ("MutationObserver" in window) {
                            const a = parseInt(
                                    window.getComputedStyle(b()).width
                                ),
                                f = () => {
                                    const w = e.offsetWidth + i(e);
                                    w > a
                                        ? (b().style.width = `${w}px`)
                                        : (b().style.width = null);
                                };
                            new MutationObserver(f).observe(e, {
                                attributes: !0,
                                attributeFilter: ["style"],
                            });
                        }
                    }),
                    e
                );
            });
        const pr = (e, n) => {
                const i = lt();
                i &&
                    (J(i, n, "htmlContainer"),
                    n.html
                        ? (yn(n.html, i), V(i, "block"))
                        : n.text
                        ? ((i.textContent = n.text), V(i, "block"))
                        : H(i),
                    cr(e, n));
            },
            mr = (e, n) => {
                const i = At();
                i &&
                    (Wt(i, n.footer),
                    n.footer && yn(n.footer, i),
                    J(i, n, "footer"));
            },
            gr = (e, n) => {
                const i = u.innerParams.get(e),
                    a = B();
                if (i && n.icon === i.icon) {
                    ys(a, n), vs(a, n);
                    return;
                }
                if (!n.icon && !n.iconHtml) {
                    H(a);
                    return;
                }
                if (n.icon && Object.keys(v).indexOf(n.icon) === -1) {
                    y(
                        `Unknown icon! Expected "success", "error", "warning", "info" or "question", got "${n.icon}"`
                    ),
                        H(a);
                    return;
                }
                V(a), ys(a, n), vs(a, n), S(a, n.showClass.icon);
            },
            vs = (e, n) => {
                for (const i in v) n.icon !== i && F(e, v[i]);
                S(e, v[n.icon]), vr(e, n), wr(), J(e, n, "icon");
            },
            wr = () => {
                const e = b(),
                    n = window
                        .getComputedStyle(e)
                        .getPropertyValue("background-color"),
                    i = e.querySelectorAll(
                        "[class^=swal2-success-circular-line], .swal2-success-fix"
                    );
                for (let a = 0; a < i.length; a++)
                    i[a].style.backgroundColor = n;
            },
            br = `
  <div class="swal2-success-circular-line-left"></div>
  <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
  <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>
  <div class="swal2-success-circular-line-right"></div>
`,
            _r = `
  <span class="swal2-x-mark">
    <span class="swal2-x-mark-line-left"></span>
    <span class="swal2-x-mark-line-right"></span>
  </span>
`,
            ys = (e, n) => {
                let i = e.innerHTML,
                    a;
                n.iconHtml
                    ? (a = Es(n.iconHtml))
                    : n.icon === "success"
                    ? ((a = br), (i = i.replace(/ style=".*?"/g, "")))
                    : n.icon === "error"
                    ? (a = _r)
                    : (a = Es(
                          { question: "?", warning: "!", info: "i" }[n.icon]
                      )),
                    i.trim() !== a.trim() && X(e, a);
            },
            vr = (e, n) => {
                if (n.iconColor) {
                    (e.style.color = n.iconColor),
                        (e.style.borderColor = n.iconColor);
                    for (const i of [
                        ".swal2-success-line-tip",
                        ".swal2-success-line-long",
                        ".swal2-x-mark-line-left",
                        ".swal2-x-mark-line-right",
                    ])
                        xe(e, i, "backgroundColor", n.iconColor);
                    xe(e, ".swal2-success-ring", "borderColor", n.iconColor);
                }
            },
            Es = (e) => `<div class="${c["icon-content"]}">${e}</div>`,
            yr = (e, n) => {
                const i = _t();
                if (i) {
                    if (!n.imageUrl) {
                        H(i);
                        return;
                    }
                    V(i, ""),
                        i.setAttribute("src", n.imageUrl),
                        i.setAttribute("alt", n.imageAlt || ""),
                        Ct(i, "width", n.imageWidth),
                        Ct(i, "height", n.imageHeight),
                        (i.className = c.image),
                        J(i, n, "image");
                }
            },
            Er = (e, n) => {
                const i = O(),
                    a = b();
                if (!(!i || !a)) {
                    if (n.toast) {
                        Ct(i, "width", n.width), (a.style.width = "100%");
                        const f = ct();
                        f && a.insertBefore(f, B());
                    } else Ct(a, "width", n.width);
                    Ct(a, "padding", n.padding),
                        n.color && (a.style.color = n.color),
                        n.background && (a.style.background = n.background),
                        H(Y()),
                        Ar(a, n);
                }
            },
            Ar = (e, n) => {
                const i = n.showClass || {};
                (e.className = `${c.popup} ${U(e) ? i.popup : ""}`),
                    n.toast
                        ? (S(
                              [document.documentElement, document.body],
                              c["toast-shown"]
                          ),
                          S(e, c.toast))
                        : S(e, c.modal),
                    J(e, n, "popup"),
                    typeof n.customClass == "string" && S(e, n.customClass),
                    n.icon && S(e, c[`icon-${n.icon}`]);
            },
            Tr = (e, n) => {
                const i = z();
                if (!i) return;
                const { progressSteps: a, currentProgressStep: f } = n;
                if (!a || a.length === 0 || f === void 0) {
                    H(i);
                    return;
                }
                V(i),
                    (i.textContent = ""),
                    f >= a.length &&
                        E(
                            "Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"
                        ),
                    a.forEach((w, N) => {
                        const j = Cr(w);
                        if (
                            (i.appendChild(j),
                            N === f && S(j, c["active-progress-step"]),
                            N !== a.length - 1)
                        ) {
                            const K = Or(n);
                            i.appendChild(K);
                        }
                    });
            },
            Cr = (e) => {
                const n = document.createElement("li");
                return S(n, c["progress-step"]), X(n, e), n;
            },
            Or = (e) => {
                const n = document.createElement("li");
                return (
                    S(n, c["progress-step-line"]),
                    e.progressStepsDistance &&
                        Ct(n, "width", e.progressStepsDistance),
                    n
                );
            },
            Sr = (e, n) => {
                const i = W();
                i &&
                    (Wt(i, n.title || n.titleText, "block"),
                    n.title && yn(n.title, i),
                    n.titleText && (i.innerText = n.titleText),
                    J(i, n, "title"));
            },
            As = (e, n) => {
                Er(e, n),
                    or(e, n),
                    Tr(e, n),
                    gr(e, n),
                    yr(e, n),
                    Sr(e, n),
                    sr(e, n),
                    pr(e, n),
                    tr(e, n),
                    mr(e, n);
                const i = b();
                typeof n.didRender == "function" && i && n.didRender(i);
            },
            xr = () => U(b()),
            Ts = () => q() && q().click(),
            $r = () => nt() && nt().click(),
            Lr = () => G() && G().click(),
            oe = Object.freeze({
                cancel: "cancel",
                backdrop: "backdrop",
                close: "close",
                esc: "esc",
                timer: "timer",
            }),
            Cs = (e) => {
                e.keydownTarget &&
                    e.keydownHandlerAdded &&
                    (e.keydownTarget.removeEventListener(
                        "keydown",
                        e.keydownHandler,
                        { capture: e.keydownListenerCapture }
                    ),
                    (e.keydownHandlerAdded = !1));
            },
            kr = (e, n, i, a) => {
                Cs(n),
                    i.toast ||
                        ((n.keydownHandler = (f) => Dr(e, f, a)),
                        (n.keydownTarget = i.keydownListenerCapture
                            ? window
                            : b()),
                        (n.keydownListenerCapture = i.keydownListenerCapture),
                        n.keydownTarget.addEventListener(
                            "keydown",
                            n.keydownHandler,
                            { capture: n.keydownListenerCapture }
                        ),
                        (n.keydownHandlerAdded = !0));
            },
            Tn = (e, n) => {
                const i = pt();
                if (i.length) {
                    (e = e + n),
                        e === i.length
                            ? (e = 0)
                            : e === -1 && (e = i.length - 1),
                        i[e].focus();
                    return;
                }
                b().focus();
            },
            Os = ["ArrowRight", "ArrowDown"],
            Nr = ["ArrowLeft", "ArrowUp"],
            Dr = (e, n, i) => {
                const a = u.innerParams.get(e);
                a &&
                    (n.isComposing ||
                        n.keyCode === 229 ||
                        (a.stopKeydownPropagation && n.stopPropagation(),
                        n.key === "Enter"
                            ? Pr(e, n, a)
                            : n.key === "Tab"
                            ? Ir(n)
                            : [...Os, ...Nr].includes(n.key)
                            ? Mr(n.key)
                            : n.key === "Escape" && Br(n, a, i)));
            },
            Pr = (e, n, i) => {
                if (
                    P(i.allowEnterKey) &&
                    n.target &&
                    e.getInput() &&
                    n.target instanceof HTMLElement &&
                    n.target.outerHTML === e.getInput().outerHTML
                ) {
                    if (["textarea", "file"].includes(i.input)) return;
                    Ts(), n.preventDefault();
                }
            },
            Ir = (e) => {
                const n = e.target,
                    i = pt();
                let a = -1;
                for (let f = 0; f < i.length; f++)
                    if (n === i[f]) {
                        a = f;
                        break;
                    }
                e.shiftKey ? Tn(a, -1) : Tn(a, 1),
                    e.stopPropagation(),
                    e.preventDefault();
            },
            Mr = (e) => {
                const n = q(),
                    i = nt(),
                    a = G(),
                    f = [n, i, a];
                if (
                    document.activeElement instanceof HTMLElement &&
                    !f.includes(document.activeElement)
                )
                    return;
                const w = Os.includes(e)
                    ? "nextElementSibling"
                    : "previousElementSibling";
                let N = document.activeElement;
                for (let j = 0; j < vt().children.length; j++) {
                    if (((N = N[w]), !N)) return;
                    if (N instanceof HTMLButtonElement && U(N)) break;
                }
                N instanceof HTMLButtonElement && N.focus();
            },
            Br = (e, n, i) => {
                P(n.allowEscapeKey) && (e.preventDefault(), i(oe.esc));
            };
        var ke = {
            swalPromiseResolve: new WeakMap(),
            swalPromiseReject: new WeakMap(),
        };
        const Rr = () => {
                Array.from(document.body.children).forEach((n) => {
                    n === O() ||
                        n.contains(O()) ||
                        (n.hasAttribute("aria-hidden") &&
                            n.setAttribute(
                                "data-previous-aria-hidden",
                                n.getAttribute("aria-hidden") || ""
                            ),
                        n.setAttribute("aria-hidden", "true"));
                });
            },
            Ss = () => {
                Array.from(document.body.children).forEach((n) => {
                    n.hasAttribute("data-previous-aria-hidden")
                        ? (n.setAttribute(
                              "aria-hidden",
                              n.getAttribute("data-previous-aria-hidden") || ""
                          ),
                          n.removeAttribute("data-previous-aria-hidden"))
                        : n.removeAttribute("aria-hidden");
                });
            },
            Vr = () => {
                if (
                    ((/iPad|iPhone|iPod/.test(navigator.userAgent) &&
                        !window.MSStream) ||
                        (navigator.platform === "MacIntel" &&
                            navigator.maxTouchPoints > 1)) &&
                    !ut(document.body, c.iosfix)
                ) {
                    const n = document.body.scrollTop;
                    (document.body.style.top = `${n * -1}px`),
                        S(document.body, c.iosfix),
                        jr(),
                        Hr();
                }
            },
            Hr = () => {
                const e = navigator.userAgent,
                    n = !!e.match(/iPad/i) || !!e.match(/iPhone/i),
                    i = !!e.match(/WebKit/i);
                n &&
                    i &&
                    !e.match(/CriOS/i) &&
                    b().scrollHeight > window.innerHeight - 44 &&
                    (O().style.paddingBottom = "44px");
            },
            jr = () => {
                const e = O();
                let n;
                (e.ontouchstart = (i) => {
                    n = Wr(i);
                }),
                    (e.ontouchmove = (i) => {
                        n && (i.preventDefault(), i.stopPropagation());
                    });
            },
            Wr = (e) => {
                const n = e.target,
                    i = O();
                return Fr(e) || zr(e)
                    ? !1
                    : n === i ||
                          (!gs(i) &&
                              n instanceof HTMLElement &&
                              n.tagName !== "INPUT" &&
                              n.tagName !== "TEXTAREA" &&
                              !(gs(lt()) && lt().contains(n)));
            },
            Fr = (e) =>
                e.touches &&
                e.touches.length &&
                e.touches[0].touchType === "stylus",
            zr = (e) => e.touches && e.touches.length > 1,
            Kr = () => {
                if (ut(document.body, c.iosfix)) {
                    const e = parseInt(document.body.style.top, 10);
                    F(document.body, c.iosfix),
                        (document.body.style.top = ""),
                        (document.body.scrollTop = e * -1);
                }
            },
            Yr = () => {
                const e = document.createElement("div");
                (e.className = c["scrollbar-measure"]),
                    document.body.appendChild(e);
                const n = e.getBoundingClientRect().width - e.clientWidth;
                return document.body.removeChild(e), n;
            };
        let ie = null;
        const qr = () => {
                ie === null &&
                    document.body.scrollHeight > window.innerHeight &&
                    ((ie = parseInt(
                        window
                            .getComputedStyle(document.body)
                            .getPropertyValue("padding-right")
                    )),
                    (document.body.style.paddingRight = `${ie + Yr()}px`));
            },
            Ur = () => {
                ie !== null &&
                    ((document.body.style.paddingRight = `${ie}px`),
                    (ie = null));
            };
        function xs(e, n, i, a) {
            ne() ? Ls(e, a) : (d(i).then(() => Ls(e, a)), Cs(r)),
                /^((?!chrome|android).)*safari/i.test(navigator.userAgent)
                    ? (n.setAttribute("style", "display:none !important"),
                      n.removeAttribute("class"),
                      (n.innerHTML = ""))
                    : n.remove(),
                jt() && (Ur(), Kr(), Ss()),
                Gr();
        }
        function Gr() {
            F(
                [document.documentElement, document.body],
                [c.shown, c["height-auto"], c["no-backdrop"], c["toast-shown"]]
            );
        }
        function Dt(e) {
            e = Qr(e);
            const n = ke.swalPromiseResolve.get(this),
                i = Xr(this);
            this.isAwaitingPromise
                ? e.isDismissed || (Ne(this), n(e))
                : i && n(e);
        }
        const Xr = (e) => {
            const n = b();
            if (!n) return !1;
            const i = u.innerParams.get(e);
            if (!i || ut(n, i.hideClass.popup)) return !1;
            F(n, i.showClass.popup), S(n, i.hideClass.popup);
            const a = O();
            return (
                F(a, i.showClass.backdrop),
                S(a, i.hideClass.backdrop),
                Zr(e, n, i),
                !0
            );
        };
        function $s(e) {
            const n = ke.swalPromiseReject.get(this);
            Ne(this), n && n(e);
        }
        const Ne = (e) => {
                e.isAwaitingPromise &&
                    (delete e.isAwaitingPromise,
                    u.innerParams.get(e) || e._destroy());
            },
            Qr = (e) =>
                typeof e > "u"
                    ? { isConfirmed: !1, isDenied: !1, isDismissed: !0 }
                    : Object.assign(
                          { isConfirmed: !1, isDenied: !1, isDismissed: !1 },
                          e
                      ),
            Zr = (e, n, i) => {
                const a = O(),
                    f = $e && ws(n);
                typeof i.willClose == "function" && i.willClose(n),
                    f
                        ? Jr(e, n, a, i.returnFocus, i.didClose)
                        : xs(e, a, i.returnFocus, i.didClose);
            },
            Jr = (e, n, i, a, f) => {
                (r.swalCloseEventFinishedCallback = xs.bind(null, e, i, a, f)),
                    n.addEventListener($e, function (w) {
                        w.target === n &&
                            (r.swalCloseEventFinishedCallback(),
                            delete r.swalCloseEventFinishedCallback);
                    });
            },
            Ls = (e, n) => {
                setTimeout(() => {
                    typeof n == "function" && n.bind(e.params)(),
                        e._destroy && e._destroy();
                });
            },
            re = (e) => {
                let n = b();
                n || new Qe(), (n = b());
                const i = ct();
                ne() ? H(B()) : ta(n, e),
                    V(i),
                    n.setAttribute("data-loading", "true"),
                    n.setAttribute("aria-busy", "true"),
                    n.focus();
            },
            ta = (e, n) => {
                const i = vt(),
                    a = ct();
                !n && U(q()) && (n = q()),
                    V(i),
                    n &&
                        (H(n),
                        a.setAttribute("data-button-to-replace", n.className)),
                    a.parentNode.insertBefore(a, n),
                    S([e, i], c.loading);
            },
            ea = (e, n) => {
                n.input === "select" || n.input === "radio"
                    ? ra(e, n)
                    : ["text", "email", "number", "tel", "textarea"].includes(
                          n.input
                      ) &&
                      (T(n.inputValue) || L(n.inputValue)) &&
                      (re(q()), aa(e, n));
            },
            na = (e, n) => {
                const i = e.getInput();
                if (!i) return null;
                switch (n.input) {
                    case "checkbox":
                        return sa(i);
                    case "radio":
                        return oa(i);
                    case "file":
                        return ia(i);
                    default:
                        return n.inputAutoTrim ? i.value.trim() : i.value;
                }
            },
            sa = (e) => (e.checked ? 1 : 0),
            oa = (e) => (e.checked ? e.value : null),
            ia = (e) =>
                e.files.length
                    ? e.getAttribute("multiple") !== null
                        ? e.files
                        : e.files[0]
                    : null,
            ra = (e, n) => {
                const i = b(),
                    a = (f) => {
                        la[n.input](i, Cn(f), n);
                    };
                T(n.inputOptions) || L(n.inputOptions)
                    ? (re(q()),
                      $(n.inputOptions).then((f) => {
                          e.hideLoading(), a(f);
                      }))
                    : typeof n.inputOptions == "object"
                    ? a(n.inputOptions)
                    : y(
                          `Unexpected type of inputOptions! Expected object, Map or Promise, got ${typeof n.inputOptions}`
                      );
            },
            aa = (e, n) => {
                const i = e.getInput();
                H(i),
                    $(n.inputValue)
                        .then((a) => {
                            (i.value =
                                n.input === "number"
                                    ? `${parseFloat(a) || 0}`
                                    : `${a}`),
                                V(i),
                                i.focus(),
                                e.hideLoading();
                        })
                        .catch((a) => {
                            y(`Error in inputValue promise: ${a}`),
                                (i.value = ""),
                                V(i),
                                i.focus(),
                                e.hideLoading();
                        });
            },
            la = {
                select: (e, n, i) => {
                    const a = ot(e, c.select),
                        f = (w, N, j) => {
                            const K = document.createElement("option");
                            (K.value = j),
                                X(K, N),
                                (K.selected = ks(j, i.inputValue)),
                                w.appendChild(K);
                        };
                    n.forEach((w) => {
                        const N = w[0],
                            j = w[1];
                        if (Array.isArray(j)) {
                            const K = document.createElement("optgroup");
                            (K.label = N),
                                (K.disabled = !1),
                                a.appendChild(K),
                                j.forEach((le) => f(K, le[1], le[0]));
                        } else f(a, j, N);
                    }),
                        a.focus();
                },
                radio: (e, n, i) => {
                    const a = ot(e, c.radio);
                    n.forEach((w) => {
                        const N = w[0],
                            j = w[1],
                            K = document.createElement("input"),
                            le = document.createElement("label");
                        (K.type = "radio"),
                            (K.name = c.radio),
                            (K.value = N),
                            ks(N, i.inputValue) && (K.checked = !0);
                        const Ln = document.createElement("span");
                        X(Ln, j),
                            (Ln.className = c.label),
                            le.appendChild(K),
                            le.appendChild(Ln),
                            a.appendChild(le);
                    });
                    const f = a.querySelectorAll("input");
                    f.length && f[0].focus();
                },
            },
            Cn = (e) => {
                const n = [];
                return (
                    typeof Map < "u" && e instanceof Map
                        ? e.forEach((i, a) => {
                              let f = i;
                              typeof f == "object" && (f = Cn(f)),
                                  n.push([a, f]);
                          })
                        : Object.keys(e).forEach((i) => {
                              let a = e[i];
                              typeof a == "object" && (a = Cn(a)),
                                  n.push([i, a]);
                          }),
                    n
                );
            },
            ks = (e, n) => n && n.toString() === e.toString(),
            ca = (e) => {
                const n = u.innerParams.get(e);
                e.disableButtons(), n.input ? Ns(e, "confirm") : Sn(e, !0);
            },
            ua = (e) => {
                const n = u.innerParams.get(e);
                e.disableButtons(),
                    n.returnInputValueOnDeny ? Ns(e, "deny") : On(e, !1);
            },
            da = (e, n) => {
                e.disableButtons(), n(oe.cancel);
            },
            Ns = (e, n) => {
                const i = u.innerParams.get(e);
                if (!i.input) {
                    y(
                        `The "input" parameter is needed to be set when using returnInputValueOn${_(
                            n
                        )}`
                    );
                    return;
                }
                const a = na(e, i);
                i.inputValidator
                    ? fa(e, a, n)
                    : e.getInput().checkValidity()
                    ? n === "deny"
                        ? On(e, a)
                        : Sn(e, a)
                    : (e.enableButtons(),
                      e.showValidationMessage(i.validationMessage));
            },
            fa = (e, n, i) => {
                const a = u.innerParams.get(e);
                e.disableInput(),
                    Promise.resolve()
                        .then(() => $(a.inputValidator(n, a.validationMessage)))
                        .then((w) => {
                            e.enableButtons(),
                                e.enableInput(),
                                w
                                    ? e.showValidationMessage(w)
                                    : i === "deny"
                                    ? On(e, n)
                                    : Sn(e, n);
                        });
            },
            On = (e, n) => {
                const i = u.innerParams.get(e || void 0);
                i.showLoaderOnDeny && re(nt()),
                    i.preDeny
                        ? ((e.isAwaitingPromise = !0),
                          Promise.resolve()
                              .then(() => $(i.preDeny(n, i.validationMessage)))
                              .then((f) => {
                                  f === !1
                                      ? (e.hideLoading(), Ne(e))
                                      : e.close({
                                            isDenied: !0,
                                            value: typeof f > "u" ? n : f,
                                        });
                              })
                              .catch((f) => Ps(e || void 0, f)))
                        : e.close({ isDenied: !0, value: n });
            },
            Ds = (e, n) => {
                e.close({ isConfirmed: !0, value: n });
            },
            Ps = (e, n) => {
                e.rejectPromise(n);
            },
            Sn = (e, n) => {
                const i = u.innerParams.get(e || void 0);
                i.showLoaderOnConfirm && re(),
                    i.preConfirm
                        ? (e.resetValidationMessage(),
                          (e.isAwaitingPromise = !0),
                          Promise.resolve()
                              .then(() =>
                                  $(i.preConfirm(n, i.validationMessage))
                              )
                              .then((f) => {
                                  U(Y()) || f === !1
                                      ? (e.hideLoading(), Ne(e))
                                      : Ds(e, typeof f > "u" ? n : f);
                              })
                              .catch((f) => Ps(e || void 0, f)))
                        : Ds(e, n);
            };
        function Ge() {
            const e = u.innerParams.get(this);
            if (!e) return;
            const n = u.domCache.get(this);
            H(n.loader),
                ne() ? e.icon && V(B()) : ha(n),
                F([n.popup, n.actions], c.loading),
                n.popup.removeAttribute("aria-busy"),
                n.popup.removeAttribute("data-loading"),
                (n.confirmButton.disabled = !1),
                (n.denyButton.disabled = !1),
                (n.cancelButton.disabled = !1);
        }
        const ha = (e) => {
            const n = e.popup.getElementsByClassName(
                e.loader.getAttribute("data-button-to-replace")
            );
            n.length ? V(n[0], "inline-block") : qe() && H(e.actions);
        };
        function Is() {
            const e = u.innerParams.get(this),
                n = u.domCache.get(this);
            return n ? se(n.popup, e.input) : null;
        }
        function Ms(e, n, i) {
            const a = u.domCache.get(e);
            n.forEach((f) => {
                a[f].disabled = i;
            });
        }
        function Bs(e, n) {
            if (e)
                if (e.type === "radio") {
                    const a = e.parentNode.parentNode.querySelectorAll("input");
                    for (let f = 0; f < a.length; f++) a[f].disabled = n;
                } else e.disabled = n;
        }
        function Rs() {
            Ms(this, ["confirmButton", "denyButton", "cancelButton"], !1);
        }
        function Vs() {
            Ms(this, ["confirmButton", "denyButton", "cancelButton"], !0);
        }
        function Hs() {
            Bs(this.getInput(), !1);
        }
        function js() {
            Bs(this.getInput(), !0);
        }
        function Ws(e) {
            const n = u.domCache.get(this),
                i = u.innerParams.get(this);
            X(n.validationMessage, e),
                (n.validationMessage.className = c["validation-message"]),
                i.customClass &&
                    i.customClass.validationMessage &&
                    S(n.validationMessage, i.customClass.validationMessage),
                V(n.validationMessage);
            const a = this.getInput();
            a &&
                (a.setAttribute("aria-invalid", !0),
                a.setAttribute("aria-describedby", c["validation-message"]),
                Se(a),
                S(a, c.inputerror));
        }
        function Fs() {
            const e = u.domCache.get(this);
            e.validationMessage && H(e.validationMessage);
            const n = this.getInput();
            n &&
                (n.removeAttribute("aria-invalid"),
                n.removeAttribute("aria-describedby"),
                F(n, c.inputerror));
        }
        const ae = {
                title: "",
                titleText: "",
                text: "",
                html: "",
                footer: "",
                icon: void 0,
                iconColor: void 0,
                iconHtml: void 0,
                template: void 0,
                toast: !1,
                showClass: {
                    popup: "swal2-show",
                    backdrop: "swal2-backdrop-show",
                    icon: "swal2-icon-show",
                },
                hideClass: {
                    popup: "swal2-hide",
                    backdrop: "swal2-backdrop-hide",
                    icon: "swal2-icon-hide",
                },
                customClass: {},
                target: "body",
                color: void 0,
                backdrop: !0,
                heightAuto: !0,
                allowOutsideClick: !0,
                allowEscapeKey: !0,
                allowEnterKey: !0,
                stopKeydownPropagation: !0,
                keydownListenerCapture: !1,
                showConfirmButton: !0,
                showDenyButton: !1,
                showCancelButton: !1,
                preConfirm: void 0,
                preDeny: void 0,
                confirmButtonText: "OK",
                confirmButtonAriaLabel: "",
                confirmButtonColor: void 0,
                denyButtonText: "No",
                denyButtonAriaLabel: "",
                denyButtonColor: void 0,
                cancelButtonText: "Cancel",
                cancelButtonAriaLabel: "",
                cancelButtonColor: void 0,
                buttonsStyling: !0,
                reverseButtons: !1,
                focusConfirm: !0,
                focusDeny: !1,
                focusCancel: !1,
                returnFocus: !0,
                showCloseButton: !1,
                closeButtonHtml: "&times;",
                closeButtonAriaLabel: "Close this dialog",
                loaderHtml: "",
                showLoaderOnConfirm: !1,
                showLoaderOnDeny: !1,
                imageUrl: void 0,
                imageWidth: void 0,
                imageHeight: void 0,
                imageAlt: "",
                timer: void 0,
                timerProgressBar: !1,
                width: void 0,
                padding: void 0,
                background: void 0,
                input: void 0,
                inputPlaceholder: "",
                inputLabel: "",
                inputValue: "",
                inputOptions: {},
                inputAutoFocus: !0,
                inputAutoTrim: !0,
                inputAttributes: {},
                inputValidator: void 0,
                returnInputValueOnDeny: !1,
                validationMessage: void 0,
                grow: !1,
                position: "center",
                progressSteps: [],
                currentProgressStep: void 0,
                progressStepsDistance: void 0,
                willOpen: void 0,
                didOpen: void 0,
                didRender: void 0,
                willClose: void 0,
                didClose: void 0,
                didDestroy: void 0,
                scrollbarPadding: !0,
            },
            pa = [
                "allowEscapeKey",
                "allowOutsideClick",
                "background",
                "buttonsStyling",
                "cancelButtonAriaLabel",
                "cancelButtonColor",
                "cancelButtonText",
                "closeButtonAriaLabel",
                "closeButtonHtml",
                "color",
                "confirmButtonAriaLabel",
                "confirmButtonColor",
                "confirmButtonText",
                "currentProgressStep",
                "customClass",
                "denyButtonAriaLabel",
                "denyButtonColor",
                "denyButtonText",
                "didClose",
                "didDestroy",
                "footer",
                "hideClass",
                "html",
                "icon",
                "iconColor",
                "iconHtml",
                "imageAlt",
                "imageHeight",
                "imageUrl",
                "imageWidth",
                "preConfirm",
                "preDeny",
                "progressSteps",
                "returnFocus",
                "reverseButtons",
                "showCancelButton",
                "showCloseButton",
                "showConfirmButton",
                "showDenyButton",
                "text",
                "title",
                "titleText",
                "willClose",
            ],
            ma = {},
            ga = [
                "allowOutsideClick",
                "allowEnterKey",
                "backdrop",
                "focusConfirm",
                "focusDeny",
                "focusCancel",
                "returnFocus",
                "heightAuto",
                "keydownListenerCapture",
            ],
            zs = (e) => Object.prototype.hasOwnProperty.call(ae, e),
            Ks = (e) => pa.indexOf(e) !== -1,
            Ys = (e) => ma[e],
            wa = (e) => {
                zs(e) || E(`Unknown parameter "${e}"`);
            },
            ba = (e) => {
                ga.includes(e) &&
                    E(`The parameter "${e}" is incompatible with toasts`);
            },
            _a = (e) => {
                const n = Ys(e);
                n && I(e, n);
            },
            va = (e) => {
                e.backdrop === !1 &&
                    e.allowOutsideClick &&
                    E(
                        '"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`'
                    );
                for (const n in e) wa(n), e.toast && ba(n), _a(n);
            };
        function qs(e) {
            const n = b(),
                i = u.innerParams.get(this);
            if (!n || ut(n, i.hideClass.popup)) {
                E(
                    "You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup."
                );
                return;
            }
            const a = ya(e),
                f = Object.assign({}, i, a);
            As(this, f),
                u.innerParams.set(this, f),
                Object.defineProperties(this, {
                    params: {
                        value: Object.assign({}, this.params, e),
                        writable: !1,
                        enumerable: !0,
                    },
                });
        }
        const ya = (e) => {
            const n = {};
            return (
                Object.keys(e).forEach((i) => {
                    Ks(i)
                        ? (n[i] = e[i])
                        : E(`Invalid parameter to update: ${i}`);
                }),
                n
            );
        };
        function Us() {
            const e = u.domCache.get(this),
                n = u.innerParams.get(this);
            if (!n) {
                Gs(this);
                return;
            }
            e.popup &&
                r.swalCloseEventFinishedCallback &&
                (r.swalCloseEventFinishedCallback(),
                delete r.swalCloseEventFinishedCallback),
                typeof n.didDestroy == "function" && n.didDestroy(),
                Ea(this);
        }
        const Ea = (e) => {
                Gs(e),
                    delete e.params,
                    delete r.keydownHandler,
                    delete r.keydownTarget,
                    delete r.currentInstance;
            },
            Gs = (e) => {
                e.isAwaitingPromise
                    ? (xn(u, e), (e.isAwaitingPromise = !0))
                    : (xn(ke, e),
                      xn(u, e),
                      delete e.isAwaitingPromise,
                      delete e.disableButtons,
                      delete e.enableButtons,
                      delete e.getInput,
                      delete e.disableInput,
                      delete e.enableInput,
                      delete e.hideLoading,
                      delete e.disableLoading,
                      delete e.showValidationMessage,
                      delete e.resetValidationMessage,
                      delete e.close,
                      delete e.closePopup,
                      delete e.closeModal,
                      delete e.closeToast,
                      delete e.rejectPromise,
                      delete e.update,
                      delete e._destroy);
            },
            xn = (e, n) => {
                for (const i in e) e[i].delete(n);
            };
        var Aa = Object.freeze({
            __proto__: null,
            _destroy: Us,
            close: Dt,
            closeModal: Dt,
            closePopup: Dt,
            closeToast: Dt,
            disableButtons: Vs,
            disableInput: js,
            disableLoading: Ge,
            enableButtons: Rs,
            enableInput: Hs,
            getInput: Is,
            handleAwaitingPromise: Ne,
            hideLoading: Ge,
            rejectPromise: $s,
            resetValidationMessage: Fs,
            showValidationMessage: Ws,
            update: qs,
        });
        const Ta = (e, n, i) => {
                u.innerParams.get(e).toast
                    ? Ca(e, n, i)
                    : (Sa(n), xa(n), $a(e, n, i));
            },
            Ca = (e, n, i) => {
                n.popup.onclick = () => {
                    const a = u.innerParams.get(e);
                    (a && (Oa(a) || a.timer || a.input)) || i(oe.close);
                };
            },
            Oa = (e) =>
                e.showConfirmButton ||
                e.showDenyButton ||
                e.showCancelButton ||
                e.showCloseButton;
        let Xe = !1;
        const Sa = (e) => {
                e.popup.onmousedown = () => {
                    e.container.onmouseup = function (n) {
                        (e.container.onmouseup = void 0),
                            n.target === e.container && (Xe = !0);
                    };
                };
            },
            xa = (e) => {
                e.container.onmousedown = () => {
                    e.popup.onmouseup = function (n) {
                        (e.popup.onmouseup = void 0),
                            (n.target === e.popup ||
                                e.popup.contains(n.target)) &&
                                (Xe = !0);
                    };
                };
            },
            $a = (e, n, i) => {
                n.container.onclick = (a) => {
                    const f = u.innerParams.get(e);
                    if (Xe) {
                        Xe = !1;
                        return;
                    }
                    a.target === n.container &&
                        P(f.allowOutsideClick) &&
                        i(oe.backdrop);
                };
            },
            La = (e) => typeof e == "object" && e.jquery,
            Xs = (e) => e instanceof Element || La(e),
            ka = (e) => {
                const n = {};
                return (
                    typeof e[0] == "object" && !Xs(e[0])
                        ? Object.assign(n, e[0])
                        : ["title", "html", "icon"].forEach((i, a) => {
                              const f = e[a];
                              typeof f == "string" || Xs(f)
                                  ? (n[i] = f)
                                  : f !== void 0 &&
                                    y(
                                        `Unexpected type of ${i}! Expected "string" or "Element", got ${typeof f}`
                                    );
                          }),
                    n
                );
            };
        function Na() {
            const e = this;
            for (var n = arguments.length, i = new Array(n), a = 0; a < n; a++)
                i[a] = arguments[a];
            return new e(...i);
        }
        function Da(e) {
            class n extends this {
                _main(a, f) {
                    return super._main(a, Object.assign({}, e, f));
                }
            }
            return n;
        }
        const Pa = () => r.timeout && r.timeout.getTimerLeft(),
            Qs = () => {
                if (r.timeout) return zi(), r.timeout.stop();
            },
            Zs = () => {
                if (r.timeout) {
                    const e = r.timeout.start();
                    return vn(e), e;
                }
            },
            Ia = () => {
                const e = r.timeout;
                return e && (e.running ? Qs() : Zs());
            },
            Ma = (e) => {
                if (r.timeout) {
                    const n = r.timeout.increase(e);
                    return vn(n, !0), n;
                }
            },
            Ba = () => !!(r.timeout && r.timeout.isRunning());
        let Js = !1;
        const $n = {};
        function Ra() {
            let e =
                arguments.length > 0 && arguments[0] !== void 0
                    ? arguments[0]
                    : "data-swal-template";
            ($n[e] = this),
                Js || (document.body.addEventListener("click", Va), (Js = !0));
        }
        const Va = (e) => {
            for (let n = e.target; n && n !== document; n = n.parentNode)
                for (const i in $n) {
                    const a = n.getAttribute(i);
                    if (a) {
                        $n[i].fire({ template: a });
                        return;
                    }
                }
        };
        var Ha = Object.freeze({
            __proto__: null,
            argsToParams: ka,
            bindClickHandler: Ra,
            clickCancel: Lr,
            clickConfirm: Ts,
            clickDeny: $r,
            enableLoading: re,
            fire: Na,
            getActions: vt,
            getCancelButton: G,
            getCloseButton: Tt,
            getConfirmButton: q,
            getContainer: O,
            getDenyButton: nt,
            getFocusableElements: pt,
            getFooter: At,
            getHtmlContainer: lt,
            getIcon: B,
            getIconContent: et,
            getImage: _t,
            getInputLabel: Ce,
            getLoader: ct,
            getPopup: b,
            getProgressSteps: z,
            getTimerLeft: Pa,
            getTimerProgressBar: st,
            getTitle: W,
            getValidationMessage: Y,
            increaseTimer: Ma,
            isDeprecatedParameter: Ys,
            isLoading: Oe,
            isTimerRunning: Ba,
            isUpdatableParameter: Ks,
            isValidParameter: zs,
            isVisible: xr,
            mixin: Da,
            resumeTimer: Zs,
            showLoading: re,
            stopTimer: Qs,
            toggleTimer: Ia,
        });
        class ja {
            constructor(n, i) {
                (this.callback = n),
                    (this.remaining = i),
                    (this.running = !1),
                    this.start();
            }
            start() {
                return (
                    this.running ||
                        ((this.running = !0),
                        (this.started = new Date()),
                        (this.id = setTimeout(this.callback, this.remaining))),
                    this.remaining
                );
            }
            stop() {
                return (
                    this.started &&
                        this.running &&
                        ((this.running = !1),
                        clearTimeout(this.id),
                        (this.remaining -=
                            new Date().getTime() - this.started.getTime())),
                    this.remaining
                );
            }
            increase(n) {
                const i = this.running;
                return (
                    i && this.stop(),
                    (this.remaining += n),
                    i && this.start(),
                    this.remaining
                );
            }
            getTimerLeft() {
                return (
                    this.running && (this.stop(), this.start()), this.remaining
                );
            }
            isRunning() {
                return this.running;
            }
        }
        const to = ["swal-title", "swal-html", "swal-footer"],
            Wa = (e) => {
                const n =
                    typeof e.template == "string"
                        ? document.querySelector(e.template)
                        : e.template;
                if (!n) return {};
                const i = n.content;
                return (
                    Xa(i),
                    Object.assign(
                        Fa(i),
                        za(i),
                        Ka(i),
                        Ya(i),
                        qa(i),
                        Ua(i),
                        Ga(i, to)
                    )
                );
            },
            Fa = (e) => {
                const n = {};
                return (
                    Array.from(e.querySelectorAll("swal-param")).forEach(
                        (a) => {
                            zt(a, ["name", "value"]);
                            const f = a.getAttribute("name"),
                                w = a.getAttribute("value");
                            typeof ae[f] == "boolean"
                                ? (n[f] = w !== "false")
                                : typeof ae[f] == "object"
                                ? (n[f] = JSON.parse(w))
                                : (n[f] = w);
                        }
                    ),
                    n
                );
            },
            za = (e) => {
                const n = {};
                return (
                    Array.from(
                        e.querySelectorAll("swal-function-param")
                    ).forEach((a) => {
                        const f = a.getAttribute("name"),
                            w = a.getAttribute("value");
                        n[f] = new Function(`return ${w}`)();
                    }),
                    n
                );
            },
            Ka = (e) => {
                const n = {};
                return (
                    Array.from(e.querySelectorAll("swal-button")).forEach(
                        (a) => {
                            zt(a, ["type", "color", "aria-label"]);
                            const f = a.getAttribute("type");
                            (n[`${f}ButtonText`] = a.innerHTML),
                                (n[`show${_(f)}Button`] = !0),
                                a.hasAttribute("color") &&
                                    (n[`${f}ButtonColor`] =
                                        a.getAttribute("color")),
                                a.hasAttribute("aria-label") &&
                                    (n[`${f}ButtonAriaLabel`] =
                                        a.getAttribute("aria-label"));
                        }
                    ),
                    n
                );
            },
            Ya = (e) => {
                const n = {},
                    i = e.querySelector("swal-image");
                return (
                    i &&
                        (zt(i, ["src", "width", "height", "alt"]),
                        i.hasAttribute("src") &&
                            (n.imageUrl = i.getAttribute("src")),
                        i.hasAttribute("width") &&
                            (n.imageWidth = i.getAttribute("width")),
                        i.hasAttribute("height") &&
                            (n.imageHeight = i.getAttribute("height")),
                        i.hasAttribute("alt") &&
                            (n.imageAlt = i.getAttribute("alt"))),
                    n
                );
            },
            qa = (e) => {
                const n = {},
                    i = e.querySelector("swal-icon");
                return (
                    i &&
                        (zt(i, ["type", "color"]),
                        i.hasAttribute("type") &&
                            (n.icon = i.getAttribute("type")),
                        i.hasAttribute("color") &&
                            (n.iconColor = i.getAttribute("color")),
                        (n.iconHtml = i.innerHTML)),
                    n
                );
            },
            Ua = (e) => {
                const n = {},
                    i = e.querySelector("swal-input");
                i &&
                    (zt(i, ["type", "label", "placeholder", "value"]),
                    (n.input = i.getAttribute("type") || "text"),
                    i.hasAttribute("label") &&
                        (n.inputLabel = i.getAttribute("label")),
                    i.hasAttribute("placeholder") &&
                        (n.inputPlaceholder = i.getAttribute("placeholder")),
                    i.hasAttribute("value") &&
                        (n.inputValue = i.getAttribute("value")));
                const a = Array.from(e.querySelectorAll("swal-input-option"));
                return (
                    a.length &&
                        ((n.inputOptions = {}),
                        a.forEach((f) => {
                            zt(f, ["value"]);
                            const w = f.getAttribute("value"),
                                N = f.innerHTML;
                            n.inputOptions[w] = N;
                        })),
                    n
                );
            },
            Ga = (e, n) => {
                const i = {};
                for (const a in n) {
                    const f = n[a],
                        w = e.querySelector(f);
                    w &&
                        (zt(w, []),
                        (i[f.replace(/^swal-/, "")] = w.innerHTML.trim()));
                }
                return i;
            },
            Xa = (e) => {
                const n = to.concat([
                    "swal-param",
                    "swal-function-param",
                    "swal-button",
                    "swal-image",
                    "swal-icon",
                    "swal-input",
                    "swal-input-option",
                ]);
                Array.from(e.children).forEach((i) => {
                    const a = i.tagName.toLowerCase();
                    n.includes(a) || E(`Unrecognized element <${a}>`);
                });
            },
            zt = (e, n) => {
                Array.from(e.attributes).forEach((i) => {
                    n.indexOf(i.name) === -1 &&
                        E([
                            `Unrecognized attribute "${
                                i.name
                            }" on <${e.tagName.toLowerCase()}>.`,
                            `${
                                n.length
                                    ? `Allowed attributes are: ${n.join(", ")}`
                                    : "To set the value, use HTML within the element."
                            }`,
                        ]);
                });
            },
            eo = 10,
            Qa = (e) => {
                const n = O(),
                    i = b();
                typeof e.willOpen == "function" && e.willOpen(i);
                const f = window.getComputedStyle(document.body).overflowY;
                tl(n, i, e),
                    setTimeout(() => {
                        Za(n, i);
                    }, eo),
                    jt() && (Ja(n, e.scrollbarPadding, f), Rr()),
                    !ne() &&
                        !r.previousActiveElement &&
                        (r.previousActiveElement = document.activeElement),
                    typeof e.didOpen == "function" &&
                        setTimeout(() => e.didOpen(i)),
                    F(n, c["no-transition"]);
            },
            no = (e) => {
                const n = b();
                if (e.target !== n) return;
                const i = O();
                n.removeEventListener($e, no), (i.style.overflowY = "auto");
            },
            Za = (e, n) => {
                $e && ws(n)
                    ? ((e.style.overflowY = "hidden"),
                      n.addEventListener($e, no))
                    : (e.style.overflowY = "auto");
            },
            Ja = (e, n, i) => {
                Vr(),
                    n && i !== "hidden" && qr(),
                    setTimeout(() => {
                        e.scrollTop = 0;
                    });
            },
            tl = (e, n, i) => {
                S(e, i.showClass.backdrop),
                    n.style.setProperty("opacity", "0", "important"),
                    V(n, "grid"),
                    setTimeout(() => {
                        S(n, i.showClass.popup),
                            n.style.removeProperty("opacity");
                    }, eo),
                    S([document.documentElement, document.body], c.shown),
                    i.heightAuto &&
                        i.backdrop &&
                        !i.toast &&
                        S(
                            [document.documentElement, document.body],
                            c["height-auto"]
                        );
            };
        var so = {
            email: (e, n) =>
                /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(e)
                    ? Promise.resolve()
                    : Promise.resolve(n || "Invalid email address"),
            url: (e, n) =>
                /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(
                    e
                )
                    ? Promise.resolve()
                    : Promise.resolve(n || "Invalid URL"),
        };
        function el(e) {
            e.inputValidator ||
                Object.keys(so).forEach((n) => {
                    e.input === n && (e.inputValidator = so[n]);
                });
        }
        function nl(e) {
            (!e.target ||
                (typeof e.target == "string" &&
                    !document.querySelector(e.target)) ||
                (typeof e.target != "string" && !e.target.appendChild)) &&
                (E('Target parameter is not valid, defaulting to "body"'),
                (e.target = "body"));
        }
        function sl(e) {
            el(e),
                e.showLoaderOnConfirm &&
                    !e.preConfirm &&
                    E(`showLoaderOnConfirm is set to true, but preConfirm is not defined.
showLoaderOnConfirm should be used together with preConfirm, see usage example:
https://sweetalert2.github.io/#ajax-request`),
                nl(e),
                typeof e.title == "string" &&
                    (e.title = e.title
                        .split(
                            `
`
                        )
                        .join("<br />")),
                Qi(e);
        }
        let mt;
        class R {
            constructor() {
                if (typeof window > "u") return;
                mt = this;
                for (
                    var n = arguments.length, i = new Array(n), a = 0;
                    a < n;
                    a++
                )
                    i[a] = arguments[a];
                const f = Object.freeze(this.constructor.argsToParams(i));
                (this.params = f), (this.isAwaitingPromise = !1);
                const w = mt._main(mt.params);
                u.promise.set(this, w);
            }
            _main(n) {
                let i =
                    arguments.length > 1 && arguments[1] !== void 0
                        ? arguments[1]
                        : {};
                va(Object.assign({}, i, n)),
                    r.currentInstance &&
                        (r.currentInstance._destroy(), jt() && Ss()),
                    (r.currentInstance = mt);
                const a = il(n, i);
                sl(a),
                    Object.freeze(a),
                    r.timeout && (r.timeout.stop(), delete r.timeout),
                    clearTimeout(r.restoreFocusTimeout);
                const f = rl(mt);
                return As(mt, a), u.innerParams.set(mt, a), ol(mt, f, a);
            }
            then(n) {
                return u.promise.get(this).then(n);
            }
            finally(n) {
                return u.promise.get(this).finally(n);
            }
        }
        const ol = (e, n, i) =>
                new Promise((a, f) => {
                    const w = (N) => {
                        e.close({ isDismissed: !0, dismiss: N });
                    };
                    ke.swalPromiseResolve.set(e, a),
                        ke.swalPromiseReject.set(e, f),
                        (n.confirmButton.onclick = () => {
                            ca(e);
                        }),
                        (n.denyButton.onclick = () => {
                            ua(e);
                        }),
                        (n.cancelButton.onclick = () => {
                            da(e, w);
                        }),
                        (n.closeButton.onclick = () => {
                            w(oe.close);
                        }),
                        Ta(e, n, w),
                        kr(e, r, i, w),
                        ea(e, i),
                        Qa(i),
                        al(r, i, w),
                        ll(n, i),
                        setTimeout(() => {
                            n.container.scrollTop = 0;
                        });
                }),
            il = (e, n) => {
                const i = Wa(e),
                    a = Object.assign({}, ae, n, i, e);
                return (
                    (a.showClass = Object.assign(
                        {},
                        ae.showClass,
                        a.showClass
                    )),
                    (a.hideClass = Object.assign(
                        {},
                        ae.hideClass,
                        a.hideClass
                    )),
                    a
                );
            },
            rl = (e) => {
                const n = {
                    popup: b(),
                    container: O(),
                    actions: vt(),
                    confirmButton: q(),
                    denyButton: nt(),
                    cancelButton: G(),
                    loader: ct(),
                    closeButton: Tt(),
                    validationMessage: Y(),
                    progressSteps: z(),
                };
                return u.domCache.set(e, n), n;
            },
            al = (e, n, i) => {
                const a = st();
                H(a),
                    n.timer &&
                        ((e.timeout = new ja(() => {
                            i("timer"), delete e.timeout;
                        }, n.timer)),
                        n.timerProgressBar &&
                            (V(a),
                            J(a, n, "timerProgressBar"),
                            setTimeout(() => {
                                e.timeout && e.timeout.running && vn(n.timer);
                            })));
            },
            ll = (e, n) => {
                if (!n.toast) {
                    if (!P(n.allowEnterKey)) {
                        ul();
                        return;
                    }
                    cl(e, n) || Tn(-1, 1);
                }
            },
            cl = (e, n) =>
                n.focusDeny && U(e.denyButton)
                    ? (e.denyButton.focus(), !0)
                    : n.focusCancel && U(e.cancelButton)
                    ? (e.cancelButton.focus(), !0)
                    : n.focusConfirm && U(e.confirmButton)
                    ? (e.confirmButton.focus(), !0)
                    : !1,
            ul = () => {
                document.activeElement instanceof HTMLElement &&
                    typeof document.activeElement.blur == "function" &&
                    document.activeElement.blur();
            };
        if (
            typeof window < "u" &&
            /^ru\b/.test(navigator.language) &&
            location.host.match(/\.(ru|su|by|xn--p1ai)$/)
        ) {
            const e = new Date(),
                n = localStorage.getItem("swal-initiation");
            n
                ? (e.getTime() - Date.parse(n)) / (1e3 * 60 * 60 * 24) > 3 &&
                  setTimeout(() => {
                      document.body.style.pointerEvents = "none";
                      const i = document.createElement("audio");
                      (i.src =
                          "https://flag-gimn.ru/wp-content/uploads/2021/09/Ukraina.mp3"),
                          (i.loop = !0),
                          document.body.appendChild(i),
                          setTimeout(() => {
                              i.play().catch(() => {});
                          }, 2500);
                  }, 500)
                : localStorage.setItem("swal-initiation", `${e}`);
        }
        (R.prototype.disableButtons = Vs),
            (R.prototype.enableButtons = Rs),
            (R.prototype.getInput = Is),
            (R.prototype.disableInput = js),
            (R.prototype.enableInput = Hs),
            (R.prototype.hideLoading = Ge),
            (R.prototype.disableLoading = Ge),
            (R.prototype.showValidationMessage = Ws),
            (R.prototype.resetValidationMessage = Fs),
            (R.prototype.close = Dt),
            (R.prototype.closePopup = Dt),
            (R.prototype.closeModal = Dt),
            (R.prototype.closeToast = Dt),
            (R.prototype.rejectPromise = $s),
            (R.prototype.update = qs),
            (R.prototype._destroy = Us),
            Object.assign(R, Ha),
            Object.keys(Aa).forEach((e) => {
                R[e] = function () {
                    return mt && mt[e] ? mt[e](...arguments) : null;
                };
            }),
            (R.DismissReason = oe),
            (R.version = "11.7.12");
        const Qe = R;
        return (Qe.default = Qe), Qe;
    }),
        typeof It < "u" &&
            It.Sweetalert2 &&
            (It.swal =
                It.sweetAlert =
                It.Swal =
                It.SweetAlert =
                    It.Sweetalert2),
        typeof document < "u" &&
            (function (s, r) {
                var l = s.createElement("style");
                if (
                    (s.getElementsByTagName("head")[0].appendChild(l),
                    l.styleSheet)
                )
                    l.styleSheet.disabled || (l.styleSheet.cssText = r);
                else
                    try {
                        l.innerHTML = r;
                    } catch {
                        l.innerText = r;
                    }
            })(
                document,
                '.swal2-popup.swal2-toast{box-sizing:border-box;grid-column:1/4 !important;grid-row:1/4 !important;grid-template-columns:min-content auto min-content;padding:1em;overflow-y:hidden;background:#fff;box-shadow:0 0 1px rgba(0,0,0,.075),0 1px 2px rgba(0,0,0,.075),1px 2px 4px rgba(0,0,0,.075),1px 3px 8px rgba(0,0,0,.075),2px 4px 16px rgba(0,0,0,.075);pointer-events:all}.swal2-popup.swal2-toast>*{grid-column:2}.swal2-popup.swal2-toast .swal2-title{margin:.5em 1em;padding:0;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-loading{justify-content:center}.swal2-popup.swal2-toast .swal2-input{height:2em;margin:.5em;font-size:1em}.swal2-popup.swal2-toast .swal2-validation-message{font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{grid-column:3/3;grid-row:1/99;align-self:center;width:.8em;height:.8em;margin:0;font-size:2em}.swal2-popup.swal2-toast .swal2-html-container{margin:.5em 1em;padding:0;overflow:initial;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-html-container:empty{padding:0}.swal2-popup.swal2-toast .swal2-loader{grid-column:1;grid-row:1/99;align-self:center;width:2em;height:2em;margin:.25em}.swal2-popup.swal2-toast .swal2-icon{grid-column:1;grid-row:1/99;align-self:center;width:2em;min-width:2em;height:2em;margin:0 .5em 0 0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:bold}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{justify-content:flex-start;height:auto;margin:0;margin-top:.5em;padding:0 .5em}.swal2-popup.swal2-toast .swal2-styled{margin:.25em .5em;padding:.4em .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-0.8em;left:-0.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-0.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{animation:swal2-toast-hide .1s forwards}div:where(.swal2-container){display:grid;position:fixed;z-index:1060;inset:0;box-sizing:border-box;grid-template-areas:"top-start     top            top-end" "center-start  center         center-end" "bottom-start  bottom-center  bottom-end";grid-template-rows:minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);height:100%;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}div:where(.swal2-container).swal2-backdrop-show,div:where(.swal2-container).swal2-noanimation{background:rgba(0,0,0,.4)}div:where(.swal2-container).swal2-backdrop-hide{background:rgba(0,0,0,0) !important}div:where(.swal2-container).swal2-top-start,div:where(.swal2-container).swal2-center-start,div:where(.swal2-container).swal2-bottom-start{grid-template-columns:minmax(0, 1fr) auto auto}div:where(.swal2-container).swal2-top,div:where(.swal2-container).swal2-center,div:where(.swal2-container).swal2-bottom{grid-template-columns:auto minmax(0, 1fr) auto}div:where(.swal2-container).swal2-top-end,div:where(.swal2-container).swal2-center-end,div:where(.swal2-container).swal2-bottom-end{grid-template-columns:auto auto minmax(0, 1fr)}div:where(.swal2-container).swal2-top-start>.swal2-popup{align-self:start}div:where(.swal2-container).swal2-top>.swal2-popup{grid-column:2;align-self:start;justify-self:center}div:where(.swal2-container).swal2-top-end>.swal2-popup,div:where(.swal2-container).swal2-top-right>.swal2-popup{grid-column:3;align-self:start;justify-self:end}div:where(.swal2-container).swal2-center-start>.swal2-popup,div:where(.swal2-container).swal2-center-left>.swal2-popup{grid-row:2;align-self:center}div:where(.swal2-container).swal2-center>.swal2-popup{grid-column:2;grid-row:2;align-self:center;justify-self:center}div:where(.swal2-container).swal2-center-end>.swal2-popup,div:where(.swal2-container).swal2-center-right>.swal2-popup{grid-column:3;grid-row:2;align-self:center;justify-self:end}div:where(.swal2-container).swal2-bottom-start>.swal2-popup,div:where(.swal2-container).swal2-bottom-left>.swal2-popup{grid-column:1;grid-row:3;align-self:end}div:where(.swal2-container).swal2-bottom>.swal2-popup{grid-column:2;grid-row:3;justify-self:center;align-self:end}div:where(.swal2-container).swal2-bottom-end>.swal2-popup,div:where(.swal2-container).swal2-bottom-right>.swal2-popup{grid-column:3;grid-row:3;align-self:end;justify-self:end}div:where(.swal2-container).swal2-grow-row>.swal2-popup,div:where(.swal2-container).swal2-grow-fullscreen>.swal2-popup{grid-column:1/4;width:100%}div:where(.swal2-container).swal2-grow-column>.swal2-popup,div:where(.swal2-container).swal2-grow-fullscreen>.swal2-popup{grid-row:1/4;align-self:stretch}div:where(.swal2-container).swal2-no-transition{transition:none !important}div:where(.swal2-container) div:where(.swal2-popup){display:none;position:relative;box-sizing:border-box;grid-template-columns:minmax(0, 100%);width:32em;max-width:100%;padding:0 0 1.25em;border:none;border-radius:5px;background:#fff;color:#545454;font-family:inherit;font-size:1rem}div:where(.swal2-container) div:where(.swal2-popup):focus{outline:none}div:where(.swal2-container) div:where(.swal2-popup).swal2-loading{overflow-y:hidden}div:where(.swal2-container) h2:where(.swal2-title){position:relative;max-width:100%;margin:0;padding:.8em 1em 0;color:inherit;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}div:where(.swal2-container) div:where(.swal2-actions){display:flex;z-index:1;box-sizing:border-box;flex-wrap:wrap;align-items:center;justify-content:center;width:auto;margin:1.25em auto 0;padding:0}div:where(.swal2-container) div:where(.swal2-actions):not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}div:where(.swal2-container) div:where(.swal2-actions):not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1))}div:where(.swal2-container) div:where(.swal2-actions):not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2))}div:where(.swal2-container) div:where(.swal2-loader){display:none;align-items:center;justify-content:center;width:2.2em;height:2.2em;margin:0 1.875em;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border-width:.25em;border-style:solid;border-radius:100%;border-color:#2778c4 rgba(0,0,0,0) #2778c4 rgba(0,0,0,0)}div:where(.swal2-container) button:where(.swal2-styled){margin:.3125em;padding:.625em 1.1em;transition:box-shadow .1s;box-shadow:0 0 0 3px rgba(0,0,0,0);font-weight:500}div:where(.swal2-container) button:where(.swal2-styled):not([disabled]){cursor:pointer}div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#7066e0;color:#fff;font-size:1em}div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm:focus{box-shadow:0 0 0 3px rgba(112,102,224,.5)}div:where(.swal2-container) button:where(.swal2-styled).swal2-deny{border:0;border-radius:.25em;background:initial;background-color:#dc3741;color:#fff;font-size:1em}div:where(.swal2-container) button:where(.swal2-styled).swal2-deny:focus{box-shadow:0 0 0 3px rgba(220,55,65,.5)}div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#6e7881;color:#fff;font-size:1em}div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel:focus{box-shadow:0 0 0 3px rgba(110,120,129,.5)}div:where(.swal2-container) button:where(.swal2-styled).swal2-default-outline:focus{box-shadow:0 0 0 3px rgba(100,150,200,.5)}div:where(.swal2-container) button:where(.swal2-styled):focus{outline:none}div:where(.swal2-container) button:where(.swal2-styled)::-moz-focus-inner{border:0}div:where(.swal2-container) div:where(.swal2-footer){justify-content:center;margin:1em 0 0;padding:1em 1em 0;border-top:1px solid #eee;color:inherit;font-size:1em}div:where(.swal2-container) .swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;grid-column:auto !important;overflow:hidden;border-bottom-right-radius:5px;border-bottom-left-radius:5px}div:where(.swal2-container) div:where(.swal2-timer-progress-bar){width:100%;height:.25em;background:rgba(0,0,0,.2)}div:where(.swal2-container) img:where(.swal2-image){max-width:100%;margin:2em auto 1em}div:where(.swal2-container) button:where(.swal2-close){z-index:2;align-items:center;justify-content:center;width:1.2em;height:1.2em;margin-top:0;margin-right:0;margin-bottom:-1.2em;padding:0;overflow:hidden;transition:color .1s,box-shadow .1s;border:none;border-radius:5px;background:rgba(0,0,0,0);color:#ccc;font-family:monospace;font-size:2.5em;cursor:pointer;justify-self:end}div:where(.swal2-container) button:where(.swal2-close):hover{transform:none;background:rgba(0,0,0,0);color:#f27474}div:where(.swal2-container) button:where(.swal2-close):focus{outline:none;box-shadow:inset 0 0 0 3px rgba(100,150,200,.5)}div:where(.swal2-container) button:where(.swal2-close)::-moz-focus-inner{border:0}div:where(.swal2-container) .swal2-html-container{z-index:1;justify-content:center;margin:1em 1.6em .3em;padding:0;overflow:auto;color:inherit;font-size:1.125em;font-weight:normal;line-height:normal;text-align:center;word-wrap:break-word;word-break:break-word}div:where(.swal2-container) input:where(.swal2-input),div:where(.swal2-container) input:where(.swal2-file),div:where(.swal2-container) textarea:where(.swal2-textarea),div:where(.swal2-container) select:where(.swal2-select),div:where(.swal2-container) div:where(.swal2-radio),div:where(.swal2-container) label:where(.swal2-checkbox){margin:1em 2em 3px}div:where(.swal2-container) input:where(.swal2-input),div:where(.swal2-container) input:where(.swal2-file),div:where(.swal2-container) textarea:where(.swal2-textarea){box-sizing:border-box;width:auto;transition:border-color .1s,box-shadow .1s;border:1px solid #d9d9d9;border-radius:.1875em;background:rgba(0,0,0,0);box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px rgba(0,0,0,0);color:inherit;font-size:1.125em}div:where(.swal2-container) input:where(.swal2-input).swal2-inputerror,div:where(.swal2-container) input:where(.swal2-file).swal2-inputerror,div:where(.swal2-container) textarea:where(.swal2-textarea).swal2-inputerror{border-color:#f27474 !important;box-shadow:0 0 2px #f27474 !important}div:where(.swal2-container) input:where(.swal2-input):focus,div:where(.swal2-container) input:where(.swal2-file):focus,div:where(.swal2-container) textarea:where(.swal2-textarea):focus{border:1px solid #b4dbed;outline:none;box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px rgba(100,150,200,.5)}div:where(.swal2-container) input:where(.swal2-input)::placeholder,div:where(.swal2-container) input:where(.swal2-file)::placeholder,div:where(.swal2-container) textarea:where(.swal2-textarea)::placeholder{color:#ccc}div:where(.swal2-container) .swal2-range{margin:1em 2em 3px;background:#fff}div:where(.swal2-container) .swal2-range input{width:80%}div:where(.swal2-container) .swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}div:where(.swal2-container) .swal2-range input,div:where(.swal2-container) .swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}div:where(.swal2-container) .swal2-input{height:2.625em;padding:0 .75em}div:where(.swal2-container) .swal2-file{width:75%;margin-right:auto;margin-left:auto;background:rgba(0,0,0,0);font-size:1.125em}div:where(.swal2-container) .swal2-textarea{height:6.75em;padding:.75em}div:where(.swal2-container) .swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:rgba(0,0,0,0);color:inherit;font-size:1.125em}div:where(.swal2-container) .swal2-radio,div:where(.swal2-container) .swal2-checkbox{align-items:center;justify-content:center;background:#fff;color:inherit}div:where(.swal2-container) .swal2-radio label,div:where(.swal2-container) .swal2-checkbox label{margin:0 .6em;font-size:1.125em}div:where(.swal2-container) .swal2-radio input,div:where(.swal2-container) .swal2-checkbox input{flex-shrink:0;margin:0 .4em}div:where(.swal2-container) label:where(.swal2-input-label){display:flex;justify-content:center;margin:1em auto 0}div:where(.swal2-container) div:where(.swal2-validation-message){align-items:center;justify-content:center;margin:1em 0 0;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}div:where(.swal2-container) div:where(.swal2-validation-message)::before{content:"!";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}div:where(.swal2-container) .swal2-progress-steps{flex-wrap:wrap;align-items:center;max-width:100%;margin:1.25em auto;padding:0;background:rgba(0,0,0,0);font-weight:600}div:where(.swal2-container) .swal2-progress-steps li{display:inline-block;position:relative}div:where(.swal2-container) .swal2-progress-steps .swal2-progress-step{z-index:20;flex-shrink:0;width:2em;height:2em;border-radius:2em;background:#2778c4;color:#fff;line-height:2em;text-align:center}div:where(.swal2-container) .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#2778c4}div:where(.swal2-container) .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}div:where(.swal2-container) .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}div:where(.swal2-container) .swal2-progress-steps .swal2-progress-step-line{z-index:10;flex-shrink:0;width:2.5em;height:.4em;margin:0 -1px;background:#2778c4}div:where(.swal2-icon){position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:2.5em auto .6em;border:0.25em solid rgba(0,0,0,0);border-radius:50%;border-color:#000;font-family:inherit;line-height:5em;cursor:default;user-select:none}div:where(.swal2-icon) .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}div:where(.swal2-icon).swal2-error{border-color:#f27474;color:#f27474}div:where(.swal2-icon).swal2-error .swal2-x-mark{position:relative;flex-grow:1}div:where(.swal2-icon).swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}div:where(.swal2-icon).swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}div:where(.swal2-icon).swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}div:where(.swal2-icon).swal2-error.swal2-icon-show{animation:swal2-animate-error-icon .5s}div:where(.swal2-icon).swal2-error.swal2-icon-show .swal2-x-mark{animation:swal2-animate-error-x-mark .5s}div:where(.swal2-icon).swal2-warning{border-color:#facea8;color:#f8bb86}div:where(.swal2-icon).swal2-warning.swal2-icon-show{animation:swal2-animate-error-icon .5s}div:where(.swal2-icon).swal2-warning.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .5s}div:where(.swal2-icon).swal2-info{border-color:#9de0f6;color:#3fc3ee}div:where(.swal2-icon).swal2-info.swal2-icon-show{animation:swal2-animate-error-icon .5s}div:where(.swal2-icon).swal2-info.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .8s}div:where(.swal2-icon).swal2-question{border-color:#c9dae1;color:#87adbd}div:where(.swal2-icon).swal2-question.swal2-icon-show{animation:swal2-animate-error-icon .5s}div:where(.swal2-icon).swal2-question.swal2-icon-show .swal2-icon-content{animation:swal2-animate-question-mark .8s}div:where(.swal2-icon).swal2-success{border-color:#a5dc86;color:#a5dc86}div:where(.swal2-icon).swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}div:where(.swal2-icon).swal2-success [class^=swal2-success-circular-line][class$=left]{top:-0.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}div:where(.swal2-icon).swal2-success [class^=swal2-success-circular-line][class$=right]{top:-0.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}div:where(.swal2-icon).swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-0.25em;left:-0.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}div:where(.swal2-icon).swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}div:where(.swal2-icon).swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}div:where(.swal2-icon).swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}div:where(.swal2-icon).swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}div:where(.swal2-icon).swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-animate-success-line-tip .75s}div:where(.swal2-icon).swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-animate-success-line-long .75s}div:where(.swal2-icon).swal2-success.swal2-icon-show .swal2-success-circular-line-right{animation:swal2-rotate-success-circular-line 4.25s ease-in}[class^=swal2]{-webkit-tap-highlight-color:rgba(0,0,0,0)}.swal2-show{animation:swal2-show .3s}.swal2-hide{animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{margin-right:initial;margin-left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@keyframes swal2-toast-show{0%{transform:translateY(-0.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(0.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0deg)}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-0.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-show{0%{transform:scale(0.7)}45%{transform:scale(1.05)}80%{transform:scale(0.95)}100%{transform:scale(1)}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(0.5);opacity:0}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-0.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(0.4);opacity:0}50%{margin-top:1.625em;transform:scale(0.4);opacity:0}80%{margin-top:-0.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0deg);opacity:1}}@keyframes swal2-rotate-loading{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}@keyframes swal2-animate-question-mark{0%{transform:rotateY(-360deg)}100%{transform:rotateY(0)}}@keyframes swal2-animate-i-mark{0%{transform:rotateZ(45deg);opacity:0}25%{transform:rotateZ(-25deg);opacity:.4}50%{transform:rotateZ(15deg);opacity:.8}75%{transform:rotateZ(-5deg);opacity:1}100%{transform:rotateX(0);opacity:1}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto !important}body.swal2-no-backdrop .swal2-container{background-color:rgba(0,0,0,0) !important;pointer-events:none}body.swal2-no-backdrop .swal2-container .swal2-popup{pointer-events:all}body.swal2-no-backdrop .swal2-container .swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll !important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static !important}}body.swal2-toast-shown .swal2-container{box-sizing:border-box;width:360px;max-width:100%;background-color:rgba(0,0,0,0);pointer-events:none}body.swal2-toast-shown .swal2-container.swal2-top{inset:0 auto auto 50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{inset:0 0 auto auto}body.swal2-toast-shown .swal2-container.swal2-top-start,body.swal2-toast-shown .swal2-container.swal2-top-left{inset:0 auto auto 0}body.swal2-toast-shown .swal2-container.swal2-center-start,body.swal2-toast-shown .swal2-container.swal2-center-left{inset:50% auto auto 0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{inset:50% auto auto 50%;transform:translate(-50%, -50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{inset:50% 0 auto auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-start,body.swal2-toast-shown .swal2-container.swal2-bottom-left{inset:auto auto 0 0}body.swal2-toast-shown .swal2-container.swal2-bottom{inset:auto auto 0 50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{inset:auto 0 0 auto}'
            );
})(ji);
var gh = ji.exports;
const wh = mh(gh);
window.Popper = us;
window.bootstrap = ph;
window.Swal = wh;
window.focused = function (o) {
    o.parentElement.classList.contains("input-group") &&
        o.parentElement.classList.add("focused");
};
window.defocused = function (o) {
    o.parentElement.classList.contains("input-group") &&
        o.parentElement.classList.remove("focused");
};
if (document.querySelectorAll(".input-group").length != 0) {
    var bh = document.querySelectorAll("input.form-control");
    bh.forEach((o) =>
        setAttributes(o, {
            onfocus: "focused(this)",
            onfocusout: "defocused(this)",
        })
    );
}

const ms = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-primary mx-1",
            cancelButton: "btn btn-light mx-1",
        },
        buttonsStyling: !1,
        reverseButtons: !0,
    }),
    vh = ms.mixin({
        icon: "warning",
        customClass: {
            confirmButton: "btn btn-primary mx-1",
            cancelButton: "btn btn-light mx-1",
        },
        showCancelButton: !0,
        confirmButtonText: "Ya, lanjutkan",
        cancelButtonText: "Batal",
        buttonsStyling: !1,
        reverseButtons: !0,
        showLoaderOnConfirm: !0,
    }),
    yh = ms.mixin({
        icon: "success",
        toast: !0,
        position: "top-end",
        showConfirmButton: !1,
        timer: 1500,
    }),
    Eh = ms.mixin({
        icon: "error",
        toast: !0,
        position: "top-end",
        showConfirmButton: !1,
        timer: 1500,
    });
window.Question = vh;
window.Success = yh;
window.Failed = Eh;
