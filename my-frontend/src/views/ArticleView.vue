<template>
  <div class="page-container">
    <!-- 上方导航栏 -->
    <div class="navbar">
      <el-menu :default-active="active" class="menu" mode="horizontal">
        <el-menu-item index="home" @click="goToHomePage">首页</el-menu-item>
        <el-menu-item index="aboutUs" @click="goToAboutUsPage">关于我们</el-menu-item>
        <el-menu-item index="projectIntro" @click="goToProjectIntroPage">项目介绍</el-menu-item>
        <el-menu-item index="profile" @click="goToProfilePage">个人</el-menu-item>
      </el-menu>
    </div>
    
    <div class="header">
      <h1 class="page-title">文章列表</h1>
    </div>
    
    <div class="content-container">
      <div class="article-grid">
        <router-link 
          v-for="item in articleList" 
          :key="item.id" 
          :to="'/article/' + item.id" 
          class="article-card"
        >
          <div class="card-content">
            <div class="card-header">
              <h2 class="article-title">{{ item.title}}</h2>
              <span class="article-date">{{ item.publication_date}}</span>
            </div>
            <div class="card-preview">
              {{item.summary}}
            </div>
            <div class="card-footer">
              <span class="read-more">阅读全文</span>
              <span class="arrow">→</span>
            </div>
          </div>
        </router-link>
      </div>

      <div class="pagination-container">
        <el-pagination 
          background 
          layout="prev, pager, next" 
          :total="pagecount" 
          hide-on-single-page
          @current-change="handlePageChange" 
        />
      </div>
    </div>
  </div>
  <el-backtop :right="100" :bottom="100" />
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      articleList: [],  // Articles list
      pagecount: 1  // Total number of pages
    };
  },
  mounted() {
    this.getUrl();  // Fetch articles
    this.getpage();  // Fetch page count
  },
  methods: {
    goToHomePage() {
      this.$router.push('/');  // 跳转到首页
    },
    goToAboutUsPage() {
      this.$router.push('/aboutUs');  // 跳转到关于我们页面
    },
    goToProjectIntroPage() {
      this.$router.push('/projectIntro');  // 跳转到项目介绍页面
    },
    goToProfilePage() {
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
        this.$router.push("/profile"); // 跳转到个人页面
      }
    },
    getUrl() {
      axios
        .post('http://localhost:8080/api/getarticle')
        .then((response) => {
          console.log('API 返回的数据:', response.data); // 检查数据
          if (Array.isArray(response.data)) {
            this.articleList = response.data;
          } else {
            this.articleList = []; // 如果数据格式不对，置为空数组
          }
        })
        .catch((error) => {
          console.error('请求失败', error);
        });
    },

    // Handle page change for pagination
    handlePageChange(page) {
      axios
        .post(`http://localhost:8080/api/getarticle?page=${page}`)
        .then((response) => {
          const elBacktop = document.querySelector('.el-backtop');
          this.articleList = Array.isArray(response.data) ? response.data : [];
          elBacktop.click();  // Scroll to top after page change
        })
        .catch((error) => {
          console.error('请求失败', error);
        });
    },

    // Get the total page count from the server
    getpage() {
      axios
        .post('http://localhost:8080/api/getarticlepagecount')
        .then((response) => {
          // Ensure the response data is valid
          this.pagecount = Number.isInteger(response.data) ? response.data * 10 : 0;
          console.log(this.pagecount);  // Debug: log page count
        })
        .catch((error) => {
          console.error('请求失败', error);
        });
    }
  }
};
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  background-color: #f5f5f5;
  padding: 40px 20px;
}

.header {
  max-width: 1200px;
  margin: 0 auto 40px;
  text-align: center;
}

.page-title {
  color: #2c3e50;
  font-size: 32px;
  font-weight: 600;
  margin: 0;
}

.content-container {
  max-width: 1200px;
  margin: 0 auto;
}

.article-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.article-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  height: 100%;
}

.article-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.card-content {
  padding: 20px;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card-header {
  margin-bottom: 15px;
}

.article-title {
  color: #2c3e50;
  font-size: 20px;
  margin: 0 0 10px 0;
  line-height: 1.4;
}

.article-date {
  color: #666;
  font-size: 14px;
}

.card-preview {
  color: #666;
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 20px;
  flex-grow: 1;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 15px;
  border-top: 1px solid #eee;
}

.read-more {
  color: #409EFF;
  font-size: 14px;
  font-weight: 500;
}

.arrow {
  color: #409EFF;
  font-size: 18px;
  transition: transform 0.3s ease;
}

.article-card:hover .arrow {
  transform: translateX(5px);
}

.pagination-container {
  display: flex;
  justify-content: center;
  padding: 20px 0;
}

:deep(.el-pagination.is-background .el-pager li:not(.is-disabled).is-active) {
  background-color: #409EFF;
}

:deep(.el-pagination.is-background .el-pager li) {
  margin: 0 4px;
  transition: all 0.3s ease;
}

:deep(.el-pagination.is-background .el-pager li:hover) {
  color: #409EFF;
}

@media (max-width: 768px) {
  .page-container {
    padding: 20px 10px;
  }

  .header {
    margin-bottom: 20px;
  }

  .page-title {
    font-size: 24px;
  }

  .article-grid {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .article-title {
    font-size: 18px;
  }

  .card-content {
    padding: 15px;
  }
}
</style>
