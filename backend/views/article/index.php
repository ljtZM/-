<?php

use app\models\Article; // 使用 Article 模型而不是 Articles
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index"> <!-- 注意类名与模型名称一致 -->

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Articles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // 序号列

            'id', // 使用数据库字段名 id
            'title', // 使用数据库字段名 title
            'content:ntext', // 使用数据库字段名 content
            'publication_date', // 使用数据库字段名 publication_date

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Article $model, $key, $index, $column) {
                    // 使用数据库字段作为 URL 路由参数
                    return Url::toRoute([$action, 'id' => $model->id]); // 使用主键 id
                }
            ],
        ],
    ]); ?>

</div>
