<template>
  <div class="video-container">
    <!-- 返回按钮 -->
    <div class="back-button-container">
      <button @click="goBack" class="back-button">返回</button>
    </div>

    <div class="video-wrapper">
      <!-- 视频内容 -->
      <div class="video-content">
        <h1 class="video-title">{{ title }}</h1>
        <video :src="videoUrl" controls class="video-player"></video>
        <div class="publish-time">发布时间：{{ videoTime }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      title: '',
      videoUrl: '',
      videoTime: '',
      id: ''
    }
  },
  mounted() {
    this.id = this.$route.params.id;
    this.getVideoData();
  },
  methods: {
    goBack() {
      this.$router.push({ name: 'VideoView' });
    },
    getVideoData() {
      const id = this.$route.params.id;
      axios
        .get('http://localhost:8080/api/getvideo?video_id=' + id)
        .then((response) => {
          this.title = response.data.title;
          const videoFileName = response.data.url; // 假设后端返回的视频文件名
          console.log(videoFileName);
          this.videoUrl = require(`@/assets/videos/${videoFileName}`); // 使用 require 来加载静态资源
          // import(`@/assets/videos/${videoFileName}`)
          //     .then((module) => {
          //       this.videoUrl = module.default; // 动态加载成功后设置 URL
          //     })
          //     .catch((error) => {
          //       console.error('视频加载失败', error);
          //     });
          console.log(this.videoUrl);
          this.videoTime = response.data.created_at;
        })
        .catch((error) => {
          console.error('请求数据失败', error);
        });
    }
  }
}
</script>

<style scoped>
/* Import the external CSS file */
@import '../assets/css/video.css';
</style>