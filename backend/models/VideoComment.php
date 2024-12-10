<?php

namespace app\models;

use yii\db\ActiveRecord;

class VideoComment extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'videocomments';
    }

    /**
     * 定义与视频的关系
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::class, ['id' => 'video_id']);
    }
}
