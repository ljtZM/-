<template>
  <div class="video-container" v-if="video">
    <div class="video-header">
      <h1>{{ video.title }}</h1>
    </div>
    <div class="video-player">
      <video controls>
        <source :src="video.src" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="video-likes">
      <button @click="likeVideo(video.id)" class="like-button">👍 Like</button>
      <span class="like-count">{{ video.likes }}</span>
    </div>
    <div class="video-description">
      <p>{{ video.description }}</p>
    </div>
    <div class="comment-section">
      <h2>Comments</h2>
      <div v-for="comment in comments" :key="comment.id" class="comment">
        <div class="comment-header">
          <strong>{{ comment.username }}</strong>
          <span class="comment-date">{{ comment.comment_date }}</span>
        </div>
        <p>{{ comment.comment }}</p>
      </div>
      <div class="comment-form">
        <textarea v-model="newComment" placeholder="Add a comment..."></textarea>
        <button @click="addVideoComments">Post Comment</button>
      </div>
    </div>
  </div>
  <div v-else>
    <p>Loading...</p>
  </div>
</template>

<script>
// 导入 axios
import axios from 'axios';

export default {
  props: ['id'],
  mounted() {
    document.querySelector('body').setAttribute('style', 'background-color:#a0efb9');
    this.getVideoComments(); // 组件挂载时获取评论
  },
  beforeUnmount() {
    document.querySelector('body').removeAttribute('style');
  },
  data() {
    return {
      videos: [
        { id: 1, title: 'Exploring AI', src: require('@/assets/videos/video1.mp4'), description: 'Explore AI and its impact on society.', date: 'March 15, 2023', likes: 0 },
        { id: 2, title: 'AI in Robotics', src: require('@/assets/videos/video2.mp4'), description: 'Discover how AI is used in robotics.', date: 'March 10, 2023', likes: 0 },
        // 添加更多视频对象
      ],
      video: null,
      comments: [], // 初始化为空数组
      newComment: ''
    };
  },
  created() {
    this.loadVideo();
  },
  methods: {
    likeVideo(videoId) {
      const video = this.videos.find(v => v.id === videoId);
      if (video) {
        video.likes += 1;
      }
    },
    loadVideo() {
      this.video = this.videos.find(v => v.id === parseInt(this.id));
    },
    getVideoComments() {
      const id = this.$route.params.id;  // 获取文章的 ID
      axios
        .get(`http://localhost:8080/api/getvideocomments?video_id=${id}`)
        .then((response) => {
          this.comments = response.data; // 将评论数据赋值给 comments
        })
        .catch((error) => {
          console.error('Failed to fetch comments', error);
        });
    },
    addVideoComments() {
      if (this.newComment.trim() !== '') {
        axios
          .post('http://localhost:8080/api/addvideocomments', {
            video_id: this.id,
            comment: this.newComment,
            username: 'Guest' // 这里应该是当前用户的用户名，如果是游客评论，可以使用'Guest'
          })
          .then(() => {
            this.newComment = '';
            this.getVideoComments(); // 添加评论后重新获取评论列表
          })
          .catch((error) => {
            console.error('Failed to add comment', error);
          });
      }
    }
  }
};
</script>

<style scoped>
/* Import the external CSS file */
@import '../assets/css/video.css';
</style>