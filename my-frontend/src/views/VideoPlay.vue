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

      <!-- 点赞和时间信息 -->
     <div class="article-info">
        <div class="like-info">
          <strong>{{ likeNum }}</strong>
          <span>个点赞 👍</span>
        </div>
        <!-- 点赞按钮 -->
        <VideoLikeBtn :id="id" :type="a" :currentLikeNum="likeNum" @likeUpdated="updateLikeNum" />
      </div>

      <!-- 评论区域 -->
      <div class="comment-section fade-in">
        <!-- 评论输入框 -->
        <div class="comment-form">
          <textarea 
            v-model="message" 
            placeholder="写下你的评论..."
            class="comment-input"
          ></textarea>
          <button class="submit-btn" @click="submitMessage">发表评论</button>
        </div>

        <!-- 评论列表 -->
        <div class="comment-list">
          <div v-for="(msg, index) in messages" 
               :key="index" 
               class="comment-item">
            <div class="comment-header">
              <div class="user-name">{{ msg.username }}</div>
              <div class="comment-time">{{ msg.comment_date }}</div>
            </div>
            <div class="comment-content">{{ msg.comment }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</template>

<script>
import axios from 'axios';
import VideoLikeBtn from '../components/VideoLikeBtn.vue';

export default {
  data() {
    return {
      title: '',
      videoUrl: '',
      videoTime: '',
      id: '',
      likeNum: 0,  // 初始点赞数
      messages: [],  // 评论列表
      message: '',  // 用户输入的评论
      a: 'a'
    }
  },
  components: {
      VideoLikeBtn,
  },
  mounted() {
    this.getComments()
    this.getLikeNum()
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
    },
    getLikeNum() {
          const id = this.$route.params.id
          axios
              .post('http://localhost:8080/api/getvideolikes?video_id=' + id)
              .then((response) => {
                  this.likeNum = response.data
              })
              .catch((error) => {
                console.error('请求数据失败', error)
              })
      },
      updateLikeNum() {
        const id = this.$route.params.id
          axios
              .post('http://localhost:8080/api/getvideolikes?video_id=' + id)
              .then((response) => {
                  this.likeNum = response.data
              })
              .catch((error) => {
                console.error('请求数据失败', error)
              })
      },
      getComments() {
        const id = this.$route.params.id;  
        axios
            .post(`http://localhost:8080/api/getvideocomment?video_id=${id}`)
            .then((response) => {
                if (response.data && Array.isArray(response.data)) {
                    this.messages = response.data;
                } else {
                    console.error('评论数据格式不正确');
                }
            })
            .catch((error) => {
                console.error('请求数据失败', error);
            });
    },
    submitMessage() {
        const username = sessionStorage.getItem("Username");
        if (!username) {
          this.$confirm("您尚未登录，是否跳转到登录页面？", "提示", {
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            type: "warning",
          })
            .then(() => {
              this.$router.push("/");
            })
            .catch(() => {
              this.$message.info("已取消操作");
            });
        } else {
          const id = this.$route.params.id;

          if (this.message) {
            const currentDate = new Date().toISOString(); 
            const url = `http://localhost:8080/api/addvideocomment?comment_date=${currentDate}&username=${username}&comment=${encodeURIComponent(this.message)}&video_id=${id}`;
            axios
                .post(url)
                .then((response) => {
                    const status = response.data.status;
                    if (status === -1) {
                        this.$message.error('添加评论失败');
                    } else {
                        this.message = '';
                        this.getComments();  
                    }
                })
                .catch((error) => {
                    console.error('发送数据失败', error);
                    this.$message.error('检查网络问题！');
                });
          } else {
              this.$message.error('请填写评论！');
          }
        }
      }
  }
}
</script>

<style scoped>
/* Import the external CSS file */
@import '../assets/css/video.css';
</style>