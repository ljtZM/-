<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class UserController extends Controller
{
    // 用户注册
    public function actionRegister()
    {
        $model = new User();
        $model->username = Yii::$app->request->post('username');
        $model->email = Yii::$app->request->post('email');
        $model->password = Yii::$app->request->post('password');

        if (!$model->validate()) {
            throw new BadRequestHttpException('Validation failed');
        }

        // 设置密码并保存
        $model->setPassword($model->password);
        $model->auth_key = Yii::$app->security->generateRandomString();

        if ($model->save()) {
            return ['status' => 'success', 'message' => 'User created successfully'];
        }

        return ['status' => 'error', 'message' => 'User registration failed'];
    }

    // 用户登录
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);
        if (!$user || !$user->validatePassword($password)) {
            throw new BadRequestHttpException('Invalid username or password');
        }

        // 生成 token 或 auth_key 以供前端使用
        return [
            'status' => 'success',
            'auth_key' => $user->auth_key,
            'id' => $user->id
        ];
    }
}