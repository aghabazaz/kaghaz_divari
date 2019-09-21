if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");
+function(t){
    "use strict";
    var e=t.fn.jquery.split(" ")[0].split(".");
    if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")
}(jQuery),+function(t){
    "use strict";
    function e(){
        var t=document.createElement("bootstrap"),e={
            WebkitTransition:"webkitTransitionEnd",
            MozTransition:"transitionend",
            OTransition:"oTransitionEnd otransitionend",
            transition:"transitionend"
        };
        
        for(var i in e)if(void 0!==t.style[i])return{
            end:e[i]
        };
        return!1
    }
    t.fn.emulateTransitionEnd=function(e){
        var i=!1,o=this;
        t(this).one("bsTransitionEnd",function(){
            i=!0
        });
        var n=function(){
            i||t(o).trigger(t.support.transition.end)
        };
            
        return setTimeout(n,e),this
    },t(function(){
        t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={
            bindType:t.support.transition.end,
            delegateType:t.support.transition.end,
            handle:function(e){
                return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0
            }
        })
    })
}(jQuery),+function(t){
    "use strict";
    function e(e){
        return this.each(function(){
            var i=t(this),n=i.data("bs.alert");
            n||i.data("bs.alert",n=new o(this)),"string"==typeof e&&n[e].call(i)
        })
    }
    var i='[data-dismiss="alert"]',o=function(e){
        t(e).on("click",i,this.close)
    };
        
    o.VERSION="3.3.5",o.TRANSITION_DURATION=150,o.prototype.close=function(e){
        function i(){
            a.detach().trigger("closed.bs.alert").remove()
        }
        var n=t(this),s=n.attr("data-target");
        s||(s=n.attr("href"),s=s&&s.replace(/.*(?=#[^\s]*$)/,""));
        var a=t(s);
        e&&e.preventDefault(),a.length||(a=n.closest(".alert")),a.trigger(e=t.Event("close.bs.alert")),e.isDefaultPrevented()||(a.removeClass("in"),t.support.transition&&a.hasClass("fade")?a.one("bsTransitionEnd",i).emulateTransitionEnd(o.TRANSITION_DURATION):i())
    };
        
    var n=t.fn.alert;
    t.fn.alert=e,t.fn.alert.Constructor=o,t.fn.alert.noConflict=function(){
        return t.fn.alert=n,this
    },t(document).on("click.bs.alert.data-api",i,o.prototype.close)
}(jQuery),+function(t){
    "use strict";
    function e(e){
        return this.each(function(){
            var o=t(this),n=o.data("bs.button"),s="object"==typeof e&&e;
            n||o.data("bs.button",n=new i(this,s)),"toggle"==e?n.toggle():e&&n.setState(e)
        })
    }
    var i=function(e,o){
        this.$element=t(e),this.options=t.extend({},i.DEFAULTS,o),this.isLoading=!1
    };
        
    i.VERSION="3.3.5",i.DEFAULTS={
        loadingText:"loading..."
    },i.prototype.setState=function(e){
        var i="disabled",o=this.$element,n=o.is("input")?"val":"html",s=o.data();
        e+="Text",null==s.resetText&&o.data("resetText",o[n]()),setTimeout(t.proxy(function(){
            o[n](null==s[e]?this.options[e]:s[e]),"loadingText"==e?(this.isLoading=!0,o.addClass(i).attr(i,i)):this.isLoading&&(this.isLoading=!1,o.removeClass(i).removeAttr(i))
        },this),0)
    },i.prototype.toggle=function(){
        var t=!0,e=this.$element.closest('[data-toggle="buttons"]');
        if(e.length){
            var i=this.$element.find("input");
            "radio"==i.prop("type")?(i.prop("checked")&&(t=!1),e.find(".active").removeClass("active"),this.$element.addClass("active")):"checkbox"==i.prop("type")&&(i.prop("checked")!==this.$element.hasClass("active")&&(t=!1),this.$element.toggleClass("active")),i.prop("checked",this.$element.hasClass("active")),t&&i.trigger("change")
        }else this.$element.attr("aria-pressed",!this.$element.hasClass("active")),this.$element.toggleClass("active")
    };
            
    var o=t.fn.button;
    t.fn.button=e,t.fn.button.Constructor=i,t.fn.button.noConflict=function(){
        return t.fn.button=o,this
    },t(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(i){
        var o=t(i.target);
        o.hasClass("btn")||(o=o.closest(".btn")),e.call(o,"toggle"),t(i.target).is('input[type="radio"]')||t(i.target).is('input[type="checkbox"]')||i.preventDefault()
    }).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(e){
        t(e.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(e.type))
    })
}(jQuery),+function(t){
    "use strict";
    function e(e){
        return this.each(function(){
            var o=t(this),n=o.data("bs.carousel"),s=t.extend({},i.DEFAULTS,o.data(),"object"==typeof e&&e),a="string"==typeof e?e:s.slide;
            n||o.data("bs.carousel",n=new i(this,s)),"number"==typeof e?n.to(e):a?n[a]():s.interval&&n.pause().cycle()
        })
    }
    var i=function(e,i){
        this.$element=t(e),this.$indicators=this.$element.find(".carousel-indicators"),this.options=i,this.paused=null,this.sliding=null,this.interval=null,this.$active=null,this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",t.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",t.proxy(this.pause,this)).on("mouseleave.bs.carousel",t.proxy(this.cycle,this))
    };
        
    i.VERSION="3.3.5",i.TRANSITION_DURATION=600,i.DEFAULTS={
        interval:5e3,
        pause:"hover",
        wrap:!0,
        keyboard:!0
    },i.prototype.keydown=function(t){
        if(!/input|textarea/i.test(t.target.tagName)){
            switch(t.which){
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            t.preventDefault()
        }
    },i.prototype.cycle=function(e){
        return e||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(t.proxy(this.next,this),this.options.interval)),this
    },i.prototype.getItemIndex=function(t){
        return this.$items=t.parent().children(".item"),this.$items.index(t||this.$active)
    },i.prototype.getItemForDirection=function(t,e){
        var i=this.getItemIndex(e),o="prev"==t&&0===i||"next"==t&&i==this.$items.length-1;
        if(o&&!this.options.wrap)return e;
        var n="prev"==t?-1:1,s=(i+n)%this.$items.length;
        return this.$items.eq(s)
    },i.prototype.to=function(t){
        var e=this,i=this.getItemIndex(this.$active=this.$element.find(".item.active"));
        return t>this.$items.length-1||0>t?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){
            e.to(t)
        }):i==t?this.pause().cycle():this.slide(t>i?"next":"prev",this.$items.eq(t))
    },i.prototype.pause=function(e){
        return e||(this.paused=!0),this.$element.find(".next, .prev").length&&t.support.transition&&(this.$element.trigger(t.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this
    },i.prototype.next=function(){
        return this.sliding?void 0:this.slide("next")
    },i.prototype.prev=function(){
        return this.sliding?void 0:this.slide("prev")
    },i.prototype.slide=function(e,o){
        var n=this.$element.find(".item.active"),s=o||this.getItemForDirection(e,n),a=this.interval,r="next"==e?"left":"right",l=this;
        if(s.hasClass("active"))return this.sliding=!1;
        var h=s[0],d=t.Event("slide.bs.carousel",{
            relatedTarget:h,
            direction:r
        });
        if(this.$element.trigger(d),!d.isDefaultPrevented()){
            if(this.sliding=!0,a&&this.pause(),this.$indicators.length){
                this.$indicators.find(".active").removeClass("active");
                var p=t(this.$indicators.children()[this.getItemIndex(s)]);
                p&&p.addClass("active")
            }
            var c=t.Event("slid.bs.carousel",{
                relatedTarget:h,
                direction:r
            });
            return t.support.transition&&this.$element.hasClass("slide")?(s.addClass(e),s[0].offsetWidth,n.addClass(r),s.addClass(r),n.one("bsTransitionEnd",function(){
                s.removeClass([e,r].join(" ")).addClass("active"),n.removeClass(["active",r].join(" ")),l.sliding=!1,setTimeout(function(){
                    l.$element.trigger(c)
                },0)
            }).emulateTransitionEnd(i.TRANSITION_DURATION)):(n.removeClass("active"),s.addClass("active"),this.sliding=!1,this.$element.trigger(c)),a&&this.cycle(),this
        }
    };

    var o=t.fn.carousel;
    t.fn.carousel=e,t.fn.carousel.Constructor=i,t.fn.carousel.noConflict=function(){
        return t.fn.carousel=o,this
    };
    
    var n=function(i){
        var o,n=t(this),s=t(n.attr("data-target")||(o=n.attr("href"))&&o.replace(/.*(?=#[^\s]+$)/,""));
        if(s.hasClass("carousel")){
            var a=t.extend({},s.data(),n.data()),r=n.attr("data-slide-to");
            r&&(a.interval=!1),e.call(s,a),r&&s.data("bs.carousel").to(r),i.preventDefault()
        }
    };

    t(document).on("click.bs.carousel.data-api","[data-slide]",n).on("click.bs.carousel.data-api","[data-slide-to]",n),t(window).on("load",function(){
        t('[data-ride="carousel"]').each(function(){
            var i=t(this);
            e.call(i,i.data())
        })
    })
}(jQuery),+function(t){
    "use strict";
    function e(e){
        var i,o=e.attr("data-target")||(i=e.attr("href"))&&i.replace(/.*(?=#[^\s]+$)/,"");
        return t(o)
    }
    function i(e){
        return this.each(function(){
            var i=t(this),n=i.data("bs.collapse"),s=t.extend({},o.DEFAULTS,i.data(),"object"==typeof e&&e);
            !n&&s.toggle&&/show|hide/.test(e)&&(s.toggle=!1),n||i.data("bs.collapse",n=new o(this,s)),"string"==typeof e&&n[e]()
        })
    }
    var o=function(e,i){
        this.$element=t(e),this.options=t.extend({},o.DEFAULTS,i),this.$trigger=t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()
    };
        
    o.VERSION="3.3.5",o.TRANSITION_DURATION=350,o.DEFAULTS={
        toggle:!0
    },o.prototype.dimension=function(){
        var t=this.$element.hasClass("width");
        return t?"width":"height"
    },o.prototype.show=function(){
        if(!this.transitioning&&!this.$element.hasClass("in")){
            var e,n=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");
            if(!(n&&n.length&&(e=n.data("bs.collapse"),e&&e.transitioning))){
                var s=t.Event("show.bs.collapse");
                if(this.$element.trigger(s),!s.isDefaultPrevented()){
                    n&&n.length&&(i.call(n,"hide"),e||n.data("bs.collapse",null));
                    var a=this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[a](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;
                    var r=function(){
                        this.$element.removeClass("collapsing").addClass("collapse in")[a](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")
                    };
                        
                    if(!t.support.transition)return r.call(this);
                    var l=t.camelCase(["scroll",a].join("-"));
                    this.$element.one("bsTransitionEnd",t.proxy(r,this)).emulateTransitionEnd(o.TRANSITION_DURATION)[a](this.$element[0][l])
                }
            }
        }
    },o.prototype.hide=function(){
        if(!this.transitioning&&this.$element.hasClass("in")){
            var e=t.Event("hide.bs.collapse");
            if(this.$element.trigger(e),!e.isDefaultPrevented()){
                var i=this.dimension();
                this.$element[i](this.$element[i]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;
                var n=function(){
                    this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                };
                
                return t.support.transition?void this.$element[i](0).one("bsTransitionEnd",t.proxy(n,this)).emulateTransitionEnd(o.TRANSITION_DURATION):n.call(this)
            }
        }
    },o.prototype.toggle=function(){
        this[this.$element.hasClass("in")?"hide":"show"]()
    },o.prototype.getParent=function(){
        return t(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(i,o){
            var n=t(o);
            this.addAriaAndCollapsedClass(e(n),n)
        },this)).end()
    },o.prototype.addAriaAndCollapsedClass=function(t,e){
        var i=t.hasClass("in");
        t.attr("aria-expanded",i),e.toggleClass("collapsed",!i).attr("aria-expanded",i)
    };
    
    var n=t.fn.collapse;
    t.fn.collapse=i,t.fn.collapse.Constructor=o,t.fn.collapse.noConflict=function(){
        return t.fn.collapse=n,this
    },t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(o){
        var n=t(this);
        n.attr("data-target")||o.preventDefault();
        var s=e(n),a=s.data("bs.collapse"),r=a?"toggle":n.data();
        i.call(s,r)
    })
}(jQuery),+function(t){
    "use strict";
    function e(e){
        var i=e.attr("data-target");
        i||(i=e.attr("href"),i=i&&/#[A-Za-z]/.test(i)&&i.replace(/.*(?=#[^\s]*$)/,""));
        var o=i&&t(i);
        return o&&o.length?o:e.parent()
    }
    function i(i){
        i&&3===i.which||(t(n).remove(),"undefined"!=typeof i&&t(i.target).parents(".mega_menu_dropdown").length>0||t(s).each(function(){
            var o=t(this),n=e(o),s={
                relatedTarget:this
            };
            
            n.hasClass("open")&&(i&&"click"==i.type&&/input|textarea/i.test(i.target.tagName)&&t.contains(n[0],i.target)||(n.trigger(i=t.Event("hide.bs.dropdown",s)),i.isDefaultPrevented()||(o.attr("aria-expanded","false"),n.removeClass("open").trigger("hidden.bs.dropdown",s))))
        }))
    }
    function o(e){
        return this.each(function(){
            var i=t(this),o=i.data("bs.dropdown");
            o||i.data("bs.dropdown",o=new a(this)),"string"==typeof e&&o[e].call(i)
        })
    }
    var n=".dropdown-backdrop",s='[data-toggle="dropdown"]',a=function(e){
        t(e).on("click.bs.dropdown",this.toggle)
    };
        
    a.VERSION="3.3.5",a.prototype.toggle=function(o){
        var n=t(this);
        if(!n.is(".disabled, :disabled")){
            var s=e(n),a=s.hasClass("open");
            if(i(),!a){
                "ontouchstart"in document.documentElement&&!s.closest(".navbar-nav").length&&t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click",i);
                var r={
                    relatedTarget:this
                };
                
                if(s.trigger(o=t.Event("show.bs.dropdown",r)),o.isDefaultPrevented())return;
                n.trigger("focus").attr("aria-expanded","true"),s.toggleClass("open").trigger("shown.bs.dropdown",r)
            }
            return!1
        }
    },a.prototype.keydown=function(i){
        if(/(38|40|27|32)/.test(i.which)&&!/input|textarea/i.test(i.target.tagName)){
            var o=t(this);
            if(i.preventDefault(),i.stopPropagation(),!o.is(".disabled, :disabled")){
                var n=e(o),a=n.hasClass("open");
                if(!a&&27!=i.which||a&&27==i.which)return 27==i.which&&n.find(s).trigger("focus"),o.trigger("click");
                var r=" li:not(.disabled):visible a",l=n.find(".dropdown-menu"+r);
                if(l.length){
                    var h=l.index(i.target);
                    38==i.which&&h>0&&h--,40==i.which&&h<l.length-1&&h++,~h||(h=0),l.eq(h).trigger("focus")
                }
            }
        }
    };

    var r=t.fn.dropdown;
    t.fn.dropdown=o,t.fn.dropdown.Constructor=a,t.fn.dropdown.noConflict=function(){
        return t.fn.dropdown=r,this
    },t(document).on("click.bs.dropdown.data-api",i).on("click.bs.dropdown.data-api",".dropdown form",function(t){
        t.stopPropagation()
    }).on("click.bs.dropdown.data-api",s,a.prototype.toggle).on("keydown.bs.dropdown.data-api",s,a.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",a.prototype.keydown)
}(jQuery),+function(t){
    "use strict";
    function e(e,o){
        return this.each(function(){
            var n=t(this),s=n.data("bs.modal"),a=t.extend({},i.DEFAULTS,n.data(),"object"==typeof e&&e);
            s||n.data("bs.modal",s=new i(this,a)),"string"==typeof e?s[e](o):a.show&&s.show(o)
        })
    }
    var i=function(e,i){
        this.options=i,this.$body=t(document.body),this.$element=t(e),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,t.proxy(function(){
            this.$element.trigger("loaded.bs.modal")
        },this))
    };
        
    i.VERSION="3.3.5",i.TRANSITION_DURATION=300,i.BACKDROP_TRANSITION_DURATION=150,i.DEFAULTS={
        backdrop:!0,
        keyboard:!0,
        show:!0
    },i.prototype.toggle=function(t){
        return this.isShown?this.hide():this.show(t)
    },i.prototype.show=function(e){
        var o=this,n=t.Event("show.bs.modal",{
            relatedTarget:e
        });
        this.$element.trigger(n),this.isShown||n.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){
            o.$element.one("mouseup.dismiss.bs.modal",function(e){
                t(e.target).is(o.$element)&&(o.ignoreBackdropClick=!0)
            })
        }),this.backdrop(function(){
            var n=t.support.transition&&o.$element.hasClass("fade");
            o.$element.parent().length||o.$element.appendTo(o.$body),o.$element.show().scrollTop(0),o.adjustDialog(),n&&o.$element[0].offsetWidth,o.$element.addClass("in"),o.enforceFocus();
            var s=t.Event("shown.bs.modal",{
                relatedTarget:e
            });
            n?o.$dialog.one("bsTransitionEnd",function(){
                o.$element.trigger("focus").trigger(s)
            }).emulateTransitionEnd(i.TRANSITION_DURATION):o.$element.trigger("focus").trigger(s)
        }))
    },i.prototype.hide=function(e){
        e&&e.preventDefault(),e=t.Event("hide.bs.modal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",t.proxy(this.hideModal,this)).emulateTransitionEnd(i.TRANSITION_DURATION):this.hideModal())
    },i.prototype.enforceFocus=function(){
        t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){
            this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.trigger("focus")
        },this))
    },i.prototype.escape=function(){
        this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",t.proxy(function(t){
            27==t.which&&this.hide()
        },this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")
    },i.prototype.resize=function(){
        this.isShown?t(window).on("resize.bs.modal",t.proxy(this.handleUpdate,this)):t(window).off("resize.bs.modal")
    },i.prototype.hideModal=function(){
        var t=this;
        this.$element.hide(),this.backdrop(function(){
            t.$body.removeClass("modal-open"),t.resetAdjustments(),t.resetScrollbar(),t.$element.trigger("hidden.bs.modal")
        })
    },i.prototype.removeBackdrop=function(){
        this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null
    },i.prototype.backdrop=function(e){
        var o=this,n=this.$element.hasClass("fade")?"fade":"";
        if(this.isShown&&this.options.backdrop){
            var s=t.support.transition&&n;
            if(this.$backdrop=t(document.createElement("div")).addClass("modal-backdrop "+n).appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",t.proxy(function(t){
                return this.ignoreBackdropClick?void(this.ignoreBackdropClick=!1):void(t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))
            },this)),s&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;
            s?this.$backdrop.one("bsTransitionEnd",e).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION):e()
        }else if(!this.isShown&&this.$backdrop){
            this.$backdrop.removeClass("in");
            var a=function(){
                o.removeBackdrop(),e&&e()
            };
                
            t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",a).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION):a()
        }else e&&e()
    },i.prototype.handleUpdate=function(){
        this.adjustDialog()
    },i.prototype.adjustDialog=function(){
        var t=this.$element[0].scrollHeight>document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft:!this.bodyIsOverflowing&&t?this.scrollbarWidth:"",
            paddingRight:this.bodyIsOverflowing&&!t?this.scrollbarWidth:""
        })
    },i.prototype.resetAdjustments=function(){
        this.$element.css({
            paddingLeft:"",
            paddingRight:""
        })
    },i.prototype.checkScrollbar=function(){
        var t=window.innerWidth;
        if(!t){
            var e=document.documentElement.getBoundingClientRect();
            t=e.right-Math.abs(e.left)
        }
        this.bodyIsOverflowing=document.body.clientWidth<t,this.scrollbarWidth=this.measureScrollbar()
    },i.prototype.setScrollbar=function(){
        var t=parseInt(this.$body.css("padding-right")||0,10);
        this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",t+this.scrollbarWidth)
    },i.prototype.resetScrollbar=function(){
        this.$body.css("padding-right",this.originalBodyPad)
    },i.prototype.measureScrollbar=function(){
        var t=document.createElement("div");
        t.className="modal-scrollbar-measure",this.$body.append(t);
        var e=t.offsetWidth-t.clientWidth;
        return this.$body[0].removeChild(t),e
    };
        
    var o=t.fn.modal;
    t.fn.modal=e,t.fn.modal.Constructor=i,t.fn.modal.noConflict=function(){
        return t.fn.modal=o,this
    },t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(i){
        var o=t(this),n=o.attr("href"),s=t(o.attr("data-target")||n&&n.replace(/.*(?=#[^\s]+$)/,"")),a=s.data("bs.modal")?"toggle":t.extend({
            remote:!/#/.test(n)&&n
        },s.data(),o.data());
        o.is("a")&&i.preventDefault(),s.one("show.bs.modal",function(t){
            t.isDefaultPrevented()||s.one("hidden.bs.modal",function(){
                o.is(":visible")&&o.trigger("focus")
            })
        }),e.call(s,a,this)
    })
}(jQuery),
    /* ========================================================================
 * Bootstrap: tooltip.js v3.1.1
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


    +function ($) {
        'use strict';

        // TOOLTIP PUBLIC CLASS DEFINITION
        // ===============================

        var Tooltip = function (element, options) {
            this.type       =
            this.options    =
            this.enabled    =
            this.timeout    =
            this.hoverState =
            this.$element   = null

            this.init('tooltip', element, options)
        }

        Tooltip.DEFAULTS = {
            animation: true,
            placement: 'top',
            selector: false,
            template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: 'hover focus',
            title: '',
            delay: 0,
            html: false,
            container: false
        }

        Tooltip.prototype.init = function (type, element, options) {
            this.enabled  = true
            this.type     = type
            this.$element = $(element)
            this.options  = this.getOptions(options)

            var triggers = this.options.trigger.split(' ')
            //var triggers='click';
            for (var i = triggers.length; i--;) {
                var trigger = triggers[i]

                if (trigger == 'click') {
                    this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
                } else if (trigger != 'manual') {
                    var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
                    var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

                    this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
                    this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
                }
            }

            this.options.selector ?
            (this._options = $.extend({}, this.options, {
                trigger: 'manual', 
                selector: ''
            })) :
            this.fixTitle()
        }

        Tooltip.prototype.getDefaults = function () {
            return Tooltip.DEFAULTS
        }

        Tooltip.prototype.getOptions = function (options) {
            options = $.extend({}, this.getDefaults(), this.$element.data(), options)

            if (options.delay && typeof options.delay == 'number') {
                options.delay = {
                    show: options.delay,
                    hide: options.delay
                }
            }

            return options
        }

        Tooltip.prototype.getDelegateOptions = function () {
            var options  = {}
            var defaults = this.getDefaults()

            this._options && $.each(this._options, function (key, value) {
                if (defaults[key] != value) options[key] = value
            })

            return options
        }

        Tooltip.prototype.enter = function (obj) {
            var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)

            clearTimeout(self.timeout)

            self.hoverState = 'in'

            if (!self.options.delay || !self.options.delay.show) return self.show()

            self.timeout = setTimeout(function () {
                if (self.hoverState == 'in') self.show()
            }, self.options.delay.show)
        }

        Tooltip.prototype.leave = function (obj) {
            var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)

            clearTimeout(self.timeout)

            self.hoverState = 'out'

            if (!self.options.delay || !self.options.delay.hide) return self.hide()

            self.timeout = setTimeout(function () {
                if (self.hoverState == 'out') self.hide()
            }, self.options.delay.hide)
        }

        Tooltip.prototype.show = function () {
            var e = $.Event('show.bs.' + this.type)

            if (this.hasContent() && this.enabled) {
                this.$element.trigger(e)

                if (e.isDefaultPrevented()) return
                var that = this;

                var $tip = this.tip()

                this.setContent()

                if (this.options.animation) $tip.addClass('fade')

                var placement = typeof this.options.placement == 'function' ?
                this.options.placement.call(this, $tip[0], this.$element[0]) :
                this.options.placement

                var autoToken = /\s?auto?\s?/i
                var autoPlace = autoToken.test(placement)
                if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

                $tip
                .detach()
                .css({
                    top: 0, 
                    left: 0, 
                    display: 'block'
                })
                .addClass(placement)

                this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)

                var pos          = this.getPosition()
                var actualWidth  = $tip[0].offsetWidth
                var actualHeight = $tip[0].offsetHeight

                if (autoPlace) {
                    var $parent = this.$element.parent()

                    var orgPlacement = placement
                    var docScroll    = document.documentElement.scrollTop || document.body.scrollTop
                    var parentWidth  = this.options.container == 'body' ? window.innerWidth  : $parent.outerWidth()
                    var parentHeight = this.options.container == 'body' ? window.innerHeight : $parent.outerHeight()
                    var parentLeft   = this.options.container == 'body' ? 0 : $parent.offset().left

                    placement = placement == 'bottom' && pos.top   + pos.height  + actualHeight - docScroll > parentHeight  ? 'top'    :
                    placement == 'top'    && pos.top   - docScroll   - actualHeight < 0                         ? 'bottom' :
                    placement == 'right'  && pos.right + actualWidth > parentWidth                              ? 'left'   :
                    placement == 'left'   && pos.left  - actualWidth < parentLeft                               ? 'right'  :
                    placement

                    $tip
                    .removeClass(orgPlacement)
                    .addClass(placement)
                }

                var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

                this.applyPlacement(calculatedOffset, placement)
                this.hoverState = null

                var complete = function() {
                    that.$element.trigger('shown.bs.' + that.type)
                }

                $.support.transition && this.$tip.hasClass('fade') ?
                $tip
                .one($.support.transition.end, complete)
                .emulateTransitionEnd(150) :
                complete()
            }
        }

        Tooltip.prototype.applyPlacement = function (offset, placement) {
            var replace
            var $tip   = this.tip()
            var width  = $tip[0].offsetWidth
            var height = $tip[0].offsetHeight

            // manually read margins because getBoundingClientRect includes difference
            var marginTop = parseInt($tip.css('margin-top'), 10)
            var marginLeft = parseInt($tip.css('margin-left'), 10)

            // we must check for NaN for ie 8/9
            if (isNaN(marginTop))  marginTop  = 0
            if (isNaN(marginLeft)) marginLeft = 0

            offset.top  = offset.top  + marginTop
            offset.left = offset.left + marginLeft

            // $.fn.offset doesn't round pixel values
            // so we use setOffset directly with our own function B-0
            $.offset.setOffset($tip[0], $.extend({
                using: function (props) {
                    $tip.css({
                        top: Math.round(props.top),
                        left: Math.round(props.left)
                    })
                }
            }, offset), 0)

            $tip.addClass('in')

            // check to see if placing tip in new offset caused the tip to resize itself
            var actualWidth  = $tip[0].offsetWidth
            var actualHeight = $tip[0].offsetHeight

            if (placement == 'top' && actualHeight != height) {
                replace = true
                offset.top = offset.top + height - actualHeight
            }

            if (/bottom|top/.test(placement)) {
                var delta = 0

                if (offset.left < 0) {
                    delta       = offset.left * -2
                    offset.left = 0

                    $tip.offset(offset)

                    actualWidth  = $tip[0].offsetWidth
                    actualHeight = $tip[0].offsetHeight
                }

                this.replaceArrow(delta - width + actualWidth, actualWidth, 'left')
            } else {
                this.replaceArrow(actualHeight - height, actualHeight, 'top')
            }

            if (replace) $tip.offset(offset)
        }

        Tooltip.prototype.replaceArrow = function (delta, dimension, position) {
            this.arrow().css(position, delta ? (50 * (1 - delta / dimension) + '%') : '')
        }

        Tooltip.prototype.setContent = function () {
            var $tip  = this.tip()
            var title = this.getTitle()

            $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
            $tip.removeClass('fade in top bottom left right')
        }

        Tooltip.prototype.hide = function () {
            var that = this
            var $tip = this.tip()
            var e    = $.Event('hide.bs.' + this.type)

            function complete() {
                if (that.hoverState != 'in') $tip.detach()
                that.$element.trigger('hidden.bs.' + that.type)
            }

            this.$element.trigger(e)

            if (e.isDefaultPrevented()) return

            $tip.removeClass('in')

            $.support.transition && this.$tip.hasClass('fade') ?
            $tip
            .one($.support.transition.end, complete)
            .emulateTransitionEnd(150) :
            complete()

            this.hoverState = null

            return this
        }

        Tooltip.prototype.fixTitle = function () {
            var $e = this.$element
            if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
                $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
            }
        }

        Tooltip.prototype.hasContent = function () {
            return this.getTitle()
        }

        Tooltip.prototype.getPosition = function () {
            var el = this.$element[0]
            return $.extend({}, (typeof el.getBoundingClientRect == 'function') ? el.getBoundingClientRect() : {
                width: el.offsetWidth,
                height: el.offsetHeight
            }, this.$element.offset())
        }

        Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
            return placement == 'bottom' ? {
                top: pos.top + pos.height,   
                left: pos.left + pos.width / 2 - actualWidth / 2
            } :
            placement == 'top'    ? {
                top: pos.top - actualHeight, 
                left: pos.left + pos.width / 2 - actualWidth / 2
            } :
            placement == 'left'   ? {
                top: pos.top + pos.height / 2 - actualHeight / 2, 
                left: pos.left - actualWidth
            } :
/* placement == 'right' */ {
                top: pos.top + pos.height / 2 - actualHeight / 2, 
                left: pos.left + pos.width
            }
        }

        Tooltip.prototype.getTitle = function () {
            var title
            var $e = this.$element
            var o  = this.options

            title = $e.attr('data-original-title')
            || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

            return title
        }

        Tooltip.prototype.tip = function () {
            return this.$tip = this.$tip || $(this.options.template)
        }

        Tooltip.prototype.arrow = function () {
            return this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow')
        }

        Tooltip.prototype.validate = function () {
            if (!this.$element[0].parentNode) {
                this.hide()
                this.$element = null
                this.options  = null
            }
        }

        Tooltip.prototype.enable = function () {
            this.enabled = true
        }

        Tooltip.prototype.disable = function () {
            this.enabled = false
        }

        Tooltip.prototype.toggleEnabled = function () {
            this.enabled = !this.enabled
        }

        Tooltip.prototype.toggle = function (e) {
            var self = e ? $(e.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type) : this
            self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
        }

        Tooltip.prototype.destroy = function () {
            clearTimeout(this.timeout)
            this.hide().$element.off('.' + this.type).removeData('bs.' + this.type)
        }


        // TOOLTIP PLUGIN DEFINITION
        // =========================

        var old = $.fn.tooltip

        $.fn.tooltip = function (option) {
            return this.each(function () {
                var $this   = $(this)
                var data    = $this.data('bs.tooltip')
                var options = typeof option == 'object' && option

                if (!data && option == 'destroy') return
                if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
                if (typeof option == 'string') data[option]()
            })
        }

        $.fn.tooltip.Constructor = Tooltip


        // TOOLTIP NO CONFLICT
        // ===================

        $.fn.tooltip.noConflict = function () {
            $.fn.tooltip = old
            return this
        }

    }(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.1.1
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // POPOVER PUBLIC CLASS DEFINITION
    // ===============================

    var Popover = function (element, options) {
        this.init('popover', element, options)
    }

    if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

    Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
        placement: 'right',
        trigger: 'click',
        content: '',
        template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    })


    // NOTE: POPOVER EXTENDS tooltip.js
    // ================================

    Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

    Popover.prototype.constructor = Popover

    Popover.prototype.getDefaults = function () {
        return Popover.DEFAULTS
    }

    Popover.prototype.setContent = function () {
        var $tip    = this.tip()
        var title   = this.getTitle()
        var content = this.getContent()

        $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
        $tip.find('.popover-content')[ // we use append for html objects to maintain js events
        this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
        ](content)

        $tip.removeClass('fade top bottom left right in')

        // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
        // this manually by checking the contents.
        if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
    }

    Popover.prototype.hasContent = function () {
        return this.getTitle() || this.getContent()
    }

    Popover.prototype.getContent = function () {
        var $e = this.$element
        var o  = this.options

        return $e.attr('data-content')
        || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
    }

    Popover.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find('.arrow')
    }

    Popover.prototype.tip = function () {
        if (!this.$tip) this.$tip = $(this.options.template)
        return this.$tip
    }


    // POPOVER PLUGIN DEFINITION
    // =========================

    var old = $.fn.popover

    $.fn.popover = function (option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.popover')
            var options = typeof option == 'object' && option

            if (!data && option == 'destroy') return
            if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.popover.Constructor = Popover


    // POPOVER NO CONFLICT
    // ===================

    $.fn.popover.noConflict = function () {
        $.fn.popover = old
        return this
    }

}(jQuery),
    +function(t){
        "use strict";
        function e(i,o){
            this.$body=t(document.body),this.$scrollElement=t(t(i).is(document.body)?window:i),this.options=t.extend({},e.DEFAULTS,o),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",t.proxy(this.process,this)),this.refresh(),this.process()
        }
        function i(i){
            return this.each(function(){
                var o=t(this),n=o.data("bs.scrollspy"),s="object"==typeof i&&i;
                n||o.data("bs.scrollspy",n=new e(this,s)),"string"==typeof i&&n[i]()
            })
        }
        e.VERSION="3.3.5",e.DEFAULTS={
            offset:10
        },e.prototype.getScrollHeight=function(){
            return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)
        },e.prototype.refresh=function(){
            var e=this,i="offset",o=0;
            this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),t.isWindow(this.$scrollElement[0])||(i="position",o=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){
                var e=t(this),n=e.data("target")||e.attr("href"),s=/^#./.test(n)&&t(n);
                return s&&s.length&&s.is(":visible")&&[[s[i]().top+o,n]]||null
            }).sort(function(t,e){
                return t[0]-e[0]
            }).each(function(){
                e.offsets.push(this[0]),e.targets.push(this[1])
            })
        },e.prototype.process=function(){
            var t,e=this.$scrollElement.scrollTop()+this.options.offset,i=this.getScrollHeight(),o=this.options.offset+i-this.$scrollElement.height(),n=this.offsets,s=this.targets,a=this.activeTarget;
            if(this.scrollHeight!=i&&this.refresh(),e>=o)return a!=(t=s[s.length-1])&&this.activate(t);
            if(a&&e<n[0])return this.activeTarget=null,this.clear();
            for(t=n.length;t--;)a!=s[t]&&e>=n[t]&&(void 0===n[t+1]||e<n[t+1])&&this.activate(s[t])
        },e.prototype.activate=function(e){
            this.activeTarget=e,this.clear();
            var i=this.selector+'[data-target="'+e+'"],'+this.selector+'[href="'+e+'"]',o=t(i).parents("li").addClass("active");
            o.parent(".dropdown-menu").length&&(o=o.closest("li.dropdown").addClass("active")),o.trigger("activate.bs.scrollspy")
        },e.prototype.clear=function(){
            t(this.selector).parentsUntil(this.options.target,".active").removeClass("active")
        };
        
        var o=t.fn.scrollspy;
        t.fn.scrollspy=i,t.fn.scrollspy.Constructor=e,t.fn.scrollspy.noConflict=function(){
            return t.fn.scrollspy=o,this
        },t(window).on("load.bs.scrollspy.data-api",function(){
            t('[data-spy="scroll"]').each(function(){
                var e=t(this);
                i.call(e,e.data())
            })
        })
    }(jQuery),+function(t){
        "use strict";
        function e(e){
            return this.each(function(){
                var o=t(this),n=o.data("bs.tab");
                n||o.data("bs.tab",n=new i(this)),"string"==typeof e&&n[e]()
            })
        }
        var i=function(e){
            this.element=t(e)
        };
        
        i.VERSION="3.3.5",i.TRANSITION_DURATION=150,i.prototype.show=function(){
            var e=this.element,i=e.closest("ul:not(.dropdown-menu)"),o=e.data("target");
            if(o||(o=e.attr("href"),o=o&&o.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){
                var n=i.find(".active:last a"),s=t.Event("hide.bs.tab",{
                    relatedTarget:e[0]
                }),a=t.Event("show.bs.tab",{
                    relatedTarget:n[0]
                });
                if(n.trigger(s),e.trigger(a),!a.isDefaultPrevented()&&!s.isDefaultPrevented()){
                    var r=t(o);
                    this.activate(e.closest("li"),i),this.activate(r,r.parent(),function(){
                        n.trigger({
                            type:"hidden.bs.tab",
                            relatedTarget:e[0]
                        }),e.trigger({
                            type:"shown.bs.tab",
                            relatedTarget:n[0]
                        })
                    })
                }
            }
        },i.prototype.activate=function(e,o,n){
            function s(){
                a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),r?(e[0].offsetWidth,e.addClass("in")):e.removeClass("fade"),e.parent(".dropdown-menu").length&&e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),n&&n()
            }
            var a=o.find("> .active"),r=n&&t.support.transition&&(a.length&&a.hasClass("fade")||!!o.find("> .fade").length);
            a.length&&r?a.one("bsTransitionEnd",s).emulateTransitionEnd(i.TRANSITION_DURATION):s(),a.removeClass("in")
        };
    
        var o=t.fn.tab;
        t.fn.tab=e,t.fn.tab.Constructor=i,t.fn.tab.noConflict=function(){
            return t.fn.tab=o,this
        };
    
        var n=function(i){
            i.preventDefault(),e.call(t(this),"show")
        };
    
        t(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',n).on("click.bs.tab.data-api",'[data-toggle="pill"]',n)
    }(jQuery),+function(t){
        "use strict";
        function e(e){
            return this.each(function(){
                var o=t(this),n=o.data("bs.affix"),s="object"==typeof e&&e;
                n||o.data("bs.affix",n=new i(this,s)),"string"==typeof e&&n[e]()
            })
        }
        var i=function(e,o){
            this.options=t.extend({},i.DEFAULTS,o),this.$target=t(this.options.target).on("scroll.bs.affix.data-api",t.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",t.proxy(this.checkPositionWithEventLoop,this)),this.$element=t(e),this.affixed=null,this.unpin=null,this.pinnedOffset=null,this.checkPosition()
        };
        
        i.VERSION="3.3.5",i.RESET="affix affix-top affix-bottom",i.DEFAULTS={
            offset:0,
            target:window
        },i.prototype.getState=function(t,e,i,o){
            var n=this.$target.scrollTop(),s=this.$element.offset(),a=this.$target.height();
            if(null!=i&&"top"==this.affixed)return i>n?"top":!1;
            if("bottom"==this.affixed)return null!=i?n+this.unpin<=s.top?!1:"bottom":t-o>=n+a?!1:"bottom";
            var r=null==this.affixed,l=r?n:s.top,h=r?a:e;
            return null!=i&&i>=n?"top":null!=o&&l+h>=t-o?"bottom":!1
        },i.prototype.getPinnedOffset=function(){
            if(this.pinnedOffset)return this.pinnedOffset;
            this.$element.removeClass(i.RESET).addClass("affix");
            var t=this.$target.scrollTop(),e=this.$element.offset();
            return this.pinnedOffset=e.top-t
        },i.prototype.checkPositionWithEventLoop=function(){
            setTimeout(t.proxy(this.checkPosition,this),1)
        },i.prototype.checkPosition=function(){
            if(this.$element.is(":visible")){
                var e=this.$element.height(),o=this.options.offset,n=o.top,s=o.bottom,a=Math.max(t(document).height(),t(document.body).height());
                "object"!=typeof o&&(s=n=o),"function"==typeof n&&(n=o.top(this.$element)),"function"==typeof s&&(s=o.bottom(this.$element));
                var r=this.getState(a,e,n,s);
                if(this.affixed!=r){
                    null!=this.unpin&&this.$element.css("top","");
                    var l="affix"+(r?"-"+r:""),h=t.Event(l+".bs.affix");
                    if(this.$element.trigger(h),h.isDefaultPrevented())return;
                    this.affixed=r,this.unpin="bottom"==r?this.getPinnedOffset():null,this.$element.removeClass(i.RESET).addClass(l).trigger(l.replace("affix","affixed")+".bs.affix")
                }
                "bottom"==r&&this.$element.offset({
                    top:a-e-s
                })
            }
        };
    
        var o=t.fn.affix;
        t.fn.affix=e,t.fn.affix.Constructor=i,t.fn.affix.noConflict=function(){
            return t.fn.affix=o,this
        },t(window).on("load",function(){
            t('[data-spy="affix"]').each(function(){
                var i=t(this),o=i.data();
                o.offset=o.offset||{},null!=o.offsetBottom&&(o.offset.bottom=o.offsetBottom),null!=o.offsetTop&&(o.offset.top=o.offsetTop),e.call(i,o)
            })
        })
    }(jQuery);
;
var addComment={
    moveForm:function(a,b,c,d){
        var e,f,g,h,i=this,j=i.I(a),k=i.I(c),l=i.I("cancel-comment-reply-link"),m=i.I("comment_parent"),n=i.I("comment_post_ID"),o=k.getElementsByTagName("form")[0];
        if(j&&k&&l&&m&&o){
            i.respondId=c,d=d||!1,i.I("wp-temp-form-div")||(e=document.createElement("div"),e.id="wp-temp-form-div",e.style.display="none",k.parentNode.insertBefore(e,k)),j.parentNode.insertBefore(k,j.nextSibling),n&&d&&(n.value=d),m.value=b,l.style.display="",l.onclick=function(){
                var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);
                if(b&&c)return a.I("comment_parent").value="0",b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b),this.style.display="none",this.onclick=null,!1
            };
                    
            try{
                for(var p=0;p<o.elements.length;p++)if(f=o.elements[p],h=!1,"getComputedStyle"in window?g=window.getComputedStyle(f):document.documentElement.currentStyle&&(g=f.currentStyle),(f.offsetWidth<=0&&f.offsetHeight<=0||"hidden"===g.visibility)&&(h=!0),"hidden"!==f.type&&!f.disabled&&!h){
                    f.focus();
                    break
                }
            }catch(q){}
            return!1
        }
    },
    I:function(a){
        return document.getElementById(a)
    }
};
;/*! ResponsiveSlides.js v1.54
 * http://responsiveslides.com
 * http://viljamis.com
 *
 * Copyright (c) 2011-2012 @viljamis
 * Available under the MIT license
 */

