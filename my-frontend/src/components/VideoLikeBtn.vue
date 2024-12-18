<template>
    <div class="like-button-container">
      <button 
        class="like-button" 
        @click="handleClick"
        :class="{ 'liked': isLiked }"
        :disabled="isLiked"
      >
        <span class="like-icon">👍</span>
        <span class="like-text">{{ isLiked ? '已点赞' : '点赞' }}</span>
      </button>
    </div>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    name: 'VideoLikeBtn',
    props: {
      id: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      currentLikeNum: {  // 添加接收点赞数的属性
        type: Number,
        required: true
      }
    },
    data() {
      return {
        isLiked: false,
        updatedLikeNum: this.currentLikeNum // 使用传入的点赞数
      }
    },
    methods: {
      handleClick() {
        if (!this.isLiked) {
          const username = sessionStorage.getItem('Username')
          const num = 1 // 每次点击增加1个点赞
          axios
            .post('http://localhost:8080/api/addvideolikes', null, {
              params: {
                username: username,
                video_id: this.id,
                num: num
              }
            })
            .then(() => {
              this.isLiked = true // 设置按钮为已点赞
              this.updatedLikeNum += 1 // 立即更新点赞数
              this.$emit('likeUpdated', this.updatedLikeNum) // 通知父组件更新点赞数
            })
            .catch((error) => {
              console.error('点赞失败', error)
              this.$message.error('点赞失败，请检查网络')
            })
        }
      }
    }
  }
  </script>
  
  
  
  <style scoped>
  .like-button-container {
    display: flex;
    justify-content: center;
    margin: 20px 0;
  }
  
  .like-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 30px;
    background-color: white;
    border: 2px solid #409EFF;
    border-radius: 25px;
    color: #409EFF;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .like-button:hover:not(:disabled) {
    background-color: #409EFF;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(64, 158, 255, 0.2);
  }
  
  .like-button.liked {
    background-color: #409EFF;
    color: white;
    cursor: default;
  }
  
  .like-icon {
    font-size: 20px;
    line-height: 1;
  }
  
  .like-text {
    font-size: 16px;
  }
  
  /* 禁用状态样式 */
  .like-button:disabled {
    opacity: 0.8;
    cursor: default;
  }
  
  @media (max-width: 768px) {
    .like-button {
      padding: 10px 25px;
      font-size: 14px;
    }
    
    .like-icon {
      font-size: 18px;
    }
    
    .like-text {
      font-size: 14px;
    }
  }
  </style>
  