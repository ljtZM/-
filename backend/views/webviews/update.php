<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Webviews $model */

$this->title = 'Update Webviews: ' . $model->views;
$this->params['breadcrumbs'][] = ['label' => 'Webviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->views, 'url' => ['view', 'views' => $model->views]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webviews-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
