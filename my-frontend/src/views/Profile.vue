<template>
  <div class="profile-container">
    <div class="profile-box">
      <div class="profile-header">
        <img :src="avatar" alt="头像" class="avatar" />
        <h2 class="username">{{ username }}</h2>
      </div>
      <div class="profile-details">
        <div class="detail">
          <strong>密码：</strong><span>{{ password }}</span>
        </div>
      </div>
      <div class="actions">
        <button @click="logout" class="logout-btn">取消登录</button>
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
    };
  },
  methods: {
    logout() {
      sessionStorage.clear();
       // 导航到 /home 路径
       setTimeout(() => {
            window.location.href = '/login'
          }, 2000)
    },
  },
};
</script>
<style scoped>
.profile-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f4f7fc;
}

.profile-box {
  background: white;
  padding: 30px;
  width: 90%;
  max-width: 400px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.profile-header {
  margin-bottom: 20px;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
}

.username {
  font-size: 1.5em;
  color: #1890ff;
  margin: 10px 0;
}

.profile-details {
  margin-bottom: 20px;
  font-size: 1.2em;
  color: #555;
}

.detail {
  margin-bottom: 15px;
}

.actions {
  margin-top: 20px;
}

.logout-btn {
  padding: 10px 20px;
  background-color: #1890ff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1.2em;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.logout-btn:hover {
  background-color: #40a9ff;
}
</style>
