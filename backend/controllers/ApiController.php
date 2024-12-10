<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Users;
use app\models\Article;
use app\models\ArticleComments;
use app\models\ArticleLikes;
use app\models\Webviews;

class ApiController extends Controller
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
    
    // 用于登录的API
    public function actionAuthenticate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $username = \Yii::$app->request->get('username');
        $password = \Yii::$app->request->get('password');

        if ($username !== null && $password !== null) {
            // 根据用户名查找用户
            $user = Users::find()
                ->where(['username' => $username])
                ->one();

            if ($user !== null && \Yii::$app->security->validatePassword($password, $user->password_hash)) {
                // 密码验证通过
                return ['status' => 1, 'message' => '登录成功'];
            } else {
                // 用户名或密码不匹配
                return ['status' => 0, 'message' => '用户名或密码错误'];
            }
        }

        return ['status' => -1, 'message' => '参数缺失'];
    }

    // 用于注册的API
    public function actionRegister()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $username = \Yii::$app->request->get('username');
        $password = \Yii::$app->request->get('password');
        $email = \Yii::$app->request->get('email');


        if ($username && $password && $email) {
            // 检查用户名是否已存在
            $existingUser = Users::find()
            ->where(['username' => $username])
            ->one();

            if ($existingUser !== null) {
            return ['status' => 0, 'message' => '用户名已被注册'];
            }

            // 检查邮箱是否已存在
            $existingEmail = Users::find()
            ->where(['email' => $email])
            ->one();

            if ($existingEmail !== null) {
            return ['status' => 0, 'message' => '邮箱已被注册'];
            }

            // 创建新用户
            $user = new Users();
            $user->username = $username;
            $user->email = $email;
            $user->role = 'user'; // 默认角色是用户，可以根据需求调整
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = $user->created_at;

            // 密码进行哈希处理
            $user->password_hash = \Yii::$app->security->generatePasswordHash($password);

            if ($user->save()) {
                return ['status' => 1, 'message' => '注册成功'];
            } else {
                return ['status' => -1, 'message' => '注册失败，系统错误'];
            }
        }
        else{
            return ['status' => -1, 'message' => '缺少必要参数'];
        }
    }

    //获取文章总页数
    public function actionGetarticlepagecount()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $count = Article::find()->count();
        $pagecount = intval($count / 15);

        if ($count % 15 !== 0) {
            $pagecount += 1;
        }
        $pagecount=json_encode($pagecount);
        return $pagecount;
    }
    
    public function actionGetarticle()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // 获取页数
        $page = \Yii::$app->request->get('page');
        $intpage = (int)$page;
        $id = \Yii::$app->request->get('id');

        if ($id !== null) {
            // 查询单篇文章
            $article = Article::find()->select(['id', 'title', 'summary', 'content', 'author', 'publication_date', 'created_at', 'updated_at'])
                ->where(['id' => $id])
                ->one();

            // 如果找到该文章，则返回
            if ($article !== null) {
                return $article;
            } else {
                // 如果找不到文章，返回错误消息
                return ['error' => 'Article not found'];
            }
        } else {
            // 查询分页文章列表
            $articles = Article::find()->select(['id', 'title', 'summary', 'content', 'author', 'publication_date', 'created_at', 'updated_at'])
                ->offset(15 * ($intpage - 1))  // 偏移量，根据页数
                ->limit(15)  // 每页显示 15 篇文章
                ->all();

            // 如果没有文章返回空数组
            if (empty($articles)) {
                return [];
            }

            // 返回文章列表
            return $articles;
        }
    }

    
    //获取文章评论
    public function actionGetarticlecomment()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $articleID = \Yii::$app->request->get('article_id');
        $username = \Yii::$app->request->get('username');
        
        if ($username !== null) {
            // 查询指定用户名的评论
            $comments = ArticleComments::find()
                ->select(['id', 'article_id', 'comment', 'comment_date', 'username'])
                ->where(['username' => $username])
                ->all();
        } elseif ($articleID !== null) {
            // 查询指定文章 ID 的评论
            $comments = ArticleComments::find()
                ->select(['id', 'article_id', 'comment', 'comment_date', 'username'])
                ->where(['article_id' => $articleID])
                ->all();
        } else {
            // 查询所有评论
            $comments = ArticleComments::find()
                ->select(['id', 'article_id', 'comment', 'comment_date', 'username'])
                ->all();
        }

        return $comments;
    }

    //添加文章评论
    public function actionAddarticlecomment()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $username = \Yii::$app->request->get('username');
        $comment = \Yii::$app->request->get('comment');
        $articleID = \Yii::$app->request->get('article_id');

        $commentModel = new ArticleComments();
        $commentModel->username = $username;
        $commentModel->comment = $comment;
        $commentModel->article_id = $articleID;

        if ($commentModel->save()) {
            return ['status' => 1, 'message' => 'Comment added successfully'];
        } else {
            return ['status' => -1, 'message' => 'Failed to add comment'];
        }
    }

    //获取文章点赞数
    public function actionGetarticlelikes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $articleID = \Yii::$app->request->get('article_id');
        
        $likes = ArticleLikes::find()
            ->where(['article_id' => $articleID])
            ->one();
        
        if ($likes === null) {
            // 如果没有找到点赞记录，则创建一条
            $likes = new ArticleLikes();
            $likes->article_id = $articleID;
            $likes->likes = 0;
            $likes->save();
        }

        return $likes->likes;
    }

    //增加文章点赞数
    public function actionAddarticlelikes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $articleID = \Yii::$app->request->get('article_id');
        $num = \Yii::$app->request->get('num');
        
        $likes = ArticleLikes::find()
            ->where(['article_id' => $articleID])
            ->one();
        
        if ($likes === null) {
            // 如果没有找到点赞记录，则创建一条
            $likes = new ArticleLikes();
            $likes->article_id = $articleID;
            $likes->likes = 0;
            $likes->save();
        }

        // 增加点赞数
        $likes->likes += $num;
        if ($likes->save()) {
            return ['status' => 1, 'message' => 'Likes updated successfully'];
        } else {
            return ['status' => -1, 'message' => 'Failed to update likes'];
        }
    }


}
