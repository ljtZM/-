<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "articlecomments".
 *
 * @property int $id
 * @property int $article_id
 * @property string $comment
 * @property string $comment_date
 * @property string $username
 *
 * @property Article $article
 */
class ArticleComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articlecomments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'comment', 'username'], 'required'],
            [['article_id'], 'integer'],
            [['comment'], 'string'],
            [['comment_date'], 'safe'],
            [['username'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
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
            'article_id' => 'Article ID',
            'comment' => 'Comment',
            'comment_date' => 'Comment Date',
            'username' => 'Username',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
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
