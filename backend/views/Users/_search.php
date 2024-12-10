<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '搜索用户';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-search">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['placeholder' => '请输入用户名']) ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => '请输入电子邮件']) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
