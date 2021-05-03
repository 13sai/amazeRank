<template>
    <div class="app-container calendar-list-container">
        <div class="filter-container">
            <el-button class="filter-item" style="margin-left: 10px;" @click="handleCreate('create')" type="primary" icon="edit">添加</el-button>
        </div>

        <el-table key='tableKey' :data="adminList" v-loading="listLoading" element-loading-text="给我一点时间" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="序号" width="65">
                <template slot-scope="scope">
                    <span>{{scope.row.id}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="角色" width="200">
                <template slot-scope="scope">
                    <span>{{scope.row.role}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="账号" width="400">
                <template slot-scope="scope">
                    <span>{{scope.row.name}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="添加时间" >
                <template slot-scope="scope">
                    <span>{{scope.row.created_at}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" >
                <template slot-scope="scope">
                    <el-button size="small" type="success" @click="handleEdit(scope.row,'edit')">编辑 </el-button>
                    <el-button size="small" type="danger" @click="deleteAdmin(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>

        </el-table>

        <el-dialog title="管理员" :visible.sync="dialogFormVisible">
            <el-form class="small-space" :model="temp" label-position="left" label-width="70px" style='width: 400px; margin-left:50px;'>

                <el-form-item label="角色">
                    <el-radio-group v-model="temp.role">
                        <el-radio label="super">超级管理员</el-radio>
                        <el-radio label="admin">普通管理员</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="账号">
                    <el-input v-model="temp.name"></el-input>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input v-model="temp.password" v-if="dialogStatus=='create'"></el-input>
                    <el-input v-model="temp.password" v-else placeholder="不填写密码则不修改密码"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button v-if="dialogStatus=='create'" type="primary" @click="create">确 定</el-button>
                <el-button v-else type="primary" @click="update">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import { fetchAdminList, fetchAdmin, updateAdmin, deleteAdmin, addAdmin } from '@/api/manager'

export default {
    name: 'admin',
    data() {
        return {
            adminList: null,
            dialogFormVisible: false,
            temp: {

            },
            dialogStatus: null,
            ip: "",
            btn: "0",
        }
    },
    created() {
        this.getAdminList();
    },
    methods: {
        getAdminList() {
            this.listLoading = true
            fetchAdminList().then(response => {
                console.log(response)
                this.adminList = response.data
                this.listLoading = false
            })
        },
        
        handleEdit(row, status) {
            this.dialogFormVisible = true
            row.password = ''
            this.temp = row
            this.dialogStatus = status
        },
        handleCreate(status) {
            this.dialogStatus = status
            this.dialogFormVisible = true
            this.temp = {
                role: ''
            }
        },
        create() {
            addAdmin(this.temp).then(response => {
                console.log(response)
                if (response.code == 0) {
                    this.$message({
                        message: response.msg,
                        type: 'success'
                    })
                    this.dialogFormVisible = false
                    this.getAdminList()
                } else {
                    this.$message({
                        message: response.msg,
                        type: 'error'
                    })
                }
            })
        },
        update() {
            updateAdmin(this.temp).then(response => {
                console.log(response)
                if (response.code == 0) {
                    this.$message({
                        message: response.msg,
                        type: 'success'
                    })
                    this.dialogFormVisible = false
                    this.getAdminList()
                } else {
                    this.$message({
                        message: response.msg,
                        type: 'error'
                    })
                }
            })
        },
        deleteAdmin(id) {
            deleteAdmin({id:id}).then(response => {
                console.log(response)
                if (response.code == 0) {
                    this.$message({
                        message: response.msg,
                        type: 'success'
                    })
                    this.getAdminList()
                } else {
                    this.$message({
                        message: response.msg,
                        type: 'error'
                    })
                }
            })
        }

    }

}
</script>

