<template>
  <div class="home-container">
    <!-- 上方导航栏 -->
    <div class="navbar">
      <div class="logo">
        <span class="logo-text">2024</span>
        <span class="election-text">AI前沿动态</span>
        <span class="separator"></span>  <!-- 分隔符 -->
    <span class="subtitle">AI Trends</span>  <!-- 英文副标题 -->
      </div>
      <el-menu :default-active="active" class="menu" mode="horizontal">
        <el-menu-item index="home" @click="goToHomePage">首页</el-menu-item>
        <el-menu-item index="aboutUs" @click="goToAboutUsPage">关于我们</el-menu-item>
        <el-menu-item index="projectIntro" @click="goToProjectIntroPage">项目介绍</el-menu-item>
        <el-menu-item index="profile" @click="goToProfilePage">个人</el-menu-item>
        <el-menu-item index="adminlogin" @click="goToAdminLogin">管理员登录</el-menu-item>
      </el-menu>
    </div>
  
    <!-- 图片轮播 -->
    <div class="carousel-container">
      <el-carousel :interval="5000" type="card" height="60vh" trigger="click">
        <el-carousel-item v-for="(imagePath, index) in imagePaths" :key="index">
          <img :src="imagePath" alt="carousel image" />
        </el-carousel-item>
      </el-carousel>
    </div>


    <!-- 主内容区域 -->
    <div class="main-container">
      <!-- 左侧内容区域 -->
      <div class="main-content">
        <h1>人工智能最新进展</h1>
        <p>人工智能正在迅速改变各行各业。以下是一些领域中的最新进展：</p>
        <ul>
          <li><strong>大语言模型（LLM）</strong>: 最新的AI语言模型如GPT-4，不仅能够处理文本，还能分析图像和视频，展现出强大的跨模态理解能力。</li>
          <li><strong>生成式AI</strong>: 生成图像、音乐、文本等内容的AI技术正在被广泛应用，甚至创造出逼真的虚拟角色和数字艺术。</li>
          <li><strong>强化学习</strong>: 在自动驾驶、机器人控制等领域，强化学习的应用日益广泛，帮助提升系统的自主决策能力。</li>
          <li><strong>医疗领域的AI应用</strong>: AI在疾病预测、个性化治疗和药物研发方面展现出巨大的潜力。</li>
          <li><strong>艺术文化中的AI</strong>: AI正在深入各类艺术创作领域，包括视觉艺术、音乐、写作、电影制作以及虚拟角色和数字内容的生成。</li>
        </ul>
        <p class="future-ai-text">AI的未来充满了无限可能，它不仅将改变我们的生活，还将重新定义工作、学习和娱乐的方式。</p>
      </div>

      <!-- 右侧栏区域 -->
      <div class="sidebar">
        <!-- 文章区域 -->
        <div class="section-card article-section">
          <div class="section-header">
            <h2>最新文章</h2>
            <el-button type="text" @click="goToArticlePage" class="section-btn">文章专区</el-button>
          </div>
          <el-carousel :interval="3000" height="auto" trigger="click">
            <el-carousel-item v-for="(article, index) in articles.slice(0, 5)" :key="index">
              <a :href="'/articles/' + article.id" class="article-link">{{ article.title }}</a>
            </el-carousel-item>
          </el-carousel>
        </div>

        <!-- 视频区域 -->
        <div class="section-card video-section">
          <div class="section-header">
            <h2>精彩视频</h2>
            <el-button type="text" @click="goToVideoPage" class="section-btn">视频专区</el-button>
          </div>
          <div class="video-list">
            <div v-for="(video, index) in videos.slice(0, 3)" :key="index" class="video-entry">
              <el-card :body-style="{ padding: '20px' }">
                <img :src="video.thumbnail" alt="Video Thumbnail" class="video-thumbnail" />
                <div class="video-title">{{ video.title }}</div>
                <el-button type="primary" @click="goToVideoPage(video.id)" class="video-btn">观看视频</el-button>
              </el-card>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      active: "home",
      imagePaths: [
        require('@/assets/images/1.png'),
        require('@/assets/images/2.png'),
        require('@/assets/images/3.png'),
        require('@/assets/images/4.png'),
        require('@/assets/images/5.png')
      ],
      backgroundImage: require('@/assets/images/6.png'),  // 使用 require 引入背景图
      articles: [],
      videos: [],
      viewCount: 0,
      lastVisitTime: null // 用来记录上次访问的时间
    };
  },
  methods: {
    goToAdminLogin() {
      this.$router.push('/admin');  // 跳转到首页
    },
    goToArticlePage() {
      this.$router.push('/articles');
    },
    goToVideoPage() {
      this.$router.push('/videoview');
    },
    goToHomePage() {
      this.$router.push('/home');  // 跳转到首页
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
            this.$router.push("/"); // 跳转到登录页面
          })
          .catch(() => {
            this.$message.info("已取消操作");
          });
      } else {
        this.$router.push("/profile"); // 跳转到个人页面
      }
    },
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Special+Elite&display=swap'); /* 导入特别字体 */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Merriweather:wght@700&display=swap');
.home-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  background-color: #f8f9fa; /* 设置页面背景色 */
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
  margin-right: 150px; /* 调整左右间距 */
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

