<template>
  <div class="admin">
    <div class="login-container">
      <h2>管理员验证</h2>
      <el-form :model="form" ref="formRef" label-width="80px">
        <el-form-item label="用户名" :rules="[{ required: true, message: '请输入用户名', trigger: 'blur' }]">
          <el-input v-model="form.username" placeholder="请输入用户名"></el-input>
        </el-form-item>
        <el-form-item label="密码" :rules="[{ required: true, message: '请输入密码', trigger: 'blur' }]">
          <el-input
            v-model="form.password"
            type="password"
            placeholder="请输入密码"
          ></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="register">登录</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      form: {
        username: '',
        password: '',
      },
    };
  },
  methods: {
    register() {
      // 获取用户名和密码
      const { username, password } = this.form;

      // 向后端发送请求
      axios
        .post(`http://localhost:8080/api/adminlogin?username=${username}&password=${password}`)
        .then((response) => {
          const status = response.data.status;
          if (status === 1) {
            this.$message.success('验证成功');
            setTimeout(() => {
              window.location.href = 'http://localhost:8080/site/index';
            }, 1000);
          } else if (status === 0) {
            // 验证失败
            this.$message.error('验证失败');
          }
        })
        .catch((error) => {
          console.error('发送请求失败:', error);
          this.$message.error('发送请求失败');
        });
    },
  },
};
</script>

<style scoped>
.admin {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: aliceblue;
  width: 100vw;
  height: 100vh;
}

.login-container {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 300px;
  text-align: center;
}

.el-form-item {
  margin-bottom: 20px;
}

.el-button {
  width: 100%;
}
</style>
