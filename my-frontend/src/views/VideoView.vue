<template>
  <div class="container">
    <!-- 上方导航栏 -->
    <div class="navbar">
      <div class="logo">
        <span class="logo-text">视频专区</span>
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

    <!-- 主要内容区域 -->
    <main class="main-content">
      <!-- 图片展示切换 -->
      <div class="swiper-container">
        <swiper
          ref="swiperRef"  
          :modules="modules"
          :slides-per-view="1"
          :space-between="50"
          navigation
          :pagination="{ clickable: true }"
          :scrollbar="{ draggable: true }"
          @swiper="onSwiper"
          @slideChange="onSlideChange"
        >
          <swiper-slide v-for="image in images" :key="image">
            <img :src="image.src" :alt="image.alt" class="swiper-image" @click="goToVideo(image.videoId)">
          </swiper-slide>
        </swiper>
      </div>

      <!-- 文章区域 -->
      <div class="article">
        <h2>人工智能的最新进展</h2>
        <p>欢迎来到我们的人工智能视频资源中心！在这里，您将发现人工智能如何模拟和扩展人类智能的边界。通过深入浅出的讲解，我们将带您了解AI的基本原理、核心技术及其带来的创新应用，无论您是初学者还是技术达人，都能从中受益良多。</p>
        <p>人工智能正在重新定义各个行业的未来。从增强医疗诊断能力到优化金融风险管理，再到赋能智能家庭助手，AI的影响力无处不在。加入我们，探索AI驱动下的未来世界，感受科技赋能生活的无尽魅力。</p>
      </div>

      <!-- 视频封面展示 -->
      <div class="video-grid">
        <div v-for="video in videos" :key="video.id" class="video-item" @click="goToVideo(video.id)">
          <img :src="video.thumbnail" :alt="video.title" class="video-thumbnail">
          <h3>{{ video.title }}</h3>
        </div>
      </div>
    </main>

    <!-- 边栏 -->
    <aside :class="['sidebar', { 'sidebar-collapsed': isSidebarCollapsed }]">
      <div class="sidebar-toggle" @click="toggleSidebar">
        <span v-if="isSidebarCollapsed">展开</span>
        <span v-else>收起</span>
      </div>
      <h2>热门视频</h2>
      <ul>
        <li v-for="video in popularVideos" :key="video.id" @click="goToVideo(video.id)">
          <img :src="video.thumbnail" :alt="video.title" class="sidebar-thumbnail">
          <span>{{ video.title }}</span>
        </li>
      </ul>
    </aside>

    <!-- 底部 -->
    <footer class="footer">
      <p>&copy; 2024 人工智能新闻与视频</p>
    </footer>
  </div>
</template>

<script>
  // import Swiper core and required modules
  import { Navigation, Pagination, Scrollbar, A11y } from 'swiper';

  // Import Swiper Vue.js components
  import { Swiper, SwiperSlide } from 'swiper/vue';

  // Import Swiper styles
  import 'swiper/css';
  import 'swiper/css/navigation';
  import 'swiper/css/pagination';
  import 'swiper/css/scrollbar';

  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';

  export default {
    components: {
      Swiper,
      SwiperSlide,
    },
    setup() {
      const router = useRouter();  // 获取 router 实例
      const swiperRef = ref(null);
      const isSidebarCollapsed = ref(false);

      const images = [
        { src: require('@/assets/images/img1.jpg'), alt: 'Image 1', videoId: 1 },
        { src: require('@/assets/images/img2.jpg'), alt: 'Image 2', videoId: 2 },
        { src: require('@/assets/images/img3.jpg'), alt: 'Image 3', videoId: 3 },
        { src: require('@/assets/images/img4.jpg'), alt: 'Image 4', videoId: 4 },
        { src: require('@/assets/images/img5.jpg'), alt: 'Image 5', videoId: 5 },
      ];

      const videos = [
        { id: 1, title: 'Exploring AI', thumbnail: require('@/assets/images/img1.jpg') },
        { id: 2, title: 'AI in Robotics', thumbnail: require('@/assets/images/img2.jpg') },
        { id: 3, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img3.jpg') },
        { id: 4, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img4.jpg') },
        { id: 5, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img5.jpg') },
        { id: 6, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img6.jpg') },
      ];

      const popularVideos = [
        { id: 1, title: 'Exploring AI', thumbnail: require('@/assets/images/img1.jpg') },
        { id: 2, title: 'AI in Robotics', thumbnail: require('@/assets/images/img2.jpg') },
        { id: 3, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img3.jpg') },
      ];

      const onSwiper = (swiper) => {
        console.log(swiper);
      };

      const onSlideChange = () => {
        console.log('slide change');
      };

      const goToVideo = (videoId) => {
        console.log('Navigating to VideoPlay with ID:', videoId);
        router.push({ name: 'VideoPlay', params: { id: videoId } });
      };

      const toggleSidebar = () => {
        isSidebarCollapsed.value = !isSidebarCollapsed.value;
      };

      // 页面跳转函数
      const goToHomePage = () => {
        router.push('/home');  // 跳转到首页
      };

      const goToAboutUsPage = () => {
        router.push('/aboutUs');  // 跳转到关于我们页面
      };

      const goToProjectIntroPage = () => {
        router.push('/projectIntro');  // 跳转到项目介绍页面
      };

      const goToAdminLogin = () => {
        router.push('/admin');  // 跳转到管理员登录页面
      };

      const goToProfilePage = () => {
        const username = sessionStorage.getItem('Username');
        if (!username) {
          router.push('/'); // 未登录，跳转到登录页面
        } else {
          router.push('/profile'); // 已登录，跳转到个人页面
        }
      };

      // Swiper 初始化后更新尺寸，避免 ResizeObserver 循环
      onMounted(() => {
        if (swiperRef.value && swiperRef.value.swiper) {
          swiperRef.value.swiper.update();  // 手动更新 Swiper
        }
      });

      return {
        onSwiper,
        onSlideChange,
        modules: [Navigation, Pagination, Scrollbar, A11y],
        images,
        videos,
        popularVideos,
        goToVideo,
        isSidebarCollapsed,
        toggleSidebar,
        swiperRef,
        goToHomePage,
        goToAboutUsPage,
        goToProjectIntroPage,
        goToAdminLogin,
        goToProfilePage,
      };
    },
  };
</script>

<style scoped>
/* Import the external CSS file */
@import '../assets/css/gallery.css';
@import '../assets/css/video.css';


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
</style> 
