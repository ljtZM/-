<template>
  <div class="container">
    <!-- 头部标题 -->
    <header class="header">
      <h1>人工智能新闻与视频</h1>
      <p>探索人工智能的最新动态和应用</p>
    </header>

    <!-- 主要内容区域 -->
    <main class="main-content">
      <!-- 图片展示切换 -->
      <div class="swiper-container">
        <swiper
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

  import { ref } from 'vue';
  import { useRouter } from 'vue-router';

  export default {
    components: {
      Swiper,
      SwiperSlide,
    },
    setup() {
      const router = useRouter();
      const isSidebarCollapsed = ref(false);

      const images = [
        { src: require('@/assets/images/img1.jpg'), alt: 'Image 1', videoId: 1 },
        { src: require('@/assets/images/img2.jpg'), alt: 'Image 2', videoId: 2 },
        { src: require('@/assets/images/img3.jpg'), alt: 'Image 3', videoId: 3 },
        { src: require('@/assets/images/img4.jpg'), alt: 'Image 4', videoId: 4 },
        { src: require('@/assets/images/img5.jpg'), alt: 'Image 5', videoId: 5 },
        // Add more images as needed
      ];

      const videos = [
        { id: 1, title: 'Exploring AI', thumbnail: require('@/assets/images/img1.jpg') },
        { id: 2, title: 'AI in Robotics', thumbnail: require('@/assets/images/img2.jpg') },
        { id: 3, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img3.jpg') },
        { id: 4, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img4.jpg') },
        { id: 5, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img5.jpg') },
        { id: 6, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img6.jpg') },
        { id: 7, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img7.jpg') },
        // Add more videos as needed
      ];

      const popularVideos = [
        { id: 1, title: 'Exploring AI', thumbnail: require('@/assets/images/img1.jpg') },
        { id: 2, title: 'AI in Robotics', thumbnail: require('@/assets/images/img2.jpg') },
        { id: 3, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img3.jpg') },
        { id: 4, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img4.jpg') },
        { id: 5, title: 'AI in Healthcare', thumbnail: require('@/assets/images/img5.jpg') },
        // Add more popular videos as needed
      ];

      const onSwiper = (swiper) => {
        console.log(swiper);
      };
      const onSlideChange = () => {
        console.log('slide change');
      };

      const goToVideo = (videoId) => {
        router.push({ name: 'Video', params: { id: videoId } });
      };

      const toggleSidebar = () => {
        isSidebarCollapsed.value = !isSidebarCollapsed.value;
      };

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
      };
    },
  };
</script>

<style scoped>
/* Import the external CSS file */
@import '../assets/css/gallery.css';
</style>
