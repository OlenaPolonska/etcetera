(()=>{"use strict";var e={338:(e,t,n)=>{var o=n(795);t.H=o.createRoot,o.hydrateRoot},795:e=>{e.exports=window.ReactDOM}},t={};const n=window.React;var o=function n(o){var i=t[o];if(void 0!==i)return i.exports;var r=t[o]={exports:{}};return e[o](r,r.exports,n),r.exports}(338);const i=window.lodash;const r=window.wp.i18n,{IconChooserModal:c}=(0,i.get)(window,["__FontAwesomeOfficialPlugin__","iconChooser"],{});function s(e,t,r){const s=new Event(a||`fontAwesomeIconChooser-${function(e){let t="";for(let e=0;e<16;e++)t+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".charAt(Math.floor(62*Math.random()));return t}()}`,{bubbles:!0,cancelable:!1});var a;const d=document.createElement("div");return t.appendChild(d),(0,o.H)(d).render((0,n.createElement)(c,{onSubmit:function(t){r(e,function(e){const t=[];if(!e.iconName)return void console.error("Font Awesome Icon Chooser: missing required iconName attribute for shortcode");t.push(`name="${e.iconName}"`);const n=["prefix","style","class","aria-hidden","aria-label","aria-labelledby","title","role"];for(const o of n){const n=(0,i.get)(e,o);n&&t.push(`${o}="${n}"`)}return`[icon ${t.join(" ")}]`}(t.detail))},openEvent:s})),()=>{document.dispatchEvent(s)}}function a(e,t){const n=(0,i.get)(window,`tinymce.editors.${e}`);if(n&&!n.hidden)return void n.insertContent(t);const o=window.QTags&&QTags.getInstance(e),r=function(e){const t=window.getComputedStyle(e);if("none"===t.display)return!1;if("hidden"===t.visibility)return!1;const n=e.getBoundingClientRect();return 0!==n.width&&0!==n.height}(o.canvas);o&&r&&QTags.insertContent(t,e)}function d(){const e=(0,i.get)(window,"__FontAwesomeOfficialPlugin_tinymce__.editors",[]);for(const t of e){const e=document.querySelector(`#fawp-tinymce-${t}`),n=document.querySelector(`#${t}`),o=n.parentElement;if(!n||!e||!o){console.error((0,r.__)("Font Awesome Plugin: could not attach to editor id:","font-awesome"),t);continue}const i=s(t,o,((e,t)=>{a(e,t)}));e.addEventListener("click",i)}}"complete"===document.readyState?d():window.addEventListener("DOMContentLoaded",(()=>{d()}))})();