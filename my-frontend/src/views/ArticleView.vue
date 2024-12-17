<template>
  <div class="page-container">
     <!-- 上方导航栏 -->
     <div class="navbar">
      <div class="logo">
        <span class="logo-text">文章专区</span>
        <span class="separator"></span>  <!-- 分隔符 -->
      </div>
      <el-menu :default-active="active" class="menu" mode="horizontal">
        <el-menu-item index="home" @click="goToHomePage">首页</el-menu-item>
        <el-menu-item index="aboutUs" @click="goToAboutUsPage">关于我们</el-menu-item>
        <el-menu-item index="projectIntro" @click="goToProjectIntroPage">项目介绍</el-menu-item>
        <el-menu-item index="profile" @click="goToProfilePage">个人</el-menu-item>
        <el-menu-item index="adminlogin" @click="goToAdminLogin">管理员登录</el-menu-item>
      </el-menu>
    </div>
    <div class="search-bar">
      <el-input 
        v-model="searchQuery" 
        placeholder="请输入搜索内容" 
        suffix-icon="el-icon-search" 
        @input="filterArticles" 
        @keyup.enter="searchOnEnter" 
        clearable
      />
    </div>
    <div class="content-container">
      <div class="article-grid">
        <!-- 渲染过滤后的文章列表 -->
        <router-link 
          v-for="item in filteredArticles" 
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
    <!-- 底部 -->
    <footer class="footer">
      <p>&copy; 2024 人工智能新闻与视频</p>
    </footer>
  </div>
  <el-backtop :right="50" :bottom="100" />
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      articleList: [],  // Articles list
      pagecount: 1,  // Total number of pages
      searchQuery: ""  // 确保定义了 searchQuery
    };
  },
  computed: {
    filteredArticles() {
      if (this.searchQuery === "") {
        return this.articleList; // 如果没有搜索内容，显示所有文章
      }
      return this.articleList.filter(item => item.title.toLowerCase().includes(this.searchQuery.toLowerCase()));
    }
  },
  mounted() {
    this.getUrl();  // Fetch articles
    this.getpage();  // Fetch page count
  },
  methods: {
    filterArticles() {
      // 在这里不需要做任何操作，因为 `filteredArticles` 已经根据 `searchQuery` 自动计算了
    },
    searchOnEnter() {
      this.filterArticles(); // 按下回车时触发搜索
    },
    goToAdminLogin() {
      this.$router.push('/admin');  // 跳转到首页
    },
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
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  background: linear-gradient(135deg, #8b9dc3,#3b5998);
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
  display: flex;
  max-width: 1200px;
  width:100%;
  margin: 30px;
  
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
  background-color: aliceblue;
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
/* 上方导航栏样式 */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 10px 20px;
  /*background: linear-gradient(135deg, #2e8b57, #98fb98); 绿色渐变 */
  background: linear-gradient(135deg, #3b5998, #8b9dc3);
}

.logo {
  display: flex;
  align-items: center;
  margin-left: 100px; /* 调整左右间距 */
  margin-right: 400px; /* 调整左右间距 */
}

.logo-text {
  font-size: 36px; /* 放大2024 */
  font-weight: bold;
  margin-right: 10px;
  /*color: #8470FF;  稍微深一点的蓝色 */
  color: #ff9900;
  font-family: 'Special Elite', cursive; /* 使用特别字体 */
}

.election-text {
  font-size: 34px; 
  color: white; /* 字体颜色 */
  font-family: 'Special Elite', cursive; /* 使用特别字体 */
  font-weight: bold; /* 加粗字体 */
}

/* 英文副标题样式 */
.subtitle {
  font-size: 24px;  /* 英文副标题较小 */
  color: rgba(255, 255, 255, 0.7);  /* 字体颜色为白色并带有透明度，0.7为微透明 */
  margin-left: 5px; /* 左侧间距 */
  font-family: 'Arial', sans-serif; /* 英文字体 */
  font-weight: lighter;  /* 字体更轻 */
  font-style: italic; /* 斜体 */
}


.menu {
  display: flex;
  flex-grow: 1;
  justify-content: center;
  margin-right: 5px; /* 调整右侧间距 */
}

/* 定义全局样式，确保菜单和菜单项背景透明 */
html body .el-menu {
  background-color: transparent !important;  /* 设置菜单背景透明 */
  border: none !important;  /* 去掉边框 */
  font-size: 26px;  /* 设置菜单的字体大小 */
}

/* 对菜单项进行处理，去掉白色背景 */
html body .el-menu .el-menu-item {
  background-color: transparent !important;  /* 设置菜单项背景透明 */
  color: white !important;  /* 设置字体颜色为白色 */
  font-size: 26px;  /* 设置菜单项的字体大小 */
  transition: background-color 0.3s ease, color 0.3s ease; /* 平滑的背景色和字体色变化 */
}

/* 悬停时和选中时背景透明 */
html body .el-menu .el-menu-item:hover,
html body .el-menu .el-menu-item.is-active {
  background-color: transparent !important;  /* 悬停和选中时背景透明 */
  color: #ff9900 !important;  /* 设置字体颜色为白色 */
  font-size: 26px;  /* 确保悬停和选中时字体大小保持一致 */
}

.footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 10px;
}
.search-bar {
  margin: 20px;

  display: flex;
  justify-content: center;
  width: 300px;
  height: 50px;
}
</style>