/*jslint browser: true, sloppy: true, vars: true, plusplus: true, indent: 2 */

(function ($, window, i) {
    $.fn.responsiveSlides = function (options) {

        // Default settings
        var settings = $.extend({
            "auto": true,             // Boolean: Animate automatically, true or false
            "speed": 500,             // Integer: Speed of the transition, in milliseconds
            "timeout": 4000,          // Integer: Time between slide transitions, in milliseconds
            "pager": false,           // Boolean: Show pager, true or false
            "nav": false,             // Boolean: Show navigation, true or false
            "random": false,          // Boolean: Randomize the order of the slides, true or false
            "pause": false,           // Boolean: Pause on hover, true or false
            "pauseControls": true,    // Boolean: Pause when hovering controls, true or false
            "prevText": "Previous",   // String: Text for the "previous" button
            "nextText": "Next",       // String: Text for the "next" button
            "maxwidth": "",           // Integer: Max-width of the slideshow, in pixels
            "navContainer": "",       // Selector: Where auto generated controls should be appended to, default is after the <ul>
            "manualControls": "",     // Selector: Declare custom pager navigation
            "namespace": "rslides",   // String: change the default namespace used
            "before": $.noop,         // Function: Before callback
            "after": $.noop           // Function: After callback
        }, options);

        return this.each(function () {

            // Index for namespacing
            i++;

            var $this = $(this),

            // Local variables
            vendor,
            selectTab,
            startCycle,
            restartCycle,
            rotate,
            $tabs,

            // Helpers
            index = 0,
            $slide = $this.children(),
            length = $slide.size(),
            fadeTime = parseFloat(settings.speed),
            waitTime = parseFloat(settings.timeout),
            maxw = parseFloat(settings.maxwidth),

            // Namespacing
            namespace = settings.namespace,
            namespaceIdx = namespace + i,

            // Classes
            navClass = namespace + "_nav " + namespaceIdx + "_nav",
            activeClass = namespace + "_here",
            visibleClass = namespaceIdx + "_on",
            slideClassPrefix = namespaceIdx + "_s",

            // Pager
            $pager = $("<ul class='" + namespace + "_tabs " + namespaceIdx + "_tabs' />"),

            // Styles for visible and hidden slides
            visible = {
                "float": "left", 
                "position": "relative", 
                "opacity": 1, 
                "zIndex": 2
            },
            hidden = {
                "float": "none", 
                "position": "absolute", 
                "opacity": 0, 
                "zIndex": 1
            },

            // Detect transition support
            supportsTransitions = (function () {
                var docBody = document.body || document.documentElement;
                var styles = docBody.style;
                var prop = "transition";
                if (typeof styles[prop] === "string") {
                    return true;
                }
                // Tests for vendor specific prop
                vendor = ["Moz", "Webkit", "Khtml", "O", "ms"];
                prop = prop.charAt(0).toUpperCase() + prop.substr(1);
                var i;
                for (i = 0; i < vendor.length; i++) {
                    if (typeof styles[vendor[i] + prop] === "string") {
                        return true;
                    }
                }
                return false;
            })(),

            // Fading animation
            slideTo = function (idx) {
                settings.before(idx);
                // If CSS3 transitions are supported
                if (supportsTransitions) {
                    $slide
                    .removeClass(visibleClass)
                    .css(hidden)
                    .eq(idx)
                    .addClass(visibleClass)
                    .css(visible);
                    index = idx;
                    setTimeout(function () {
                        settings.after(idx);
                    }, fadeTime);
                // If not, use jQuery fallback
                } else {
                    $slide
                    .stop()
                    .fadeOut(fadeTime, function () {
                        $(this)
                        .removeClass(visibleClass)
                        .css(hidden)
                        .css("opacity", 1);
                    })
                    .eq(idx)
                    .fadeIn(fadeTime, function () {
                        $(this)
                        .addClass(visibleClass)
                        .css(visible);
                        settings.after(idx);
                        index = idx;
                    });
                }
            };

            // Random order
            if (settings.random) {
                $slide.sort(function () {
                    return (Math.round(Math.random()) - 0.5);
                });
                $this
                .empty()
                .append($slide);
            }

            // Add ID's to each slide
            $slide.each(function (i) {
                this.id = slideClassPrefix + i;
            });

            // Add max-width and classes
            $this.addClass(namespace + " " + namespaceIdx);
            if (options && options.maxwidth) {
                $this.css("max-width", maxw);
            }

            // Hide all slides, then show first one
            $slide
            .hide()
            .css(hidden)
            .eq(0)
            .addClass(visibleClass)
            .css(visible)
            .show();

            // CSS transitions
            if (supportsTransitions) {
                $slide
                .show()
                .css({
                    // -ms prefix isn't needed as IE10 uses prefix free version
                    "-webkit-transition": "opacity " + fadeTime + "ms ease-in-out",
                    "-moz-transition": "opacity " + fadeTime + "ms ease-in-out",
                    "-o-transition": "opacity " + fadeTime + "ms ease-in-out",
                    "transition": "opacity " + fadeTime + "ms ease-in-out"
                });
            }

            // Only run if there's more than one slide
            if ($slide.size() > 1) {

                // Make sure the timeout is at least 100ms longer than the fade
                if (waitTime < fadeTime + 100) {
                    return;
                }

                // Pager
                if (settings.pager && !settings.manualControls) {
                    var tabMarkup = [];
                    $slide.each(function (i) {
                        var n = i + 1;
                        tabMarkup +=
                        "<li>" +
                        "<a href='#' class='" + slideClassPrefix + n + "'>" + n + "</a>" +
                        "</li>";
                    });
                    $pager.append(tabMarkup);

                    // Inject pager
                    if (options.navContainer) {
                        $(settings.navContainer).append($pager);
                    } else {
                        $this.after($pager);
                    }
                }

                // Manual pager controls
                if (settings.manualControls) {
                    $pager = $(settings.manualControls);
                    $pager.addClass(namespace + "_tabs " + namespaceIdx + "_tabs");
                }

                // Add pager slide class prefixes
                if (settings.pager || settings.manualControls) {
                    $pager.find('li').each(function (i) {
                        $(this).addClass(slideClassPrefix + (i + 1));
                    });
                }

                // If we have a pager, we need to set up the selectTab function
                if (settings.pager || settings.manualControls) {
                    $tabs = $pager.find('a');

                    // Select pager item
                    selectTab = function (idx) {
                        $tabs
                        .closest("li")
                        .removeClass(activeClass)
                        .eq(idx)
                        .addClass(activeClass);
                    };
                }

                // Auto cycle
                if (settings.auto) {

                    startCycle = function () {
                        rotate = setInterval(function () {

                            // Clear the event queue
                            $slide.stop(true, true);

                            var idx = index + 1 < length ? index + 1 : 0;

                            // Remove active state and set new if pager is set
                            if (settings.pager || settings.manualControls) {
                                selectTab(idx);
                            }

                            slideTo(idx);
                        }, waitTime);
                    };

                    // Init cycle
                    startCycle();
                }

                // Restarting cycle
                restartCycle = function () {
                    if (settings.auto) {
                        // Stop
                        clearInterval(rotate);
                        // Restart
                        startCycle();
                    }
                };

                // Pause on hover
                if (settings.pause) {
                    $this.hover(function () {
                        clearInterval(rotate);
                    }, function () {
                        restartCycle();
                    });
                }

                // Pager click event handler
                if (settings.pager || settings.manualControls) {
                    $tabs.bind("click", function (e) {
                        e.preventDefault();

                        if (!settings.pauseControls) {
                            restartCycle();
                        }

                        // Get index of clicked tab
                        var idx = $tabs.index(this);

                        // Break if element is already active or currently animated
                        if (index === idx || $("." + visibleClass).queue('fx').length) {
                            return;
                        }

                        // Remove active state from old tab and set new one
                        selectTab(idx);

                        // Do the animation
                        slideTo(idx);
                    })
                    .eq(0)
                    .closest("li")
                    .addClass(activeClass);

                    // Pause when hovering pager
                    if (settings.pauseControls) {
                        $tabs.hover(function () {
                            clearInterval(rotate);
                        }, function () {
                            restartCycle();
                        });
                    }
                }

                // Navigation
                if (settings.nav) {
                    var navMarkup =
                    "<a href='#' class='" + navClass + " prev'>" + settings.prevText + "</a>" +
                    "<a href='#' class='" + navClass + " next'>" + settings.nextText + "</a>";

                    // Inject navigation
                    if (options.navContainer) {
                        $(settings.navContainer).append(navMarkup);
                    } else {
                        $this.append(navMarkup);
                    }

                    var $trigger = $("." + namespaceIdx + "_nav"),
                    $prev = $trigger.filter(".prev");

                    // Click event handler
                    $trigger.bind("click", function (e) {
                        e.preventDefault();

                        var $visibleClass = $("." + visibleClass);

                        // Prevent clicking if currently animated
                        if ($visibleClass.queue('fx').length) {
                            return;
                        }

                        //  Adds active class during slide animation
                        //  $(this)
                        //    .addClass(namespace + "_active")
                        //    .delay(fadeTime)
                        //    .queue(function (next) {
                        //      $(this).removeClass(namespace + "_active");
                        //      next();
                        //  });

                        // Determine where to slide
                        var idx = $slide.index($visibleClass),
                        prevIdx = idx - 1,
                        nextIdx = idx + 1 < length ? index + 1 : 0;

                        // Go to slide
                        slideTo($(this)[0] === $prev[0] ? prevIdx : nextIdx);
                        if (settings.pager || settings.manualControls) {
                            selectTab($(this)[0] === $prev[0] ? prevIdx : nextIdx);
                        }

                        if (!settings.pauseControls) {
                            restartCycle();
                        }
                    });

                    // Pause when hovering navigation
                    if (settings.pauseControls) {
                        $trigger.hover(function () {
                            clearInterval(rotate);
                        }, function () {
                            restartCycle();
                        });
                    }
                }

            }

            // Max-width fallback
            if (typeof document.body.style.maxWidth === "undefined" && options.maxwidth) {
                var widthSupport = function () {
                    $this.css("width", "100%");
                    if ($this.width() > maxw) {
                        $this.css("width", maxw);
                    }
                };

                // Init fallback
                widthSupport();
                $(window).bind("resize", function () {
                    widthSupport();
                });
            }

        });

    };
})(jQuery, this, 0);

