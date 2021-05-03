<template>
  <div class="app-container calendar-list-container">
    <div class="filter-container">
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        @click="doAdd()"
        type="primary"
        icon="edit"
      >添加</el-button>
    </div>

    <el-table
      key="tableList"
      :data="list"
      v-loading="listLoading"
      element-loading-text="给我一点时间"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column align="center" label="序号" width="65">
        <template slot-scope="scope">
          <span>{{scope.row.id}}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="图片" width="250">
        <template slot-scope="scope">
          <img :src="scope.row.thumbnail" style="width:200px" />
        </template>
      </el-table-column>

      <el-table-column align="center" label="排序">
        <template slot-scope="scope">
          <span>{{scope.row.order}}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="跳转类型">
        <template slot-scope="scope">
          <span>{{scope.row.redirect_type == 0 ? '不跳转' : (scope.row.redirect_type == 1 ? '跳转小程序' : '跳转网页')}}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="跳转地址">
        <template slot-scope="scope">
          <span>{{scope.row.path}}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="是否展示">
        <template slot-scope="scope">
          <span>{{scope.row.is_show == 1 ? '是' : '否'}}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="操作">
        <template slot-scope="scope">
          <el-button size="small" type="primary" @click="updateAction(scope.row)">编辑</el-button>
          <el-button size="small" type="danger" @click="deleteBanner(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="dialogTitle" :visible.sync="dialogFormVisible">
      <el-form
        class="small-space"
        :model="temp"
        label-position="left"
        label-width="100px"
        style="width: 500px; margin-left:50px;"
      >
        <el-form-item label="banner">
          <el-upload
            class="avatar-uploader"
            :action="uploadPath"
            :headers="header"
            :show-file-list="false"
            :on-success="handleImageSuccess"
          >
            <img v-if="temp.thumbnail" :src="temp.thumbnail" class="avatar" style="max-width: 100%" />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <el-form-item label="描述">
          <el-input v-model="temp.desc"></el-input>
        </el-form-item>
        <el-form-item label="跳转类型">
          <el-radio-group v-model="temp.redirect_type">
            <el-radio :label="0">不跳转</el-radio>
            <el-radio :label="1">小程序页面</el-radio>
            <el-radio :label="2">网页</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="链接路径" v-show="temp.redirect_type">
          <el-input v-model="temp.path"></el-input>
        </el-form-item>
        <el-form-item label="排序">
          <el-input v-model="temp.order"></el-input>
        </el-form-item>
        <el-form-item label="是否展示" prop="is_show">
          <el-switch v-model="temp.is_show"  :active-value="1" :inactive-value="0">是</el-switch>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="createBanner">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import {
  BannerList,
  addBanner,
  updateBanner,
  deleteBanner,
  showBanner
} from "@/api/banner";
import { getToken, getGrade } from '@/utils/auth';
import { uploadPath } from "@/utils/common";

export default {
  name: "Banner",
  data() {
    return {
      list: null,
      imageUrl: "",
      dialogFormVisible: false,
      uploadPath: uploadPath,
      temp: {
        thumbnail: "",
        desc: "",
        path: "",
        order: 0,
        redirect_type: 0,
        is_show: 1
      },
      dialogTitle: "添加banner",
      header: {
        Authorization: getToken()
      }
    };
  },
  created() {
    this.getList();
  },
  methods: {
    doAdd() {
      this.dialogTitle = "添加banner";
      this.temp = {
        thumbnail: "",
        desc: "",
        path: "",
        order: 0,
        redirect_type: 0,
        is_show: 1,
        area_id: ""
      };
      this.dialogFormVisible = true;
    },
    getList() {
      this.listLoading = true;
      BannerList().then(response => {
        this.list = response.data;
      });
      this.listLoading = false;
    },
    handleImageSuccess(res) {
      if (res.code == 0) {
        this.temp.thumbnail = res.data.filepath;
        this.$forceUpdate();
        this.$message.success("上传成功！");
      } else {
        this.$message.error("上传失败");
      }
    },
    createBanner() {
      if (this.dialogTitle == "添加banner") {
        addBanner(this.temp).then(res => {
          if (res.code == 0) {
            this.$message.success("添加成功！");
            this.getList();
            this.temp = {
              thumbnail: "",
              desc: "",
              path: "",
              order: 0,
              redirect_type: 0,
              is_show: 1
            };
            this.dialogFormVisible = !this.dialogFormVisible;
          } else {
            this.$message.error(res.msg);
          }
        });
      } else {
        updateBanner(this.temp).then(res => {
          if (res.code == 0) {
            this.$message.success("编辑成功！");
            this.getList();
            this.temp = {
              thumbnail: "",
              full_pic: "",
              desc: "",
              goods_id: "",
              type: 0,
              order: 0,
              height: 0,
            };
            this.dialogFormVisible = !this.dialogFormVisible;
          } else {
            this.$message.error(res.msg);
          }
          this.dialogTitle = "添加banner";
        });
      }
    },
    handleShow(id) {
      showBanner({ id: id }).then(res => {
        if (res.data.code == 0) {
          this.$message.success(res.data.msg);
          this.getList();
        } else {
          this.$message.error(res.data.msg);
        }
      });
    },
    deleteBanner(id) {
      deleteBanner({ id: id }).then(res => {
        if (res.code == 0) {
          this.$message.success("删除成功！");
          this.getList();
        } else {
          this.$message.error(res.msg);
        }
      });
    },
    updateAction(row) {
      this.temp = row;
      this.dialogTitle = "编辑banner";
      this.dialogFormVisible = !this.dialogFormVisible;
    }
  }
};
</script>

<style>
.overflow-on .cell {
  overflow: visible;
  overflow-x: visible;
  overflow-y: visible;
}
.el-badge[type="primary"] .el-badge__content {
  background-color: #409eff;
}
.el-badge[type="success"] .el-badge__content {
  background-color: #67c23a;
}
.el-badge[type="warning"] .el-badge__content {
  background-color: #e6a23c;
}
.el-badge[type="danger"] .el-badge__content {
  background-color: #f56c6c;
}
.el-badge[type="info"] .el-badge__content {
  background-color: #909399;
}
.cell-img .cell {
  line-height: 0;
}
</style>
