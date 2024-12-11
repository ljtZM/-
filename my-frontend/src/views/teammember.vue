<script>
import MContainer from '../components/MContainer.vue'
import axios from 'axios'
export default {
  data() {
    return {
      views: 0,
      Info: "",
      name1: '崔交军',
      name2: '高艺轩',
      name3: '李嘉桐',
      name4: '杨峥芃',
      downloadSrc: [
        {
          title: '崔交军',
          link: 'public/data/1.zip',
        },
        {
          title: '高艺轩',
          link: 'public/data/1.zip'
        },
        {
          title: '团队作业',
          link: 'public/data/1.zip'
        },
        {
          title: '李嘉桐',
          link: 'public/data/1.zip'
        },
        {
          title: '杨峥芃',
          link: 'public/data/1.zip'
        },
      ],
    }
  },
  components: {
    MContainer
  },
  mounted() {
    this.checkviews()
  },
  methods: {
    checkviews() {
      axios.post('http://localhost:8080/api/checkwebviews')
        .then((response) => {
          this.views = response.data.views
        })
        .catch((error) => {
          console.error('请求失败', error)
        })
    },
    scrollToSection(section) {
      const element = document.getElementById(section)
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' })
      }
    }
  }
}
</script>

<template>
  <div class="aboutContainer">
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
      </el-menu>
    </div>
    <!-- 面包栏 -->
    <div class="breadcrumb">
      <button @click="scrollToSection('webInfo0')">网站信息</button>
      <button @click="scrollToSection('download')">作业下载</button>
      <button @click="scrollToSection('team-container')">成员信息</button>
    </div>

    <h2>🌐 网站访问次数：{{ views }} 次</h2>
    <div id="webInfo0" class="webInfo0">
      <h2>✨ 关于网站</h2>
      <!-- 在此添加新的文本内容 -->
      <p>我们是一个致力于搜集并挑选AI前沿科研成果的网站，致力于加强成果共享，尽力帮助需要的人节省检索的时间。</p>
    </div>


    <div id="download" class="download">
      <h2>📂 作业下载</h2>
      <div class="homework">
        <div class="teamwork-btn">
          <a :href="downloadSrc[2].link" download>
            <li class="teamwork">{{ downloadSrc[2].title }}</li>
          </a>
        </div>

        <div class="member-btns">
          <a v-for="(item, index) in downloadSrc.slice(0, 2)" :key="index" :href="item.link" download>
            <li>{{ item.title }}</li>
          </a>
          <a v-for="(item, index) in downloadSrc.slice(3)" :key="index + 3" :href="item.link" download>
            <li>{{ item.title }}</li>
          </a>
        </div>
      </div>
    </div>

    <div id="team-container" class="team-container">
      <h2>🌟 成员信息</h2>
      <div class="members">
        <!-- 成员 1 -->
        <MContainer
          fullname="崔交军"
          studentId="20240001"
          task="负责前端开发"
          email="cuijiaojun@example.com"
          github="https://github.com/cuijiaojun"
          imageSrc="../pic/member1.jpg"
        />
        <!-- 成员 2 -->
        <MContainer
          fullname="高艺轩"
          studentId="20240002"
          task="负责后端开发"
          email="gaoyixuan@example.com"
          github="https://github.com/gaoyixuan"
          imageSrc="../pic/member2.jpg"
        />
        <!-- 成员 3 -->
        <MContainer
          fullname="李嘉桐"
          studentId="20240003"
          task="负责数据库设计"
          email="lijiatong@example.com"
          github="https://github.com/lijiatong"
          imageSrc="../pic/member3.jpg"
        />
        <!-- 成员 4 -->
        <MContainer
          fullname="杨峥芃"
          studentId="20240004"
          task="负责测试与部署"
          email="yangzhengpeng@example.com"
          github="https://github.com/yangzhengpeng"
          imageSrc="member4.jpg"
        />
      </div>
    </div>
    <el-backtop :right="200" :bottom="100" />
  </div>
</template>

<style scoped>

