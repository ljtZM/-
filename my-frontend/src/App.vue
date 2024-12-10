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
    this.AddWebview()
  },
  methods: {
    AddWebview() {
      axios.post('http://localhost:8080/api/addwebviews', {}, {
    headers: {
        'Content-Type': 'application/json'
    },
    cache: 'no-store'  // 禁用缓存
})
.then(response => {
    console.log(response.data.message);
})
.catch(error => {
    console.error("请求失败", error.response);
});


    }
  }
};
</script>
