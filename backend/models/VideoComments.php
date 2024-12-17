<?php
/**
 * Team:从容应“队”，NKU
 * coding by 高艺轩 2211820
 * 视频评论模型
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "videocomments".
 *
 * @property int $id
 * @property int $video_id
 * @property string $comment
 * @property string $comment_date
 * @property string $username
 *
 * @property Videos $video
 */
class VideoComments extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'videocomments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'comment', 'username'], 'required'],
            [['video_id'], 'integer'],
            [['comment'], 'string'],
            [['comment_date'], 'safe'],
            [['username'], 'string', 'max' => 255],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Videos::class, 'targetAttribute' => ['video_id' => 'id']],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['username' => 'Username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'comment' => 'Comment',
            'comment_date' => 'Comment Date',
            'username' => 'Username',
        ];
    }

    /**
     * Gets query for [[Video]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Videos::class, ['id' => 'video_id']);
    }

    /**
     * Gets query for [[Username]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
        return $this->hasOne(Users::class, ['username' => 'username']);
    }
}