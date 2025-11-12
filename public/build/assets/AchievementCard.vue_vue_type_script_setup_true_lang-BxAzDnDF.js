import{c as n}from"./PublicLayout.vue_vue_type_script_setup_true_lang-DUZBXdru.js";import{C as c}from"./calendar-CfhrwA6t.js";import{d as r,c as d,o as i,a as e,i as s,j as l,f as o,t as a}from"./app-B26E56ET.js";/**
 * @license lucide-vue-next v0.541.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h=n("award",[["path",{d:"m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526",key:"1yiouv"}],["circle",{cx:"12",cy:"8",r:"6",key:"1vp47v"}]]);/**
 * @license lucide-vue-next v0.541.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p=n("graduation-cap",[["path",{d:"M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z",key:"j76jl0"}],["path",{d:"M22 10v6",key:"1lu8f3"}],["path",{d:"M6 12.5V16a6 3 0 0 0 12 0v-3.5",key:"1r8lef"}]]);/**
 * @license lucide-vue-next v0.541.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m=n("medal",[["path",{d:"M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15",key:"143lza"}],["path",{d:"M11 12 5.12 2.2",key:"qhuxz6"}],["path",{d:"m13 12 5.88-9.8",key:"hbye0f"}],["path",{d:"M8 7h8",key:"i86dvs"}],["circle",{cx:"12",cy:"17",r:"5",key:"qbz8iq"}],["path",{d:"M12 18v-2h-.5",key:"fawc4q"}]]);/**
 * @license lucide-vue-next v0.541.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f=n("trophy",[["path",{d:"M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978",key:"1n3hpd"}],["path",{d:"M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978",key:"rfe1zi"}],["path",{d:"M18 9h1.5a1 1 0 0 0 0-5H18",key:"7xy6bh"}],["path",{d:"M4 22h16",key:"57wxv0"}],["path",{d:"M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z",key:"1mhfuq"}],["path",{d:"M6 9H4.5a1 1 0 0 1 0-5H6",key:"tex48p"}]]),x={class:"bg-[#CBDCEB] rounded-lg overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg flex flex-col"},v={class:"aspect-video"},y=["src","alt"],_={class:"p-5 flex flex-col flex-grow justify-between"},u={class:"flex items-center flex-wrap gap-2 mb-3"},b={class:"inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]"},g={class:"inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]"},k={class:"inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]"},w={class:"text-xl font-bold text-black leading-snug"},M={class:"flex items-center gap-2 text-sm text-black mt-1"},z={class:"mt-4 pt-4 border-t border-gray-400/50 flex flex-col"},E={class:"flex items-start gap-2 text-base font-bold text-black min-h-[3rem]"},F={class:"flex-1"},C={class:"text-sm text-black mt-2"},V=r({__name:"AchievementCard",props:{achievement:{}},setup(A){return(t,j)=>(i(),d("div",x,[e("div",v,[e("img",{src:t.achievement.photo_url,alt:"Foto "+t.achievement.student_name,class:"w-full h-full object-cover",loading:"lazy",onerror:"this.onerror=null;this.src='https://placehold.co/600x400/cccccc/FFFFFF?text=Image+Not+Found';"},null,8,y)]),e("div",_,[e("div",null,[e("div",u,[e("span",b,[s(o(f),{class:"h-3 w-3"}),l(" "+a(t.achievement.category),1)]),e("span",g,[s(o(m),{class:"h-3 w-3"}),l(" "+a(t.achievement.level),1)]),e("span",k,[s(o(c),{class:"h-3 w-3"}),l(" "+a(t.achievement.year),1)])]),e("h3",w,a(t.achievement.student_name),1),e("p",M,[s(o(p),{class:"h-4 w-4"}),l(" "+a(t.achievement.study_program),1)])]),e("div",z,[e("p",E,[s(o(h),{class:"h-5 w-5 flex-shrink-0 mt-0.5"}),e("span",F,a(t.achievement.achievement_name),1)]),e("p",C," Oleh: "+a(t.achievement.organizer),1)])])]))}});export{h as A,p as G,m as M,f as T,V as _};
