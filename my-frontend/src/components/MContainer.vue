<template>
  <div class="card" :class="{ active: isActive }">
    <!-- 用户信息区域 -->
    <div class="user" @click="toggle">
      <div class="imgBx">
        <!-- 使用 require 动态解析图片路径 -->
        <img :src="getImagePath" alt="Avatar" />
      </div>
      <!-- 文本信息 -->
      <div class="content">
        <p>姓名：{{ fullname }}</p>
        <p>学号：{{ studentId }}</p>
        <p>任务：{{ task }}</p>
      </div>
    </div>

    <!-- 联系方式展示区域 -->
    <ul class="contact">
      <li :style="{ '--delay': '0.2s' }">
        <a :href="`mailto:${email}`">
          <div class="iconBx"><i class="fa-solid fa-envelope"></i></div>
          <p>{{ email }}</p>
        </a>
      </li>
      <li :style="{ '--delay': '0.4s' }">
        <a :href="github" target="_blank">
          <div class="iconBx"><i class="fa-brands fa-github"></i></div>
          <p>{{ github }}</p>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "MContainer",
  props: {
    fullname: String,       // 姓名
    studentId: String,      // 学号
    task: String,           // 任务
    email: String,          // 邮箱
    github: String,         // GitHub 链接
    imageSrc: String        // 头像路径
  },
  data() {
    return {
      isActive: false // 控制卡片展开/收回
    };
  },
  computed: {
    getImagePath() {
      // 解析路径，指向 src/assets/pic 下的图片
      try {
        return require(`@/assets/pic/${this.imageSrc}`);
      } catch (error) {
        console.error("图片加载失败：", error);
        return ""; // 如果路径错误，返回空字符串
      }
    }
  },
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    }
  }
};
</script>
<style scoped>
/* 全局样式重置 */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.card {
  width: 800px; /* 卡片宽度 */
  background: linear-gradient(135deg, #0bd3d3, #82eaff); /* 初音未来配色 */
  border-radius: 15px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  transition: height 0.5s ease;
  height: 160px; /* 默认紧凑高度 */
  cursor: pointer;
}

.card.active {
  height: 400px; /* 展开时的高度 */
}

/* 用户信息区域 */
.user {
  display: flex;
  align-items: center;
  padding: 20px;
}

.imgBx {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 4px solid #a0f2f2; /* 浅色边框 */
  overflow: hidden;
  flex-shrink: 0;
}

.imgBx img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.content {
  margin-left: 20px;
  color: #fff;
  font-size: 1.1rem;
  line-height: 1.8rem;
  font-family: Arial, sans-serif;
}

/* 联系方式展示区域 */
.contact {
  display: flex;
  flex-direction: column;
  gap: 15px;
  padding: 10px 20px;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.card.active .contact {
  opacity: 1;
  transform: translateY(0);
}

.contact li {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 10px;
  padding: 10px 15px;
  list-style: none;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease, transform 0.5s ease;
  transition-delay: var(--delay); /* 停顿感 */
}

.card.active .contact li {
  opacity: 1;
  transform: translateY(0);
}

.contact li a {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #333;
  text-decoration: none;
}

.iconBx {
  width: 40px;
  height: 40px;
  background-color: #00d3d3;
  color: #fff;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.contact li p {
  font-size: 1rem;
}
</style>
