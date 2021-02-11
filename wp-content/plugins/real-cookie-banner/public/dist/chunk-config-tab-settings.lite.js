(self.webpackChunkrealCookieBanner_name_=self.webpackChunkrealCookieBanner_name_||[]).push([[768],{217:function(e,t,a){"use strict";a.d(t,{f:function(){return r}});var n=a(6526),o=a.n(n),r=function(e){var t=e.children,a=e.maxWidth,n=void 0===a?"auto":a,r=e.style,c=void 0===r?{}:r;return React.createElement("div",{className:"rcb-config-content",style:o()({maxWidth:"fixed"===n?1300:n},c)},t)}},4908:function(e,t,a){"use strict";a.r(t),a.d(t,{SettingsForm:function(){return M}});var n=a(5744),o=a(150),r=a.n(o),c=a(5450),i=a.n(c),l=a(175),s=a(6526),u=a.n(s),m=a(8714),d=a.n(m),p=a(7256),h=a.n(p),f=a(1593),g=a(6310),y=a.n(g),b=a(2173),v=a(3804),E=a(3554),_=a(6438),R=a(2918),k=a(2780),w=a(8990),Z=a(9095),S=(0,E.Pi)((function(){var e=(0,w.m)().optionStore.others.isPro;return React.createElement(React.Fragment,null,React.createElement(f.Z.Item,{label:(0,_.__)("Automatically accept all cookies for bots")},React.createElement(f.Z.Item,{name:"acceptAllForBots",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},(0,_.__)("Bots cannot give consent to the setting of cookies. As a result, they may consider your site as slow if a cookie banner permanently blocks all other content. Therefore, you should allow the bots to browse your site without consent, but still set all cookies."))),React.createElement(f.Z.Item,{label:(0,_.__)('Respect "Do Not Track"')},React.createElement(f.Z.Item,{name:"respectDoNotTrack",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},(0,_.__)('Users can set the "Do not track" HTTP header in their browser to indicate that they do not want to be tracked. Most cookies are used for tracking. Therefore, if you enable this option, users with this HTTP header can access your site without a cookie banner and only the essential cookies will be set.'))),React.createElement(React.Fragment,null),React.createElement(f.Z.Item,{label:(0,_.__)("Duration of cookie consent")},React.createElement(f.Z.Item,{name:"cookieDuration",wrapperCol:{span:6},style:{marginBottom:0}},React.createElement(R.Z,{addonAfter:(0,_.__)("days"),type:"number"})),React.createElement("p",{className:"description"},(0,_.__)("The consent of a user to set cookies should be limited in time. You can specify how long the consent is valid. If you change the behaviour or content of the cookie banner in the meantime, visitors of your website must give their consent again, even if it has not yet expired."))),React.createElement(f.Z.Item,{label:(0,_.__)("Age notice for consent")},React.createElement(f.Z.Item,{name:"ageNotice",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},(0,_._i)((0,_.__)("In accordance with {{a}}Article 8 EU GDPR{{/a}}, consent to cookies and services that process personal data can only be given from the age of 16 years (varying in some EU countries) or together with an legal guardian. If your website does not clearly and exclusively address adults (e.g. dating or porn sites), you as the website operator must inform children under the minimum age in simple language that they are not allowed to consent to non-essential cookies without the consent of their legal guardian."),{a:React.createElement("a",{href:(0,_.__)("https://gdpr-info.eu/art-8-gdpr/"),target:"_blank",rel:"noreferrer"})}))),React.createElement(f.Z.Item,{label:(0,_.__)("Consent for data processing in the USA")},React.createElement(f.Z.Item,{name:"ePrivacyUSA",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{disabled:!e,value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{disabled:!e,value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},React.createElement(Z.g,{title:(0,_.__)("Do you need consent for US data processing?"),testDrive:!0,feature:"eprivacy-usa",assetName:(0,_.__)("pro-modal/eprivacy-usa.png"),description:(0,_.__)("The Privacy Shield should ensure that data processed in the US are treated at the same level of data protection as in the EU. However, the ECJ has declared the Privacy Shield to be illegal (ECJ, 16.7.2020 - C-311/18). In our opinion, the only way to legally use US services like Google Analytics or YouTube is to obtain a consent to do so.")}),(0,_._i)((0,_.__)("The Privacy Shield should ensure that data processed in the US are treated at the same level of data protection as in the EU. However, the ECJ has declared the Privacy Shield to be illegal (ECJ, 16.7.2020 - C-311/18), as the level of data protection in the US does not match the level of data protection in the EU and violates fundamental rights of EU citizens. This means that you are no longer allowed to use services that process data in the USA or pass on data to affiliated companies from that country (e. g. Google). In practice, however, exclusion from US services is often not possible. {{a}}Lawyer Dr. Schwenke suggests as a possible solution the consent to process data in the coookie banner.{{/a}} Activate this option to be able to mark cookies in its definition that they process data in the USA and obtain the consent of their users for this in your cookie banner."),{a:React.createElement("a",{href:(0,_.__)("https://datenschutz-generator.de/eugh-privacy-shield-unwirksam/#Einwilligung_im_CookieBanner_als_Loesung"),target:"_blank",rel:"noreferrer"})}))),React.createElement(f.Z.Item,{label:(0,_.__)("Save IP address on consent")},React.createElement(f.Z.Item,{name:"saveIp",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},(0,_.__)("Depending on your country of origin, it may make legal sense to store the IP address of the user who consents to cookies. But on the other hand, you must inform the user in your privacy policy that you are saving this IP address together with the consent, as from a legal point of view this is a personal date."))))})),C=a(9438),P=a(7099),I=a(7450),T=a(5493),N=function(e){var t=e.value,a=e.multiple,o=e.disabled,r=e.onChange,c=(0,v.useState)(t),l=y()(c,2),s=l[0],u=l[1],m=(0,v.useState)(!1),p=y()(m,2),h=p[0],f=p[1],g=(0,v.useState)({}),b=y()(g,2),E=b[0],R=b[1],k=(0,v.useCallback)(d()(i().mark((function e(){var t;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return f(!0),e.next=3,(0,_.WY)({location:T.A,params:{filter:"notCurrent"}});case 3:t=e.sent,R(t),f(!1);case 6:case"end":return e.stop()}}),e)}))),[]);return(0,v.useEffect)((function(){k()}),[]),React.createElement(P.Z,{mode:a?"multiple":void 0,disabled:o,value:s,notFoundContent:h?React.createElement(n.Z,{size:"small"}):React.createElement(I.Z,{description:(0,_.__)("No additional sites endpoints found.")}),onChange:function(e){u(e),null==r||r(e)},filterOption:!1,loading:h},!a&&!h&&React.createElement(P.Z.Option,{value:0},(0,_.__)("— Select —")),Object.keys(E).map((function(e){return React.createElement(P.Z.Option,{key:e,value:e},E[e])})))},A=(0,E.Pi)((function(){var e=(0,v.useState)(!1),t=y()(e,2),a=t[0],o=(t[1],(0,v.useState)({})),r=y()(o,2),c=r[0],i=(r[1],(0,w.m)().optionStore.others.isPro),s=(0,v.useCallback)((function(e){return(0,C.v)(e.target.parentElement.previousElementSibling.value),l.ZP.success((0,_.__)("Successfully copied to the clipboard!")),e.preventDefault(),!1}),[]),u=(0,_.__)("https://devowl.io/knowledge-base/cookie-banner-consent-forwarding-setup/");return React.createElement(React.Fragment,null,React.createElement(f.Z.Item,{label:(0,_.__)("Consent Forwarding")},React.createElement(f.Z.Item,{name:"consentForwarding",noStyle:!0},React.createElement(k.ZP.Group,null,React.createElement(k.ZP.Button,{disabled:!i,value:!0},(0,_.__)("Enabled")),React.createElement(k.ZP.Button,{disabled:!i,value:!1},(0,_.__)("Disabled")))),React.createElement("p",{className:"description"},React.createElement(Z.g,{title:(0,_.__)("One consent for all your websites?"),testDrive:!0,feature:"consent-forwarding",assetName:(0,_.__)("pro-modal/consent-forwarding.png"),description:(0,_.__)("In WordPress multisites or multiple instances of WordPress running for one organization, you only need to obtain cookie consent once. Consents are automatically forwarded, so your visitor only needs to accept cookies once, instead of on each site again.")}),(0,_._i)((0,_.__)("You can ask the user for consent on one site, and the consent applies to other sites in a WordPress multisite installation or other standalone WordPress installations. This is useful if you run multiple WordPress sites for one organization. For example, you have a company page, landing page, and blog, and you want to show the user as few cookie banners as possible. {{a}}Learn more about how to configure the forwarding of consents.{{/a}}"),{a:React.createElement("a",{href:u,target:"_blank",rel:"noreferrer"})}))),React.createElement(f.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.consentForwarding!==t.consentForwarding}},(function(e){var t=(0,e.getFieldValue)("consentForwarding");return i&&t&&React.createElement(React.Fragment,null,React.createElement(f.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return JSON.stringify(e.forwardTo)!==JSON.stringify(t.forwardTo)||JSON.stringify(e.crossDomains)!==JSON.stringify(t.crossDomains)}},(function(e){var t=e.getFieldValue;return(JSON.stringify(t("forwardTo"))+JSON.stringify(t("crossDomains"))).indexOf("http://")>-1&&React.createElement(f.Z.Item,{wrapperCol:{offset:6}},React.createElement("div",{className:"notice notice-warning inline below-h2 notice-alt",style:{margin:0}},React.createElement("p",null,(0,_._i)((0,_.__)("One of your configured endpoints is using an insecure protocol (not HTTPS). For security reasons, most modern browsers reject and block the use of cross-domain cookies on unsecured pages. {{a}}Learn more.{{/a}}"),{a:React.createElement("a",{href:"https://www.chromestatus.com/feature/5633521622188032",rel:"noreferrer",target:"_blank"})}))))})),React.createElement(f.Z.Item,{label:(0,_.__)("Forward to")},React.createElement(f.Z.Item,{name:"forwardTo",noStyle:!0},React.createElement(N,{multiple:!0})),React.createElement("p",{className:"description"},(0,_.__)("Select all sites to which the consent of the user on the current site should be forwarded."))),React.createElement(n.Z,{spinning:a},React.createElement(f.Z.Item,{label:(0,_.__)("External 'Forward To' endpoints")},React.createElement(f.Z.Item,{name:"crossDomains",noStyle:!0},React.createElement(R.Z.TextArea,{autoSize:{minRows:3}})),React.createElement("p",{className:"description"},(0,_.__)("This option is only required if you want to forward consent to another WordPress installation. Please enter one URL endpoint of the Real Cookie Banner WP REST API per line. Below you find a list of all available endpoints of this WordPress installation.")),Object.keys(c).map((function(e){return React.createElement("p",{key:e},React.createElement("label",null,c[e]),React.createElement(R.Z,{value:e,readOnly:!0,addonAfter:React.createElement("button",{className:"button-link alignright",onClick:s},(0,_.__)("Copy to clipboard"))}))})))))})))})),D=a(3590),x=a(847),B=a(217),F={labelCol:{span:6},wrapperCol:{span:16}},O=b.Z.TabPane,M=(0,E.Pi)((function(){var e=(0,x.useRouteMatch)(),t=e.params,a=e.path,o=(0,v.useState)(!1),c=y()(o,2),s=c[0],m=c[1],p=t.tab||"",g=(0,x.useHistory)(),E=f.Z.useForm(),R=y()(E,1)[0],k=(0,w.m)(),Z=k.optionStore,C=k.checklistStore,P=Z.busySettings,I=Z.bannerActive,T=Z.blockerActive,N=Z.refreshSiteAfterConsent,M=Z.imprintId,U=Z.privacyPolicyId,W=Z.hidePageIds,G=Z.setCookiesViaManager,L=Z.acceptAllForBots,J=Z.respectDoNotTrack,H=Z.cookieDuration,V=Z.saveIp,Y=Z.ePrivacyUSA,z=Z.ageNotice,j=Z.consentForwarding,K=Z.forwardTo,q=Z.crossDomains,Q=Z.affiliateLink,X=Z.affiliateLabelBehind,$=Z.affiliateLabelDescription,ee={bannerActive:I,blockerActive:T,refreshSiteAfterConsent:N,imprintId:M,privacyPolicyId:U,hidePageIds:h()(W),setCookiesViaManager:G,acceptAllForBots:L,respectDoNotTrack:J,cookieDuration:H,saveIp:V,ePrivacyUSA:Y,ageNotice:z,consentForwarding:j,forwardTo:h()(K),crossDomains:q,affiliateLink:Q,affiliateLabelBehind:X,affiliateLabelDescription:$},te=(0,v.useCallback)(d()(i().mark((function e(){var t,n,o;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=!1===(null===(t=C.items.filter((function(e){return"save-settings"===e.id}))[0])||void 0===t?void 0:t.checked),o=R.getFieldsValue(),e.next=4,Z.updateSettings(u()(u()({},ee),o));case 4:l.ZP.success((0,_.__)("Successfully updated settings!")),m(!1),n&&""===p&&g.push(a.replace(":tab?","consent"));case 7:case"end":return e.stop()}}),e)}))),[R,Z,ee,C]),ae=(0,v.useCallback)((function(e){return!(!e.pathname.startsWith("/settings/")&&s)||(0,_.__)("You have unsaved changes. If you click on confirm, your changes will be discarded.")}),[R,ee]),ne=(0,v.useMemo)((function(){return React.createElement(f.Z.Item,{className:"rcb-form-sticky-submit"},React.createElement("span",null,React.createElement("input",{type:"submit",className:"button button-primary right",value:(0,_.__)("Save settings")})))}),[]);return React.createElement(n.Z,{spinning:P},React.createElement(f.Z,r()({name:"settings",initialValues:ee,form:R},F,{onFinish:te,onValuesChange:function(){return m(!0)}}),React.createElement(x.Prompt,{message:ae}),React.createElement(f.Z.Item,{noStyle:!0,labelCol:{span:0},wrapperCol:{span:24}},React.createElement(x.Switch,null,React.createElement(React.Fragment,null,React.createElement(b.Z,{activeKey:p,onTabClick:function(e){g.push(a.replace(":tab?",e))}},React.createElement(O,{tab:(0,_.__)("General"),key:""},React.createElement(B.f,{maxWidth:"fixed"},React.createElement(D.DR,null),ne)),React.createElement(O,{tab:(0,_.__)("Consent"),key:"consent"},React.createElement(B.f,{maxWidth:"fixed"},React.createElement(S,null),ne)),React.createElement(O,{tab:(0,_.__)("Multisite / Consent Forwarding"),key:"multisite"},React.createElement(B.f,{maxWidth:"fixed"},React.createElement(A,null),ne)),!1))))))}))},3590:function(e,t,a){"use strict";a.d(t,{DR:function(){return p},Gh:function(){return m},Ki:function(){return d}});var n=a(2780),o=a(1593),r=a(6428),c=a(3554),i=a(6438),l=a(980),s=a(9095),u=a(8990),m="Google Tag Manager",d="Matomo Tag Manager",p=(0,c.Pi)((function(){var e=(0,u.m)().optionStore.others.isPro;return React.createElement(React.Fragment,null,React.createElement(o.Z.Item,{label:(0,i.__)("Cookie Banner/Dialog")},React.createElement(o.Z.Item,{noStyle:!0,name:"bannerActive",valuePropName:"checked"},React.createElement(r.Z,null)),React.createElement("p",{className:"description",style:{marginTop:5}},(0,i.__)("You can enable and disable the cookie banner. We recommend to activate the cookie banner on your website after you have added all cookies."))),React.createElement(o.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.bannerActive!==t.bannerActive}},(function(e){var t=e.getFieldValue;return React.createElement(o.Z.Item,{label:(0,i.__)("Content Blocker"),style:{display:t("bannerActive")?void 0:"none"}},React.createElement(o.Z.Item,{name:"blockerActive",valuePropName:"checked",noStyle:!0},React.createElement(r.Z,{style:{marginTop:5}})),React.createElement("p",{className:"description",style:{marginTop:5}},(0,i.__)("This feature allows you to block content that would set cookies, but for which you do not yet have the visitor's consent.")))})),React.createElement(o.Z.Item,{label:(0,i.__)("Refresh site after consent")},React.createElement(o.Z.Item,{name:"refreshSiteAfterConsent",noStyle:!0},React.createElement(n.ZP.Group,null,React.createElement(n.ZP.Button,{value:!1},(0,i.__)("Do not refresh")),React.createElement(n.ZP.Button,{value:!0},(0,i.__)("Refresh")))),React.createElement("p",{className:"description"},(0,i.__)("Depending on how cookies are set e. g. by other plugins on your website, it may be necessary to reload the website after the user has given his consent to set cookies (only necessary in very rare cases)."))),React.createElement(o.Z.Item,{label:(0,i.__)("Hide cookie banner on specific pages")},React.createElement("p",{className:"description",style:{marginTop:7}},(0,i.__)("According to the ePrivacy Directive, legally mandatory pages such as the privacy policy or the imprint should be accessible without the need for the user to consent to cookies. Therefore, it is recommended to avoid cookies on these pages and not to display a cookie banner.")),React.createElement(o.Z.Item,{label:(0,i.__)("Imprint page"),labelCol:{span:24},wrapperCol:{span:12},style:{marginBottom:12}},React.createElement(o.Z.Item,{name:"imprintId",noStyle:!0},React.createElement(l.m,{postType:"pages",forceDefaultLanguage:!0,postStatus:["publish"],perPage:100}))),React.createElement(o.Z.Item,{label:(0,i.__)("Privacy policy page"),labelCol:{span:24},wrapperCol:{span:12},style:{marginBottom:12}},React.createElement(o.Z.Item,{name:"privacyPolicyId",noStyle:!0},React.createElement(l.m,{postType:"pages",forceDefaultLanguage:!0,postStatus:["publish"],perPage:100}))),React.createElement(o.Z.Item,{label:React.createElement(React.Fragment,null,(0,i.__)("Hide on additional pages")," ",React.createElement(s.g,{title:(0,i.__)("Want to hide cookie banner on more pages?"),testDrive:!0,feature:"hide-page-ids",description:(0,i.__)("Cookie banners are legally necessary, but distract your users from the essential. For example, on landing pages for advertising campaigns they lead to poorer conversation rates. On these pages it can be useful to do without cookies to keep the conversation rate high. You can hide the cookie banner on these pages.")})),labelCol:{span:24},wrapperCol:{span:12},style:{marginBottom:12}},React.createElement(o.Z.Item,{name:"hidePageIds",noStyle:!0},React.createElement(l.m,{postType:"pages",multiple:!0,disabled:!e,forceDefaultLanguage:!0,postStatus:["publish"],perPage:100})))),React.createElement(o.Z.Item,{label:(0,i.__)("Set cookies after consent via")},React.createElement(o.Z.Item,{name:"setCookiesViaManager",noStyle:!0},React.createElement(n.ZP.Group,null,React.createElement(n.ZP.Button,{disabled:!e,value:"none"},(0,i.__)("HTML/JavaScript Snippet")),React.createElement(n.ZP.Button,{disabled:!e,value:"googleTagManager"},(0,i.__)("%s Event",m)),React.createElement(n.ZP.Button,{disabled:!e,value:"matomoTagManager"},(0,i.__)("%s Event",d)))),React.createElement("p",{className:"description"},React.createElement(s.g,{title:(0,i.__)("Want to use a Tag Manager legally?"),testDrive:!0,feature:"set-cookies-via-manager",assetName:(0,i.__)("pro-modal/set-cookies-via-manager.png"),description:(0,i.__)("You can integrate services via Google Tag Manager or Matomo Tag Manager. At the same time, you can obtain and document consents via Real Cookie Banner in accordance with data protection regulations.")}),React.createElement("strong",null,(0,i.__)("You only need to change this option if you use Google Tag Manager or Matomo Tag Manager."))," ",(0,i.__)("If you opt-in to or opt-out from cookies, you will normally execute JavaScript code to ensure that scripts are enabled/disabled and cookies are set/removed on the visitor client. If you are a Google Tag Manager or Matomo Tag Manager user, you can map this behavior by using tags that are triggered by an event in the data layer. If you enable this option, the Google Tag Manager or Matomo Tag Manager should not yet be integrated into your website. Instead, you must integrate it as an opt-in script of a cookie you create for the Tag Manager. For each cookie (service) listed in this plugin, you will receive an additional field where you can specify the name of the event that is automatically triggered when the user opt-in or opt-out. We have a full integration for Tag Manager which should allow you to run it legally compliant in the EU."))))}))},980:function(e,t,a){"use strict";a.d(t,{m:function(){return y}});var n=a(7099),o=a(5744),r=a(5450),c=a.n(r),i=a(6526),l=a.n(i),s=a(8714),u=a.n(s),m=a(6310),d=a.n(m),p=a(3804),h=a(6438),f=a(1786),g=a(8685),y=function(e){var t=e.postType,a=e.postStatus,r=void 0===a?["draft","publish","private"]:a,i=e.perPage,s=void 0===i?10:i,m=e.value,y=e.multiple,b=e.disabled,v=e.forceDefaultLanguage,E=e.onChange,_=e.filter,R=void 0===_?function(){return!0}:_,k=(0,p.useState)(!1),w=d()(k,2),Z=w[0],S=w[1],C=(0,p.useState)(m),P=d()(C,2),I=P[0],T=P[1],N=(0,p.useState)(!1),A=d()(N,2),D=A[0],x=A[1],B=(0,p.useState)([]),F=d()(B,2),O=F[0],M=F[1],U=(0,p.useCallback)(function(){var e=u()(c().mark((function e(a){var n,o,i,s;return c().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return x(!0),n=(0,f.u)(),o=n.defaultLanguage,i=n.currentLanguage,e.next=4,(0,h.WY)({location:{path:"/".concat(t),method:g.RouteHttpVerb.GET,namespace:"wp/v2"},request:l()({status:a.include?["draft","publish","private"]:r,orderby:a.search?"relevance":"title"},a),params:{rcbForceLang:v?o:i}});case 4:s=e.sent,M(s),x(!1);case 7:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),[]);return function(e,t,a,n){var o=(0,p.useState)(e),r=d()(o,2),c=r[0],i=r[1];(0,p.useEffect)((function(){var a=setTimeout((function(){i(e)}),t);return null==n||n(e),function(){clearTimeout(a)}}),[e]),(0,p.useEffect)((function(){var e;!1!==(e=c)&&U({search:e,per_page:e.length?50:s})}),[c])}(Z,""===Z?0:800,0,(function(e){!1!==e&&x(!0),M([])})),(0,p.useEffect)((function(){(I>0||Array.isArray(I)&&I.length>0)&&U({include:Array.isArray(I)?I:[I]})}),[]),(0,p.useEffect)((function(){JSON.stringify(I)!==JSON.stringify(m)&&(m>0||Array.isArray(m)&&m.length>0)&&(T(m),U({include:Array.isArray(m)?m:[m]}))}),[m,I]),React.createElement(n.Z,{mode:y?"multiple":void 0,disabled:b,showSearch:!0,value:I,placeholder:(0,h.__)("Search..."),notFoundContent:D?React.createElement(o.Z,{size:"small"}):null,onClick:function(){return S("")},onSearch:S,onChange:function(e){var t=Array.isArray(e)?e.map(Number):+e;T(t),null==E||E(t)},filterOption:!1,loading:D},!y&&!D&&React.createElement(n.Z.Option,{value:0},(0,h.__)("— Select —")),O.filter(R).map((function(e){return React.createElement(n.Z.Option,{key:e.id,value:e.id},e.title.rendered)})))}},9095:function(e,t,a){"use strict";a.d(t,{g:function(){return c}});var n=a(518),o=a.n(n),r=a(7812),c=function(e){e.children;var t=e.wrapperAttributes,a=void 0===t?{}:t,n=o()(e,["children","wrapperAttributes"]),c=(0,r.t)(n),i=c.modal,l=c.tag;return React.createElement(React.Fragment,null,i,React.createElement("span",a,l))}},9438:function(e,t,a){"use strict";function n(e){var t=document.createElement("textarea");t.innerText=e,document.body.appendChild(t),t.select(),document.execCommand("copy"),t.remove()}a.d(t,{v:function(){return n}})},6428:function(e,t,a){"use strict";a.d(t,{Z:function(){return w}});var n=a(150),o=a.n(n),r=a(1781),c=a.n(r),i=a(3804),l=a(499),s=a(8008),u=a(4097),m=a(2286),d=a.n(m),p=a(8833),h=a(5065),f=i.forwardRef((function(e,t){var a,n=e.prefixCls,o=void 0===n?"rc-switch":n,r=e.className,c=e.checked,m=e.defaultChecked,f=e.disabled,g=e.loadingIcon,y=e.checkedChildren,b=e.unCheckedChildren,v=e.onClick,E=e.onChange,_=e.onKeyDown,R=(0,u.Z)(e,["prefixCls","className","checked","defaultChecked","disabled","loadingIcon","checkedChildren","unCheckedChildren","onClick","onChange","onKeyDown"]),k=(0,p.Z)(!1,{value:c,defaultValue:m}),w=(0,s.Z)(k,2),Z=w[0],S=w[1];function C(e,t){var a=Z;return f||(S(a=e),null==E||E(a,t)),a}var P=d()(o,r,(a={},(0,l.Z)(a,"".concat(o,"-checked"),Z),(0,l.Z)(a,"".concat(o,"-disabled"),f),a));return i.createElement("button",Object.assign({},R,{type:"button",role:"switch","aria-checked":Z,disabled:f,className:P,ref:t,onKeyDown:function(e){e.which===h.Z.LEFT?C(!1,e):e.which===h.Z.RIGHT&&C(!0,e),null==_||_(e)},onClick:function(e){var t=C(!Z,e);null==v||v(t,e)}}),g,i.createElement("span",{className:"".concat(o,"-inner")},Z?y:b))}));f.displayName="Switch";var g=f,y=a(5621),b=a.n(y),v=a(397),E=a(7079),_=a(6166),R=a(3631),k=i.forwardRef((function(e,t){var a,n=e.prefixCls,r=e.size,l=e.loading,s=e.className,u=void 0===s?"":s,m=e.disabled,p=function(e,t){var a={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(a[n]=e[n]);if(null!=e&&"function"==typeof Object.getOwnPropertySymbols){var o=0;for(n=Object.getOwnPropertySymbols(e);o<n.length;o++)t.indexOf(n[o])<0&&Object.prototype.propertyIsEnumerable.call(e,n[o])&&(a[n[o]]=e[n[o]])}return a}(e,["prefixCls","size","loading","className","disabled"]);(0,R.Z)("checked"in p||!("value"in p),"Switch","`value` is not a valid prop, do you mean `checked`?");var h=i.useContext(E.E_),f=h.getPrefixCls,y=h.direction,k=i.useContext(_.Z),w=f("switch",n),Z=i.createElement("div",{className:"".concat(w,"-handle")},l&&i.createElement(b(),{className:"".concat(w,"-loading-icon")})),S=d()((a={},c()(a,"".concat(w,"-small"),"small"===(r||k)),c()(a,"".concat(w,"-loading"),l),c()(a,"".concat(w,"-rtl"),"rtl"===y),a),u);return i.createElement(v.Z,{insertExtraNode:!0},i.createElement(g,o()({},p,{prefixCls:w,className:S,disabled:m||l,ref:t,loadingIcon:Z})))}));k.__ANT_SWITCH=!0,k.displayName="Switch";var w=k}}]);
//# sourceMappingURL=chunk-config-tab-settings.lite.js.map?ver=b3f6abcb91d96fb55031