.aboutContainer {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 0vh;
  width: 100%;
  min-height: 65vh;
  overflow-x: hidden;
  overflow-y: hidden;
  background-color: #111;
  color: white;
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
  margin-left: 320px; /* 调整左右间距 */
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

.breadcrumb {
  display: flex;
  gap: 30px;
  margin-top: 20px;
  margin-bottom: 30px;
}

.breadcrumb button {
  background: linear-gradient(45deg, #00e5ff, #008c9e);
  border: none;
  padding: 15px 25px;
  font-size: 18px;
  color: white;
  cursor: pointer;
  border-radius: 10px;
  transition: all 0.3s ease;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

.webmem {
  text-align: center; /* 居中文本 */
}

.breadcrumb button:hover {
  background: linear-gradient(45deg, #008c9e, #00e5ff);
  transform: scale(1.05);
  box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
}

h2 {
  color: #00e5ff;
}

.webInfo0 {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: rgba(0, 0, 0, 0.7);
  border-radius: 15px;
  margin-top: 10vh;
  margin-bottom: 10vh;
  width: 80%;
  min-height: 40vh;
}

.Info0 {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: space-evenly;
  background-color: #1e1e1e;
  border-radius: 15px;
  padding: 20px;
  margin-top: 3vh;
  margin-bottom: 3vh;
  width: 95%;
  min-height: 70%;
  color: #ccc;
}

.download {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: rgba(0, 0, 0, 0.7);
  border-radius: 15px;
  margin-top: 0vh;
  margin-bottom: 10vh;
  width: 80%;
  min-height: 40vh;
}

.homework {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  justify-content: center;
  gap: 20px;
  background-color: #2b2b2b;
  border-radius: 15px;
  padding: 20px;
  margin-top: 3vh;
  margin-bottom: 3vh;
  width: 95%;
  min-height: 70%;
}

.teamwork-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.teamwork {
  display: flex;
  justify-content: center;
  align-items: center;
  list-style: none;
  font-size: 3vh;
  height: 125px;  
  width: 125px;   
  background-color: #00e5ff;
  border-radius: 50%;
  color: white;
  transition: all 0.3s ease-in-out;
}

.teamwork:hover {
  transform: scale(1.25);  
}

.team-container {
  text-align: center;
}

.members {
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
  margin-top: 20px;
}

.member-btns {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  width: 100%;
}

.member-btns a {
  text-decoration: none;
}

.member-btns li {
  display: flex;
  justify-content: center;
  align-items: center;
  list-style: none;
  font-size: 3vh;
  background-color: #00e5ff;
  border-radius: 10px;
  padding: 10px;
  transition: all 0.3s ease-in-out;
}

.member-btns li:hover {
  transform: scale(1.2);
}

.webInfo1, .webInfo2, .webInfo3, .webInfo4 {
  display: flex;
  margin-top: 10vh;
  margin-bottom: 10vh;
  width: 100%;
  justify-content: center;
}

/* 修改成员信息容器样式 */
.members-container {
  display: flex;
  justify-content: center; /* 水平居中 */
  flex-wrap: wrap; /* 允许内容换行 */
  gap: 30px; /* 设置容器内元素之间的统一间隔 */
  width: 90%; /* 容器宽度扩大 */
  margin: 0 auto; /* 水平居中 */
  padding: 20px; /* 添加内边距，增加动态展示空间 */
  box-sizing: border-box;
  transition: all 0.3s ease; /* 添加动态效果 */
}

/* 单个成员卡片样式 */
.members-container .card {
  flex: 0 1 900px; /* 卡片宽度自适应，最大宽度450px */
  height: 400px; /* 调整高度 */
  margin: 10px; /* 增加卡片之间的间隔 */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* 添加阴影，增强视觉效果 */
  border-radius: 10px; /* 卡片圆角 */
  transition: transform 0.3s ease, box-shadow 0.3s ease; /* 添加动态效果 */
}

/* 卡片悬停效果 */
.members-container .card:hover {
  transform: translateY(-10px); /* 悬浮时卡片上移 */
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3); /* 悬浮时阴影变大 */
}

</style>