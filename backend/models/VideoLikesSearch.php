<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VideoLikes;

/**
 * VideolikesSearch represents the model behind the search form of `app\models\Videolikes`.
 */
class VideoLikesSearch extends VideoLikes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'video_id', 'likes'], 'integer'],
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
        $query = VideoLikes::find();

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
            'video_id' => $this->video_id,
            'likes' => $this->likes,
        ]);

        return $dataProvider;
    }
}