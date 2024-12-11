<template>
  <div class="article-container">
    <!-- 返回按钮 -->
    <div class="back-button-container">
      <button @click="goBack" class="back-button">返回</button>
    </div>

    <div class="article-wrapper">
      <!-- 文章主体内容 -->
      <div class="article-content">
        <h1 class="article-title">{{ title }}</h1>
        <!-- 显示作者信息 -->
        <div class="article-author">{{ author }}</div>
        <div class="publish-time">发布时间：{{ articleTime }}</div>
        <div class="article-body" v-html="content" />
      </div>

      <!-- 点赞和时间信息 -->
      <div class="article-info">
        <div class="like-info">
          <strong>{{ likeNum }}</strong>
          <span>个点赞 👍</span>
        </div>
        <!-- 点赞按钮 -->
        <LikeBtn :id="id" :type="a" :currentLikeNum="likeNum" @likeUpdated="updateLikeNum" />
      </div>

      <!-- 评论区域 -->
      <div class="comment-section">
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
import axios from 'axios'
import LikeBtn from '../components/LikeBtn.vue';

export default {
    data() {
        return {
            title: '',
            content: '',
            articleTime: '',
            likeNum: 0,  // 初始点赞数
            messages: [],  // 评论列表
            message: '',  // 用户输入的评论
            id: '',
            a: 'a'
        }
    },
    components: {
        LikeBtn,
    },
    mounted() {
        this.getUrl()
        this.getComments()
        this.getLikeNum()
        this.id = this.$route.params.id
    },
    methods: {
       // 返回按钮点击事件
      goBack() {
        // 跳转到你想去的页面
        this.$router.push({ name: 'article' }); // targetPageName 是你要跳转的页面名称
      },
      getUrl() {
          const id = this.$route.params.id
          axios
              .post('http://localhost:8080/api/getarticle?id=' + id)
              .then((response) => {
                  this.title = response.data.title
                  this.author = response.data.author // 获取作者信息
                  this.content = response.data.content
                      .replace(/\n/g, '<br>') // 处理换行符
                      .replace(/(^|\n)(\s{2})/g, '$1&nbsp;&nbsp;') // 每个段落前加两个空格
                  this.articleTime = response.data.publication_date
              })
              .catch((error) => {
                  console.error('请求数据失败', error)
              })
      },
      getLikeNum() {
          const id = this.$route.params.id
          axios
              .post('http://localhost:8080/api/getarticlelikes?article_id=' + id)
              .then((response) => {
                  this.likeNum = response.data // 获取初始点赞数
              })
              .catch((error) => {
                console.error('请求数据失败', error)
              })
      },
      updateLikeNum() {
        const id = this.$route.params.id
          axios
              .post('http://localhost:8080/api/getarticlelikes?article_id=' + id)
              .then((response) => {
                  this.likeNum = response.data // 获取初始点赞数
              })
              .catch((error) => {
                console.error('请求数据失败', error)
              })
      },
      getComments() {
        const id = this.$route.params.id;  // 获取文章的 ID
        axios
            .post(`http://localhost:8080/api/getarticlecomment?article_id=${id}`)  // 使用反引号
            .then((response) => {
                console.log('评论数据:', response.data);  // 在控制台打印返回的评论数据
                if (response.data && Array.isArray(response.data)) {
                    this.messages = response.data;  // 将返回的评论数据存入 messages 数组
                } else {
                    console.error('评论数据格式不正确');
                }
            })
            .catch((error) => {
                console.error('请求数据失败', error);  // 错误处理
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
              this.$router.push("/login"); // 跳转到登录页面
            })
            .catch(() => {
              this.$message.info("已取消操作");
            });
        } else {
          const id = this.$route.params.id;

          if (this.message) {
            const currentDate = new Date().toISOString(); // 获取当前时间，格式为 ISO 8601
            const url = `http://localhost:8080/api/addarticlecomment?comment_date=${currentDate}&username=${username}&comment=${encodeURIComponent(
                this.message
            )}&article_id=${id}`;
            axios
                .post(url)
                .then((response) => {
                    const status = response.data.status;
                    if (status === -1) {
                        this.$message.error('添加评论失败');
                    } else {
                        this.message = '';
                        this.getComments();  // 刷新评论列表
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
/* 返回按钮样式 */
.back-button-container {
  position: absolute;
  top: 20px;
  left: 20px;
}

.back-button {
  padding: 8px 16px;
  font-size: 16px;
  background-color: #409EFF;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.back-button:hover {
  background-color: #66b3ff;
}

.article-container {
  min-height: 100vh;
  padding: 40px 20px;
  background-color: #f5f5f5;
  display: flex;
  justify-content: center;
}

.article-wrapper {
  max-width: 800px;
  width: 100%;
}

.article-content {
  background: white;
  border-radius: 8px;
  padding: 30px;
  margin-bottom: 20px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.article-title {
  font-size: 28px;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.article-body {
  font-size: 16px;
  line-height: 1.8;
  color: #444;
}

.article-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 20px 0;
  padding: 15px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.like-info {
  display: flex;
  align-items: center;
  gap: 5px;
}

.like-info strong {
  color: #409EFF;
  font-size: 20px;
}

.publish-time {
  color: #999;
  font-size: 16px;
  margin-bottom: 15px;
  font-weight: bold;
}

.comment-section {
  background: white;
  border-radius: 8px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.comment-form {
  margin-bottom: 30px;
}

.comment-input {
  width: 100%;
  min-height: 100px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  margin-bottom: 15px;
  font-size: 14px;
  resize: vertical;
}

.submit-btn {
  background-color: #409EFF;
  color: white;
  padding: 10px 25px;
  border-radius: 20px;
  float: right;
  transition: background-color 0.3s;
}

.submit-btn:hover {
  background-color: #66b1ff;
}

.comment-item {
  padding: 20px;
  border-bottom: 1px solid #eee;
}

.comment-item:last-child {
  border-bottom: none;
}

.comment-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.user-name {
  color: #409EFF;
  font-weight: 500;
}

.comment-time {
  color: #999;
  font-size: 14px;
}

.comment-content {
  color: #666;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .article-container {
    padding: 20px 10px;
  }

  .article-title {
    font-size: 24px;
  }

  .article-content {
    padding: 20px;
  }

  .submit-btn {
    width: 100%;
  }
}

  .article-author {
      font-size: 16px;
      color: #666;
      margin-bottom: 15px;
      font-weight: bold;
  }

</style> 