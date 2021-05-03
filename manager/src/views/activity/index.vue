<template>
  <div class="app-container calendar-list-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.title"
        style="width: 150px;"
        class="filter-item"
        placeholder="活动名称"
      />
      <el-button
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >
        查询
      </el-button>
    </div>
    <div>
    <el-table
      key="tableList"
      v-loading="listLoading"
      :data="list"
      element-loading-text="给我一点时间"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column
        align="center"
        label="id"
        width="65"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="活动名称"
        class-name="overflow-on"
      >
        <template slot-scope="scope">
          {{ scope.row.title }}
        </template>
      </el-table-column>

      <el-table-column align="center" label="学校名称">
        <template slot-scope="scope">
          <span>{{ scope.row.college ? scope.row.college.name:'' }}</span>
        </template>
      </el-table-column>

      <!-- <el-table-column
        align="center"
        label="活动图片"
      >
        <template slot-scope="scope">
          <img :src="scope.row.image" style="width:200px" />
        </template>
      </el-table-column> -->

      <el-table-column
        align="center"
        label="地点"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.address }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="人数"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.limitation }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="活动时间"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.start_time }}</span><br>至
          <span>{{ scope.row.end_time }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="序号"
        width="50"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.sort }}</span>
        </template>
      </el-table-column>

       <el-table-column
        align="center"
        label="状态"
      >
        <template slot-scope="scope">
          <span v-if="scope.row.status == -1">已结束</span>
          <span v-if="scope.row.status == 0">未开始</span>
          <span v-if="scope.row.status == 1">进行中</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="操作"
      >
        <template slot-scope="scope"> 
          <el-button
            size="small"
            type="primary"
            @click="updateAction(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            size="small"
            type="primary"
            @click="open(scope.row.id)"
          >
            排序
          </el-button>
          <el-button
            size="small"
            type="danger"
            @click="deleteAction(scope.row.id)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    </div>

    <!-- 分页 -->
    <div class="pagination-container text-right">
      <el-pagination
        background
        :total="pagination.total"
        :current-page="listQuery.page"
        :page-sizes="[20]"
        :page-size="listQuery.limit"
        layout="total, sizes, prev, pager, next"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
      />
    </div>

    <el-dialog
      :title="dialogTitle"
      :visible.sync="dialogFormVisible"
    >
      <el-form
        ref="temp"
        class="small-space"
        :model="temp"
        :need_amounts="formneed_amounts"
        label-position="right"
        label-width="150px"
        style="width: 800px; margin-left:20px;"
      >
        <el-form-item
          label="活动名称"
          prop="title"
          required
        >
          <el-input v-model="temp.title" />
        </el-form-item>
        
        <el-form-item label="活动类型" required>
          <el-select 
            v-model="temp.type"
          >
            <el-option
              v-for="(item, index) in typeList"
              :key="index"
              :label="item"
              :value="index" 
            />
          </el-select>
        </el-form-item>
        <el-form-item
          label="活动简介"
          prop="desc"
          required
        >
          <el-input
            v-model="temp.desc"
            type="textarea"
          />
        </el-form-item>
        
        <el-form-item
          label="活动地点"
          prop="address"
          required
        >
          <el-input
            v-model="temp.address"
          />
        </el-form-item>
        <el-form-item
          label="活动人数"
          required
        >
          <el-input
            v-model="temp.limitation"
            placeholder="请输入"
          />
        </el-form-item>
        <el-form-item
          label="开始时间"
          prop="start_time"
          required
        >
          <el-date-picker
            v-model="temp.start_time"
            class="filter-item"
            type="datetime"
          />
        </el-form-item>
        <el-form-item
          label="结束时间"
          prop="end_time"
          required
        >
          <el-date-picker
            v-model="temp.end_time"
            class="filter-item"
            type="datetime"
          />
        </el-form-item>

        <!-- <el-form-item label="活动图片">
          <el-upload
            class="avatar-uploader"
            :action="uploadPath"
            :headers="header"
            :show-file-list="false"
            :on-success="handleImageSuccess"
          >
            <img v-if="temp.image" :src="temp.image" class="avatar" style="max-width: 300px" />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item> -->
      </el-form>
      <div
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="dialogFormVisible = false">
          取 消
        </el-button>
        <el-button
          type="primary"
          @click="createCoupon('temp')"
        >
          确 定
        </el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import {
  getList,
  edit,
  sort,
  del
} from "@/api/activity";
import { getToken } from "@/utils/auth";
import { uploadPath } from "@/utils/common";

