(function(h,m){function n(a,b,c){var d=r[b.type]||{};if(null==a)return c||!b.def?null:b.def;a=d.floor?~~a:parseFloat(a);return isNaN(a)?b.def:d.mod?(a+d.mod)%d.mod:0>a?0:d.max<a?d.max:a}function s(a){var b=f(),c=b._rgba=[],a=a.toLowerCase();j(v,function(d,g){var e,i=g.re.exec(a);e=i&&g.parse(i);i=g.space||"rgba";if(e)return e=b[i](e),b[k[i].cache]=e[k[i].cache],c=b._rgba=e._rgba,!1});return c.length?("0,0,0,0"===c.join()&&h.extend(c,o.transparent),b):o[a]}function p(a,b,c){c=(c+1)%1;return 1>6*c?
a+6*(b-a)*c:1>2*c?b:2>3*c?a+6*(b-a)*(2/3-c):a}var w=/^([\-+])=\s*(\d+\.?\d*)/,v=[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(a){return[a[1],a[2],a[3],a[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(a){return[2.55*a[1],2.55*a[2],2.55*a[3],a[4]]}},{re:/#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,parse:function(a){return[parseInt(a[1],16),parseInt(a[2],16),
parseInt(a[3],16)]}},{re:/#([a-f0-9])([a-f0-9])([a-f0-9])/,parse:function(a){return[parseInt(a[1]+a[1],16),parseInt(a[2]+a[2],16),parseInt(a[3]+a[3],16)]}},{re:/hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,space:"hsla",parse:function(a){return[a[1],a[2]/100,a[3]/100,a[4]]}}],f=h.Color=function(a,b,c,d){return new h.Color.fn.parse(a,b,c,d)},k={rgba:{props:{red:{idx:0,type:"byte"},green:{idx:1,type:"byte"},blue:{idx:2,type:"byte"}}},hsla:{props:{hue:{idx:0,
type:"degrees"},saturation:{idx:1,type:"percent"},lightness:{idx:2,type:"percent"}}}},r={"byte":{floor:!0,max:255},percent:{max:1},degrees:{mod:360,floor:!0}},t=f.support={},u=h("<p>")[0],o,j=h.each;u.style.cssText="background-color:rgba(1,1,1,.5)";t.rgba=-1<u.style.backgroundColor.indexOf("rgba");j(k,function(a,b){b.cache="_"+a;b.props.alpha={idx:3,type:"percent",def:1}});f.fn=h.extend(f.prototype,{parse:function(a,b,c,d){if(a===m)return this._rgba=[null,null,null,null],this;if(a.jquery||a.nodeType)a=
h(a).css(b),b=m;var g=this,e=h.type(a),i=this._rgba=[];b!==m&&(a=[a,b,c,d],e="array");if("string"===e)return this.parse(s(a)||o._default);if("array"===e)return j(k.rgba.props,function(d,c){i[c.idx]=n(a[c.idx],c)}),this;if("object"===e)return a instanceof f?j(k,function(c,d){a[d.cache]&&(g[d.cache]=a[d.cache].slice())}):j(k,function(d,c){var b=c.cache;j(c.props,function(d,e){if(!g[b]&&c.to){if(d==="alpha"||a[d]==null)return;g[b]=c.to(g._rgba)}g[b][e.idx]=n(a[d],e,true)});if(g[b]&&h.inArray(null,g[b].slice(0,
3))<0){g[b][3]=1;if(c.from)g._rgba=c.from(g[b])}}),this},is:function(a){var b=f(a),c=!0,d=this;j(k,function(a,e){var i,h=b[e.cache];h&&(i=d[e.cache]||e.to&&e.to(d._rgba)||[],j(e.props,function(a,d){if(null!=h[d.idx])return c=h[d.idx]===i[d.idx]}));return c});return c},_space:function(){var a=[],b=this;j(k,function(c,d){b[d.cache]&&a.push(c)});return a.pop()},transition:function(a,b){var c=f(a),d=c._space(),g=k[d],e=0===this.alpha()?f("transparent"):this,i=e[g.cache]||g.to(e._rgba),h=i.slice(),c=c[g.cache];
j(g.props,function(a,d){var g=d.idx,e=i[g],f=c[g],j=r[d.type]||{};null!==f&&(null===e?h[g]=f:(j.mod&&(f-e>j.mod/2?e+=j.mod:e-f>j.mod/2&&(e-=j.mod)),h[g]=n((f-e)*b+e,d)))});return this[d](h)},blend:function(a){if(1===this._rgba[3])return this;var b=this._rgba.slice(),c=b.pop(),d=f(a)._rgba;return f(h.map(b,function(a,b){return(1-c)*d[b]+c*a}))},toRgbaString:function(){var a="rgba(",b=h.map(this._rgba,function(a,d){return null==a?2<d?1:0:a});1===b[3]&&(b.pop(),a="rgb(");return a+b.join()+")"},toHslaString:function(){var a=
"hsla(",b=h.map(this.hsla(),function(a,d){null==a&&(a=2<d?1:0);d&&3>d&&(a=Math.round(100*a)+"%");return a});1===b[3]&&(b.pop(),a="hsl(");return a+b.join()+")"},toHexString:function(a){var b=this._rgba.slice(),c=b.pop();a&&b.push(~~(255*c));return"#"+h.map(b,function(a){a=(a||0).toString(16);return 1===a.length?"0"+a:a}).join("")},toString:function(){return 0===this._rgba[3]?"transparent":this.toRgbaString()}});f.fn.parse.prototype=f.fn;k.hsla.to=function(a){if(null==a[0]||null==a[1]||null==a[2])return[null,
null,null,a[3]];var b=a[0]/255,c=a[1]/255,d=a[2]/255,a=a[3],g=Math.max(b,c,d),e=Math.min(b,c,d),i=g-e,h=g+e,f=0.5*h;return[Math.round(e===g?0:b===g?60*(c-d)/i+360:c===g?60*(d-b)/i+120:60*(b-c)/i+240)%360,0===f||1===f?f:0.5>=f?i/h:i/(2-h),f,null==a?1:a]};k.hsla.from=function(a){if(null==a[0]||null==a[1]||null==a[2])return[null,null,null,a[3]];var b=a[0]/360,c=a[1],d=a[2],a=a[3],c=0.5>=d?d*(1+c):d+c-d*c,d=2*d-c;return[Math.round(255*p(d,c,b+1/3)),Math.round(255*p(d,c,b)),Math.round(255*p(d,c,b-1/3)),
a]};j(k,function(a,b){var c=b.props,d=b.cache,g=b.to,e=b.from;f.fn[a]=function(a){g&&!this[d]&&(this[d]=g(this._rgba));if(a===m)return this[d].slice();var b,q=h.type(a),k="array"===q||"object"===q?a:arguments,l=this[d].slice();j(c,function(a,d){var b=k["object"===q?a:d.idx];null==b&&(b=l[d.idx]);l[d.idx]=n(b,d)});return e?(b=f(e(l)),b[d]=l,b):f(l)};j(c,function(d,b){f.fn[d]||(f.fn[d]=function(c){var e=h.type(c),g="alpha"===d?this._hsla?"hsla":"rgba":a,f=this[g](),j=f[b.idx];if("undefined"===e)return j;
"function"===e&&(c=c.call(this,j),e=h.type(c));if(null==c&&b.empty)return this;"string"===e&&(e=w.exec(c))&&(c=j+parseFloat(e[2])*("+"===e[1]?1:-1));f[b.idx]=c;return this[g](f)})})});f.hook=function(a){a=a.split(" ");j(a,function(a,c){h.cssHooks[c]={set:function(a,b){var e,i="";if("string"!==h.type(b)||(e=s(b))){b=f(e||b);if(!t.rgba&&1!==b._rgba[3]){for(e="backgroundColor"===c?a.parentNode:a;(""===i||"transparent"===i)&&e&&e.style;)try{i=h.css(e,"backgroundColor"),e=e.parentNode}catch(j){}b=b.blend(i&&
"transparent"!==i?i:"_default")}b=b.toRgbaString()}try{a.style[c]=b}catch(k){}}};h.fx.step[c]=function(a){a.colorInit||(a.start=f(a.elem,c),a.end=f(a.end),a.colorInit=!0);h.cssHooks[c].set(a.elem,a.start.transition(a.end,a.pos))}})};f.hook("backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor");h.cssHooks.borderColor={expand:function(a){var b={};j(["Top","Right","Bottom","Left"],function(c,d){b["border"+
d+"Color"]=a});return b}};o=h.Color.names={aqua:"#00ffff",black:"#000000",blue:"#0000ff",fuchsia:"#ff00ff",gray:"#808080",green:"#008000",lime:"#00ff00",maroon:"#800000",navy:"#000080",olive:"#808000",purple:"#800080",red:"#ff0000",silver:"#c0c0c0",teal:"#008080",white:"#ffffff",yellow:"#ffff00",transparent:[null,null,null,0],_default:"#ffffff"}})(jQuery);