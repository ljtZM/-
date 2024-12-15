<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string|null $bio
 * @property string|null $image_url
 * @property string $created_at
 * @property string $student_id
 * @property string $email
 * @property string $github
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'position', 'student_id', 'email', 'github'], 'required'],
            [['bio'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'position', 'image_url', 'email', 'github'], 'string', 'max' => 255],
            [['student_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'position' => 'Position',
            'bio' => 'Bio',
            'image_url' => 'Image Url',
            'created_at' => 'Created At',
            'student_id' => 'Student ID',
            'email' => 'Email',
            'github' => 'Github',
        ];
    }
}
