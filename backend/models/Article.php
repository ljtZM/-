<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string $author
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ArticleLikes[] $articleLikes
 * @property Articlecomments[] $articlecomments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'author'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'author'], 'string', 'max' => 255],
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
            'content' => 'Content',
            'author' => 'Author',
            'summary' => 'Summary',
            'publication_date' => 'Publication_Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ArticleLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleLikes()
    {
        return $this->hasMany(ArticleLikes::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Articlecomments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlecomments()
    {
        return $this->hasMany(Articlecomments::class, ['article_id' => 'id']);
    }
}
