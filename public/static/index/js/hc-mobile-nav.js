/*!
 * jQuery HC-MobileNav
 * ===================
 * Version: 3.0.0
 * Author: Some Web Media
 * Author URL: http://somewebmedia.com
 * Plugin URL: https://github.com/somewebmedia/hc-mobile-nav
 * Description: jQuery plugin for creating toggled mobile multi-level navigations
 * License: MIT
 */
!function(y,e){"use strict";var a,l,x=e.document,T=(/iPad|iPhone|iPod/.test(navigator.userAgent)||!!navigator.platform&&/iPad|iPhone|iPod/.test(navigator.platform))&&!e.MSStream,w="ontouchstart"in e||navigator.maxTouchPoints||e.DocumentTouch&&x instanceof DocumentTouch,O=function(e){return!isNaN(parseFloat(e))&&isFinite(e)},B=function(e){return e.stopPropagation()},M=function(n,a,l){return function(e){n&&e.preventDefault(),a&&e.stopPropagation(),"function"==typeof l&&l()}},P=(a=y("head"),l="hc-mobile-nav-style",function(e){var n=a.find("style#"+l);n.length?n.html(e):y('<style id="'+l+'">'+e+"</style>").appendTo(a)}),N=function(e,n,a){var l=a.children("li"),o=l.length,i=-1<n?Math.max(0,Math.min(n-1,o)):Math.max(0,Math.min(o+n+1,o));0===i?a.prepend(e):l.eq(i-1).after(e)},S=0;y.fn.extend({hcMobileNav:function(e){if(!this.length)return this;var l,m=y.extend({},{maxWidth:1024,appendTo:"body",clone:!0,offCanvas:!0,side:"left",levelOpen:"overlap",levelSpacing:40,levelTitles:!1,navTitle:null,navClass:"",disableBody:!0,closeOnClick:!0,customToggle:null,responsive:null,insertClose:!0,insertBack:!0,labelClose:"Reset",labelBack:"Back"},e),k=y(x.getElementsByTagName("html")[0]),b=(y(x),y(x.body)),C=(l=function(e){var n=["Webkit","Moz","Ms","O"],a=(x.body||x.documentElement).style,l=e.charAt(0).toUpperCase()+e.slice(1);if(void 0!==a[e])return e;for(var o=0;o<n.length;o++)if(void 0!==a[n[o]+l])return n[o]+l;return!1}("transform"),function(e,n){if(l){var a="left"===m.side?n:-n;e.css(l,"translate3d("+a+"px,0,0)")}else e.css(m.side,n)});return this.each(function(){var e=y(this),n=void 0,a=!1,l=0;if(e.is("ul"))n=e.clone().wrap("<nav>").parent();else if(e.is("nav"))n=e.clone();else if(!(n=e.find("nav, ul").first().clone()).length)return void console.log("%c! HC MobileNav:%c There is no <nav> or <ul> elements in your menu.","color: red","color: black");var o=n.find("ul");if(o.length){var p={},i=void 0,v="hc-nav-"+ ++S;e.addClass("hc-nav "+v),m.customToggle?i=y(m.customToggle).addClass(v).on("click",u):(i=y('<a class="hc-nav-trigger '+v+'"><span></span></a>').on("click",u),e.after(i));var r=n.children("ul").wrapAll('<div class="nav-wrapper nav-wrapper-1">').parent().on("click",B).wrap('<div class="nav-container">').parent();m.navTitle&&r.children().prepend("<h2>"+m.navTitle+"</h2>");var t="\n          .hc-mobile-nav."+v+" {\n            display: block;\n          }\n          .hc-nav-trigger."+v+",\n          "+m.customToggle+"."+v+" {\n            display: "+(i.css("display")||"block")+"\n          }\n          .hc-nav."+v+" {\n            display: none;\n          }";if(m.maxWidth&&(t="@media screen and (max-width: "+(m.maxWidth-1)+"px) {\n            "+t+"\n          }"),P(t),n.on("click",B).removeAttr("id").removeClass().addClass("\n            hc-mobile-nav\n            "+v+"\n            "+(m.navClass||"")+"\n            nav-levels-"+(m.levelOpen||"none")+"\n            side-"+m.side+"\n            "+(m.offCanvas?"off-canvas":"")+"\n            "+(m.disableBody?"disable-body":"")+"\n            "+(T?"is-ios":"")+"\n            "+(w?"touch-device":"")+"\n          ").find("[id]").removeAttr("id"),m.disableBody&&n.on("click",h),m.closeOnClick&&o.find("li").children("a").on("click",h),!1!==m.insertClose){var s=y();s.children("a").on("click",M(!0,!0,h)),!0===m.insertClose?o.first().prepend(s):O(m.insertClose)&&N(s,m.insertClose,o.first().add(o.siblings("ul")))}o.each(function(){var e=y(this),n=e.parents("li").length;if(0!==n){var a=e.parent().addClass("nav-parent"),l=a.children("a");p[n]||(p[n]=[]),p[n].push({nav:e});var o=p[n].length-1;p[n][o].wrapper=e.closest(".nav-wrapper");var i=e.wrap('<div class="nav-wrapper nav-wrapper-'+(n+1)+'">').parent().on("click",B);if(!m.levelSpacing||"expand"!==m.levelOpen&&!1!==m.levelOpen&&"none"!==m.levelOpen||e.css("text-indent",m.levelSpacing*n+"px"),!1===m.levelOpen||"none"===m.levelOpen)return;!0===m.levelTitles&&i.prepend("<h2>"+l.text()+"</h2>");var t=y('<span class="nav-next">').appendTo(l),r=y('<label for="'+v+"-"+n+"-"+o+'">').on("click",B),s=y('<input type="checkbox" id="'+v+"-"+n+"-"+o+'">').attr("data-level",n).attr("data-index",o).on("click",B).on("change",d);if(p[n][o].checkbox=s,a.prepend(s),l.attr("href")&&"#"!==l.attr("href")?t.append(r):l.on("click",M(!0,!0)).prepend(r),!1!==m.insertBack&&"overlap"===m.levelOpen){var c=y('<li class="nav-back"><a href="#">'+(m.labelBack||"")+"<span></span></a></li>");c.children("a").on("click",M(!0,!0,function(){return g(n,o)})),!0===m.insertBack?e.prepend(c):O(m.insertBack)&&N(c,m.insertBack,e)}}}),m.clone?y(m.appendTo).append(n):e.replaceWith(n);var c=function(e,n){if(p[e]&&p[e][n]){var a=p[e][n].checkbox,l=a.parent("li"),o=p[e][n].wrapper;a.prop("checked",!1),o.removeClass("sub-level-open"),l.removeClass("level-open")}}}else console.log("%c! HC MobileNav:%c Menu must contain <ul> element.","color: red","color: black");function d(){var e,n,a,l,o=y(this),i=Number(o.attr("data-level")),t=Number(o.attr("data-index"));o.prop("checked")?(n=t,a=p[e=i][n].checkbox.parent("li"),(l=p[e][n].wrapper).addClass("sub-level-open"),a.addClass("level-open"),"overlap"===m.levelOpen&&(l.on("click",function(){return g(e,n)}),C(r,e*m.levelSpacing))):g(i,t)}function f(){a=!0,n.addClass("nav-open"),i.addClass("toggle-open"),m.disableBody&&(l=k.scrollTop()||b.scrollTop(),b.addClass("hc-nav-open"),l&&b.css("top",-l),x.body.scrollHeight>x.body.offsetHeight&&k.addClass("hc-yscroll"))}function h(){a=!1,n.removeClass("nav-open"),r.removeAttr("style"),i.removeClass("toggle-open"),!1!==m.levelOpen&&"none"!==m.levelOpen&&g(0),m.disableBody&&(b.removeClass("hc-nav-open"),k.removeClass("hc-yscroll"),l&&(b.css("top","").scrollTop(l),k.scrollTop(l),l=0))}function u(e){e.preventDefault(),e.stopPropagation(),a?h():f()}function g(e,n){for(var a=e;a<=Object.keys(p).length;a++){if(0!==a)if(a==e&&void 0!==n){if(c(a,n),"overlap"===m.levelOpen)p[a][n].wrapper.off("click").on("click",B),C(r,(a-1)*m.levelSpacing)}else for(var l in p[a]){if(c(a,l),"overlap"===m.levelOpen)p[a][l].wrapper.off("click").on("click",B),a==e&&C(r,(a-1)*m.levelSpacing)}}}})}})}(jQuery,"undefined"!=typeof window?window:this);