<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "videos".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property VideoLikes[] $VideoLikes
 * @property VideoComments[] $videocomments
 */
class Videos extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getVideoLikes()
    {
        return $this->hasMany(VideoLikes::class, ['video_id' => 'id']);
    }
    
    public function getVideoComments()
    {
        return $this->hasMany(VideoComments::class, ['video_id' => 'id']);
    }
    
}