export default {
  name: "activity",
  data() {
    return {
      list: null,
      imageUrl: "",
      typeList: [],
      pagination: "",
      listQuery: {
        page: 1,
        limit: 20,
        status: 0,
        id:'',
        name: '',
        date:""
      },
      uploadPath: uploadPath,
      typeList: [],
      dialogFormVisible: false,
      temp: {
          image: '',
          title: '',
          type: 1,
          limitation: '',
          start_time: 0,
          end_time: 0,
          hotel_id: [],
          is_manaul: 1,
          is_week: 1,
          address: '',
      },
      dialogTitle:'编辑',
      header: {
        Authorization: getToken()
      },
      formneed_amounts: {
        title: [
            { required: true, message: '请输入名称', trigger: 'blur' },
            {  max: 30, message: '长度在30 个字符以内', trigger: 'blur' }
        ],
        start_time: [
            { type: 'date', required: true, message: '请选择开始时间', trigger: 'change' }
        ],
        end_time: [
            { type: 'date', required: true, message: '请选择结束时间', trigger: 'change' }
        ],
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    resetForm() {
      this.listQuery.id = '';
      this.listQuery.name = '';
      this.listQuery.status = '';
    },
    handleSizeChange(val) {
      this.listQuery.limit = val;
      this.getList();
    },
    handleCurrentChange(val) {
      this.listQuery.page = val;
      this.getList();
    },
    getList() {
      this.listLoading = true;
      getList(this.listQuery).then(res => {
        var data = res.data.list;
        this.list = data.data;
        this.pagination = data;
        this.listQuery.page = data.current_page;
        this.typeList = res.data.typeList;
      });
      
      this.listLoading = false;
    },
    createCoupon(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          if (this.dialogTitle == '添加优惠券') {
              this.doAddCoupon();
          }else {
              edit(this.temp.id, this.temp).then(res => {
                  if (res.code == 0) {
                      this.$message.success("编辑成功！");
                      this.getList();
                      this.dialogFormVisible = !this.dialogFormVisible;
                  } else {
                      this.$message.error(res.data.msg);
                  }
              });
          }
        } else {
          this.$notify.error({
              title: '错误',
              message: '请检查输入是否正确',
              offset: 100
          });
          return false;
        }
      });
    },
    open(id) {
      this.$prompt('请输入数字', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
      }).then(({ value }) => {
        console.log(value)
        sort(id, {"sort": value}).then(res => {
          if (res.code == 0) {
            this.$message.success(res.data.msg);
            this.getList();
          } else {
            this.$message.error(res.data.msg);
          }
        });
      }).catch(() => {
           
      });
    },
    handleImageSuccess(res) {
      if (res.code == 0) {
        this.temp.image = res.data.filepath;
        this.$message.success("上传成功！");
      } else {
        this.$message.error("上传失败");
      }
    },
    deleteAction(id) {
      this.$confirm('此操作将删除该活动，不在小程序端展示, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        del(id).then(res => {
          if (res.code == 0) {
            this.$message.success(res.data.msg);
            this.getList();
          } else {
            this.$message.error(res.data.msg);
          }
        });
      }).catch(() => {
            
      });
    },
    updateAction(row) {
      this.temp = row;
      this.dialogFormVisible = !this.dialogFormVisible;
   }
  }
};
</script>