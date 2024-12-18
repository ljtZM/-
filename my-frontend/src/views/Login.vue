<template>
  <div class="form-box">
    <div class="back1-button-container">
      <button @click="goBack1" class="back-button">我是游客</button>
    </div>

    <div class="back2-button-container">
      <button @click="goBack2" class="back-button">我是管理员</button>
    </div>
    <!-- 切换按钮 -->
    <div class="toggle-buttons">
      <button 
        :class="['toggle-btn', isLogin ? 'active' : '']" 
        @click="isLogin = true"
      >
        登录
      </button>
      <button 
        :class="['toggle-btn', !isLogin ? 'active' : '']" 
        @click="isLogin = false"
      >
        注册
      </button>
    </div>

    <!-- 使用 transition 组件包裹表单 -->
    <transition name="fade" mode="out-in">
      <!-- 登录表单 -->
      <form v-if="isLogin" @submit.prevent="handleLogin" class="form" key="login">
        <div class="form-group">
          <input 
            type="text" 
            v-model="loginForm.username" 
            placeholder="用户名"
            required
          >
        </div>
        <div class="form-group">
          <input 
            type="password" 
            v-model="loginForm.password" 
            placeholder="密码"
            required
          >
        </div>
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? '登录中...' : '登录' }}
        </button>
      </form>

      <!-- 注册表单 -->
      <form v-else @submit.prevent="handleRegister" class="form" key="register">
        <div class="form-group">
          <input 
            type="text" 
            v-model="registerForm.username" 
            placeholder="用户名"
            required
          >
        </div>
        <div class="form-group">
          <input 
            type="email" 
            v-model="registerForm.email" 
            placeholder="邮箱"
            required
          >
        </div>
        <div class="form-group">
          <input 
            type="password" 
            v-model="registerForm.password" 
            placeholder="密码"
            required
          >
        </div>
        <div class="form-group">
          <input 
            type="password" 
            v-model="registerForm.confirmPassword" 
            placeholder="确认密码"
            required
          >
        </div>
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? '注册中...' : '注册' }}
        </button>
      </form>
    </transition>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'LoginView',
  data() {
    return {
      isLogin: true,
      loginForm: {
        username: '',
        password: ''
      },
      registerForm: {
        username: '',
        email: '',
        password: '',
        confirmPassword: ''
      },
      loading: false
    }
  },
  created() {
    const Username = sessionStorage.getItem('Username')
    const Password = sessionStorage.getItem('Password')
    if (Username && Password) {
      window.location.href = '/home'
    }
  },
  methods: {
    // 返回按钮点击事件
    goBack1() {
        this.$router.push({ name: 'Home' });
      },
      // 返回按钮点击事件
     goBack2() {
        this.$router.push({ name: 'admin' });
      },
    async handleLogin() {
      try {
        this.loading = true

        const username = this.loginForm.username
        const password = this.loginForm.password

        const response = await axios.post('http://localhost:8080/api/login?username=' + username + '&password=' + password)

        if (response.data.status === 1) {
          sessionStorage.setItem('Username', username)
          sessionStorage.setItem('Password', password)
          this.$message.success(response.data.message||'登录成功')
          // 清空表单
          this.loginForm = {
            username: '',
            password: ''
          }

          // 导航到 /home 路径
          setTimeout(() => {
            window.location.href = '/home'
          }, 2000)
        } else {
          this.$message.error(response.data.message || '登录失败')
        }
      } catch (error) {
        console.error('登录出错：', error)
        this.$message.error('登录失败，请稍后重试')
      } finally {
        this.loading = false
      }
    },

    async handleRegister() {
      if (this.registerForm.password !== this.registerForm.confirmPassword) {
        this.$message.error('两次输入的密码不一致！')
        return
      }

      try {
        this.loading = true

        const username = this.registerForm.username
        const email = this.registerForm.email
        const password = this.registerForm.password

        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,}$/

        if (!passwordPattern.test(this.registerForm.password)) {
          this.$message.error('密码至少为8位，且包含大小写字母、数字和特殊字符')
          return
        }


        const response = await axios.post('http://localhost:8080/api/register?username=' + username + '&password=' + password + '&email=' + email )

        if (response.data.status === 1) {
          this.$message.success(response.data.message||'注册成功！')
          sessionStorage.setItem('Username', username)
          sessionStorage.setItem('Password', password)
          sessionStorage.setItem("Email", email)
          this.isLogin = true
          this.loginForm.username = this.registerForm.username
          this.loginForm.password = this.registerForm.password
          // 清空注册表单
          this.registerForm = {
            username: '',
            email: '',
            password: '',
            confirmPassword: ''
          }
          
        } else if (response.data.status === 0){
          this.$message.error(response.data.message || '注册失败')
        }
      } catch (error) {
        console.error('注册出错：', error)
        this.$message.error('注册失败，请稍后重试')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>

.form-box {
  background: #ffffff;
  padding: 30px;
  width: 90%;
  max-width: 400px;
  margin: 50px auto;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* 增加阴影 */
  border: none;
  transition: all 0.3s ease;
}

.toggle-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  gap: 10px;
}

.toggle-btn {
  flex: 1;
  padding: 10px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 18px;
  color: #666;
  font-weight: 500;
  position: relative;
  transition: color 0.3s ease;
}

.toggle-btn.active {
  color: #1890ff;
  border-bottom: 2px solid #1890ff;
  font-weight: bold;
}

.form-group {
  margin-bottom: 20px;
  width: 90%;
  margin-left: auto;
  margin-right: auto;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  border-radius: 8px;
  font-size: 16px;
  margin-bottom: 15px;
  transition: all 0.3s ease;
}

input:focus {
  outline: none;
  border-color: #1890ff;
  box-shadow: 0 4px 12px rgba(24, 144, 255, 0.2);
  transform: translateY(-2px); /* 输入框上浮 */
}

/* 登录/注册按钮样式 */
.submit-btn {
  width: 100%;
  padding: 14px;
  background-color: #1890ff;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: all 0.3s ease;
  margin-top: 10px;
}

.submit-btn:hover {
  background-color: #40a9ff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(24, 144, 255, 0.3);
}

.submit-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.form {
  max-width: 500px;
  margin: 0 auto;
  padding: 40px;
  border: 2px solid #ffffff;
  /* border-radius: 8px; */
  background: #ffffff;
  /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); */
}

/* 淡入淡出效果 */
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
  transform: translateY(0);
}

/* 切换按钮动画 */
.toggle-btn {
  transition: all 0.3s ease;
  position: relative;
}

.toggle-btn::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background-color: #1890ff;
  transition: all 0.3s ease;
}

.toggle-btn.active::after {
  width: 100%;
  left: 0;
}

/* 输入框动画 */
.form-group {
  transition: all 0.3s ease;
}

input {
  transition: all 0.3s ease;
}

input:focus {
  transform: translateY(-2px);
  box-shadow: 0 2px 8px rgba(24, 144, 255, 0.1);
}


input:valid {
  border-color: #52c41a;
}

input:focus::placeholder {
  color: transparent;
}

/* 按钮动画 */
.submit-btn {
  transition: all 0.3s ease;
}

.submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(24, 144, 255, 0.3);
}

/* 表单容器动画 */
.form {
  transition: all 0.3s ease;
}

/* 添加禁用状态样式 */
.submit-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

/* 返回按钮样式 */
.back1-button-container {
  position: absolute;
  top: 20px;
  left: 20px;
}

.back2-button-container {
  position: absolute;
  top: 80px;
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
