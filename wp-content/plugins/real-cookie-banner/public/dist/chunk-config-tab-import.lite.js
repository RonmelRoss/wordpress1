(self.webpackChunkrealCookieBanner_name_=self.webpackChunkrealCookieBanner_name_||[]).push([[357],{8155:function(e,t,a){"use strict";a.r(t),a.d(t,{ImportExportCards:function(){return z}});var n=a(9707),r=a(7984),l=a(3875),c=a(3554),o=a(6438),i=a(5744),u=a(150),s=a.n(u),m=a(2780),p=a(6428),_=a(7099),d=a(5038),E=a(2918),R=a(5450),k=a.n(R),f=a(175),b=a(6526),g=a.n(b),y=a(8714),v=a.n(y),h=a(1593),Z=a(6310),S=a.n(Z),x=a(3804),C=a(8990),P=a(4393),w=a(518),I=a.n(w),F=a(2867),D=(0,c.Pi)((function(e){var t=e.result,a=(0,x.useCallback)((function(e){var t=e.fix,a=e.settingsTab,n=e.cookieDuplicate,r=e.cookie,l=e.blockerDuplicate,c=e.blocker,i=e.href;switch(t){case"settings":return React.createElement("a",{href:"#/settings/".concat(a),target:"_blank",rel:"noreferrer"},(0,o.__)("Set manually"));case"cookieDuplicate":var u=S()(n.original,2),s=u[0],m=u[1],p=S()(n.duplicate,2),_=p[0],d=p[1];return React.createElement(React.Fragment,null,React.createElement("a",{href:"#/cookies/".concat(s,"/edit/").concat(m),target:"_blank",rel:"noreferrer"},(0,o.__)("Open original"))," ","•"," ",React.createElement("a",{href:"#/cookies/".concat(_,"/edit/").concat(d),target:"_blank",rel:"noreferrer"},(0,o.__)("Open newly created")));case"cookie":var E=S()(r,2),R=E[0],k=E[1];return React.createElement("a",{href:"#/cookies/".concat(R,"/edit/").concat(k),target:"_blank",rel:"noreferrer"},(0,o.__)("Check manually"));case"blockerDuplicate":var f=l.original,b=l.duplicate;return React.createElement(React.Fragment,null,React.createElement("a",{href:"#/blocker/edit/".concat(f),target:"_blank",rel:"noreferrer"},(0,o.__)("Open original"))," ","•"," ",React.createElement("a",{href:"#/blocker/edit/".concat(b),target:"_blank",rel:"noreferrer"},(0,o.__)("Open newly created")));case"blocker":return React.createElement("a",{href:"#/blocker/edit/".concat(c),target:"_blank",rel:"noreferrer"},(0,o.__)("Check manually"));case"link":return React.createElement("a",{href:i,target:"_blank",rel:"noreferrer"},(0,o.__)("Set manually"));default:return null}}),[]);return t?React.createElement(React.Fragment,null,React.createElement(F.Z,{style:{marginTop:0}},(0,o.__)("Result")),t.messages.map((function(e,t){var n=e.message,r=e.severity,l=I()(e,["message","severity"]);return React.createElement("div",{key:t,className:"notice notice-".concat(r," inline below-h2 notice-alt"),style:{margin:"10px 0 0 0"}},React.createElement("p",null,React.createElement("span",{dangerouslySetInnerHTML:{__html:n}}),!!l.fix&&React.createElement(React.Fragment,null," • ",a(l))))}))):null})),Y=a(5924),N={labelCol:{span:24},wrapperCol:{span:24}},T=(0,c.Pi)((function(){var e,t=(0,C.m)(),a=t.cookieStore,n=t.optionStore,r=a.groups,l=a.busy,c=h.Z.useForm(),u=S()(c,1)[0],R=(0,x.useState)(!1),b=S()(R,2),y=b[0],Z=b[1],w=(0,x.useState)(void 0),I=S()(w,2),F=I[0],T=I[1];(0,x.useEffect)((function(){a.fetchGroups()}),[]);var B=(0,x.useCallback)(function(){var e=v()(k().mark((function e(t){return k().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return Z(!0),e.prev=1,e.t0=T,e.next=5,(0,o.WY)({location:P.H,request:g()({cookieGroup:0,cookieStatus:"keep",cookieSkipExisting:!0,blockerStatus:"keep",blockerSkipExisting:!0},t)});case 5:e.t1=e.sent,(0,e.t0)(e.t1),n.fetchCurrentRevision(),n.fetchSettings(),f.ZP.success((0,o.__)("Successfully imported!")),e.next=15;break;case 12:e.prev=12,e.t2=e.catch(1),f.ZP.error(e.t2.responseJSON.message);case 15:return e.prev=15,Z(!1),e.finish(15);case 18:case"end":return e.stop()}}),e,null,[[1,12,15,18]])})));return function(t){return e.apply(this,arguments)}}(),[]),L=(0,x.useCallback)((function(e){var t=new FileReader;return t.readAsText(e,"UTF-8"),t.onload=function(e){return u.setFieldsValue({json:e.target.result})},t.onerror=function(){return u.setFieldsValue({json:(0,o.__)("File could not be read.")})},!1}),[u]),V=(0,x.useCallback)((function(e,t){try{var a=JSON.parse(e);return!t||!!a[t]}catch(e){return!1}}),[]);return React.createElement(i.Z,{spinning:y||l},React.createElement(h.Z,s()({name:"import",form:u},N,{initialValues:{json:"",cookieStatus:"keep",cookieSkipExisting:!0,blockerStatus:"keep",blockerSkipExisting:!0},onFinish:B}),React.createElement(h.Z.Item,{label:(0,o.__)("Content to import"),required:!0},React.createElement(h.Z.Item,{name:"json",rules:[{required:!0,message:(0,o.__)("Please provide a value!")}]},React.createElement(E.Z.TextArea,{rows:5})),React.createElement("p",{className:"description"},(0,o.__)("or select a file to upload:")),React.createElement(d.Z,{accept:"application/json",showUploadList:!1,beforeUpload:L},React.createElement("a",{className:"button"},React.createElement(Y.Z,null)," ",(0,o.__)("Select File")))),React.createElement(h.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.json!==t.json}},(function(e){var t=e.getFieldValue;return V(t("json"),"cookies")&&React.createElement(h.Z.Item,{label:(0,o.__)("Fallback cookie group"),required:!0},React.createElement(h.Z.Item,{name:"cookieGroup",noStyle:!0,rules:[{required:!0,message:(0,o.__)("Please provide a group!")}]},React.createElement(_.Z,{style:{width:"70%"}},r.sortedGroups.map((function(e){var t=e.data,a=t.id,n=t.name;return React.createElement(_.Z.Option,{key:a,value:a},n)})))),React.createElement("p",{className:"description"},(0,o.__)("Select an alternative group to which the cookie should be assigned in case an imported cookie cannot be assigned to its original group.")))})),React.createElement(h.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.json!==t.json}},(function(e){var t=e.getFieldValue;return V(t("json"),"cookies")&&React.createElement(React.Fragment,null,React.createElement(h.Z.Item,null,React.createElement("span",null,React.createElement(h.Z.Item,{name:"cookieSkipExisting",valuePropName:"checked",noStyle:!0},React.createElement(p.Z,null)),React.createElement("span",null,"  ",(0,o.__)("Skip already existing cookies")))),React.createElement(h.Z.Item,{label:(0,o.__)("Set cookie status"),name:"cookieStatus",rules:[{required:!0,message:(0,o.__)("Please choose a status!")}]},React.createElement(m.ZP.Group,null,React.createElement(m.ZP.Button,{value:"keep"},(0,o.__)("Keep")),React.createElement(m.ZP.Button,{value:"publish"},(0,o.__)("Enabled")),React.createElement(m.ZP.Button,{value:"private"},(0,o.__)("Disabled")),React.createElement(m.ZP.Button,{value:"draft"},(0,o.__)("Draft")))))})),React.createElement(h.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.json!==t.json}},(function(e){var t=e.getFieldValue;return V(t("json"),"blocker")&&React.createElement(React.Fragment,null,React.createElement(h.Z.Item,null,React.createElement("span",null,React.createElement(h.Z.Item,{name:"blockerSkipExisting",valuePropName:"checked",noStyle:!0},React.createElement(p.Z,null)),React.createElement("span",null,"  ",(0,o.__)("Skip already existing content blocker")))),React.createElement(h.Z.Item,{label:(0,o.__)("Set content blocker status"),name:"blockerStatus",rules:[{required:!0,message:(0,o.__)("Please choose a status!")}]},React.createElement(m.ZP.Group,null,React.createElement(m.ZP.Button,{value:"keep"},(0,o.__)("Keep")),React.createElement(m.ZP.Button,{value:"publish"},(0,o.__)("Enabled")),React.createElement(m.ZP.Button,{value:"private"},(0,o.__)("Disabled")),React.createElement(m.ZP.Button,{value:"draft"},(0,o.__)("Draft")))))})),React.createElement(h.Z.Item,null,React.createElement("input",{type:"submit",className:"button button-primary",style:{marginTop:10},value:(0,o.__)("Import")})),React.createElement(h.Z.Item,{style:{display:null!=F&&null!==(e=F.messages)&&void 0!==e&&e.length?"block":"none"}},React.createElement(D,{result:F}))))})),B=a(8911),L=a(9438),V=a(7057),j=a(6480),U={labelCol:{span:24},wrapperCol:{span:24}},M=(0,c.Pi)((function(){var e=(0,C.m)().optionStore.others.hints.export,t=h.Z.useForm(),a=S()(t,1)[0],n=(0,x.useState)(!1),r=S()(n,2),l=r[0],c=r[1],u=(0,x.useState)(""),m=S()(u,2),p=m[0],_=m[1],d=(0,x.useCallback)(function(){var e=v()(k().mark((function e(t){return k().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return c(!0),e.prev=1,e.t0=_,e.t1=JSON,e.next=6,(0,o.WY)({location:j.V,params:t});case 6:e.t2=e.sent,e.t3=e.t1.stringify.call(e.t1,e.t2),(0,e.t0)(e.t3);case 9:return e.prev=9,c(!1),e.finish(9);case 12:case"end":return e.stop()}}),e,null,[[1,,9,12]])})));return function(t){return e.apply(this,arguments)}}(),[]),R=(0,x.useCallback)((function(){(0,L.v)(p),f.ZP.success((0,o.__)("Export successfully copied to the clipboard."))}),[p]),b=(0,x.useCallback)((function(e){return v()(k().mark((function e(){return k().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:c(!0),window.location.href=(0,o.Y4)({location:j.V,params:g()(g()({},a.getFieldsValue()),{},{download:!0})}),c(!1);case 3:case"end":return e.stop()}}),e)})))(),e.preventDefault(),!1}),[c,a]);return React.createElement(i.Z,{spinning:l},React.createElement(h.Z,s()({name:"export",form:a},U,{initialValues:{settings:!0,cookieGroups:!0,cookies:!0,blocker:!0,customizeBanner:!0},onFinish:d}),React.createElement(h.Z.Item,{label:(0,o.__)("Content to export")},React.createElement("div",null,React.createElement(h.Z.Item,{name:"settings",noStyle:!0,valuePropName:"checked"},React.createElement(B.Z,null,(0,o.__)("Settings")))),React.createElement("div",null,React.createElement(h.Z.Item,{name:"cookieGroups",noStyle:!0,valuePropName:"checked"},React.createElement(B.Z,null,(0,o.__)("Cookie Groups")))),React.createElement("div",null,React.createElement(h.Z.Item,{name:"cookies",noStyle:!0,valuePropName:"checked"},React.createElement(B.Z,null,(0,o.__)("Cookies")))),React.createElement("div",null,React.createElement(h.Z.Item,{name:"blocker",noStyle:!0,valuePropName:"checked"},React.createElement(B.Z,null,(0,o.__)("Content Blocker")))),React.createElement("div",null,React.createElement(h.Z.Item,{name:"customizeBanner",noStyle:!0,valuePropName:"checked"},React.createElement(B.Z,null,(0,o.__)("Cookie banner customization"))))),React.createElement(h.Z.Item,null,React.createElement("input",{type:"submit",className:"button button-primary",style:{marginTop:10},value:(0,o.__)("Export")}),React.createElement("input",{onClick:b,type:"submit",className:"button",style:{margin:"10px 0 0 10px"},value:(0,o.__)("Download JSON")}),e.length>0&&React.createElement("div",{className:"notice notice-info inline below-h2 notice-alt",style:{margin:"10px 0 0 0"}},React.createElement("p",null,(0,V.E)(e.join("\n\n"))))),React.createElement(h.Z.Item,{style:{display:p?"block":"none"}},React.createElement(h.Z.Item,{noStyle:!0},React.createElement(F.Z,{style:{marginTop:0}},(0,o.__)("Result")),React.createElement(E.Z.TextArea,{onClick:R,value:p,readOnly:!0,rows:5})),React.createElement("p",{className:"description"},(0,o.__)('Copy the exported content and paste it into the "Import" textarea of your target WordPress installation.')))))})),q=a(4880),O=a(8193),G=a(2470),A=a.n(G),J={labelCol:{span:24},wrapperCol:{span:24}},W=(0,c.Pi)((function(){var e=h.Z.useForm(),t=S()(e,1)[0],a=(0,x.useState)(!1),n=S()(a,2),r=n[0],l=n[1],c=(0,x.useState)(!1),u=S()(c,2),p=u[0],_=u[1],d=(0,x.useCallback)((function(){v()(k().mark((function e(){var a,n,r,c;return k().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:l(!0),_(!0),a=t.getFieldsValue(),n=a.uuid,r=a.date,c=(0,o.Y4)({location:O.Q,params:{uuid:n||"",from:(null==r?void 0:r[0].format("YYYY-MM-DD"))||"",to:(null==r?void 0:r[1].format("YYYY-MM-DD"))||""}}),window.open(c,"_blank"),l(!1);case 6:case"end":return e.stop()}}),e)})))()}),[l,_,t]);return React.createElement(i.Z,{spinning:r},React.createElement(h.Z,s()({name:"export",form:t},J,{initialValues:{by:"",date:[],uuid:""},onFinish:d}),React.createElement(h.Z.Item,{label:(0,o.__)("Export by"),required:!0},React.createElement(h.Z.Item,{name:"by",noStyle:!0,rules:[{required:!0,message:(0,o.__)("Please select an option!")}]},React.createElement(m.ZP.Group,null,React.createElement(m.ZP.Button,{value:"date"},(0,o.__)("Date range")),React.createElement(m.ZP.Button,{value:"uuid"},(0,o.__)("UUID"))))),React.createElement(h.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.by!==t.by}},(function(e){return"date"===(0,e.getFieldValue)("by")&&React.createElement(h.Z.Item,{name:"date",label:(0,o.__)("Date range"),required:!0,rules:[{type:"array",required:!0,message:(0,o.__)("Please provide a valid date range!")}]},React.createElement(q.D,{disabledDate:function(e){return!e||e.isAfter(A()())}}))})),React.createElement(h.Z.Item,{noStyle:!0,shouldUpdate:function(e,t){return e.by!==t.by}},(function(e){return"uuid"===(0,e.getFieldValue)("by")&&React.createElement(h.Z.Item,{name:"uuid",label:(0,o.__)("UUID"),required:!0,rules:[{required:!0,pattern:/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/,message:(0,o.__)("Please provide a valid UUID!")}]},React.createElement(E.Z,null))})),React.createElement(h.Z.Item,null,React.createElement("input",{type:"submit",className:"button button-primary",style:{marginTop:10},value:(0,o.__)("Download CSV")})),p&&React.createElement("div",{className:"notice notice-info inline below-h2 notice-alt",style:{margin:"10px 0 0 0"}},React.createElement("p",null,(0,o.__)("The CSV file can be very large because data in this format is redundant per line. In your WordPress database the consents are much smaller.")))))})),z=(0,c.Pi)((function(){return React.createElement(n.Z,null,React.createElement(r.Z,{xl:16,sm:16,xs:24},React.createElement(l.Z,{style:{margin:10},title:(0,o.__)("Import")},React.createElement(T,null))),React.createElement(r.Z,{xl:8,sm:8,xs:24},React.createElement(l.Z,{style:{margin:10},title:(0,o.__)("Export")},React.createElement(M,null)),React.createElement(l.Z,{style:{margin:10},title:(0,o.__)("Export consents")},React.createElement(W,null))))}))},4880:function(e,t,a){"use strict";a.d(t,{D:function(){return s}});var n=a(150),r=a.n(n),l=a(6582),c=a(6438),o=a(2470),i=a.n(o),u=l.Z.RangePicker,s=function(e){var t=i().localeData();return React.createElement(u,r()({locale:{lang:{locale:i().locale(),placeholder:(0,c.__)("Select date"),rangePlaceholder:[(0,c.__)("Start date"),(0,c.__)("End date")],today:(0,c.__)("Today"),now:(0,c.__)("Now"),backToToday:(0,c.__)("Back to today"),ok:(0,c.__)("OK"),clear:(0,c.__)("Clear"),month:(0,c.__)("Month"),year:(0,c.__)("Year"),timeSelect:(0,c.__)("Select time"),dateSelect:(0,c.__)("Select date"),monthSelect:(0,c.__)("Choose a month"),yearSelect:(0,c.__)("Choose a year"),decadeSelect:(0,c.__)("Choose a decade"),yearFormat:"YYYY",dateFormat:t.longDateFormat("LL"),dayFormat:"D",dateTimeFormat:t.longDateFormat("LLL"),monthFormat:"MMMM",monthBeforeYear:!0,previousMonth:(0,c.__)("Previous month (PageUp)"),nextMonth:(0,c.__)("Next month (PageDown)"),previousYear:(0,c.__)("Last year (Control + left)"),nextYear:(0,c.__)("Next year (Control + right)"),previousDecade:(0,c.__)("Last decade"),nextDecade:(0,c.__)("Next decade"),previousCentury:(0,c.__)("Last century"),nextCentury:(0,c.__)("Next century")},timePickerLocale:{placeholder:(0,c.__)("Select time")},dateFormat:t.longDateFormat("LL"),dateTimeFormat:t.longDateFormat("LLL"),weekFormat:"YYYY-wo",monthFormat:"YYYY-MM"}},e))}},9438:function(e,t,a){"use strict";function n(e){var t=document.createElement("textarea");t.innerText=e,document.body.appendChild(t),t.select(),document.execCommand("copy"),t.remove()}a.d(t,{v:function(){return n}})},7057:function(e,t,a){"use strict";a.d(t,{E:function(){return l}});var n=a(3804),r=/(\r\n|\r|\n|<br[ ]?\/>)/g,l=function(e){return e.split(r).map((function(e,t){return e.match(r)?(0,n.createElement)("br",{key:t}):e}))}}}]);
//# sourceMappingURL=chunk-config-tab-import.lite.js.map?ver=7642473506357f6746c1