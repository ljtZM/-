<template>
  <div class="project-intro" :style="{ backgroundImage: 'url(' + backgroundImage + ')' }">
    <div class ="bordered-text">
    <div class="header">
      <h1>人工智能的最新进展</h1>
      <p>探索前沿动态，了解人工智能领域的最新创新与突破</p>
    </div>

    <div class="content">
      <div class="section">
        <h2>项目背景</h2>
        <p>
          本项目旨在为大家提供一个了解人工智能领域的窗口，通过文章与视频，分享人工智能的最新研究成果与应用案例。
          我们设计的网页旨在帮助大家从不同角度探索人工智能技术的前沿，打破技术壁垒，让更多人了解这个快速发展的领域。
        </p>
      </div>

      <div class="section">
        <h2>项目功能</h2>
        <p>
          1. 文章专区：提供多篇关于人工智能的深度分析文章，涵盖AI技术、机器学习、深度学习、数据科学等领域的最新进展。
        </p>
        <p>
          2. 视频专区：精选一些人工智能领域的精彩讲座、课程以及技术分享，帮助您快速掌握前沿动态。
        </p>
      </div>

      <div class="section">
        <h2>网址目标</h2>
        <p>
          我们的目标是让所有人都能快速接触并理解人工智能，不论是技术爱好者、科研人员，还是普通大众。
          通过这个平台，我们希望激发更多人的兴趣，推动人工智能技术的普及与发展。
        </p>
      </div>
      
      <div class="section1">
        <p>
          网站已经被访问了 {{ views }} 次，感谢您的宣传！
        </p>
      </div>
     </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'ProjectIntro',
  data() {
    return {
      backgroundImage: require('@/assets/images/7.png'), // 使用 require 动态引入背景图片
      views: 0 // 初始化 views 变量
    };
  }, // 在 data() 和 methods 之间加上逗号
  mounted() {
    this.checkviews()// 在组件挂载后发起 API 请求
  },
  methods: {
    checkviews() {
      axios.post('http://localhost:8080/api/checkwebviews')
        .then((response) => {
          this.views = response.data.views; //将获取到的数据存储到views
        })
        .catch((error) => {
          console.error('请求失败', error);
        });
    }
  }
}
</script>


<style scoped>
.project-intro {
  font-family: 'Arial', sans-serif;
  color: #ffffff;
  background-size: cover; /* 背景图片覆盖整个容器 */
  background-position: center; /* 背景居中显示 */
  padding: 20px;
  min-height: 100vh; /* 确保背景图覆盖整个页面 */
}

.bordered-text {
  border: 2px solid #00bfae; /* 设置边框颜色和宽度 */
  border-radius: 15px; /* 设置圆角 */
  padding: 30px; /* 添加内边距 */
  margin: 5px auto 0 auto; /* 上边距设置为40px，下边距自动居中 */
  max-width: 1200px; /* 设置最大宽度，避免内容过宽 */
  background-color: rgba(0, 0, 0, 0.6); /* 半透明背景，提升可读性 */
}

.header {
  text-align: center;
  margin-bottom: 30px;
}

.header h1 {
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #00bfae;
}

.header p {
  font-size: 18px;
  margin: 0;
  color: #bbbbbb;
}

.content {
  margin: 0 auto;
  max-width: 900px;
}

.section {
  margin-bottom: 40px;
}

.section1 {
  text-align: center;
  margin-bottom: 40px;
  color:	#458B00;
  font-size: 22px;
}

.section h2 {
  font-size: 26px;
  font-weight: bold;
  color: #00bfae;
  margin-bottom: 10px;
}

.section p {
  font-size: 19px;
  line-height: 1.6;
  color: #cccccc;
}

.section p strong {
  color: #ffffff;
}


@media (max-width: 768px) {
  .header h1 {
    font-size: 28px;
  }

  .header p {
    font-size: 16px;
  }

  .section h2 {
    font-size: 20px;
  }

  .section p {
    font-size: 14px;
  }
}
</style>