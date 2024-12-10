<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = '用户详情: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>ID:</strong> <?= Html::encode($model->id) ?></p>
    <p><strong>用户名:</strong> <?= Html::encode($model->username) ?></p>
    <p><strong>电子邮件:</strong> <?= Html::encode($model->email) ?></p>
    <p><strong>角色:</strong> <?= Html::encode($model->role) ?></p>
    <p><strong>创建时间:</strong> <?= Html::encode($model->created_at) ?></p>
    <p><strong>更新时间:</strong> <?= Html::encode($model->updated_at) ?></p>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除这个用户吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
