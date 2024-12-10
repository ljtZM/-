<?php

namespace app\models;

use yii\db\ActiveRecord;

class Video extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * 定义与评论的关系
     * @return \yii\db\ActiveQuery
     */
    public function getVideoComments()
    {
        return $this->hasMany(VideoComment::class, ['video_id' => 'id']);
    }
}
