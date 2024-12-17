<script> 
import MContainer from '../components/MContainer.vue'
import axios from 'axios'
export default {
  data() {
    return {
      views: 0,
      Info: "",
      members: [], // Store member data
      websiteDescription: "",
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
    this.checkviews();
    this.fetchMembers(); // Fetch members data on component mount
    this.fetchWebsiteDescription(); // Fetch the description when the component is mounted
  },
  methods: {
    goToAdminLogin() {
      this.$router.push('/admin');  // 跳转到管理员登录页
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
    checkviews() {
      axios.post('http://localhost:8080/api/checkwebviews')
        .then((response) => {
          this.views = response.data.views
        })
        .catch((error) => {
          console.error('请求失败', error)
        })
    },
    fetchMembers() {
      // Fetch members information from the backend API
      axios.get('http://localhost:8080/api/getmembers') // Adjust API endpoint
        .then(response => {
          this.members = response.data; // Assuming the response is an array of members
        })
        .catch(error => {
          console.error('成员信息获取失败:', error);
        });
    },
    scrollToSection(section) {
      const element = document.getElementById(section)
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' })
      }
    },
    fetchWebsiteDescription() {
      axios.get('http://localhost:8080/api/getdescription') // 调整为实际的API端点
        .then(response => {
          if (response.data.description) {
            this.websiteDescription = response.data.description;
          } else {
            console.error('Website description not found');
          }
        })
        .catch(error => {
          console.error('请求失败:', error);
        });
    }
  }
}
</script>

<template>
  <div class="aboutContainer">
    <!-- 上方导航栏 -->
    <div class="navbar">
      <div class="logo">
        <span class="logo-text">团队主页</span>
        <span class="separator"></span>
      </div>
      <el-menu :default-active="active" class="menu" mode="horizontal">
        <el-menu-item index="home" @click="goToHomePage">首页</el-menu-item>
        <el-menu-item index="aboutUs" @click="goToAboutUsPage">关于我们</el-menu-item>
        <el-menu-item index="projectIntro" @click="goToProjectIntroPage">项目介绍</el-menu-item>
        <el-menu-item index="profile" @click="goToProfilePage">个人</el-menu-item>
        <el-menu-item index="adminlogin" @click="goToAdminLogin">管理员登录</el-menu-item>
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
      <p>{{ websiteDescription }}</p>
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
      <!-- 动态加载成员 -->
      <MContainer
        v-for="(member, index) in members" 
        :key="index"
        :fullname="member.name"
        :studentId="member.student_id"
        :task="member.bio"
        :email="member.email"   
        :github="member.github"
        :imageSrc="member.imageSrc" 
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
  background: linear-gradient(135deg, #8b9dc3, #3b5998);
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
.breadcrumb {
  display: flex;
  gap: 30px;
  margin-top: 20px;
  margin-bottom: 30px;
}

.breadcrumb button {
  
  background: linear-gradient(45deg, #00e5ff, #00e5ff);
  /*background: linear-gradient(45deg, #00e5ff, #008c9e);*/
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