(function(c){var l="0.9.3";var j={isMsie:function(){var m=/(msie) ([\w.]+)/i.exec(navigator.userAgent);return m?parseInt(m[2],10):false},isBlankString:function(m){return !m||/^\s*$/.test(m)},escapeRegExChars:function(m){return m.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")},isString:function(m){return typeof m==="string"},isNumber:function(m){return typeof m==="number"},isArray:c.isArray,isFunction:c.isFunction,isObject:c.isPlainObject,isUndefined:function(m){return typeof m==="undefined"},bind:c.proxy,bindAll:function(n){var o;for(var m in n){c.isFunction(o=n[m])&&(n[m]=c.proxy(o,n))}},indexOf:function(n,o){for(var m=0;m<n.length;m++){if(n[m]===o){return m}}return -1},each:c.each,map:c.map,filter:c.grep,every:function(n,o){var m=true;if(!n){return m}c.each(n,function(p,q){if(!(m=o.call(null,q,p,n))){return false}});return !!m},some:function(n,o){var m=false;if(!n){return m}c.each(n,function(p,q){if(m=o.call(null,q,p,n)){return false}});return !!m},mixin:c.extend,getUniqueId:function(){var m=0;return function(){return m++}}(),defer:function(m){setTimeout(m,0)},debounce:function(o,q,n){var p,m;return function(){var u=this,t=arguments,s,r;s=function(){p=null;if(!n){m=o.apply(u,t)}};r=n&&!p;clearTimeout(p);p=setTimeout(s,q);if(r){m=o.apply(u,t)}return m}},throttle:function(r,t){var p,o,s,m,q,n;q=0;n=function(){q=new Date();s=null;m=r.apply(p,o)};return function(){var u=new Date(),v=t-(u-q);p=this;o=arguments;if(v<=0){clearTimeout(s);s=null;q=u;m=r.apply(p,o)}else{if(!s){s=setTimeout(n,v)}}return m}},tokenizeQuery:function(m){return c.trim(m).toLowerCase().split(/[\s]+/)},tokenizeText:function(m){return c.trim(m).toLowerCase().split(/[\s\-_]+/)},getProtocol:function(){return location.protocol},noop:function(){}};var k=function(){var m=/\s+/;return{on:function(n,p){var o;if(!p){return this}this._callbacks=this._callbacks||{};n=n.split(m);while(o=n.shift()){this._callbacks[o]=this._callbacks[o]||[];this._callbacks[o].push(p)}return this},trigger:function(o,r){var q,p;if(!this._callbacks){return this}o=o.split(m);while(q=o.shift()){if(p=this._callbacks[q]){for(var n=0;n<p.length;n+=1){p[n].call(this,{type:q,data:r})}}}return this}}}();var e=function(){var n="typeahead:";function m(p){if(!p||!p.el){c.error("EventBus initialized without el")}this.$el=c(p.el)}j.mixin(m.prototype,{trigger:function(p){var o=[].slice.call(arguments,1);this.$el.trigger(n+p,o)}});return m}();var g=function(){var m,n;try{m=window.localStorage;m.setItem("~~~","!");m.removeItem("~~~")}catch(r){m=null}function p(t){this.prefix=["__",t,"__"].join("");this.ttlKey="__ttl__";this.keyMatcher=new RegExp("^"+this.prefix)}if(m&&window.JSON){n={_prefix:function(t){return this.prefix+t},_ttlKey:function(t){return this._prefix(t)+this.ttlKey},get:function(t){if(this.isExpired(t)){this.remove(t)}return s(m.getItem(this._prefix(t)))},set:function(u,v,t){if(j.isNumber(t)){m.setItem(this._ttlKey(u),q(o()+t))}else{m.removeItem(this._ttlKey(u))}return m.setItem(this._prefix(u),q(v))},remove:function(t){m.removeItem(this._ttlKey(t));m.removeItem(this._prefix(t));return this},clear:function(){var v,u,w=[],t=m.length;for(v=0;v<t;v++){if((u=m.key(v)).match(this.keyMatcher)){w.push(u.replace(this.keyMatcher,""))}}for(v=w.length;v--;){this.remove(w[v])}return this},isExpired:function(u){var t=s(m.getItem(this._ttlKey(u)));return j.isNumber(t)&&o()>t?true:false}}}else{n={get:j.noop,set:j.noop,remove:j.noop,clear:j.noop,isExpired:j.noop}}j.mixin(p.prototype,n);return p;function o(){return new Date().getTime()}function q(t){return JSON.stringify(j.isUndefined(t)?null:t)}function s(t){return JSON.parse(t)}}();var i=function(){function m(n){j.bindAll(this);n=n||{};this.sizeLimit=n.sizeLimit||10;this.cache={};this.cachedKeysByAge=[]}j.mixin(m.prototype,{get:function(n){return this.cache[n]},set:function(o,p){var n;if(this.cachedKeysByAge.length===this.sizeLimit){n=this.cachedKeysByAge.shift();delete this.cache[n]}this.cache[o]=p;this.cachedKeysByAge.push(o)}});return m}();var d=function(){var n=0,q={},m,s;function t(u){j.bindAll(this);u=j.isString(u)?{url:u}:u;s=s||new i();m=j.isNumber(u.maxParallelRequests)?u.maxParallelRequests:m||6;this.url=u.url;this.wildcard=u.wildcard||"%QUERY";this.filter=u.filter;this.replace=u.replace;this.ajaxSettings={type:"get",cache:u.cache,timeout:u.timeout,dataType:u.dataType||"json",beforeSend:u.beforeSend};this._get=(/^throttle$/i.test(u.rateLimitFn)?j.throttle:j.debounce)(this._get,u.rateLimitWait||300)}j.mixin(t.prototype,{_get:function(w,u){var x=this;if(p()){this._sendRequest(w).done(v)}else{this.onDeckRequestArgs=[].slice.call(arguments,0)}function v(z){var y=x.filter?x.filter(z):z;u&&u(y);s.set(w,z)}},_sendRequest:function(v){var x=this,w=q[v];if(!w){o();w=q[v]=c.ajax(v,this.ajaxSettings).always(u)}return w;function u(){r();q[v]=null;if(x.onDeckRequestArgs){x._get.apply(x,x.onDeckRequestArgs);x.onDeckRequestArgs=null}}},get:function(y,u){var x=this,w=encodeURIComponent(y||""),v,z;u=u||j.noop;v=this.replace?this.replace(this.url,w):this.url.replace(this.wildcard,w);if(z=s.get(v)){j.defer(function(){u(x.filter?x.filter(z):z)})}else{this._get(v,u)}return !!z}});return t;function o(){n++}function r(){n--}function p(){return n<m}}();var a=function(){var o={thumbprint:"thumbprint",protocol:"protocol",itemHash:"itemHash",adjacencyList:"adjacencyList"};function n(p){j.bindAll(this);if(j.isString(p.template)&&!p.engine){c.error("no template engine specified")}if(!p.local&&!p.prefetch&&!p.remote){c.error("one of local, prefetch, or remote is required")}this.name=p.name||j.getUniqueId();this.limit=p.limit||5;this.minLength=p.minLength||1;this.header=p.header;this.footer=p.footer;this.valueKey=p.valueKey||"value";this.template=m(p.template,p.engine,this.valueKey);this.local=p.local;this.prefetch=p.prefetch;this.remote=p.remote;this.itemHash={};this.adjacencyList={};this.storage=p.name?new g(p.name):null}j.mixin(n.prototype,{_processLocalData:function(p){this._mergeProcessedData(this._processData(p))},_loadPrefetchData:function(q){var t=this,y=l+(q.thumbprint||""),w,r,u,p,s,x;if(this.storage){w=this.storage.get(o.thumbprint);r=this.storage.get(o.protocol);u=this.storage.get(o.itemHash);p=this.storage.get(o.adjacencyList)}s=w!==y||r!==j.getProtocol();q=j.isString(q)?{url:q}:q;q.ttl=j.isNumber(q.ttl)?q.ttl:24*60*60*1000;if(u&&p&&!s){this._mergeProcessedData({itemHash:u,adjacencyList:p});x=c.Deferred().resolve()}else{x=c.getJSON(q.url).done(v)}return x;function v(D){var C=q.filter?q.filter(D):D,B=t._processData(C),z=B.itemHash,A=B.adjacencyList;if(t.storage){t.storage.set(o.itemHash,z,q.ttl);t.storage.set(o.adjacencyList,A,q.ttl);t.storage.set(o.thumbprint,y,q.ttl);t.storage.set(o.protocol,j.getProtocol(),q.ttl)}t._mergeProcessedData(B)}},_transformDatum:function(p){var r=j.isString(p)?p:p[this.valueKey],s=p.tokens||j.tokenizeText(r),q={value:r,tokens:s};if(j.isString(p)){q.datum={};q.datum[this.valueKey]=p}else{q.datum=p}q.tokens=j.filter(q.tokens,function(t){return !j.isBlankString(t)});q.tokens=j.map(q.tokens,function(t){return t.toLowerCase()});return q},_processData:function(s){var r=this,p={},q={};j.each(s,function(u,t){var v=r._transformDatum(t),w=j.getUniqueId(v.value);p[w]=v;j.each(v.tokens,function(y,x){var A=x.charAt(0),z=q[A]||(q[A]=[w]);!~j.indexOf(z,w)&&z.push(w)})});return{itemHash:p,adjacencyList:q}},_mergeProcessedData:function(p){var q=this;j.mixin(this.itemHash,p.itemHash);j.each(p.adjacencyList,function(t,s){var r=q.adjacencyList[t];q.adjacencyList[t]=r?r.concat(s):s})},_getLocalSuggestions:function(u){var t=this,s=[],q=[],r,p=[];j.each(u,function(w,v){var x=v.charAt(0);!~j.indexOf(s,x)&&s.push(x)});j.each(s,function(v,w){var x=t.adjacencyList[w];if(!x){return false}q.push(x);if(!r||x.length<r.length){r=x}});if(q.length<s.length){return[]}j.each(r,function(v,z){var x=t.itemHash[z],y,w;y=j.every(q,function(A){return ~j.indexOf(A,z)});w=y&&j.every(u,function(A){return j.some(x.tokens,function(B){return B.indexOf(A)===0})});w&&p.push(x)});return p},initialize:function(){var p;this.local&&this._processLocalData(this.local);this.transport=this.remote?new d(this.remote):null;p=this.prefetch?this._loadPrefetchData(this.prefetch):c.Deferred().resolve();this.local=this.prefetch=this.remote=null;this.initialize=function(){return p};return p},getSuggestions:function(u,q){var t=this,s,p,r=false;if(u.length<this.minLength){return}s=j.tokenizeQuery(u);p=this._getLocalSuggestions(s).slice(0,this.limit);if(p.length<this.limit&&this.transport){r=this.transport.get(u,v)}!r&&q&&q(p);function v(w){p=p.slice(0);j.each(w,function(z,y){var A=t._transformDatum(y),x;x=j.some(p,function(B){return A.value===B.value});!x&&p.push(A);return p.length<t.limit});q&&q(p)}}});return n;function m(s,r,t){var q,p;if(j.isFunction(s)){q=s}else{if(j.isString(s)){p=r.compile(s);q=j.bind(p.render,p)}else{q=function(u){return"<p>"+u[t]+"</p>"}}}return q}}();var b=function(){function n(q){var p=this;j.bindAll(this);this.specialKeyCodeMap={9:"tab",27:"esc",37:"left",39:"right",13:"enter",38:"up",40:"down"};this.$hint=c(q.hint);this.$input=c(q.input).on("blur.tt",this._handleBlur).on("focus.tt",this._handleFocus).on("keydown.tt",this._handleSpecialKeyEvent);if(!j.isMsie()){this.$input.on("input.tt",this._compareQueryToInputValue)}else{this.$input.on("keydown.tt keypress.tt cut.tt paste.tt",function(r){if(p.specialKeyCodeMap[r.which||r.keyCode]){return}j.defer(p._compareQueryToInputValue)})}this.query=this.$input.val();this.$overflowHelper=o(this.$input)}j.mixin(n.prototype,k,{_handleFocus:function(){this.trigger("focused")},_handleBlur:function(){this.trigger("blured")},_handleSpecialKeyEvent:function(p){var q=this.specialKeyCodeMap[p.which||p.keyCode];q&&this.trigger(q+"Keyed",p)},_compareQueryToInputValue:function(){var p=this.getInputValue(),r=m(this.query,p),q=r?this.query.length!==p.length:false;if(q){this.trigger("whitespaceChanged",{value:this.query})}else{if(!r){this.trigger("queryChanged",{value:this.query=p})}}},destroy:function(){this.$hint.off(".tt");this.$input.off(".tt");this.$hint=this.$input=this.$overflowHelper=null},focus:function(){this.$input.focus()},blur:function(){this.$input.blur()},getQuery:function(){return this.query},setQuery:function(p){this.query=p},getInputValue:function(){return this.$input.val()},setInputValue:function(q,p){this.$input.val(q);!p&&this._compareQueryToInputValue()},getHintValue:function(){return this.$hint.val()},setHintValue:function(p){this.$hint.val(p)},getLanguageDirection:function(){return(this.$input.css("direction")||"ltr").toLowerCase()},isOverflow:function(){this.$overflowHelper.text(this.getInputValue());return this.$overflowHelper.width()>this.$input.width()},isCursorAtEnd:function(){var q=this.$input.val().length,r=this.$input[0].selectionStart,p;if(j.isNumber(r)){return r===q}else{if(document.selection){p=document.selection.createRange();p.moveStart("character",-q);return q===p.text.length}}return true}});return n;function o(p){return c("<span></span>").css({position:"absolute",left:"-9999px",visibility:"hidden",whiteSpace:"nowrap",fontFamily:p.css("font-family"),fontSize:p.css("font-size"),fontStyle:p.css("font-style"),fontVariant:p.css("font-variant"),fontWeight:p.css("font-weight"),wordSpacing:p.css("word-spacing"),letterSpacing:p.css("letter-spacing"),textIndent:p.css("text-indent"),textRendering:p.css("text-rendering"),textTransform:p.css("text-transform")}).insertAfter(p)}function m(q,p){q=(q||"").replace(/^\s*/g,"").replace(/\s{2,}/g," ");p=(p||"").replace(/^\s*/g,"").replace(/\s{2,}/g," ");return q===p}}();var f=function(){var o={suggestionsList:'<span class="tt-suggestions"></span>'},n={suggestionsList:{display:"block"},suggestion:{whiteSpace:"nowrap",cursor:"pointer"},suggestionChild:{whiteSpace:"normal"}};function p(q){j.bindAll(this);this.isOpen=false;this.isEmpty=true;this.isMouseOverDropdown=false;this.$menu=c(q.menu).on("mouseenter.tt",this._handleMouseenter).on("mouseleave.tt",this._handleMouseleave).on("click.tt",".tt-suggestion",this._handleSelection).on("mouseover.tt",".tt-suggestion",this._handleMouseover)}j.mixin(p.prototype,k,{_handleMouseenter:function(){this.isMouseOverDropdown=true},_handleMouseleave:function(){this.isMouseOverDropdown=false},_handleMouseover:function(r){var q=c(r.currentTarget);this._getSuggestions().removeClass("tt-is-under-cursor");q.addClass("tt-is-under-cursor")},_handleSelection:function(r){var q=c(r.currentTarget);this.trigger("suggestionSelected",m(q))},_show:function(){this.$menu.css("display","block")},_hide:function(){this.$menu.hide()},_moveCursor:function(s){var u,r,q,t;if(!this.isVisible()){return}u=this._getSuggestions();r=u.filter(".tt-is-under-cursor");r.removeClass("tt-is-under-cursor");q=u.index(r)+s;q=(q+1)%(u.length+1)-1;if(q===-1){this.trigger("cursorRemoved");return}else{if(q<-1){q=u.length-1}}t=u.eq(q).addClass("tt-is-under-cursor");this._ensureVisibility(t);this.trigger("cursorMoved",m(t))},_getSuggestions:function(){return this.$menu.find(".tt-suggestions > .tt-suggestion")},_ensureVisibility:function(t){var u=this.$menu.height()+parseInt(this.$menu.css("paddingTop"),10)+parseInt(this.$menu.css("paddingBottom"),10),r=this.$menu.scrollTop(),q=t.position().top,s=q+t.outerHeight(true);if(q<0){this.$menu.scrollTop(r+q)}else{if(u<s){this.$menu.scrollTop(r+(s-u))}}},destroy:function(){this.$menu.off(".tt");this.$menu=null},isVisible:function(){return this.isOpen&&!this.isEmpty},closeUnlessMouseIsOverDropdown:function(){if(!this.isMouseOverDropdown){this.close()}},close:function(){if(this.isOpen){this.isOpen=false;this.isMouseOverDropdown=false;this._hide();this.$menu.find(".tt-suggestions > .tt-suggestion").removeClass("tt-is-under-cursor");this.trigger("closed")}},open:function(){if(!this.isOpen){this.isOpen=true;!this.isEmpty&&this._show();this.trigger("opened")}},setLanguageDirection:function(q){var r={left:"0",right:"auto"},s={left:"auto",right:" 0"};q==="ltr"?this.$menu.css(r):this.$menu.css(s)},moveCursorUp:function(){this._moveCursor(-1)},moveCursorDown:function(){this._moveCursor(+1)},getSuggestionUnderCursor:function(){var q=this._getSuggestions().filter(".tt-is-under-cursor").first();return q.length>0?m(q):null},getFirstSuggestion:function(){var q=this._getSuggestions().first();return q.length>0?m(q):null},renderSuggestions:function(t,u){var q="tt-dataset-"+t.name,r='<div class="tt-suggestion">%body</div>',x,w,y=this.$menu.find("."+q),s,v,z;if(y.length===0){w=c(o.suggestionsList).css(n.suggestionsList);y=c("<div></div>").addClass(q).append(t.header).append(w).append(t.footer).appendTo(this.$menu)}if(u.length>0){this.isEmpty=false;this.isOpen&&this._show();s=document.createElement("div");v=document.createDocumentFragment();j.each(u,function(B,A){A.dataset=t.name;x=t.template(A.datum);s.innerHTML=r.replace("%body",x);z=c(s.firstChild).css(n.suggestion).data("suggestion",A);z.children().each(function(){c(this).css(n.suggestionChild)});v.appendChild(z[0])});y.show().find(".tt-suggestions").html(v)}else{this.clearSuggestions(t.name)}this.trigger("suggestionsRendered")},clearSuggestions:function(s){var q=s?this.$menu.find(".tt-dataset-"+s):this.$menu.find('[class^="tt-dataset-"]'),r=q.find(".tt-suggestions");q.hide();r.empty();if(this._getSuggestions().length===0){this.isEmpty=true;this._hide()}}});return p;function m(q){return q.data("suggestion")}}();var h=function(){var q={wrapper:'<span class="twitter-typeahead"></span>',hint:'<input class="tt-hint" type="text" autocomplete="off" spellcheck="off" disabled>',dropdown:'<span class="tt-dropdown-menu"></span>'},p={wrapper:{position:"relative",display:"inline-block"},hint:{position:"absolute",top:"0",left:"0",borderColor:"transparent",boxShadow:"none"},query:{position:"relative",verticalAlign:"top",backgroundColor:"transparent"},dropdown:{position:"absolute",top:"100%",left:"0",zIndex:"100",display:"none"}};if(j.isMsie()){j.mixin(p.query,{backgroundImage:"url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)"})}if(j.isMsie()&&j.isMsie()<=7){j.mixin(p.wrapper,{display:"inline",zoom:"1"});j.mixin(p.query,{marginTop:"-1px"})}function n(t){var s,u,r;j.bindAll(this);this.$node=m(t.input);this.datasets=t.datasets;this.dir=null;this.eventBus=t.eventBus;s=this.$node.find(".tt-dropdown-menu");u=this.$node.find(".tt-query");r=this.$node.find(".tt-hint");this.dropdownView=new f({menu:s}).on("suggestionSelected",this._handleSelection).on("cursorMoved",this._clearHint).on("cursorMoved",this._setInputValueToSuggestionUnderCursor).on("cursorRemoved",this._setInputValueToQuery).on("cursorRemoved",this._updateHint).on("suggestionsRendered",this._updateHint).on("opened",this._updateHint).on("closed",this._clearHint).on("opened closed",this._propagateEvent);this.inputView=new b({input:u,hint:r}).on("focused",this._openDropdown).on("blured",this._closeDropdown).on("blured",this._setInputValueToQuery).on("enterKeyed tabKeyed",this._handleSelection).on("queryChanged",this._clearHint).on("queryChanged",this._clearSuggestions).on("queryChanged",this._getSuggestions).on("whitespaceChanged",this._updateHint).on("queryChanged whitespaceChanged",this._openDropdown).on("queryChanged whitespaceChanged",this._setLanguageDirection).on("escKeyed",this._closeDropdown).on("escKeyed",this._setInputValueToQuery).on("tabKeyed upKeyed downKeyed",this._managePreventDefault).on("upKeyed downKeyed",this._moveDropdownCursor).on("upKeyed downKeyed",this._openDropdown).on("tabKeyed leftKeyed rightKeyed",this._autocomplete)}j.mixin(n.prototype,k,{_managePreventDefault:function(u){var t=u.data,v,r,s=false;switch(u.type){case"tabKeyed":v=this.inputView.getHintValue();r=this.inputView.getInputValue();s=v&&v!==r;break;case"upKeyed":case"downKeyed":s=!t.shiftKey&&!t.ctrlKey&&!t.metaKey;break}s&&t.preventDefault()},_setLanguageDirection:function(){var r=this.inputView.getLanguageDirection();if(r!==this.dir){this.dir=r;this.$node.css("direction",r);this.dropdownView.setLanguageDirection(r)}},_updateHint:function(){var u=this.dropdownView.getFirstSuggestion(),t=u?u.value:null,x=this.dropdownView.isVisible(),w=this.inputView.isOverflow(),s,y,z,r,v;if(t&&x&&!w){s=this.inputView.getInputValue();y=s.replace(/\s{2,}/g," ").replace(/^\s+/g,"");z=j.escapeRegExChars(y);r=new RegExp("^(?:"+z+")(.*$)","i");v=r.exec(t);this.inputView.setHintValue(s+(v?v[1]:""))}},_clearHint:function(){this.inputView.setHintValue("")},_clearSuggestions:function(){this.dropdownView.clearSuggestions()},_setInputValueToQuery:function(){this.inputView.setInputValue(this.inputView.getQuery())},_setInputValueToSuggestionUnderCursor:function(s){var r=s.data;this.inputView.setInputValue(r.value,true)},_openDropdown:function(){this.dropdownView.open()},_closeDropdown:function(r){this.dropdownView[r.type==="blured"?"closeUnlessMouseIsOverDropdown":"close"]()},_moveDropdownCursor:function(s){var r=s.data;if(!r.shiftKey&&!r.ctrlKey&&!r.metaKey){this.dropdownView[s.type==="upKeyed"?"moveCursorUp":"moveCursorDown"]()}},_handleSelection:function(t){var s=t.type==="suggestionSelected",r=s?t.data:this.dropdownView.getSuggestionUnderCursor();if(r){this.inputView.setInputValue(r.value);s?this.inputView.focus():t.data.preventDefault();s&&j.isMsie()?j.defer(this.dropdownView.close):this.dropdownView.close();this.eventBus.trigger("selected",r.datum,r.dataset)}},_getSuggestions:function(){var r=this,s=this.inputView.getQuery();if(j.isBlankString(s)){return}j.each(this.datasets,function(t,u){u.getSuggestions(s,function(v){if(s===r.inputView.getQuery()){r.dropdownView.renderSuggestions(u,v)}})})},_autocomplete:function(v){var s,r,u,w,t;if(v.type==="rightKeyed"||v.type==="leftKeyed"){s=this.inputView.isCursorAtEnd();r=this.inputView.getLanguageDirection()==="ltr"?v.type==="leftKeyed":v.type==="rightKeyed";if(!s||r){return}}u=this.inputView.getQuery();w=this.inputView.getHintValue();if(w!==""&&u!==w){t=this.dropdownView.getFirstSuggestion();this.inputView.setInputValue(t.value);this.eventBus.trigger("autocompleted",t.datum,t.dataset)}},_propagateEvent:function(r){this.eventBus.trigger(r.type)},destroy:function(){this.inputView.destroy();this.dropdownView.destroy();o(this.$node);this.$node=null},setQuery:function(r){this.inputView.setQuery(r);this.inputView.setInputValue(r);this._clearHint();this._clearSuggestions();this._getSuggestions()}});return n;function m(r){var t=c(q.wrapper),v=c(q.dropdown),w=c(r),s=c(q.hint);t=t.css(p.wrapper);v=v.css(p.dropdown);s.css(p.hint).css({backgroundAttachment:w.css("background-attachment"),backgroundClip:w.css("background-clip"),backgroundColor:w.css("background-color"),backgroundImage:w.css("background-image"),backgroundOrigin:w.css("background-origin"),backgroundPosition:w.css("background-position"),backgroundRepeat:w.css("background-repeat"),backgroundSize:w.css("background-size")});w.data("ttAttrs",{dir:w.attr("dir"),autocomplete:w.attr("autocomplete"),spellcheck:w.attr("spellcheck"),style:w.attr("style")});w.addClass("tt-query").attr({autocomplete:"off",spellcheck:false}).css(p.query);try{!w.attr("dir")&&w.attr("dir","auto")}catch(u){}return w.wrap(t).parent().prepend(s).append(v)}function o(r){var s=r.find(".tt-query");j.each(s.data("ttAttrs"),function(t,u){j.isUndefined(u)?s.removeAttr(t):s.attr(t,u)});s.detach().removeData("ttAttrs").removeClass("tt-query").insertAfter(r);r.remove()}}();(function(){var n={},o="ttView",m;m={initialize:function(r){var q;r=j.isArray(r)?r:[r];if(r.length===0){c.error("no datasets provided")}q=j.map(r,function(t){var s=n[t.name]?n[t.name]:new a(t);if(t.name){n[t.name]=s}return s});return this.each(p);function p(){var u=c(this),t,s=new e({el:u});t=j.map(q,function(v){return v.initialize()});u.data(o,new h({input:u,eventBus:s=new e({el:u}),datasets:q}));c.when.apply(c,t).always(function(){j.defer(function(){s.trigger("initialized")})})}},destroy:function(){return this.each(p);function p(){var r=c(this),q=r.data(o);if(q){q.destroy();r.removeData(o)}}},setQuery:function(p){return this.each(q);function q(){var r=c(this).data(o);r&&r.setQuery(p)}}};jQuery.fn.typeahead=function(p){if(m[p]){return m[p].apply(this,[].slice.call(arguments,1))}else{return m.initialize.apply(this,arguments)}}})()})(window.jQuery);