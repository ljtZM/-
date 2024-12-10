<?php

namespace app\controllers;

use Yii;
use app\models\Video;
use app\models\VideoComment; // 使用您定义的 VideoComment 模型
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class VideoCommentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-comments' => ['GET'],
                    'add-comment' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Get comments for a specific video.
     *
     * @param int $id Video ID
     * @return Response
     * @throws NotFoundHttpException if the video cannot be found
     */
    public function getVideoComments($id)
    {
        return "video comments";
    }

    /**
     * Add a new comment to a video.
     *
     * @return Response
     */
    public function addVideoComments()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        // 验证请求数据
        $data = $request->post();
        if (empty($data['video_id']) || empty($data['comment']) || empty($data['username'])) {
            return ['error' => 'Invalid data'];
        }

        // 创建新评论
        $comment = new VideoComment();
        $comment->video_id = $data['video_id'];
        $comment->comment = $data['comment'];
        $comment->username = $data['username'];
        $comment->comment_date = date('Y-m-d H:i:s'); // 设置当前时间

        if ($comment->save()) {
            return ['success' => 'Comment added successfully'];
        } else {
            return ['error' => 'Failed to save comment'];
        }
    }
}
