<?php
namespace app\controllers;

use Yii;
use app\models\Article;
use yii\web\Controller;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $articles = Article::find()->all();
        return $this->asJson($articles);
    }

    public function actionCreate()
    {
        $model = new Article();
        $model->title = Yii::$app->request->post('title');
        $model->content = Yii::$app->request->post('content');
        
        if ($model->save()) {
            return ['status' => 'success', 'message' => 'Article created successfully'];
        }
        return ['status' => 'error', 'message' => 'Article creation failed'];
    }
}