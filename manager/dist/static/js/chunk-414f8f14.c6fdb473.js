(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-414f8f14"],{"9b43e":function(t,e,n){},cf45:function(t,e,n){"use strict";n.d(e,"a",(function(){return i}));var i="/admin/img/upload"},d02c:function(t,e,n){"use strict";var i=n("9b43e"),a=n.n(i);a.a},f2f4:function(t,e,n){"use strict";n.r(e);var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container"},[n("div",{staticClass:"filter-container"},[n("el-input",{staticClass:"filter-item",staticStyle:{width:"100px"},attrs:{placeholder:"ID"},model:{value:t.listQuery.id,callback:function(e){t.$set(t.listQuery,"id",e)},expression:"listQuery.id"}}),t._v(" "),n("el-input",{staticClass:"filter-item",staticStyle:{width:"150px"},attrs:{placeholder:"昵称"},model:{value:t.listQuery.nickname,callback:function(e){t.$set(t.listQuery,"nickname",e)},expression:"listQuery.nickname"}}),t._v(" "),n("el-button",{staticClass:"filter-item",attrs:{type:"primary",icon:"el-icon-search"},on:{click:t.handleFilter}},[t._v("查询")])],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],key:"id",attrs:{data:t.list,"element-loading-text":"给我一点时间",border:"",fit:"","highlight-current-row":""}},[n("el-table-column",{attrs:{align:"center",label:"ID"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.id))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"头像","class-name":"overflow-on"},scopedSlots:t._u([{key:"default",fn:function(t){return[n("img",{staticStyle:{width:"100px"},attrs:{src:t.row.avatar_url}})]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"昵称"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.nickname))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"组织名称"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.org))]),t._v(" "),n("el-button",{attrs:{size:"small",type:"primary"},on:{click:function(n){return t.open(e.row.id)}}},[t._v("\n            编辑\n          ")])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"大学"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.college?e.row.college.name:""))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"center",label:"注册时间"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.created_at))])]}}])}),t._v(" "),n("el-table-column",{attrs:{align:"left",label:"操作",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[2==e.row.status?n("el-button",{attrs:{size:"small",type:"danger"},on:{click:function(n){return t.changeStatus(e.row)}}},[t._v("\n            取消授权\n          ")]):n("el-button",{attrs:{size:"small",type:"warning"},on:{click:function(n){return t.changeStatus(e.row)}}},[t._v("\n            发布授权\n          ")])]}}])})],1),t._v(" "),n("div",{staticClass:"pagination-container text-right"},[n("el-pagination",{attrs:{background:"",total:t.pagination.total,"current-page":t.listQuery.page,"page-sizes":[20],"page-size":t.listQuery.limit,layout:"total, sizes, prev, pager, next, jumper"},on:{"size-change":t.handleSizeChange,"current-change":t.handleCurrentChange}})],1)],1)},a=[],s=n("ade3"),o=n("b775");function r(t){return Object(o["a"])({url:"/members",method:"get",params:t})}function l(t){return Object(o["a"])({url:"/member/auth/".concat(t),method:"post"})}function c(t,e){return Object(o["a"])({url:"/member/org/".concat(t),method:"post",data:e})}function u(t){return Object(o["a"])({url:"/member/noAuth/".concat(t),method:"post"})}n("5f87"),n("cf45");var d={name:"articleIndex",data:function(){var t;return t={btn:!1,list:null,imageUrl:"",pagination:{},dialogFormVisible:!1,listQuery:{page:1,limit:20,id:"",created_at:"",status:"",mobile:"",nickname:""}},Object(s["a"])(t,"pagination",""),Object(s["a"])(t,"dialogTitle","添加"),Object(s["a"])(t,"status_list",{}),t},created:function(){this.getList()},methods:{getList:function(){var t=this;this.listLoading=!0,r(this.listQuery).then((function(e){var n=e.data;t.list=n.data,t.pagination=n})),this.listLoading=!1},open:function(t){var e=this;this.$prompt("请输入组织名称","提示",{confirmButtonText:"确定",cancelButtonText:"取消"}).then((function(n){var i=n.value;console.log(i),c(t,{org:i}).then((function(t){0==t.code?(e.$message.success(t.msg),e.getList()):e.$message.error(t.msg)}))})).catch((function(){}))},handleFilter:function(){this.listQuery.page=1,this.getList()},handleSizeChange:function(t){this.listQuery.limit=t,this.getList()},handleCurrentChange:function(t){this.listQuery.page=t,this.getList()},resetForm:function(){this.listQuery.title="",this.listQuery.type=""},changeStatus:function(t){var e=this;1==t.status?l(t.id).then((function(n){t.status=2,e.$message.success(n.msg)})):u(t.id).then((function(n){t.status=1,e.$message.success(n.msg)}))},handleCardImageSuccess:function(t,e){0==t.code?(this.temp.image=t.data.filepath,this.$message.success("上传成功！")):this.$message.error("上传失败")},showCreateCoupon:function(){this.temp={type:"",title:"",content:"",sort:0,desc:"",image:""},this.dialogTitle="添加",this.dialogFormVisible=!0},doAddCoupon:function(){var t=this;create(this.temp).then((function(e){0==e.code?(t.$message.success("添加成功！"),t.getList(),t.dialogFormVisible=!t.dialogFormVisible):t.$message.error(e.msg)}))},createCoupon:function(t){var e=this;this.$refs[t].validate((function(t){if(!t)return e.$notify.error({title:"错误",message:"请检查输入是否正确",offset:100}),!1;"添加"==e.dialogTitle?e.doAddCoupon():edit(e.temp.id,e.temp).then((function(t){e.btn=!1,0==t.code?(e.$message.success("编辑成功！"),e.getList(),e.dialogFormVisible=!e.dialogFormVisible):e.$message.error(t.data.msg)}))}))},deleteCoupon:function(t){var e=this;this.$confirm("确认删除?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){deleteS(t).then((function(t){0==t.code?(e.$message.success("删除成功！"),e.getList()):e.$message.error(t.data.msg)}))}))},updateAction:function(t){this.btn=!1,this.temp=t,console.log(t),this.dialogTitle="编辑",this.dialogFormVisible=!this.dialogFormVisible},getTime:function(t){var e=new Date(t);return e},onEditorReady:function(t){},onEditorBlur:function(){},onEditorFocus:function(){},onEditorChange:function(){},beforeEditorUpload:function(){this.quillUpdateImg=!0},editorUploadSuccess:function(t,e){var n=this.$refs.myQuillEditor.quill;if(0===t.code){var i=n.getSelection().index;n.insertEmbed(i,"image",t.data.filepath),n.setSelection(i+1)}else this.$message.error("图片插入失败");this.quillUpdateImg=!1},editorUploadError:function(){this.quillUpdateImg=!1,this.$message.error("图片插入失败")}}},g=d,m=(n("d02c"),n("2877")),f=Object(m["a"])(g,i,a,!1,null,null,null);e["default"]=f.exports}}]);