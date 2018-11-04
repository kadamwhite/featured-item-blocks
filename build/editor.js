!function(n){var r={};function o(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}o.m=n,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)o.d(n,r,function(e){return t[e]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=9)}([function(e,t){e.exports=wp.data},function(e,t){e.exports=wp.i18n},function(e,t,n){"use strict";n.d(t,"c",function(){return c}),n.d(t,"d",function(){return u}),n.d(t,"a",function(){return a}),n.d(t,"b",function(){return l});var r=n(4),o=n(5),i=n(0),c=function(n,e){e&&e.dispose(function(e){var t=function(e){var t=Object(i.select)("core/editor").getSelectedBlock();if(t&&t.name===e)return Object(i.dispatch)("core/editor").clearSelectedBlock(),t.clientId}(n);t&&(e.clientId=t),r.unregisterBlockType(n)})},u=function(e,t){t&&t.dispose(function(){o.unregisterPlugin(e)})},a=function(e,t,n){r.registerBlockType(e,t),n&&n.data&&n.data.clientId&&Object(i.dispatch)("core/editor").selectBlock(n.data.clientId)},l=function(e,t){o.registerPlugin(e,t)}},function(e,t){e.exports=wp.components},function(e,t){e.exports=wp.blocks},function(e,t){e.exports=wp.plugins},function(e,t,n){var o=n(13);e.exports=function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{},r=Object.keys(n);"function"==typeof Object.getOwnPropertySymbols&&(r=r.concat(Object.getOwnPropertySymbols(n).filter(function(e){return Object.getOwnPropertyDescriptor(n,e).enumerable}))),r.forEach(function(e){o(t,e,n[e])})}return t}},function(e,t){e.exports=wp.editPost},function(e,t){e.exports=wp.compose},function(e,t,n){"use strict";n.r(t),function(c){var e=n(2);window.whatModuleExports=function(t){Object.keys(window.wp).forEach(function(e){Object.keys(window.wp[e]).includes(t)&&console.log("Export named ".concat(t," found in wp.").concat(e,"!"))})};var t=function(o,i,e){o.keys().forEach(function(e){var t=o(e),n=t.name,r=t.options;i(n,r,c.hot)})};t(n(11),e.a,e.c),t(n(15),e.b,e.d)}.call(this,n(10)(e))},function(e,t){e.exports=function(e){if(!e.webpackPolyfill){var t=Object.create(e);t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),Object.defineProperty(t,"exports",{enumerable:!0}),t.webpackPolyfill=1}return t}},function(e,t,n){var r={"./featured-items-list/index.js":12};function o(e){var t=i(e);return n(t)}function i(e){var t=r[e];if(t+1)return t;var n=new Error("Cannot find module '"+e+"'");throw n.code="MODULE_NOT_FOUND",n}o.keys=function(){return Object.keys(r)},o.resolve=i,(e.exports=o).id=11},function(e,t,n){"use strict";n.r(t),n.d(t,"name",function(){return u}),n.d(t,"options",function(){return a});var r=n(6),o=n.n(r),i=n(1),c=n(3),u=(n(14),"featured-item-blocks/featured-items-list"),a={title:Object(i.__)("Featured Items List"),description:Object(i.__)("Display a list of featured items."),icon:"star-empty",category:"widgets",attributes:{count:{type:"number",default:4},editMode:{type:"boolean",default:!1},postsPerCategory:{type:"number",default:3}},edit:function(e){var t=e.attributes;return wp.element.createElement("div",{className:"featured-items-list"},wp.element.createElement(c.ServerSideRender,{block:u,attributes:o()({},t,{editMode:!0})}))},save:function(){return null}}},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}},function(e,t,n){},function(e,t,n){var r={"./featured-item-selector/index.js":16};function o(e){var t=i(e);return n(t)}function i(e){var t=r[e];if(t+1)return t;var n=new Error("Cannot find module '"+e+"'");throw n.code="MODULE_NOT_FOUND",n}o.keys=function(){return Object.keys(r)},o.resolve=i,(e.exports=o).id=15},function(e,t,n){"use strict";n.r(t);var r=n(7),o=n(3),i=n(8),c=n(1),u=n(0),a=["post"],l=Object(u.withSelect)(function(e){var t=e("core/editor");return{meta:t.getEditedPostAttribute("meta"),postType:t.getCurrentPostType()}}),f=Object(u.withDispatch)(function(e,t){var n=t.meta,r=e("core/editor").editPost;return{toggleMeta:function(){return r({meta:{_featured:"yes"===n._featured?null:"yes"}})}}}),s=Object(i.compose)([l,f])(function(e){var t=e.meta,n=e.postType,r=e.toggleMeta;return a.includes(n)?wp.element.createElement(o.CheckboxControl,{label:Object(c.__)("Feature this post"),checked:"yes"===t._featured,onChange:r}):null});n.d(t,"name",function(){return d}),n.d(t,"options",function(){return p});var d="featured-item-selector",p={icon:"star-empty",render:function(){return wp.element.createElement(r.PluginPostStatusInfo,null,wp.element.createElement(s,null))}}}]);