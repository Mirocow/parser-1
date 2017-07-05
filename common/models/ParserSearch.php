<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Parser;

/**
 * ParserSearch represents the model behind the search form about `common\models\Parser`.
 */
class ParserSearch extends Parser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'available'], 'integer'],
            [['product_name', 'product_sku', 'site_name', 'error_code', 'error_text'], 'safe'],
            [['price', 'price_old'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Parser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'price_old' => $this->price_old,
            'available' => $this->available,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_sku', $this->product_sku])
            ->andFilterWhere(['like', 'site_name', $this->site_name])
            ->andFilterWhere(['like', 'error_code', $this->error_code])
            ->andFilterWhere(['like', 'error_text', $this->error_text]);

        return $dataProvider;
    }
}