;/*! Magnific Popup - v0.9.9 - 2013-12-27
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2013 Dmitry Semenov; */
(function(e){
    var t,n,i,o,r,a,s,l="Close",c="BeforeClose",d="AfterClose",u="BeforeAppend",p="MarkupParse",f="Open",m="Change",g="mfp",h="."+g,v="mfp-ready",C="mfp-removing",y="mfp-prevent-close",w=function(){},b=!!window.jQuery,I=e(window),x=function(e,n){
        t.ev.on(g+e+h,n)
    },k=function(t,n,i,o){
        var r=document.createElement("div");
        return r.className="mfp-"+t,i&&(r.innerHTML=i),o?n&&n.appendChild(r):(r=e(r),n&&r.appendTo(n)),r
    },T=function(n,i){
        t.ev.triggerHandler(g+n,i),t.st.callbacks&&(n=n.charAt(0).toLowerCase()+n.slice(1),t.st.callbacks[n]&&t.st.callbacks[n].apply(t,e.isArray(i)?i:[i]))
    },E=function(n){
        return n===s&&t.currTemplate.closeBtn||(t.currTemplate.closeBtn=e(t.st.closeMarkup.replace("%title%",t.st.tClose)),s=n),t.currTemplate.closeBtn
    },_=function(){
        e.magnificPopup.instance||(t=new w,t.init(),e.magnificPopup.instance=t)
    },S=function(){
        var e=document.createElement("p").style,t=["ms","O","Moz","Webkit"];
        if(void 0!==e.transition)return!0;
        for(;t.length;)if(t.pop()+"Transition"in e)return!0;return!1
    };
        
    w.prototype={
        constructor:w,
        init:function(){
            var n=navigator.appVersion;
            t.isIE7=-1!==n.indexOf("MSIE 7."),t.isIE8=-1!==n.indexOf("MSIE 8."),t.isLowIE=t.isIE7||t.isIE8,t.isAndroid=/android/gi.test(n),t.isIOS=/iphone|ipad|ipod/gi.test(n),t.supportsTransition=S(),t.probablyMobile=t.isAndroid||t.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),o=e(document),t.popupsCache={}
        },
        open:function(n){
            i||(i=e(document.body));
            var r;
            if(n.isObj===!1){
                t.items=n.items.toArray(),t.index=0;
                var s,l=n.items;
                for(r=0;l.length>r;r++)if(s=l[r],s.parsed&&(s=s.el[0]),s===n.el[0]){
                    t.index=r;
                    break
                }
            }else t.items=e.isArray(n.items)?n.items:[n.items],t.index=n.index||0;
            if(t.isOpen)return t.updateItemHTML(),void 0;
            t.types=[],a="",t.ev=n.mainEl&&n.mainEl.length?n.mainEl.eq(0):o,n.key?(t.popupsCache[n.key]||(t.popupsCache[n.key]={}),t.currTemplate=t.popupsCache[n.key]):t.currTemplate={},t.st=e.extend(!0,{},e.magnificPopup.defaults,n),t.fixedContentPos="auto"===t.st.fixedContentPos?!t.probablyMobile:t.st.fixedContentPos,t.st.modal&&(t.st.closeOnContentClick=!1,t.st.closeOnBgClick=!1,t.st.showCloseBtn=!1,t.st.enableEscapeKey=!1),t.bgOverlay||(t.bgOverlay=k("bg").on("click"+h,function(){
                t.close()
            }),t.wrap=k("wrap").attr("tabindex",-1).on("click"+h,function(e){
                t._checkIfClose(e.target)&&t.close()
            }),t.container=k("container",t.wrap)),t.contentContainer=k("content"),t.st.preloader&&(t.preloader=k("preloader",t.container,t.st.tLoading));
            var c=e.magnificPopup.modules;
            for(r=0;c.length>r;r++){
                var d=c[r];
                d=d.charAt(0).toUpperCase()+d.slice(1),t["init"+d].call(t)
            }
            T("BeforeOpen"),t.st.showCloseBtn&&(t.st.closeBtnInside?(x(p,function(e,t,n,i){
                n.close_replaceWith=E(i.type)
            }),a+=" mfp-close-btn-in"):t.wrap.append(E())),t.st.alignTop&&(a+=" mfp-align-top"),t.fixedContentPos?t.wrap.css({
                overflow:t.st.overflowY,
                overflowX:"hidden",
                overflowY:t.st.overflowY
            }):t.wrap.css({
                top:I.scrollTop(),
                position:"absolute"
            }),(t.st.fixedBgPos===!1||"auto"===t.st.fixedBgPos&&!t.fixedContentPos)&&t.bgOverlay.css({
                height:o.height(),
                position:"absolute"
            }),t.st.enableEscapeKey&&o.on("keyup"+h,function(e){
                27===e.keyCode&&t.close()
            }),I.on("resize"+h,function(){
                t.updateSize()
            }),t.st.closeOnContentClick||(a+=" mfp-auto-cursor"),a&&t.wrap.addClass(a);
            var u=t.wH=I.height(),m={};
    
            if(t.fixedContentPos&&t._hasScrollBar(u)){
                var g=t._getScrollbarSize();
                g&&(m.marginRight=g)
            }
            t.fixedContentPos&&(t.isIE7?e("body, html").css("overflow","hidden"):m.overflow="hidden");
            var C=t.st.mainClass;
            return t.isIE7&&(C+=" mfp-ie7"),C&&t._addClassToMFP(C),t.updateItemHTML(),T("BuildControls"),e("html").css(m),t.bgOverlay.add(t.wrap).prependTo(t.st.prependTo||i),t._lastFocusedEl=document.activeElement,setTimeout(function(){
                t.content?(t._addClassToMFP(v),t._setFocus()):t.bgOverlay.addClass(v),o.on("focusin"+h,t._onFocusIn)
            },16),t.isOpen=!0,t.updateSize(u),T(f),n
        },
        close:function(){
            t.isOpen&&(T(c),t.isOpen=!1,t.st.removalDelay&&!t.isLowIE&&t.supportsTransition?(t._addClassToMFP(C),setTimeout(function(){
                t._close()
            },t.st.removalDelay)):t._close())
        },
        _close:function(){
            T(l);
            var n=C+" "+v+" ";
            if(t.bgOverlay.detach(),t.wrap.detach(),t.container.empty(),t.st.mainClass&&(n+=t.st.mainClass+" "),t._removeClassFromMFP(n),t.fixedContentPos){
                var i={
                    marginRight:""
                };
        
                t.isIE7?e("body, html").css("overflow",""):i.overflow="",e("html").css(i)
            }
            o.off("keyup"+h+" focusin"+h),t.ev.off(h),t.wrap.attr("class","mfp-wrap").removeAttr("style"),t.bgOverlay.attr("class","mfp-bg"),t.container.attr("class","mfp-container"),!t.st.showCloseBtn||t.st.closeBtnInside&&t.currTemplate[t.currItem.type]!==!0||t.currTemplate.closeBtn&&t.currTemplate.closeBtn.detach(),t._lastFocusedEl&&e(t._lastFocusedEl).focus(),t.currItem=null,t.content=null,t.currTemplate=null,t.prevHeight=0,T(d)
        },
        updateSize:function(e){
            if(t.isIOS){
                var n=document.documentElement.clientWidth/window.innerWidth,i=window.innerHeight*n;
                t.wrap.css("height",i),t.wH=i
            }else t.wH=e||I.height();
            t.fixedContentPos||t.wrap.css("height",t.wH),T("Resize")
        },
        updateItemHTML:function(){
            var n=t.items[t.index];
            t.contentContainer.detach(),t.content&&t.content.detach(),n.parsed||(n=t.parseEl(t.index));
            var i=n.type;
            if(T("BeforeChange",[t.currItem?t.currItem.type:"",i]),t.currItem=n,!t.currTemplate[i]){
                var o=t.st[i]?t.st[i].markup:!1;
                T("FirstMarkupParse",o),t.currTemplate[i]=o?e(o):!0
            }
            r&&r!==n.type&&t.container.removeClass("mfp-"+r+"-holder");
            var a=t["get"+i.charAt(0).toUpperCase()+i.slice(1)](n,t.currTemplate[i]);
            t.appendContent(a,i),n.preloaded=!0,T(m,n),r=n.type,t.container.prepend(t.contentContainer),T("AfterChange")
        },
        appendContent:function(e,n){
            t.content=e,e?t.st.showCloseBtn&&t.st.closeBtnInside&&t.currTemplate[n]===!0?t.content.find(".mfp-close").length||t.content.append(E()):t.content=e:t.content="",T(u),t.container.addClass("mfp-"+n+"-holder"),t.contentContainer.append(t.content)
        },
        parseEl:function(n){
            var i,o=t.items[n];
            if(o.tagName?o={
                el:e(o)
            }:(i=o.type,o={
                data:o,
                src:o.src
            }),o.el){
                for(var r=t.types,a=0;r.length>a;a++)if(o.el.hasClass("mfp-"+r[a])){
                    i=r[a];
                    break
                }
                o.src=o.el.attr("data-mfp-src"),o.src||(o.src=o.el.attr("href"))
            }
            return o.type=i||t.st.type||"inline",o.index=n,o.parsed=!0,t.items[n]=o,T("ElementParse",o),t.items[n]
        },
        addGroup:function(e,n){
            var i=function(i){
                i.mfpEl=this,t._openClick(i,e,n)
            };
        
            n||(n={});
            var o="click.magnificPopup";
            n.mainEl=e,n.items?(n.isObj=!0,e.off(o).on(o,i)):(n.isObj=!1,n.delegate?e.off(o).on(o,n.delegate,i):(n.items=e,e.off(o).on(o,i)))
        },
        _openClick:function(n,i,o){
            var r=void 0!==o.midClick?o.midClick:e.magnificPopup.defaults.midClick;
            if(r||2!==n.which&&!n.ctrlKey&&!n.metaKey){
                var a=void 0!==o.disableOn?o.disableOn:e.magnificPopup.defaults.disableOn;
                if(a)if(e.isFunction(a)){
                    if(!a.call(t))return!0
                }else if(a>I.width())return!0;
                n.type&&(n.preventDefault(),t.isOpen&&n.stopPropagation()),o.el=e(n.mfpEl),o.delegate&&(o.items=i.find(o.delegate)),t.open(o)
            }
        },
        updateStatus:function(e,i){
            if(t.preloader){
                n!==e&&t.container.removeClass("mfp-s-"+n),i||"loading"!==e||(i=t.st.tLoading);
                var o={
                    status:e,
                    text:i
                };
        
                T("UpdateStatus",o),e=o.status,i=o.text,t.preloader.html(i),t.preloader.find("a").on("click",function(e){
                    e.stopImmediatePropagation()
                }),t.container.addClass("mfp-s-"+e),n=e
            }
        },
        _checkIfClose:function(n){
            if(!e(n).hasClass(y)){
                var i=t.st.closeOnContentClick,o=t.st.closeOnBgClick;
                if(i&&o)return!0;
                if(!t.content||e(n).hasClass("mfp-close")||t.preloader&&n===t.preloader[0])return!0;
                if(n===t.content[0]||e.contains(t.content[0],n)){
                    if(i)return!0
                }else if(o&&e.contains(document,n))return!0;
                return!1
            }
        },
        _addClassToMFP:function(e){
            t.bgOverlay.addClass(e),t.wrap.addClass(e)
        },
        _removeClassFromMFP:function(e){
            this.bgOverlay.removeClass(e),t.wrap.removeClass(e)
        },
        _hasScrollBar:function(e){
            return(t.isIE7?o.height():document.body.scrollHeight)>(e||I.height())
        },
        _setFocus:function(){
            (t.st.focus?t.content.find(t.st.focus).eq(0):t.wrap).focus()
        },
        _onFocusIn:function(n){
            return n.target===t.wrap[0]||e.contains(t.wrap[0],n.target)?void 0:(t._setFocus(),!1)
        },
        _parseMarkup:function(t,n,i){
            var o;
            i.data&&(n=e.extend(i.data,n)),T(p,[t,n,i]),e.each(n,function(e,n){
                if(void 0===n||n===!1)return!0;
                if(o=e.split("_"),o.length>1){
                    var i=t.find(h+"-"+o[0]);
                    if(i.length>0){
                        var r=o[1];
                        "replaceWith"===r?i[0]!==n[0]&&i.replaceWith(n):"img"===r?i.is("img")?i.attr("src",n):i.replaceWith('<img src="'+n+'" class="'+i.attr("class")+'" />'):i.attr(o[1],n)
                    }
                }else t.find(h+"-"+e).html(n)
            })
        },
        _getScrollbarSize:function(){
            if(void 0===t.scrollbarSize){
                var e=document.createElement("div");
                e.id="mfp-sbm",e.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(e),t.scrollbarSize=e.offsetWidth-e.clientWidth,document.body.removeChild(e)
            }
            return t.scrollbarSize
        }
    },e.magnificPopup={
        instance:null,
        proto:w.prototype,
        modules:[],
        open:function(t,n){
            return _(),t=t?e.extend(!0,{},t):{},t.isObj=!0,t.index=n||0,this.instance.open(t)
        },
        close:function(){
            return e.magnificPopup.instance&&e.magnificPopup.instance.close()
        },
        registerModule:function(t,n){
            n.options&&(e.magnificPopup.defaults[t]=n.options),e.extend(this.proto,n.proto),this.modules.push(t)
        },
        defaults:{
            disableOn:0,
            key:null,
            midClick:!1,
            mainClass:"",
            preloader:!0,
            focus:"",
            closeOnContentClick:!1,
            closeOnBgClick:!0,
            closeBtnInside:!0,
            showCloseBtn:!0,
            enableEscapeKey:!0,
            modal:!1,
            alignTop:!1,
            removalDelay:0,
            prependTo:null,
            fixedContentPos:"auto",
            fixedBgPos:"auto",
            overflowY:"auto",
            closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',
            tClose:"Close (Esc)",
            tLoading:"Loading..."
        }
    },e.fn.magnificPopup=function(n){
        _();
        var i=e(this);
        if("string"==typeof n)if("open"===n){
            var o,r=b?i.data("magnificPopup"):i[0].magnificPopup,a=parseInt(arguments[1],10)||0;
            r.items?o=r.items[a]:(o=i,r.delegate&&(o=o.find(r.delegate)),o=o.eq(a)),t._openClick({
                mfpEl:o
            },i,r)
        }else t.isOpen&&t[n].apply(t,Array.prototype.slice.call(arguments,1));else n=e.extend(!0,{},n),b?i.data("magnificPopup",n):i[0].magnificPopup=n,t.addGroup(i,n);
        return i
    };
    
    var P,O,z,M="inline",B=function(){
        z&&(O.after(z.addClass(P)).detach(),z=null)
    };
    
    e.magnificPopup.registerModule(M,{
        options:{
            hiddenClass:"hide",
            markup:"",
            tNotFound:"Content not found"
        },
        proto:{
            initInline:function(){
                t.types.push(M),x(l+"."+M,function(){
                    B()
                })
            },
            getInline:function(n,i){
                if(B(),n.src){
                    var o=t.st.inline,r=e(n.src);
                    if(r.length){
                        var a=r[0].parentNode;
                        a&&a.tagName&&(O||(P=o.hiddenClass,O=k(P),P="mfp-"+P),z=r.after(O).detach().removeClass(P)),t.updateStatus("ready")
                    }else t.updateStatus("error",o.tNotFound),r=e("<div>");
                    return n.inlineElement=r,r
                }
                return t.updateStatus("ready"),t._parseMarkup(i,{},n),i
            }
        }
    });
    var F,H="ajax",L=function(){
        F&&i.removeClass(F)
    },A=function(){
        L(),t.req&&t.req.abort()
    };
    
    e.magnificPopup.registerModule(H,{
        options:{
            settings:null,
            cursor:"mfp-ajax-cur",
            tError:'<a href="%url%">The content</a> could not be loaded.'
        },
        proto:{
            initAjax:function(){
                t.types.push(H),F=t.st.ajax.cursor,x(l+"."+H,A),x("BeforeChange."+H,A)
            },
            getAjax:function(n){
                F&&i.addClass(F),t.updateStatus("loading");
                var o=e.extend({
                    url:n.src,
                    success:function(i,o,r){
                        var a={
                            data:i,
                            xhr:r
                        };
                    
                        T("ParseAjax",a),t.appendContent(e(a.data),H),n.finished=!0,L(),t._setFocus(),setTimeout(function(){
                            t.wrap.addClass(v)
                        },16),t.updateStatus("ready"),T("AjaxContentAdded")
                    },
                    error:function(){
                        L(),n.finished=n.loadError=!0,t.updateStatus("error",t.st.ajax.tError.replace("%url%",n.src))
                    }
                },t.st.ajax.settings);
                return t.req=e.ajax(o),""
            }
        }
    });
    var j,N=function(n){
        if(n.data&&void 0!==n.data.title)return n.data.title;
        var i=t.st.image.titleSrc;
        if(i){
            if(e.isFunction(i))return i.call(t,n);
            if(n.el)return n.el.attr(i)||""
        }
        return""
    };
    
    e.magnificPopup.registerModule("image",{
        options:{
            markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',
            cursor:"mfp-zoom-out-cur",
            titleSrc:"title",
            verticalFit:!0,
            tError:'<a href="%url%">The image</a> could not be loaded.'
        },
        proto:{
            initImage:function(){
                var e=t.st.image,n=".image";
                t.types.push("image"),x(f+n,function(){
                    "image"===t.currItem.type&&e.cursor&&i.addClass(e.cursor)
                }),x(l+n,function(){
                    e.cursor&&i.removeClass(e.cursor),I.off("resize"+h)
                }),x("Resize"+n,t.resizeImage),t.isLowIE&&x("AfterChange",t.resizeImage)
            },
            resizeImage:function(){
                var e=t.currItem;
                if(e&&e.img&&t.st.image.verticalFit){
                    var n=0;
                    t.isLowIE&&(n=parseInt(e.img.css("padding-top"),10)+parseInt(e.img.css("padding-bottom"),10)),e.img.css("max-height",t.wH-n)
                }
            },
            _onImageHasSize:function(e){
                e.img&&(e.hasSize=!0,j&&clearInterval(j),e.isCheckingImgSize=!1,T("ImageHasSize",e),e.imgHidden&&(t.content&&t.content.removeClass("mfp-loading"),e.imgHidden=!1))
            },
            findImageSize:function(e){
                var n=0,i=e.img[0],o=function(r){
                    j&&clearInterval(j),j=setInterval(function(){
                        return i.naturalWidth>0?(t._onImageHasSize(e),void 0):(n>200&&clearInterval(j),n++,3===n?o(10):40===n?o(50):100===n&&o(500),void 0)
                    },r)
                };
            
                o(1)
            },
            getImage:function(n,i){
                var o=0,r=function(){
                    n&&(n.img[0].complete?(n.img.off(".mfploader"),n===t.currItem&&(t._onImageHasSize(n),t.updateStatus("ready")),n.hasSize=!0,n.loaded=!0,T("ImageLoadComplete")):(o++,200>o?setTimeout(r,100):a()))
                },a=function(){
                    n&&(n.img.off(".mfploader"),n===t.currItem&&(t._onImageHasSize(n),t.updateStatus("error",s.tError.replace("%url%",n.src))),n.hasSize=!0,n.loaded=!0,n.loadError=!0)
                },s=t.st.image,l=i.find(".mfp-img");
                if(l.length){
                    var c=document.createElement("img");
                    c.className="mfp-img",n.img=e(c).on("load.mfploader",r).on("error.mfploader",a),c.src=n.src,l.is("img")&&(n.img=n.img.clone()),c=n.img[0],c.naturalWidth>0?n.hasSize=!0:c.width||(n.hasSize=!1)
                }
                return t._parseMarkup(i,{
                    title:N(n),
                    img_replaceWith:n.img
                },n),t.resizeImage(),n.hasSize?(j&&clearInterval(j),n.loadError?(i.addClass("mfp-loading"),t.updateStatus("error",s.tError.replace("%url%",n.src))):(i.removeClass("mfp-loading"),t.updateStatus("ready")),i):(t.updateStatus("loading"),n.loading=!0,n.hasSize||(n.imgHidden=!0,i.addClass("mfp-loading"),t.findImageSize(n)),i)
            }
        }
    });
    var W,R=function(){
        return void 0===W&&(W=void 0!==document.createElement("p").style.MozTransform),W
    };
    
    e.magnificPopup.registerModule("zoom",{
        options:{
            enabled:!1,
            easing:"ease-in-out",
            duration:300,
            opener:function(e){
                return e.is("img")?e:e.find("img")
            }
        },
        proto:{
            initZoom:function(){
                var e,n=t.st.zoom,i=".zoom";
                if(n.enabled&&t.supportsTransition){
                    var o,r,a=n.duration,s=function(e){
                        var t=e.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),i="all "+n.duration/1e3+"s "+n.easing,o={
                            position:"fixed",
                            zIndex:9999,
                            left:0,
                            top:0,
                            "-webkit-backface-visibility":"hidden"
                        },r="transition";
                        return o["-webkit-"+r]=o["-moz-"+r]=o["-o-"+r]=o[r]=i,t.css(o),t
                    },d=function(){
                        t.content.css("visibility","visible")
                    };
                
                    x("BuildControls"+i,function(){
                        if(t._allowZoom()){
                            if(clearTimeout(o),t.content.css("visibility","hidden"),e=t._getItemToZoom(),!e)return d(),void 0;
                            r=s(e),r.css(t._getOffset()),t.wrap.append(r),o=setTimeout(function(){
                                r.css(t._getOffset(!0)),o=setTimeout(function(){
                                    d(),setTimeout(function(){
                                        r.remove(),e=r=null,T("ZoomAnimationEnded")
                                    },16)
                                },a)
                            },16)
                        }
                    }),x(c+i,function(){
                        if(t._allowZoom()){
                            if(clearTimeout(o),t.st.removalDelay=a,!e){
                                if(e=t._getItemToZoom(),!e)return;
                                r=s(e)
                            }
                            r.css(t._getOffset(!0)),t.wrap.append(r),t.content.css("visibility","hidden"),setTimeout(function(){
                                r.css(t._getOffset())
                            },16)
                        }
                    }),x(l+i,function(){
                        t._allowZoom()&&(d(),r&&r.remove(),e=null)
                    })
                }
            },
            _allowZoom:function(){
                return"image"===t.currItem.type
            },
            _getItemToZoom:function(){
                return t.currItem.hasSize?t.currItem.img:!1
            },
            _getOffset:function(n){
                var i;
                i=n?t.currItem.img:t.st.zoom.opener(t.currItem.el||t.currItem);
                var o=i.offset(),r=parseInt(i.css("padding-top"),10),a=parseInt(i.css("padding-bottom"),10);
                o.top-=e(window).scrollTop()-r;
                var s={
                    width:i.width(),
                    height:(b?i.innerHeight():i[0].offsetHeight)-a-r
                };
        
                return R()?s["-moz-transform"]=s.transform="translate("+o.left+"px,"+o.top+"px)":(s.left=o.left,s.top=o.top),s
            }
        }
    });
    var Z="iframe",q="//about:blank",D=function(e){
        if(t.currTemplate[Z]){
            var n=t.currTemplate[Z].find("iframe");
            n.length&&(e||(n[0].src=q),t.isIE8&&n.css("display",e?"block":"none"))
        }
    };

    e.magnificPopup.registerModule(Z,{
        options:{
            markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
            srcAction:"iframe_src",
            patterns:{
                youtube:{
                    index:"youtube.com",
                    id:"v=",
                    src:"//www.youtube.com/embed/%id%?autoplay=1"
                },
                vimeo:{
                    index:"vimeo.com/",
                    id:"/",
                    src:"//player.vimeo.com/video/%id%?autoplay=1"
                },
                gmaps:{
                    index:"//maps.google.",
                    src:"%id%&output=embed"
                }
            }
        },
        proto:{
            initIframe:function(){
                t.types.push(Z),x("BeforeChange",function(e,t,n){
                    t!==n&&(t===Z?D():n===Z&&D(!0))
                }),x(l+"."+Z,function(){
                    D()
                })
            },
            getIframe:function(n,i){
                var o=n.src,r=t.st.iframe;
                e.each(r.patterns,function(){
                    return o.indexOf(this.index)>-1?(this.id&&(o="string"==typeof this.id?o.substr(o.lastIndexOf(this.id)+this.id.length,o.length):this.id.call(this,o)),o=this.src.replace("%id%",o),!1):void 0
                });
                var a={};
        
                return r.srcAction&&(a[r.srcAction]=o),t._parseMarkup(i,a,n),t.updateStatus("ready"),i
            }
        }
    });
    var K=function(e){
        var n=t.items.length;
        return e>n-1?e-n:0>e?n+e:e
    },Y=function(e,t,n){
        return e.replace(/%curr%/gi,t+1).replace(/%total%/gi,n)
    };
    
    e.magnificPopup.registerModule("gallery",{
        options:{
            enabled:!1,
            arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
            preload:[0,2],
            navigateByImgClick:!0,
            arrows:!0,
            tPrev:"Previous (Left arrow key)",
            tNext:"Next (Right arrow key)",
            tCounter:"%curr% از %total%"
        },
        proto:{
            initGallery:function(){
                var n=t.st.gallery,i=".mfp-gallery",r=Boolean(e.fn.mfpFastClick);
                return t.direction=!0,n&&n.enabled?(a+=" mfp-gallery",x(f+i,function(){
                    n.navigateByImgClick&&t.wrap.on("click"+i,".mfp-img",function(){
                        return t.items.length>1?(t.next(),!1):void 0
                    }),o.on("keydown"+i,function(e){
                        37===e.keyCode?t.prev():39===e.keyCode&&t.next()
                    })
                }),x("UpdateStatus"+i,function(e,n){
                    n.text&&(n.text=Y(n.text,t.currItem.index,t.items.length))
                }),x(p+i,function(e,i,o,r){
                    var a=t.items.length;
                    o.counter=a>1?Y(n.tCounter,r.index,a):""
                }),x("BuildControls"+i,function(){
                    if(t.items.length>1&&n.arrows&&!t.arrowLeft){
                        var i=n.arrowMarkup,o=t.arrowLeft=e(i.replace(/%title%/gi,n.tPrev).replace(/%dir%/gi,"left")).addClass(y),a=t.arrowRight=e(i.replace(/%title%/gi,n.tNext).replace(/%dir%/gi,"right")).addClass(y),s=r?"mfpFastClick":"click";
                        o[s](function(){
                            t.prev()
                        }),a[s](function(){
                            t.next()
                        }),t.isIE7&&(k("b",o[0],!1,!0),k("a",o[0],!1,!0),k("b",a[0],!1,!0),k("a",a[0],!1,!0)),t.container.append(o.add(a))
                    }
                }),x(m+i,function(){
                    t._preloadTimeout&&clearTimeout(t._preloadTimeout),t._preloadTimeout=setTimeout(function(){
                        t.preloadNearbyImages(),t._preloadTimeout=null
                    },16)
                }),x(l+i,function(){
                    o.off(i),t.wrap.off("click"+i),t.arrowLeft&&r&&t.arrowLeft.add(t.arrowRight).destroyMfpFastClick(),t.arrowRight=t.arrowLeft=null
                }),void 0):!1
            },
            next:function(){
                t.direction=!0,t.index=K(t.index+1),t.updateItemHTML()
            },
            prev:function(){
                t.direction=!1,t.index=K(t.index-1),t.updateItemHTML()
            },
            goTo:function(e){
                t.direction=e>=t.index,t.index=e,t.updateItemHTML()
            },
            preloadNearbyImages:function(){
                var e,n=t.st.gallery.preload,i=Math.min(n[0],t.items.length),o=Math.min(n[1],t.items.length);
                for(e=1;(t.direction?o:i)>=e;e++)t._preloadItem(t.index+e);
                for(e=1;(t.direction?i:o)>=e;e++)t._preloadItem(t.index-e)
            },
            _preloadItem:function(n){
                if(n=K(n),!t.items[n].preloaded){
                    var i=t.items[n];
                    i.parsed||(i=t.parseEl(n)),T("LazyLoad",i),"image"===i.type&&(i.img=e('<img class="mfp-img" />').on("load.mfploader",function(){
                        i.hasSize=!0
                    }).on("error.mfploader",function(){
                        i.hasSize=!0,i.loadError=!0,T("LazyLoadError",i)
                    }).attr("src",i.src)),i.preloaded=!0
                }
            }
        }
    });
    var U="retina";
    e.magnificPopup.registerModule(U,{
        options:{
            replaceSrc:function(e){
                return e.src.replace(/\.\w+$/,function(e){
                    return"@2x"+e
                })
            },
            ratio:1
        },
        proto:{
            initRetina:function(){
                if(window.devicePixelRatio>1){
                    var e=t.st.retina,n=e.ratio;
                    n=isNaN(n)?n():n,n>1&&(x("ImageHasSize."+U,function(e,t){
                        t.img.css({
                            "max-width":t.img[0].naturalWidth/n,
                            width:"100%"
                        })
                    }),x("ElementParse."+U,function(t,i){
                        i.src=e.replaceSrc(i,n)
                    }))
                }
            }
        }
    }),function(){
        var t=1e3,n="ontouchstart"in window,i=function(){
            I.off("touchmove"+r+" touchend"+r)
        },o="mfpFastClick",r="."+o;
        e.fn.mfpFastClick=function(o){
            return e(this).each(function(){
                var a,s=e(this);
                if(n){
                    var l,c,d,u,p,f;
                    s.on("touchstart"+r,function(e){
                        u=!1,f=1,p=e.originalEvent?e.originalEvent.touches[0]:e.touches[0],c=p.clientX,d=p.clientY,I.on("touchmove"+r,function(e){
                            p=e.originalEvent?e.originalEvent.touches:e.touches,f=p.length,p=p[0],(Math.abs(p.clientX-c)>10||Math.abs(p.clientY-d)>10)&&(u=!0,i())
                        }).on("touchend"+r,function(e){
                            i(),u||f>1||(a=!0,e.preventDefault(),clearTimeout(l),l=setTimeout(function(){
                                a=!1
                            },t),o())
                        })
                    })
                }
                s.on("click"+r,function(){
                    a||o()
                })
            })
        },e.fn.destroyMfpFastClick=function(){
            e(this).off("touchstart"+r+" click"+r),n&&I.off("touchmove"+r+" touchend"+r)
        }
    }(),_()
})(window.jQuery||window.Zepto);
;/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
/*!
 * EventEmitter v4.2.6 - git.io/ee
 * Oliver Caldwell
 * MIT license
 * @preserve
 */
