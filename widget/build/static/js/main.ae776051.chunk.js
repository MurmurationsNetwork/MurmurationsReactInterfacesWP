(this.webpackJsonpwidget=this.webpackJsonpwidget||[]).push([[0],{242:function(e,t,a){},494:function(e,t,a){"use strict";a.r(t);var n=a(0),r=a(62),i=a.n(r),s=(a(242),a(10)),c=a(236),o=a(235),l=a.n(o),d=a(2);var j=function(e){if(!e.value)return null;if(e.value===Object(e.value)&&!Array.isArray(e.value))return null;var t=e.value,a=e.field,n=e.attribs,r=e.nodeData;Array.isArray(t)&&(t=t.join(", "));var i="";if(1==n.showLabel){var s=n.label;i=Object(d.jsx)("div",{className:"node-field-label "+a,children:s})}else i="";return n.truncate&&t.length>n.truncate&&(t=t.slice(0,n.truncate)+"..."),n.link&&(t=Object(d.jsx)("a",{href:r[n.link],children:t})),Object(d.jsxs)("div",{className:"node-field "+a,children:[i,Object(d.jsx)("div",{className:"node-field-value "+a,children:t})]})};var u=function(e){var t=[];if("HTML"==e.settings.apiNodeFormat)t=Object(d.jsx)("div",{dangerouslySetInnerHTML:{__html:e.nodeData}});else if(e.settings.directoryDisplaySchema)for(var a in e.settings.directoryDisplaySchema)e.settings.directoryDisplaySchema.hasOwnProperty(a)&&t.push(Object(d.jsx)(j,{field:a,value:e.nodeData[a],attribs:e.settings.directoryDisplaySchema[a],nodeData:e.nodeData}));return Object(d.jsx)("div",{className:"directory-node",children:t})};var m=function(e){var t,a=Object(n.useState)(0),r=Object(s.a)(a,2),i=r[0],c=r[1],o=Object(n.useState)(null),j=Object(s.a)(o,2),m=j[0],b=j[1],p=parseInt(e.settings.nodesPerPage)||15,h=e.nodes;return Object(n.useEffect)((function(){var e=parseInt(i)*p,t=parseInt(e)+p;b(h.slice(e,t))}),[i,h]),e.loaded||(t=Object(d.jsx)("div",{class:"mri-directory-loading",children:Object(d.jsx)("img",{src:e.settings.clientPathToApp+"build/images/spinner.gif"})})),Object(d.jsxs)("div",{className:"mri-directory",children:[e.loaded?Object(d.jsxs)("div",{className:"node-list",children:[Object(d.jsxs)("div",{className:"node-count",children:[h.length," results found"]}),m.map((function(t){return Object(d.jsx)(u,{nodeData:t,settings:e.settings})}))]}):t,Object(d.jsx)("div",{className:"react-paginate",children:Object(d.jsx)(l.a,{previousLabel:"prev",nextLabel:"next",breakLabel:"...",breakClassName:"break-me",pageCount:h.length/p,marginPagesDisplayed:2,pageRangeDisplayed:p,onPageChange:function(e){c(e.selected)},containerClassName:"pagination",subContainerClassName:"pages pagination",pageClassName:"page-link-li",activeClassName:"active"})})]})},b=a(496),p=a(499),h=a(497),g=a(498),f=a(16),O=a.n(f),v=function(e){var t=e.node;return Object(d.jsxs)("div",{children:[t.image&&Object(d.jsx)("img",{src:t.image[0].url,alt:"Node logo",maxWidth:"50%",height:8}),Object(d.jsx)("div",{children:t.url||t.urls?Object(d.jsx)("a",{href:t.url||t.urls[0].url,target:"_blank",rel:"noopener noreferrer",children:Object(d.jsx)("span",{wordBreak:"break-all",children:t.name})}):Object(d.jsx)("span",{wordBreak:"break-all",children:t.name})}),t.description&&Object(d.jsx)("div",{children:t.description.length>250?"".concat(t.description.slice(0,250),"..."):t.description})]})};a(493);delete O.a.Icon.Default.prototype._getIconUrl;var x=function(e){var t,a=e.nodes,n=e.settings,r=e.loaded;return O.a.Icon.Default.mergeOptions({iconRetinaUrl:n.clientPathToApp+"build/images/marker-icon-2x.png",iconUrl:n.clientPathToApp+"build/images/marker-icon.png",shadowUrl:n.clientPathToApp+"build/images/marker-shadow.png"}),r||(t=Object(d.jsx)("div",{class:"mri-map-loading",children:Object(d.jsx)("img",{src:n.clientPathToApp+"build/images/spinner.gif"})})),Object(d.jsxs)("div",{class:"mri-map",children:[t,Object(d.jsxs)(b.a,{center:n.mapCenter,zoom:n.mapZoom,scrollWheelZoom:n.mapAllowScrollZoom,children:[Object(d.jsx)(p.a,{attribution:'\xa9 <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',url:"https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"}),a.map((function(e){if(e.data){var t=e.id;(e=e.data).id=t}return Object(d.jsxs)("div",{children:[e.geolocation?Object(d.jsx)(h.a,{position:[parseFloat(e.geolocation.lat),parseFloat(e.geolocation.lon)],children:Object(d.jsx)(g.a,{children:Object(d.jsx)(v,{node:e})})}):null,e.latitude&&e.longitude?Object(d.jsx)(h.a,{position:[parseFloat(e.latitude),parseFloat(e.longitude)],children:Object(d.jsx)(g.a,{children:Object(d.jsx)(v,{node:e})})}):null]},"".concat(e.id||e.objectID))}))]})]})};var y=function(e){var t=this,a=e.settings,r=e.interfaceComp,i=Object(n.useState)(!1),o=Object(s.a)(i,2),l=o[0],j=o[1],u=Object(n.useState)(!1),b=Object(s.a)(u,2),p=b[0],h=b[1],g=Object(n.useState)([]),f=Object(s.a)(g,2),O=f[0],v=f[1],y=Object(n.useState)(null),S=Object(s.a)(y,2),N=S[0],w=S[1],D=Object(n.useState)(a.formData),k=Object(s.a)(D,2),C=k[0],P=k[1];Object(n.useEffect)((function(){I()}),[]);var A,I=function(e){var t=a.apiUrl,n=a.apiNodeFormat;j(!1),v([]);var i=new URLSearchParams(e);"directory"==r&&i.set("format",n),N&&i.set("search",N),fetch(t+"?"+i.toString()).then((function(e){return e.json()})).then((function(e){j(!0),v(e)}),(function(e){j(!0),h(e)}))},E=a.filterSchema;return p?A=Object(d.jsxs)("div",{children:["Error: ",p.message]}):"directory"==r?A=Object(d.jsx)(m,{nodes:O,settings:a,loaded:l}):"map"==r&&(A=Object(d.jsx)(x,{nodes:O,settings:a,loaded:l})),Object(d.jsxs)("div",{className:"mri-interface",children:[a.showFilters?Object(d.jsx)("div",{className:"mri-filter-form",children:Object(d.jsx)(c.a,{schema:E,formData:C,onChange:function(e,t){var n=e.formData,r="";P(n),Object.keys(n).forEach((function(e,t){if(n[e]&&"any"!=n[e]&&""!=n[e]){if("operator"in a.filterSchema.properties[e])var i=a.filterSchema.properties[e].operator;else i="equals";r+="filters["+t+"][0]="+e+"&",r+="filters["+t+"][1]="+i+"&",r+="filters["+t+"][2]="+n[e]+"&"}})),I(r)},onError:function(){console.log("errors",t)}})}):null,Object(d.jsxs)("div",{className:"mri-content-container",children:[Object(d.jsx)("div",{className:"mri-search-form",children:Object(d.jsxs)("form",{action:"/",onSubmit:function(e){e.preventDefault(),I()},children:[Object(d.jsx)("input",{type:"text",name:"search",onChange:function(e){w(e.target.value)},value:N}),Object(d.jsx)("button",{type:"submit",children:"Search"})]})}),A]})]})},S=document.getElementById("murmurations-react-directory"),N=document.getElementById("murmurations-react-map");if(S){var w=window.wpReactSettings;i.a.render(Object(d.jsx)(y,{settings:w,interfaceComp:"directory"}),S)}if(N){var D=window.wpReactSettings;i.a.render(Object(d.jsx)(y,{settings:D,interfaceComp:"map"}),N)}}},[[494,1,2]]]);
//# sourceMappingURL=main.ae776051.chunk.js.map