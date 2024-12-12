<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VideoLikes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="video-likes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'video_id')->textInput() ?>

    <?= $form->field($model, 'likes')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