(function(){
    function EventEmitter(){}
    var proto=EventEmitter.prototype;
    var exports=this;
    var originalGlobalValue=exports.EventEmitter;
    function indexOfListener(listeners,listener){
        var i=listeners.length;
        while(i--){
            if(listeners[i].listener===listener){
                return i;
            }
        }
        return-1;
    }
    function alias(name){
        return function aliasClosure(){
            return this[name].apply(this,arguments);
        };

    }
    proto.getListeners=function getListeners(evt){
        var events=this._getEvents();
        var response;
        var key;
        if(typeof evt==='object'){
            response={};
        
            for(key in events){
                if(events.hasOwnProperty(key)&&evt.test(key)){
                    response[key]=events[key];
                }
            }
        }
        else{
            response=events[evt]||(events[evt]=[]);
        }
        return response;
    };

    proto.flattenListeners=function flattenListeners(listeners){
        var flatListeners=[];
        var i;
        for(i=0;i<listeners.length;i+=1){
            flatListeners.push(listeners[i].listener);
        }
        return flatListeners;
    };

    proto.getListenersAsObject=function getListenersAsObject(evt){
        var listeners=this.getListeners(evt);
        var response;
        if(listeners instanceof Array){
            response={};
        
            response[evt]=listeners;
        }
        return response||listeners;
    };

    proto.addListener=function addListener(evt,listener){
        var listeners=this.getListenersAsObject(evt);
        var listenerIsWrapped=typeof listener==='object';
        var key;
        for(key in listeners){
            if(listeners.hasOwnProperty(key)&&indexOfListener(listeners[key],listener)===-1){
                listeners[key].push(listenerIsWrapped?listener:{
                    listener:listener,
                    once:false
                });
            }
        }
        return this;
    };

    proto.on=alias('addListener');
    proto.addOnceListener=function addOnceListener(evt,listener){
        return this.addListener(evt,{
            listener:listener,
            once:true
        });
    };

    proto.once=alias('addOnceListener');
    proto.defineEvent=function defineEvent(evt){
        this.getListeners(evt);
        return this;
    };

    proto.defineEvents=function defineEvents(evts){
        for(var i=0;i<evts.length;i+=1){
            this.defineEvent(evts[i]);
        }
        return this;
    };

    proto.removeListener=function removeListener(evt,listener){
        var listeners=this.getListenersAsObject(evt);
        var index;
        var key;
        for(key in listeners){
            if(listeners.hasOwnProperty(key)){
                index=indexOfListener(listeners[key],listener);
                if(index!==-1){
                    listeners[key].splice(index,1);
                }
            }
        }
        return this;
    };

    proto.off=alias('removeListener');
    proto.addListeners=function addListeners(evt,listeners){
        return this.manipulateListeners(false,evt,listeners);
    };

    proto.removeListeners=function removeListeners(evt,listeners){
        return this.manipulateListeners(true,evt,listeners);
    };

    proto.manipulateListeners=function manipulateListeners(remove,evt,listeners){
        var i;
        var value;
        var single=remove?this.removeListener:this.addListener;
        var multiple=remove?this.removeListeners:this.addListeners;
        if(typeof evt==='object'&&!(evt instanceof RegExp)){
            for(i in evt){
                if(evt.hasOwnProperty(i)&&(value=evt[i])){
                    if(typeof value==='function'){
                        single.call(this,i,value);
                    }
                    else{
                        multiple.call(this,i,value);
                    }
                }
            }
        }
        else{
            i=listeners.length;
            while(i--){
                single.call(this,evt,listeners[i]);
            }
        }
        return this;
    };

    proto.removeEvent=function removeEvent(evt){
        var type=typeof evt;
        var events=this._getEvents();
        var key;
        if(type==='string'){
            delete events[evt];
        }
        else if(type==='object'){
            for(key in events){
                if(events.hasOwnProperty(key)&&evt.test(key)){
                    delete events[key];
                }
            }
        }
        else{
            delete this._events;
        }
        return this;
    };

    proto.removeAllListeners=alias('removeEvent');
    proto.emitEvent=function emitEvent(evt,args){
        var listeners=this.getListenersAsObject(evt);
        var listener;
        var i;
        var key;
        var response;
        for(key in listeners){
            if(listeners.hasOwnProperty(key)){
                i=listeners[key].length;
                while(i--){
                    listener=listeners[key][i];
                    if(listener.once===true){
                        this.removeListener(evt,listener.listener);
                    }
                    response=listener.listener.apply(this,args||[]);
                    if(response===this._getOnceReturnValue()){
                        this.removeListener(evt,listener.listener);
                    }
                }
            }
        }
        return this;
    };

    proto.trigger=alias('emitEvent');
    proto.emit=function emit(evt){
        var args=Array.prototype.slice.call(arguments,1);
        return this.emitEvent(evt,args);
    };

    proto.setOnceReturnValue=function setOnceReturnValue(value){
        this._onceReturnValue=value;
        return this;
    };

    proto._getOnceReturnValue=function _getOnceReturnValue(){
        if(this.hasOwnProperty('_onceReturnValue')){
            return this._onceReturnValue;
        }
        else{
            return true;
        }
    };

    proto._getEvents=function _getEvents(){
        return this._events||(this._events={});
    };

    EventEmitter.noConflict=function noConflict(){
        exports.EventEmitter=originalGlobalValue;
        return EventEmitter;
    };

    if(typeof define==='function'&&define.amd){
        define('eventEmitter/EventEmitter',[],function(){
            return EventEmitter;
        });
    }
    else if(typeof module==='object'&&module.exports){
        module.exports=EventEmitter;
    }
    else{
        this.EventEmitter=EventEmitter;
    }
}.call(this));
/*!
 * eventie v1.0.4
 * event binding helper
 *   eventie.bind( elem, 'click', myFn )
 *   eventie.unbind( elem, 'click', myFn )
 */
