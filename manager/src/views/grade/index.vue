<template>
  <div class="app-container">
    <div class="filter-container">
        <el-input
          v-model="listQuery.name"
          style="width: 100px;"
          placeholder="姓名"
        />

        <el-select v-model="listQuery.select" placeholder="选科">
            <el-option
                v-for="item in select_list"
                :key="item"
                :label="item"
                :value="item">
                </el-option>
        </el-select>
        <el-button class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">查询</el-button>
        <el-button class="filter-item" type="danger" @click="clean">清空数据</el-button>
        <el-button
        type="primary"
        @click="download"
        >
        导出排名
        </el-button>
        <el-button
        type="success"
        @click="avgDownload"
        >
        导出班级平均分
        </el-button>
        <el-select v-model="listQuery.class" placeholder="班级">
            <el-option
                v-for="item in class_list"
                :key="item"
                :label="item"
                :value="item">
                </el-option>
        </el-select>
        <el-button
        type="primary"
        @click="classDownload"
        >
        导出班级排名
        </el-button>
      </div>

      <el-table
        key="id"
        v-loading="listLoading"
        :data="list"
        element-loading-text="给我一点时间"
        border
        fit
        highlight-current-row
      >
        <el-table-column 
            v-for="(item, index) in columns" 
            :key="index" 
            :prop="index"
            :sortable="sortArr.indexOf(index) > -1"
            :label="item">
        </el-table-column>
      </el-table>
  </div>
</template>
<script>
import {
  getList,
  cleanData
} from "@/api/grade";
import { getToken } from "@/utils/auth";
import { uploadPath } from "@/utils/common";

export default {
  name: "gradeIndex",
  data() {
    return {
      btn: false,
      list: null,
      imageUrl: "",
      pagination: {},
      dialogFormVisible: false,
      listQuery: {
        page: 1,
        limit: 20,
        select: "",
        name: "",
        class: "",
      },
      class_list: [],
      select_list: [],
      pagination: "",
      dialogTitle:'添加',
      columns: [],
      sortArr: [],
    }
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      this.listLoading = true;
      getList(this.listQuery).then(response => {
        var data = response.data;
        this.sortArr = data.sortArr;
        this.list = data.list;
        this.columns = data.columns;
        this.select_list = data.select_list;
        this.class_list = data.class_list;
      });
      this.listLoading = false;
    },
    clean() {
        this.$confirm('确认删除?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
        }).then(() => {
            cleanData().then(res => {
                var that = this
                that.getList();
                this.$message.success(res.msg);
            })
        });
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },

    handleSizeChange(val) {
      this.listQuery.limit = val;
      this.getList();
    },

    handleCurrentChange(val) {
      this.listQuery.page = val;
      this.getList();
    },

    resetForm() {
      this.listQuery.title = "";
      this.listQuery.type = "";
    },
    classDownload() {
      window.open(process.env.VUE_APP_BASE_API+'/grade/classDownload?class='+this.listQuery.class+'&api_token=' + getToken())
    },
    avgDownload() {
      window.open(process.env.VUE_APP_BASE_API+'/grade/avgDownload?api_token=' + getToken())
    },
    download() {
      var query = this.listQuery;
      var isArray =  function(obj) {
      return Object.prototype.toString.call(obj) === '[object Array]';
    };
      var url = Object.keys(this.listQuery).map(function (key){
        if (isArray(query[key])) {
          var iUrl = '';
          query[key].forEach((item)=>{
              iUrl = iUrl+ key + '[]=' + item + '&';
          });
          return iUrl.trim('&');
        } else {
          return encodeURIComponent(key) + "=" + encodeURIComponent(query[key]);
        }
      }).join("&");
      window.open(process.env.VUE_APP_BASE_API+'/grade/download?'+url+'&api_token=' + getToken())
    },
  }
};
</script>

<style>
    .overflow-on .cell {
        overflow: visible;
        overflow-x: visible;
        overflow-y: visible;
    }
    .table-container {
      margin:20px 0;
    }
    .ql-editor{
        height:360px;
    }
</style>
