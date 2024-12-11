<?php
namespace app\controllers;

use Yii;
use app\models\Article;
use yii\web\Controller;

class ArticleController extends Controller
{
    public function actionAddwebviews()
    {
        //设置响应格式为 JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $webviews = Webviews::find()->one();
        if (!$webviews) {
            return ['status' => -1, 'message' => '无法找到浏览量记录'];
        }
        $webviews->views = $webviews->views + 1;

        if ($webviews->save()) {
            return ['status' => 1, 'message' => '浏览量增加成功'];
        } else {
            return ['status' => -1, 'message' => '浏览量增加失败'];
        }
    }

    //查询网站浏览量的api接口
    public function actionCheckwebviews()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $webviews = Webviews::find()->one();

        return $webviews;
    }
}