var umdHeader = umdHeader || {};
umdHeader.jQuery = {};
umdHeader.init = function(b) {
    var f, e, d, c;
    e = "//s3.amazonaws.com/umdheader.umd.edu/app";
    d = 200;
    c = [{
        title: "About",
        href: "#",
        children: [{
            title: "Office of the President",
            href: "http://www.president.umd.edu"
        }, {
            title: "Office of the Provost",
            href: "http://www.provost.umd.edu"
        }, {
            title: "Vice Presidents",
            href: "http://www.president.umd.edu/vicepresidents.cfm"
        }, {
            title: "Administrative Departments and Campus Services",
            href: "http://www.umd.edu/admin_dir.cfm"
        }, {
            title: "Research Centers, Institutes, Laboratories, &amp; Bureaus",
            href: "http://www.umd.edu/directories/centers.cfm"
        }, {
            title: "Alumni Hall of Fame",
            href: "http://alumni.umd.edu/s/1132/index.aspx?sid=1132&amp;gid=1&amp;pgid=830"
        }, {
            title: "Maryland Traditions",
            href: "http://www.umd.edu/traditions"
        }, {
            title: "Mission Statement",
            href: "http://www.provost.umd.edu/Strategic_Planning/PlanAndMission.html"
        }, {
            title: "Official Documents",
            href: "http://www.inform.umd.edu/CampusInfo/Reports/"
        }, {
            title: "Past Presidents",
            href: "http://www.president.umd.edu/pastpres/"
        }, {
            title: "Strategic Plan",
            href: "http://www.umd.edu/strat_plan/index.cfm"
        }, {
            title: "Timeline",
            href: "http://www.urhome.umd.edu/timeline/"
        }, {
            title: "University Archives",
            href: "http://www.lib.umd.edu/univarchives"
        }, {
            title: "Faculty Awards",
            href: "http://www.faculty.umd.edu/FacAwards/"
        }, {
            title: "Faculty and Staff Convocation Awards",
            href: "http://www.umd.edu/university/awards.cfm"
        }, {
            title: "Nobel Laureates at UM",
            href: "http://www.umd.edu/university/nobelum.cfm"
        }, {
            title: "Maryland Moments",
            href: "http://www.umdrightnow.umd.edu/about-university-maryland"
        }, {
            title: "University Rankings",
            href: "http://www.umdrightnow.umd.edu/about-university-maryland"
        }, {
            title: "HEOA/Consumer Info",
            href: "http://www.umd.edu/whatyouneedtoknow/"
        }, {
            title: "Maryland Public Information Act Requests",
            href: "http://www.president.umd.edu/legal/pia.html"
        }, {
            title: "University of Maryland Campus Counts",
            href: "https://www.irpa.umd.edu/menus.cfm?action=campuscounts"
        }]
    }, {
        title: "Academics",
        href: "#",
        children: [{
            title: "Colleges and Schools",
            href: "http://www.umd.edu/directories/colleges.cfm"
        }, {
            title: "Academic Departments and Programs",
            href: "http://www.umd.edu/acad_dir.cfm"
        }, {
            title: "Centers and Institutes",
            href: "http://www.umd.edu/directories/centers.cfm"
        }, {
            title: "Majors at Maryland",
            href: "http://www.admissions.umd.edu/academics/majors.cfm"
        }, {
            title: "Main UMD Calendars",
            href: "http://www.umd.edu/calendars/"
        }, {
            title: "Certificate Programs",
            href: "http://www.admissions.umd.edu/academics/certificateprograms.cfm"
        }, {
            title: "Special Academic Programs",
            href: "http://www.admissions.umd.edu/academics/specprograms.cfm"
        }, {
            title: "Living Learning Programs",
            href: "http://www.resnet.umd.edu/acadhall.html"
        }, {
            title: "Office of the Provost",
            href: "http://www.provost.umd.edu"
        }, {
            title: "Graduate School",
            href: "http://www.gradschool.umd.edu/"
        }, {
            title: "Office of Undergraduate Studies",
            href: "http://www.ugst.umd.edu/"
        }]
    }, {
        title: "Fearless Ideas",
        href: "http://giving.umd.edu"
    }];
    if (window.jQuery) {
        (function() {
            var h;
            h = window.jQuery.fn.jquery.split(".");
            if (parseInt(h[0]) >= 1 && parseInt(h[1]) >= 8) {
                f = umdHeader.jQuery = window.jQuery;
                g()
            } else {
                a()
            }
        }())
    } else {
        a()
    }

    function a() {
        var h, i;
        i = "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js";
        h = document.createElement("script");
        h.onload = function() {
            f = umdHeader.jQuery = jQuery.noConflict(true);
            g()
        };
        h.src = i;
        document.getElementsByTagName("head")[0].appendChild(h)
    }

    function g() {
        f(function() {
            var h, m, k, n, i, l, j;
            m = {
                news: true,
                ready: []
            };
            l = f.extend({}, m, b);
            h = f("body");
            j = f('<div id="umh-cont"><div id="umh-main"><div id="umh-search-cont"><form method="get" action="http://www.searchum.umd.edu/search"><input type="hidden" name="site" value="UMCP"/><input type="hidden" name="client" value="UMCP"/><input type="hidden" name="proxystylesheet" value="UMCP"/><input type="hidden" name="output" value="xml_no_dtd"/><input type="hidden" name="as_oq" value="site:" /><input type="text" name="q" size="15" title="Search UM" id="umh-search-text" /><button type="submit" value="Search" id="umh-search-submit" /></form></div><div id="umh-menu-cont"><ul id="umh-menu"><li class="umh-home"><a href="http://www.umd.edu" target="_blank">Home</a></li><li id="umh-menu-links"><a href="#" id="umh-menu-links-toggle">Toggle</a><ul id="umh-menu-links-list"></ul></li></ul></div></div><div id="umh-toggle-cont"><a href="#" id="umh-toggle-bar"><span id="umh-toggle-logo"><img src="' + e + '/images/umd-bar-logo.png" /></span></a><a href="#" id="umh-toggle-arrow"></a></div></div>');
            k = f("#umh-main", j);
            i = f("#umh-toggle-bar, #umh-toggle-arrow", j);
            i.click(function() {
                function o(r) {
                    var q, p, s;
                    if (!k.is(":visible")) {
                        return false
                    }
                    s = k.height();
                    if (f("#umh-submenu-cont").css("display") == "block") {
                        s -= f("#umh-submenu-cont").height()
                    }
                    switch (r) {
                        case "add":
                            p = "+=";
                            q = "removeClass";
                            break;
                        case "subtract":
                            p = "-=";
                            q = "addClass";
                            break;
                        default:
                            return false;
                            break
                    }
                    h.css("paddingTop", p + s);
                    j[q]("collapsed");
                    f(window).trigger("umdHeader.bodyPadding", {
                        operator: p
                    })
                }
                o("subtract");
                k.animate({
                    height: "toggle"
                }, d, function() {
                    o("add")
                });
                return false
            });
            (function() {
                var o, p, s, t, u, v, q, r, w;
                o = f("#umh-menu-cont", j);
                p = f("#umh-menu", o);
                s = f("#umh-menu-links", o);
                t = f("#umh-menu-links-list", o);
                u = f("#umh-menu-links-toggle", o);
                v = "active";
                q = f('<div id="umh-submenu-cont"></div>').appendTo(o);
                r = "umh-has-submenu";
                w = f();
                (function() {
                    var z, A, y;
                    z = f("<ul/>");
                    A = f("<li/>");
                    y = f("<a/>", {
                        target: "_blank"
                    });

                    function x(C) {
                        var B;
                        B = f();
                        f.each(C, function(E, H) {
                            var F, I, D, G;
                            if (typeof H === "undefined" || !H.hasOwnProperty("title") || !H.hasOwnProperty("href")) {
                                return false
                            }
                            D = A.clone();
                            G = y.clone().attr("href", H.href).html(H.title).prependTo(D);
                            if (H.hasOwnProperty("children") && f.isArray(H.children) && H.children.length > 0) {
                                F = z.clone();
                                F.append(x(H.children));
                                if (F.children().length > 0) {
                                    I = F.clone();
                                    D.addClass(r);
                                    w = w.add(G);
                                    G.data("submenus", F.add(I));
                                    I.hide().appendTo(q);
                                    D.append(F)
                                }
                            }
                            B = B.add(D)
                        });
                        return B
                    }
                    t.append(x(c))
                }());
                w.click(function() {
                    var z, C, x, A, D;

                    function B(F, E, G) {
                        G = G || f.noop;
                        E.toggleClass(v);
                        F.animate({
                            height: "toggle"
                        }, d).promise().done(G)
                    }

                    function y() {
                        if (t.children(".active").length > 0) {
                            s.addClass(v);
                            t.css({
                                display: "inline-block"
                            })
                        } else {
                            s.removeClass(v);
                            t.css({
                                display: ""
                            })
                        }
                    }
                    z = f(this);
                    C = z.parent();
                    x = z.data("submenus");
                    A = C.siblings("." + v);
                    if (A.length > 0) {
                        B(A.children("a").data("submenus"), A, function() {
                            B(x, C, y)
                        })
                    } else {
                        B(x, C, y)
                    }
                    return false
                });
                u.click(function() {
                    if (s.hasClass(v)) {
                        t.animate({
                            width: "toggle"
                        }, d, function() {
                            s.removeClass(v);
                            t.css({
                                display: ""
                            })
                        })
                    } else {
                        s.addClass(v);
                        t.animate({
                            width: "toggle"
                        }, d)
                    }
                    return false
                })
            }());
            (function() {
                var t = f("#umh-search-cont", j),
                    q = f("#umh-search-text", j),
                    o = f("#umh-search-submit", j),
                    r = "Search UMD.edu";

                function p() {
                    var u = q.val();
                    if (u === "") {
                        q.val(r)
                    } else {
                        if (u === r) {
                            q.val("")
                        }
                    }
                }

                function s() {
                    q.css({
                        display: "",
                        height: ""
                    })
                }
                q.attr("value", r).focus(p).blur(function() {
                    q.val(q.val().trim());
                    p();
                    if (q.css("position") === "absolute") {
                        q.animate({
                            height: "hide"
                        }, d, s)
                    } else {
                        s()
                    }
                });
                o.click(function(u) {
                    if (q.css("position") === "absolute" && q.is(":hidden")) {
                        q.animate({
                            height: "show"
                        }, d).focus();
                        return false
                    }
                    if (f.inArray(q.val(), [r, ""]) > -1) {
                        q.stop(true).animate({
                            height: "show"
                        }, 0).focus();
                        return false
                    }
                })
            }());
            (function() {
                var p = "//umd.edu/umdheader/news.php",
                    o = "render";
                j.addClass("umh-no-news");
                if (l.news != true) {
                    return
                }
                j.removeClass("umh-no-news").addClass("umh-news");
                f.ajax({
                    dataType: "jsonp",
                    url: p,
                    jsonpCallback: o,
                    success: function(v) {
                        var q, w, r, x, u, t, s;
                        q = f('<div id="umh-news-cont"></div>');
                        w = f('<div id="umh-news-items"></div>');
                        r = f('<div id="umh-news-pager-cont"></div>');
                        x = f('<div id="umh-news-title">Latest News</div>');
                        u = f('<a href="#" id="umh-news-pager-prev" class="umh-news-pager-link"></a>');
                        t = f('<a href="#" id="umh-news-pager-next" class="umh-news-pager-link"></a>');
                        s = u.add(t);
                        s.click(function() {
                            var A, C, z, y, B;
                            C = w.children("a");
                            z = C.filter(":visible");
                            if (typeof z !== "object" || z.length !== 1) {
                                return false
                            }
                            y = z.index();
                            A = f(this);
                            z.fadeOut(d, function() {
                                var D;
                                switch (A.attr("id")) {
                                    case "umh-news-pager-prev":
                                        if (y === 0) {
                                            B = C.length - 1
                                        } else {
                                            B = y - 1
                                        }
                                        break;
                                    case "umh-news-pager-next":
                                        if (y === C.length - 1) {
                                            B = 0
                                        } else {
                                            B = y + 1
                                        }
                                        break;
                                    default:
                                        return false;
                                        break
                                }
                                C.eq(B).fadeIn(d)
                            });
                            return false
                        });
                        r.append(s);
                        w.append(v).children().hide().first().css("display", "block");
                        q.append(x, r, w).prependTo(k)
                    }
                })
            }());
            f('<link type="text/css" rel="stylesheet">').appendTo(f("head")).load(function() {
                h.prepend(j).css("paddingTop", "+=" + j.height());
                if (f.isArray(l.ready)) {
                    f.each(l.ready, function() {
                        this()
                    })
                }
            }).attr("href", e + "/css/main.css")
        })
    }
};