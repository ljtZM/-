<?php
/**
 * Team:从容应“队”，NKU
 * coding by 李嘉桐 2212023
 */
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArticleLikes;

/**
 * ArticleLikesSearch represents the model behind the search form of `app\models\ArticleLikes`.
 */
class ArticleLikesSearch extends ArticleLikes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'article_id', 'likes'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleLikes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'article_id' => $this->article_id,
            'likes' => $this->likes,
        ]);

        return $dataProvider;
    }
}
