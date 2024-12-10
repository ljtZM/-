<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User[] $users */

$this->title = '所有用户';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建新用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>电子邮件</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= Html::encode($user->id) ?></td>
                    <td><?= Html::encode($user->username) ?></td>
                    <td><?= Html::encode($user->email) ?></td>
                    <td><?= Html::encode($user->created_at) ?></td>
                    <td>
                        <?= Html::a('查看', ['view', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('编辑', ['update', 'id' => $user->id], ['class' => 'btn btn-warning']) ?>
                        <?= Html::a('删除', ['delete', 'id' => $user->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '您确定要删除这个用户吗?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
