<?php

use app\models\Webviews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Webviews $searchModel *///修改
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Webviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webviews-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Webviews', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'views',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Webviews $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'views' => $model->views]);
                 }
            ],
        ],
    ]); ?>


</div>
