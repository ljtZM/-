<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'App',
  mounted() {
    // 检查 sessionStorage 是否已经发送过浏览量请求
    if (!sessionStorage.getItem('webviewSent')) {
      this.AddWebView();
      sessionStorage.setItem('webviewSent', 'true'); // 标记浏览量已增加
    } else {
      console.log("浏览量已增加，跳过");
    }
  },
  methods: {
    AddWebView() {
      axios
        .post('http://localhost:8080/api/addwebviews')
        .catch((error) => {
          console.error('浏览量增加失败', error);
        });
    },
  },
};
</script>
