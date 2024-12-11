<template>
  <div class="profile-container">
    <!-- 上方导航栏 -->
    <div class="navbar">
      <el-menu :default-active="active" class="menu" mode="horizontal">
        <el-menu-item index="home" @click="goToHomePage">首页</el-menu-item>
        <el-menu-item index="aboutUs" @click="goToAboutUsPage">关于我们</el-menu-item>
        <el-menu-item index="projectIntro" @click="goToProjectIntroPage">项目介绍</el-menu-item>
        <el-menu-item index="profile" @click="goToProfilePage">个人</el-menu-item>
        
      </el-menu>
    </div>

    <!-- 个人信息展示区域 -->
    <div class="profile-box">
      <div class="profile-header">
        <img :src="avatar" alt="头像" class="avatar" />
        <h2>{{ username }}</h2>
        <p class="email">{{ email }}</p>
      </div>

      <div class="actions">
        <button @click="showInfo" class="action-btn">查看个人信息</button>
        <button @click="showEditForm" class="action-btn">编辑个人信息</button>
        <button @click="logout" class="action-btn logout-btn">退出登录</button>
      </div>

      <!-- 查看个人信息弹框 -->
      <div v-if="isInfoVisible" class="modal">
        <div class="modal-content">
          <h3>个人信息</h3>
          <p><strong>用户名：</strong>{{ username }}</p>
          <p><strong>密码：</strong>{{ password }}</p>
          <button @click="closeModal" class="close-btn">关闭</button>
        </div>
      </div>

      <!-- 编辑个人信息弹框 -->
      <div v-if="isEditVisible" class="modal">
        <div class="modal-content">
          <h3>验证密码</h3>
          <input v-model="inputPassword" type="password" placeholder="请输入密码" class="input-field" />
          <button @click="verifyPassword" class="action-btn">验证</button>
          <button @click="closeModal" class="close-btn">关闭</button>
        </div>
      </div>

      <!-- 修改个人信息弹框 -->
      <div v-if="isEditFormVisible" class="modal">
        <div class="modal-content">
          <h3>编辑个人信息</h3>
          <input v-model="username" type="text" placeholder="修改用户名" class="input-field" />
          <input v-model="password" type="password" placeholder="修改密码" class="input-field" />
          <input v-model="email" type="email" placeholder="修改邮箱" class="input-field" />
          <button @click="saveChanges" class="action-btn">保存</button>
          <button @click="closeModal" class="close-btn">关闭</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: sessionStorage.getItem("Username") || "",
      password: sessionStorage.getItem("Password") || "",
      avatar: sessionStorage.getItem("Avatar") || "../assets/images/1.png",
      isInfoVisible: false,
      isEditVisible: false,
      isEditFormVisible: false,
      inputPassword: "",
    };
  },
  methods: {
    goToHomePage() {
      this.$router.push('/');  // 跳转到首页
    },
    goToAboutUsPage() {
      this.$router.push('/aboutUs');  // 跳转到关于我们页面
    },
    goToProjectIntroPage() {
      this.$router.push('/projectIntro');  // 跳转到项目介绍页面
    },
    goToProfilePage() {
      const username = sessionStorage.getItem("Username");
      if (!username) {
        this.$confirm("您尚未登录，是否跳转到登录页面？", "提示", {
          confirmButtonText: "确认",
          cancelButtonText: "取消",
          type: "warning",
        })
          .then(() => {
            this.$router.push("/login"); // 跳转到登录页面
          })
          .catch(() => {
            this.$message.info("已取消操作");
          });
      } else {
        this.$router.push("/profile"); // 跳转到个人页面
      }
    },
    showInfo() {
      this.isInfoVisible = true;
    },
    showEditForm() {
      this.isEditVisible = true;
    },
    closeModal() {
      this.isInfoVisible = false;
      this.isEditVisible = false;
      this.isEditFormVisible = false;
      this.inputPassword = "";
    },
    verifyPassword() {
      if (this.inputPassword === this.password) {
        this.isEditVisible = false;
        this.isEditFormVisible = true;
      } else {
        this.$message.error("密码错误，请重试！");
      }
    },
    saveChanges() {
      sessionStorage.setItem("Username", this.username);
      sessionStorage.setItem("Password", this.password);
      sessionStorage.setItem("Email", this.email);
      this.$message.success("信息已更新！");
      this.closeModal();
    },
    logout() {
      sessionStorage.clear();

      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    },
  },
};
</script>

<style scoped>
/* 页面布局 */
.profile-container {
  padding: 20px;
  background-color: #f4f7fc;
}

/* 导航栏样式 */
.navbar {
  margin-bottom: 20px;
}

.menu {
  background-color: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

/* 个人信息展示区域 */
.profile-box {
  max-width: 800px;
  margin: 0 auto;
  background-color: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-header {
  text-align: center;
  margin-bottom: 20px;
}

.avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  margin-bottom: 10px;
}

.profile-header h2 {
  font-size: 24px;
  margin: 0;
}

.email {
  font-size: 16px;
  color: #777;
}

/* 按钮样式 */
.actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.action-btn {
  padding: 10px 20px;
  font-size: 16px;
  color: #ffffff;
  background-color: #409EFF;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.action-btn:hover {
  background-color: #66b3ff;
}

.logout-btn {
  background-color: #f56c6c;
}

.logout-btn:hover {
  background-color: #f78989;
}

/* 弹框样式 */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 30px;
  border-radius: 10px;
  width: 400px;
  max-width: 80%;
}

.modal h3 {
  margin-bottom: 20px;
}

.input-field {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.input-field:focus {
  border-color: #409EFF;
}

.close-btn {
  background-color: #ccc;
  padding: 8px 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

.close-btn:hover {
  background-color: #999;
}
</style>