/* 倾斜且加长的渐变分隔符 */
.separator {
  display: inline-block;
  width: 6px;  /* 设置较小的宽度 */
  height: 80px;  /* 加长分隔符 */
  /*background: linear-gradient(to bottom, #ff7e5f, #feb47b, #32cd32, #2575fc);  渐变色包含绿色 */
   background: linear-gradient(to bottom, #ff7e5f, #feb47b, #6a11cb, #2575fc); 
  border-radius: 2px;  /* 圆角效果 */
  margin: 0 15px;  /* 分隔符的左右间距 */
  transform: rotate(8deg);  /* 倾斜角度 */
  transform-origin: center;  /* 设置倾斜原点为中间 */
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



/* 图片轮播样式 */
.carousel-container {
  width: 100%;
  margin-top: 20px;
}

.carousel-container img {
  width: 100%;
  height: auto;
  object-fit: cover; /* 保持图片比例，适应容器 */
  border-radius: 8px; /* 给图片添加圆角 */
}

/* 主要容器 */
.main-container {
  display: flex;
  margin-top: 30px;
  gap: 30px; /* 设置主内容与侧边栏之间的间距 */
}

/* 主内容区域 */
.main-content {
  flex: 3;
  margin-right: 20px;
  margin-left: 30px; /* 增加左边距 */
  margin-right: 20px;
  background-color: #F8F8FF; /* 背景色 */
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* 边框阴影 */
  font-family: 'Arial', sans-serif; /* 字体 */
  color: #333333; /* 字体颜色 */
}

.main-content h1 {
  font-size: 3.2em; /* 更大的标题字体大小 */
  font-weight: 700; /* 使用更粗的字体 */
  background: linear-gradient(to right, #8470FF, #00bfff); /* 渐变背景 */
  -webkit-background-clip: text; /* 渲染渐变文字 */
  color: transparent; /* 使文字颜色透明以显示渐变背景 */
  text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2); /* 加强阴影效果 */
  margin-bottom: 20px; /* 增加间距 */
  font-family: 'Poppins', sans-serif; /* 使用 Poppins 字体 */
  letter-spacing: 2px; /* 字母间距 */
  text-transform: uppercase; /* 大写字母 */
  line-height: 1.2; /* 行高，增加文字的可读性 */
}

.main-content p {
  font-size: 1.1em; /* 正文字体大小 */
  line-height: 1.6; /* 行高 */
  margin-bottom: 15px; /* 段落间距 */
  color: #666666; /* 正文颜色 */
}

.main-content ul {
  list-style-type: none;
  padding-left: 0;
}

.main-content ul li {
  font-size: 1.1em;
  margin-bottom: 10px;
}

.main-content ul li strong {
  color: 	#000000; /* 强调文本颜色 */
}


/* AI未来段落样式 */
.future-ai-text {
  font-family: 'KaiTi', 'SimSun', 'Arial', sans-serif;  /* 使用楷体、宋体和常规字体 */
  font-size: 100px;/* 更大的字体大小 */
  line-height: 1.8;  /* 行高 */
  color: #2E8B57;  /* 字体颜色，选择绿色系 */
  padding: 25px;  /* 增加内边距 */
  margin: 25px 0;  /* 增加外边距 */
  text-align: center;  /* 居中对齐 */
  font-weight: bold;  /* 加粗字体 */
  background-color: 	#E6E6FA;  
  border-radius: 12px;  /* 圆角背景 */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* 轻微阴影 */
}

.future-ai-text span {
  color: #FF6347;  /* 强调部分字体颜色，选择番茄色 */
  font-style: italic;  /* 斜体 */
  font-size: 100px;  /* 强调部分字体增大 */
}

/* 侧边栏 */
.sidebar {
  flex: 1;
  background-color: rgba(255, 255, 255, 0.8); /* 半透明背景色 */
  background-image: url('@/assets/images/6.png'); /* 背景图 */
  background-size: cover;  /* 背景图覆盖整个区域 */
  background-position: center;  /* 背景图居中 */
  background-repeat: no-repeat;  /* 背景图不重复 */
  padding: 20px;
  border-radius: 12px; /* 更大的圆角 */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* 更柔和的阴影 */
  transition: transform 0.3s ease-in-out; /* 添加缩放效果 */
}

.sidebar:hover {
  transform: scale(1.02); /* 鼠标悬停时缩放 */
}

/* 文章和视频专区的卡片 */
.section-card {
  margin-bottom: 25px;
  background-color: rgba(255, 255, 255, 0.9); /* 增加透明度，让背景更可见 */
  padding: 15px;
  border-radius: 12px; /* 更大的圆角 */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12); /* 更柔和的阴影 */
  transition: box-shadow 0.3s ease-in-out; /* 添加卡片阴影效果 */
}

.section-card:hover {
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* 鼠标悬停时更明显的阴影 */
}

/* 文章专区标题 */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

/* 标题样式 */
.section-header h2 {
  font-size: 2.5em; /* 更大的标题 */
  color: transparent;
  background: linear-gradient(45deg, #333333, #888888); /* 渐变色效果 */
  -webkit-background-clip: text; /* 只对文字应用渐变 */
  background-clip: text;
  font-weight: 600; /* 增加标题的粗体 */
  letter-spacing: 1px; /* 字母间距，增加视觉效果 */
  text-transform: uppercase; /* 大写字母 */
}

/* 按钮样式 */
.section-btn {
  font-size: 1.1em;
  color: #fff;
  background: linear-gradient(45deg, #8470FF, #87CEFA); /* 渐变按钮背景 */
  border: none;
  cursor: pointer;
  text-decoration: none;
  padding: 8px 20px;
  border-radius: 30px; /* 圆角按钮 */
  transition: background-color 0.3s ease, transform 0.3s ease; /* 添加过渡效果 */
}

/* 鼠标悬停效果 */
.section-btn:hover {
  background: linear-gradient(45deg, #388e3c, #5aaf60); /* 鼠标悬停时的渐变背景 */
  transform: translateY(-3px); /* 鼠标悬停时按钮微移 */
}

/* 文章专区的链接 */
.article-link {
  font-size: 1.2em;
  color: #0073e6;
  text-decoration: none;
  margin-bottom: 15px;
  transition: color 0.3s ease;
  font-weight: 500;
}

/* 鼠标悬停效果 */
.article-link:hover {
  color: #004b99;
  text-decoration: underline;
}

/* 视频专区链接样式 */
.video-link {
  font-size: 1.2em;
  color: #0073e6;
  text-decoration: none;
  margin-bottom: 15px;
  transition: color 0.3s ease;
  font-weight: 500;
}

/* 鼠标悬停效果 */
.video-link:hover {
  color: #004b99;
  text-decoration: underline;
}

/* 响应式设计 - 在较小屏幕上调整尺寸 */
@media (max-width: 768px) {
  .main-container {
    flex-direction: column;
    gap: 20px;
  }

  .main-content {
    flex: 1;
    margin-right: 0;
  }

  .sidebar {
    flex: 1;
  }

  .section-header h2 {
    font-size: 2em; /* 小屏幕下调整标题大小 */
  }

  .section-btn {
    font-size: 1em;
  }

  .video-list {
    gap: 15px;
  }
}



</style>