<?php
/**
 * Team:从容应“队”，NKU
 * coding by 高艺轩 2211820
 * 视频点赞模型
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "video_likes".
 *
 * @property int $id
 * @property int $videoid
 * @property int $likes
 *
 * @property Videos $video
 */
class VideoLikes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id'], 'required'],
            [['video_id', 'likes'], 'integer'],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Videos::class, 'targetAttribute' => ['video_id' => 'id']],
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
            'likes' => 'Likes',
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
}