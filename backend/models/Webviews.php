<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * Webviews模型，负责浏览量的管理和查询
 *
 * @property int $views
 */
class Webviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['views'], 'required'],
            [['views'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'views' => '浏览量',
        ];
    }

    /**
     * WebviewsSearch 用于查询 Webviews 模型
     * 
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Webviews::find();

        // 加载查询参数
        $this->load($params);
        
        // 如果验证失败，直接返回不包含数据的 DataProvider
        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        // 过滤条件
        $query->andFilterWhere([
            'views' => $this->views,
        ]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * 增加浏览量
     * 
     * @return bool 是否保存成功
     */
    public function increaseViews()
    {
        // 增加浏览量
        $this->views += 1;
        return $this->save();
    }

    /**
     * 获取当前 Webviews 数据
     * 
     * @return Webviews|null
     */
    public static function getCurrent()
    {
        // 获取当前的唯一记录
        return self::findOne(1);
    }

    /**
     * 查找 Webviews 模型，根据 primaryKey 查找
     * 
     * @param int $views 浏览量
     * @return Webviews
     */
    protected function findModel($views)
    {
        if (($model = Webviews::findOne(['views' => $views])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}