(function(window){
    var docElem=document.documentElement;
    var bind=function(){};
    
    function getIEEvent(obj){
        var event=window.event;
        event.target=event.target||event.srcElement||obj;
        return event;
    }
    if(docElem.addEventListener){
        bind=function(obj,type,fn){
            obj.addEventListener(type,fn,false);
        };
    
    }else if(docElem.attachEvent){
        bind=function(obj,type,fn){
            obj[type+fn]=fn.handleEvent?function(){
                var event=getIEEvent(obj);
                fn.handleEvent.call(fn,event);
            }:function(){
                var event=getIEEvent(obj);
                fn.call(obj,event);
            };
        
            obj.attachEvent("on"+type,obj[type+fn]);
        };

    }
    var unbind=function(){};
    
    if(docElem.removeEventListener){
        unbind=function(obj,type,fn){
            obj.removeEventListener(type,fn,false);
        };

    }else if(docElem.detachEvent){
        unbind=function(obj,type,fn){
            obj.detachEvent("on"+type,obj[type+fn]);
            try{
                delete obj[type+fn];
            }catch(err){
                obj[type+fn]=undefined;
            }
        };

    }
    var eventie={
        bind:bind,
        unbind:unbind
    };

    if(typeof define==='function'&&define.amd){
        define('eventie/eventie',eventie);
    }else{
        window.eventie=eventie;
    }
})(this);
/*!
 * imagesLoaded v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(window,factory){
    if(typeof define==='function'&&define.amd){
        define(['eventEmitter/EventEmitter','eventie/eventie'],function(EventEmitter,eventie){
            return factory(window,EventEmitter,eventie);
        });
    }else if(typeof exports==='object'){
        module.exports=factory(window,require('wolfy87-eventemitter'),require('eventie'));
    }else{
        window.imagesLoaded=factory(window,window.EventEmitter,window.eventie);
    }
})(window,function factory(window,EventEmitter,eventie){
    var $=window.jQuery;
    var console=window.console;
    var hasConsole=typeof console!=='undefined';
    function extend(a,b){
        for(var prop in b){
            a[prop]=b[prop];
        }
        return a;
    }
    var objToString=Object.prototype.toString;
    function isArray(obj){
        return objToString.call(obj)==='[object Array]';
    }
    function makeArray(obj){
        var ary=[];
        if(isArray(obj)){
            ary=obj;
        }else if(typeof obj.length==='number'){
            for(var i=0,len=obj.length;i<len;i++){
                ary.push(obj[i]);
            }
        }else{
            ary.push(obj);
        }
        return ary;
    }
    function ImagesLoaded(elem,options,onAlways){
        if(!(this instanceof ImagesLoaded)){
            return new ImagesLoaded(elem,options);
        }
        if(typeof elem==='string'){
            elem=document.querySelectorAll(elem);
        }
        this.elements=makeArray(elem);
        this.options=extend({},this.options);
        if(typeof options==='function'){
            onAlways=options;
        }else{
            extend(this.options,options);
        }
        if(onAlways){
            this.on('always',onAlways);
        }
        this.getImages();
        if($){
            this.jqDeferred=new $.Deferred();
        }
        var _this=this;
        setTimeout(function(){
            _this.check();
        });
    }
    ImagesLoaded.prototype=new EventEmitter();
    ImagesLoaded.prototype.options={};
    
    ImagesLoaded.prototype.getImages=function(){
        this.images=[];
        for(var i=0,len=this.elements.length;i<len;i++){
            var elem=this.elements[i];
            if(elem.nodeName==='IMG'){
                this.addImage(elem);
            }
            var nodeType=elem.nodeType;
            if(!nodeType||!(nodeType===1||nodeType===9||nodeType===11)){
                continue;
            }
            var childElems=elem.querySelectorAll('img');
            for(var j=0,jLen=childElems.length;j<jLen;j++){
                var img=childElems[j];
                this.addImage(img);
            }
        }
    };

    ImagesLoaded.prototype.addImage=function(img){
        var loadingImage=new LoadingImage(img);
        this.images.push(loadingImage);
    };

    ImagesLoaded.prototype.check=function(){
        var _this=this;
        var checkedCount=0;
        var length=this.images.length;
        this.hasAnyBroken=false;
        if(!length){
            this.complete();
            return;
        }
        function onConfirm(image,message){
            if(_this.options.debug&&hasConsole){
                console.log('confirm',image,message);
            }
            _this.progress(image);
            checkedCount++;
            if(checkedCount===length){
                _this.complete();
            }
            return true;
        }
        for(var i=0;i<length;i++){
            var loadingImage=this.images[i];
            loadingImage.on('confirm',onConfirm);
            loadingImage.check();
        }
    };
    
    ImagesLoaded.prototype.progress=function(image){
        this.hasAnyBroken=this.hasAnyBroken||!image.isLoaded;
        var _this=this;
        setTimeout(function(){
            _this.emit('progress',_this,image);
            if(_this.jqDeferred&&_this.jqDeferred.notify){
                _this.jqDeferred.notify(_this,image);
            }
        });
    };

    ImagesLoaded.prototype.complete=function(){
        var eventName=this.hasAnyBroken?'fail':'done';
        this.isComplete=true;
        var _this=this;
        setTimeout(function(){
            _this.emit(eventName,_this);
            _this.emit('always',_this);
            if(_this.jqDeferred){
                var jqMethod=_this.hasAnyBroken?'reject':'resolve';
                _this.jqDeferred[jqMethod](_this);
            }
        });
    };

    if($){
        $.fn.imagesLoaded=function(options,callback){
            var instance=new ImagesLoaded(this,options,callback);
            return instance.jqDeferred.promise($(this));
        };

    }
    function LoadingImage(img){
        this.img=img;
    }
    LoadingImage.prototype=new EventEmitter();
    LoadingImage.prototype.check=function(){
        var resource=cache[this.img.src]||new Resource(this.img.src);
        if(resource.isConfirmed){
            this.confirm(resource.isLoaded,'cached was confirmed');
            return;
        }
        if(this.img.complete&&this.img.naturalWidth!==undefined){
            this.confirm(this.img.naturalWidth!==0,'naturalWidth');
            return;
        }
        var _this=this;
        resource.on('confirm',function(resrc,message){
            _this.confirm(resrc.isLoaded,message);
            return true;
        });
        resource.check();
    };

    LoadingImage.prototype.confirm=function(isLoaded,message){
        this.isLoaded=isLoaded;
        this.emit('confirm',this,message);
    };

    var cache={};

    function Resource(src){
        this.src=src;
        cache[src]=this;
    }
    Resource.prototype=new EventEmitter();
    Resource.prototype.check=function(){
        if(this.isChecked){
            return;
        }
        var proxyImage=new Image();
        eventie.bind(proxyImage,'load',this);
        eventie.bind(proxyImage,'error',this);
        proxyImage.src=this.src;
        this.isChecked=true;
    };

    Resource.prototype.handleEvent=function(event){
        var method='on'+event.type;
        if(this[method]){
            this[method](event);
        }
    };

    Resource.prototype.onload=function(event){
        this.confirm(true,'onload');
        this.unbindProxyEvents(event);
    };

    Resource.prototype.onerror=function(event){
        this.confirm(false,'onerror');
        this.unbindProxyEvents(event);
    };

    Resource.prototype.confirm=function(isLoaded,message){
        this.isConfirmed=true;
        this.isLoaded=isLoaded;
        this.emit('confirm',this,message);
    };

    Resource.prototype.unbindProxyEvents=function(event){
        eventie.unbind(event.target,'load',this);
        eventie.unbind(event.target,'error',this);
    };

    return ImagesLoaded;
});
;
/*!
 * Masonry PACKAGED v3.1.5
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */
!function(a){
    function b(){}
    function c(a){
        function c(b){
            b.prototype.option||(b.prototype.option=function(b){
                a.isPlainObject(b)&&(this.options=a.extend(!0,this.options,b))
            })
        }
        function e(b,c){
            a.fn[b]=function(e){
                if("string"==typeof e){
                    for(var g=d.call(arguments,1),h=0,i=this.length;i>h;h++){
                        var j=this[h],k=a.data(j,b);
                        if(k)if(a.isFunction(k[e])&&"_"!==e.charAt(0)){
                            var l=k[e].apply(k,g);
                            if(void 0!==l)return l
                        }else f("no such method '"+e+"' for "+b+" instance");else f("cannot call methods on "+b+" prior to initialization; attempted to call '"+e+"'")
                    }
                    return this
                }
                return this.each(function(){
                    var d=a.data(this,b);
                    d?(d.option(e),d._init()):(d=new c(this,e),a.data(this,b,d))
                })
            }
        }
        if(a){
            var f="undefined"==typeof console?b:function(a){
                console.error(a)
            };
            
            return a.bridget=function(a,b){
                c(b),e(a,b)
            },a.bridget
        }
    }
    var d=Array.prototype.slice;
    "function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],c):c(a.jQuery)
}(window),function(a){
    function b(b){
        var c=a.event;
        return c.target=c.target||c.srcElement||b,c
    }
    var c=document.documentElement,d=function(){};
    
    c.addEventListener?d=function(a,b,c){
        a.addEventListener(b,c,!1)
    }:c.attachEvent&&(d=function(a,c,d){
        a[c+d]=d.handleEvent?function(){
            var c=b(a);
            d.handleEvent.call(d,c)
        }:function(){
            var c=b(a);
            d.call(a,c)
        },a.attachEvent("on"+c,a[c+d])
    });
    var e=function(){};
    
    c.removeEventListener?e=function(a,b,c){
        a.removeEventListener(b,c,!1)
    }:c.detachEvent&&(e=function(a,b,c){
        a.detachEvent("on"+b,a[b+c]);
        try{
            delete a[b+c]
        }catch(d){
            a[b+c]=void 0
        }
    });
    var f={
        bind:d,
        unbind:e
    };

    "function"==typeof define&&define.amd?define("eventie/eventie",f):"object"==typeof exports?module.exports=f:a.eventie=f
}(this),function(a){
    function b(a){
        "function"==typeof a&&(b.isReady?a():f.push(a))
    }
    function c(a){
        var c="readystatechange"===a.type&&"complete"!==e.readyState;
        if(!b.isReady&&!c){
            b.isReady=!0;
            for(var d=0,g=f.length;g>d;d++){
                var h=f[d];
                h()
            }
        }
    }
    function d(d){
        return d.bind(e,"DOMContentLoaded",c),d.bind(e,"readystatechange",c),d.bind(a,"load",c),b
    }
    var e=a.document,f=[];
    b.isReady=!1,"function"==typeof define&&define.amd?(b.isReady="function"==typeof requirejs,define("doc-ready/doc-ready",["eventie/eventie"],d)):a.docReady=d(a.eventie)
}(this),function(){
    function a(){}
    function b(a,b){
        for(var c=a.length;c--;)if(a[c].listener===b)return c;return-1
    }
    function c(a){
        return function(){
            return this[a].apply(this,arguments)
        }
    }
    var d=a.prototype,e=this,f=e.EventEmitter;
    d.getListeners=function(a){
        var b,c,d=this._getEvents();
        if(a instanceof RegExp){
            b={};
        
            for(c in d)d.hasOwnProperty(c)&&a.test(c)&&(b[c]=d[c])
        }else b=d[a]||(d[a]=[]);
        return b
    },d.flattenListeners=function(a){
        var b,c=[];
        for(b=0;b<a.length;b+=1)c.push(a[b].listener);
        return c
    },d.getListenersAsObject=function(a){
        var b,c=this.getListeners(a);
        return c instanceof Array&&(b={},b[a]=c),b||c
    },d.addListener=function(a,c){
        var d,e=this.getListenersAsObject(a),f="object"==typeof c;
        for(d in e)e.hasOwnProperty(d)&&-1===b(e[d],c)&&e[d].push(f?c:{
            listener:c,
            once:!1
        });return this
    },d.on=c("addListener"),d.addOnceListener=function(a,b){
        return this.addListener(a,{
            listener:b,
            once:!0
        })
    },d.once=c("addOnceListener"),d.defineEvent=function(a){
        return this.getListeners(a),this
    },d.defineEvents=function(a){
        for(var b=0;b<a.length;b+=1)this.defineEvent(a[b]);
        return this
    },d.removeListener=function(a,c){
        var d,e,f=this.getListenersAsObject(a);
        for(e in f)f.hasOwnProperty(e)&&(d=b(f[e],c),-1!==d&&f[e].splice(d,1));return this
    },d.off=c("removeListener"),d.addListeners=function(a,b){
        return this.manipulateListeners(!1,a,b)
    },d.removeListeners=function(a,b){
        return this.manipulateListeners(!0,a,b)
    },d.manipulateListeners=function(a,b,c){
        var d,e,f=a?this.removeListener:this.addListener,g=a?this.removeListeners:this.addListeners;
        if("object"!=typeof b||b instanceof RegExp)for(d=c.length;d--;)f.call(this,b,c[d]);else for(d in b)b.hasOwnProperty(d)&&(e=b[d])&&("function"==typeof e?f.call(this,d,e):g.call(this,d,e));return this
    },d.removeEvent=function(a){
        var b,c=typeof a,d=this._getEvents();
        if("string"===c)delete d[a];
        else if(a instanceof RegExp)for(b in d)d.hasOwnProperty(b)&&a.test(b)&&delete d[b];else delete this._events;
        return this
    },d.removeAllListeners=c("removeEvent"),d.emitEvent=function(a,b){
        var c,d,e,f,g=this.getListenersAsObject(a);
        for(e in g)if(g.hasOwnProperty(e))for(d=g[e].length;d--;)c=g[e][d],c.once===!0&&this.removeListener(a,c.listener),f=c.listener.apply(this,b||[]),f===this._getOnceReturnValue()&&this.removeListener(a,c.listener);return this
    },d.trigger=c("emitEvent"),d.emit=function(a){
        var b=Array.prototype.slice.call(arguments,1);
        return this.emitEvent(a,b)
    },d.setOnceReturnValue=function(a){
        return this._onceReturnValue=a,this
    },d._getOnceReturnValue=function(){
        return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0
    },d._getEvents=function(){
        return this._events||(this._events={})
    },a.noConflict=function(){
        return e.EventEmitter=f,a
    },"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){
        return a
    }):"object"==typeof module&&module.exports?module.exports=a:this.EventEmitter=a
}.call(this),function(a){
    function b(a){
        if(a){
            if("string"==typeof d[a])return a;
            a=a.charAt(0).toUpperCase()+a.slice(1);
            for(var b,e=0,f=c.length;f>e;e++)if(b=c[e]+a,"string"==typeof d[b])return b
        }
    }
    var c="Webkit Moz ms Ms O".split(" "),d=document.documentElement.style;
    "function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){
        return b
    }):"object"==typeof exports?module.exports=b:a.getStyleProperty=b
}(window),function(a){
    function b(a){
        var b=parseFloat(a),c=-1===a.indexOf("%")&&!isNaN(b);
        return c&&b
    }
    function c(){
        for(var a={
            width:0,
            height:0,
            innerWidth:0,
            innerHeight:0,
            outerWidth:0,
            outerHeight:0
        },b=0,c=g.length;c>b;b++){
            var d=g[b];
            a[d]=0
        }
        return a
    }
    function d(a){
        function d(a){
            if("string"==typeof a&&(a=document.querySelector(a)),a&&"object"==typeof a&&a.nodeType){
                var d=f(a);
                if("none"===d.display)return c();
                var e={};
                
                e.width=a.offsetWidth,e.height=a.offsetHeight;
                for(var k=e.isBorderBox=!(!j||!d[j]||"border-box"!==d[j]),l=0,m=g.length;m>l;l++){
                    var n=g[l],o=d[n];
                    o=h(a,o);
                    var p=parseFloat(o);
                    e[n]=isNaN(p)?0:p
                }
                var q=e.paddingLeft+e.paddingRight,r=e.paddingTop+e.paddingBottom,s=e.marginLeft+e.marginRight,t=e.marginTop+e.marginBottom,u=e.borderLeftWidth+e.borderRightWidth,v=e.borderTopWidth+e.borderBottomWidth,w=k&&i,x=b(d.width);
                x!==!1&&(e.width=x+(w?0:q+u));
                var y=b(d.height);
                return y!==!1&&(e.height=y+(w?0:r+v)),e.innerWidth=e.width-(q+u),e.innerHeight=e.height-(r+v),e.outerWidth=e.width+s,e.outerHeight=e.height+t,e
            }
        }
        function h(a,b){
            if(e||-1===b.indexOf("%"))return b;
            var c=a.style,d=c.left,f=a.runtimeStyle,g=f&&f.left;
            return g&&(f.left=a.currentStyle.left),c.left=b,b=c.pixelLeft,c.left=d,g&&(f.left=g),b
        }
        var i,j=a("boxSizing");
        return function(){
            if(j){
                var a=document.createElement("div");
                a.style.width="200px",a.style.padding="1px 2px 3px 4px",a.style.borderStyle="solid",a.style.borderWidth="1px 2px 3px 4px",a.style[j]="border-box";
                var c=document.body||document.documentElement;
                c.appendChild(a);
                var d=f(a);
                i=200===b(d.width),c.removeChild(a)
            }
        }(),d
    }
    var e=a.getComputedStyle,f=e?function(a){
        return e(a,null)
    }:function(a){
        return a.currentStyle
    },g=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];
    "function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],d):"object"==typeof exports?module.exports=d(require("get-style-property")):a.getSize=d(a.getStyleProperty)
}(window),function(a,b){
    function c(a,b){
        return a[h](b)
    }
    function d(a){
        if(!a.parentNode){
            var b=document.createDocumentFragment();
            b.appendChild(a)
        }
    }
    function e(a,b){
        d(a);
        for(var c=a.parentNode.querySelectorAll(b),e=0,f=c.length;f>e;e++)if(c[e]===a)return!0;return!1
    }
    function f(a,b){
        return d(a),c(a,b)
    }
    var g,h=function(){
        if(b.matchesSelector)return"matchesSelector";
        for(var a=["webkit","moz","ms","o"],c=0,d=a.length;d>c;c++){
            var e=a[c],f=e+"MatchesSelector";
            if(b[f])return f
        }
    }();
    if(h){
        var i=document.createElement("div"),j=c(i,"div");
        g=j?c:f
    }else g=e;
    "function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){
        return g
    }):window.matchesSelector=g
}(this,Element.prototype),function(a){
    function b(a,b){
        for(var c in b)a[c]=b[c];return a
    }
    function c(a){
        for(var b in a)return!1;return b=null,!0
    }
    function d(a){
        return a.replace(/([A-Z])/g,function(a){
            return"-"+a.toLowerCase()
        })
    }
    function e(a,e,f){
        function h(a,b){
            a&&(this.element=a,this.layout=b,this.position={
                x:0,
                y:0
            },this._create())
        }
        var i=f("transition"),j=f("transform"),k=i&&j,l=!!f("perspective"),m={
            WebkitTransition:"webkitTransitionEnd",
            MozTransition:"transitionend",
            OTransition:"otransitionend",
            transition:"transitionend"
        }
        [i],n=["transform","transition","transitionDuration","transitionProperty"],o=function(){
            for(var a={},b=0,c=n.length;c>b;b++){
                var d=n[b],e=f(d);
                e&&e!==d&&(a[d]=e)
            }
            return a
        }();
        b(h.prototype,a.prototype),h.prototype._create=function(){
            this._transn={
                ingProperties:{},
                clean:{},
                onEnd:{}
            },this.css({
                position:"absolute"
            })
        },h.prototype.handleEvent=function(a){
            var b="on"+a.type;
            this[b]&&this[b](a)
        },h.prototype.getSize=function(){
            this.size=e(this.element)
        },h.prototype.css=function(a){
            var b=this.element.style;
            for(var c in a){
                var d=o[c]||c;
                b[d]=a[c]
            }
        },h.prototype.getPosition=function(){
            var a=g(this.element),b=this.layout.options,c=b.isOriginLeft,d=b.isOriginTop,e=parseInt(a[c?"left":"right"],10),f=parseInt(a[d?"top":"bottom"],10);
            e=isNaN(e)?0:e,f=isNaN(f)?0:f;
            var h=this.layout.size;
            e-=c?h.paddingLeft:h.paddingRight,f-=d?h.paddingTop:h.paddingBottom,this.position.x=e,this.position.y=f
        },h.prototype.layoutPosition=function(){
            var a=this.layout.size,b=this.layout.options,c={};
    
            b.isOriginLeft?(c.left=this.position.x+a.paddingLeft+"px",c.right=""):(c.right=this.position.x+a.paddingRight+"px",c.left=""),b.isOriginTop?(c.top=this.position.y+a.paddingTop+"px",c.bottom=""):(c.bottom=this.position.y+a.paddingBottom+"px",c.top=""),this.css(c),this.emitEvent("layout",[this])
        };
    
        var p=l?function(a,b){
            return"translate3d("+a+"px, "+b+"px, 0)"
        }:function(a,b){
            return"translate("+a+"px, "+b+"px)"
        };
    
        h.prototype._transitionTo=function(a,b){
            this.getPosition();
            var c=this.position.x,d=this.position.y,e=parseInt(a,10),f=parseInt(b,10),g=e===this.position.x&&f===this.position.y;
            if(this.setPosition(a,b),g&&!this.isTransitioning)return void this.layoutPosition();
            var h=a-c,i=b-d,j={},k=this.layout.options;
            h=k.isOriginLeft?h:-h,i=k.isOriginTop?i:-i,j.transform=p(h,i),this.transition({
                to:j,
                onTransitionEnd:{
                    transform:this.layoutPosition
                },
                isCleaning:!0
            })
        },h.prototype.goTo=function(a,b){
            this.setPosition(a,b),this.layoutPosition()
        },h.prototype.moveTo=k?h.prototype._transitionTo:h.prototype.goTo,h.prototype.setPosition=function(a,b){
            this.position.x=parseInt(a,10),this.position.y=parseInt(b,10)
        },h.prototype._nonTransition=function(a){
            this.css(a.to),a.isCleaning&&this._removeStyles(a.to);
            for(var b in a.onTransitionEnd)a.onTransitionEnd[b].call(this)
        },h.prototype._transition=function(a){
            if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(a);
            var b=this._transn;
            for(var c in a.onTransitionEnd)b.onEnd[c]=a.onTransitionEnd[c];for(c in a.to)b.ingProperties[c]=!0,a.isCleaning&&(b.clean[c]=!0);if(a.from){
                this.css(a.from);
                var d=this.element.offsetHeight;
                d=null
            }
            this.enableTransition(a.to),this.css(a.to),this.isTransitioning=!0
        };
    
        var q=j&&d(j)+",opacity";
        h.prototype.enableTransition=function(){
            this.isTransitioning||(this.css({
                transitionProperty:q,
                transitionDuration:this.layout.options.transitionDuration
            }),this.element.addEventListener(m,this,!1))
        },h.prototype.transition=h.prototype[i?"_transition":"_nonTransition"],h.prototype.onwebkitTransitionEnd=function(a){
            this.ontransitionend(a)
        },h.prototype.onotransitionend=function(a){
            this.ontransitionend(a)
        };
    
        var r={
            "-webkit-transform":"transform",
            "-moz-transform":"transform",
            "-o-transform":"transform"
        };

        h.prototype.ontransitionend=function(a){
            if(a.target===this.element){
                var b=this._transn,d=r[a.propertyName]||a.propertyName;
                if(delete b.ingProperties[d],c(b.ingProperties)&&this.disableTransition(),d in b.clean&&(this.element.style[a.propertyName]="",delete b.clean[d]),d in b.onEnd){
                    var e=b.onEnd[d];
                    e.call(this),delete b.onEnd[d]
                }
                this.emitEvent("transitionEnd",[this])
            }
        },h.prototype.disableTransition=function(){
            this.removeTransitionStyles(),this.element.removeEventListener(m,this,!1),this.isTransitioning=!1
        },h.prototype._removeStyles=function(a){
            var b={};
    
            for(var c in a)b[c]="";this.css(b)
        };
    
        var s={
            transitionProperty:"",
            transitionDuration:""
        };

        return h.prototype.removeTransitionStyles=function(){
            this.css(s)
        },h.prototype.removeElem=function(){
            this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])
        },h.prototype.remove=function(){
            if(!i||!parseFloat(this.layout.options.transitionDuration))return void this.removeElem();
            var a=this;
            this.on("transitionEnd",function(){
                return a.removeElem(),!0
            }),this.hide()
        },h.prototype.reveal=function(){
            delete this.isHidden,this.css({
                display:""
            });
            var a=this.layout.options;
            this.transition({
                from:a.hiddenStyle,
                to:a.visibleStyle,
                isCleaning:!0
            })
        },h.prototype.hide=function(){
            this.isHidden=!0,this.css({
                display:""
            });
            var a=this.layout.options;
            this.transition({
                from:a.visibleStyle,
                to:a.hiddenStyle,
                isCleaning:!0,
                onTransitionEnd:{
                    opacity:function(){
                        this.isHidden&&this.css({
                            display:"none"
                        })
                    }
                }
            })
        },h.prototype.destroy=function(){
            this.css({
                position:"",
                left:"",
                right:"",
                top:"",
                bottom:"",
                transition:"",
                transform:""
            })
        },h
    }
    var f=a.getComputedStyle,g=f?function(a){
        return f(a,null)
    }:function(a){
        return a.currentStyle
    };
    
    "function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],e):(a.Outlayer={},a.Outlayer.Item=e(a.EventEmitter,a.getSize,a.getStyleProperty))
}(window),function(a){
    function b(a,b){
        for(var c in b)a[c]=b[c];return a
    }
    function c(a){
        return"[object Array]"===l.call(a)
    }
    function d(a){
        var b=[];
        if(c(a))b=a;
        else if(a&&"number"==typeof a.length)for(var d=0,e=a.length;e>d;d++)b.push(a[d]);else b.push(a);
        return b
    }
    function e(a,b){
        var c=n(b,a);
        -1!==c&&b.splice(c,1)
    }
    function f(a){
        return a.replace(/(.)([A-Z])/g,function(a,b,c){
            return b+"-"+c
        }).toLowerCase()
    }
    function g(c,g,l,n,o,p){
        function q(a,c){
            if("string"==typeof a&&(a=h.querySelector(a)),!a||!m(a))return void(i&&i.error("Bad "+this.constructor.namespace+" element: "+a));
            this.element=a,this.options=b({},this.constructor.defaults),this.option(c);
            var d=++r;
            this.element.outlayerGUID=d,s[d]=this,this._create(),this.options.isInitLayout&&this.layout()
        }
        var r=0,s={};
        
        return q.namespace="outlayer",q.Item=p,q.defaults={
            containerStyle:{
                position:"relative"
            },
            isInitLayout:!0,
            isOriginLeft:!0,
            isOriginTop:!0,
            isResizeBound:!0,
            isResizingContainer:!0,
            transitionDuration:"0.4s",
            hiddenStyle:{
                opacity:0,
                transform:"scale(0.001)"
            },
            visibleStyle:{
                opacity:1,
                transform:"scale(1)"
            }
        },b(q.prototype,l.prototype),q.prototype.option=function(a){
            b(this.options,a)
        },q.prototype._create=function(){
            this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),b(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()
        },q.prototype.reloadItems=function(){
            this.items=this._itemize(this.element.children)
        },q.prototype._itemize=function(a){
            for(var b=this._filterFindItemElements(a),c=this.constructor.Item,d=[],e=0,f=b.length;f>e;e++){
                var g=b[e],h=new c(g,this);
                d.push(h)
            }
            return d
        },q.prototype._filterFindItemElements=function(a){
            a=d(a);
            for(var b=this.options.itemSelector,c=[],e=0,f=a.length;f>e;e++){
                var g=a[e];
                if(m(g))if(b){
                    o(g,b)&&c.push(g);
                    for(var h=g.querySelectorAll(b),i=0,j=h.length;j>i;i++)c.push(h[i])
                }else c.push(g)
            }
            return c
        },q.prototype.getItemElements=function(){
            for(var a=[],b=0,c=this.items.length;c>b;b++)a.push(this.items[b].element);
            return a
        },q.prototype.layout=function(){
            this._resetLayout(),this._manageStamps();
            var a=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;
            this.layoutItems(this.items,a),this._isLayoutInited=!0
        },q.prototype._init=q.prototype.layout,q.prototype._resetLayout=function(){
            this.getSize()
        },q.prototype.getSize=function(){
            this.size=n(this.element)
        },q.prototype._getMeasurement=function(a,b){
            var c,d=this.options[a];
            d?("string"==typeof d?c=this.element.querySelector(d):m(d)&&(c=d),this[a]=c?n(c)[b]:d):this[a]=0
        },q.prototype.layoutItems=function(a,b){
            a=this._getItemsForLayout(a),this._layoutItems(a,b),this._postLayout()
        },q.prototype._getItemsForLayout=function(a){
            for(var b=[],c=0,d=a.length;d>c;c++){
                var e=a[c];
                e.isIgnored||b.push(e)
            }
            return b
        },q.prototype._layoutItems=function(a,b){
            function c(){
                d.emitEvent("layoutComplete",[d,a])
            }
            var d=this;
            if(!a||!a.length)return void c();
            this._itemsOn(a,"layout",c);
            for(var e=[],f=0,g=a.length;g>f;f++){
                var h=a[f],i=this._getItemLayoutPosition(h);
                i.item=h,i.isInstant=b||h.isLayoutInstant,e.push(i)
            }
            this._processLayoutQueue(e)
        },q.prototype._getItemLayoutPosition=function(){
            return{
                x:0,
                y:0
            }
        },q.prototype._processLayoutQueue=function(a){
            for(var b=0,c=a.length;c>b;b++){
                var d=a[b];
                this._positionItem(d.item,d.x,d.y,d.isInstant)
            }
        },q.prototype._positionItem=function(a,b,c,d){
            d?a.goTo(b,c):a.moveTo(b,c)
        },q.prototype._postLayout=function(){
            this.resizeContainer()
        },q.prototype.resizeContainer=function(){
            if(this.options.isResizingContainer){
                var a=this._getContainerSize();
                a&&(this._setContainerMeasure(a.width,!0),this._setContainerMeasure(a.height,!1))
            }
        },q.prototype._getContainerSize=k,q.prototype._setContainerMeasure=function(a,b){
            if(void 0!==a){
                var c=this.size;
                c.isBorderBox&&(a+=b?c.paddingLeft+c.paddingRight+c.borderLeftWidth+c.borderRightWidth:c.paddingBottom+c.paddingTop+c.borderTopWidth+c.borderBottomWidth),a=Math.max(a,0),this.element.style[b?"width":"height"]=a+"px"
            }
        },q.prototype._itemsOn=function(a,b,c){
            function d(){
                return e++,e===f&&c.call(g),!0
            }
            for(var e=0,f=a.length,g=this,h=0,i=a.length;i>h;h++){
                var j=a[h];
                j.on(b,d)
            }
        },q.prototype.ignore=function(a){
            var b=this.getItem(a);
            b&&(b.isIgnored=!0)
        },q.prototype.unignore=function(a){
            var b=this.getItem(a);
            b&&delete b.isIgnored
        },q.prototype.stamp=function(a){
            if(a=this._find(a)){
                this.stamps=this.stamps.concat(a);
                for(var b=0,c=a.length;c>b;b++){
                    var d=a[b];
                    this.ignore(d)
                }
            }
        },q.prototype.unstamp=function(a){
            if(a=this._find(a))for(var b=0,c=a.length;c>b;b++){
                var d=a[b];
                e(d,this.stamps),this.unignore(d)
            }
        },q.prototype._find=function(a){
            return a?("string"==typeof a&&(a=this.element.querySelectorAll(a)),a=d(a)):void 0
        },q.prototype._manageStamps=function(){
            if(this.stamps&&this.stamps.length){
                this._getBoundingRect();
                for(var a=0,b=this.stamps.length;b>a;a++){
                    var c=this.stamps[a];
                    this._manageStamp(c)
                }
            }
        },q.prototype._getBoundingRect=function(){
            var a=this.element.getBoundingClientRect(),b=this.size;
            this._boundingRect={
                left:a.left+b.paddingLeft+b.borderLeftWidth,
                top:a.top+b.paddingTop+b.borderTopWidth,
                right:a.right-(b.paddingRight+b.borderRightWidth),
                bottom:a.bottom-(b.paddingBottom+b.borderBottomWidth)
            }
        },q.prototype._manageStamp=k,q.prototype._getElementOffset=function(a){
            var b=a.getBoundingClientRect(),c=this._boundingRect,d=n(a),e={
                left:b.left-c.left-d.marginLeft,
                top:b.top-c.top-d.marginTop,
                right:c.right-b.right-d.marginRight,
                bottom:c.bottom-b.bottom-d.marginBottom
            };
        
            return e
        },q.prototype.handleEvent=function(a){
            var b="on"+a.type;
            this[b]&&this[b](a)
        },q.prototype.bindResize=function(){
            this.isResizeBound||(c.bind(a,"resize",this),this.isResizeBound=!0)
        },q.prototype.unbindResize=function(){
            this.isResizeBound&&c.unbind(a,"resize",this),this.isResizeBound=!1
        },q.prototype.onresize=function(){
            function a(){
                b.resize(),delete b.resizeTimeout
            }
            this.resizeTimeout&&clearTimeout(this.resizeTimeout);
            var b=this;
            this.resizeTimeout=setTimeout(a,100)
        },q.prototype.resize=function(){
            this.isResizeBound&&this.needsResizeLayout()&&this.layout()
        },q.prototype.needsResizeLayout=function(){
            var a=n(this.element),b=this.size&&a;
            return b&&a.innerWidth!==this.size.innerWidth
        },q.prototype.addItems=function(a){
            var b=this._itemize(a);
            return b.length&&(this.items=this.items.concat(b)),b
        },q.prototype.appended=function(a){
            var b=this.addItems(a);
            b.length&&(this.layoutItems(b,!0),this.reveal(b))
        },q.prototype.prepended=function(a){
            var b=this._itemize(a);
            if(b.length){
                var c=this.items.slice(0);
                this.items=b.concat(c),this._resetLayout(),this._manageStamps(),this.layoutItems(b,!0),this.reveal(b),this.layoutItems(c)
            }
        },q.prototype.reveal=function(a){
            var b=a&&a.length;
            if(b)for(var c=0;b>c;c++){
                var d=a[c];
                d.reveal()
            }
        },q.prototype.hide=function(a){
            var b=a&&a.length;
            if(b)for(var c=0;b>c;c++){
                var d=a[c];
                d.hide()
            }
        },q.prototype.getItem=function(a){
            for(var b=0,c=this.items.length;c>b;b++){
                var d=this.items[b];
                if(d.element===a)return d
            }
        },q.prototype.getItems=function(a){
            if(a&&a.length){
                for(var b=[],c=0,d=a.length;d>c;c++){
                    var e=a[c],f=this.getItem(e);
                    f&&b.push(f)
                }
                return b
            }
        },q.prototype.remove=function(a){
            a=d(a);
            var b=this.getItems(a);
            if(b&&b.length){
                this._itemsOn(b,"remove",function(){
                    this.emitEvent("removeComplete",[this,b])
                });
                for(var c=0,f=b.length;f>c;c++){
                    var g=b[c];
                    g.remove(),e(g,this.items)
                }
            }
        },q.prototype.destroy=function(){
            var a=this.element.style;
            a.height="",a.position="",a.width="";
            for(var b=0,c=this.items.length;c>b;b++){
                var d=this.items[b];
                d.destroy()
            }
            this.unbindResize(),delete this.element.outlayerGUID,j&&j.removeData(this.element,this.constructor.namespace)
        },q.data=function(a){
            var b=a&&a.outlayerGUID;
            return b&&s[b]
        },q.create=function(a,c){
            function d(){
                q.apply(this,arguments)
            }
            return Object.create?d.prototype=Object.create(q.prototype):b(d.prototype,q.prototype),d.prototype.constructor=d,d.defaults=b({},q.defaults),b(d.defaults,c),d.prototype.settings={},d.namespace=a,d.data=q.data,d.Item=function(){
                p.apply(this,arguments)
            },d.Item.prototype=new p,g(function(){
                for(var b=f(a),c=h.querySelectorAll(".js-"+b),e="data-"+b+"-options",g=0,k=c.length;k>g;g++){
                    var l,m=c[g],n=m.getAttribute(e);
                    try{
                        l=n&&JSON.parse(n)
                    }catch(o){
                        i&&i.error("Error parsing "+e+" on "+m.nodeName.toLowerCase()+(m.id?"#"+m.id:"")+": "+o);
                        continue
                    }
                    var p=new d(m,l);
                    j&&j.data(m,a,p)
                }
            }),j&&j.bridget&&j.bridget(a,d),d
        },q.Item=p,q
    }
    var h=a.document,i=a.console,j=a.jQuery,k=function(){},l=Object.prototype.toString,m="object"==typeof HTMLElement?function(a){
        return a instanceof HTMLElement
    }:function(a){
        return a&&"object"==typeof a&&1===a.nodeType&&"string"==typeof a.nodeName
    },n=Array.prototype.indexOf?function(a,b){
        return a.indexOf(b)
    }:function(a,b){
        for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1
    };
    
    "function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],g):a.Outlayer=g(a.eventie,a.docReady,a.EventEmitter,a.getSize,a.matchesSelector,a.Outlayer.Item)
}(window),function(a){
    function b(a,b){
        var d=a.create("masonry");
        return d.prototype._resetLayout=function(){
            this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();
            var a=this.cols;
            for(this.colYs=[];a--;)this.colYs.push(0);
            this.maxY=0
        },d.prototype.measureColumns=function(){
            if(this.getContainerWidth(),!this.columnWidth){
                var a=this.items[0],c=a&&a.element;
                this.columnWidth=c&&b(c).outerWidth||this.containerWidth
            }
            this.columnWidth+=this.gutter,this.cols=Math.floor((this.containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)
        },d.prototype.getContainerWidth=function(){
            var a=this.options.isFitWidth?this.element.parentNode:this.element,c=b(a);
            this.containerWidth=c&&c.innerWidth
        },d.prototype._getItemLayoutPosition=function(a){
            a.getSize();
            var b=a.size.outerWidth%this.columnWidth,d=b&&1>b?"round":"ceil",e=Math[d](a.size.outerWidth/this.columnWidth);
            e=Math.min(e,this.cols);
            for(var f=this._getColGroup(e),g=Math.min.apply(Math,f),h=c(f,g),i={
                x:this.columnWidth*h,
                y:g
            },j=g+a.size.outerHeight,k=this.cols+1-f.length,l=0;k>l;l++)this.colYs[h+l]=j;
            return i
        },d.prototype._getColGroup=function(a){
            if(2>a)return this.colYs;
            for(var b=[],c=this.cols+1-a,d=0;c>d;d++){
                var e=this.colYs.slice(d,d+a);
                b[d]=Math.max.apply(Math,e)
            }
            return b
        },d.prototype._manageStamp=function(a){
            var c=b(a),d=this._getElementOffset(a),e=this.options.isOriginLeft?d.left:d.right,f=e+c.outerWidth,g=Math.floor(e/this.columnWidth);
            g=Math.max(0,g);
            var h=Math.floor(f/this.columnWidth);
            h-=f%this.columnWidth?0:1,h=Math.min(this.cols-1,h);
            for(var i=(this.options.isOriginTop?d.top:d.bottom)+c.outerHeight,j=g;h>=j;j++)this.colYs[j]=Math.max(i,this.colYs[j])
        },d.prototype._getContainerSize=function(){
            this.maxY=Math.max.apply(Math,this.colYs);
            var a={
                height:this.maxY
            };
                
            return this.options.isFitWidth&&(a.width=this._getContainerFitWidth()),a
        },d.prototype._getContainerFitWidth=function(){
            for(var a=0,b=this.cols;--b&&0===this.colYs[b];)a++;
            return(this.cols-a)*this.columnWidth-this.gutter
        },d.prototype.needsResizeLayout=function(){
            var a=this.containerWidth;
            return this.getContainerWidth(),a!==this.containerWidth
        },d
    }
    var c=Array.prototype.indexOf?function(a,b){
        return a.indexOf(b)
    }:function(a,b){
        for(var c=0,d=a.length;d>c;c++){
            var e=a[c];
            if(e===b)return c
        }
        return-1
    };
        
    "function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],b):a.Masonry=b(a.Outlayer,a.getSize)
}(window);
;
!function(a,b,c,d){
    function e(b,c){
        this.settings=null,this.options=a.extend({},e.Defaults,c),this.$element=a(b),this.drag=a.extend({},m),this.state=a.extend({},n),this.e=a.extend({},o),this._plugins={},this._supress={},this._current=null,this._speed=null,this._coordinates=[],this._breakpoint=null,this._width=null,this._items=[],this._clones=[],this._mergers=[],this._invalidated={},this._pipe=[],a.each(e.Plugins,a.proxy(function(a,b){
            this._plugins[a[0].toLowerCase()+a.slice(1)]=new b(this)
        },this)),a.each(e.Pipe,a.proxy(function(b,c){
            this._pipe.push({
                filter:c.filter,
                run:a.proxy(c.run,this)
            })
        },this)),this.setup(),this.initialize()
    }
    function f(a){
        if(a.touches!==d)return{
            x:a.touches[0].pageX,
            y:a.touches[0].pageY
        };
            
        if(a.touches===d){
            if(a.pageX!==d)return{
                x:a.pageX,
                y:a.pageY
            };
                
            if(a.pageX===d)return{
                x:a.clientX,
                y:a.clientY
            }
        }
    }
    function g(a){
        var b,d,e=c.createElement("div"),f=a;
        for(b in f)if(d=f[b],"undefined"!=typeof e.style[d])return e=null,[d,b];return[!1]
    }
    function h(){
        return g(["transition","WebkitTransition","MozTransition","OTransition"])[1]
    }
    function i(){
        return g(["transform","WebkitTransform","MozTransform","OTransform","msTransform"])[0]
    }
    function j(){
        return g(["perspective","webkitPerspective","MozPerspective","OPerspective","MsPerspective"])[0]
    }
    function k(){
        return"ontouchstart"in b||!!navigator.msMaxTouchPoints
    }
    function l(){
        return b.navigator.msPointerEnabled
    }
    var m,n,o;
    m={
        start:0,
        startX:0,
        startY:0,
        current:0,
        currentX:0,
        currentY:0,
        offsetX:0,
        offsetY:0,
        distance:null,
        startTime:0,
        endTime:0,
        updatedX:0,
        targetEl:null
    },n={
        isTouch:!1,
        isScrolling:!1,
        isSwiping:!1,
        direction:!1,
        inMotion:!1
    },o={
        _onDragStart:null,
        _onDragMove:null,
        _onDragEnd:null,
        _transitionEnd:null,
        _resizer:null,
        _responsiveCall:null,
        _goToLoop:null,
        _checkVisibile:null
    },e.Defaults={
        items:3,
        loop:!1,
        center:!1,
        mouseDrag:!0,
        touchDrag:!0,
        pullDrag:!0,
        freeDrag:!1,
        margin:0,
        stagePadding:0,
        merge:!1,
        mergeFit:!0,
        autoWidth:!1,
        startPosition:0,
        rtl:!1,
        smartSpeed:250,
        fluidSpeed:!1,
        dragEndSpeed:!1,
        responsive:{},
        responsiveRefreshRate:200,
        responsiveBaseElement:b,
        responsiveClass:!1,
        fallbackEasing:"swing",
        info:!1,
        nestedItemSelector:!1,
        itemElement:"div",
        stageElement:"div",
        themeClass:"owl-theme",
        baseClass:"owl-carousel",
        itemClass:"owl-item",
        centerClass:"center",
        activeClass:"active"
    },e.Width={
        Default:"default",
        Inner:"inner",
        Outer:"outer"
    },e.Plugins={},e.Pipe=[{
        filter:["width","items","settings"],
        run:function(a){
            a.current=this._items&&this._items[this.relative(this._current)]
        }
    },{
        filter:["items","settings"],
        run:function(){
            var a=this._clones,b=this.$stage.children(".cloned");
            (b.length!==a.length||!this.settings.loop&&a.length>0)&&(this.$stage.children(".cloned").remove(),this._clones=[])
        }
    },{
        filter:["items","settings"],
        run:function(){
            var a,b,c=this._clones,d=this._items,e=this.settings.loop?c.length-Math.max(2*this.settings.items,4):0;
            for(a=0,b=Math.abs(e/2);b>a;a++)e>0?(this.$stage.children().eq(d.length+c.length-1).remove(),c.pop(),this.$stage.children().eq(0).remove(),c.pop()):(c.push(c.length/2),this.$stage.append(d[c[c.length-1]].clone().addClass("cloned")),c.push(d.length-1-(c.length-1)/2),this.$stage.prepend(d[c[c.length-1]].clone().addClass("cloned")))
        }
    },{
        filter:["width","items","settings"],
        run:function(){
            var a,b,c,d=this.settings.rtl?1:-1,e=(this.width()/this.settings.items).toFixed(3),f=0;
            for(this._coordinates=[],b=0,c=this._clones.length+this._items.length;c>b;b++)a=this._mergers[this.relative(b)],a=this.settings.mergeFit&&Math.min(a,this.settings.items)||a,f+=(this.settings.autoWidth?this._items[this.relative(b)].width()+this.settings.margin:e*a)*d,this._coordinates.push(f)
        }
    },{
        filter:["width","items","settings"],
        run:function(){
            var b,c,d=(this.width()/this.settings.items).toFixed(3),e={
                width:Math.abs(this._coordinates[this._coordinates.length-1])+2*this.settings.stagePadding,
                "padding-left":this.settings.stagePadding||"",
                "padding-right":this.settings.stagePadding||""
            };
            
            if(this.$stage.css(e),e={
                width:this.settings.autoWidth?"auto":d-this.settings.margin
            },e[this.settings.rtl?"margin-left":"margin-right"]=this.settings.margin,!this.settings.autoWidth&&a.grep(this._mergers,function(a){
                return a>1
            }).length>0)for(b=0,c=this._coordinates.length;c>b;b++)e.width=Math.abs(this._coordinates[b])-Math.abs(this._coordinates[b-1]||0)-this.settings.margin,this.$stage.children().eq(b).css(e);else this.$stage.children().css(e)
        }
    },{
        filter:["width","items","settings"],
        run:function(a){
            a.current&&this.reset(this.$stage.children().index(a.current))
        }
    },{
        filter:["position"],
        run:function(){
            this.animate(this.coordinates(this._current))
        }
    },{
        filter:["width","position","items","settings"],
        run:function(){
            var a,b,c,d,e=this.settings.rtl?1:-1,f=2*this.settings.stagePadding,g=this.coordinates(this.current())+f,h=g+this.width()*e,i=[];
            for(c=0,d=this._coordinates.length;d>c;c++)a=this._coordinates[c-1]||0,b=Math.abs(this._coordinates[c])+f*e,(this.op(a,"<=",g)&&this.op(a,">",h)||this.op(b,"<",g)&&this.op(b,">",h))&&i.push(c);
            this.$stage.children("."+this.settings.activeClass).removeClass(this.settings.activeClass),this.$stage.children(":eq("+i.join("), :eq(")+")").addClass(this.settings.activeClass),this.settings.center&&(this.$stage.children("."+this.settings.centerClass).removeClass(this.settings.centerClass),this.$stage.children().eq(this.current()).addClass(this.settings.centerClass))
        }
    }],e.prototype.initialize=function(){
        if(this.trigger("initialize"),this.$element.addClass(this.settings.baseClass).addClass(this.settings.themeClass).toggleClass("owl-rtl",this.settings.rtl),this.browserSupport(),this.settings.autoWidth&&this.state.imagesLoaded!==!0){
            var b,c,e;
            if(b=this.$element.find("img"),c=this.settings.nestedItemSelector?"."+this.settings.nestedItemSelector:d,e=this.$element.children(c).width(),b.length&&0>=e)return this.preloadAutoWidthImages(b),!1
        }
        this.$element.addClass("owl-loading"),this.$stage=a("<"+this.settings.stageElement+' class="owl-stage"/>').wrap('<div class="owl-stage-outer">'),this.$element.append(this.$stage.parent()),this.replace(this.$element.children().not(this.$stage.parent())),this._width=this.$element.width(),this.refresh(),this.$element.removeClass("owl-loading").addClass("owl-loaded"),this.eventsCall(),this.internalEvents(),this.addTriggerableEvents(),this.trigger("initialized")
    },e.prototype.setup=function(){
        var b=this.viewport(),c=this.options.responsive,d=-1,e=null;
        c?(a.each(c,function(a){
            b>=a&&a>d&&(d=Number(a))
        }),e=a.extend({},this.options,c[d]),delete e.responsive,e.responsiveClass&&this.$element.attr("class",function(a,b){
            return b.replace(/\b owl-responsive-\S+/g,"")
        }).addClass("owl-responsive-"+d)):e=a.extend({},this.options),(null===this.settings||this._breakpoint!==d)&&(this.trigger("change",{
            property:{
                name:"settings",
                value:e
            }
        }),this._breakpoint=d,this.settings=e,this.invalidate("settings"),this.trigger("changed",{
            property:{
                name:"settings",
                value:this.settings
            }
        }))
    },e.prototype.optionsLogic=function(){
        this.$element.toggleClass("owl-center",this.settings.center),this.settings.loop&&this._items.length<this.settings.items&&(this.settings.loop=!1),this.settings.autoWidth&&(this.settings.stagePadding=!1,this.settings.merge=!1)
    },e.prototype.prepare=function(b){
        var c=this.trigger("prepare",{
            content:b
        });
        return c.data||(c.data=a("<"+this.settings.itemElement+"/>").addClass(this.settings.itemClass).append(b)),this.trigger("prepared",{
            content:c.data
        }),c.data
    },e.prototype.update=function(){
        for(var b=0,c=this._pipe.length,d=a.proxy(function(a){
            return this[a]
        },this._invalidated),e={};
        c>b;)(this._invalidated.all||a.grep(this._pipe[b].filter,d).length>0)&&this._pipe[b].run(e),b++;
        this._invalidated={}
    },e.prototype.width=function(a){
        switch(a=a||e.Width.Default){
            case e.Width.Inner:case e.Width.Outer:
                return this._width;
            default:
                return this._width-2*this.settings.stagePadding+this.settings.margin
        }
    },e.prototype.refresh=function(){
        if(0===this._items.length)return!1;
        (new Date).getTime();
        this.trigger("refresh"),this.setup(),this.optionsLogic(),this.$stage.addClass("owl-refresh"),this.update(),this.$stage.removeClass("owl-refresh"),this.state.orientation=b.orientation,this.watchVisibility(),this.trigger("refreshed")
    },e.prototype.eventsCall=function(){
        this.e._onDragStart=a.proxy(function(a){
            this.onDragStart(a)
        },this),this.e._onDragMove=a.proxy(function(a){
            this.onDragMove(a)
        },this),this.e._onDragEnd=a.proxy(function(a){
            this.onDragEnd(a)
        },this),this.e._onResize=a.proxy(function(a){
            this.onResize(a)
        },this),this.e._transitionEnd=a.proxy(function(a){
            this.transitionEnd(a)
        },this),this.e._preventClick=a.proxy(function(a){
            this.preventClick(a)
        },this)
    },e.prototype.onThrottledResize=function(){
        b.clearTimeout(this.resizeTimer),this.resizeTimer=b.setTimeout(this.e._onResize,this.settings.responsiveRefreshRate)
    },e.prototype.onResize=function(){
        return this._items.length?this._width===this.$element.width()?!1:this.trigger("resize").isDefaultPrevented()?!1:(this._width=this.$element.width(),this.invalidate("width"),this.refresh(),void this.trigger("resized")):!1
    },e.prototype.eventsRouter=function(a){
        var b=a.type;
        "mousedown"===b||"touchstart"===b?this.onDragStart(a):"mousemove"===b||"touchmove"===b?this.onDragMove(a):"mouseup"===b||"touchend"===b?this.onDragEnd(a):"touchcancel"===b&&this.onDragEnd(a)
    },e.prototype.internalEvents=function(){
        var c=(k(),l());
        this.settings.mouseDrag?(this.$stage.on("mousedown",a.proxy(function(a){
            this.eventsRouter(a)
        },this)),this.$stage.on("dragstart",function(){
            return!1
        }),this.$stage.get(0).onselectstart=function(){
            return!1
        }):this.$element.addClass("owl-text-select-on"),this.settings.touchDrag&&!c&&this.$stage.on("touchstart touchcancel",a.proxy(function(a){
            this.eventsRouter(a)
        },this)),this.transitionEndVendor&&this.on(this.$stage.get(0),this.transitionEndVendor,this.e._transitionEnd,!1),this.settings.responsive!==!1&&this.on(b,"resize",a.proxy(this.onThrottledResize,this))
    },e.prototype.onDragStart=function(d){
        var e,g,h,i;
        if(e=d.originalEvent||d||b.event,3===e.which||this.state.isTouch)return!1;
        if("mousedown"===e.type&&this.$stage.addClass("owl-grab"),this.trigger("drag"),this.drag.startTime=(new Date).getTime(),this.speed(0),this.state.isTouch=!0,this.state.isScrolling=!1,this.state.isSwiping=!1,this.drag.distance=0,g=f(e).x,h=f(e).y,this.drag.offsetX=this.$stage.position().left,this.drag.offsetY=this.$stage.position().top,this.settings.rtl&&(this.drag.offsetX=this.$stage.position().left+this.$stage.width()-this.width()+this.settings.margin),this.state.inMotion&&this.support3d)i=this.getTransformProperty(),this.drag.offsetX=i,this.animate(i),this.state.inMotion=!0;
        else if(this.state.inMotion&&!this.support3d)return this.state.inMotion=!1,!1;
        this.drag.startX=g-this.drag.offsetX,this.drag.startY=h-this.drag.offsetY,this.drag.start=g-this.drag.startX,this.drag.targetEl=e.target||e.srcElement,this.drag.updatedX=this.drag.start,("IMG"===this.drag.targetEl.tagName||"A"===this.drag.targetEl.tagName)&&(this.drag.targetEl.draggable=!1),a(c).on("mousemove.owl.dragEvents mouseup.owl.dragEvents touchmove.owl.dragEvents touchend.owl.dragEvents",a.proxy(function(a){
            this.eventsRouter(a)
        },this))
    },e.prototype.onDragMove=function(a){
        var c,e,g,h,i,j;
        this.state.isTouch&&(this.state.isScrolling||(c=a.originalEvent||a||b.event,e=f(c).x,g=f(c).y,this.drag.currentX=e-this.drag.startX,this.drag.currentY=g-this.drag.startY,this.drag.distance=this.drag.currentX-this.drag.offsetX,this.drag.distance<0?this.state.direction=this.settings.rtl?"right":"left":this.drag.distance>0&&(this.state.direction=this.settings.rtl?"left":"right"),this.settings.loop?this.op(this.drag.currentX,">",this.coordinates(this.minimum()))&&"right"===this.state.direction?this.drag.currentX-=(this.settings.center&&this.coordinates(0))-this.coordinates(this._items.length):this.op(this.drag.currentX,"<",this.coordinates(this.maximum()))&&"left"===this.state.direction&&(this.drag.currentX+=(this.settings.center&&this.coordinates(0))-this.coordinates(this._items.length)):(h=this.coordinates(this.settings.rtl?this.maximum():this.minimum()),i=this.coordinates(this.settings.rtl?this.minimum():this.maximum()),j=this.settings.pullDrag?this.drag.distance/5:0,this.drag.currentX=Math.max(Math.min(this.drag.currentX,h+j),i+j)),(this.drag.distance>8||this.drag.distance<-8)&&(c.preventDefault!==d?c.preventDefault():c.returnValue=!1,this.state.isSwiping=!0),this.drag.updatedX=this.drag.currentX,(this.drag.currentY>16||this.drag.currentY<-16)&&this.state.isSwiping===!1&&(this.state.isScrolling=!0,this.drag.updatedX=this.drag.start),this.animate(this.drag.updatedX)))
    },e.prototype.onDragEnd=function(b){
        var d,e,f;
        if(this.state.isTouch){
            if("mouseup"===b.type&&this.$stage.removeClass("owl-grab"),this.trigger("dragged"),this.drag.targetEl.removeAttribute("draggable"),this.state.isTouch=!1,this.state.isScrolling=!1,this.state.isSwiping=!1,0===this.drag.distance&&this.state.inMotion!==!0)return this.state.inMotion=!1,!1;
            this.drag.endTime=(new Date).getTime(),d=this.drag.endTime-this.drag.startTime,e=Math.abs(this.drag.distance),(e>3||d>300)&&this.removeClick(this.drag.targetEl),f=this.closest(this.drag.updatedX),this.speed(this.settings.dragEndSpeed||this.settings.smartSpeed),this.current(f),this.invalidate("position"),this.update(),this.settings.pullDrag||this.drag.updatedX!==this.coordinates(f)||this.transitionEnd(),this.drag.distance=0,a(c).off(".owl.dragEvents")
        }
    },e.prototype.removeClick=function(c){
        this.drag.targetEl=c,a(c).on("click.preventClick",this.e._preventClick),b.setTimeout(function(){
            a(c).off("click.preventClick")
        },300)
    },e.prototype.preventClick=function(b){
        b.preventDefault?b.preventDefault():b.returnValue=!1,b.stopPropagation&&b.stopPropagation(),a(b.target).off("click.preventClick")
    },e.prototype.getTransformProperty=function(){
        var a,c;
        return a=b.getComputedStyle(this.$stage.get(0),null).getPropertyValue(this.vendorName+"transform"),a=a.replace(/matrix(3d)?\(|\)/g,"").split(","),c=16===a.length,c!==!0?a[4]:a[12]
    },e.prototype.closest=function(b){
        var c=-1,d=30,e=this.width(),f=this.coordinates();
        return this.settings.freeDrag||a.each(f,a.proxy(function(a,g){
            return b>g-d&&g+d>b?c=a:this.op(b,"<",g)&&this.op(b,">",f[a+1]||g-e)&&(c="left"===this.state.direction?a+1:a),-1===c
        },this)),this.settings.loop||(this.op(b,">",f[this.minimum()])?c=b=this.minimum():this.op(b,"<",f[this.maximum()])&&(c=b=this.maximum())),c
    },e.prototype.animate=function(b){
        this.trigger("translate"),this.state.inMotion=this.speed()>0,this.support3d?this.$stage.css({
            transform:"translate3d("+b+"px,0px, 0px)",
            transition:this.speed()/1e3+"s"
        }):this.state.isTouch?this.$stage.css({
            left:b+"px"
        }):this.$stage.animate({
            left:b
        },this.speed()/1e3,this.settings.fallbackEasing,a.proxy(function(){
            this.state.inMotion&&this.transitionEnd()
        },this))
    },e.prototype.current=function(a){
        if(a===d)return this._current;
        if(0===this._items.length)return d;
        if(a=this.normalize(a),this._current!==a){
            var b=this.trigger("change",{
                property:{
                    name:"position",
                    value:a
                }
            });
            b.data!==d&&(a=this.normalize(b.data)),this._current=a,this.invalidate("position"),this.trigger("changed",{
                property:{
                    name:"position",
                    value:this._current
                }
            })
        }
        return this._current
    },e.prototype.invalidate=function(a){
        this._invalidated[a]=!0
    },e.prototype.reset=function(a){
        a=this.normalize(a),a!==d&&(this._speed=0,this._current=a,this.suppress(["translate","translated"]),this.animate(this.coordinates(a)),this.release(["translate","translated"]))
    },e.prototype.normalize=function(b,c){
        var e=c?this._items.length:this._items.length+this._clones.length;
        return!a.isNumeric(b)||1>e?d:b=this._clones.length?(b%e+e)%e:Math.max(this.minimum(c),Math.min(this.maximum(c),b))
    },e.prototype.relative=function(a){
        return a=this.normalize(a),a-=this._clones.length/2,this.normalize(a,!0)
    },e.prototype.maximum=function(a){
        var b,c,d,e=0,f=this.settings;
        if(a)return this._items.length-1;
        if(!f.loop&&f.center)b=this._items.length-1;
        else if(f.loop||f.center)if(f.loop||f.center)b=this._items.length+f.items;
            else{
                if(!f.autoWidth&&!f.merge)throw"Can not detect maximum absolute position.";
                for(revert=f.rtl?1:-1,c=this.$stage.width()-this.$element.width();(d=this.coordinates(e))&&!(d*revert>=c);)b=++e
            }else b=this._items.length-f.items;
        return b
    },e.prototype.minimum=function(a){
        return a?0:this._clones.length/2
    },e.prototype.items=function(a){
        return a===d?this._items.slice():(a=this.normalize(a,!0),this._items[a])
    },e.prototype.mergers=function(a){
        return a===d?this._mergers.slice():(a=this.normalize(a,!0),this._mergers[a])
    },e.prototype.clones=function(b){
        var c=this._clones.length/2,e=c+this._items.length,f=function(a){
            return a%2===0?e+a/2:c-(a+1)/2
        };
        
        return b===d?a.map(this._clones,function(a,b){
            return f(b)
        }):a.map(this._clones,function(a,c){
            return a===b?f(c):null
        })
    },e.prototype.speed=function(a){
        return a!==d&&(this._speed=a),this._speed
    },e.prototype.coordinates=function(b){
        var c=null;
        return b===d?a.map(this._coordinates,a.proxy(function(a,b){
            return this.coordinates(b)
        },this)):(this.settings.center?(c=this._coordinates[b],c+=(this.width()-c+(this._coordinates[b-1]||0))/2*(this.settings.rtl?-1:1)):c=this._coordinates[b-1]||0,c)
    },e.prototype.duration=function(a,b,c){
        return Math.min(Math.max(Math.abs(b-a),1),6)*Math.abs(c||this.settings.smartSpeed)
    },e.prototype.to=function(c,d){
        if(this.settings.loop){
            var e=c-this.relative(this.current()),f=this.current(),g=this.current(),h=this.current()+e,i=0>g-h?!0:!1,j=this._clones.length+this._items.length;
            h<this.settings.items&&i===!1?(f=g+this._items.length,this.reset(f)):h>=j-this.settings.items&&i===!0&&(f=g-this._items.length,this.reset(f)),b.clearTimeout(this.e._goToLoop),this.e._goToLoop=b.setTimeout(a.proxy(function(){
                this.speed(this.duration(this.current(),f+e,d)),this.current(f+e),this.update()
            },this),30)
        }else this.speed(this.duration(this.current(),c,d)),this.current(c),this.update()
    },e.prototype.next=function(a){
        a=a||!1,this.to(this.relative(this.current())+1,a)
    },e.prototype.prev=function(a){
        a=a||!1,this.to(this.relative(this.current())-1,a)
    },e.prototype.transitionEnd=function(a){
        return a!==d&&(a.stopPropagation(),(a.target||a.srcElement||a.originalTarget)!==this.$stage.get(0))?!1:(this.state.inMotion=!1,void this.trigger("translated"))
    },e.prototype.viewport=function(){
        var d;
        if(this.options.responsiveBaseElement!==b)d=a(this.options.responsiveBaseElement).width();
        else if(b.innerWidth)d=b.innerWidth;
        else{
            if(!c.documentElement||!c.documentElement.clientWidth)throw"Can not detect viewport width.";
            d=c.documentElement.clientWidth
        }
        return d
    },e.prototype.replace=function(b){
        this.$stage.empty(),this._items=[],b&&(b=b instanceof jQuery?b:a(b)),this.settings.nestedItemSelector&&(b=b.find("."+this.settings.nestedItemSelector)),b.filter(function(){
            return 1===this.nodeType
        }).each(a.proxy(function(a,b){
            b=this.prepare(b),this.$stage.append(b),this._items.push(b),this._mergers.push(1*b.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||1)
        },this)),this.reset(a.isNumeric(this.settings.startPosition)?this.settings.startPosition:0),this.invalidate("items")
    },e.prototype.add=function(a,b){
        b=b===d?this._items.length:this.normalize(b,!0),this.trigger("add",{
            content:a,
            position:b
        }),0===this._items.length||b===this._items.length?(this.$stage.append(a),this._items.push(a),this._mergers.push(1*a.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||1)):(this._items[b].before(a),this._items.splice(b,0,a),this._mergers.splice(b,0,1*a.find("[data-merge]").andSelf("[data-merge]").attr("data-merge")||1)),this.invalidate("items"),this.trigger("added",{
            content:a,
            position:b
        })
    },e.prototype.remove=function(a){
        a=this.normalize(a,!0),a!==d&&(this.trigger("remove",{
            content:this._items[a],
            position:a
        }),this._items[a].remove(),this._items.splice(a,1),this._mergers.splice(a,1),this.invalidate("items"),this.trigger("removed",{
            content:null,
            position:a
        }))
    },e.prototype.addTriggerableEvents=function(){
        var b=a.proxy(function(b,c){
            return a.proxy(function(a){
                a.relatedTarget!==this&&(this.suppress([c]),b.apply(this,[].slice.call(arguments,1)),this.release([c]))
            },this)
        },this);
        a.each({
            next:this.next,
            prev:this.prev,
            to:this.to,
            destroy:this.destroy,
            refresh:this.refresh,
            replace:this.replace,
            add:this.add,
            remove:this.remove
        },a.proxy(function(a,c){
            this.$element.on(a+".owl.carousel",b(c,a+".owl.carousel"))
        },this))
    },e.prototype.watchVisibility=function(){
        function c(a){
            return a.offsetWidth>0&&a.offsetHeight>0
        }
        function d(){
            c(this.$element.get(0))&&(this.$element.removeClass("owl-hidden"),this.refresh(),b.clearInterval(this.e._checkVisibile))
        }
        c(this.$element.get(0))||(this.$element.addClass("owl-hidden"),b.clearInterval(this.e._checkVisibile),this.e._checkVisibile=b.setInterval(a.proxy(d,this),500))
    },e.prototype.preloadAutoWidthImages=function(b){
        var c,d,e,f;
        c=0,d=this,b.each(function(g,h){
            e=a(h),f=new Image,f.onload=function(){
                c++,e.attr("src",f.src),e.css("opacity",1),c>=b.length&&(d.state.imagesLoaded=!0,d.initialize())
            },f.src=e.attr("src")||e.attr("data-src")||e.attr("data-src-retina")
        })
    },e.prototype.destroy=function(){
        this.$element.hasClass(this.settings.themeClass)&&this.$element.removeClass(this.settings.themeClass),this.settings.responsive!==!1&&a(b).off("resize.owl.carousel"),this.transitionEndVendor&&this.off(this.$stage.get(0),this.transitionEndVendor,this.e._transitionEnd);
        for(var d in this._plugins)this._plugins[d].destroy();(this.settings.mouseDrag||this.settings.touchDrag)&&(this.$stage.off("mousedown touchstart touchcancel"),a(c).off(".owl.dragEvents"),this.$stage.get(0).onselectstart=function(){},this.$stage.off("dragstart",function(){
            return!1
        })),this.$element.off(".owl"),this.$stage.children(".cloned").remove(),this.e=null,this.$element.removeData("owlCarousel"),this.$stage.children().contents().unwrap(),this.$stage.children().unwrap(),this.$stage.unwrap()
    },e.prototype.op=function(a,b,c){
        var d=this.settings.rtl;
        switch(b){
            case"<":
                return d?a>c:c>a;
            case">":
                return d?c>a:a>c;
            case">=":
                return d?c>=a:a>=c;
            case"<=":
                return d?a>=c:c>=a
        }
    },e.prototype.on=function(a,b,c,d){
        a.addEventListener?a.addEventListener(b,c,d):a.attachEvent&&a.attachEvent("on"+b,c)
    },e.prototype.off=function(a,b,c,d){
        a.removeEventListener?a.removeEventListener(b,c,d):a.detachEvent&&a.detachEvent("on"+b,c)
    },e.prototype.trigger=function(b,c,d){
        var e={
            item:{
                count:this._items.length,
                index:this.current()
            }
        },f=a.camelCase(a.grep(["on",b,d],function(a){
            return a
        }).join("-").toLowerCase()),g=a.Event([b,"owl",d||"carousel"].join(".").toLowerCase(),a.extend({
            relatedTarget:this
        },e,c));
        return this._supress[b]||(a.each(this._plugins,function(a,b){
            b.onTrigger&&b.onTrigger(g)
        }),this.$element.trigger(g),this.settings&&"function"==typeof this.settings[f]&&this.settings[f].apply(this,g)),g
    },e.prototype.suppress=function(b){
        a.each(b,a.proxy(function(a,b){
            this._supress[b]=!0
        },this))
    },e.prototype.release=function(b){
        a.each(b,a.proxy(function(a,b){
            delete this._supress[b]
        },this))
    },e.prototype.browserSupport=function(){
        if(this.support3d=j(),this.support3d){
            this.transformVendor=i();
            var a=["transitionend","webkitTransitionEnd","transitionend","oTransitionEnd"];
            this.transitionEndVendor=a[h()],this.vendorName=this.transformVendor.replace(/Transform/i,""),this.vendorName=""!==this.vendorName?"-"+this.vendorName.toLowerCase()+"-":""
        }
        this.state.orientation=b.orientation
    },a.fn.owlCarousel=function(b){
        return this.each(function(){
            a(this).data("owlCarousel")||a(this).data("owlCarousel",new e(this,b))
        })
    },a.fn.owlCarousel.Constructor=e
}(window.Zepto||window.jQuery,window,document),function(a,b){
    var c=function(b){
        this._core=b,this._loaded=[],this._handlers={
            "initialized.owl.carousel change.owl.carousel":a.proxy(function(b){
                if(b.namespace&&this._core.settings&&this._core.settings.lazyLoad&&(b.property&&"position"==b.property.name||"initialized"==b.type))for(var c=this._core.settings,d=c.center&&Math.ceil(c.items/2)||c.items,e=c.center&&-1*d||0,f=(b.property&&b.property.value||this._core.current())+e,g=this._core.clones().length,h=a.proxy(function(a,b){
                    this.load(b)
                },this);e++<d;)this.load(g/2+this._core.relative(f)),g&&a.each(this._core.clones(this._core.relative(f++)),h)
            },this)
        },this._core.options=a.extend({},c.Defaults,this._core.options),this._core.$element.on(this._handlers)
    };
        
    c.Defaults={
        lazyLoad:!1
    },c.prototype.load=function(c){
        var d=this._core.$stage.children().eq(c),e=d&&d.find(".owl-lazy");
        !e||a.inArray(d.get(0),this._loaded)>-1||(e.each(a.proxy(function(c,d){
            var e,f=a(d),g=b.devicePixelRatio>1&&f.attr("data-src-retina")||f.attr("data-src");
            this._core.trigger("load",{
                element:f,
                url:g
            },"lazy"),f.is("img")?f.one("load.owl.lazy",a.proxy(function(){
                f.css("opacity",1),this._core.trigger("loaded",{
                    element:f,
                    url:g
                },"lazy")
            },this)).attr("src",g):(e=new Image,e.onload=a.proxy(function(){
                f.css({
                    "background-image":"url("+g+")",
                    opacity:"1"
                }),this._core.trigger("loaded",{
                    element:f,
                    url:g
                },"lazy")
            },this),e.src=g)
        },this)),this._loaded.push(d.get(0)))
    },c.prototype.destroy=function(){
        var a,b;
        for(a in this.handlers)this._core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)
    },a.fn.owlCarousel.Constructor.Plugins.Lazy=c
}(window.Zepto||window.jQuery,window,document),function(a){
    var b=function(c){
        this._core=c,this._handlers={
            "initialized.owl.carousel":a.proxy(function(){
                this._core.settings.autoHeight&&this.update()
            },this),
            "changed.owl.carousel":a.proxy(function(a){
                this._core.settings.autoHeight&&"position"==a.property.name&&this.update()
            },this),
            "loaded.owl.lazy":a.proxy(function(a){
                this._core.settings.autoHeight&&a.element.closest("."+this._core.settings.itemClass)===this._core.$stage.children().eq(this._core.current())&&this.update()
            },this)
        },this._core.options=a.extend({},b.Defaults,this._core.options),this._core.$element.on(this._handlers)
    };
        
    b.Defaults={
        autoHeight:!1,
        autoHeightClass:"owl-height"
    },b.prototype.update=function(){
        this._core.$stage.parent().height(this._core.$stage.children().eq(this._core.current()).height()).addClass(this._core.settings.autoHeightClass)
    },b.prototype.destroy=function(){
        var a,b;
        for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)
    },a.fn.owlCarousel.Constructor.Plugins.AutoHeight=b
}(window.Zepto||window.jQuery,window,document),function(a,b,c){
    var d=function(b){
        this._core=b,this._videos={},this._playing=null,this._fullscreen=!1,this._handlers={
            "resize.owl.carousel":a.proxy(function(a){
                this._core.settings.video&&!this.isInFullScreen()&&a.preventDefault()
            },this),
            "refresh.owl.carousel changed.owl.carousel":a.proxy(function(){
                this._playing&&this.stop()
            },this),
            "prepared.owl.carousel":a.proxy(function(b){
                var c=a(b.content).find(".owl-video");
                c.length&&(c.css("display","none"),this.fetch(c,a(b.content)))
            },this)
        },this._core.options=a.extend({},d.Defaults,this._core.options),this._core.$element.on(this._handlers),this._core.$element.on("click.owl.video",".owl-video-play-icon",a.proxy(function(a){
            this.play(a)
        },this))
    };
        
    d.Defaults={
        video:!1,
        videoHeight:!1,
        videoWidth:!1
    },d.prototype.fetch=function(a,b){
        var c=a.attr("data-vimeo-id")?"vimeo":"youtube",d=a.attr("data-vimeo-id")||a.attr("data-youtube-id"),e=a.attr("data-width")||this._core.settings.videoWidth,f=a.attr("data-height")||this._core.settings.videoHeight,g=a.attr("href");
        if(!g)throw new Error("Missing video URL.");
        if(d=g.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/),d[3].indexOf("youtu")>-1)c="youtube";
        else{
            if(!(d[3].indexOf("vimeo")>-1))throw new Error("Video URL not supported.");
            c="vimeo"
        }
        d=d[6],this._videos[g]={
            type:c,
            id:d,
            width:e,
            height:f
        },b.attr("data-video",g),this.thumbnail(a,this._videos[g])
    },d.prototype.thumbnail=function(b,c){
        var d,e,f,g=c.width&&c.height?'style="width:'+c.width+"px;height:"+c.height+'px;"':"",h=b.find("img"),i="src",j="",k=this._core.settings,l=function(a){
            e='<div class="owl-video-play-icon"></div>',d=k.lazyLoad?'<div class="owl-video-tn '+j+'" '+i+'="'+a+'"></div>':'<div class="owl-video-tn" style="opacity:1;background-image:url('+a+')"></div>',b.after(d),b.after(e)
        };
            
        return b.wrap('<div class="owl-video-wrapper"'+g+"></div>"),this._core.settings.lazyLoad&&(i="data-src",j="owl-lazy"),h.length?(l(h.attr(i)),h.remove(),!1):void("youtube"===c.type?(f="http://img.youtube.com/vi/"+c.id+"/hqdefault.jpg",l(f)):"vimeo"===c.type&&a.ajax({
            type:"GET",
            url:"http://vimeo.com/api/v2/video/"+c.id+".json",
            jsonp:"callback",
            dataType:"jsonp",
            success:function(a){
                f=a[0].thumbnail_large,l(f)
            }
        }))
    },d.prototype.stop=function(){
        this._core.trigger("stop",null,"video"),this._playing.find(".owl-video-frame").remove(),this._playing.removeClass("owl-video-playing"),this._playing=null
    },d.prototype.play=function(b){
        this._core.trigger("play",null,"video"),this._playing&&this.stop();
        var c,d,e=a(b.target||b.srcElement),f=e.closest("."+this._core.settings.itemClass),g=this._videos[f.attr("data-video")],h=g.width||"100%",i=g.height||this._core.$stage.height();
        "youtube"===g.type?c='<iframe width="'+h+'" height="'+i+'" src="http://www.youtube.com/embed/'+g.id+"?autoplay=1&v="+g.id+'" frameborder="0" allowfullscreen></iframe>':"vimeo"===g.type&&(c='<iframe src="http://player.vimeo.com/video/'+g.id+'?autoplay=1" width="'+h+'" height="'+i+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'),f.addClass("owl-video-playing"),this._playing=f,d=a('<div style="height:'+i+"px; width:"+h+'px" class="owl-video-frame">'+c+"</div>"),e.after(d)
    },d.prototype.isInFullScreen=function(){
        var d=c.fullscreenElement||c.mozFullScreenElement||c.webkitFullscreenElement;
        return d&&a(d).parent().hasClass("owl-video-frame")&&(this._core.speed(0),this._fullscreen=!0),d&&this._fullscreen&&this._playing?!1:this._fullscreen?(this._fullscreen=!1,!1):this._playing&&this._core.state.orientation!==b.orientation?(this._core.state.orientation=b.orientation,!1):!0
    },d.prototype.destroy=function(){
        var a,b;
        this._core.$element.off("click.owl.video");
        for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)
    },a.fn.owlCarousel.Constructor.Plugins.Video=d
}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){
    var e=function(b){
        this.core=b,this.core.options=a.extend({},e.Defaults,this.core.options),this.swapping=!0,this.previous=d,this.next=d,this.handlers={
            "change.owl.carousel":a.proxy(function(a){
                "position"==a.property.name&&(this.previous=this.core.current(),this.next=a.property.value)
            },this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel":a.proxy(function(a){
                this.swapping="translated"==a.type
            },this),
            "translate.owl.carousel":a.proxy(function(){
                this.swapping&&(this.core.options.animateOut||this.core.options.animateIn)&&this.swap()
            },this)
        },this.core.$element.on(this.handlers)
    };
        
    e.Defaults={
        animateOut:!1,
        animateIn:!1
    },e.prototype.swap=function(){
        if(1===this.core.settings.items&&this.core.support3d){
            this.core.speed(0);
            var b,c=a.proxy(this.clear,this),d=this.core.$stage.children().eq(this.previous),e=this.core.$stage.children().eq(this.next),f=this.core.settings.animateIn,g=this.core.settings.animateOut;
            this.core.current()!==this.previous&&(g&&(b=this.core.coordinates(this.previous)-this.core.coordinates(this.next),d.css({
                left:b+"px"
            }).addClass("animated owl-animated-out").addClass(g).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",c)),f&&e.addClass("animated owl-animated-in").addClass(f).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",c))
        }
    },e.prototype.clear=function(b){
        a(b.target).css({
            left:""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut),this.core.transitionEnd()
    },e.prototype.destroy=function(){
        var a,b;
        for(a in this.handlers)this.core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)
    },a.fn.owlCarousel.Constructor.Plugins.Animate=e
}(window.Zepto||window.jQuery,window,document),function(a,b,c){
    var d=function(b){
        this.core=b,this.core.options=a.extend({},d.Defaults,this.core.options),this.handlers={
            "translated.owl.carousel refreshed.owl.carousel":a.proxy(function(){
                this.autoplay()
            },this),
            "play.owl.autoplay":a.proxy(function(a,b,c){
                this.play(b,c)
            },this),
            "stop.owl.autoplay":a.proxy(function(){
                this.stop()
            },this),
            "mouseover.owl.autoplay":a.proxy(function(){
                this.core.settings.autoplayHoverPause&&this.pause()
            },this),
            "mouseleave.owl.autoplay":a.proxy(function(){
                this.core.settings.autoplayHoverPause&&this.autoplay()
            },this)
        },this.core.$element.on(this.handlers)
    };
        
    d.Defaults={
        autoplay:!1,
        autoplayTimeout:5e3,
        autoplayHoverPause:!1,
        autoplaySpeed:!1
    },d.prototype.autoplay=function(){
        this.core.settings.autoplay&&!this.core.state.videoPlay?(b.clearInterval(this.interval),this.interval=b.setInterval(a.proxy(function(){
            this.play()
        },this),this.core.settings.autoplayTimeout)):b.clearInterval(this.interval)
    },d.prototype.play=function(){
        return c.hidden===!0||this.core.state.isTouch||this.core.state.isScrolling||this.core.state.isSwiping||this.core.state.inMotion?void 0:this.core.settings.autoplay===!1?void b.clearInterval(this.interval):void this.core.next(this.core.settings.autoplaySpeed)
    },d.prototype.stop=function(){
        b.clearInterval(this.interval)
    },d.prototype.pause=function(){
        b.clearInterval(this.interval)
    },d.prototype.destroy=function(){
        var a,c;
        b.clearInterval(this.interval);
        for(a in this.handlers)this.core.$element.off(a,this.handlers[a]);for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)
    },a.fn.owlCarousel.Constructor.Plugins.autoplay=d
}(window.Zepto||window.jQuery,window,document),function(a){
    "use strict";
    var b=function(c){
        this._core=c,this._initialized=!1,this._pages=[],this._controls={},this._templates=[],this.$element=this._core.$element,this._overrides={
            next:this._core.next,
            prev:this._core.prev,
            to:this._core.to
        },this._handlers={
            "prepared.owl.carousel":a.proxy(function(b){
                this._core.settings.dotsData&&this._templates.push(a(b.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            },this),
            "add.owl.carousel":a.proxy(function(b){
                this._core.settings.dotsData&&this._templates.splice(b.position,0,a(b.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            },this),
            "remove.owl.carousel prepared.owl.carousel":a.proxy(function(a){
                this._core.settings.dotsData&&this._templates.splice(a.position,1)
            },this),
            "change.owl.carousel":a.proxy(function(a){
                if("position"==a.property.name&&!this._core.state.revert&&!this._core.settings.loop&&this._core.settings.navRewind){
                    var b=this._core.current(),c=this._core.maximum(),d=this._core.minimum();
                    a.data=a.property.value>c?b>=c?d:c:a.property.value<d?c:a.property.value
                }
            },this),
            "changed.owl.carousel":a.proxy(function(a){
                "position"==a.property.name&&this.draw()
            },this),
            "refreshed.owl.carousel":a.proxy(function(){
                this._initialized||(this.initialize(),this._initialized=!0),this._core.trigger("refresh",null,"navigation"),this.update(),this.draw(),this._core.trigger("refreshed",null,"navigation")
            },this)
        },this._core.options=a.extend({},b.Defaults,this._core.options),this.$element.on(this._handlers)
    };
    
    b.Defaults={
        nav:!1,
        navRewind:!0,
        navText:["prev","next"],
        navSpeed:!1,
        navElement:"div",
        navContainer:!1,
        navContainerClass:"owl-nav",
        navClass:["owl-prev","owl-next"],
        slideBy:1,
        dotClass:"owl-dot",
        dotsClass:"owl-dots",
        dots:!0,
        dotsEach:!1,
        dotData:!1,
        dotsSpeed:!1,
        dotsContainer:!1,
        controlsClass:"owl-controls"
    },b.prototype.initialize=function(){
        var b,c,d=this._core.settings;
        d.dotsData||(this._templates=[a("<div>").addClass(d.dotClass).append(a("<span>")).prop("outerHTML")]),d.navContainer&&d.dotsContainer||(this._controls.$container=a("<div>").addClass(d.controlsClass).appendTo(this.$element)),this._controls.$indicators=d.dotsContainer?a(d.dotsContainer):a("<div>").hide().addClass(d.dotsClass).appendTo(this._controls.$container),this._controls.$indicators.on("click","div",a.proxy(function(b){
            var c=a(b.target).parent().is(this._controls.$indicators)?a(b.target).index():a(b.target).parent().index();
            b.preventDefault(),this.to(c,d.dotsSpeed)
        },this)),b=d.navContainer?a(d.navContainer):a("<div>").addClass(d.navContainerClass).prependTo(this._controls.$container),this._controls.$next=a("<"+d.navElement+">"),this._controls.$previous=this._controls.$next.clone(),this._controls.$previous.addClass(d.navClass[0]).html(d.navText[0]).hide().prependTo(b).on("click",a.proxy(function(){
            this.prev(d.navSpeed)
        },this)),this._controls.$next.addClass(d.navClass[1]).html(d.navText[1]).hide().appendTo(b).on("click",a.proxy(function(){
            this.next(d.navSpeed)
        },this));
        for(c in this._overrides)this._core[c]=a.proxy(this[c],this)
    },b.prototype.destroy=function(){
        var a,b,c,d;
        for(a in this._handlers)this.$element.off(a,this._handlers[a]);for(b in this._controls)this._controls[b].remove();for(d in this.overides)this._core[d]=this._overrides[d];for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)
    },b.prototype.update=function(){
        var a,b,c,d=this._core.settings,e=this._core.clones().length/2,f=e+this._core.items().length,g=d.center||d.autoWidth||d.dotData?1:d.dotsEach||d.items;
        if("page"!==d.slideBy&&(d.slideBy=Math.min(d.slideBy,d.items)),d.dots||"page"==d.slideBy)for(this._pages=[],a=e,b=0,c=0;f>a;a++)(b>=g||0===b)&&(this._pages.push({
            start:a-e,
            end:a-e+g-1
        }),b=0,++c),b+=this._core.mergers(this._core.relative(a))
    },b.prototype.draw=function(){
        var b,c,d="",e=this._core.settings,f=(this._core.$stage.children(),this._core.relative(this._core.current()));
        if(!e.nav||e.loop||e.navRewind||(this._controls.$previous.toggleClass("disabled",0>=f),this._controls.$next.toggleClass("disabled",f>=this._core.maximum())),this._controls.$previous.toggle(e.nav),this._controls.$next.toggle(e.nav),e.dots){
            if(b=this._pages.length-this._controls.$indicators.children().length,e.dotData&&0!==b){
                for(c=0;c<this._controls.$indicators.children().length;c++)d+=this._templates[this._core.relative(c)];
                this._controls.$indicators.html(d)
            }else b>0?(d=new Array(b+1).join(this._templates[0]),this._controls.$indicators.append(d)):0>b&&this._controls.$indicators.children().slice(b).remove();
            this._controls.$indicators.find(".active").removeClass("active"),this._controls.$indicators.children().eq(a.inArray(this.current(),this._pages)).addClass("active")
        }
        this._controls.$indicators.toggle(e.dots)
    },b.prototype.onTrigger=function(b){
        var c=this._core.settings;
        b.page={
            index:a.inArray(this.current(),this._pages),
            count:this._pages.length,
            size:c&&(c.center||c.autoWidth||c.dotData?1:c.dotsEach||c.items)
        }
    },b.prototype.current=function(){
        var b=this._core.relative(this._core.current());
        return a.grep(this._pages,function(a){
            return a.start<=b&&a.end>=b
        }).pop()
    },b.prototype.getPosition=function(b){
        var c,d,e=this._core.settings;
        return"page"==e.slideBy?(c=a.inArray(this.current(),this._pages),d=this._pages.length,b?++c:--c,c=this._pages[(c%d+d)%d].start):(c=this._core.relative(this._core.current()),d=this._core.items().length,b?c+=e.slideBy:c-=e.slideBy),c
    },b.prototype.next=function(b){
        a.proxy(this._overrides.to,this._core)(this.getPosition(!0),b)
    },b.prototype.prev=function(b){
        a.proxy(this._overrides.to,this._core)(this.getPosition(!1),b)
    },b.prototype.to=function(b,c,d){
        var e;
        d?a.proxy(this._overrides.to,this._core)(b,c):(e=this._pages.length,a.proxy(this._overrides.to,this._core)(this._pages[(b%e+e)%e].start,c))
    },a.fn.owlCarousel.Constructor.Plugins.Navigation=b
}(window.Zepto||window.jQuery,window,document),function(a,b){
    "use strict";
    var c=function(d){
        this._core=d,this._hashes={},this.$element=this._core.$element,this._handlers={
            "initialized.owl.carousel":a.proxy(function(){
                "URLHash"==this._core.settings.startPosition&&a(b).trigger("hashchange.owl.navigation")
            },this),
            "prepared.owl.carousel":a.proxy(function(b){
                var c=a(b.content).find("[data-hash]").andSelf("[data-hash]").attr("data-hash");
                this._hashes[c]=b.content
            },this)
        },this._core.options=a.extend({},c.Defaults,this._core.options),this.$element.on(this._handlers),a(b).on("hashchange.owl.navigation",a.proxy(function(){
            var a=b.location.hash.substring(1),c=this._core.$stage.children(),d=this._hashes[a]&&c.index(this._hashes[a])||0;
            return a?void this._core.to(d,!1,!0):!1
        },this))
    };
        
    c.Defaults={
        URLhashListener:!1
    },c.prototype.destroy=function(){
        var c,d;
        a(b).off("hashchange.owl.navigation");
        for(c in this._handlers)this._core.$element.off(c,this._handlers[c]);for(d in Object.getOwnPropertyNames(this))"function"!=typeof this[d]&&(this[d]=null)
    },a.fn.owlCarousel.Constructor.Plugins.Hash=c
}(window.Zepto||window.jQuery,window,document);
;
jQuery(document).ready(function($){
    "use strict";
    $(window).on('scroll',function(){
        if($(window).scrollTop()>200){
            $('.to_top').fadeIn(100);
        }
        else{
            $('.to_top').fadeOut(100);
        }
    });
    $(document).on('click','.dropdown-toggle',function(){
        if($(this).attr('href').indexOf('http')>-1){
            window.location.href=$(this).attr('href');
        }
    });
    $(document).on('click','.to_top',function(e){
        e.preventDefault();
        $("html, body").stop().animate({
            scrollTop:0
        },{
            duration:1200
        });
    });
    $(document).on('click','.submit_form',function(){
        $(this).parents('form').submit();
    });
    function start_review_slider(){
        $('.review-slider').owlCarousel(
        {
            items:1,
            animateOut:'fadeOut',
            rtl:true,
            nav:$('.review-slider li').length>1?true:false,
            autoHeight:true,
            navText:['<div class="bnav"><i class="fa fa-angle-left"></i></div>','<div class="bnav"><i class="fa fa-angle-right"></i></div>'],
        });
    }
    $(document).on('reviews-images-loaded',function(){
        start_review_slider();
        $(document).on('click','.slider-pager .owl-item',function(){
            $('.review-slider').trigger('to.owl.carousel',$(this).index());
        });
    });
    $('.review-slider li').magnificPopup(
    {
        type:'image',
        delegate:'a',
        gallery:{
            enabled:true
        },
    });
    $('.slider-pager').owlCarousel(
    {
        items:10,
        rtl:true,
        responsiveClass:true,
        margin:5,
        responsive:{
            0:{
                items:3
            },
            200:{
                items:4
            },
            400:{
                items:6
            },
            600:{
                items:8,
                margin:3
            },
            736:{
                margin:4
            },
            800:{
                items:10
            }
        },
        nav:false,
        dots:false
    });
    $('.gallery-slider').responsiveSlides({
        speed:500,
        auto:false,
        pager:false,
        nav:true,
        prevText:'<i class="fa fa-angle-left"></i>',
        nextText:'<i class="fa fa-angle-right"></i>',
    });
    $('.big-search-slider').responsiveSlides({
        speed:800,
        auto:true,
        pager:false,
        nav:false,
    });
    function handle_navigation(){
        if($(window).width()>=767){
            $(document).on('mouseenter','ul.nav li.dropdown, ul.nav li.dropdown-submenu',function(){
                var $this=$(this);
                if(!$this.hasClass('open')){
                    $(this).addClass('open').find(' > .dropdown-menu').show();
                }
            });
            $(document).on('mouseleave','ul.nav li.dropdown, ul.nav li.dropdown-submenu',function(){
                var $this=$(this);
                setTimeout(function(){
                    if(!$this.is(":hover")){
                        if($this.hasClass('open')){
                            $this.removeClass('open').find(' > .dropdown-menu').hide();
                        }
                    }
                },100);
            });
        }
        else{
            $('ul.nav li.dropdown, ul.nav li.dropdown-submenu').unbind('mouseenter mouseleave');
        }
    }
    $(window).resize(function(){
        setTimeout(function(){
            handle_navigation();
        },200);
    });
    function start_slider(){
        $('.post-slider').responsiveSlides({
            speed:500,
            auto:false,
            pager:false,
            nav:true,
            prevText:'<i class="fa fa-angle-left"></i>',
            nextText:'<i class="fa fa-angle-right"></i>',
        });
    }
    start_slider();
    $(document).on('click','.submit-live-form',function(){
        $(this).parents('form').submit();
    });
    $(document).on('click','.submit-form',function(){
        var $this=$(this);
        var $form=$this.parents('form');
        var $result=$form.find('.send_result');
        if($this.find('i').length==0){
            var $html=$this.html();
            $this.html($html+' <i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                url:ajaxurl,
                data:$form.serialize(),
                method:$form.attr('method'),
                dataType:"JSON",
                success:function(response){
                    if(response.message){
                        $result.html(response.message);
                    }
                    if(response.url){
                        window.location.href=response.url;
                    }
                },
                complete:function(){
                    $this.html($html);
                }
            });
        }
    });
    $(document).on('click','.subscribe',function(e){
        e.preventDefault();
        var $this=$(this);
        var $parent=$this.parents('.subscribe-form');
        $.ajax({
            url:ajaxurl,
            method:"POST",
            data:{
                action:'subscribe',
                email:$parent.find('.email').val()
            },
            dataType:"JSON",
            success:function(response){
                if(!response.error){
                    $parent.find('.sub_result').html('<div class="alert alert-success" role="alert"><span class="fa fa-check-circle"></span> '+response.success+'</div>');
                }
                else{
                    $parent.find('.sub_result').html('<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>');
                }
            }
        })
    });
    $(document).on('click','.send-contact',function(e){
        e.preventDefault();
        var $this=$(this);
        var $html=$this.html();
        $this.append(' <i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            url:ajaxurl,
            method:"POST",
            data:{
                action:'contact',
                name:$('.name').val(),
                email:$('.email').val(),
                subject:$('.subject').val(),
                message:$('.message').val()
            },
            dataType:"JSON",
            success:function(response){
                if(!response.error){
                    $('.send_result').html('<div class="alert alert-success" role="alert"><span class="fa fa-check-circle"></span> '+response.success+'</div>');
                }
                else{
                    $('.send_result').html('<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>');
                }
            },
            complete:function(){
                $this.html($html);
            }
        })
    });
    $('.gallery').each(function(){
        var $this=$(this);
        $this.magnificPopup({
            type:'image',
            delegate:'a',
            gallery:{
                enabled:true
            },
        });
    });

    var $navigation_bar=$('.navigation-bar');
    var $sticky_nav=$navigation_bar.clone().addClass('sticky_nav');
    if($sticky_nav.find('a[data-toggle="tab"]').length>0)
    {
        $sticky_nav.find('a[data-toggle="tab"]').each(function()
        {
            $(this).attr('href',$(this).attr('href')+'_sticky');
        });
        $sticky_nav.find('.tab-pane').each(function()
        {
            $(this).attr('id',$(this).attr('id')+'_sticky');
        });
    }
    $('body').append($sticky_nav);
    function sticky_nav()
    {
        var $admin=$('#wpadminbar');
        if($admin.length>0&&$admin.css('position')=='fixed')
        {
            $sticky_nav.css('top',$admin.height());
        }
        else
        {
            $sticky_nav.css('top','0');
        }
    }
	/*
    $(window).on('scroll',function()
    {
        if($(window).scrollTop()>0&&$(window).scrollTop()>=$navigation_bar.position().top&&$(window).width()>769)
        {
        //$sticky_nav.show();
        }
        else
        {
        //$sticky_nav.hide();
        }
    });
    $(window).on('scroll',function()
    {
        if($(window).scrollTop()>0&&$(window).scrollTop()>=$navigation_bar.position().top)
        {
            $('.top-bar-fixed').css('position','fixed');
            $('.top-bar-fixed').css('top','0');
        //$sticky_nav.show();
        }
        else
        {
            $('.top-bar-fixed').css('position','relative');
            $('.top-bar-fixed').css('top','0');
        //$sticky_nav.hide();
        }
    });
    sticky_nav();
	*/
    handle_navigation();
    $(window).resize(function(){
        sticky_nav();
    });
    $('#sort, #review-category').change(function(){
        $(this).parents('form').submit();
    });
    var $container=$('.masonry');
    var has_masonry=false;
    function start_masonry()
    {
        if($(window).width()<768&&has_masonry)
        {
            $container.masonry('destroy');
            has_masonry=false;
        }
        else if($(window).width()>=768&&!has_masonry)
        {
            $container.imagesLoaded(function()
            {
                $container.masonry({
                    itemSelector:'.masonry-item',
                    columnWidth:'.masonry-item',
                });
                has_masonry=true;
            });
        }
    }
    start_masonry();
    $(window).resize(function()
    {
        setTimeout(function()
        {
            start_masonry();
        },500);
    });
    $(document).on('mouseenter','#rating-form .rating .fa',function()
    {
        var pos=$(this).index();
        //alert(pos);
        var $parent=$(this).parents('.user-ratings');
        var icon,is_clicked;
        for(var i=0;i<=4;i++)
        {
            icon=$parent.find('.fa:eq('+i+')');
            is_clicked=icon.hasClass('clicked')?'clicked':'';
            if(i<=pos)
            {
				
                icon.attr('class','fa fa-star '+is_clicked);
            }
            else
            {
				
                icon.attr('class','fa fa-star-o '+is_clicked);
            }
        }
    });
    $(document).on('mouseleave','#rating-form .rating .fa',function()
    {
        $(this).parents('.user-ratings').find('.fa').each(function()
        {
            if(!$(this).hasClass('clicked'))
            {
                $(this).attr('class','fa fa-star-o');
            }
			
        });
    });
    $(document).on('mouseleave','#rating-form .rating',function()
    {
        $(this).find('.fa').each(function()
        {
            if($(this).hasClass('clicked') && $(this).hasClass('fa fa-star-o'))
            {
                $(this).attr('class','fa fa-star clicked');
            }
			
        });
    });
    $(document).on('click','#rating-form .rating .fa',function()
    {
        var value=$(this).index();
        var $parent=$(this).parents('.user-ratings');
        $parent.find('.fa').removeClass('clicked');
        for(var i=0;i<=value;i++)
        {
            $parent.find('.fa:eq('+i+')').attr('class','fa fa-star').addClass('clicked');
        }
        update_ratings();
    });
	
    function update_ratings()
    {
        var review_value=[];
        var counter=0;
        var value_criteria;
        $('#rating-form .rating .user-ratings').each(function()
        {
            var $this=$(this);
            counter++;
            if($this.find('.clicked').length>0)
            {
                value_criteria=$this.find('.clicked').length;
                review_value.push(counter+'|'+value_criteria);
            }
        });
        //alert(review_value.join(','));
        $('#rate').val(value_criteria);
    }
    $('.mega_menu_dropdown').parents().each(function()
    {
        var $this=$(this);
        if(!$this.hasClass('navigation-bar'))
        {
            $this.css('position','static');
        }
        else if(!$this.hasClass('sticky_nav'))
        {
            $this.css('position','relative')
        }
    });
    $('.reviews-slider').each(function()
    {
        var $this=$(this);
        $this.owlCarousel(
        {
            margin:30,
            rtl:true,
            responsive:
            {
                1300:{
                    items:4
                },
                1100:{
                    items:3
                },
                700:{
                    items:2
                },
                400:{
                    items:1
                }
            },
            nav:true,
            navText:['<div class="bnav"><i class="fa fa-angle-right"></i></div>','<div class="bnav"><i class="fa fa-angle-left"></i></div>'],
            dots:false
        });
    });

    $('.cat-slider').each(function()
    {
        var $this=$(this);
        $this.owlCarousel(
        {
            margin:0,
            rtl:true,
            responsive:
            {
                1200:{
                    items:10
                },
                1000:{
                    items:9
                },
                800:{
                    items:6
                },
                600:{
                    items:5
                },
                500:{
                    items:4
                },
                400:{
                    items:3
                },
                300:{
                    items:2
                },
                200:{
                    items:1
                }
			
            },
            nav:true,
            navText:['<div class="PrevCarousel"><i class="fa fa-angle-right fa-2x"></i></div>','<div class="NextCarousel"><i class="fa fa-angle-left fa-2x"></i></div>'],
            dots:false
        });
    });


    $('.dropdown-cat').hover(function() 
    {
        var $this=$(this);
        //alert($this.html());
        $this.find('.JobsCat').addClass('activeCarouselItemClass');
        $this.find('ul.dropdown-menu').slideDown();
    },function()
    {
        var $this=$(this);
        //alert($this.html());
        $this.find('ul.dropdown-menu').slideUp();
        $this.find('.JobsCat').removeClass('activeCarouselItemClass');
    });

    var lazy_images_loaded=0;
    var lazy_images=$('.reviews-lazy-load:not(.image-loaded)').length;
    function lazy_load_images(){
        $('.reviews-lazy-load:not(.image-loaded)').each(function(){
            var $this=$(this);
            var imgPreload=new Image();
            var $imgPreload=$(imgPreload);
            $imgPreload.attr({
                src:$this.data('src')
            });
            if(imgPreload.complete||imgPreload.readyState===4){
                $this.attr('src',$imgPreload.attr('src'));
                check_lazy_finish();
            }else{
                $imgPreload.load(function(response,status,xhr){
                    if(status=='error'){
                        check_lazy_finish();
                    }else{
                        $this.attr('src',$imgPreload.attr('src'));
                        check_lazy_finish();
                    }
                });
            }
        });
    }
    function check_lazy_finish(){
        lazy_images_loaded++;
        if(lazy_images_loaded==lazy_images){
            $(document).trigger('reviews-images-loaded');
        }
    }
    lazy_load_images();
    $(window).load(function(){
        if(lazy_images_loaded<lazy_images){
            $(document).trigger('reviews-images-loaded');
        }
    });
    function open_quick_search(){
        $('.quick_search_result').show();
    }
    function close_quick_search(){
        $('.quick_search_result').hide();
    }
    $(document).on('keyup','.quick-search input',function(){
        var $this=$(this);
        var val=$this.val();
        if(val!==''&&val.length>=3){
            timeout=setTimeout(function(){
                $('.quick-search').append('<i class="fa fa-spin fa-circle-o-notch"></i>');
                $.ajax({
                    url:ajaxurl,
                    type:"POST",
                    data:{
                        action:'quick_search',
                        val:val
                    },
                    success:function(response){
                        $('.quick_search_result').html(response);
                        open_quick_search();
                    },
                    complete:function(){
                        if($this.val()==''){
                            close_quick_search();
                        }
                        $('.quick-search .fa').remove();
                    }
                });
            },200);
        }
        else{
            clearTimeout(timeout);
            close_quick_search();
        }
    });
    $(document).on('focus','.quick-search input',function(){
        var $this=$(this);
        if($this.val()!==''){
            open_quick_search();
        }
    });
    $(document).on('blur','.quick-search input',function(){
        if(!$('.quick_search_result').is(':hover')){
            close_quick_search();
        }
    });

		
    $(window).load(function(){
        if(window.location.hash){
            var $target=$(window.location.hash);
            if($target.length==1){
                var scroll=$target.offset().top;
                var $admin=$('#wpadminbar');
                var $sticky=$('.sticky_nav');
                if($admin.length>0&&$admin.css('position')=='fixed'){
                    scroll-=$admin.height();
                }
                if($sticky.length>0){
                    scroll-=$sticky.outerHeight(true);
                }
                scroll-=20;
                window.scrollTo(0,scroll);
            }
        }
    });
});
;
!function(a,b){
    "use strict";
    function c(){
        if(!e){
            e=!0;
            var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");
            for(c=0;c<i.length;c++)if(d=i[c],!d.getAttribute("data-secret")){
                if(f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f),g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)
            }else;
        }
    }
    var d=!1,e=!1;
    if(b.querySelector)if(a.addEventListener)d=!0;
    if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){
        var d=c.data;
        if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){
            var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');
            for(e=0;e<k.length;e++)k[e].style.display="none";
            for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){
                if(f.removeAttribute("style"),"height"===d.message){
                    if(g=parseInt(d.value,10),g>1e3)g=1e3;
                    else if(200>~~g)g=200;
                    f.height=g
                }
                if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value
            }else;
        }
    },d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)
}(window,document);



