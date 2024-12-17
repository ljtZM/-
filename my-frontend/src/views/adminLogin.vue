<template>
  <div class="admin">
    <div class="back-button-container">
      <button @click="goBack" class="back-button">回到主页</button>
    </div>

    <div class="login-container animated fadeInDown">
      <h2>管理员验证</h2>
      <el-form :model="form" ref="formRef" label-width="80px">
        <el-form-item label="用户名" prop="username" class="form-item">
          <el-input
            v-model="form.username"
            placeholder="请输入用户名"
            class="input-field"
          ></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="password" class="form-item">
          <el-input
            v-model="form.password"
            type="password"
            placeholder="请输入密码"
            class="input-field"
          ></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="register" class="login-button animated pulse infinite">登录</el-button>
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
     // 返回按钮点击事件
     goBack() {
        this.$router.push({ name: 'Home' });
      },

    register() {
      const { username, password } = this.form;

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


@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

.admin {
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #3b5998, #8b9dc3);
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  animation: backgroundAnimation 8s ease-in-out infinite;
}

@keyframes backgroundAnimation {
  0% {
    background: linear-gradient(135deg, #3b5998, #8b9dc3);
  }
  50% {
    background: linear-gradient(135deg, #8b9dc3, #3b5998);
  }
  100% {
    background: linear-gradient(135deg, #3b5998, #8b9dc3);
  }
}

.login-container {
  background-color: rgba(255, 255, 255, 0.9);
  padding: 50px;
  border-radius: 16px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  width: 450px;
  max-width: 100%;
  text-align: center;
  transition: transform 0.3s ease-in-out;
}

.login-container:hover {
  transform: scale(1.05);
}

h2 {
  margin-bottom: 2rem;
  color: #3b5998;
  font-size: 2.4rem;
  font-family: 'Arial', sans-serif;
  font-weight: 600;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.el-form-item {
  margin-bottom: 28px;
}

.el-form-item .el-form-item__label {
  font-size: 1.4rem;  /* 设置标签字体大小 */
  font-weight: bold;  /* 设置标签字体加粗 */
  color: #3b5998;     /* 设置标签字体颜色 */
  text-align: left;   /* 设置标签左对齐 */
}

/* 使用::v-deep确保样式作用于组件内部 */
::deep .el-form-item .el-form-item__label {
  font-size: 1.4rem;  /* 设置标签字体大小 */
  font-weight: bold;  /* 设置标签字体加粗 */
  color: #3b5998;     /* 设置标签字体颜色 */
  text-align: left;   /* 设置标签左对齐 */
}

.input-field {
  font-size: 1.2rem;
  padding: 5px 5px;
  height: 50px;
  width: 100%;
  border-radius: 12px;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.input-field:focus {
  border-color: #3b5998;
  box-shadow: 0 0 8px rgba(59, 89, 152, 0.4);
}

.el-button {
  width: 100%;
  height: 55px;
  font-size: 1.2rem;
  font-weight: bold;
  border-radius: 12px;
  background-color: #3b5998;
  color: white;
  border: none;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s, transform 0.3s;
}

.el-button:hover {
  background-color: #2a447e;
  transform: translateY(-2px);
}

.el-button:active {
  background-color: #1d3557;
  transform: translateY(1px);
}

/* Add a glowing animation for the login button */
.el-button.animated.pulse {
  animation: pulseButton 2s infinite;
}

@keyframes pulseButton {
  0% {
    transform: scale(1);
    box-shadow: 0 0 12px rgba(59, 89, 152, 0.7), 0 0 25px rgba(59, 89, 152, 0.5);
  }
  50% {
    transform: scale(1.05);
    box-shadow: 0 0 18px rgba(59, 89, 152, 0.9), 0 0 35px rgba(59, 89, 152, 0.6);
  }
  100% {
    transform: scale(1);
    box-shadow: 0 0 12px rgba(59, 89, 152, 0.7), 0 0 25px rgba(59, 89, 152, 0.5);
  }
}

/* 返回按钮样式 */
.back-button-container {
  position: absolute;
  top: 20px;
  left: 20px;
}

.back-button {
  padding: 10px 20px;
  font-size: 18px;
  background: linear-gradient(145deg, #409EFF, #66b3ff); /* 渐变背景色 */
  color: white;
  border: none;
  border-radius: 25px;  /* 增加圆角 */
  cursor: pointer;
  transition: transform 0.2s ease, background-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  /* 阴影效果 */
}

.back-button:hover {
  background-color: #66b3ff;
  transform: scale(1.05);  /* 鼠标悬停时按钮放大 */
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);  /* 鼠标悬停时增加阴影 */
}

.back-button:focus {
  outline: none; /* 去除点击后的默认边框 */
  box-shadow: 0 0 0 4px rgba(64, 158, 255, 0.3);  /* 点击时显示聚焦效果 */
}
</style>
