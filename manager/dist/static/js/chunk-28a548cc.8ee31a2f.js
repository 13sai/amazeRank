(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-28a548cc"],{"09fd":function(e,t,a){"use strict";var i=a("bb0c"),s=a.n(i);s.a},"432a":function(e,t,a){"use strict";a.r(t);var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"app-container calendar-list-container"},[a("div",{staticClass:"filter-container"},[a("el-button",{staticClass:"filter-item",staticStyle:{"margin-left":"10px"},attrs:{type:"primary",icon:"edit"},on:{click:function(t){return e.doAdd()}}},[e._v("添加")])],1),e._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.listLoading,expression:"listLoading"}],key:"tableList",staticStyle:{width:"100%"},attrs:{data:e.list,"element-loading-text":"给我一点时间",border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{align:"center",label:"序号",width:"65"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("span",[e._v(e._s(t.row.id))])]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"图片",width:"250"},scopedSlots:e._u([{key:"default",fn:function(e){return[a("img",{staticStyle:{width:"200px"},attrs:{src:e.row.thumbnail}})]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"排序"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("span",[e._v(e._s(t.row.order))])]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"跳转类型"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("span",[e._v(e._s(0==t.row.redirect_type?"不跳转":1==t.row.redirect_type?"跳转小程序":"跳转网页"))])]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"跳转地址"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("span",[e._v(e._s(t.row.path))])]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"是否展示"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("span",[e._v(e._s(1==t.row.is_show?"是":"否"))])]}}])}),e._v(" "),a("el-table-column",{attrs:{align:"center",label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{size:"small",type:"primary"},on:{click:function(a){return e.updateAction(t.row)}}},[e._v("编辑")]),e._v(" "),a("el-button",{attrs:{size:"small",type:"danger"},on:{click:function(a){return e.deleteBanner(t.row.id)}}},[e._v("删除")])]}}])})],1),e._v(" "),a("el-dialog",{attrs:{title:e.dialogTitle,visible:e.dialogFormVisible},on:{"update:visible":function(t){e.dialogFormVisible=t}}},[a("el-form",{staticClass:"small-space",staticStyle:{width:"500px","margin-left":"50px"},attrs:{model:e.temp,"label-position":"left","label-width":"100px"}},[a("el-form-item",{attrs:{label:"banner"}},[a("el-upload",{staticClass:"avatar-uploader",attrs:{action:e.uploadPath,headers:e.header,"show-file-list":!1,"on-success":e.handleImageSuccess}},[e.temp.thumbnail?a("img",{staticClass:"avatar",staticStyle:{"max-width":"100%"},attrs:{src:e.temp.thumbnail}}):a("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1),e._v(" "),a("el-form-item",{attrs:{label:"描述"}},[a("el-input",{model:{value:e.temp.desc,callback:function(t){e.$set(e.temp,"desc",t)},expression:"temp.desc"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"跳转类型"}},[a("el-radio-group",{model:{value:e.temp.redirect_type,callback:function(t){e.$set(e.temp,"redirect_type",t)},expression:"temp.redirect_type"}},[a("el-radio",{attrs:{label:0}},[e._v("不跳转")]),e._v(" "),a("el-radio",{attrs:{label:1}},[e._v("小程序页面")]),e._v(" "),a("el-radio",{attrs:{label:2}},[e._v("网页")])],1)],1),e._v(" "),a("el-form-item",{directives:[{name:"show",rawName:"v-show",value:e.temp.redirect_type,expression:"temp.redirect_type"}],attrs:{label:"链接路径"}},[a("el-input",{model:{value:e.temp.path,callback:function(t){e.$set(e.temp,"path",t)},expression:"temp.path"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"排序"}},[a("el-input",{model:{value:e.temp.order,callback:function(t){e.$set(e.temp,"order",t)},expression:"temp.order"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"是否展示",prop:"is_show"}},[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},model:{value:e.temp.is_show,callback:function(t){e.$set(e.temp,"is_show",t)},expression:"temp.is_show"}},[e._v("是")])],1)],1),e._v(" "),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(t){e.dialogFormVisible=!1}}},[e._v("取 消")]),e._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:e.createBanner}},[e._v("确 定")])],1)],1)],1)},s=[],r=a("b775");function l(e){return Object(r["a"])({url:"/bannerList",method:"get",params:e})}function n(e){var t=JSON.parse(JSON.stringify(e));return t.start_time=new Date(t.start_time).getTime(),t.over_time=new Date(t.over_time).getTime(),Object(r["a"])({url:"/banner",method:"post",params:t})}function o(e){var t=JSON.parse(JSON.stringify(e));return t.start_time=new Date(t.start_time).getTime(),t.over_time=new Date(t.over_time).getTime(),Object(r["a"])({url:"/banner",method:"put",params:t})}function c(e){return Object(r["a"])({url:"/banner",method:"delete",params:e})}function d(e){return Object(r["a"])({url:"/showBanner",method:"put",params:e})}var u=a("5f87"),m=a("cf45"),p={name:"Banner",data:function(){return{list:null,imageUrl:"",dialogFormVisible:!1,uploadPath:m["a"],temp:{thumbnail:"",desc:"",path:"",order:0,redirect_type:0,is_show:1},dialogTitle:"添加banner",header:{Authorization:Object(u["a"])()}}},created:function(){this.getList()},methods:{doAdd:function(){this.dialogTitle="添加banner",this.temp={thumbnail:"",desc:"",path:"",order:0,redirect_type:0,is_show:1,area_id:""},this.dialogFormVisible=!0},getList:function(){var e=this;this.listLoading=!0,l().then((function(t){e.list=t.data})),this.listLoading=!1},handleImageSuccess:function(e){0==e.code?(this.temp.thumbnail=e.data.filepath,this.$forceUpdate(),this.$message.success("上传成功！")):this.$message.error("上传失败")},createBanner:function(){var e=this;"添加banner"==this.dialogTitle?n(this.temp).then((function(t){0==t.code?(e.$message.success("添加成功！"),e.getList(),e.temp={thumbnail:"",desc:"",path:"",order:0,redirect_type:0,is_show:1},e.dialogFormVisible=!e.dialogFormVisible):e.$message.error(t.msg)})):o(this.temp).then((function(t){0==t.code?(e.$message.success("编辑成功！"),e.getList(),e.temp={thumbnail:"",full_pic:"",desc:"",goods_id:"",type:0,order:0,height:0},e.dialogFormVisible=!e.dialogFormVisible):e.$message.error(t.msg),e.dialogTitle="添加banner"}))},handleShow:function(e){var t=this;d({id:e}).then((function(e){0==e.data.code?(t.$message.success(e.data.msg),t.getList()):t.$message.error(e.data.msg)}))},deleteBanner:function(e){var t=this;c({id:e}).then((function(e){0==e.code?(t.$message.success("删除成功！"),t.getList()):t.$message.error(e.msg)}))},updateAction:function(e){this.temp=e,this.dialogTitle="编辑banner",this.dialogFormVisible=!this.dialogFormVisible}}},h=p,f=(a("09fd"),a("2877")),b=Object(f["a"])(h,i,s,!1,null,null,null);t["default"]=b.exports},bb0c:function(e,t,a){},cf45:function(e,t,a){"use strict";a.d(t,"a",(function(){return i}));var i="/admin/img/upload"}}]);