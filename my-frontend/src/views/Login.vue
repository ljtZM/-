<template>
  <div>
    <h1>用户注册</h1>
    <form @submit.prevent="handleRegister">
      <div>
        <label for="username">用户名:</label>
        <input v-model="username" id="username" type="text" required />
      </div>
      <div>
        <label for="email">邮箱:</label>
        <input v-model="email" id="email" type="email" required />
      </div>
      <div>
        <label for="password">密码:</label>
        <input v-model="password" id="password" type="password" required />
      </div>
      <button type="submit">注册</button>
    </form>

    <h1>用户登录</h1>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="loginUsername">用户名:</label>
        <input v-model="loginUsername" id="loginUsername" type="text" required />
      </div>
      <div>
        <label for="loginPassword">密码:</label>
        <input v-model="loginPassword" id="loginPassword" type="password" required />
      </div>
      <button type="submit">登录</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

/*
handleRegister：当用户提交注册表单时，调用 registerUser 方法，传入用户名、邮箱和密码，并显示相应的结果。
handleLogin：当用户提交登录表单时，调用 loginUser 方法，传入用户名和密码，并显示登录结果。
registerUser：
使用 axios.post 向后端发送注册请求 (/api/auth/register)，请求体中包含用户名、邮箱和密码。
如果返回的响应数据 status 为 "success"，则表示注册成功，否则返回失败信息。
如果请求出错，则捕获错误并返回 "注册失败"。
loginUser：
使用 axios.post 向后端发送登录请求 (/api/auth/login)，请求体中包含用户名和密码。
如果登录成功，后端会返回一个 auth_key，并将其保存在 localStorage 中（用于后续身份验证）。如果登录失败，则返回错误信息。
*/
export default {
  data() {
    return {
      username: "",
      email: "",
      password: "",
      loginUsername: "",
      loginPassword: ""
    };
  },
  methods: {
    async handleRegister() {
      const response = await this.registerUser(this.username, this.email, this.password);
      alert(response);
    },
    async handleLogin() {
      const response = await this.loginUser(this.loginUsername, this.loginPassword);
      alert(response);
    },
    async registerUser(username, email, password) {
      try {
        console.log("Sending register request with data:", { username, email, password });
        const response = await axios.post("http://localhost:8081/api/auth/register", {
          username,
          email,
          password
        });
        console.log("Register response:", response);
        if (response.data.status === "success") {
          return "注册成功";
        } else {
          console.log("Register failed, message:", response.data.message);
          return response.data.message;
        }
      } catch (error) {
        console.error("注册失败", error);
        return "注册失败";
      }
    },
    async loginUser(username, password) {
      try {
        const response = await axios.post("http://localhost:8081/api/auth/login", {
          username,
          password
        });
        if (response.data.status === "success") {
          localStorage.setItem("auth_key", response.data.auth_key);
          return "登录成功";
        } else {
          return "用户名或密码错误";
        }
      } catch (error) {
        console.error("登录失败", error);
        return "登录失败";
      }
    }
  }
};
</script>
