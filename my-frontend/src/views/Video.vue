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
      <span class="like-count">{{ video.likes }}</span> <!-- 显示视频的当前点赞数 -->
    </div>
    <div class="video-description">
      <p>{{ video.description }}</p>
    </div>
    <div class="comment-section">
      <h2>评论</h2>
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
import axios from 'axios';

export default {
  mounted() {
    document.querySelector('body').setAttribute('style', 'background-color:#a0efb9');
    this.getVideoComments(); // 组件挂载时获取评论
  },
  beforeUnmount() {
    document.querySelector('body').removeAttribute('style');
  },
  data() {
    return {
      video: null,
      comments: [],
      newComment: '',
      id: null,
      videos: [
        { id: 1, title: 'Exploring AI', src: require('@/assets/videos/video1.mp4'), description: 'Explore AI and its impact on society.', date: 'March 15, 2023', likes: 0 },
        { id: 2, title: 'AI in Robotics', src: require('@/assets/videos/video2.mp4'), description: 'Discover how AI is used in robotics.', date: 'March 10, 2023', likes: 0 },
        // 添加更多视频对象
      ]
    };
  },
  created() {
    this.id = parseInt(this.$route.params.id); // 存储ID
    this.loadVideo();
    this.getVideoComments();
    this.getVideoLikes();
  },
  methods: {
    loadVideo() {
      this.video = this.videos.find(v => v.id === this.id);
    },
    getVideoComments() {
      axios
        .get(`http://localhost:8080/api/getvideocomments?video_id=${this.id}`)
        .then((response) => {
          this.comments = response.data;
        })
        .catch((error) => {
          console.error('Failed to fetch comments', error);
        });
    },
    addVideoComments() {
      if (this.newComment.trim() !== '') {
        const currentDate = new Date().toISOString(); // 获取当前时间，格式为 ISO 8601
        axios
          .get('http://localhost:8080/api/addvideocomments', {
            video_id: this.id,
            comment: this.newComment,
            username: 'Guest',
            comment_date: currentDate
          })
          .then((response) => {
            this.$message.success("添加评论成功！")
            console.log(response);
            this.newComment = '';
            this.getVideoComments();
          })
          .catch((error) => {
            console.error('Failed to add comment', error);
          });
      }
    },
    getVideoLikes() {
      axios
        .get(`http://localhost:8080/api/getvideolikes?video_id=${this.id}`)
        .then((response) => {
          const video = this.videos.find(v => v.id === this.id);
          if (video) {
            video.likes = response.data;
          }
        })
        .catch((error) => {
          console.error('Failed to fetch video likes', error);
        });
    },
    likeVideo() {
      console.log('Liking video', this.id);
      const video = this.videos.find(v => v.id === this.id);
      if (video) {
        video.likes += 1; // 本地更新点赞数
        axios
          .get(`http://localhost:8080/api/addvideolikes?video_id=${this.id}`)
          .then((response) => {
            this.$message.success("点赞成功！")
            console.log(response);
          })
          .catch((error) => {
            
            console.error('Failed to update likes', error);
            video.likes -= 1; // 如果失败，将本地计数减回去
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