<?php

namespace app\controllers;

use app\models\Webviews;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WebviewsController extends Controller
{
    /**
     * 增加浏览量
     * @return \yii\web\Response
     */
    public function actionAddWebviews()
    {
        $model = Webviews::findOne(1); // 假设只操作一个记录（如首页）

        if ($model) {
            $model->views += 1;  // 增加浏览量
            if ($model->save()) {
                return $this->asJson([
                    'status' => 1,
                    'message' => '浏览量增加成功',
                ]);
            }
        }

        return $this->asJson([
            'status' => 0,
            'message' => '操作失败',
        ]);
    }

    /**
     * 检查浏览量
     * @return \yii\web\Response
     */
    public function actionCheckWebviews()
    {
        $model = Webviews::findOne(1); // 假设检查一个固定的记录

        if ($model) {
            return $this->asJson([
                'status' => 1,
                'message' => '成功获取浏览量',
                'data' => ['views' => $model->views],
            ]);
        }

        return $this->asJson([
            'status' => 0,
            'message' => '未找到数据',
        ]);
    }
}