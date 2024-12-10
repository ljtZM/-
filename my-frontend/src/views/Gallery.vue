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
          <p>人工智能正在改变我们的生活，从自动驾驶汽车到智能家居，AI的应用越来越广泛。本文将介绍人工智能的最新进展和未来趋势。</p>
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