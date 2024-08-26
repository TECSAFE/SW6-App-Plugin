"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["mad-tecsafe"],{548:(e,t,i)=>{var s=i(389),n=i.n(s),o=i(5117),r=i(3212),a=i(80);class c{constructor(e,t={},i=!1){if(!o.Z.isNode(e))throw new Error("There is no valid element given.");this.el=e,this.$emitter=new a.Z(this.el),this._pluginName=this._getPluginName(i),this.options=this._mergeOptions(t),this._initialized=!1,this._registerInstance(),this._init()}init(){throw new Error(`The "init" method for the plugin "${this._pluginName}" is not defined.`)}update(){}_init(){this._initialized||(this.init(),this._initialized=!0)}_update(){this._initialized&&this.update()}_mergeOptions(e){const t=r.Z.toDashCase(this._pluginName),i=o.Z.getDataAttribute(this.el,`data-${t}-config`,!1),s=o.Z.getAttribute(this.el,`data-${t}-options`,!1),a=[this.constructor.options,this.options,e];i&&a.push(window.PluginConfigManager.get(this._pluginName,i));try{s&&a.push(JSON.parse(s))}catch(e){throw console.error(this.el),new Error(`The data attribute "data-${t}-options" could not be parsed to json: ${e.message}`)}return n().all(a.filter((e=>e instanceof Object&&!(e instanceof Array))).map((e=>e||{})))}_registerInstance(){window.PluginManager.getPluginInstancesFromElement(this.el).set(this._pluginName,this);window.PluginManager.getPlugin(this._pluginName,!1).get("instances").push(this)}_getPluginName(e){return e||(e=this.constructor.name),e}}var l=i(6612),h=i(7127),u=i(2154),f=i(1372),d=i(6292),p=i(4295);const m="CookieConfiguration_Update";class g extends l.Z{init(){this.lastState={active:[],inactive:[]},this._httpClient=new d.Z,this._registerEvents()}_registerEvents(){const{submitEvent:e,buttonOpenSelector:t,customLinkSelector:i,globalButtonAcceptAllSelector:s}=this.options;Array.from(document.querySelectorAll(t)).forEach((t=>{t.addEventListener(e,this.openOffCanvas.bind(this))})),Array.from(document.querySelectorAll(i)).forEach((t=>{t.addEventListener(e,this._handleCustomLink.bind(this))})),Array.from(document.querySelectorAll(s)).forEach((t=>{t.addEventListener(e,this._acceptAllCookiesFromCookieBar.bind(this))}))}_registerOffCanvasEvents(){const{submitEvent:e,buttonSubmitSelector:t,buttonAcceptAllSelector:i,wrapperToggleSelector:s}=this.options,n=this._getOffCanvas();if(n){const o=n.querySelector(t),r=n.querySelector(i),a=Array.from(n.querySelectorAll('input[type="checkbox"]')),c=Array.from(n.querySelectorAll(s));o&&o.addEventListener(e,this._handleSubmit.bind(this,h.Z)),r&&r.addEventListener(e,this._acceptAllCookiesFromOffCanvas.bind(this,h.Z)),a.forEach((t=>{t.addEventListener(e,this._handleCheckbox.bind(this))})),c.forEach((t=>{t.addEventListener(e,this._handleWrapperTrigger.bind(this))}))}}_handleCustomLink(e){e.preventDefault(),this.openOffCanvas()}_handleUpdateListener(e,t){const i=this._getUpdatedCookies(e,t);document.$emitter.publish(m,i)}_getUpdatedCookies(e,t){const{lastState:i}=this,s={};return e.forEach((e=>{i.inactive.includes(e)&&(s[e]=!0)})),t.forEach((e=>{i.active.includes(e)&&(s[e]=!1)})),s}openOffCanvas(e){const{offCanvasPosition:t}=this.options,i=window.router["frontend.cookie.offcanvas"];this._hideCookieBar(),u.Z.open(i,!1,this._onOffCanvasOpened.bind(this,e),t)}closeOffCanvas(e){u.Z.close(),"function"==typeof e&&e()}_onOffCanvasOpened(e){this._registerOffCanvasEvents(),this._setInitialState(),this._setInitialOffcanvasState(),PluginManager.initializePlugins(),"function"==typeof e&&e()}_hideCookieBar(){const e=PluginManager.getPluginInstances("CookiePermission");e&&e[0]&&(e[0]._hideCookieBar(),e[0]._removeBodyPadding())}_setInitialState(e=null){const t=e||this._getCookies("all"),i=[],s=[];t.forEach((({cookie:e,required:t})=>{h.Z.getItem(e)||t?i.push(e):s.push(e)})),this.lastState={active:i,inactive:s}}_setInitialOffcanvasState(){const e=this.lastState.active,t=this._getOffCanvas();e.forEach((e=>{const i=t.querySelector(`[data-cookie="${e}"]`);i.checked=!0,this._childCheckboxEvent(i)}))}_handleWrapperTrigger(e){e.preventDefault();const{entriesActiveClass:t,entriesClass:i,groupClass:s}=this.options,{target:n}=e,o=this._findParentEl(n,i,s);if(o){o.classList.contains(t)?o.classList.remove(t):o.classList.add(t)}}_handleCheckbox(e){const{parentInputClass:t}=this.options,{target:i}=e;(i.classList.contains(t)?this._parentCheckboxEvent:this._childCheckboxEvent).call(this,i)}_findParentEl(e,t,i=null){for(;e&&!e.classList.contains(i);){if(e.classList.contains(t))return e;e=e.parentElement}return null}_isChecked(e){return!!e.checked}_parentCheckboxEvent(e){const{groupClass:t}=this.options,i=this._isChecked(e),s=this._findParentEl(e,t);this._toggleWholeGroup(i,s)}_childCheckboxEvent(e){const{groupClass:t}=this.options,i=this._isChecked(e),s=this._findParentEl(e,t);this._toggleParentCheckbox(i,s)}_toggleWholeGroup(e,t){Array.from(t.querySelectorAll("input")).forEach((t=>{t.checked=e}))}_toggleParentCheckbox(e,t){const{parentInputSelector:i}=this.options,s=Array.from(t.querySelectorAll(`input:not(${i})`)),n=Array.from(t.querySelectorAll(`input:not(${i}):checked`));if(s.length>0){const e=t.querySelector(i);if(e){const t=n.length>0,i=t&&n.length!==s.length;e.checked=t,e.indeterminate=i}}}_handleSubmit(){const e=this._getCookies("active"),t=this._getCookies("inactive"),{cookiePreference:i}=this.options,s=[],n=[];t.forEach((({cookie:e})=>{n.push(e),h.Z.getItem(e)&&h.Z.removeItem(e)})),e.forEach((({cookie:e,value:t,expiration:i})=>{s.push(e),e&&t&&h.Z.setItem(e,t,i)})),h.Z.setItem(i,"1","30"),this._handleUpdateListener(s,n),this.closeOffCanvas(document.$emitter.publish("CookieConfiguration_CloseOffCanvas"))}acceptAllCookies(e=!1){if(!e)return this._handleAcceptAll(),void this.closeOffCanvas();p.Z.create(this.el);const t=window.router["frontend.cookie.offcanvas"];this._httpClient.get(t,(e=>{const t=(new DOMParser).parseFromString(e,"text/html");this._handleAcceptAll(t),p.Z.remove(this.el),this._hideCookieBar()}))}_acceptAllCookiesFromCookieBar(){return this.acceptAllCookies(!0)}_acceptAllCookiesFromOffCanvas(){return this.acceptAllCookies()}_handleAcceptAll(e=null){const t=this._getCookies("all",e);this._setInitialState(t);const{cookiePreference:i}=this.options;t.forEach((({cookie:e,value:t,expiration:i})=>{e&&t&&h.Z.setItem(e,t,i)})),h.Z.setItem(i,"1","30"),this._handleUpdateListener(t.map((({cookie:e})=>e)),[])}_getCookies(e="all",t=null){const{cookieSelector:i}=this.options;return t||(t=this._getOffCanvas()),Array.from(t.querySelectorAll(i)).filter((t=>{switch(e){case"all":return!0;case"active":return this._isChecked(t);case"inactive":return!this._isChecked(t);default:return!1}})).map((e=>{const{cookie:t,cookieValue:i,cookieExpiration:s,cookieRequired:n}=e.dataset;return{cookie:t,value:i,expiration:s,required:n}}))}_getOffCanvas(){const e=f.Z?f.Z.getOffCanvas():[];return!!(e&&e.length>0)&&e[0]}}var v,C,k;v=g,C="options",k={offCanvasPosition:"left",submitEvent:"click",cookiePreference:"cookie-preference",cookieSelector:"[data-cookie]",buttonOpenSelector:".js-cookie-configuration-button button",buttonSubmitSelector:".js-offcanvas-cookie-submit",buttonAcceptAllSelector:".js-offcanvas-cookie-accept-all",globalButtonAcceptAllSelector:".js-cookie-accept-all-button",wrapperToggleSelector:".offcanvas-cookie-entries span",parentInputSelector:".offcanvas-cookie-parent-input",customLinkSelector:`[href="${window.router["frontend.cookie.offcanvas"]}"]`,entriesActiveClass:"offcanvas-cookie-entries--active",entriesClass:"offcanvas-cookie-entries",groupClass:"offcanvas-cookie-group",parentInputClass:"offcanvas-cookie-parent-input"},(C=function(e){var t=function(e,t){if("object"!=typeof e||null===e)return e;var i=e[Symbol.toPrimitive];if(void 0!==i){var s=i.call(e,t||"default");if("object"!=typeof s)return s;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"==typeof t?t:String(t)}(C))in v?Object.defineProperty(v,C,{value:k,enumerable:!0,configurable:!0,writable:!0}):v[C]=k;class b{static isSupported(){return"undefined"!==document.cookie}static setItem(e,t,i){if(null==e)throw new Error("You must specify a key to set a cookie");const s=new Date;s.setTime(s.getTime()+24*i*60*60*1e3);let n="";"https:"===location.protocol&&(n="secure"),document.cookie=`${e}=${t};expires=${s.toUTCString()};path=/;sameSite=lax;${n}`}static getItem(e){if(!e)return!1;const t=e+"=",i=document.cookie.split(";");for(let e=0;e<i.length;e++){let s=i[e];for(;" "===s.charAt(0);)s=s.substring(1);if(0===s.indexOf(t))return s.substring(t.length,s.length)}return!1}static removeItem(e){document.cookie=`${e}= ; expires = Thu, 01 Jan 1970 00:00:00 GMT;path=/`}static key(){return""}static clear(){}}class y{constructor(e){this.getAccessToken=e}async get(e){let t={"Content-Type":"application/json"};const i=this.getAccessToken();i&&(t.Authorization=`Bearer ${i}`);const s=await fetch(process.env.API_SERVER+"/api"+e,{method:"GET",headers:t});if(404===s.status)throw new w("Not found",s.status);if(!s.ok)throw new E("Internal server error",s.status);return s.json()}async post(e,t){let i={"Content-Type":"application/json"};const s=this.getAccessToken();s&&(i.Authorization=`Bearer ${s}`);const n=await fetch(process.env.API_SERVER+"/api"+e,{method:"POST",headers:i,body:JSON.stringify(t)});if(404===n.status)throw new w("Not found",n.status);if(!n.ok)throw new E("Internal server error",n.status);return n.json()}}class _{constructor(e,t){this.message=e,this.status=t}}class w extends _{}class E extends _{}var T=i(133);class A{iframe=null;unregister=[];constructor(e,t){this.api=e,this.element=t,this.unregister.push(this.api.on("customerChanged",(e=>{this.build(e)}))),this.unregister.push(this.api.on("refreshToken",(e=>{this.message({type:"refreshCustomerToken",customerToken:e})}))),this.unregister.push(this.api.on("customerLogout",(()=>{this.handleLogout()})));const i=this.api.getCustomerToken();i?this.build(i):this.handleLogout()}handleLogout(){this.iframe=null,this.element.innerHTML="No Customer Token"}destroy(){for(const e of this.unregister)e();this.iframe=null,this.element.innerHTML=""}build(e){}message(e){this.iframe?.contentWindow?.postMessage(e)}}class O extends A{constructor(e,t,i,s){super(e,t),this.insertArticles=i,this.containerId=s}build(e){this.element.innerHTML="",this.iframe=document.createElement("iframe"),this.iframe.src=`${this.api.config.appUrl}/iframe/widget?customerToken=${e}`,this.iframe.style.width="100%",this.iframe.style.height="100%",this.iframe.style.backgroundColor="transparent",this.iframe.style.border="none",this.element.appendChild(this.iframe)}}class S extends A{build(e){this.element.innerHTML="",this.iframe=document.createElement("iframe"),this.iframe.src=`${this.api.config.appUrl}/iframe/cart?customerToken=${e}`,this.iframe.style.width="100%",this.iframe.style.height="100%",this.iframe.style.backgroundColor="transparent",this.iframe.style.border="none",this.element.appendChild(this.iframe)}}class L{element=null;iframe=null;unregister=[];constructor(e){this.api=e,this.unregister.push(this.api.on("customerChanged",(e=>{this.build(e)}))),this.unregister.push(this.api.on("refreshToken",(e=>{this.message({type:"refreshCustomerToken",customerToken:e})}))),this.unregister.push(this.api.on("customerLogout",(()=>{this.destroy()})));const t=this.api.getCustomerToken();t?this.build(t):this.destroy()}destroy(){for(const e of this.unregister)e();this.iframe=null,this.element&&(this.element.remove(),this.element=null)}build(e){}message(e){this.iframe?.contentWindow?.postMessage(e)}}class x extends L{build(e){this.element=document.createElement("div"),this.element.style.position="fixed",this.element.style.backdropFilter="blur(10px)",this.element.style.top="0",this.element.style.left="0",this.element.style.height="100%",this.element.style.width="100%",this.element.style.padding="2rem",this.element.style.boxSizing="border-box",this.iframe=document.createElement("iframe"),this.iframe.src=`${this.api.config.appUrl}/iframe/app?customerToken=${e}`,this.iframe.style.height="100%",this.iframe.style.width="100%",this.iframe.style.backgroundColor="transparent",this.iframe.style.border="none",this.element.appendChild(this.iframe),document.body.append(this.element)}}function I(e){this.message=e}I.prototype=new Error,I.prototype.name="InvalidCharacterError";var P="undefined"!=typeof window&&window.atob&&window.atob.bind(window)||function(e){var t=String(e).replace(/=+$/,"");if(t.length%4==1)throw new I("'atob' failed: The string to be decoded is not correctly encoded.");for(var i,s,n=0,o=0,r="";s=t.charAt(o++);~s&&(i=n%4?64*i+s:s,n++%4)?r+=String.fromCharCode(255&i>>(-2*n&6)):0)s="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(s);return r};function Z(e){var t=e.replace(/-/g,"+").replace(/_/g,"/");switch(t.length%4){case 0:break;case 2:t+="==";break;case 3:t+="=";break;default:throw"Illegal base64url string!"}try{return function(e){return decodeURIComponent(P(e).replace(/(.)/g,(function(e,t){var i=t.charCodeAt(0).toString(16).toUpperCase();return i.length<2&&(i="0"+i),"%"+i})))}(t)}catch(e){return P(t)}}function $(e){this.message=e}$.prototype=new Error,$.prototype.name="InvalidTokenError";const N=function(e,t){if("string"!=typeof e)throw new $("Invalid token specified");var i=!0===(t=t||{}).header?0:1;try{return JSON.parse(Z(e.split(".")[i]))}catch(e){throw new $("Invalid token specified: "+e.message)}};class q{customerToken=null;eventEmitter=new T.TypedEmitter;appWidget=null;refreshTimeout=null;retryCounter=0;constructor(e,t){this.config={appUrl:"https://tecsafe.github.io/app-ui/",...t},this.getCustomerTokenCallback=e,this.httpClient=new y((()=>{if(null===this.customerToken)throw new Error("missing customer token");return this.customerToken})),window.addEventListener("message",(e=>{this.listenMessage(e.data)}))}async initialize(){await this.reloadToken()}productDetailWidget(e,t,i){return new O(this,e,t,i)}cartWidget(e){return new S(this,e)}openApp(){return this.appWidget||(this.appWidget=new x(this)),this.appWidget}closeApp(){this.appWidget&&(this.appWidget.destroy(),this.appWidget=null)}async reloadToken(){try{const e=await this.getCustomerTokenCallback();if(e===this.customerToken)return;if(null===e)return void this.logout();const t=N(e);if(this.refreshTimeout&&(clearTimeout(this.refreshTimeout),this.refreshTimeout=null),this.refreshTimeout=setTimeout((()=>{this.reloadToken()}),1e3*(t.exp-30)-Date.now()),this.customerToken){if(N(this.customerToken).sub===t.sub)return this.customerToken=e,this.retryCounter=0,void this.eventEmitter.emit("refreshToken",e)}this.customerToken=e,this.retryCounter=0,this.eventEmitter.emit("customerChanged",e)}catch(e){if(console.error(e),this.refreshTimeout&&(clearTimeout(this.refreshTimeout),this.refreshTimeout=null),this.retryCounter<3)return console.warn(`retry in 5 seconds (${this.retryCounter+1}/3)`),this.retryCounter++,void(this.refreshTimeout=setTimeout((()=>{this.reloadToken()}),5e3));this.logout()}}logout(){this.refreshTimeout&&(clearTimeout(this.refreshTimeout),this.refreshTimeout=null),this.customerToken=null,this.eventEmitter.emit("customerLogout")}getCustomerToken(){return this.customerToken}async getCart(){return this.httpClient.get("/cart")}on(e,t){return this.eventEmitter.on(e,t),()=>{this.eventEmitter.off(e,t)}}off(e,t){this.eventEmitter.off(e,t)}emit(e,...t){this.eventEmitter.emit(e,...t)}listenMessage(e){switch(e.type){case"addToCart":this.eventEmitter.emit("addToCart",e.itemId,e.quantity,e.price);break;case"removeFromCart":this.eventEmitter.emit("removeFromCart",e.itemId);break;case"changeCartQuantity":this.eventEmitter.emit("changeCartQuantity",e.itemId,e.quantity,e.price);break;case"openApp":this.openApp();break;case"closeApp":this.closeApp()}}}const M={initializeTecsafeApi:async function(e,t){const i=new q(e,t);return await i.initialize(),i}};class j extends c{init(){console.log("foobaz"),document.$emitter.subscribe(m,this._handleInit.bind(this)),this._handleInit()}reloadToken(){this.api.reloadToken()}logout(){}async initApi(){this.api=await M.initializeTecsafeApi((async()=>{const e=await fetch("/tecsafe/ofcp/token");return(await e.json()).token}))}_handleInit(){if(b.getItem(this.options.cookieName))return this.initApi()}createProductDetailWidget(e){return this.api.productDetailWidget(e)}createElementBackdrop(){const e=document.createElement("div");e.classList.add("foobar");const t=document.createElement("div");return e.appendChild(t),e}_replaceElementWithVideo(){console.log("heyho");const e=document.createElement("iframe");e.setAttribute("src",this.options.videoUrl),this.options.iframeClasses.forEach((t=>{e.classList.add(t)}));const t=this.el.parentNode;return t.appendChild(e),t.removeChild(this.el),!0}}!function(e,t,i){(t=function(e){var t=function(e,t){if("object"!=typeof e||null===e)return e;var i=e[Symbol.toPrimitive];if(void 0!==i){var s=i.call(e,t||"default");if("object"!=typeof s)return s;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"==typeof t?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i}(j,"options",{cookieName:"tecsafe-foam-configurator-enabled",btnClasses:[],videoUrl:null,iframeClasses:[],overlayText:null,backdropClasses:["element-loader-backdrop","element-loader-backdrop-open"],confirmButtonText:null,modalTriggerSelector:'[data-bs-toggle="modal"][data-url]',urlAttribute:"data-url"});window.PluginManager.register("Tecsafe",j,"[data-tecsafe-plugin]")},2154:(e,t,i)=>{i.d(t,{Z:()=>a});var s=i(1372),n=i(6292),o=i(2189);let r=null;class a extends s.Z{static open(e=!1,t=!1,i=null,n="left",o=!0,r=s.Z.REMOVE_OFF_CANVAS_DELAY(),a=!1,c=""){if(!e)throw new Error("A url must be given!");s.r._removeExistingOffCanvas();const l=s.r._createOffCanvas(n,a,c,o);this.setContent(e,t,i,o,r),s.r._openOffcanvas(l)}static setContent(e,t,i,s,c){const l=new n.Z;super.setContent(`<div class="offcanvas-content-container">${o.Z.getTemplate()}</div>`,s,c),r&&r.abort();const h=e=>{super.setContent(e,s,c),"function"==typeof i&&i(e)};r=t?l.post(e,t,a.executeCallback.bind(this,h)):l.get(e,a.executeCallback.bind(this,h))}static executeCallback(e,t){"function"==typeof e&&e(t),window.PluginManager.initializePlugins()}}},1372:(e,t,i)=>{i.d(t,{Z:()=>h,r:()=>l});var s=i(8870),n=i(80),o=i(1518);const r="offcanvas",a=350;class c{constructor(){this.$emitter=new n.Z}open(e,t,i,s,n,o,r){this._removeExistingOffCanvas();const a=this._createOffCanvas(i,o,r,s);this.setContent(e,s,n),this._openOffcanvas(a,t)}setContent(e,t,i){const s=this.getOffCanvas();s[0]&&(s[0].innerHTML=e,this._registerEvents(i))}setAdditionalClassName(e){this.getOffCanvas()[0].classList.add(e)}getOffCanvas(){return document.querySelectorAll(`.${r}`)}close(e){const t=this.getOffCanvas();o.Z.iterate(t,(e=>{bootstrap.Offcanvas.getInstance(e).hide()})),setTimeout((()=>{this.$emitter.publish("onCloseOffcanvas",{offCanvasContent:t})}),e)}goBackInHistory(){window.history.back()}exists(){return this.getOffCanvas().length>0}_openOffcanvas(e,t){c.bsOffcanvas.show(),window.history.pushState("offcanvas-open",""),"function"==typeof t&&t()}_registerEvents(e){const t=s.Z.isTouchDevice()?"touchend":"click",i=this.getOffCanvas();o.Z.iterate(i,(t=>{const s=()=>{setTimeout((()=>{t.remove(),this.$emitter.publish("onCloseOffcanvas",{offCanvasContent:i})}),e),t.removeEventListener("hide.bs.offcanvas",s)};t.addEventListener("hide.bs.offcanvas",s)})),window.addEventListener("popstate",this.close.bind(this,e),{once:!0});const n=document.querySelectorAll(".js-offcanvas-close");o.Z.iterate(n,(i=>i.addEventListener(t,this.close.bind(this,e))))}_removeExistingOffCanvas(){c.bsOffcanvas=null;const e=this.getOffCanvas();return o.Z.iterate(e,(e=>e.remove()))}_getPositionClass(e){return"left"===e?"offcanvas-start":"right"===e?"offcanvas-end":`offcanvas-${e}`}_createOffCanvas(e,t,i,s){const n=document.createElement("div");if(n.classList.add(r),n.classList.add(this._getPositionClass(e)),!0===t&&n.classList.add("is-fullwidth"),i){const e=typeof i;if("string"===e)n.classList.add(i);else{if(!Array.isArray(i))throw new Error(`The type "${e}" is not supported. Please pass an array or a string.`);i.forEach((e=>{n.classList.add(e)}))}}return document.body.appendChild(n),c.bsOffcanvas=new bootstrap.Offcanvas(n,{backdrop:!1!==s||"static"}),n}}const l=Object.freeze(new c);class h{static open(e,t=null,i="left",s=!0,n=350,o=!1,r=""){l.open(e,t,i,s,n,o,r)}static setContent(e,t=!0,i=350){l.setContent(e,t,i)}static setAdditionalClassName(e){l.setAdditionalClassName(e)}static close(e=350){l.close(e)}static exists(){return l.exists()}static getOffCanvas(){return l.getOffCanvas()}static REMOVE_OFF_CANVAS_DELAY(){return a}}},133:(e,t,i)=>{t.TypedEmitter=i(8728).EventEmitter}},e=>{e.O(0,["vendor-node","vendor-shared"],(()=>{return t=548,e(e.s=t);var t}));e.O()}]);