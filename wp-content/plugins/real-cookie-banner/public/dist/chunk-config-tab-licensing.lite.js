(self.webpackChunkrealCookieBanner_name_=self.webpackChunkrealCookieBanner_name_||[]).push([[322],{217:function(e,t,n){"use strict";n.d(t,{f:function(){return c}});var a=n(6526),r=n.n(a),c=function(e){var t=e.children,n=e.maxWidth,a=void 0===n?"auto":n,c=e.style,o=void 0===c?{}:c;return React.createElement("div",{className:"rcb-config-content",style:r()({maxWidth:"fixed"===a?1300:a},o)},t)}},4828:function(e,t,n){"use strict";n.r(t),n.d(t,{ConfigLicensing:function(){return v}});var a=n(3554),r=n(6187),c=n(3875),o=n(2491),i=n(1593),l=n(6412),s=n(5744),u=n(3804),m=n(8990),f=n(6438),d=(0,a.Pi)((function(){var e=(0,r.useStores)().pluginUpdateStore,t=e.busy,n=e.pluginUpdate,a=(0,m.m)(),d=a.optionStore,p=a.checklistStore,v=d.slug,y=d.others,g=y.isPro,b=y.showLicenseFormImmediate,E=d.publicUrl;(0,u.useEffect)((function(){return e.setFromSlug(v),function(){e.hideLicense()}}),[]);var h=(0,u.useCallback)((function(){p.fetchChecklist(),d.setShowLicenseFormImmediate(!1)}),[p,d]),x=(0,u.useCallback)((function(){d.setShowLicenseFormImmediate(!1),n.skip()}),[n,d]);return(0,u.useEffect)((function(){b&&null!=n&&n.hasInteractedWithFormOnce&&x()}),[n,b,x]),t||!n?React.createElement(s.Z,{spinning:!0}):React.createElement(React.Fragment,null,b&&React.createElement("div",{style:{maxWidth:650,textAlign:"center",margin:"0 auto 20px"}},React.createElement(l.C,{src:"".concat(E,"images/logos/real-cookie-banner.svg"),shape:"square",size:130,style:{backgroundColor:"white",padding:25,borderRadius:999}}),!g&&React.createElement("p",{style:{fontSize:15}},(0,f._i)((0,f.__)("Before we start configuring your cookie banner, you can {{strong}}obtain your free license to enjoy all the benefits{{/strong}} of the free version of Real Cookie Banner. The cookies are already waiting for you. Get started now!"),{strong:React.createElement("strong",null)}))),React.createElement(c.Z,{title:g||n.isLicensed?(0,f.__)("License activation"):(0,f.__)("Get your free license")},React.createElement(o.Z,{direction:"vertical",size:"large"},!n.isLicensed&&React.createElement("p",{className:"description"},g?(0,f.__)("Activate your Real Cookie Banner PRO license to receive regular updates and support. You find your license key in the customer center of devowl.io."):(0,f._i)((0,f.__)("To use all advantages of Real Cookie Banner {{strong}}you need a free license{{/strong}}. After license activation you will receive answers to support requests and announcements in your plugin (e.g. also notices for discount actions of the PRO version)."),{strong:React.createElement("strong",null)})),React.createElement(r.PluginUpdateEmbed,{formProps:{onSave:h,onFailure:b&&!g?x:void 0,footer:React.createElement(i.Z.Item,{style:{margin:"25px 0 0",textAlign:b?"center":void 0}},React.createElement("input",{type:"submit",className:"button button-primary",value:b?g?(0,f.__)("Activate license & continue"):(0,f.__)("Activate free license & Continue"):(0,f.__)("Save")}))},listProps:{onDeactivate:h}}))),b&&React.createElement("div",{style:{textAlign:"center",marginTop:20}},React.createElement("a",{className:"button-link",onClick:x},g?(0,f.__)("Continue without regular updates and without any support"):(0,f.__)("Continue without any support and without e.g. discount announcements"))))})),p=n(217),v=(0,a.Pi)((function(){return React.createElement(p.f,{maxWidth:800,style:{margin:"auto"}},React.createElement(r.Provider,null,React.createElement(d,null)))}))},6412:function(e,t,n){"use strict";n.d(t,{C:function(){return k}});var a=n(150),r=n.n(a),c=n(1781),o=n.n(c),i=n(867),l=n.n(i),s=n(6310),u=n.n(s),m=n(3804),f=n(2286),d=n.n(f),p=n(2177),v=n(5643),y=n(7079),g=n(3631),b=n(4952),E=n(3490),h=m.createContext("default"),x=function(e){var t=e.children,n=e.size;return m.createElement(h.Consumer,null,(function(e){return m.createElement(h.Provider,{value:n||e},t)}))},C=h,O=function(e,t){var n,a,c=m.useContext(C),i=m.useState(1),s=u()(i,2),f=s[0],h=s[1],x=m.useState(!1),O=u()(x,2),N=O[0],P=O[1],Z=m.useState(!0),w=u()(Z,2),S=w[0],R=w[1],k=m.useRef(),_=m.useRef(),j=(0,v.sQ)(t,k),z=m.useContext(y.E_).getPrefixCls,T=function(){if(_.current&&k.current){var t=_.current.offsetWidth,n=k.current.offsetWidth;if(0!==t&&0!==n){var a=e.gap,r=void 0===a?4:a;2*r<n&&h(n-2*r<t?(n-2*r)/t:1)}}};m.useEffect((function(){P(!0)}),[]),m.useEffect((function(){R(!0),h(1)}),[e.src]),m.useEffect((function(){T()}),[e.gap]);var A=e.prefixCls,L=e.shape,I=e.size,B=e.src,F=e.srcSet,W=e.icon,K=e.className,G=e.alt,U=e.draggable,D=e.children,H=function(e,t){var n={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(n[a]=e[a]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(n[a[r]]=e[a[r]])}return n}(e,["prefixCls","shape","size","src","srcSet","icon","className","alt","draggable","children"]),q="default"===I?c:I,M=(0,E.Z)(),Q=m.useMemo((function(){if("object"!==l()(q))return{};var e=b.c4.find((function(e){return M[e]})),t=q[e];return t?{width:t,height:t,lineHeight:"".concat(t,"px"),fontSize:W?t/2:18}:{}}),[M,q]);(0,g.Z)(!("string"==typeof W&&W.length>2),"Avatar","`icon` is using ReactNode instead of string naming in v4. Please check `".concat(W,"` at https://ant.design/components/icon"));var V,X=z("avatar",A),Y=d()((n={},o()(n,"".concat(X,"-lg"),"large"===q),o()(n,"".concat(X,"-sm"),"small"===q),n)),J=m.isValidElement(B),$=d()(X,Y,(a={},o()(a,"".concat(X,"-").concat(L),L),o()(a,"".concat(X,"-image"),J||B&&S),o()(a,"".concat(X,"-icon"),W),a),K),ee="number"==typeof q?{width:q,height:q,lineHeight:"".concat(q,"px"),fontSize:W?q/2:18}:{};if("string"==typeof B&&S)V=m.createElement("img",{src:B,draggable:U,srcSet:F,onError:function(){var t=e.onError;!1!==(t?t():void 0)&&R(!1)},alt:G});else if(J)V=B;else if(W)V=W;else if(N||1!==f){var te="scale(".concat(f,") translateX(-50%)"),ne={msTransform:te,WebkitTransform:te,transform:te},ae="number"==typeof q?{lineHeight:"".concat(q,"px")}:{};V=m.createElement(p.Z,{onResize:T},m.createElement("span",{className:"".concat(X,"-string"),ref:function(e){_.current=e},style:r()(r()({},ae),ne)},D))}else V=m.createElement("span",{className:"".concat(X,"-string"),style:{opacity:0},ref:function(e){_.current=e}},D);return delete H.onError,delete H.gap,m.createElement("span",r()({},H,{style:r()(r()(r()({},ee),Q),H.style),className:$,ref:j}),V)},N=m.forwardRef(O);N.displayName="Avatar",N.defaultProps={shape:"circle",size:"default"};var P=N,Z=n(4237),w=n(6219),S=n(2481),R=P;R.Group=function(e){var t=m.useContext(y.E_),n=t.getPrefixCls,a=t.direction,r=e.prefixCls,c=e.className,i=void 0===c?"":c,l=e.maxCount,s=e.maxStyle,u=e.size,f=n("avatar-group",r),p=d()(f,o()({},"".concat(f,"-rtl"),"rtl"===a),i),v=e.children,g=e.maxPopoverPlacement,b=void 0===g?"top":g,E=(0,Z.Z)(v).map((function(e,t){return(0,w.Tm)(e,{key:"avatar-key-".concat(t)})})),h=E.length;if(l&&l<h){var C=E.slice(0,l),O=E.slice(l,h);return C.push(m.createElement(S.Z,{key:"avatar-popover-key",content:O,trigger:"hover",placement:b,overlayClassName:"".concat(f,"-popover")},m.createElement(P,{style:s},"+".concat(h-l)))),m.createElement(x,{size:u},m.createElement("div",{className:p,style:e.style},C))}return m.createElement(x,{size:u},m.createElement("div",{className:p,style:e.style},E))};var k=R},3875:function(e,t,n){"use strict";n.d(t,{Z:function(){return b}});var a=n(1781),r=n.n(a),c=n(150),o=n.n(c),i=n(3804),l=n(2286),s=n.n(l),u=n(2465),m=n(7079),f=function(e){var t=e.prefixCls,n=e.className,a=e.hoverable,c=void 0===a||a,l=function(e,t){var n={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(n[a]=e[a]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(n[a[r]]=e[a[r]])}return n}(e,["prefixCls","className","hoverable"]);return i.createElement(m.C,null,(function(e){var a=(0,e.getPrefixCls)("card",t),u=s()("".concat(a,"-grid"),n,r()({},"".concat(a,"-grid-hoverable"),c));return i.createElement("div",o()({},l,{className:u}))}))},d=n(2173),p=n(9707),v=n(7984),y=n(6166),g=function(e){var t,n,a,c=i.useContext(m.E_),l=c.getPrefixCls,g=c.direction,b=i.useContext(y.Z),E=e.prefixCls,h=e.className,x=e.extra,C=e.headStyle,O=void 0===C?{}:C,N=e.bodyStyle,P=void 0===N?{}:N,Z=e.title,w=e.loading,S=e.bordered,R=void 0===S||S,k=e.size,_=e.type,j=e.cover,z=e.actions,T=e.tabList,A=e.children,L=e.activeTabKey,I=e.defaultActiveTabKey,B=e.tabBarExtraContent,F=e.hoverable,W=e.tabProps,K=void 0===W?{}:W,G=function(e,t){var n={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(n[a]=e[a]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(n[a[r]]=e[a[r]])}return n}(e,["prefixCls","className","extra","headStyle","bodyStyle","title","loading","bordered","size","type","cover","actions","tabList","children","activeTabKey","defaultActiveTabKey","tabBarExtraContent","hoverable","tabProps"]),U=l("card",E),D=0===P.padding||"0px"===P.padding?{padding:24}:void 0,H=i.createElement("div",{className:"".concat(U,"-loading-block")}),q=i.createElement("div",{className:"".concat(U,"-loading-content"),style:D},i.createElement(p.Z,{gutter:8},i.createElement(v.Z,{span:22},H)),i.createElement(p.Z,{gutter:8},i.createElement(v.Z,{span:8},H),i.createElement(v.Z,{span:15},H)),i.createElement(p.Z,{gutter:8},i.createElement(v.Z,{span:6},H),i.createElement(v.Z,{span:18},H)),i.createElement(p.Z,{gutter:8},i.createElement(v.Z,{span:13},H),i.createElement(v.Z,{span:9},H)),i.createElement(p.Z,{gutter:8},i.createElement(v.Z,{span:4},H),i.createElement(v.Z,{span:3},H),i.createElement(v.Z,{span:16},H))),M=void 0!==L,Q=o()(o()({},K),(t={},r()(t,M?"activeKey":"defaultActiveKey",M?L:I),r()(t,"tabBarExtraContent",B),t)),V=T&&T.length?i.createElement(d.Z,o()({size:"large"},Q,{className:"".concat(U,"-head-tabs"),onChange:function(t){e.onTabChange&&e.onTabChange(t)}}),T.map((function(e){return i.createElement(d.Z.TabPane,{tab:e.tab,disabled:e.disabled,key:e.key})}))):null;(Z||x||V)&&(a=i.createElement("div",{className:"".concat(U,"-head"),style:O},i.createElement("div",{className:"".concat(U,"-head-wrapper")},Z&&i.createElement("div",{className:"".concat(U,"-head-title")},Z),x&&i.createElement("div",{className:"".concat(U,"-extra")},x)),V));var X,Y=j?i.createElement("div",{className:"".concat(U,"-cover")},j):null,J=i.createElement("div",{className:"".concat(U,"-body"),style:P},w?q:A),$=z&&z.length?i.createElement("ul",{className:"".concat(U,"-actions")},function(e){return e.map((function(t,n){return i.createElement("li",{style:{width:"".concat(100/e.length,"%")},key:"action-".concat(n)},i.createElement("span",null,t))}))}(z)):null,ee=(0,u.Z)(G,["onTabChange"]),te=k||b,ne=s()(U,(n={},r()(n,"".concat(U,"-loading"),w),r()(n,"".concat(U,"-bordered"),R),r()(n,"".concat(U,"-hoverable"),F),r()(n,"".concat(U,"-contain-grid"),(i.Children.forEach(e.children,(function(e){e&&e.type&&e.type===f&&(X=!0)})),X)),r()(n,"".concat(U,"-contain-tabs"),T&&T.length),r()(n,"".concat(U,"-").concat(te),te),r()(n,"".concat(U,"-type-").concat(_),!!_),r()(n,"".concat(U,"-rtl"),"rtl"===g),n),h);return i.createElement("div",o()({},ee,{className:ne}),a,Y,J,$)};g.Grid=f,g.Meta=function(e){return i.createElement(m.C,null,(function(t){var n=t.getPrefixCls,a=e.prefixCls,r=e.className,c=e.avatar,l=e.title,u=e.description,m=function(e,t){var n={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(n[a]=e[a]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(n[a[r]]=e[a[r]])}return n}(e,["prefixCls","className","avatar","title","description"]),f=n("card",a),d=s()("".concat(f,"-meta"),r),p=c?i.createElement("div",{className:"".concat(f,"-meta-avatar")},c):null,v=l?i.createElement("div",{className:"".concat(f,"-meta-title")},l):null,y=u?i.createElement("div",{className:"".concat(f,"-meta-description")},u):null,g=v||y?i.createElement("div",{className:"".concat(f,"-meta-detail")},v,y):null;return i.createElement("div",o()({},m,{className:d}),p,g)}))};var b=g},7984:function(e,t,n){"use strict";var a=n(1349);t.Z=a.Z},3490:function(e,t,n){"use strict";var a=n(6310),r=n.n(a),c=n(3804),o=n(4952);t.Z=function(){var e=(0,c.useState)({}),t=r()(e,2),n=t[0],a=t[1];return(0,c.useEffect)((function(){var e=o.ZP.subscribe((function(e){a(e)}));return function(){return o.ZP.unsubscribe(e)}}),[]),n}},2481:function(e,t,n){"use strict";var a=n(150),r=n.n(a),c=n(3804),o=n(7452),i=n(7079),l=n(3305),s=c.forwardRef((function(e,t){var n=e.prefixCls,a=e.title,s=e.content,u=function(e,t){var n={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(n[a]=e[a]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var r=0;for(a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(n[a[r]]=e[a[r]])}return n}(e,["prefixCls","title","content"]),m=(0,c.useContext(i.E_).getPrefixCls)("popover",n);return c.createElement(o.Z,r()({},u,{prefixCls:m,ref:t,overlay:function(e){return c.createElement(c.Fragment,null,a&&c.createElement("div",{className:"".concat(e,"-title")},(0,l.Z)(a)),c.createElement("div",{className:"".concat(e,"-inner-content")},(0,l.Z)(s)))}(m)}))}));s.displayName="Popover",s.defaultProps={placement:"top",transitionName:"zoom-big",trigger:"hover",mouseEnterDelay:.1,mouseLeaveDelay:.1,overlayStyle:{}},t.Z=s},9707:function(e,t,n){"use strict";var a=n(5147);t.Z=a.Z}}]);
//# sourceMappingURL=chunk-config-tab-licensing.lite.js.map?ver=c1b8c361194a8d62dc52