/* =========================================================
Comment Form
============================================================ */
jQuery(document).ready(function()
{
    if(jQuery("#comment-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the comments form
        jQuery('#comment-form').validate(
        {
            //alert('ok');
    	
            // Add requirements to each of the fields
            rules: {
                
                message: {
                    required: true,
                    minlength: 10
                }
            },
    		
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
               
                message: {
                    required: "لطفا دیدگاه خود را وارد کنید",
                    minlength: jQuery.format("وارد کردن حداقل 10 کاراکتر برای دیدگاه الزامی است.")
                }
            },
            submitHandler: function(form) 
            {
                //alert('ok');
                //jQuery("#submit-contact").attr("value", "در حال ثبت ....");
                jQuery("#submit").attr("disabled", "disabled");
                jQuery("#submit").attr("value", "در حال ثبت ....");
                        
                jQuery(form).ajaxSubmit(
                {
                    //alert('ok');
                    success: function(data, statusText, xhr, $form) 
                    {
                        //alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        //alert(responseResult);
                        if(responseResult=='success')
                        {
                                        
                            jQuery('#comment-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                        }
                                    
                                    
                        jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                        ;
                        // jQuery("#submit-contact").attr("value", "ارسال");
                        jQuery("#submit").attr("value", "ثبت دیدگاه شما");
                        jQuery("#submit").removeAttr("disabled");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });  
            
    }
    jQuery("#responseRating").html('').hide();
    // Validate the comments form
    jQuery('#rating-form').validate(
    {
			
        submitHandler: function(form) 
        {
            //alert('ok');
            //jQuery("#submit-contact").attr("value", "در حال ثبت ....");
            if(jQuery('#rate').val()>0)
            {
					
				
                jQuery("#submitR").attr("disabled", "disabled");
                jQuery("#submitR").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit(
                {
                    //alert('ok');
                    success: function(data, statusText, xhr, $form) 
                    {
                        //alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        //alert(responseResult);
                        if(responseResult=='success')
                        {
											
                            //jQuery('#comment-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                        }
										
										
                        jQuery("#responseRating").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                        ;
                        // jQuery("#submit-contact").attr("value", "ارسال");
                        jQuery("#submitR").attr("value", "ثبت امتیاز");
                        jQuery("#submitR").removeAttr("disabled");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
            }
            else
            {
                var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> انتخاب حداقل یک ستاره برای امتیازدهی الزامی است.</div>';
                jQuery("#responseRating").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
            }
            return false;
        }
    });  
		
    jQuery("#responseFeature").html('').hide();
    // Validate the comments form
    jQuery('#feature-form').validate(
    {
			
        submitHandler: function(form) 
        {
            //alert('ok');
            //jQuery("#submit-contact").attr("value", "در حال ثبت ....");
				
					
				
            jQuery("#submitF").attr("disabled", "disabled");
            jQuery("#submitF").attr("value", "در حال ثبت ....");
							
            jQuery(form).ajaxSubmit(
            {
                //alert('ok');
                success: function(data, statusText, xhr, $form) 
                {
                    //alert('ok');
                    var responseArray = JSON.parse(data);
                    var responseText=responseArray['message'];
                    var responseResult=responseArray['result'];
                    //alert(responseResult);
                    if(responseResult=='success')
                    {
											
                        //jQuery('#comment-form')[0].reset();
                        var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                    }
                    else
                    {
                        var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                    }
										
										
                    jQuery("#responseFeature").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                    ;
                    // jQuery("#submit-contact").attr("value", "ارسال");
                    jQuery("#submitF").attr("value", "ثبت امتیاز");
                    jQuery("#submitF").removeAttr("disabled");
                //jQuery('#contact-form')[0].reset();
                }
            });
				
            return false;
        }
    });  
		
    if(jQuery("#contact-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#contact-form').validate({
				   
            // Add requirements to each of the fields
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 10
                }
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                name: {
                    required: "لطفا نام خود را وارد کنید.",
						
                },
                email: {
                    required: "لطفا پست الکترونیکی خود را وارد کنید.",
                    email: "لطفا یک ایمیل معتبر وارد کنید.."
                },
                url: {
                    required: "Please enter your url.",
                    url: "Please enter a valid url."
                },
                message: {
                    required: "لطفا متن انتقاد یا پیشنهاد را وارد کنید.",
                    minlength: jQuery.format("حداقل ده کاراکتر باید وارد شود.")
                }
            },
				
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال ثبت ....");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
											
                            jQuery('#contact-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                        }
										
										
                        jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
										
										
							
                        jQuery("#submit-contact").attr("value", "ثبت دیدگاه شما");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
            
    if(jQuery("#register-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#register-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                mobile: {
                    required: true,
                    pattern: /(09)\d{9}$/
                                                
						
                }
					
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                mobile: {
                    required: "لطفا شماره تلفن  همراه خود را وارد کنید.",
                    pattern:'فرمت وارد شده معتبر نمی باشد.'
                                                
						
                }
					
            },
				
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال ثبت ....");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            window.location=responseText;
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                        }
										
										
							
										
										
							
                        jQuery("#submit-contact").attr("value", "ثبت نام");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#register-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#register-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                mobile: {
                    required: true,
                    pattern: /(09)\d{9}$/
                                                
						
                }
					
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                mobile: {
                    required: "لطفا شماره تلفن  همراه خود را وارد کنید.",
                    pattern:'فرمت وارد شده معتبر نمی باشد.'
                                                
						
                }
					
            },
				
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال ثبت ....");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            window.location=responseText;
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                           
                        }
										
										
							
										
										
							
                        jQuery("#submit-contact").attr("value", "ثبت نام");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#verify-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#verify-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                code: {
                    required: true			
                }
					
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                code: {
                    required: "لطفا کد تایید را وارد کنید."				
                }
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال بررسی ...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            window.location=responseText;
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "بررسی");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#account-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#account-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                name: {
                    required: true			
                },
                username: {
                    required: true			
                },
                password: {
                    required: true,
                    minlength : 5
                },
                rep_password: {
                    required: true,
                    equalTo : "#account_password"
                },
                email:{
                    email:true
                }
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                name: {
                    required: "لطفا نام و نام خانوادگی را وارد کنید."				
                },
                username: {
                    required: "لطفا نام کاربری را وارد کنید."				
                },
                password: {
                    required: "لطفا کلمه عبور را وارد کنید.",
                    minlength: jQuery.format("وارد کردن حداقل 5 کاراکتر برای کلمه عبور الزامی است.")
                },
                rep_password: {
                    required: "لطفا تکرار کلمه عبور را وارد کنید",
                    equalTo: "تکرار کلمه عبور اشتباه است."
                },
                email: {
                    email: "فرمت ایمیل وارد شده معتبر نیست."				
                }
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال ثبت اطلاعات ...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            jQuery('#account-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            window.location=responseArray['url'];
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "ثبت نام نهایی");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#login-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#login-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
               
                username: {
                    required: true			
                },
                password: {
                    required: true,
                   
                }
		
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
               
                username: {
                    required: "لطفا نام کاربری را وارد کنید."				
                },
                password: {
                    required: "لطفا کلمه عبور را وارد کنید.",
                     
                }
                
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "در حال ورود به سایت ...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            jQuery('#login-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            window.location=responseArray['url'];
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "ورود");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    
    if(jQuery("#password-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#password-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                old_password: {
                    required: true,
                   
                },
                password: {
                    required: true,
                    minlength : 5
                },
                rep_password: {
                    required: true,
                    equalTo : "#account_password"
                },
                email:{
                    email:true
                }
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                old_password: {
                    required: "لطفا کلمه عبور فعلی را وارد کنید."
                    
                },
                password: {
                    required: "لطفا کلمه عبور جدید را وارد کنید.",
                    minlength: jQuery.format("وارد کردن حداقل 5 کاراکتر برای کلمه عبور الزامی است.")
                },
                rep_password: {
                    required: "لطفا تکرار کلمه عبور جدید را وارد کنید",
                    equalTo: "تکرار کلمه عبور جدید اشتباه است."
                },
               
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "لطفا منتظر بمانید ... ");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            jQuery('#password-form')[0].reset();
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            //window.location=responseArray['url'];
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "ارسال");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#profile-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#profile-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                name: {
                    required: true			
                },
               
                email:{
                    email:true
                }
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                name: {
                    required: "لطفا نام و نام خانوادگی را وارد کنید."				
                },
               
                email: {
                    email: "فرمت ایمیل وارد شده معتبر نیست."				
                }
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "لطفا منتظر بمانید...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                          
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                           
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "ارسال");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#service-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#service-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                title: {
                    required: true			
                },
                cat_id: {
                    required: true			
                },
                subcat_id: {
                    required: true			
                },
                state_id: {
                    required: true			
                },
                city_id: {
                    required: true			
                }
                
                
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                title: {
                    required: "عنوان خدمات را وارد کنید."				
                },
               
                
					
            },		
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").html("لطفا منتظر بمانید...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
                //return;					
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            jQuery('#service-form')[0].reset();
                            $('select').select2('val', 'All');
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                           
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").html("ثبت اطلاعات");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
    if(jQuery("#forget-form").length > 0)
    {
        jQuery("#response2").html('').hide();
        // Validate the contact form
        jQuery('#forget-form').validate({
				
            debug:true,
            // Add requirements to each of the fields
            rules: {
                mobile: {
                    required: true,
                    pattern: /(09)\d{9}$/
                                                
						
                }
					
            },
				
            // Specify what error messages to display
            // when the user does something horrid
            messages: {
                mobile: {
                    required: "لطفا شماره تلفن  همراه خود را وارد کنید.",
                    pattern:'فرمت وارد شده معتبر نمی باشد.'
                                                
						
                }
					
            },
				
            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-forget").attr("disabled", "disabled");
                jQuery("#submit-forget").attr("value", "لطفا منتظر بمانید...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            //window.location=responseText;
                            jQuery('#forget-form')[0].reset();
                            
                            var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response2").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }
                        else
                        {
                            var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            jQuery("#response2").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                           
                        }
										
										
							
										
										
							
                        jQuery("#submit-forget").attr("value", "ارسال");
                        jQuery("#submit-forget").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }          
    if(jQuery("#pay-form").length > 0)
    {
        jQuery("#response").html('').hide();
        // Validate the contact form
        jQuery('#pay-form').validate({

            // Use Ajax to send everything to processForm.php
            submitHandler: function(form) {
                jQuery("#submit-contact").attr("disabled", "disabled");
                jQuery("#submit-contact").attr("value", "لطفا منتظر بمانید...");
                // jQuery("#submit-comment").attr("value", "در حال ثبت ....");
							
                jQuery(form).ajaxSubmit({
                    success: function(data, statusText, xhr, $form) 
                    {
                        // alert('ok');
                        var responseArray = JSON.parse(data);
                        var responseText=responseArray['message'];
                        var responseResult=responseArray['result'];
                        if(responseResult=='success')
                        {
                            //jQuery('#login-form')[0].reset();
                            //var html='<div class="alert alert-success" role="alert"><i class="fa fa-check fa-2x"></i> '+responseText+'</div>';
                            //jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            //window.location=responseArray['url'];
                            
                        }
                        else
                        {
                            //var html='<div class="alert alert-danger" role="alert"><i class="fa fa-warning fa-2x"></i> '+responseText+'</div>';
                            //jQuery("#response").html(html).hide().slideDown("fast").delay(3000).slideUp("fast");
                            
                        }				
                        jQuery("#submit-contact").attr("value", "پرداخت آنلاین");
                        jQuery("#submit-contact").removeAttr("disabled");
                    //jQuery("#submit-comment").attr("value", "ثبت دیدگاه شما");
                    //jQuery('#contact-form')[0].reset();
                    }
                });
                return false;
            }
        });
    }
   
    
});
