<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ParserPrice]].
 *
 * @see ParserPrice
 */
class ParserPriceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ParserPrice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ParserPrice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
