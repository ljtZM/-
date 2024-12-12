<template>
  <div class="profile-container">
    <!-- 上方导航栏 -->
    <!-- 上方导航栏 -->
    <div class="navbar">
      <div class="logo">
        <span class="logo-text">个人主页</span>
        <span class="separator"></span>  <!-- 分隔符 -->
      </div>
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
  background-color: #f4f7fc;
  min-height: 100vh; /* 确保容器至少占满整个视口高度 */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

/* 上方导航栏样式 */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 10px 20px;
  background: linear-gradient(135deg, #3b5998, #8b9dc3);
}

.logo {
  display: flex;
  align-items: center;
  margin-left: 100px; /* 调整左右间距 */
  margin-right: 400px; /* 调整左右间距 */
}

.logo-text {
  font-size: 36px; /* 放大2024 */
  font-weight: bold;
  margin-right: 10px;
  color: #ff9900;
  font-family: 'Special Elite', cursive; /* 使用特别字体 */
}

.election-text {
  font-size: 34px; 
  color: white; /* 字体颜色 */
  font-family: 'Special Elite', cursive; /* 使用特别字体 */
  font-weight: bold; /* 加粗字体 */
}

/* 英文副标题样式 */
.subtitle {
  font-size: 24px;  /* 英文副标题较小 */
  color: rgba(255, 255, 255, 0.7);  /* 字体颜色为白色并带有透明度，0.7为微透明 */
  margin-left: 5px; /* 左侧间距 */
  font-family: 'Arial', sans-serif; /* 英文字体 */
  font-weight: lighter;  /* 字体更轻 */
  font-style: italic; /* 斜体 */
}

.menu {
  display: flex;
  flex-grow: 1;
  justify-content: center;
  margin-right: 5px; /* 调整右侧间距 */
}

/* 定义全局样式，确保菜单和菜单项背景透明 */
html body .el-menu {
  background-color: transparent !important;  /* 设置菜单背景透明 */
  border: none !important;  /* 去掉边框 */
  font-size: 26px;  /* 设置菜单的字体大小 */
}

/* 对菜单项进行处理，去掉白色背景 */
html body .el-menu .el-menu-item {
  background-color: transparent !important;  /* 设置菜单项背景透明 */
  color: white !important;  /* 设置字体颜色为白色 */
  font-size: 26px;  /* 设置菜单项的字体大小 */
  transition: background-color 0.3s ease, color 0.3s ease; /* 平滑的背景色和字体色变化 */
}

/* 悬停时和选中时背景透明 */
html body .el-menu .el-menu-item:hover,
html body .el-menu .el-menu-item.is-active {
  background-color: transparent !important;  /* 悬停和选中时背景透明 */
  color: #ff9900 !important;  /* 设置字体颜色为橙色 */
}

/* 个人信息展示区域 */
.profile-box {
  max-width: 600px;
  max-height: 450px;
  margin-top: 80px;
  background-color: #f9fafb;
  padding: 30px;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  width: 100%; /* 确保宽度占满父容器 */
  flex: 1; /* 让 profile-box 占据剩余空间 */
}

.profile-header {
  text-align: center;
  margin-bottom: 30px;
}

.avatar {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
}

.profile-header h2 {
  font-size: 28px;
  margin: 0;
  color: #333;
}

.email {
  font-size: 18px;
  color: #777;
}

/* 按钮样式 */
.actions {
  display: flex;
  flex-direction: column; /* 将按钮竖直排列 */
  align-items: center;
  gap: 15px; /* 增加按钮之间的间距 */
  margin-top: 30px;
}

.action-btn {
  padding: 12px 24px;
  font-size: 18px;
  color: #fff;
  background-color: #409eff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 100%; /* 确保按钮宽度一致 */
  max-width: 300px; /* 最大宽度限制 */
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
  background-color: #fff;
  padding: 40px;
  border-radius: 12px;
  width: 450px;
  max-width: 80%;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.modal h3 {
  margin-bottom: 25px;
  font-size: 24px;
  color: #333;
}

.input-field {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.input-field:focus {
  border-color: #409eff;
  outline: none;
}

.close-btn {
  background-color: #ccc;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.close-btn:hover {
  background-color: #999;
}




</style>