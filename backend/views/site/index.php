<?php
/**
 * Team:从容应“队”，NKU
 * coding by 李嘉桐 2212023
 * 将site/index.php作为后台主页面，并修改页面样式
 */
$this->title = 'Yii2后端';
?>
<div class="site-index">
    <div class="back-button-container">
      <button @click="goBack" class="back-button">回到主页</button>
    </div>
    <div class="jumbotron text-center">
        <h1 class="display-4">欢迎管理员！</h1>

        <div class="btn-container">
            <div class="row">
                <div class="col-md-4">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['article/index']) ?>" class="btn btn-primary rounded-circle">管理文章专区</a>
                </div>
                <div class="col-md-4">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['Users/index']) ?>" class="btn btn-primary rounded-circle">管理用户</a>
                </div>
                <div class="col-md-4">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['videos/index']) ?>" class="btn btn-primary rounded-circle">管理视频专区</a>
                </div>
                <div class="col-md-4">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['team/index']) ?>" class="btn btn-primary rounded-circle">管理团队成员</a>
                </div>
                <div class="col-md-4">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['website/index']) ?>" class="btn btn-primary rounded-circle">网页信息</a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <a href="<?= \Yii::$app->urlManager->createUrl(['articlecomments/index']) ?>" class="btn btn-primary rounded-circle">管理文章评论</a>
                </div>
                <div class="col-md-3">
                     <a href="<?= \Yii::$app->urlManager->createUrl(['articlelikes/index']) ?>" class="btn btn-primary rounded-circle">管理文章点赞</a>
                </div>
                
            </div>
        </div>
    </div>

</div>

<script>
export default {
  methods: {
     // 返回按钮点击事件
     goBack() {
        this.$router.push({ name: 'Home' });
      },
  },
};
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

.site-index {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ffffff;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    padding: 0;
    box-sizing: border-box;
}

.jumbotron {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    width: 80%;
    max-width: 1000px;
    padding: 60px;
    transition: transform 0.3s ease-in-out;
    margin: auto;
    text-align: center;
}

.btn-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%; /* 确保 btn-container 占据整个 jumbotron 的宽度 */
}

.row {
    width: 100%;
    display: flex;
    justify-content: center; /* 确保行内的内容居中 */
    flex-wrap: wrap;
}

.col-md-4,
.col-md-3 {
    display: flex;
    justify-content: center; /* 确保每列的内容居中 */
    align-items: center;
    flex: 0 0 auto; /* 禁止列伸缩 */
}

.btn-group .btn,
.col-md-4 > a,
.col-md-3 > a {
    margin: 5px;
    border-radius: 50%;
    transition: background-color 0.3s, transform 0.3s;
    width: 180px;
    height: 175px;
    font-size: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #a3c4f3;
    border-color: #a3c4f3;
}

.display-4 {
    color: #5c8dd9; /* 调整标题颜色为更浅的蓝色 */
    font-size: 3rem;
    margin-bottom: 1rem;
}

/* 返回按钮样式 */
.back-button-container {
  position: absolute;
  top: 60px;
  left: 20px;
}

.back-button {
  padding: 10px 20px;
  font-size: 18px;
  background: linear-gradient(145deg, #409EFF, #66b3ff); /* 渐变背景色 */
  color: white;
  border: none;
  border-radius: 25px;  /* 增加圆角 */
  cursor: pointer;
  transition: transform 0.2s ease, background-color 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  /* 阴影效果 */
}

.back-button:hover {
  background-color: #66b3ff;
  transform: scale(1.05);  /* 鼠标悬停时按钮放大 */
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);  /* 鼠标悬停时增加阴影 */
}

.back-button:focus {
  outline: none; /* 去除点击后的默认边框 */
  box-shadow: 0 0 0 4px rgba(64, 158, 255, 0.3);  /* 点击时显示聚焦效果 */
}
</style>