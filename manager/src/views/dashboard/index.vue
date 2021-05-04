<template>
  <div class="dashboard-container">
    <!-- <div class="dashboard-text">欢迎登录管理后台</div> -->
    <el-upload
        class="avatar-uploader"
        :action="uploadPath"
        :headers="header"
        :on-success="handleImageSuccess"
        :show-file-list="false">
        <el-button type="primary">点击上传excel文件</el-button>
    </el-upload>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { uploadPath } from "@/utils/common";
import { getToken } from '@/utils/auth';

export default {
  name: 'Dashboard',
  computed: {
    ...mapGetters([
      'name'
    ])
  },
  data() {
    return {
      header: {
        Authorization: 'Bearer '+ getToken()
      },
      uploadPath: uploadPath,
    }
  },
  methods: {
    handleImageSuccess(res) {
      if (res.code == 0) {
        this.$message.success(res.msg);
        setTimeout(() =>{
            this.$router.push("/grade/index")
        }, 10000);
      } else {
        this.$message.error("上传失败");
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.dashboard {
  &-container {
    margin: 30px;
  }
  &-text {
    font-size: 30px;
    line-height: 46px;
  }
}
</style>
